-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 13-Abr-2020 às 21:08
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
(2, 'teste.py', ' print(\"Teste Python\") ', 1),
(3, 'teste.py', ' print(\"Teste Python\" ', 2),
(4, 'teste.py', ' print(a) ', 3),
(5, 'teste.py', ' print(\"jhakskjsak\" ', 4),
(6, 'teste.py', ' print(a) ', 5),
(7, 'teste.py', ' print(a) ', 6),
(8, 'teste.py', ' a=\"bbb\"\nprint(a) ', 7),
(9, 'teste.py', ' a=\"bbb\"\nprint(a) ', 8);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
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
