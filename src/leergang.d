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
		return prepared_query("SELECT id, naam FROM leergang", []);
	}
	
	unittest {
		import dunit.toolkit;
		prepared_query pq = dataLeergang.prepareSelect();
		assertEqual(pq.query, "SELECT id, naam FROM leergang");
	}
	
	public prepared_query prepareSelectContactmomenten() {
		return prepared_query("SELECT id, naam FROM contactmoment WHERE leergang_id = ?", [
			this.id
			]);
	}
	
	unittest {
		import dunit.toolkit;
		dataLeergang lg = dataLeergang("1", "PROG1");
		prepared_query pq = lg.prepareSelectContactmomenten();
		assertEqual(pq.query, "SELECT id, naam FROM contactmoment WHERE leergang_id = ?");
		assertEqual(pq.parameters[0], "1");
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