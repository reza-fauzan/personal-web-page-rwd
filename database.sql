CREATE TABLE IF NOT EXISTS level (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS studies (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nama VARCHAR(200) NOT NULL,
    idlevel INT(11) NOT NULL,
    keterangan TEXT,
    tahun_lulus YEAR(4),
    foto_sekolah VARCHAR(255),
    PRIMARY KEY (id),
    KEY fk_studies_level (idlevel),
    CONSTRAINT fk_studies_level FOREIGN KEY (idlevel) REFERENCES level(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE member (
id int(11) NOT NULL AUTO_INCREMENT,
fullname varchar(100) NOT NULL,
email varchar(100) NOT NULL,
password char(40) NOT NULL,
role enum('admin','mahasiswa','tamu') NOT NULL,
foto varchar(255) DEFAULT NULL,
PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;