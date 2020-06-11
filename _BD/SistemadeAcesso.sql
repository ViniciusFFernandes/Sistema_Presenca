
Create table alunos (
	alu_id Int NOT NULL AUTO_INCREMENT,
	alu_nome Varchar(100),
	alu_curso Varchar(100),
	alu_email Varchar(100),
 Primary Key (alu_id)) ENGINE = INNODB;

 Create table tipos_eventos (
	tiev_id Int NOT NULL AUTO_INCREMENT,
	tiev_descricao Varchar(100),
 Primary Key (tiev_id)) ENGINE = INNODB;


-- Alter table Alunos add Foreign Key (sis_id) references Sistema (sis_id) on delete  restrict on update  restrict;
-- Alter table Palestras add Foreign Key (sis_id) references Sistema (sis_id) on delete  restrict on update  restrict;



