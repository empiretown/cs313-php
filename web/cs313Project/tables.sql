
CREATE TABLE player
(
  id              SERIAL PRIMARY KEY 	NOT NULL
, username        VARCHAR(25) 		   	NOT NULL
, password        VARCHAR(255) 	    	NOT NULL
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
,	attribute 		  VARCHAR(25) 		    NOT NULL
,	value				    INT 							  NOT NULL
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

CREATE USER brother_burton WITH PASSWORD 'bradismyfavoritestudent';

GRANT SELECT, INSERT, DELETE, UPDATE ON ALL TABLES IN SCHEMA public TO brother_burton;

GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA public to brother_burton;


-- everything past this point is not needed

SELECT p.username, i.itemname, i.rarity, a.attribute FROM player p
                            INNER JOIN userTOitems u on p.id = u.player_id
                            INNER JOIN item i on u.item_id = i.id
                            INNER JOIN itemAttributes a on i.id = a.item_id
                            WHERE p.id = 17;

SELECT i.itemname, i.rarity, a.attribute FROM player p
                            INNER JOIN userTOitems u on p.id = u.player_id
                            INNER JOIN item i on u.item_id = i.id
                            INNER JOIN itemAttributes a on i.id = a.item_id
                            WHERE p.id = 17;


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

INSERT INTO sellBoard
(player_id, item_id, price)
VALUES
  (2, 48, 4000)
, (5, 49, 2000)
;

INSERT INTO itemAttributes
(attribute, value, item_id)
VALUES
  ('Health', 32, 48)
, ('Attack', 25, 49)
;
