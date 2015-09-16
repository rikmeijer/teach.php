module teach.student;

import teach.leergang;
import teach.contactmoment;

class Student {
	
	
	public void verzuim(Contactmoment contactmoment) {
		
	}
	
	unittest {
		auto student = new Student();
		auto leergang = new Leergang("PROG1");
		Contactmoment contactmoment = new Contactmoment(leergang);
		student.verzuim(contactmoment);
	}
}