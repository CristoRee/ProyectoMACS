create schema basemacs;
use basemacs;


CREATE TABLE Roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL UNIQUE
);


CREATE TABLE Estados (
    id_estado INT AUTO_INCREMENT PRIMARY KEY,
    nombre_estado VARCHAR(100) NOT NULL UNIQUE
);


CREATE TABLE Repuestos (
    id_repuesto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    stock INT NOT NULL DEFAULT 0,
    precio DECIMAL(10, 2) NOT NULL
);


CREATE TABLE Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    telefono VARCHAR(50),
    especializacion VARCHAR(255),
    foto_perfil VARCHAR(255) NULL DEFAULT NULL,
    id_rol INT NOT NULL,
    FOREIGN KEY (id_rol) REFERENCES Roles(id_rol) ON DELETE RESTRICT ON UPDATE CASCADE
);



CREATE TABLE Productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    tipo_producto VARCHAR(100),
    marca VARCHAR(100),
    modelo VARCHAR(100),
    numero_serie VARCHAR(255) UNIQUE,
    id_cliente INT NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES Usuarios(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE
);
select * from Productos;


CREATE TABLE Tickets (
    id_ticket INT AUTO_INCREMENT PRIMARY KEY,
    descripcion_problema TEXT NOT NULL,
    diagnostico_tecnico TEXT,
    fecha_ingreso DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_finalizacion DATETIME,
    id_cliente INT NOT NULL,
    id_producto INT NOT NULL,
    id_tecnico_asignado INT,
    id_estado INT NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES Usuarios(id_usuario) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES Productos(id_producto) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_tecnico_asignado) REFERENCES Usuarios(id_usuario) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (id_estado) REFERENCES Estados(id_estado) ON DELETE RESTRICT ON UPDATE CASCADE
);
select * from Tickets;

CREATE TABLE Fotos_Ticket (
    id_foto INT AUTO_INCREMENT PRIMARY KEY,
    url_imagen VARCHAR(255) NOT NULL,
    id_ticket INT NOT NULL,
    FOREIGN KEY (id_ticket) REFERENCES Tickets(id_ticket) ON DELETE CASCADE ON UPDATE CASCADE
);
select * from Fotos_Ticket;


CREATE TABLE Acciones_Reparacion (
    id_accion INT AUTO_INCREMENT PRIMARY KEY,
    descripcion_accion TEXT NOT NULL,
    fecha_hora DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_ticket INT NOT NULL,
    id_tecnico INT NOT NULL,
    FOREIGN KEY (id_ticket) REFERENCES Tickets(id_ticket) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_tecnico) REFERENCES Usuarios(id_usuario) ON DELETE RESTRICT ON UPDATE CASCADE
);


CREATE TABLE Ticket_Usa_Repuesto (
    cantidad_usada INT NOT NULL DEFAULT 1,
    id_ticket INT NOT NULL,
    id_repuesto INT NOT NULL,
    PRIMARY KEY (id_ticket, id_repuesto), 
    FOREIGN KEY (id_ticket) REFERENCES Tickets(id_ticket) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_repuesto) REFERENCES Repuestos(id_repuesto) ON DELETE RESTRICT ON UPDATE CASCADE
);


INSERT INTO Roles (nombre_rol) VALUES
('Administrador'),
('Técnico'),
('Cliente');



INSERT INTO Estados (nombre_estado) VALUES
('Ingresado'),
('En diagnóstico'),
('Esperando aprobación'),
('En espera de repuestos'),
('En reparación'),
('Listo para retirar'),
('Finalizado'),
('Cancelado');

CREATE TABLE `Conversaciones` (
  `id_conversacion` INT NOT NULL AUTO_INCREMENT,
  `id_ticket` INT NOT NULL,
  `tipo` ENUM('TICKET', 'PRIVADA') NOT NULL DEFAULT 'TICKET',
  `id_participante1` INT NULL DEFAULT NULL,
  `id_participante2` INT NULL DEFAULT NULL,
  `fecha_creacion` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_conversacion`),
  UNIQUE KEY `idx_ticket_tipo` (`id_ticket`, `tipo`),
  KEY `fk_participante1_idx` (`id_participante1`),
  KEY `fk_participante2_idx` (`id_participante2`),
  CONSTRAINT `fk_conversacion_ticket` FOREIGN KEY (`id_ticket`) REFERENCES `Tickets` (`id_ticket`) ON DELETE CASCADE,
  CONSTRAINT `fk_participante1` FOREIGN KEY (`id_participante1`) REFERENCES `Usuarios` (`id_usuario`) ON DELETE SET NULL,
  CONSTRAINT `fk_participante2` FOREIGN KEY (`id_participante2`) REFERENCES `Usuarios` (`id_usuario`) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE Mensajes (
    id_mensaje INT AUTO_INCREMENT PRIMARY KEY,
    id_conversacion INT NOT NULL,
    id_emisor INT NOT NULL,      
    id_receptor INT NOT NULL,    
    contenido TEXT NOT NULL,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    leido BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (id_conversacion) REFERENCES Conversaciones(id_conversacion) ON DELETE CASCADE,
    FOREIGN KEY (id_emisor) REFERENCES Usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_receptor) REFERENCES Usuarios(id_usuario) ON DELETE CASCADE
);

CREATE TABLE Historial (
    id_historial INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NULL,
    id_ticket INT NULL,
    accion VARCHAR(255) NOT NULL,
    fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE SET NULL,
    FOREIGN KEY (id_ticket) REFERENCES Tickets(id_ticket) ON DELETE CASCADE
);