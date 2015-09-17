module teach.sql;

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
	

	public string insert(Database db) {
		this.execute(db);
		return to!string(db.lastInsertRowid());
	}

	public ResultRange execute(Database db) {
		auto statement = db.prepare(this.query);
		for (int i = 0; i < this.parameters.length; i++) {
			statement.bind(i + 1, this.parameters[i]);
		}
		return statement.execute();
	}
}