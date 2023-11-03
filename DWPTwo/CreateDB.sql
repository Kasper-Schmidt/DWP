DROP DATABASE IF EXISTS CocktailDB;
CREATE DATABASE CocktailDB;
USE CocktailDB;

CREATE TABLE Profile (
ProfileID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
Username varchar(100),
Fname varchar(100),
Lname varchar(100),
Email varchar(100),
Pass varchar(50),
Avatar varchar(255),
Birthdate date
);
 
CREATE TABLE Media (
MediaID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
URL varchar(1000),
mediaTitle text,
mediaDesc text,
mediaComment text, 
mediaLike int,
MediaProfileFK int NOT NULL,
FOREIGN KEY (MediaProfileFK) REFERENCES Profile (ProfileID)
);

CREATE TABLE Comment (
CommentID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
CommentText text, 
LikeCount int,
MediaCommentFK int NOT NULL,
FOREIGN KEY (MediaCommentFK) REFERENCES Media (MediaID)
);

CREATE TABLE Likes (
LikeID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
LikeAmount int,
MediaLikeFK int NOT NULL,
FOREIGN KEY (MediaLikeFK) REFERENCES Media (MediaID)
);


-- Ajax asynkront javaskript
-- Prepared statements 

--joint eller update

INSERT INTO Profile VALUES (NULL, "SxySmth", "Kasper", "Schmidt", "Kasper.schmidt1@hotmail.com", "123", "213", "1998-05-05");
INSERT INTO Profile VALUES (NULL, "Chell", "Michele", "Andersen", "MA@hotmail.com", "321", "321", "2003-05-05");

