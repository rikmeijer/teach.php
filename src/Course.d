module teach.Course;

import teach.Student;
import teach.Class;

class Course {
	
	Class startClass() {
		return new Class();
	}
	
	unittest {
		auto course = new Course();
		Class courseClass = course.startClass();
	}
	
}