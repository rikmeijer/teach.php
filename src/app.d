import std.stdio;
import d2sqlite3;
import teach.leergang;
import teach.cli.choice;

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
	Choice[] choices;
	foreach (leergang; leergangen) {
		choices ~= Choice(leergang["id"].as!string, leergang["naam"].as!string);
	}
	
	Choice choiceLeergang = choice("welke leergang wil je gebruiken? ", choices);
	
	Leergang leergang = new Leergang(choiceLeergang.label);
	
	auto leergangcontactmomentenStatement = db.prepare("SELECT id, naam FROM contactmoment WHERE leergang_id = ?");
	leergangcontactmomentenStatement.bind(1, choiceLeergang.id);
	auto leergangcontactmomenten = leergangcontactmomentenStatement.execute();
	if (leergangcontactmomenten.empty()) {
		writeln("Geen contactmomenten beschikbaar");
		return 1;
	}
	
	return 0;
}
