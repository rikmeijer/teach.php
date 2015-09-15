module teach.student;

import teach.leergang;
import teach.les;

class Student {
	
	
	public void verzuim(Les les) {
		
	}
	
	unittest {
		auto student = new Student();
		auto leergang = new Leergang("PROG1");
		Les les = new Les(leergang);
		student.verzuim(les);
	}
}