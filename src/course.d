module teach.course;

import teach.coursestudent;
import teach.student;

class Course {
	
	private string name;
	
	public this(string name) {
		this.name = name;
	}
	
	public CourseStudent enroll(Student student) {
		return new CourseStudent(this);
	}
	
	unittest {
		auto student = new Student();
		auto course = new Course("PROG1");
		CourseStudent coursestudent = course.enroll(student);
	}
}