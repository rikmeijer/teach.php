module teach.sql;

import d2sqlite3;
import std.conv;
import std.array;

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

class Condition {
	
	string lhsOperand; // lhs = left-hand-side
	string operator;
	
	this(string lhsOperand, string operator) {
		this.lhsOperand = lhsOperand;
		this.operator = operator;
	}
	
	public string prepare() {
		return this.lhsOperand ~ " " ~ this.operator ~ " ?";
	}
	
	unittest {
		import dunit.toolkit;
		
		Condition condition = new Condition("leergang_id", "=");
		assertEqual("leergang_id = ?", condition.prepare());
	}

}

class Select {
	
	string[] fieldIdentifiers;
	string tableIdentifier;
	
	
	this(string[] fieldIdentifiers, string tableIdentifier) {
		this.fieldIdentifiers = fieldIdentifiers;
		this.tableIdentifier = tableIdentifier;
	}
	
	public prepared_query prepare() {
		return prepared_query("SELECT " ~ join(this.fieldIdentifiers, ", ") ~ " FROM " ~ this.tableIdentifier, []);
	}

	unittest {
		import dunit.toolkit;
			
		Select query = new Select(["id", "naam", "jaar"], "studentgroep");
		prepared_query pq = query.prepare();
		assertEqual(pq.query, "SELECT id, naam, jaar FROM studentgroep");
		
	}
}
