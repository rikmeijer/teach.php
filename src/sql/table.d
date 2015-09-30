module sql.table;

import sql.select;
import sql.schema;

class Table {
	
	private Schema schema;
	private string identifier;
	
	this(Schema schema, string identifier) {
		this.schema = schema;
		this.identifier = identifier;
	}
	
	public Select select(string[] fields) {
		return this.schema.select(this.identifier, fields);
	}
	
	unittest {
		import dunit.toolkit;
		
		Table studentgroep = new Table(new Schema(), "studentgroep");
		Select studentgroepQuery = studentgroep.select(["id", "naam"]);
		assertEqual("SELECT id, naam FROM studentgroep", studentgroepQuery.prepare().query);
	}
}