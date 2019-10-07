
/*
c:\xampp\mysql\bin\mysql -uedunova -pedunova --default_character_set=utf8 < "C:\LawFirm\lawfirm2.sql"
*/

drop database if exists LawFirm;
create database LawFirm default character set utf8;
use LawFirm;

 create table operater(
operater_id int not null primary key auto_increment,
firstname varchar (50),
lastname varchar (50),
email varchar (50),
password varchar (60),
uloga varchar (20)
);
INSERT INTO operater
(firstname, lastname, email, password)
VALUES
('Damir', 'Čavajda', 'dcavajda@edunova.hr', '$2y$12$Lt6Q93g3wRpalZ3TSD8Pi.IrcywISe7ctwSFCYMptjN8pRuIoFM72', 'admin');

insert into operater values 
(null,'operater', 'edunova' 'oper@edunova.hr',
'$2y$12$VR0bNVQMB05iablvXDUf9eP5rJd8/yeBPot3VTHSMOyuJMcfK7b6C',
'oper');

create table legal_case(
legal_case_id int not null primary key auto_increment,
lawyer int NOT NULL,
client int NOT NULL,
legal_case_code varchar (50),
case_date_start date,
case_date_end date
);
create table lawyer(
lawyer_id int not null primary key auto_increment,
firstname varchar (50),
lastname varchar(50),
IBAN varchar (32),
OIB char(11),
opis text,
);
create table client (
client_id int not null primary key auto_increment,
firstname varchar (50),                                                                                                                                              
lastname varchar (50),
IBAN varchar (32),
OIB char(11)
);
create table legal_trainee (
legal_trainee_id int not null primary key auto_increment,
firstname varchar (50),
lastname varchar (50),
IBAN varchar (32),
OIB char(11)
);
CREATE TABLE legal_case_trainee (
legal_case_id int not null,
legal_trainee_id int not null
);

ALTER TABLE legal_case ADD FOREIGN KEY (lawyer) REFERENCES lawyer (lawyer_id);
ALTER TABLE legal_case ADD FOREIGN KEY (client) REFERENCES client (client_id);

ALTER TABLE legal_case_trainee ADD FOREIGN KEY (legal_case_id) REFERENCES legal_case (legal_case_id);
ALTER TABLE legal_case_trainee ADD FOREIGN KEY (legal_trainee_id) REFERENCES legal_trainee (legal_trainee_id);

INSERT INTO client
(firstname, lastname, `IBAN`, `OIB`)
VALUES
('Ivan', 'Horvat', 'HR1234567891234567890', '4150008463'),
('Ivana', 'Babić', 'HR1234567891234512345', '765012345');

INSERT INTO lawyer
(firstname, lastname, `IBAN`, `OIB`)
VALUES
('Čedo', 'Prodanović', '12345698765', '541235478'),
('Jadranka', 'Sloković', '12345698725', '6541235410');

INSERT INTO legal_trainee
(firstname, lastname, `IBAN`, `OIB`)
VALUES
('Đuro', 'Prtenjača', 'HR3216549874563214568', '52364178'),
('Žaneta', 'Zgombić', 'HR3216549874563215462', '2364100');

INSERT INTO legal_case
(lawyer, client, legal_case_code, case_date_start, case_date_end)
VALUES
(1,1,'PP00123456','1999.05.22', '2000.05.22');



