-- MySQL Script generated by MySQL Workbench
-- Sat Jul 20 16:58:16 2024
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema EventControlDB
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema EventControlDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `EventControlDB` ;
USE `EventControlDB` ;

-- -----------------------------------------------------
-- Table `EventControlDB`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EventControlDB`.`Usuario` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `nome` VARCHAR(45) NOT NULL,
  `role_id` INT NOT NULL,
  PRIMARY KEY (`id_usuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EventControlDB`.`Estudante`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EventControlDB`.`Estudante` (
  `matricula` INT NOT NULL,
  `pontuacao` INT NULL,
  `id_usuario` INT NOT NULL,
  PRIMARY KEY (`matricula`),
  INDEX `fk_Estudante_Usuario1_idx` (`id_usuario` ASC) VISIBLE,
  CONSTRAINT `fk_Estudante_Usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `EventControlDB`.`Usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EventControlDB`.`Administrador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EventControlDB`.`Administrador` (
  `id_administrador` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NOT NULL,
  PRIMARY KEY (`id_administrador`),
  INDEX `fk_Administrador_Usuario1_idx` (`id_usuario` ASC) VISIBLE,
  CONSTRAINT `fk_Administrador_Usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `EventControlDB`.`Usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EventControlDB`.`Curso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EventControlDB`.`Curso` (
  `idCurso` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(45) NOT NULL,
  `descricao` TEXT NOT NULL,
  `data_criacao` DATE NOT NULL,
  `id_administrador` INT NOT NULL,
  PRIMARY KEY (`idCurso`),
  INDEX `fk_Curso_Administrador1_idx` (`id_administrador` ASC) VISIBLE,
  CONSTRAINT `fk_Curso_Administrador1`
    FOREIGN KEY (`id_administrador`)
    REFERENCES `EventControlDB`.`Administrador` (`id_administrador`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EventControlDB`.`Evento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EventControlDB`.`Evento` (
  `id_evento` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `descricao` TEXT NOT NULL,
  `quantidade_cursos` INT NOT NULL,
  `data_inicio` DATE NOT NULL,
  `data_fim` DATE NOT NULL,
  `encerrado` INT NOT NULL,
  `local` VARCHAR(45) NOT NULL,
  `data_criacao` DATE NOT NULL,
  `id_administrador` INT NOT NULL,
  `imagem` LONGBLOB NOT NULL,
  PRIMARY KEY (`id_evento`),
  INDEX `fk_Evento_Administrador1_idx` (`id_administrador` ASC) VISIBLE,
  CONSTRAINT `fk_Evento_Administrador1`
    FOREIGN KEY (`id_administrador`)
    REFERENCES `EventControlDB`.`Administrador` (`id_administrador`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EventControlDB`.`Cursos Evento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EventControlDB`.`Cursos_Evento` (
  `id_evento` INT NOT NULL,
  `id_curso` INT NOT NULL,
  `quantidade_vagas` INT NOT NULL,
  `quantidade_inscritos` INT NOT NULL,
  `id_administrador` INT NOT NULL,
  `data` DATE NOT NULL,
  `horario_inicio` DATETIME NOT NULL,
  `horario_fim` DATETIME NOT NULL,
  `data_criacao` DATE NOT NULL,
  PRIMARY KEY (`id_evento`, `id_curso`),
  INDEX `fk_Evento_has_Curso_Curso1_idx` (`id_curso` ASC) VISIBLE,
  INDEX `fk_Evento_has_Curso_Evento_idx` (`id_evento` ASC) VISIBLE,
  INDEX `fk_Cursos Evento_Administrador1_idx` (`id_administrador` ASC) VISIBLE,
  CONSTRAINT `fk_Evento_has_Curso_Evento`
    FOREIGN KEY (`id_evento`)
    REFERENCES `EventControlDB`.`Evento` (`id_evento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Evento_has_Curso_Curso1`
    FOREIGN KEY (`id_curso`)
    REFERENCES `EventControlDB`.`Curso` (`idCurso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cursos Evento_Administrador1`
    FOREIGN KEY (`id_administrador`)
    REFERENCES `EventControlDB`.`Administrador` (`id_administrador`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EventControlDB`.`Estudante Cursos Evento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EventControlDB`.`Estudante_Cursos_Evento` (
  `matricula` INT NOT NULL,
  `id_evento` INT NOT NULL,
  `id_curso` INT NOT NULL,
  `pontuacao` INT NOT NULL,
  PRIMARY KEY (`matricula`, `id_evento`, `id_curso`),
  INDEX `fk_Estudante_has_Cursos Evento_Cursos Evento1_idx` (`id_evento` ASC, `id_curso` ASC) VISIBLE,
  INDEX `fk_Estudante_has_Cursos Evento_Estudante1_idx` (`matricula` ASC) VISIBLE,
  CONSTRAINT `fk_Estudante_has_Cursos Evento_Estudante1`
    FOREIGN KEY (`matricula`)
    REFERENCES `EventControlDB`.`Estudante` (`matricula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Estudante_has_Cursos Evento_Cursos Evento1`
    FOREIGN KEY (`id_evento` , `id_curso`)
    REFERENCES `EventControlDB`.`Cursos Evento` (`id_evento` , `id_curso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
