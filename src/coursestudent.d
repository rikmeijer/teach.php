module teach.coursestudent;

import teach.course;
import teach.lesson;

class CourseStudent {
	
	private Course course;
	
	public this(Course course) {
		this.course = course;
	}
	
	public void skip(Lesson lesson) {
		
	}
	
	unittest {
		auto course = new Course("PROG1");
		auto student = new CourseStudent(course);
		Lesson lesson = new Lesson(course);
		student.skip(lesson);
	}
}