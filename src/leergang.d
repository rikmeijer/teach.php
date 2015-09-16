module teach.leergang;

import teach.sql;
import teach.student;

struct dataLeergang {
	
	string id;
	string naam;
	
	unittest {
		dataLeergang lg = dataLeergang("1", "PROG1");
		assert(lg.id == "1");
		assert(lg.naam == "PROG1");
	}
	
	public prepared_query prepareSelectContactmomenten() {
		return prepared_query("SELECT id, naam FROM contactmoment WHERE leergang_id = ?", [
			this.id
			]);
	}
	
	unittest {
		dataLeergang lg = dataLeergang("1", "PROG1");
		prepared_query pq = lg.prepareSelectContactmomenten();
		assert(pq.query == "SELECT id, naam FROM contactmoment WHERE leergang_id = ?");
		assert(pq.parameters[0] == "1");
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
		auto student = new Student();
		auto leergang = new Leergang(dataLeergang("1", "PROG1"));
		assert(leergang.registreerStudent(student));
	}
}