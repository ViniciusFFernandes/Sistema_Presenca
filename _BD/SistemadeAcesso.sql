
Create table Alunos (
	alunos_id Int NOT NULL AUTO_INCREMENT,
	nome_alu Varchar(100),
	curso_alu Varchar(100),
	email_alu Varchar(100),
 Primary Key (alunos_id)) ENGINE = INNODB;


-- Alter table Alunos add Foreign Key (sis_id) references Sistema (sis_id) on delete  restrict on update  restrict;
-- Alter table Palestras add Foreign Key (sis_id) references Sistema (sis_id) on delete  restrict on update  restrict;



