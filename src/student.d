module teach.student;

import teach.course;
import teach.coursestudent;
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
	
	CourseStudent enroll(Course course) {
		this.courses.length++;
		this.courses[] = course;
		return new CourseStudent(course);
	}
	
	unittest {
		auto student = new Student();
		auto course = new Course("PROG1");
		assert(student.enrolled(course) == false);
		CourseStudent coursestudent = student.enroll(course);
		assert(student.enrolled(course));
	}
}