CREATE TABLE player
(
  id              SERIAL PRIMARY KEY 	NOT NULL
, username        VARCHAR(25) 		   	NOT NULL
, password        VARCHAR(25) 	    	NOT NULL
, currency        INT                	NOT NULL
);

CREATE TABLE item
(
	id              SERIAL PRIMARY KEY  NOT NULL
,	itemname        VARCHAR(40)         NOT NULL
,	rarity          VARCHAR(15)         NOT NULL
);

CREATE TABLE itemAttributes
(
	id 	            SERIAL PRIMARY KEY  NOT NULL
,	attribute1 		  VARCHAR(25) 		    NOT NULL
,	val1				    INT 							  NOT NULL
,	item_id				  INT 				  			NOT NULL REFERENCES item(id)
);

CREATE TABLE userTOitems
(
	id 						  SERIAL PRIMARY KEY  NOT NULL
,	player_id			  INT 							  NOT NULL REFERENCES player(id)
,	item_id				  INT 							  NOT NULL REFERENCES item(id)
);

CREATE TABLE sellBoard
(
	id 					    SERIAL PRIMARY KEY  NOT NULL
,	player_id			  INT 							  NOT NULL REFERENCES player(id)
,	item_id				  INT 							  NOT NULL REFERENCES item(id)
,	price					  INT 							  NOT NULL
);

INSERT INTO item
(itemName, rarity)
VALUES
  ('Wooden Sword', 'White')
, ('Sharp Wooden Sword', 'Green')
, ('Leather Armor', 'Green')
, ('Steel Armor', 'Blue')
, ('Best Sword', 'Purple')
;

INSERT INTO player
(username, password, currency)
VALUES
  ('Brad Marx', '123', 9001)
, ('Brother Burton', '123', 99999)
, ('Karl Marx', 'russia', 1)
;

INSERT INTO userTOitems
(player_id, item_id)
VALUES
  (1, 2)
, (1, 4)
, (2, 3)
, (2, 5)
, (3, 1)
;

CREATE USER brother_burton WITH PASSWORD 'bradismyfavoritestudent';
GRANT SELECT, INSERT, UPDATE ON ALL TABLES IN SCHEMA public TO brother_burton;

-- NOT WORKING YET --
INSERT INTO itemAttributes
(attribute1, val1)
VALUES
  ('Attack', 2)
, ('Attack', 3)
, ('Crit', 5)
, ('Defense', 3)
, ('Evasion', 7)
, ('Defense', 8)
, ('Health', 30)
, ('Attack', 100)
, ('Crit', 50)
, ('MultiHit', 5)
;
