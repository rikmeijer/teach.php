module teach.studentgroep;

import sql;

struct dataStudentgroep {
	
	string id;
	string naam;
	string jaar;
	
	unittest {
		import dunit.toolkit;
		dataStudentgroep sg = dataStudentgroep("1", "Q", "2015");
		assertEqual(sg.id, "1");
		assertEqual(sg.naam, "Q");
		assertEqual(sg.jaar, "2015");
	}
	
	static prepared_query prepareSelect() {
		Table table = new Table("studentgroep");
		return table.select(["id", "naam", "jaar"]).prepare();
	}
	unittest {
		import dunit.toolkit;
		prepared_query pq = dataStudentgroep.prepareSelect();
		assertEqual(pq.query, "SELECT id, naam, jaar FROM studentgroep");
	}
}