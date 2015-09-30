module teach.leergang;

import sql;
import teach.student;

struct dataLeergang {
	
	string id;
	string naam;
	
	unittest {
		import dunit.toolkit;
		dataLeergang lg = dataLeergang("1", "PROG1");
		assertEqual(lg.id, "1");
		assertEqual(lg.naam, "PROG1");
	}
	
	static Select prepareSelect(Schema source) {
		return source.table("leergang").select(["id", "naam"]);
	}
	
	unittest {
		import dunit.toolkit;
		Select pq = dataLeergang.prepareSelect(new Schema());
	}
	
}


class Leergang {
	
	private dataLeergang leergang;
	
	public this(dataLeergang leergang) {
		this.leergang = leergang;
	}
	
	public bool registreerStudent(Student student) {
		return true;
	}
		
	unittest {
		import dunit.toolkit;
		auto student = new Student();
		auto leergang = new Leergang(dataLeergang("1", "PROG1"));
		assertTrue(leergang.registreerStudent(student));
	}
}