module teach.cli.choice;

import std.stdio;
import std.string;
import std.conv;

struct Choice {
	string id;
	string label;
}

Choice choice(string question, Choice[] choices) {
	for (int choiceKey = 0; choiceKey < choices.length; choiceKey++) {
		writeln(to!string(choiceKey) ~ ". " ~ choices[choiceKey].label);
	}
	write(question);
	string answer = strip(readln());
	int selectedChoiceKey = to!int(answer);
	if (selectedChoiceKey >= choices.length) {
		writeln("Antwoord '" ~ answer ~ "' onjuist.");
		return choice(question, choices);
	}
	return choices[selectedChoiceKey];
}