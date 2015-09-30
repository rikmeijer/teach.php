module sql.schema;

import sql.table;

class Schema {
	
	public Table table(string tableIdentifier) {
		return new Table(tableIdentifier);
	}
	
	unittest {
		import dunit.toolkit;
		
		Schema teach = new Schema();
		Table studentgroep = teach.table("studentgroep");
	}
}