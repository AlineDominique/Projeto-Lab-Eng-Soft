-- MySQL Workbench Forward Engineering

DROP DATABASE `BDVeg`;
CREATE DATABASE `BDVeg` IF NOT EXISTS 
USE DATABASE `BDVeg`
-- -----------------------------------------------------
-- Table `Usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Usuario` ;

CREATE TABLE IF NOT EXISTS `Usuario` (
  `idUsuario` INT NOT NULL,
  `NomeUsuario` VARCHAR(100) NULL,
  `Email` VARCHAR(200) NULL,
  `Senha` VARCHAR(45) NULL,
  PRIMARY KEY (`idUsuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Receita`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Receita` ;

CREATE TABLE IF NOT EXISTS `Receita` (
  `idReceita` INT NOT NULL,
  `NomeReceita` VARCHAR(100) NOT NULL,
  `TempodePreparo` VARCHAR(100) NOT NULL,
  `Porcoes` VARCHAR(100) NOT NULL,
  `Categoria` VARCHAR(120) NOT NULL,
  `Usuario_idUsuario` INT NOT NULL,
  `MododePreparo` VARCHAR(3000) NOT NULL,
  `Dicas` VARCHAR(300) NULL,
  PRIMARY KEY (`idReceita`, `Usuario_idUsuario`),
  CONSTRAINT `fk_Receita_Usuario`
    FOREIGN KEY (`Usuario_idUsuario`)
    REFERENCES `Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Ingredientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Ingredientes` ;

CREATE TABLE IF NOT EXISTS `Ingredientes` (
  `idIngredientes` INT NOT NULL,
  `Quantidade` VARCHAR(45) NOT NULL,
  `UnidMedida` VARCHAR(45) NOT NULL,
  `Observacao` VARCHAR(100) NULL,
  `NomeIngredientes` VARCHAR(100) NULL,
  `Receita_idReceita` INT NOT NULL,
  PRIMARY KEY (`idIngredientes`),
  CONSTRAINT `fk_Ingredientes_Receita1`
    FOREIGN KEY (`Receita_idReceita`)
    REFERENCES `Receita` (`idReceita`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ReceitasFav`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ReceitasFav` ;

CREATE TABLE IF NOT EXISTS `ReceitasFav` (
  `Usuario_idUsuario` INT NOT NULL,
  `Receita_idReceita` INT NOT NULL,
  PRIMARY KEY (`Usuario_idUsuario`, `Receita_idReceita`),
  CONSTRAINT `fk_ReceitasFav_Usuario1`
    FOREIGN KEY (`Usuario_idUsuario`)
    REFERENCES `Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ReceitasFav_Receita1`
    FOREIGN KEY (`Receita_idReceita`)
    REFERENCES `Receita` (`idReceita`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

