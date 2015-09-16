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
	cliChoice[] choices;
	foreach (leergang; leergangen) {
		choices ~= cliChoice(leergang["id"].as!string, leergang["naam"].as!string);
	}
	
	cliChoice answer = cli_choice("welke leergang wil je gebruiken? ", choices);
	
	Leergang leergang = new Leergang(answer.label);
	
	return 0;
}
