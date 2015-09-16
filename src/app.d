import std.stdio;
import std.conv;
import d2sqlite3;
import teach.leergang;
import teach.cli.choice;
import teach.cli.text;

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
		auto leergangcontactmomentInsertStatement = db.prepare("INSERT INTO contactmoment (`naam`, `leergang_id`) VALUES (?, ?)");
		leergangcontactmomentInsertStatement.bind(1, choiceContactmoment.label);
		leergangcontactmomentInsertStatement.bind(2, choiceLeergang.id);
		leergangcontactmomentInsertStatement.execute();
		choiceContactmoment.id = to!string(db.lastInsertRowid());
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
