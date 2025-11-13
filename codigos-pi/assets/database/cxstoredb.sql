-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.32-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para cxstorebd
CREATE DATABASE IF NOT EXISTS `cxstorebd` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `cxstorebd`;

-- Copiando estrutura para tabela cxstorebd.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(128) NOT NULL,
  `ativo` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela cxstorebd.categoria: ~3 rows (aproximadamente)
INSERT INTO `categoria` (`id`, `nome`, `ativo`) VALUES
	(4, 'Calça', 1),
	(5, 'Acessório', 1),
	(6, 'Camiseta', 1);

-- Copiando estrutura para tabela cxstorebd.cor
CREATE TABLE IF NOT EXISTS `cor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(128) NOT NULL,
  `ativo` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela cxstorebd.cor: ~2 rows (aproximadamente)
INSERT INTO `cor` (`id`, `nome`, `ativo`) VALUES
	(1, 'Azul', 1),
	(3, 'Bege', 1);

-- Copiando estrutura para tabela cxstorebd.imagem_produto
CREATE TABLE IF NOT EXISTS `imagem_produto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_produto_anuncio` int(11) DEFAULT NULL,
  `caminho` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_produto_anuncio` (`fk_produto_anuncio`),
  CONSTRAINT `FK_produto_anuncio` FOREIGN KEY (`fk_produto_anuncio`) REFERENCES `produto_anuncio` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela cxstorebd.imagem_produto: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela cxstorebd.pedido
CREATE TABLE IF NOT EXISTS `pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_usuario_id` int(11) DEFAULT NULL,
  `status` enum('carrinho','pendente','aprovado','rejeitado') NOT NULL DEFAULT 'carrinho',
  `data_criacao` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `FK_pedido_usuario` (`fk_usuario_id`),
  CONSTRAINT `FK_pedido_usuario` FOREIGN KEY (`fk_usuario_id`) REFERENCES `usuario` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela cxstorebd.pedido: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela cxstorebd.pedido_item
CREATE TABLE IF NOT EXISTS `pedido_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_pedido_id` int(11) NOT NULL,
  `fk_variacao_produto_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `preco_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) GENERATED ALWAYS AS (`quantidade` * `preco_unitario`) STORED,
  PRIMARY KEY (`id`),
  KEY `FK_pedido_item_pedido` (`fk_pedido_id`),
  KEY `FK_pedido_item_variacao` (`fk_variacao_produto_id`),
  CONSTRAINT `FK_pedido_item_pedido` FOREIGN KEY (`fk_pedido_id`) REFERENCES `pedido` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_pedido_item_variacao` FOREIGN KEY (`fk_variacao_produto_id`) REFERENCES `variacao_produto` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela cxstorebd.pedido_item: ~0 rows (aproximadamente)

-- Copiando estrutura para procedure cxstorebd.proc_atualizar_cor
DELIMITER //
CREATE PROCEDURE `proc_atualizar_cor`(
	IN `p_cor_id` INT,
	IN `p_novo_ativo` TINYINT
)
BEGIN
    IF p_novo_ativo = 0 THEN

        UPDATE variacao_produto
        SET disponivel = 0
        WHERE fk_cor_id = p_cor_id;

        UPDATE produto_anuncio p
        SET p.ativo = 0
        WHERE p.id IN (
            SELECT vp.fk_produto_anuncio_id
            FROM variacao_produto vp
            WHERE vp.fk_cor_id = p_cor_id
        )
        AND NOT EXISTS (
            SELECT 1
            FROM variacao_produto v
            WHERE v.fk_produto_anuncio_id = p.id
              AND v.disponivel = 1
        );

    END IF;

    IF p_novo_ativo = 1 THEN

        UPDATE variacao_produto
        SET disponivel = 1
        WHERE fk_cor_id = p_cor_id;
        
        UPDATE produto_anuncio p
        SET p.ativo = 1
        WHERE EXISTS (
            SELECT 1
            FROM variacao_produto v
            WHERE v.fk_produto_anuncio_id = p.id
              AND v.disponivel = 1
        );

    END IF;

END//
DELIMITER ;

-- Copiando estrutura para procedure cxstorebd.proc_atualizar_tamanho
DELIMITER //
CREATE PROCEDURE `proc_atualizar_tamanho`(
	IN `p_tamanho_id` INT,
	IN `p_novo_ativo` TINYINT
)
BEGIN
    IF p_novo_ativo = 0 THEN

        UPDATE variacao_produto
        SET disponivel = 0
        WHERE fk_tamanho_id = p_tamanho_id;

        UPDATE produto_anuncio p
        SET p.ativo = 0
        WHERE p.id IN (
            SELECT vp.fk_produto_anuncio_id
            FROM variacao_produto vp
            WHERE vp.fk_tamanho_id = p_tamanho_id
        )
        AND NOT EXISTS (
            SELECT 1
            FROM variacao_produto v
            WHERE v.fk_produto_anuncio_id = p.id
              AND v.disponivel = 1
        );

    END IF;
   
    IF p_novo_ativo = 1 THEN

        UPDATE variacao_produto
        SET disponivel = 1
        WHERE fk_tamanho_id = p_tamanho_id;

        UPDATE produto_anuncio p
        SET p.ativo = 1
        WHERE EXISTS (
            SELECT 1
            FROM variacao_produto v
            WHERE v.fk_produto_anuncio_id = p.id
              AND v.disponivel = 1
        );

    END IF;

END//
DELIMITER ;

-- Copiando estrutura para tabela cxstorebd.produto_anuncio
CREATE TABLE IF NOT EXISTS `produto_anuncio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(128) NOT NULL,
  `descricao` text DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `fk_categoria_id` int(11) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `status` tinytext DEFAULT '1',
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `FK_produto_anuncio_categoria` (`fk_categoria_id`),
  CONSTRAINT `FK_produto_anuncio_categoria` FOREIGN KEY (`fk_categoria_id`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela cxstorebd.produto_anuncio: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela cxstorebd.tamanho
CREATE TABLE IF NOT EXISTS `tamanho` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `ativo` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela cxstorebd.tamanho: ~4 rows (aproximadamente)
INSERT INTO `tamanho` (`id`, `nome`, `ativo`) VALUES
	(1, 'P', 1),
	(2, 'G', 1),
	(3, 'M', 1),
	(4, 'GG', 1);

-- Copiando estrutura para tabela cxstorebd.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `contato` varchar(20) DEFAULT NULL,
  `tipo_usuario` enum('admin','cliente') NOT NULL DEFAULT 'cliente',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela cxstorebd.usuario: ~2 rows (aproximadamente)
INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `contato`, `tipo_usuario`) VALUES
	(1, 'Admin', 'admin@gmail.com', '$2y$10$ebUcehoWLwv.8AqM3Jhu7uxJIp6V2tewJRFHQBmpSNXltF6V9jqiC', '', 'admin'),
	(2, 'cliente', 'cliente@gmail.com', '$2y$10$.NDA8eQxL6UFlc/PU/PROO35VmeYzQrQikU8NqqRlVCjGI6l5Nk0K', '', 'cliente');

-- Copiando estrutura para tabela cxstorebd.variacao_produto
CREATE TABLE IF NOT EXISTS `variacao_produto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_produto_anuncio_id` int(11) NOT NULL,
  `fk_cor_id` int(11) DEFAULT NULL,
  `fk_tamanho_id` int(11) DEFAULT NULL,
  `disponivel` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `FK_variacao_produto_anuncio` (`fk_produto_anuncio_id`),
  KEY `FK_variacao_produto_cor` (`fk_cor_id`),
  KEY `FK_variacao_produto_tamanho` (`fk_tamanho_id`),
  CONSTRAINT `FK_variacao_produto_anuncio` FOREIGN KEY (`fk_produto_anuncio_id`) REFERENCES `produto_anuncio` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_variacao_produto_cor` FOREIGN KEY (`fk_cor_id`) REFERENCES `cor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_variacao_produto_tamanho` FOREIGN KEY (`fk_tamanho_id`) REFERENCES `tamanho` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela cxstorebd.variacao_produto: ~0 rows (aproximadamente)

-- Copiando estrutura para trigger cxstorebd.tr_cor_ativada
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER tr_cor_ativada
AFTER UPDATE ON cor
FOR EACH ROW
BEGIN
    IF OLD.ativo = 0 AND NEW.ativo = 1 THEN
        CALL proc_atualizar_cor(NEW.id, 1);
    END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Copiando estrutura para trigger cxstorebd.tr_cor_inativada
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER tr_cor_inativada
AFTER UPDATE ON cor
FOR EACH ROW
BEGIN
    IF OLD.ativo = 1 AND NEW.ativo = 0 THEN
        CALL proc_atualizar_cor(NEW.id, 0);
    END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Copiando estrutura para trigger cxstorebd.tr_tamanho_ativado
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER tr_tamanho_ativado
AFTER UPDATE ON tamanho
FOR EACH ROW
BEGIN
    IF OLD.ativo = 0 AND NEW.ativo = 1 THEN
        CALL proc_atualizar_tamanho(NEW.id, 1);
    END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Copiando estrutura para trigger cxstorebd.tr_tamanho_inativado
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER tr_tamanho_inativado
AFTER UPDATE ON tamanho
FOR EACH ROW
BEGIN
    IF OLD.ativo = 1 AND NEW.ativo = 0 THEN
        CALL proc_atualizar_tamanho(NEW.id, 0);
    END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
