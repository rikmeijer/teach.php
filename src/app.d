import std.stdio;
import std.string;
import std.conv;
import d2sqlite3;
import teach.leergang;

int main(string[] args) {
	if (args.length == 1) {
		writeln("Geef database mee als argument");
		return 1;
	}
	Database db = Database(args[1]);
	
	auto leergangen = db.execute("SELECT naam FROM leergang");
	if (leergangen.empty()) {
		writeln("Geen leergangen beschikbaar");
		return 1;
	}
	writeln("Hallo, de volgende leergangen zijn beschikbaar: ");
	string[string] choices;
	foreach (leergang; leergangen) {
		string choiceKey = to!string(choices.length);
		string choice = leergang["naam"].as!string;
		
		writeln(choiceKey ~ ". " ~ choice);
		choices[choiceKey] = choice;
	}
	write("welke leergang wil je gebruiken? ");
	
	string answer = strip(readln());
	if (answer !in choices) {
		writeln("Onbekende leergang '" ~ answer ~ "'...");
		return 1;
	}
	
	Leergang leergang = new Leergang(choices[answer]);
			
	return 0;
}