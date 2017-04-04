
--Bank Agents
--DROP TABLE bank_agents;
CREATE TABLE bank_agent
(
  id                SERIAL PRIMARY KEY
, employee_num      SERIAL                NOT NULL
, firstName         VARCHAR(30)           NOT NULL
, lastName          VARCHAR(30)           NOT NULL
, username          VARCHAR(30)           NOT NULL
, password          VARCHAR(255) 	       	NOT NULL
);

--Transaction History
--DROP TABLE transaction_history;
CREATE TABLE transaction_event
(
  id                  SERIAL PRIMARY KEY
, transaction_amount  MONEY                NOT NULL
, transaction_date    DATE
---, bank_agent_id       INT                  NOT NULL REFERENCES bank_agent(id)
);

--Bank Accounts
--DROP TABLE bank_accounts;
CREATE TABLE bank_account
(
  id                      SERIAL PRIMARY KEY
, account_num             INT                  NOT NULL
, account_amount          MONEY                NOT NULL
);

--Transaction History
--DROP TABLE transaction_history;
CREATE TABLE transaction_history
(
  id                    SERIAL PRIMARY KEY
, transaction_event_id  INT                  NOT NULL REFERENCES transaction_event(id)
, bank_account_id       INT                  NOT NULL REFERENCES bank_account(id)
);

--Account Holder
--DROP TABLE account_holder;
CREATE TABLE account_holder
(
  id              SERIAL PRIMARY KEY
, name            TEXT                  NOT NULL
, username        VARCHAR(30)           NOT NULL
, password        VARCHAR(255) 	       	NOT NULL
, contact_info    TEXT
);

--Account Holder to Bank Accounts
CREATE TABLE account_holder_to_bank_account
(
  id                  SERIAL PRIMARY KEY
, account_holder_id   INT                  NOT NULL REFERENCES account_holder(id)
, bank_account_id     INT                  NOT NULL REFERENCES bank_account(id)
);

--Pending Deposit
--DROP TABLE pending_deposit;
CREATE TABLE pending_deposit
(
  id                 SERIAL PRIMARY KEY
, account_holder_id  INT                 NOT NULL REFERENCES account_holder(id)
, bank_account_id    INT                 NOT NULL REFERENCES bank_account(id)
, deposit_amount     MONEY               NOT NULL
, check_front        BYTEA               NOT NULL
, check_back         BYTEA               NOT NULL
);


-- create the user for databasse connection
CREATE USER brother_burton WITH PASSWORD 'bradismyfavoritestudent';

GRANT SELECT, INSERT, UPDATE ON ALL TABLES IN SCHEMA public TO brother_burton;

GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA public to brother_burton;


-- insert dummy data ---

-----INSERT INTO ACCOUNT_HOLDER-----
----INSERT Hayden Carlson----
INSERT INTO account_holder(name)
VALUES ('Hayden Carlson');

----INSERT Brad Marx----
INSERT INTO account_holder(name)
VALUES ('Brad Marx');

----INSERT Israel Carvajal----
INSERT INTO account_holder(name)
VALUES ('Israel Carvajal');



----------------------ACTUAL INSERT ----------------------------------

----INSERT Megan Carlson----
INSERT INTO account_holder(name, username, password)
VALUES ('Megan Carlson', 'Megan123', 'Megan123');

----INSERT Megan Carlson----
INSERT INTO bank_account(account_num, account_amount, transaction_history_id)
VALUES (999, 9000, 1);

----INSERT LINKER----
INSERT INTO account_holder_to_bank_account(account_holder_id, bank_account_id)
VALUES (1, 1);




----------------------------------------------------------------------


-----INSERT INTO BANK AGENTS-----
----INSERT John Jackson----
INSERT INTO bank_agent(firstName, lastName, username, password)
VALUES ('John', 'Jackson', 'jJack', '123');

----INSERT Jack Jackson----
INSERT INTO bank_agent(firstName, lastName, username, password)
VALUES ('Bob', 'Billy', 'bBilly', '123');

----INSERT Jack Johnson----
INSERT INTO bank_agent(firstName, lastName, username, password)
VALUES ('Sue', 'Sally', 'sSally', '123');
