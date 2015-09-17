import std.stdio;
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
	
	auto leergangen = dataLeergang.prepareSelect().select(db);
	if (leergangen.empty()) {
		writeln("Geen leergangen beschikbaar");
		return 1;
	}
	writeln("Hallo, de volgende leergangen zijn beschikbaar: ");
	Choice[] choicesLeergangen = mapResultRange(leergangen, "id", "naam");
	Choice choiceLeergang = choice("welke leergang wil je gebruiken? ", choicesLeergangen);
	
	dataLeergang dLeergang = dataLeergang(choiceLeergang.id, choiceLeergang.label);
	Leergang leergang = new Leergang(dLeergang);
	
	auto leergangcontactmomenten = dLeergang.prepareSelectContactmomenten().select(db);
	
	Choice[] choicesContactmomenten = mapResultRange(leergangcontactmomenten, "id", "naam");
	choicesContactmomenten ~= Choice(null, "Nieuw aanmaken");
	Choice choiceContactmoment = choice("welke contactmoment wil je gebruiken? ", choicesContactmomenten);
	
	if (choiceContactmoment.id is null) {
		choiceContactmoment.label = askInput("Geef de naam voor nieuw contactmoment: ");
		auto contactmoment = dataContactmoment(choiceContactmoment.id, choiceContactmoment.label, choiceLeergang.id);
		choiceContactmoment.id = contactmoment.prepareInsert().insert(db);
	}
	
	return 0;
}

private Choice[] mapResultRange(ResultRange results, string idColumn, string labelColumn) {
	Choice[] choices;
	foreach (result; results) {
		choices ~= Choice(result[idColumn].as!string, result[labelColumn].as!string);
	}
	return choices;
}
