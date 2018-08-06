--Tables 
CREATE TABLE states (
  id int(11) NOT NULL primary key auto_increment,
  country_id int(11) NOT NULL,
  state_name varchar(30) NOT NULL,
  foreign key(country_id) references countries(country_id)
)

CREATE TABLE countries (
  country_id int(11) NOT NULL primary key auto_increment,
  country_name varchar(30) NOT NULL
)

--Inner Join
SELECT * from countries INNER JOIN states on states.country_id=countries.country_id
--Left Join
SELECT * from countries LEFT JOIN states on states.country_id=countries.country_id
--Right Join
SELECT * from countries RIGHT JOIN states on states.country_id=countries.country_id
