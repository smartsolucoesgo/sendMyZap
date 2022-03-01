-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 01-Mar-2022 às 04:40
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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `conexoes`
--

INSERT INTO `conexoes` (`id`, `nome`, `id_api`, `sessionkey`, `qrcode`, `conn`, `data_cadastro`, `data_alteracao`, `id_update_user`, `status`) VALUES
(10, 'Conexao OficiaL', 6, '28e0b056f47e09ed78056b638c691969', 'data:image/png;base64,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', 0, '2022-02-28 18:40:48', '2022-03-01 04:37:54', 21, 1);

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
