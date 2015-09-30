module sql.query;

import d2sqlite3;
import std.conv;

struct prepared_query {
	string query;
	string[] parameters;
	
	public void mapParameters(void delegate(int index, string value) mapper) {
		for (int i = 0; i < this.parameters.length; i++) {
			mapper(i + 1, this.parameters[i]);
		}
	}
	
	public Statement prepare(Database db) {
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
}
