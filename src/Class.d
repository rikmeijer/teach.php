module teach.Class;

import teach.Student;
import teach.Course;

class Class {

	private Course course; 
	private Student[] students;

	this(Course course, Student[] students) {
		this.course = course;
		this.students = students;
	}
	
	bool expects(Student student) {
		foreach (Student expectedStudent; this.students) {
			if (expectedStudent == student) {
				return true;
			}
		}
		return false;
	}
	
	unittest {
		auto course = new Course();
		auto studentA = new Student();
		auto studentB = new Student();
		auto studentClass = new Class(course, [studentA]);
		assert(studentClass.expects(studentB) == false);
		assert(studentClass.expects(studentA));
	}
	
}