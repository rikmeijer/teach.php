module sql.table;

import sql.select;

class Table {
	
	private string identifier;
	
	this(string identifier) {
		this.identifier = identifier;
	}
	
	public Select select(string[] fields) {
		return new Select(fields, this.identifier);
	}
	
	unittest {
		import dunit.toolkit;
		
		Table studentgroep = new Table("studentgroep");
		Select studentgroepQuery = studentgroep.select(["id", "naam"]);
		assertEqual("SELECT id, naam FROM studentgroep", studentgroepQuery.prepare().query);
	}
}