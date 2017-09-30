-- MySQL Workbench Forward Engineering

CREATE DATABASE IF NOT EXISTS `dbvegs` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `dbvegs`;

-- -----------------------------------------------------
-- Table `Usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Usuario` ;

CREATE TABLE IF NOT EXISTS `Usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `NomeUsuario` VARCHAR(100) NULL,
  `Email` VARCHAR(200) NULL,
  PRIMARY KEY (`idUsuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Categoria` ;

CREATE TABLE IF NOT EXISTS `Categoria` (
  `idCategoria` INT NOT NULL AUTO_INCREMENT,
  `NomeCategoria` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`idCategoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Receita`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Receita` ;

CREATE TABLE IF NOT EXISTS `Receita` (
  `idReceita` INT NOT NULL AUTO_INCREMENT,
  `NomeReceita` VARCHAR(100) NOT NULL,
  `TempodePreparo` VARCHAR(100) NOT NULL,
  `Porcoes` VARCHAR(100) NOT NULL,
  `Categoria` VARCHAR(120) NOT NULL,
  `idUsuario` INT NOT NULL,
  `MododePreparo` VARCHAR(3000) NOT NULL,
  `Dicasl` VARCHAR(300) NULL,
  `idCategoria` INT NOT NULL,
  PRIMARY KEY (`idReceita`),
  CONSTRAINT `fk_Receita_Usuario`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Receita_Categoria1`
    FOREIGN KEY (`idCategoria`)
    REFERENCES `Categoria` (`idCategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Ingredientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Ingredientes` ;

CREATE TABLE IF NOT EXISTS `Ingredientes` (
  `idIngredientes` INT NOT NULL AUTO_INCREMENT,
  `Quantidade` VARCHAR(45) NOT NULL,
  `UnidMedida` VARCHAR(45) NOT NULL,
  `Observacao` VARCHAR(100) NULL,
  `NomeIngredientes` VARCHAR(100) NULL,
  `idReceita` INT NOT NULL,
  PRIMARY KEY (`idIngredientes`),
    CONSTRAINT `fk_Ingredientes_Receita1`
    FOREIGN KEY (`idReceita`)
    REFERENCES `Receita` (`idReceita`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ReceitasFav`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ReceitasFav` ;

CREATE TABLE IF NOT EXISTS `ReceitasFav` (
  `idUsuario` INT NOT NULL,
  `idReceita` INT NOT NULL,
  PRIMARY KEY (`idUsuario`, `idReceita`),
  CONSTRAINT `fk_ReceitasFav_Usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ReceitasFav_Receita1`
    FOREIGN KEY (`idReceita`)
    REFERENCES `Receita` (`idReceita`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

