module teach.cli.text;

import std.stdio;
import std.string;

public string askInput(string question) {
	write(question);
	string answer = strip(readln());
	if (answer.length == 0) {
		writeln("Antwoord vereist.");
		return askInput(question);
	}
	return answer;
}