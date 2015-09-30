module sql.condition;


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