class Student
{
	bool reportAbsent()
	{
		return true;
	}
	
	unittest 
	{
		auto student = new Student();
		assert(student.reportAbsent());
	}
}