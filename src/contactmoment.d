module teach.contactmoment;

import sql;
import teach.leergang;

struct dataContactmoment {
	
	string id;
	string naam;
	string leergang_id;
	
	static prepared_query prepareSelectByLeergang(string leergang_id) {
		Table table = new Table("contactmoment");
		Select query = table.select(["id", "naam"]);
		query.where(new Condition("leergang_id", "="));
		return query.prepare();
	}
	
	unittest {
		import dunit.toolkit;
		prepared_query pq = dataContactmoment.prepareSelectByLeergang("1");
		assertEqual(pq.query, "SELECT id, naam FROM contactmoment WHERE leergang_id = ?");
	}
	
	public prepared_query prepareInsert() {
		return prepared_query("INSERT INTO contactmoment (`naam`, `leergang_id`) VALUES (?, ?)", [
			this.naam,
			this.leergang_id
			]);
	}
	
	unittest {
		import dunit.toolkit;
		dataContactmoment cm = dataContactmoment(null, "TEST", "1");
		prepared_query pq = cm.prepareInsert();
		assertEqual(pq.query, "INSERT INTO contactmoment (`naam`, `leergang_id`) VALUES (?, ?)");
		assertEqual(pq.parameters[0], "TEST");
		assertEqual(pq.parameters[1], "1");
	}

}

class Contactmoment {
	
	private dataContactmoment contactmoment;
	
	public this(dataContactmoment contactmoment) {
		this.contactmoment = contactmoment;
	}
	
}