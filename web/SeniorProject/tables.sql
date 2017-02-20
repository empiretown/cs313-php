
--Bank Agents
--DROP TABLE bank_agents;
CREATE TABLE bank_agent(
              id SERIAL PRIMARY KEY,
              name TEXT NOT NULL,
              employee_num SERIAL NOT NULL);

--Transaction History
--DROP TABLE transaction_history;
CREATE TABLE transaction_history(
              id          SERIAL PRIMARY KEY,
              transaction_amount    MONEY            NOT NULL,
              transaction_date          DATE,
              bank_agent_id INT NOT NULL REFERENCES bank_agent(id));

--Bank Accounts
--DROP TABLE bank_accounts;
CREATE TABLE bank_account(
              id SERIAL PRIMARY KEY,
              account_num INT NOT NULL,
              account_amount MONEY NOT NULL,
              transaction_history_id INT NOT NULL REFERENCES transaction_history(id));



--Account Holder
--DROP TABLE account_holder;
CREATE TABLE account_holder(
              id          SERIAL PRIMARY KEY,
              name   TEXT      NOT NULL,
              contact_info    TEXT);

--Account Holder to Bank Accounts
CREATE TABLE account_holder_to_bank_account(
              id  SERIAL  PRIMARY KEY,
              account_holder_id INT NOT NULL REFERENCES account_holder(id),
              bank_account INT NOT NULL REFERENCES bank_account(id));

--Pending Deposit
--DROP TABLE pending_deposit;
CREATE TABLE pending_deposit(
              id          SERIAL PRIMARY KEY,
              account_holder_id       INT      NOT NULL REFERENCES account_holder(id),
              bank_account INT NOT NULL REFERENCES bank_account(id),
              deposit_amount           MONEY            NOT NULL,
              check_front BYTEA NOT NULL,
              check_back BYTEA NOT NULL);

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

----INSERT Megan Carlson----
INSERT INTO account_holder(name)
VALUES ('Megan Carlson');


-----INSERT INTO BANK AGENTS-----
----INSERT John Jackson----
INSERT INTO bank_agent(name)
VALUES ('John Jackson');

----INSERT Jack Jackson----
INSERT INTO bank_agent(name)
VALUES ('Jack Jackson');

----INSERT Jack Johnson----
INSERT INTO bank_agent(name)
VALUES ('Jack Johnson');
