module teach.Class;

import teach.Student;

class Class {

	private Student[] students;

	this(Student[] students) {
		this.students = students;
	}
	
	bool expects(Student student) {
		return false;
	}
	
	unittest {
		auto studentA = new Student();
		auto studentB = new Student();
		auto studentClass = new Class([studentA]);
		assert(studentClass.expects(studentB) == false);
	}
	
}