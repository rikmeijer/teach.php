module sql.select;

import std.array;

import sql.query;
import sql.condition;

class Select {
	
	string[] fieldIdentifiers;
	string tableIdentifier;
	Condition[] conditions;
	
	
	this(string[] fieldIdentifiers, string tableIdentifier) {
		this.fieldIdentifiers = fieldIdentifiers;
		this.tableIdentifier = tableIdentifier;
	}
	
	public prepared_query prepare() {
		string[] where = [];
		foreach (Condition condition; this.conditions) {
			where ~= condition.prepare();
		}
		
		string sql = "SELECT " ~ join(this.fieldIdentifiers, ", ") ~ " FROM " ~ this.tableIdentifier;
		if (where.length > 0) {
			sql ~= " WHERE " ~ join(where, "AND");
		}
		
		return prepared_query(sql, []);
	}

	unittest {
		import dunit.toolkit;
			
		Select query = new Select(["id", "naam", "jaar"], "studentgroep");
		prepared_query pq = query.prepare();
		assertEqual(pq.query, "SELECT id, naam, jaar FROM studentgroep");
		
	}
	
	public void where(Condition condition) {
		this.conditions ~= condition;
	}
	
	unittest {
		import dunit.toolkit;
		
		
		Select query = new Select(["id", "naam"], "contactmoment");
		query.where(new Condition("leergang_id", "="));
		prepared_query pq = query.prepare();
		assertEqual(pq.query, "SELECT id, naam FROM contactmoment WHERE leergang_id = ?");
		
	}
}
