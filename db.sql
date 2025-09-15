-- Crear base de datos
CREATE DATABASE IF NOT EXISTS sistema_estudiantes
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE sistema_estudiantes;

-- ================================
-- Tabla de Cursos
-- ================================
CREATE TABLE IF NOT EXISTS cursos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL
);

-- Insertar cursos de ejemplo
INSERT INTO cursos (nombre) VALUES
('Desarrollo Web'),
('Base de Datos'),
('Programación en PHP'),
('Algoritmos y Estructuras de Datos'),
('Inteligencia Artificial');

-- ================================
-- Tabla de Estudiantes
-- ================================
CREATE TABLE IF NOT EXISTS estudiantes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  curso_id INT,
  FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE SET NULL
);

-- Insertar estudiantes de ejemplo
INSERT INTO estudiantes (nombre, email, curso_id) VALUES
('Carlos Pérez', 'carlos.perez@example.com', 1),
('Ana Gómez', 'ana.gomez@example.com', 2),
('Luis Rodríguez', 'luis.rodriguez@example.com', 3),
('María López', 'maria.lopez@example.com', 4),
('Pedro Sánchez', 'pedro.sanchez@example.com', 5);

CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL
);

-- Insertar un usuario de ejemplo (admin/12345)
INSERT INTO usuarios (usuario, password) 
VALUES ('admin', MD5('12345'));

