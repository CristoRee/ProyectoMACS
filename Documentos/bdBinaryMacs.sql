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
    id_rol INT NOT NULL,
    FOREIGN KEY (id_rol) REFERENCES Roles(id_rol) ON DELETE RESTRICT ON UPDATE CASCADE
);
INSERT INTO Usuarios (nombre_usuario, email, password_hash, id_rol)
VALUES (
    'Cris',
    'cristo@gmail.com',
    '1234', -- Reemplaza esto con el hash real
    1 -- Asumo '2' como el ID para un rol de usuario estándar. Debes usar un id_rol que exista en tu tabla 'Roles'.
);
DELETE FROM Usuarios WHERE nombre_usuario = 'Cris';


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
    PRIMARY KEY (id_ticket, id_repuesto), -- Clave primaria compuesta para evitar duplicados.
    FOREIGN KEY (id_ticket) REFERENCES Tickets(id_ticket) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_repuesto) REFERENCES Repuestos(id_repuesto) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- ========= INSERCIÓN DE DATOS INICIALES PARA TABLAS DE CONSULTA (LOOKUP) =========
-- Insertar los roles básicos para que el sistema funcione.
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
