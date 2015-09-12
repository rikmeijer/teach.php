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
	
	unittest {
		auto course = new Course();
		auto studentA = new Student();
		auto studentClass = new Class(course, [studentA]);
	}
	
}