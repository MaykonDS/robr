-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17-Mar-2020 às 01:17
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `robr`
--
CREATE DATABASE IF NOT EXISTS `robr` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `robr`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ano`
--

CREATE TABLE `ano` (
  `id` int(11) NOT NULL,
  `desc_ano` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `bairro`
--

CREATE TABLE `bairro` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `candidato`
--

CREATE TABLE `candidato` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `cargo` varchar(20) NOT NULL,
  `seq_cand` int(11) NOT NULL,
  `num_cand` int(11) NOT NULL,
  `desc_situacao` varchar(30) NOT NULL,
  `id_partido` int(11) NOT NULL,
  `profissao` varchar(50) NOT NULL,
  `dt_nasc` date NOT NULL,
  `sexo` char(1) NOT NULL,
  `id_escolaridade` int(11) NOT NULL,
  `id_situacao` int(11) NOT NULL,
  `id_ano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `entrevistado`
--

CREATE TABLE `entrevistado` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `idade` int(11) NOT NULL,
  `id_escolaridade` int(11) NOT NULL,
  `id_bairro` int(11) NOT NULL,
  `religiao` varchar(30) NOT NULL,
  `cor` varchar(30) NOT NULL,
  `renda` int(11) NOT NULL,
  `id_cand_prefeito` int(11) NOT NULL,
  `id_cand_vereador` int(11) NOT NULL,
  `id_partido` int(11) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `escolaridade`
--

CREATE TABLE `escolaridade` (
  `id` int(11) NOT NULL,
  `escolaridade` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `partido`
--

CREATE TABLE `partido` (
  `id` int(11) NOT NULL,
  `numero` varchar(25) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `sigla` varchar(10) NOT NULL,
  `coligacao` varchar(30) NOT NULL,
  `composicao` varchar(40) NOT NULL,
  `id_ano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil_eleitorado`
--

CREATE TABLE `perfil_eleitorado` (
  `id` int(11) NOT NULL,
  `id_zona` int(11) NOT NULL,
  `num_secao` int(11) NOT NULL,
  `desc_faixa_etaria` varchar(20) NOT NULL,
  `id_escolaridade` int(11) NOT NULL,
  `sexo` char(1) NOT NULL,
  `qtd` int(11) NOT NULL,
  `id_ano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `situacao_tot`
--

CREATE TABLE `situacao_tot` (
  `id` int(11) NOT NULL,
  `situacao` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `votacao_zona_secao`
--

CREATE TABLE `votacao_zona_secao` (
  `id` int(11) NOT NULL,
  `id_zona` int(11) NOT NULL,
  `num_secao` int(11) NOT NULL,
  `desc_cargo` varchar(50) NOT NULL,
  `num_votavel` int(11) NOT NULL,
  `qtd_votos` int(11) NOT NULL,
  `id_ano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `zona`
--

CREATE TABLE `zona` (
  `id` int(11) NOT NULL,
  `num_zona` int(11) NOT NULL,
  `id_bairro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `ano`
--
ALTER TABLE `ano`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `bairro`
--
ALTER TABLE `bairro`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `candidato`
--
ALTER TABLE `candidato`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ano` (`id_ano`),
  ADD KEY `id_escolaridade` (`id_escolaridade`),
  ADD KEY `id_situacao` (`id_situacao`),
  ADD KEY `id_partido` (`id_partido`);

--
-- Índices para tabela `entrevistado`
--
ALTER TABLE `entrevistado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bairro` (`id_bairro`),
  ADD KEY `id_cand_prefeito` (`id_cand_prefeito`),
  ADD KEY `id_cand_vereador` (`id_cand_vereador`),
  ADD KEY `id_escolaridade` (`id_escolaridade`),
  ADD KEY `id_partido` (`id_partido`);

--
-- Índices para tabela `escolaridade`
--
ALTER TABLE `escolaridade`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `partido`
--
ALTER TABLE `partido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ano` (`id_ano`);

--
-- Índices para tabela `perfil_eleitorado`
--
ALTER TABLE `perfil_eleitorado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ano` (`id_ano`),
  ADD KEY `id_escolaridade` (`id_escolaridade`),
  ADD KEY `id_zona` (`id_zona`);

--
-- Índices para tabela `situacao_tot`
--
ALTER TABLE `situacao_tot`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `votacao_zona_secao`
--
ALTER TABLE `votacao_zona_secao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ano` (`id_ano`),
  ADD KEY `id_zona` (`id_zona`);

--
-- Índices para tabela `zona`
--
ALTER TABLE `zona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bairro` (`id_bairro`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `ano`
--
ALTER TABLE `ano`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `bairro`
--
ALTER TABLE `bairro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `candidato`
--
ALTER TABLE `candidato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `entrevistado`
--
ALTER TABLE `entrevistado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `escolaridade`
--
ALTER TABLE `escolaridade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `partido`
--
ALTER TABLE `partido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `perfil_eleitorado`
--
ALTER TABLE `perfil_eleitorado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `situacao_tot`
--
ALTER TABLE `situacao_tot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `votacao_zona_secao`
--
ALTER TABLE `votacao_zona_secao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `zona`
--
ALTER TABLE `zona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `candidato`
--
ALTER TABLE `candidato`
  ADD CONSTRAINT `candidato_ibfk_1` FOREIGN KEY (`id_ano`) REFERENCES `ano` (`id`),
  ADD CONSTRAINT `candidato_ibfk_2` FOREIGN KEY (`id_escolaridade`) REFERENCES `escolaridade` (`id`),
  ADD CONSTRAINT `candidato_ibfk_3` FOREIGN KEY (`id_situacao`) REFERENCES `situacao_tot` (`id`),
  ADD CONSTRAINT `candidato_ibfk_4` FOREIGN KEY (`id_partido`) REFERENCES `partido` (`id`);

--
-- Limitadores para a tabela `entrevistado`
--
ALTER TABLE `entrevistado`
  ADD CONSTRAINT `entrevistado_ibfk_1` FOREIGN KEY (`id_bairro`) REFERENCES `bairro` (`id`),
  ADD CONSTRAINT `entrevistado_ibfk_2` FOREIGN KEY (`id_cand_prefeito`) REFERENCES `candidato` (`id`),
  ADD CONSTRAINT `entrevistado_ibfk_3` FOREIGN KEY (`id_cand_vereador`) REFERENCES `candidato` (`id`),
  ADD CONSTRAINT `entrevistado_ibfk_4` FOREIGN KEY (`id_escolaridade`) REFERENCES `escolaridade` (`id`),
  ADD CONSTRAINT `entrevistado_ibfk_5` FOREIGN KEY (`id_partido`) REFERENCES `partido` (`id`);

--
-- Limitadores para a tabela `partido`
--
ALTER TABLE `partido`
  ADD CONSTRAINT `partido_ibfk_1` FOREIGN KEY (`id_ano`) REFERENCES `ano` (`id`);

--
-- Limitadores para a tabela `perfil_eleitorado`
--
ALTER TABLE `perfil_eleitorado`
  ADD CONSTRAINT `perfil_eleitorado_ibfk_1` FOREIGN KEY (`id_ano`) REFERENCES `ano` (`id`),
  ADD CONSTRAINT `perfil_eleitorado_ibfk_2` FOREIGN KEY (`id_escolaridade`) REFERENCES `escolaridade` (`id`);

--
-- Limitadores para a tabela `votacao_zona_secao`
--
ALTER TABLE `votacao_zona_secao`
  ADD CONSTRAINT `votacao_zona_secao_ibfk_1` FOREIGN KEY (`id_ano`) REFERENCES `ano` (`id`);

--
-- Limitadores para a tabela `zona`
--
ALTER TABLE `zona`
  ADD CONSTRAINT `zona_ibfk_1` FOREIGN KEY (`id_bairro`) REFERENCES `bairro` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
