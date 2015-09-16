module teach.leergang;

import teach.student;

struct dataLeergang {
	
	string id;
	string naam;
}

unittest {
	dataLeergang lg = dataLeergang("1", "PROG1");
	assert(lg.id == "1");
	assert(lg.naam == "PROG1");
}

class Leergang {
	
	private string naam;
	
	public this(string naam) {
		this.naam = naam;
	}
	
	public bool registreerStudent(Student student) {
		return true;
	}
		
	unittest {
		auto student = new Student();
		auto leergang = new Leergang("PROG1");
		assert(leergang.registreerStudent(student));
	}
}