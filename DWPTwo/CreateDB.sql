DROP DATABASE IF EXISTS CocktailDB;
CREATE DATABASE CocktailDB;
USE CocktailDB;

CREATE TABLE Profile (
    ProfileID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    Username varchar(100),
    Fname varchar(100),
    Lname varchar(100),
    Email varchar(100),
    Pass varchar(255),
    Avatar varchar(255),
    Birthdate date,
    IsAdmin TINYINT(1) DEFAULT 0,
    IsBlocked TINYINT(1) DEFAULT 0
);
 
CREATE TABLE Media (
    MediaID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    URL varchar(1000),
    mediaTitle text,
    mediaDesc text,
    mediaLike int DEFAULT 0,
    MediaProfileFK int NOT NULL,
    FOREIGN KEY (MediaProfileFK) REFERENCES Profile (ProfileID)
);

CREATE TABLE Comment (
    CommentID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    CommentText TEXT NOT NULL,
    dato date NOT NULL,
    MediaCommentFK INT NOT NULL,
    ProfileFK INT NOT NULL,
    FOREIGN KEY (MediaCommentFK) REFERENCES Media (MediaID),
    FOREIGN KEY (ProfileFK) REFERENCES Profile (ProfileID)
);

CREATE TABLE Likes (
    LikeID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    LikeAmount int,
    MediaLikeFK int NOT NULL,
    ProfileLikeFK int NOT NULL,
    FOREIGN KEY (MediaLikeFK) REFERENCES Media (MediaID),
    FOREIGN KEY (ProfileLikeFK) REFERENCES Profile (ProfileID)

);



INSERT INTO Profile VALUES (NULL, "SxySmth", "Kasper", "Schmidt", "Kasper.schmidt1@hotmail.com", "123", "213", "1998-05-05", 0, 0);
INSERT INTO Profile VALUES (NULL, "Chell", "Michele", "Andersen", "MA@hotmail.com", "321", "321", "2003-05-05", 0, 0);
INSERT INTO Profile VALUES (NULL, "admin", "admin", "admin", "admin@admin.com", "adminpass", "admin.png", "2000-01-01", 0, 0);



ALTER TABLE Profile ADD IsAdmin TINYINT(1) DEFAULT 0;
UPDATE Profile SET IsAdmin = 1 WHERE Username = 'admin';