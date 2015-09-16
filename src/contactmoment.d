module teach.contactmoment;

import teach.sql;
import teach.leergang;

struct dataContactmoment {
	
	string naam;
	string leergang_id;
	
	public prepared_query prepareInsert() {
		return prepared_query("INSERT INTO contactmoment (`naam`, `leergang_id`) VALUES (?, ?)", [
			this.naam,
			this.leergang_id
			]);
	}
}

unittest {
	dataContactmoment cm = dataContactmoment("TEST", "1");
	prepared_query pq = cm.prepareInsert();
	assert(pq.query == "INSERT INTO contactmoment (`naam`, `leergang_id`) VALUES (?, ?)");
	assert(pq.parameters[0] == "TEST");
	assert(pq.parameters[1] == "1");
}

class Contactmoment {
	
	private dataContactmoment contactmoment;
	
	public this(dataContactmoment contactmoment) {
		this.contactmoment = contactmoment;
	}
	
}