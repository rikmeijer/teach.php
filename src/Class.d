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
		return student.enrolled(this.course);
	}
	
	unittest {
		auto course = new Course();
		auto studentA = new Student();
		studentA.enroll(course);
		auto studentB = new Student();
		auto studentClass = new Class(course, [studentA]);
		assert(studentClass.expects(studentB) == false);
		assert(studentClass.expects(studentA));
	}
	
}