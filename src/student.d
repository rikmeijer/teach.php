module teach.student;

import teach.course;
import teach.lesson;

class Student {
	
	private Course[] courses;
	
	bool enrolled(Course course) {
		foreach (Course enrolledCourse; this.courses) {
			if (enrolledCourse == course) {
				return true;
			}
		}
		return false;
	}
	
	void enroll(Course course) {
		this.courses.length++;
		this.courses[] = course;
	}
	
	unittest {
		auto student = new Student();
		auto course = new Course("PROG1");
		assert(student.enrolled(course) == false);
		student.enroll(course);
		assert(student.enrolled(course));
		
	}
}