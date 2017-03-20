
CREATE TABLE person
(
  id              SERIAL PRIMARY KEY 	NOT NULL
, firstName       VARCHAR(30) 		   	NOT NULL
, lastName        VARCHAR(30) 		   	NOT NULL
, birthday        INT                 NOT NULL
);

CREATE TABLE parentTOchild
(
	id              SERIAL PRIMARY KEY   NOT NULL
,	parent_id		    INT 							   NOT NULL REFERENCES person(id)
,	child_id		    INT 							   NOT NULL REFERENCES person(id)
);


CREATE USER brother_burton WITH PASSWORD 'bradismyfavoritestudent';

GRANT SELECT, INSERT, DELETE, UPDATE ON ALL TABLES IN SCHEMA public TO brother_burton;
GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA public to brother_burton;


-- everything past this point is not needed


INSERT INTO person
(firstName, lastName, birthday)
VALUES
  ('Brad', 'Marx', 9001)
, ('Brother', 'Burton', 99999)
, ('Sam', 'Barlow', 1)
, ('JT', 'lastName', 67)
;

INSERT INTO parentTOchild
(parent_id, child_id)
VALUES
  (3, 4)
, (1, 2)
;
