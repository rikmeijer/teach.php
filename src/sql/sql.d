module teach.sql;

struct prepared_query {
	string query;
	string[] parameters;
	
	void mapParameters(void delegate(int index, string value) mapper) {
		for (int i = 0; i < this.parameters.length; i++) {
			mapper(i + 1, this.parameters[i]);
		}
	}
}