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

struct cliChoice {
	string id;
	string label;
}

cliChoice cli_choice(string question, cliChoice[] choices) {
	for (int choiceKey = 0; choiceKey < choices.length; choiceKey++) {
		writeln(to!string(choiceKey) ~ ". " ~ choices[choiceKey].label);
	}
	write(question);
	string answer = strip(readln());
	int selectedChoiceKey = to!int(answer);
	if (selectedChoiceKey >= choices.length) {
		writeln("Antwoord '" ~ answer ~ "' onjuist.");
		return cli_choice(question, choices);
	}
	return choices[selectedChoiceKey];
}
