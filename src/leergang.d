module teach.leergang;

import teach.student;

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