import Course;

class Student {
	
	bool enrolled(Course course) {
		return false;
	}
	
	unittest {
		auto student = new Student();
		auto course = new Course();
		assert(student.enrolled(course) == false);
	}
}