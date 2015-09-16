module teach.sql;

struct prepared_query {
	string query;
	string[string] parameters;
}