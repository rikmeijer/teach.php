module teach.contactmoment;

import teach.sql;
import teach.leergang;

struct contactmoment {
	
	public prepared_query prepareInsert() {
		return prepared_query("INSERT INTO contactmoment (`naam`, `leergang_id`) VALUES (?, ?)");
	}
}

unittest {
	contactmoment cm = contactmoment();
	prepared_query pq = cm.prepareInsert();
	assert(pq.query == "INSERT INTO contactmoment (`naam`, `leergang_id`) VALUES (?, ?)");
}

class Contactmoment {
	
	private Leergang leergang;
	
	public this(Leergang leergang) {
		this.leergang = leergang;
	}
	
}