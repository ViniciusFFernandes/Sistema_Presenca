/*
Created		04/07/2019
Modified		11/07/2019
Project		
Model		
Company		
Author		
Version		
Database		mySQL 4.1 
*/


Create table Alunos (
	alunos_id Int NOT NULL,
	nome_alu Varchar(50),
	curso_alu Varchar(30),
	ra_alu Char(10),
	sis_id Int,
 Primary Key (alunos_id)) ENGINE = InnoDB;

Create table Sistema (
	sis_id Int NOT NULL,
	nome_curso Varchar(40),
	nome_pale Varchar(50),
	nome_mini Varchar(50),
 Primary Key (sis_id)) ENGINE = InnoDB;

Create table Palestras (
	pale_id Int NOT NULL,
	nome_pale Varchar(50),
	sis_id Int,
 Primary Key (pale_id)) ENGINE = InnoDB;

Create table Minicursos (
	mini_id Int NOT NULL,
	nome_mini Varchar(50),
	sis_id Int NOT NULL,
 Primary Key (mini_id)) ENGINE = InnoDB;

Create table Banco_de_Dados (
	dados_id Int NOT NULL,
	pres_alu Varchar(40),
	mini_alu Varchar(40),
	qtde_horasinicial Char(20),
	qtde_horasfinal Char(20),
	qtde_horastotal Char(20),
	sis_id Int NOT NULL,
 Primary Key (dados_id)) ENGINE = InnoDB;

Create table Cadastro_de_Presen_a (
	pre_id Int NOT NULL,
	numero_pre Char(15),
	nome_alu Varchar(50),
	ra_alu Char(10),
	nome_curso Varchar(30),
	dados_id Int,
 Primary Key (pre_id)) ENGINE = InnoDB;

Create table Cadastrar_de_Minicursos (
	mini_id Int NOT NULL,
	nome_alu Varchar(40),
	nome_curso Varchar(30),
	ra_alu Char(15),
	dados_id Int,
 Primary Key (mini_id)) ENGINE = InnoDB;


Alter table Alunos add Foreign Key (sis_id) references Sistema (sis_id) on delete  restrict on update  restrict;
Alter table Palestras add Foreign Key (sis_id) references Sistema (sis_id) on delete  restrict on update  restrict;
Alter table Minicursos add Foreign Key (sis_id) references Sistema (sis_id) on delete  restrict on update  restrict;
Alter table Banco_de_Dados add Foreign Key (sis_id) references Sistema (sis_id) on delete  restrict on update  restrict;
Alter table Cadastrar_de_Minicursos add Foreign Key (dados_id) references Banco_de_Dados (dados_id) on delete  restrict on update  restrict;
Alter table Cadastro_de_Presen_a add Foreign Key (dados_id) references Banco_de_Dados (dados_id) on delete  restrict on update  restrict;


/* Users permissions */


