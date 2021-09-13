-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 05-Maio-2020 às 00:24
-- Versão do servidor: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `PEEF_BD`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `Activity`
--

CREATE TABLE `Activity` (
  `id` int(11) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Activity`
--

INSERT INTO `Activity` (`id`, `description`, `image`, `title`) VALUES
(1, 'Dado uma litas de tamanho variavel que contem varias palavras, deseja-se saber se a palavra Python esta contida na lista. Para isso voce precisa percorrer a lista e exibir a posicao da palavra, ao encontra-la. Caso a palavra nao exista, deve-se exibir o numero -1;', 'teste.png', 'Buscando um elemento na lista');

-- --------------------------------------------------------

--
-- Estrutura da tabela `Category`
--

CREATE TABLE `Category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Code`
--

CREATE TABLE `Code` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` longtext,
  `Project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Code`
--

INSERT INTO `Code` (`id`, `name`, `code`, `Project_id`) VALUES
(1, 'teste.py', 'nome = 1\nif(nom == 1):\n    print(\"ok\")', 1),
(2, 'teste2.py', 'print(\"Teste Python 2\")', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `CodeCompilation`
--

CREATE TABLE `CodeCompilation` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` longtext,
  `linesedited` tinyint(1) NOT NULL DEFAULT '0',
  `Compilation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `CodeCompilation`
--

INSERT INTO `CodeCompilation` (`id`, `name`, `code`, `linesedited`, `Compilation_id`) VALUES
(75, 'teste.py', ' nome = 100 ', 1, 78),
(76, 'teste.py', ' nome =  ', 1, 79),
(77, 'teste.py', ' nome = 1\nif ', 1, 80),
(78, 'teste.py', ' nome = 1\nif(1/10) ', 1, 81),
(79, 'teste.py', ' nome = 1\nif(1/0) ', 1, 82),
(80, 'teste.py', ' nome = 1\nif(1/0): ', 1, 83),
(81, 'teste.py', ' nome = 1\nif(1/0):\n    print(\"ok\") ', 1, 84),
(82, 'teste.py', ' nome = 1\nif(1/1):\n    print(\"ok\") ', 1, 85),
(83, 'teste.py', ' nome = 1\nif(nom = 1):\n    print(\"ok\") ', 1, 86),
(84, 'teste.py', ' nome = 1\nif(nome = 0):\n    print(\"ok\") ', 1, 87),
(85, 'teste.py', ' nome = 1\nif(nome = 0):\n    print(\"ok\") ', 1, 88),
(86, 'teste.py', ' nome = 1\nif(nome = 0):\n    print(\"ok2\") ', 1, 89),
(87, 'teste.py', ' nome = 1\nif(nome = 0):\n    print(\"ok\") ', 1, 90),
(88, 'teste.py', ' nome = 1\nif(nome = 0):\n    print(\"ok ok\") ', 1, 91),
(89, 'teste.py', ' nome = 1\nif(nome = 0):\n    print(\"ok ok\") ', 1, 92),
(90, 'teste.py', ' nome = 1\nif(nome = 0):\n    print(\"ok o2\") ', 1, 93),
(91, 'teste.py', ' nome = 1\nif(nome = 1):\n    print(\"ok o2\") ', 1, 94),
(92, 'teste.py', ' nome = 1\nif(nome = 1):\n    print(\"ok o2\") ', 1, 95),
(93, 'teste.py', ' nome = 1\nif(nome == 1):\n    print(\"ok o2\") ', 1, 96),
(94, 'teste.py', ' nome = 1\nif(nome == 1)\n    print(\"ok\") ', 1, 97),
(95, 'teste.py', ' nome = 1\nif(nome == 1)\n    print(\"ok\") ', 0, 98),
(96, 'teste.py', ' nome = 1\nif(nome = 1)\n    print(\"ok\") ', 0, 99),
(97, 'teste.py', ' nome = 1\nif(nome = 1):\n    print(\"ok\") ', 0, 100),
(98, 'teste.py', ' nome = 1\nif(nome == 1):\n    print(\"ok\") ', 0, 101),
(99, 'teste.py', ' nome = 1\nif(nom == 1):\n    print(\"ok\") ', 0, 102),
(100, 'teste.py', ' nome = 1\nif(nom == 1):\n    print(\"ok\") ', 0, 103),
(101, 'teste.py', ' nome = 1\nif(nom == 1):\n    print(\"ok\") ', 0, 104);

-- --------------------------------------------------------

--
-- Estrutura da tabela `Compilation`
--

CREATE TABLE `Compilation` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `hours` time DEFAULT NULL,
  `erromessage` longtext,
  `Code_id` int(11) NOT NULL,
  `typeError` varchar(100) DEFAULT NULL,
  `lineError` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Compilation`
--

INSERT INTO `Compilation` (`id`, `date`, `hours`, `erromessage`, `Code_id`, `typeError`, `lineError`) VALUES
(78, '2020-04-18', '22:00:22', ' ,  ', 1, 'no-error', '-1'),
(79, '2020-04-18', '22:03:38', ' ,   File \"C:UsershiperAppDataLocalTempphpA5A7.tmp\", line 1,    nome =,          ^,SyntaxError: invalid syntax ', 1, 'SyntaxError', '1'),
(80, '2020-04-18', '22:03:43', ' ,   File \"C:UsershiperAppDataLocalTempphpBB72.tmp\", line 2,    if,     ^,SyntaxError: invalid syntax ', 1, 'SyntaxError', '2'),
(81, '2020-04-18', '22:03:51', ' ,   File \"C:UsershiperAppDataLocalTempphpD95B.tmp\", line 2,    if(1/10),           ^,SyntaxError: invalid syntax ', 1, 'SyntaxError', '2'),
(82, '2020-04-18', '22:03:56', ' ,   File \"C:UsershiperAppDataLocalTempphpEF45.tmp\", line 2,    if(1/0),          ^,SyntaxError: invalid syntax ', 1, 'SyntaxError', '2'),
(83, '2020-04-18', '22:04:01', ' ,   File \"C:UsershiperAppDataLocalTempphp138.tmp\", line 3,,            ^,IndentationError: expected an indented block ', 1, 'IndentationError', '3'),
(84, '2020-04-18', '22:04:11', ' , Traceback (most recent call last):,  File \"C:UsershiperAppDataLocalTempphp27BD.tmp\", line 2, in <module>,    if(1/0):,ZeroDivisionError: integer division or modulo by zero ', 1, 'ZeroDivisionError', '2'),
(85, '2020-04-18', '22:04:16', ' ,  ', 1, 'no-error', '-1'),
(86, '2020-04-18', '22:04:26', ' ,   File \"C:UsershiperAppDataLocalTempphp63DD.tmp\", line 2,    if(nom = 1):,           ^,SyntaxError: invalid syntax ', 1, 'SyntaxError', '2'),
(87, '2020-04-18', '22:04:33', ' ,   File \"C:UsershiperAppDataLocalTempphp7F46.tmp\", line 2,    if(nome = 0):,            ^,SyntaxError: invalid syntax ', 1, 'SyntaxError', '2'),
(88, '2020-04-19', '03:29:57', ' ,   File \"C:UsershiperAppDataLocalTempphp6751.tmp\", line 2,    if(nome = 0):,            ^,SyntaxError: invalid syntax ', 1, 'SyntaxError', '2'),
(89, '2020-04-19', '03:30:16', ' ,   File \"C:UsershiperAppDataLocalTempphpB37E.tmp\", line 2,    if(nome = 0):,            ^,SyntaxError: invalid syntax ', 1, 'SyntaxError', '2'),
(90, '2020-04-22', '03:41:13', ' ,   File \"C:UsershiperAppDataLocalTempphpCA05.tmp\", line 2,    if(nome = 0):,            ^,SyntaxError: invalid syntax ', 1, 'SyntaxError', '2'),
(91, '2020-04-22', '03:42:59', ' ,   File \"C:UsershiperAppDataLocalTempphp6EDD.tmp\", line 2,    if(nome = 0):,            ^,SyntaxError: invalid syntax ', 1, 'SyntaxError', '2'),
(92, '2020-04-22', '03:43:51', ' ,   File \"C:UsershiperAppDataLocalTempphp3848.tmp\", line 2,    if(nome = 0):,            ^,SyntaxError: invalid syntax ', 1, 'SyntaxError', '2'),
(93, '2020-04-22', '03:43:55', ' ,   File \"C:UsershiperAppDataLocalTempphp4886.tmp\", line 2,    if(nome = 0):,            ^,SyntaxError: invalid syntax ', 1, 'SyntaxError', '2'),
(94, '2020-04-22', '03:44:01', ' ,   File \"C:UsershiperAppDataLocalTempphp5ECE.tmp\", line 2,    if(nome = 1):,            ^,SyntaxError: invalid syntax ', 1, 'SyntaxError', '2'),
(95, '2020-04-25', '02:37:59', ' ,   File \"C:UsershiperAppDataLocalTempphpFED6.tmp\", line 2,    if(nome = 1):,            ^,SyntaxError: invalid syntax ', 1, 'SyntaxError', '2'),
(96, '2020-04-25', '02:38:17', ' ,  ', 1, 'no-error', '-1'),
(97, '2020-04-25', '19:53:08', ' ,   File \"C:UsershiperAppDataLocalTempphpB631.tmp\", line 2,    if(nome == 1),                ^,SyntaxError: invalid syntax ', 1, 'SyntaxError', '2'),
(98, '2020-04-28', '03:42:18', ' ,   File \"C:UsershiperAppDataLocalTempphpF742.tmp\", line 2,    if(nome == 1),                ^,SyntaxError: invalid syntax ', 1, NULL, NULL),
(99, '2020-04-28', '03:42:26', ' ,   File \"C:UsershiperAppDataLocalTempphp1C31.tmp\", line 2,    if(nome = 1),            ^,SyntaxError: invalid syntax ', 1, NULL, NULL),
(100, '2020-04-28', '03:42:37', ' ,   File \"C:UsershiperAppDataLocalTempphp4574.tmp\", line 2,    if(nome = 1):,            ^,SyntaxError: invalid syntax ', 1, NULL, NULL),
(101, '2020-04-28', '03:42:46', ' ,  ', 1, NULL, NULL),
(102, '2020-04-28', '03:42:51', ' , Traceback (most recent call last):,  File \"C:UsershiperAppDataLocalTempphp7CB3.tmp\", line 2, in <module>,    if(nom == 1):,NameError: name \'nom\' is not defined ', 1, NULL, NULL),
(103, '2020-05-03', '01:05:15', ' , Traceback (most recent call last):,  File \"C:UsershiperAppDataLocalTempphp5542.tmp\", line 2, in <module>,    if(nom == 1):,NameError: name \'nom\' is not defined ', 1, NULL, NULL),
(104, '2020-05-03', '03:35:43', ' , Traceback (most recent call last):,  File \"C:UsershiperAppDataLocalTempphp19F1.tmp\", line 2, in <module>,    if(nom == 1):,NameError: name \'nom\' is not defined ', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `Course`
--

CREATE TABLE `Course` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `accesskey` varchar(45) DEFAULT NULL,
  `Professor_id` int(11) NOT NULL,
  `Language_id` int(11) DEFAULT '1',
  `code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Course`
--

INSERT INTO `Course` (`id`, `name`, `accesskey`, `Professor_id`, `Language_id`, `code`) VALUES
(1, 'Curso Teste', 'TESTE', 1, 1, 'ALG-UEFS20'),
(2, 'Curso Python teste 2', 'CSP2', 1, 1, 'ALG2-UEFS20');

-- --------------------------------------------------------

--
-- Estrutura da tabela `Course_has_Activity`
--

CREATE TABLE `Course_has_Activity` (
  `Activity_id` int(11) NOT NULL,
  `Course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `EnhancedMessage`
--

CREATE TABLE `EnhancedMessage` (
  `id` int(11) NOT NULL,
  `code` varchar(45) DEFAULT NULL,
  `original` longtext,
  `enhanced` longtext,
  `Language_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Enrollment`
--

CREATE TABLE `Enrollment` (
  `id` int(11) NOT NULL,
  `Student_id` int(11) NOT NULL,
  `Course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Enrollment`
--

INSERT INTO `Enrollment` (`id`, `Student_id`, `Course_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 1, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `Language`
--

CREATE TABLE `Language` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Language`
--

INSERT INTO `Language` (`id`, `name`) VALUES
(1, 'Python'),
(2, 'Java'),
(3, 'Javascript');

-- --------------------------------------------------------

--
-- Estrutura da tabela `LineEdited`
--

CREATE TABLE `LineEdited` (
  `id` int(11) NOT NULL,
  `line` int(11) DEFAULT NULL,
  `diff` int(11) DEFAULT NULL,
  `CodeCompilation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `LineEdited`
--

INSERT INTO `LineEdited` (`id`, `line`, `diff`, `CodeCompilation_id`) VALUES
(162, 1, 12, 75),
(163, 1, 3, 76),
(164, 1, 1, 77),
(165, 2, 3, 77),
(166, 2, 6, 78),
(167, 2, 1, 79),
(168, 2, 1, 80),
(169, 2, 1, 81),
(170, 3, 16, 81),
(171, 2, 1, 82),
(172, 2, 6, 83),
(173, 2, 2, 84),
(174, 3, 1, 86),
(175, 3, 1, 87),
(176, 3, 3, 88),
(177, 3, 1, 90),
(178, 2, 1, 91),
(179, 2, 1, 93),
(180, 2, 1, 94),
(181, 3, 3, 94);

-- --------------------------------------------------------

--
-- Estrutura da tabela `Message`
--

CREATE TABLE `Message` (
  `id` int(11) NOT NULL,
  `text` longtext,
  `fromprofessor` tinyint(4) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `horas` time DEFAULT NULL,
  `Professor_id` int(11) NOT NULL,
  `Project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Professor`
--

CREATE TABLE `Professor` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `bio` longtext,
  `institution` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Professor`
--

INSERT INTO `Professor` (`id`, `name`, `email`, `password`, `bio`, `institution`) VALUES
(1, 'Prof Teste', 'profteste@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Usuário Professor Teste', 'TESTE');

-- --------------------------------------------------------

--
-- Estrutura da tabela `Project`
--

CREATE TABLE `Project` (
  `id` int(11) NOT NULL,
  `creationdate` date DEFAULT NULL,
  `date_lastmodification` date DEFAULT NULL,
  `hours_lastmodification` time DEFAULT NULL,
  `enhancedmessage` tinyint(4) DEFAULT '1',
  `Enrollment_id` int(11) NOT NULL,
  `Activity_id` int(11) NOT NULL,
  `Estado_idEstado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Project`
--

INSERT INTO `Project` (`id`, `creationdate`, `date_lastmodification`, `hours_lastmodification`, `enhancedmessage`, `Enrollment_id`, `Activity_id`, `Estado_idEstado`) VALUES
(1, '2020-04-05', '2020-04-05', '17:28:01', 0, 1, 1, 1),
(2, '2020-04-13', '2020-04-13', '17:28:01', 0, 2, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `State`
--

CREATE TABLE `State` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `State`
--

INSERT INTO `State` (`id`, `name`) VALUES
(1, 'Developing'),
(2, 'Delivered'),
(3, 'Abandoned');

-- --------------------------------------------------------

--
-- Estrutura da tabela `Student`
--

CREATE TABLE `Student` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `bio` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Student`
--

INSERT INTO `Student` (`id`, `name`, `email`, `password`, `bio`) VALUES
(1, 'Teste', 'teste@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Usuário de Teste'),
(2, 'Teste 2', 'teste2@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Usuário de Teste 2');

-- --------------------------------------------------------

--
-- Estrutura da tabela `Test`
--

CREATE TABLE `Test` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `code` varchar(45) DEFAULT NULL,
  `Activity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Activity`
--
ALTER TABLE `Activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `Code`
--
ALTER TABLE `Code`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Code_Project1_idx` (`Project_id`);

--
-- Indexes for table `CodeCompilation`
--
ALTER TABLE `CodeCompilation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_codigo_comp_compilacao1_idx` (`Compilation_id`);

--
-- Indexes for table `Compilation`
--
ALTER TABLE `Compilation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Compilation_Code1_idx` (`Code_id`);

--
-- Indexes for table `Course`
--
ALTER TABLE `Course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_curso_Professor1_idx` (`Professor_id`),
  ADD KEY `fk_Curso_Linguagem1_idx` (`Language_id`);

--
-- Indexes for table `Course_has_Activity`
--
ALTER TABLE `Course_has_Activity`
  ADD PRIMARY KEY (`Activity_id`,`Course_id`),
  ADD KEY `fk_Atividade_has_Curso_Curso1_idx` (`Course_id`),
  ADD KEY `fk_Atividade_has_Curso_Atividade1_idx` (`Activity_id`);

--
-- Indexes for table `EnhancedMessage`
--
ALTER TABLE `EnhancedMessage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Mensagens_Melhoradas_Linguagem1_idx` (`Language_id`);

--
-- Indexes for table `Enrollment`
--
ALTER TABLE `Enrollment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_curso_has_Estudante_Estudante1_idx` (`Student_id`),
  ADD KEY `fk_Matricula_Curso1_idx` (`Course_id`);

--
-- Indexes for table `Language`
--
ALTER TABLE `Language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `LineEdited`
--
ALTER TABLE `LineEdited`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_LineEdited_CodeCompilation1_idx` (`CodeCompilation_id`);

--
-- Indexes for table `Message`
--
ALTER TABLE `Message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Mensagem_Professor1_idx` (`Professor_id`),
  ADD KEY `fk_Message_Project1_idx` (`Project_id`);

--
-- Indexes for table `Professor`
--
ALTER TABLE `Professor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Project`
--
ALTER TABLE `Project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Matricula_has_Atividade_Atividade1_idx` (`Activity_id`),
  ADD KEY `fk_Matricula_has_Atividade_Matricula1_idx` (`Enrollment_id`),
  ADD KEY `fk_Projeto_Estado1_idx` (`Estado_idEstado`);

--
-- Indexes for table `State`
--
ALTER TABLE `State`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Student`
--
ALTER TABLE `Student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Test`
--
ALTER TABLE `Test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_testes_Atividade1_idx` (`Activity_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Activity`
--
ALTER TABLE `Activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Code`
--
ALTER TABLE `Code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `CodeCompilation`
--
ALTER TABLE `CodeCompilation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
--
-- AUTO_INCREMENT for table `Compilation`
--
ALTER TABLE `Compilation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;
--
-- AUTO_INCREMENT for table `Course`
--
ALTER TABLE `Course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `EnhancedMessage`
--
ALTER TABLE `EnhancedMessage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Enrollment`
--
ALTER TABLE `Enrollment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Language`
--
ALTER TABLE `Language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `LineEdited`
--
ALTER TABLE `LineEdited`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;
--
-- AUTO_INCREMENT for table `Message`
--
ALTER TABLE `Message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Professor`
--
ALTER TABLE `Professor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Project`
--
ALTER TABLE `Project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `State`
--
ALTER TABLE `State`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Student`
--
ALTER TABLE `Student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Test`
--
ALTER TABLE `Test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `Code`
--
ALTER TABLE `Code`
  ADD CONSTRAINT `fk_Code_Project1` FOREIGN KEY (`Project_id`) REFERENCES `Project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `CodeCompilation`
--
ALTER TABLE `CodeCompilation`
  ADD CONSTRAINT `fk_codigo_comp_compilacao1` FOREIGN KEY (`Compilation_id`) REFERENCES `Compilation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Compilation`
--
ALTER TABLE `Compilation`
  ADD CONSTRAINT `fk_Compilation_Code1` FOREIGN KEY (`Code_id`) REFERENCES `Code` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Course`
--
ALTER TABLE `Course`
  ADD CONSTRAINT `fk_Curso_Linguagem1` FOREIGN KEY (`Language_id`) REFERENCES `Language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_curso_Professor1` FOREIGN KEY (`Professor_id`) REFERENCES `Professor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Course_has_Activity`
--
ALTER TABLE `Course_has_Activity`
  ADD CONSTRAINT `fk_Atividade_has_Curso_Atividade1` FOREIGN KEY (`Activity_id`) REFERENCES `Activity` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Atividade_has_Curso_Curso1` FOREIGN KEY (`Course_id`) REFERENCES `Course` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `EnhancedMessage`
--
ALTER TABLE `EnhancedMessage`
  ADD CONSTRAINT `fk_Mensagens_Melhoradas_Linguagem1` FOREIGN KEY (`Language_id`) REFERENCES `Language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Enrollment`
--
ALTER TABLE `Enrollment`
  ADD CONSTRAINT `fk_Matricula_Curso1` FOREIGN KEY (`Course_id`) REFERENCES `Course` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_curso_has_Estudante_Estudante1` FOREIGN KEY (`Student_id`) REFERENCES `Student` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `LineEdited`
--
ALTER TABLE `LineEdited`
  ADD CONSTRAINT `fk_LineEdited_CodeCompilation1` FOREIGN KEY (`CodeCompilation_id`) REFERENCES `CodeCompilation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Message`
--
ALTER TABLE `Message`
  ADD CONSTRAINT `fk_Mensagem_Professor1` FOREIGN KEY (`Professor_id`) REFERENCES `Professor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Message_Project1` FOREIGN KEY (`Project_id`) REFERENCES `Project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Project`
--
ALTER TABLE `Project`
  ADD CONSTRAINT `fk_Matricula_has_Atividade_Atividade1` FOREIGN KEY (`Activity_id`) REFERENCES `Activity` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Matricula_has_Atividade_Matricula1` FOREIGN KEY (`Enrollment_id`) REFERENCES `Enrollment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Projeto_Estado1` FOREIGN KEY (`Estado_idEstado`) REFERENCES `State` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Test`
--
ALTER TABLE `Test`
  ADD CONSTRAINT `fk_testes_Atividade1` FOREIGN KEY (`Activity_id`) REFERENCES `Activity` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
