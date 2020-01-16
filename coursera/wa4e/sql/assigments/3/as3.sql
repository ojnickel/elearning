###CREATE DATABASE Music DEFAULT CHARACTER SET utf8mb4;

USE Music;

CREATE TABLE Artists (
      id INTEGER NOT NULL AUTO_INCREMENT,
      name VARCHAR(255),
      PRIMARY KEY(id)
    
) ENGINE = InnoDB;

CREATE TABLE Albums (
      id INTEGER NOT NULL AUTO_INCREMENT,
      title VARCHAR(255),
      artist_id INTEGER,

      PRIMARY KEY(id),
      INDEX USING BTREE (title),

      CONSTRAINT FOREIGN KEY (artist_id)
        REFERENCES Artists (id)
            ON DELETE CASCADE ON UPDATE CASCADE
            
) ENGINE = InnoDB;

CREATE TABLE Genres (
      id INTEGER NOT NULL AUTO_INCREMENT,
      name VARCHAR(255),
      PRIMARY KEY(id)
    
) ENGINE = InnoDB;

CREATE TABLE Tracks (
      id INTEGER NOT NULL AUTO_INCREMENT,
      title VARCHAR(255),
      len INTEGER,
      rating INTEGER,
      count INTEGER,
      album_id INTEGER,
      genre_id INTEGER,

      PRIMARY KEY(id),
      INDEX USING BTREE (title),

      CONSTRAINT FOREIGN KEY (album_id) REFERENCES Albums (id)
        ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT FOREIGN KEY (genre_id) REFERENCES Genres (id)
            ON DELETE CASCADE ON UPDATE CASCADE
            
) ENGINE = InnoDB;
