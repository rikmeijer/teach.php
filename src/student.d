module teach.student;

import teach.course;
import teach.lesson;

class Student {
	
	
	public void skip(Lesson lesson) {
		
	}
	
	unittest {
		auto student = new Student();
		auto course = new Course("PROG1");
		Lesson lesson = new Lesson(course);
		student.skip(lesson);
	}
}