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
-- Estrutura da tabela `Compilation`
--

CREATE TABLE `Compilation` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `hours` time DEFAULT NULL,
  `erromessage` longtext,
  `Code_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Compilation`
--

INSERT INTO `Compilation` (`id`, `date`, `hours`, `erromessage`, `Code_id`) VALUES
(33, '2020-04-14', '15:07:04', ' ,  ', 1),
(34, '2020-04-14', '15:07:08', ' , SyntaxError: EOL while scanning string literal ', 1),
(35, '2020-04-14', '15:07:15', ' , SyntaxError: EOL while scanning string literal ', 1),
(36, '2020-04-14', '15:07:24', ' ,  ', 1),
(37, '2020-04-14', '15:07:34', ' line 3 , NameError: name \'a\' is not defined ', 1),
(38, '2020-04-14', '15:07:57', ' , SyntaxError: EOL while scanning string literal ', 1),
(39, '2020-04-14', '15:08:16', ' , SyntaxError: Non-ASCII character \'xc3\' in file C:UsershiperAppDataLocalTempphpCA83.tmp on line 3, but no encoding declared; see http://python.org/dev/peps/pep-0263/ for details ', 1),
(40, '2020-04-14', '15:08:29', ' , SyntaxError: Non-ASCII character \'xc3\' in file C:UsershiperAppDataLocalTempphpFD8A.tmp on line 3, but no encoding declared; see http://python.org/dev/peps/pep-0263/ for details ', 1),
(41, '2020-04-14', '15:08:49', ' ,  ', 1),
(42, '2020-04-14', '15:09:13', ' ,  ', 1),
(43, '2020-04-14', '15:09:19', ' ,  ', 1),
(44, '2020-04-14', '15:09:31', ' line 8 , SyntaxError: invalid syntax ', 1),
(45, '2020-04-14', '15:09:35', ' , IndentationError: expected an indented block ', 1),
(46, '2020-04-14', '15:09:43', ' ,  ', 1),
(47, '2020-04-14', '15:09:48', ' , IndentationError: expected an indented block ', 1),
(48, '2020-04-14', '15:09:51', ' , IndentationError: expected an indented block ', 1),
(49, '2020-04-14', '15:09:57', ' , IndentationError: expected an indented block ', 1),
(50, '2020-04-14', '15:10:06', ' ,  ', 1),
(51, '2020-04-14', '15:10:24', ' ,  ', 1),
(52, '2020-04-14', '15:10:38', ' , SyntaxError: EOL while scanning string literal ', 1),
(53, '2020-04-14', '15:10:41', ' , SyntaxError: EOL while scanning string literal ', 1),
(54, '2020-04-14', '15:10:44', ' , SyntaxError: EOL while scanning string literal ', 1),
(55, '2020-04-14', '15:10:48', ' , SyntaxError: EOL while scanning string literal ', 1),
(56, '2020-04-14', '15:10:57', ' , SyntaxError: EOL while scanning string literal ', 1),
(57, '2020-04-14', '15:11:00', ' , SyntaxError: EOL while scanning string literal ', 1),
(58, '2020-04-14', '15:11:13', ' , SyntaxError: EOL while scanning string literal ', 1),
(59, '2020-04-14', '15:11:18', ' ,  ', 1),
(60, '2020-04-15', '00:14:41', ' ,  ', 1),
(61, '2020-04-15', '00:15:19', ' , Array ', 1),
(62, '2020-04-15', '00:16:50', ' ,  ', 1),
(63, '2020-04-15', '00:18:34', ' ,   File \"C:UsershiperAppDataLocalTempphp992C.tmp\", line 3,,              ^,SyntaxError: invalid syntax ', 1),
(64, '2020-04-15', '00:19:27', ' ,   File \"C:UsershiperAppDataLocalTempphp66CD.tmp\", line 2,SyntaxError: Non-ASCII character \'xc3\' in file C:UsershiperAppDataLocalTempphp66CD.tmp on line 2, but no encoding declared; see http://python.org/dev/peps/pep-0263/ for details ', 1),
(65, '2020-04-15', '00:21:28', ' ,              ^,SyntaxError: invalid syntax ', 1),
(66, '2020-04-15', '00:24:47', ' , ,             ^,SyntaxError: invalid syntax ', 1),
(67, '2020-04-15', '00:25:12', ' ,   File \"C:UsershiperAppDataLocalTempphpADE3.tmp\", line 3,,             ^,SyntaxError: invalid syntax ', 1),
(68, '2020-04-16', '01:14:56', ' ,   File \"C:UsershiperAppDataLocalTempphpC42A.tmp\", line 3,,             ^,SyntaxError: invalid syntax ', 1),
(69, '2020-04-16', '01:15:03', ' ,  ', 1),
(70, '2020-04-16', '01:15:08', ' , Traceback (most recent call last):,  File \"C:UsershiperAppDataLocalTempphpF7AF.tmp\", line 2, in <module>,    print(\"E\"+nomew),NameError: name \'nomew\' is not defined ', 1),
(71, '2020-04-16', '01:15:17', ' ,   File \"C:UsershiperAppDataLocalTempphp1A8A.tmp\", line 2,SyntaxError: Non-ASCII character \'xc3\' in file C:UsershiperAppDataLocalTempphp1A8A.tmp on line 2, but no encoding declared; see http://python.org/dev/peps/pep-0263/ for details ', 1),
(72, '2020-04-16', '01:15:27', ' , Traceback (most recent call last):,  File \"C:UsershiperAppDataLocalTempphp419B.tmp\", line 2, in <module>,    print(1/0),ZeroDivisionError: integer division or modulo by zero ', 1),
(73, '2020-04-16', '01:16:11', ' ,   File \"C:UsershiperAppDataLocalTempphpECA1.tmp\", line 4,,        ^,IndentationError: expected an indented block ', 1),
(74, '2020-04-16', '01:16:20', ' ,  ', 1),
(75, '2020-04-16', '01:16:24', ' ,  ', 1),
(76, '2020-04-16', '01:16:29', ' ,   File \"C:UsershiperAppDataLocalTempphp3120.tmp\", line 3,    print(\"a\"),        ^,IndentationError: expected an indented block ', 1),
(77, '2020-04-16', '01:16:44', ' ,   File \"C:UsershiperAppDataLocalTempphp6B7A.tmp\", line 3,SyntaxError: Non-ASCII character \'xc3\' in file C:UsershiperAppDataLocalTempphp6B7A.tmp on line 3, but no encoding declared; see http://python.org/dev/peps/pep-0263/ for details ', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Compilation`
--
ALTER TABLE `Compilation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Compilation_Code1_idx` (`Code_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Compilation`
--
ALTER TABLE `Compilation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `Compilation`
--
ALTER TABLE `Compilation`
  ADD CONSTRAINT `fk_Compilation_Code1` FOREIGN KEY (`Code_id`) REFERENCES `Code` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
