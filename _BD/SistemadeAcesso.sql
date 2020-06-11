
Create table alunos (
	alu_id Int NOT NULL AUTO_INCREMENT,
	alu_nome Varchar(40),
	alu_curso Varchar(30),
	alu_email Varchar(50),
 Primary Key (alu_id)) ENGINE = INNODB;

 Create table tipos_eventos (
	tiev_id Int NOT NULL AUTO_INCREMENT,
	tiev_descricao Varchar(30),
 Primary Key (tiev_id)) ENGINE = INNODB;

  Create table eventos (
	ev_id Int NOT NULL AUTO_INCREMENT,
	ev_tiev_id Int NOT NULL,
	ev_nome Varchar(30),
	ev_responsavel Varchar(30),
	ev_horas Int,
	ev_data date,
	ev_hora_inicio time,
	ev_hora_fim time,
 Primary Key (ev_id)) ENGINE = INNODB;


-- Alter table Alunos add Foreign Key (sis_id) references Sistema (sis_id) on delete  restrict on update  restrict;
-- Alter table Palestras add Foreign Key (sis_id) references Sistema (sis_id) on delete  restrict on update  restrict;



