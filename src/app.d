import std.stdio;
import std.conv;
import d2sqlite3;
import teach.cli.choice;
import teach.cli.text;

import teach.sql;

import teach.leergang;
import teach.contactmoment;

int main(string[] args) {
	if (args.length == 1) {
		writeln("Geef database mee als argument");
		return 1;
	}
	Database db = Database(args[1]);
	
	auto leergangen = db.execute("SELECT id, naam FROM leergang");
	if (leergangen.empty()) {
		writeln("Geen leergangen beschikbaar");
		return 1;
	}
	writeln("Hallo, de volgende leergangen zijn beschikbaar: ");
	Choice[] choicesLeergangen = mapResultRange(leergangen, "id", "naam");
	Choice choiceLeergang = choice("welke leergang wil je gebruiken? ", choicesLeergangen);
	
	Leergang leergang = new Leergang(choiceLeergang.label);
	
	auto leergangcontactmomentenStatement = db.prepare("SELECT id, naam FROM contactmoment WHERE leergang_id = ?");
	leergangcontactmomentenStatement.bind(1, choiceLeergang.id);
	auto leergangcontactmomenten = leergangcontactmomentenStatement.execute();
	
	Choice[] choicesContactmomenten = mapResultRange(leergangcontactmomenten, "id", "naam");
	choicesContactmomenten ~= Choice(null, "Nieuw aanmaken");
	Choice choiceContactmoment = choice("welke contactmoment wil je gebruiken? ", choicesContactmomenten);
	
	if (choiceContactmoment.id is null) {
		choiceContactmoment.label = askInput("Geef de naam voor nieuw contactmoment: ");
		auto contactmoment = dataContactmoment(choiceContactmoment.id, choiceContactmoment.label, choiceLeergang.id);
		choiceContactmoment.id = insertQuery(db, contactmoment.prepareInsert());
	}
	
	return 0;
}

private string insertQuery(Database db, prepared_query query) {
	auto statement = db.prepare(query.query);
	query.mapParameters(delegate void(int index, string value) {
		statement.bind(index, value);
		});
	statement.execute();
	return to!string(db.lastInsertRowid());
}

private Choice[] mapResultRange(ResultRange results, string idColumn, string labelColumn) {
	Choice[] choices;
	foreach (result; results) {
		choices ~= Choice(result[idColumn].as!string, result[labelColumn].as!string);
	}
	return choices;
}
