module teach.sql;

import d2sqlite3;
import std.conv;
import std.array;

struct fields {
	string[] identifiers;
}
unittest {
	fields studentgroepFields = fields(["id", "naam", "jaar"]);
}

struct prepared_query {
	string query;
	string[] parameters;
	
	public void mapParameters(void delegate(int index, string value) mapper) {
		for (int i = 0; i < this.parameters.length; i++) {
			mapper(i + 1, this.parameters[i]);
		}
	}
	
	private Statement prepare(Database db) {
		auto statement = db.prepare(this.query);
		for (int i = 0; i < this.parameters.length; i++) {
			statement.bind(i + 1, this.parameters[i]);
		}
		return statement;
	}

	public string insert(Database db) {
		Statement statement = this.prepare(db);
		statement.execute();
		return to!string(db.lastInsertRowid());
	}

	public ResultRange select(Database db) {
		Statement statement = this.prepare(db);
		return statement.execute();
	}	
}

class Select {
	
	fields fieldIdentifiers;
	string tableIdentifier;
	
	
	this(fields fieldIdentifiers, string tableIdentifier) {
		this.fieldIdentifiers = fieldIdentifiers;
		this.tableIdentifier = tableIdentifier;
	}
	
	public prepared_query prepare() {
		return prepared_query("SELECT " ~ join(this.fieldIdentifiers.identifiers, ", ") ~ " FROM " ~ this.tableIdentifier, []);
	}
}

unittest {
	import dunit.toolkit;
		
	Select query = new Select(fields(["id", "naam", "jaar"]), "studentgroep");
	prepared_query pq = query.prepare();
	assertEqual(pq.query, "SELECT id, naam, jaar FROM studentgroep");
	
}
