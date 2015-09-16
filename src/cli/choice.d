module teach.cli.choice;

import std.stdio;
import std.string;
import std.conv;

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