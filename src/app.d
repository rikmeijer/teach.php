import std.stdio;
import std.string;
import teach.course;

int main() {
	write("Hello, what course are the students following today? ");
	string answer = strip(readln());
	switch (answer) {
		case "PROG1":
			break;
		case "DATAB1":
			break;
		default:
			writeln("Don't know course '" ~ answer ~ "'...");
			return 1;
			
	}
	Course course = new Course(answer);
			
	return 0;
}