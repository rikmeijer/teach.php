module teach.leergang;

import teach.sql;
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
	
	static prepareSelect() {
		Select query = new Select(["id", "naam"], "leergang");
		return query.prepare();
	}
	
	unittest {
		import dunit.toolkit;
		prepared_query pq = dataLeergang.prepareSelect();
		assertEqual(pq.query, "SELECT id, naam FROM leergang");
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