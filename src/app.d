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
		choices[choiceKey] = choice;
	}
	string answer = cli_choice("welke leergang wil je gebruiken? ", choices);
	
	Leergang leergang = new Leergang(choices[answer]);
			
	return 0;
}


string cli_choice(string question, string[string] choices) {
	foreach (choiceKey, choice; choices) {
		writeln(choiceKey ~ ". " ~ choice);
	}
	write(question);
	string answer = strip(readln());
	if (answer !in choices) {
		writeln("Antwoord '" ~ answer ~ "' onjuist.");
		return cli_choice(question, choices);
	}
	return answer;
}
