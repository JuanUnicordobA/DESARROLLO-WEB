
CREATE TABLE Eventos (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL,
  fecha DATE NOT NULL,
  lugar VARCHAR(255) NOT NULL,
  tipo VARCHAR(255) NOT NULL,
  duracion INT NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE Asistentes (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL,
  apellido VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  telefono VARCHAR(255) NOT NULL,
  fecha_nacimiento DATE NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE Inscripciones (
  id INT NOT NULL AUTO_INCREMENT,
  rol VARCHAR(255) NOT NULL,
  costo DECIMAL(10,2) NOT NULL,
  estado_pago VARCHAR(255) NOT NULL,
  fecha_inscripcion DATETIME NOT NULL,
  fecha_vencimiento DATETIME NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE Detalles (
  id INT NOT NULL AUTO_INCREMENT,
  evento_id INT NOT NULL,
  asistente_id INT NOT NULL,
  inscripcion_id INT NOT NULL,
  tipo_entrada VARCHAR(255) NOT NULL,
  codigo_promocional VARCHAR(255) NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (evento_id) REFERENCES Eventos(id),
  FOREIGN KEY (asistente_id) REFERENCES Asistentes(id),
  FOREIGN KEY (inscripcion_id) REFERENCES Inscripciones(id)
);
