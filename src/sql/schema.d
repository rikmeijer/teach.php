module sql.schema;

import sql.table;
import sql.select;
import sql.query;

import d2sqlite3;

class Schema {
	private Database sqlite_database;
	
	public this() {
	}
	
	/**
	 * SQLite constructor
	 */
	public this(Database database) {
		this.sqlite_database = database;
	}
	
	public Table table(string tableIdentifier) {
		return new Table(this, tableIdentifier);
	}
	
	unittest {
		import dunit.toolkit;
		
		Schema teach = new Schema();
		Table studentgroep = teach.table("studentgroep");
	}
	
	static sqlite(string path) {
		return new Schema(Database(path));
	}
	
	unittest {
		import dunit.toolkit;
		
		Schema teach = Schema.sqlite("/tmp/database.sqlite3");
		assertEqual("/tmp/database.sqlite3", teach.sqlite_database.attachedFilePath());
		Table studentgroep = teach.table("studentgroep");
	}
	
	public Select select(string tableIdentifier, string[] fields) {
		return new Select(this, tableIdentifier, fields);
	}
	
	unittest {
		import dunit.toolkit;
		
		Schema teach = Schema.sqlite("/tmp/database.sqlite3");
		assertEqual("SELECT id, naam FROM studentgroep", teach.select("studentgroep", ["id", "naam"]).prepare().query);
	}
	
	public ResultRange execute(prepared_query query) {
		return query.select(this.sqlite_database);
	}
}