module teach.student;

import teach.course;
import teach.coursestudent;
import teach.lesson;

class Student {
	
	CourseStudent enrollIn(Course course) {
		return new CourseStudent(course);
	}
	
	unittest {
		auto student = new Student();
		auto course = new Course("PROG1");
		CourseStudent coursestudent = student.enrollIn(course);
	}
}