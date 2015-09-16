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
	
	private dataLeergang leergang;
	
	public this(string naam) {
		this(dataLeergang(null, naam));
	}
	
	public this(dataLeergang leergang) {
		this.leergang = leergang;
	}
	
	public bool registreerStudent(Student student) {
		return true;
	}
		
	unittest {
		auto student = new Student();
		auto leergang = new Leergang(dataLeergang("1", "PROG1"));
		assert(leergang.registreerStudent(student));
	}
}