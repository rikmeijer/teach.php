module teach.contactmoment;

import sql;
import teach.leergang;

struct dataContactmoment {
	
	string id;
	string naam;
	string leergang_id;
	
	static Select prepareSelectByLeergang(Schema source, string leergang_id) {
		Select query = source.table("contactmoment").select(["id", "naam"]);
		query.where(new Condition("leergang_id", "="));
		return query;
	}
	
	unittest {
		import dunit.toolkit;
		Select pq = dataContactmoment.prepareSelectByLeergang(new Schema(), "1");
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