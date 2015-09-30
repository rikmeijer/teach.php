module sql.select;

import std.array;
import d2sqlite3;

import sql.schema;
import sql.query;
import sql.condition;

class Select {
	
	private Schema schema;
	private string tableIdentifier;
	private string[] fieldIdentifiers;
	private Condition[] conditions;
	
	this(Schema schema, string tableIdentifier, string[] fieldIdentifiers) {
		this.schema = schema;
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
			
		Select query = new Select(new Schema(), "studentgroep", ["id", "naam", "jaar"]);
		prepared_query pq = query.prepare();
		assertEqual(pq.query, "SELECT id, naam, jaar FROM studentgroep");
		
	}
	
	public void where(Condition condition) {
		this.conditions ~= condition;
	}
	
	unittest {
		import dunit.toolkit;
		
		
		Select query = new Select(new Schema(), "contactmoment", ["id", "naam"]);
		query.where(new Condition("leergang_id", "="));
		prepared_query pq = query.prepare();
		assertEqual(pq.query, "SELECT id, naam FROM contactmoment WHERE leergang_id = ?");
		
	}
	
	public ResultRange execute() {
		return this.schema.execute(this.prepare());
	}
}
