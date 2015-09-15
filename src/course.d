module teach.course;

import teach.student;

class Course {
	
	private string name;
	
	public this(string name) {
		this.name = name;
	}
	
	public bool enroll(Student student) {
		return true;
	}
		
	unittest {
		auto student = new Student();
		auto course = new Course("PROG1");
		assert(course.enroll(student));
	}
}