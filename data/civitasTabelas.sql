SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema civitas
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `civitas` DEFAULT CHARACTER SET utf8 ;
USE `civitas` ;

-- -----------------------------------------------------
-- Table `civitas`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `civitas`.`usuarios` (
  `idusuario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `usuario` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `dataNasc` DATE NOT NULL,
  `cpf` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `imgPerfil` MEDIUMBLOB NOT NULL,
  `tipo` INT NOT NULL DEFAULT '2',
  PRIMARY KEY (`idusuario`))
ENGINE = InnoDB;
INSERT INTO `usuarios`(`idusuario`, `nome`, `usuario`, `email`, `dataNasc`, `cpf`, `senha`, `imgPerfil`, `tipo`) 
VALUES ('1','admin','admin','null','2003-03-07','0','admin','null','1');

-- -----------------------------------------------------
-- Table `civitas`.`generoProduto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `civitas`.`generoProduto` (
  `idgeneroProduto` INT NOT NULL AUTO_INCREMENT,
  `genero` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idgeneroProduto`))
ENGINE = InnoDB;
INSERT INTO `civitas`.`generoProduto` (`idgeneroProduto`, `genero`) VALUES
(1, 'Suspense'),
(2, 'Drama'),
(3, 'Policial'),
(4, 'Histórico'),
(5, 'Ficção Científica'),
(6, 'Biográfico'),
(7, 'Aventura'),
(8, 'Ação'),
(9, 'Guerra'),
(10, 'Fantasia'),
(11, 'Animação'),
(12, 'Terror'),
(13, 'Mistério'),
(14, 'Musical'),
(15, 'Romance'),
(16, 'Comédia');

-- -----------------------------------------------------
-- Table `civitas`.`tipoProduto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `civitas`.`tipoProduto` (
  `idtipoProduto` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idtipoProduto`))
ENGINE = InnoDB;
INSERT INTO `civitas`.`tipoProduto` (`idtipoProduto`, `tipo`) VALUES
(1, 'Livro'),
(2, 'Filme'),
(3, 'Série');

-- -----------------------------------------------------
-- Table `civitas`.`produtoCultural`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `civitas`.`produtoCultural` (
  `idproduto` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(45) NOT NULL,
  `autor` VARCHAR(45) NOT NULL,
  `descricao` MEDIUMTEXT NOT NULL,
  `capa` MEDIUMBLOB NOT NULL,
  `idGenero` INT NOT NULL,
  `idTipo` INT NOT NULL,
  `sugestao` INT NOT NULL,
  PRIMARY KEY (`idproduto`),
  INDEX `fk_produtoCultural_generoProduto1_idx` (`idGenero` ASC),
  INDEX `fk_produtoCultural_tipoProduto1_idx` (`idTipo` ASC),
  CONSTRAINT `fk_produtoCultural_generoProduto1`
    FOREIGN KEY (`idGenero`)
    REFERENCES `civitas`.`generoProduto` (`idgeneroProduto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_produtoCultural_tipoProduto1`
    FOREIGN KEY (`idTipo`)
    REFERENCES `civitas`.`tipoProduto` (`idtipoProduto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `civitas`.`livro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `civitas`.`livro` (
  `produtoCultural_idproduto` INT NOT NULL,
  PRIMARY KEY (`produtoCultural_idproduto`),
  CONSTRAINT `fk_livro_produtoCultural1`
    FOREIGN KEY (`produtoCultural_idproduto`)
    REFERENCES `civitas`.`produtoCultural` (`idproduto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `civitas`.`publicacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `civitas`.`publicacao` (
  `idpublicacao` INT NOT NULL AUTO_INCREMENT,
  `dataPublicacao` DATE NOT NULL,
  `produtoCultural_idproduto` INT NOT NULL,
  `Usuario_idusuario` INT NOT NULL,
  `tema` VARCHAR(45) NOT NULL,
  `comentario` TEXT(1000) NOT NULL,
  `avaliacao` FLOAT NOT NULL,
  PRIMARY KEY (`idpublicacao`),
  INDEX `fk_publicacao_produtoCultural1_idx` (`produtoCultural_idproduto` ASC),
  INDEX `fk_publicacao_Usuario1_idx` (`Usuario_idusuario` ASC),
  CONSTRAINT `fk_publicacao_produtoCultural1`
    FOREIGN KEY (`produtoCultural_idproduto`)
    REFERENCES `civitas`.`produtoCultural` (`idproduto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_publicacao_Usuario1`
    FOREIGN KEY (`Usuario_idusuario`)
    REFERENCES `civitas`.`usuarios` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `civitas`.`interesse`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `civitas`.`interesse` (
  `idInteresse` INT NOT NULL AUTO_INCREMENT,
  `Usuario_idusuario` INT NOT NULL,
  `livro_produtoCultural_idproduto` INT NOT NULL,
  INDEX `fk_interessados_livro1_idx` (`livro_produtoCultural_idproduto` ASC),
  PRIMARY KEY (`idInteresse`),
  CONSTRAINT `fk_interessados_Usuario1`
    FOREIGN KEY (`Usuario_idusuario`)
    REFERENCES `civitas`.`usuarios` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_interessados_livro1`
    FOREIGN KEY (`livro_produtoCultural_idproduto`)
    REFERENCES `civitas`.`livro` (`produtoCultural_idproduto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
