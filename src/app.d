import std.stdio;
import std.string;
import teach.leergang;

int main() {
	write("Hallo, voor welke leergang hebben de studenten les? ");
	string answer = strip(readln());
	switch (answer) {
		case "PROG1":
			break;
		case "DATAB1":
			break;
		default:
			writeln("Onbekende leergang '" ~ answer ~ "'...");
			return 1;
			
	}
	Leergang leergang = new Leergang(answer);
			
	return 0;
}