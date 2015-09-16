module teach.cli.choice;

import teach.cli.text;
import std.stdio;
import std.conv;

struct Choice {
	string id;
	string label;
}

public Choice choice(string question, Choice[] choices) {
	for (int choiceKey = 0; choiceKey < choices.length; choiceKey++) {
		writeln(to!string(choiceKey) ~ ". " ~ choices[choiceKey].label);
	}
	string answer = askInput(question);
	int selectedChoiceKey = to!int(answer);
	if (selectedChoiceKey >= choices.length) {
		writeln("Antwoord '" ~ answer ~ "' onjuist.");
		return choice(question, choices);
	}
	return choices[selectedChoiceKey];
}