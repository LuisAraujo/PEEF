-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 18-Abr-2020 às 19:28
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
-- Estrutura da tabela `CodeCompilation`
--

CREATE TABLE `CodeCompilation` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` longtext,
  `Compilation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `CodeCompilation`
--

INSERT INTO `CodeCompilation` (`id`, `name`, `code`, `Compilation_id`) VALUES
(2, 'teste.py', ' nome = \"Luis\"\nprint(nome) ', 33),
(3, 'teste.py', ' nome = \"Luis\nprint(nome) ', 34),
(4, 'teste.py', ' nome = \"Luis\'\nprint(nome) ', 35),
(5, 'teste.py', ' nome = \"Luis\"\nprint(nome) ', 36),
(6, 'teste.py', ' nome = \"Luis\"\nprint(nome)\nprint(a) ', 37),
(7, 'teste.py', ' nome = \"Luis\"\nprint(nome +\"\n\")\nprint(a) ', 38),
(8, 'teste.py', ' nome = \"Luis\"\nprint(nome)\nprint(\"Meu Nome Ã© \" + nome) ', 39),
(9, 'teste.py', ' nome = \"Luis\"\nprint(nome)\nprint(\"Meu Nome Ã© \", nome) ', 40),
(10, 'teste.py', ' nome = \"Luis\"\nprint(nome)\nprint(\"Meu Nome e \", nome) ', 41),
(11, 'teste.py', ' nome = \"Luis\"\nprint(nome)\nprint(\"Meu Nome e \", nome)\na = 1;\nb = 3;\nc = 4;\n ', 42),
(12, 'teste.py', ' nome = \"Luis\"\nprint(nome)\nprint(\"Meu Nome e \", nome)\na = 1;\nb = 3;\nc = 4;\nprint(c) ', 43),
(13, 'teste.py', ' nome = \"Luis\"\nprint(nome)\nprint(\"Meu Nome e \", nome)\na = 1;\nb = 3;\nc = 4;\nprint(c)\nif(c > 2) ', 44),
(14, 'teste.py', ' nome = \"Luis\"\nprint(nome)\nprint(\"Meu Nome e \", nome)\na = 1;\nb = 3;\nc = 4;\nprint(c)\nif(c > 2): ', 45),
(15, 'teste.py', ' nome = \"Luis\"\nprint(nome)\nprint(\"Meu Nome e \", nome)\na = 1;\nb = 3;\nc = 4;\nprint(c)\nif(c > 2):\n    print(a) ', 46),
(16, 'teste.py', ' nome = \"Luis\"\nprint(nome)\nprint(\"Meu Nome e \", nome)\na = 1;\nb = 3;\nc = 4;\nprint(c)\nif(c > 2):\n   ', 47),
(17, 'teste.py', ' nome = \"Luis\"\nprint(nome)\nprint(\"Meu Nome e \", nome)\na = 1;\nb = 3;\nc = 4;\nprint(c)\nif(c > 2): ', 48),
(18, 'teste.py', ' nome = \"Luis\"\nprint(nome)\nprint(\"Meu Nome e \")\na = 1;\nb = 3;\nc = 4;\nprint(c)\nif(c > 2): ', 49),
(19, 'teste.py', ' nome = \"Luis\"\nprint(nome)\n\na = 1;\nb = 3;\nc = 4;\nprint(c)\nif(c > 2):\n    print(\"Meu Nome e \") ', 50),
(20, 'teste.py', ' nome = \"Luis\"\nprint(nome)\n\na = 1;\nb = 3;\nc = 4;\nprint(c)\nif(c > 2):\n    print(\"Meu Nome e \"+ nome) ', 51),
(21, 'teste.py', ' nome = \"Luis\"\nprint(nome)\n\na = 1;\nb = 3;\nc = 4;\nprint(c)\nif(c > 2):\n    print(\"Meu Nome e \"+ nome)\n    print(\" \n   + b) ', 52),
(22, 'teste.py', ' nome = \"Luis\"\nprint(nome)\n\na = 1;\nb = 3;\nc = 4;\nprint(c)\nif(c > 2):\n    print(\"Meu Nome e \"+ nome)\n    print(\" \n  + b) ', 53),
(23, 'teste.py', ' nome = \"Luis\"\nprint(nome)\n\na = 1;\nb = 3;\nc = 4;\nprint(c)\nif(c > 2):\n    print(\"Meu Nome e \"+ nome)\n    print(\" \n  + a) ', 54),
(24, 'teste.py', ' nome = \"Luis\"\nprint(nome)\n\na = 1;\nb = 3;\nc = 4;\nprint(c)\nif(c > 2):\n    print(\"Meu Nome e \"+ nome)\n    print(\" \n  + a\") ', 55),
(25, 'teste.py', ' nome = \"Luis\"\nprint(nome)\n\na = 1;\nb = 3;\nc = 4;\nprint(c)\nif(c > 2):\n    print(\"Meu Nome e \"+ nome)\n    print(\" \n \" + a\") ', 56),
(26, 'teste.py', ' nome = \"Luis\"\nprint(nome)\n\na = 1;\nb = 3;\nc = 4;\nprint(c)\nif(c > 2):\n    print(\"Meu Nome e \"+ nome)\n    print(\" \n \"  a\") ', 57),
(27, 'teste.py', ' nome = \"Luis\"\nprint(nome)\n\na = 1;\nb = 3;\nc = 4;\nprint(c)\nif(c > 2):\n    print(\"Meu Nome e \"+ nome)\n    print(\' \n \' +  a) ', 58),
(28, 'teste.py', ' nome = \"Luis\"\nprint(nome)\n\na = 1;\nb = 3;\nc = 4;\nprint(c)\nif(c > 2):\n    print(\"Meu Nome e \"+ nome)\n    print( a) ', 59),
(29, 'teste.py', ' nome = \"Luis\"\nprint(nome) ', 60),
(30, 'teste.py', ' nome = \"Luis\"\nprint(nome ', 61),
(31, 'teste.py', ' nome = \"Luis\"\nprint(nome ', 62),
(32, 'teste.py', ' nome = \"Luis\"\nprint(nome ', 63),
(33, 'teste.py', ' nome = \"Luis\"\nprint(\"Ã‰\") ', 64),
(34, 'teste.py', ' nome = \"Luis\"\nprint(\"E\" ', 65),
(35, 'teste.py', ' nome = \"Luis\"\nprint(\"E\" ', 66),
(36, 'teste.py', ' nome = \"Luis\"\nprint(\"E\" ', 67),
(37, 'teste.py', ' nome = \"Luis\"\nprint(\"E\" ', 68),
(38, 'teste.py', ' nome = \"Luis\"\nprint(\"E\"+nome) ', 69),
(39, 'teste.py', ' nome = \"Luis\"\nprint(\"E\"+nomew) ', 70),
(40, 'teste.py', ' nome = \"Luis\"\nprint(\"Ã‰ \") ', 71),
(41, 'teste.py', ' nome = \"Luis\"\nprint(1/0) ', 72),
(42, 'teste.py', ' nome = \"Lu\"\nif():\n     ', 73),
(43, 'teste.py', ' nome = \"Lu\"\nif():\n    print(\"a\") ', 74),
(44, 'teste.py', ' nome = \"Lu\"\nif(1):\n    print(\"a\") ', 75),
(45, 'teste.py', ' nome = \"Lu\"\nif(1):\nprint(\"a\") ', 76),
(46, 'teste.py', ' nome = \"Lu\"\nif(1):\n    print(\"Ã‰\") ', 77);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CodeCompilation`
--
ALTER TABLE `CodeCompilation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_codigo_comp_compilacao1_idx` (`Compilation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `CodeCompilation`
--
ALTER TABLE `CodeCompilation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `CodeCompilation`
--
ALTER TABLE `CodeCompilation`
  ADD CONSTRAINT `fk_codigo_comp_compilacao1` FOREIGN KEY (`Compilation_id`) REFERENCES `Compilation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
