-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 02-Mar-2022 às 06:54
-- Versão do servidor: 5.7.31
-- versão do PHP: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `compositor`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `api`
--

DROP TABLE IF EXISTS `api`;
CREATE TABLE IF NOT EXISTS `api` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `protocol` enum('http://','https://') NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `porta` varchar(10) DEFAULT NULL,
  `apitoken` varchar(255) DEFAULT NULL,
  `webhook` varchar(150) DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_alteracao` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `id_update_user` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `chatbot`
--

DROP TABLE IF EXISTS `chatbot`;
CREATE TABLE IF NOT EXISTS `chatbot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_conexao` int(11) DEFAULT NULL,
  `pergunta` text,
  `resposta` text,
  `data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_alteracao` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `id_update_user` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `conexoes`
--

DROP TABLE IF EXISTS `conexoes`;
CREATE TABLE IF NOT EXISTS `conexoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `id_api` int(11) DEFAULT NULL,
  `sessionkey` varchar(100) DEFAULT NULL,
  `qrcode` text,
  `conn` int(11) DEFAULT '0',
  `data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_alteracao` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `id_update_user` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `configuracao`
--

DROP TABLE IF EXISTS `configuracao`;
CREATE TABLE IF NOT EXISTS `configuracao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_title` varchar(255) NOT NULL,
  `protocol` enum('http://','https://') NOT NULL,
  `environment` enum('Desenvolvimento','Produção') NOT NULL,
  `mail_host` varchar(255) DEFAULT NULL,
  `mail_user` varchar(255) DEFAULT NULL,
  `mail_pass` varchar(255) DEFAULT NULL,
  `mail_auth` enum('true','false') DEFAULT 'true',
  `mail_secure` enum('ssl','tls') DEFAULT 'ssl',
  `mail_port` int(4) DEFAULT '465',
  `mail_sendtype` enum('isSMTP','isMAIL') DEFAULT 'isSMTP',
  `mail_contact` varchar(255) DEFAULT '',
  `data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_alteracao` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `id_update_user` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `configuracao`
--

INSERT INTO `configuracao` (`id`, `app_title`, `protocol`, `environment`, `mail_host`, `mail_user`, `mail_pass`, `mail_auth`, `mail_secure`, `mail_port`, `mail_sendtype`, `mail_contact`, `data_cadastro`, `data_alteracao`, `id_update_user`, `status`) VALUES
(1, 'sendMyZap', 'http://', 'Desenvolvimento', 'hostdooseuemail', 'seuemail.com.br', 'suasenha', 'true', 'tls', 587, 'isSMTP', 'email opcional', '2020-01-27 19:45:19', '2022-03-01 04:39:52', 21, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acesso` enum('Administrador','Usuario') NOT NULL DEFAULT 'Usuario',
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT 'assets/img/avatar.jpg',
  `session` varchar(255) DEFAULT NULL,
  `dark_mode` int(1) DEFAULT '0',
  `text_pequeno` int(1) DEFAULT '0',
  `data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_alteracao` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `id_update_user` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `acesso`, `nome`, `email`, `senha`, `telefone`, `imagem`, `session`, `dark_mode`, `text_pequeno`, `data_cadastro`, `data_alteracao`, `id_update_user`, `status`) VALUES
(21, 'Administrador', 'Administrador', 'admin@myzap.com', '$2y$12$c5zkPacqdF9k5DVEaCBSIOqa5f4e5PqWLkkHYoVz3PaA2CM1YruDi', '(62) 9999-99999', 'assets/img/avatar.jpg', NULL, 0, 0, '2022-02-28 21:50:39', '2022-03-01 04:38:05', 21, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
