module teach.student;

import teach.course;
import teach.coursestudent;
import teach.lesson;

class Student {
	
	CourseStudent enroll(Course course) {
		return new CourseStudent(course);
	}
	
	unittest {
		auto student = new Student();
		auto course = new Course("PROG1");
		assert(student.enrolled(course) == false);
		CourseStudent coursestudent = student.enroll(course);
	}
}