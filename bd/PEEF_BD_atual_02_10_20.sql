-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema PEEF_BD
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema PEEF_BD
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `PEEF_BD` DEFAULT CHARACTER SET utf8 ;
USE `PEEF_BD` ;

-- -----------------------------------------------------
-- Table `PEEF_BD`.`LANGUAGE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`LANGUAGE` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`SIS_LANGUAGE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`SIS_LANGUAGE` (
  `id` INT NULL AUTO_INCREMENT,
  `cod` VARCHAR(45) NOT NULL DEFAULT 'eng',
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`PROFESSOR`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`PROFESSOR` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL DEFAULT NULL,
  `email` VARCHAR(100) NULL DEFAULT NULL,
  `password` VARCHAR(45) NULL DEFAULT NULL,
  `bio` LONGTEXT NULL DEFAULT NULL,
  `institution` VARCHAR(100) NULL DEFAULT NULL,
  `Language_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_PROFESSOR_LANGUAGE1_idx` (`Language_id` ASC),
  CONSTRAINT `fk_PROFESSOR_LANGUAGE1`
    FOREIGN KEY (`Language_id`)
    REFERENCES `PEEF_BD`.`SIS_LANGUAGE` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`COURSE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`COURSE` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `accesskey` VARCHAR(45) NULL DEFAULT NULL,
  `Professor_id` INT(11) NOT NULL,
  `Language_id` INT(11) NULL DEFAULT '1',
  `code` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `code_UNIQUE` (`code` ASC),
  INDEX `fk_curso_Professor1_idx` (`Professor_id` ASC),
  INDEX `fk_Curso_Linguagem1_idx` (`Language_id` ASC),
  CONSTRAINT `fk_Curso_Linguagem1`
    FOREIGN KEY (`Language_id`)
    REFERENCES `PEEF_BD`.`LANGUAGE` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_curso_Professor1`
    FOREIGN KEY (`Professor_id`)
    REFERENCES `PEEF_BD`.`PROFESSOR` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`ACTIVITY`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`ACTIVITY` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `description` TEXT NULL DEFAULT NULL,
  `image` VARCHAR(100) NULL DEFAULT NULL,
  `title` VARCHAR(100) NULL DEFAULT NULL,
  `Course_id` INT(11) NOT NULL,
  `description_input` TEXT NULL,
  `description_output` TEXT NULL,
  `date_creation` DATE NULL DEFAULT CURDATE(),
  `data_delivery` DATE NULL DEFAULT NULL,
  `show_after` DATE NULL DEFAULT NULL COMMENT 'se tiver uma data, os sitema n exibirá até a data. Se for null, o sistema exibirá sem restrição.',
  PRIMARY KEY (`id`),
  INDEX `fk_Activity_Course1_idx` (`Course_id` ASC),
  CONSTRAINT `fk_Activity_Course1`
    FOREIGN KEY (`Course_id`)
    REFERENCES `PEEF_BD`.`COURSE` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`CATEGORY`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`CATEGORY` (
  `category_id` INT(11) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`category_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`CLASSES`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`CLASSES` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NULL DEFAULT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `url` VARCHAR(200) NULL DEFAULT NULL,
  `Course_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Classes_Course1_idx` (`Course_id` ASC),
  CONSTRAINT `fk_Classes_Course1`
    FOREIGN KEY (`Course_id`)
    REFERENCES `PEEF_BD`.`COURSE` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`STUDENT`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`STUDENT` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL DEFAULT NULL,
  `email` VARCHAR(100) NULL DEFAULT NULL,
  `password` VARCHAR(45) NULL DEFAULT NULL,
  `bio` VARCHAR(200) NULL DEFAULT NULL,
  `Language_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_STUDENT_LANGUAGE1_idx` (`Language_id` ASC),
  CONSTRAINT `fk_STUDENT_LANGUAGE1`
    FOREIGN KEY (`Language_id`)
    REFERENCES `PEEF_BD`.`SIS_LANGUAGE` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`ENROLLMENT`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`ENROLLMENT` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `Student_id` INT(11) NOT NULL,
  `Course_id` INT(11) NOT NULL,
  `enhancedmessage` INT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `fk_curso_has_Estudante_Estudante1_idx` (`Student_id` ASC),
  INDEX `fk_Matricula_Curso1_idx` (`Course_id` ASC),
  CONSTRAINT `fk_Matricula_Curso1`
    FOREIGN KEY (`Course_id`)
    REFERENCES `PEEF_BD`.`COURSE` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_curso_has_Estudante_Estudante1`
    FOREIGN KEY (`Student_id`)
    REFERENCES `PEEF_BD`.`STUDENT` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`STATE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`STATE` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`PROJECT`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`PROJECT` (
  `id` INT(11) NULL AUTO_INCREMENT,
  `creationdate` DATE NOT NULL,
  `date_lastmodification` DATE NOT NULL,
  `hours_lastmodification` TIME NOT NULL,
  `enhancedmessage` TINYINT(4) NULL DEFAULT '1',
  `sended` TINYINT(4) NULL DEFAULT 0,
  `iscorret` TINYINT(4) NULL DEFAULT NULL,
  `Enrollment_id` INT(11) NOT NULL,
  `Estado_idEstado` INT(11) NULL DEFAULT 1,
  `Activity_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Matricula_has_Atividade_Matricula1_idx` (`Enrollment_id` ASC),
  INDEX `fk_Projeto_Estado1_idx` (`Estado_idEstado` ASC),
  INDEX `fk_PROJECT_ACTIVITY1_idx` (`Activity_id` ASC),
  CONSTRAINT `fk_Matricula_has_Atividade_Matricula1`
    FOREIGN KEY (`Enrollment_id`)
    REFERENCES `PEEF_BD`.`ENROLLMENT` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Projeto_Estado1`
    FOREIGN KEY (`Estado_idEstado`)
    REFERENCES `PEEF_BD`.`STATE` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PROJECT_ACTIVITY1`
    FOREIGN KEY (`Activity_id`)
    REFERENCES `PEEF_BD`.`ACTIVITY` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`CODE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`CODE` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL DEFAULT NULL,
  `code` LONGTEXT NULL DEFAULT NULL,
  `Project_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Code_Project1_idx` (`Project_id` ASC),
  CONSTRAINT `fk_Code_Project1`
    FOREIGN KEY (`Project_id`)
    REFERENCES `PEEF_BD`.`PROJECT` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`COMPILATION`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`COMPILATION` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `hours` TIME NOT NULL,
  `erromessage` LONGTEXT NULL DEFAULT NULL,
  `Code_id` INT(11) NOT NULL,
  `typeError` VARCHAR(100) NULL DEFAULT NULL,
  `lineError` VARCHAR(100) NULL DEFAULT NULL,
  `compMessage` VARCHAR(100) NULL DEFAULT NULL,
  `testpassed` INT NULL DEFAULT -1,
  `enhancedmessagefound` INT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_Compilation_Code1_idx` (`Code_id` ASC),
  CONSTRAINT `fk_Compilation_Code1`
    FOREIGN KEY (`Code_id`)
    REFERENCES `PEEF_BD`.`CODE` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 17
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`CODECOMPILATION`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`CODECOMPILATION` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL DEFAULT NULL,
  `code` LONGTEXT NULL DEFAULT NULL,
  `linesedited` TINYINT(4) NULL DEFAULT '0',
  `Compilation_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_codigo_comp_compilacao1_idx` (`Compilation_id` ASC),
  CONSTRAINT `fk_codigo_comp_compilacao1`
    FOREIGN KEY (`Compilation_id`)
    REFERENCES `PEEF_BD`.`COMPILATION` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 17
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`COURSE_HAS_ACTIVITY`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`COURSE_HAS_ACTIVITY` (
  `Activity_id` INT(11) NOT NULL,
  `Course_id` INT(11) NOT NULL,
  PRIMARY KEY (`Activity_id`, `Course_id`),
  INDEX `fk_Atividade_has_Curso_Curso1_idx` (`Course_id` ASC),
  INDEX `fk_Atividade_has_Curso_Atividade1_idx` (`Activity_id` ASC),
  CONSTRAINT `fk_Atividade_has_Curso_Atividade1`
    FOREIGN KEY (`Activity_id`)
    REFERENCES `PEEF_BD`.`ACTIVITY` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Atividade_has_Curso_Curso1`
    FOREIGN KEY (`Course_id`)
    REFERENCES `PEEF_BD`.`COURSE` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`ENHANCEDMESSAGE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`ENHANCEDMESSAGE` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(100) NULL DEFAULT NULL,
  `subtype` VARCHAR(200) NULL DEFAULT NULL,
  `enhacedmessage` VARCHAR(45) NULL DEFAULT NULL,
  `linktutorial` VARCHAR(45) NULL DEFAULT NULL,
  `Language_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Mensagens_Melhoradas_Linguagem1_idx` (`Language_id` ASC),
  CONSTRAINT `fk_Mensagens_Melhoradas_Linguagem1`
    FOREIGN KEY (`Language_id`)
    REFERENCES `PEEF_BD`.`LANGUAGE` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`LINEEDITED`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`LINEEDITED` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `line` INT(11) NULL DEFAULT NULL,
  `diff` INT(11) NULL DEFAULT NULL,
  `CodeCompilation_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_LineEdited_CodeCompilation1_idx` (`CodeCompilation_id` ASC),
  CONSTRAINT `fk_LineEdited_CodeCompilation1`
    FOREIGN KEY (`CodeCompilation_id`)
    REFERENCES `PEEF_BD`.`CODECOMPILATION` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 39
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`MESSAGE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`MESSAGE` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `text` LONGTEXT NULL DEFAULT NULL,
  `fromprofessor` TINYINT(4) NULL DEFAULT NULL,
  `date` DATE NULL DEFAULT NULL,
  `horas` TIME NULL DEFAULT NULL,
  `Professor_id` INT(11) NOT NULL,
  `Project_id` INT(11) NOT NULL,
  `hasview` TINYINT(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Mensagem_Professor1_idx` (`Professor_id` ASC),
  INDEX `fk_Message_Project1_idx` (`Project_id` ASC),
  CONSTRAINT `fk_Mensagem_Professor1`
    FOREIGN KEY (`Professor_id`)
    REFERENCES `PEEF_BD`.`PROFESSOR` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Message_Project1`
    FOREIGN KEY (`Project_id`)
    REFERENCES `PEEF_BD`.`PROJECT` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`TEST`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`TEST` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `input` TEXT NULL DEFAULT NULL,
  `output` TEXT NULL DEFAULT NULL,
  `Activity_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_testes_Atividade1_idx` (`Activity_id` ASC),
  CONSTRAINT `fk_testes_Atividade1`
    FOREIGN KEY (`Activity_id`)
    REFERENCES `PEEF_BD`.`ACTIVITY` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`ACTION`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`ACTION` (
  `id` INT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PEEF_BD`.`LOG`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PEEF_BD`.`LOG` (
  `id` INT NULL AUTO_INCREMENT,
  `Action_id` INT NOT NULL,
  `Student_id` INT(11) NOT NULL,
  `date` DATE NULL,
  `hours` TIME NULL,
  `id_ref` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Log_Status1_idx` (`Action_id` ASC),
  INDEX `fk_LOG_STUDENT1_idx` (`Student_id` ASC),
  CONSTRAINT `fk_Log_Status1`
    FOREIGN KEY (`Action_id`)
    REFERENCES `PEEF_BD`.`ACTION` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_LOG_STUDENT1`
    FOREIGN KEY (`Student_id`)
    REFERENCES `PEEF_BD`.`STUDENT` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `PEEF_BD`.`LANGUAGE`
-- -----------------------------------------------------
START TRANSACTION;
USE `PEEF_BD`;
INSERT INTO `PEEF_BD`.`LANGUAGE` (`id`, `name`) VALUES (1, 'Python');
INSERT INTO `PEEF_BD`.`LANGUAGE` (`id`, `name`) VALUES (2, 'Java');
INSERT INTO `PEEF_BD`.`LANGUAGE` (`id`, `name`) VALUES (3, 'Javascript');
INSERT INTO `PEEF_BD`.`LANGUAGE` (`id`, `name`) VALUES (4, 'C');

COMMIT;


-- -----------------------------------------------------
-- Data for table `PEEF_BD`.`SIS_LANGUAGE`
-- -----------------------------------------------------
START TRANSACTION;
USE `PEEF_BD`;
INSERT INTO `PEEF_BD`.`SIS_LANGUAGE` (`id`, `cod`) VALUES (1, 'eng');
INSERT INTO `PEEF_BD`.`SIS_LANGUAGE` (`id`, `cod`) VALUES (2, 'pt-br');

COMMIT;


-- -----------------------------------------------------
-- Data for table `PEEF_BD`.`PROFESSOR`
-- -----------------------------------------------------
START TRANSACTION;
USE `PEEF_BD`;
INSERT INTO `PEEF_BD`.`PROFESSOR` (`id`, `name`, `email`, `password`, `bio`, `institution`, `Language_id`) VALUES (1, 'Professor Teste', 'teste@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Usuário Teste', 'TESTE', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `PEEF_BD`.`COURSE`
-- -----------------------------------------------------
START TRANSACTION;
USE `PEEF_BD`;
INSERT INTO `PEEF_BD`.`COURSE` (`id`, `name`, `accesskey`, `Professor_id`, `Language_id`, `code`) VALUES (1, 'Curso Teste', 'Teste', 1, 1, 'CTEST20');

COMMIT;


-- -----------------------------------------------------
-- Data for table `PEEF_BD`.`ACTIVITY`
-- -----------------------------------------------------
START TRANSACTION;
USE `PEEF_BD`;
INSERT INTO `PEEF_BD`.`ACTIVITY` (`id`, `description`, `image`, `title`, `Course_id`, `description_input`, `description_output`, `date_creation`, `data_delivery`, `show_after`) VALUES (1, 'Escreva um algoritmo para calcular a soma de dois numeros A e B.', 'teste.png', 'Atividade 01', 1, 'Dois valores inteiros', 'Imprima o valor da soma. Cuide para que tenha um espaco antes e depois do sinal de igualdade, conforme o exemplo abaixo.', NULL, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `PEEF_BD`.`CLASSES`
-- -----------------------------------------------------
START TRANSACTION;
USE `PEEF_BD`;
INSERT INTO `PEEF_BD`.`CLASSES` (`id`, `title`, `description`, `url`, `Course_id`) VALUES (1, 'Whats is Pyhon', 'In this classe you will learn whats is Python.', 'M7lc1UVf-VE', 1);
INSERT INTO `PEEF_BD`.`CLASSES` (`id`, `title`, `description`, `url`, `Course_id`) VALUES (2, 'Variabel in Python', 'In this classe will you learn whats is variabel and types in Python.', 'V1VlbXByUyQ', 1);
INSERT INTO `PEEF_BD`.`CLASSES` (`id`, `title`, `description`, `url`, `Course_id`) VALUES (3, 'Conditional in Python', 'In this classe will you whats is conditional in Python.', 'https://www.youtube.com/watch?v=V1VlbXByUyQ&t=63s', 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `PEEF_BD`.`STUDENT`
-- -----------------------------------------------------
START TRANSACTION;
USE `PEEF_BD`;
INSERT INTO `PEEF_BD`.`STUDENT` (`id`, `name`, `email`, `password`, `bio`, `Language_id`) VALUES (1, 'Teste', 'teste@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Usuário Teste', NULL);
INSERT INTO `PEEF_BD`.`STUDENT` (`id`, `name`, `email`, `password`, `bio`, `Language_id`) VALUES (2, 'Teste2', 'teste2@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Usuário Teste', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `PEEF_BD`.`ENROLLMENT`
-- -----------------------------------------------------
START TRANSACTION;
USE `PEEF_BD`;
INSERT INTO `PEEF_BD`.`ENROLLMENT` (`id`, `Student_id`, `Course_id`, `enhancedmessage`) VALUES (1, 1, 1, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `PEEF_BD`.`STATE`
-- -----------------------------------------------------
START TRANSACTION;
USE `PEEF_BD`;
INSERT INTO `PEEF_BD`.`STATE` (`id`, `name`) VALUES (1, 'Developing');
INSERT INTO `PEEF_BD`.`STATE` (`id`, `name`) VALUES (2, 'Delivered');
INSERT INTO `PEEF_BD`.`STATE` (`id`, `name`) VALUES (3, 'Abandoned');

COMMIT;


-- -----------------------------------------------------
-- Data for table `PEEF_BD`.`ENHANCEDMESSAGE`
-- -----------------------------------------------------
START TRANSACTION;
USE `PEEF_BD`;
INSERT INTO `PEEF_BD`.`ENHANCEDMESSAGE` (`id`, `type`, `subtype`, `enhacedmessage`, `linktutorial`, `Language_id`) VALUES (1, 'SyntaxError', 'invalid syntax', 'Ocorreu um erro de Sintaxe. Isso significa que no seu código há um padrão não reconhecido pelo Python. Verifique se falta algum parentese em comando como if, while, for, print, input e outros. Verifique ainda o uso de \':\' em comando como if e for.  ', NULL, DEFAULT);
INSERT INTO `PEEF_BD`.`ENHANCEDMESSAGE` (`id`, `type`, `subtype`, `enhacedmessage`, `linktutorial`, `Language_id`) VALUES (2, 'SyntaxError', 'Missing parentheses in call to', 'O erro pode ter ocorrido em uma chamada de função. Utilize os parênteses. Exemplo: print(\'Hello Word\') .', NULL, DEFAULT);

COMMIT;


-- -----------------------------------------------------
-- Data for table `PEEF_BD`.`TEST`
-- -----------------------------------------------------
START TRANSACTION;
USE `PEEF_BD`;
INSERT INTO `PEEF_BD`.`TEST` (`id`, `input`, `output`, `Activity_id`) VALUES (1, '10\\n20', '30', 1);
INSERT INTO `PEEF_BD`.`TEST` (`id`, `input`, `output`, `Activity_id`) VALUES (2, '-10\\n10', '0', 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `PEEF_BD`.`ACTION`
-- -----------------------------------------------------
START TRANSACTION;
USE `PEEF_BD`;
INSERT INTO `PEEF_BD`.`ACTION` (`id`, `nome`) VALUES (1, 'online');
INSERT INTO `PEEF_BD`.`ACTION` (`id`, `nome`) VALUES (2, 'offline');
INSERT INTO `PEEF_BD`.`ACTION` (`id`, `nome`) VALUES (3, 'inproject');
INSERT INTO `PEEF_BD`.`ACTION` (`id`, `nome`) VALUES (4, 'outproject');
INSERT INTO `PEEF_BD`.`ACTION` (`id`, `nome`) VALUES (5, 'oncourse');
INSERT INTO `PEEF_BD`.`ACTION` (`id`, `nome`) VALUES (6, 'offcourse');
INSERT INTO `PEEF_BD`.`ACTION` (`id`, `nome`) VALUES (7, 'fixingcode');
INSERT INTO `PEEF_BD`.`ACTION` (`id`, `nome`) VALUES (8, 'messageapproved');
INSERT INTO `PEEF_BD`.`ACTION` (`id`, `nome`) VALUES (9, 'messagerejected');

COMMIT;

