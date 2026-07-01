
-- =============================================
-- VetClínica - Script de criação do banco
-- =============================================
 
CREATE DATABASE IF NOT EXISTS vetclinica
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
 
USE vetclinica;
 
-- ---------------------------------------------
-- Tabela: usuarios
-- ---------------------------------------------
CREATE TABLE IF NOT EXISTS usuarios (
    id         INT          AUTO_INCREMENT PRIMARY KEY,
    nome       VARCHAR(100) NOT NULL,
    email      VARCHAR(100) NOT NULL UNIQUE,
    senha      VARCHAR(255) NOT NULL,
    criado_em  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);
 
-- ---------------------------------------------
-- Tabela: animais
-- ---------------------------------------------
CREATE TABLE IF NOT EXISTS animais (
    id         INT          AUTO_INCREMENT PRIMARY KEY,
    nome       VARCHAR(100) NOT NULL,
    especie    VARCHAR(50)  NOT NULL,
    raca       VARCHAR(50),
    idade      INT,
    dono_nome  VARCHAR(100) NOT NULL,
    criado_em  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);
 
-- ---------------------------------------------
-- Dados de exemplo
-- ---------------------------------------------
 
-- senha de exemplo: 123456
INSERT INTO usuarios (nome, email, senha) VALUES
('Admin',      'admin@vetclinica.com',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Dr. Carlos', 'carlos@vetclinica.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
 
INSERT INTO animais (nome, especie, raca, idade, dono_nome) VALUES
('Rex',     'Cachorro', 'Labrador', 3, 'Maria Silva'),
('Mimi',    'Gato',     'Siamês',   2, 'João Souza'),
('Bolinha', 'Cachorro', 'Poodle',   1, 'Ana Lima');
 