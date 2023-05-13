CREATE DATABASE IF NOT EXISTS itstasty;

USE itstasty;

CREATE TABLE User(
    ID int NOT NULL AUTO_INCREMENT,
    Firstname varchar(50),
    Lastname varchar(50),
    Username varchar(50),
    Email varchar(50),
    Salt varchar(50),
    Password varchar(255),
    UserImg MEDIUMBLOB NOT NULL,

    PRIMARY KEY(ID)
);

INSERT INTO `User` (`Firstname`, `Lastname`, `Email`, `Username`, `Salt`, `Password`, `UserImg`) VALUES ("Admin", "Admin", "Admin", "Admin", "1e26e2f251f1d21b2cfe55077a49f8c6","9e07b4d4bfc4cf438ad2e92fc68f7d2cb6fa0b7fb30a68a9e7d18a6c064a6a32", "1");

CREATE TABLE Recipe(
    ID int NOT NULL AUTO_INCREMENT,
    UserID int NOT NULL,
    FOREIGN KEY (UserID) REFERENCES User(ID),
    Name VARCHAR(255),
    instruction LONGTEXT,
    Time int NOT NULL,
    RecipeImg MEDIUMBLOB NOT NULL,

    PRIMARY KEY(ID)
);

CREATE TABLE Comment(
    ID int NOT NULL AUTO_INCREMENT,
    UserID int NOT NULL,
    FOREIGN KEY (UserID) REFERENCES User(ID),
    RecipeID int NOT NULL,
    FOREIGN KEY (RecipeID) REFERENCES Recipe(ID),
    Comment varchar(255),

    PRIMARY KEY(ID)
);

CREATE TABLE Categories(
    ID int NOT NULL AUTO_INCREMENT,
    Description varchar(255),

    PRIMARY KEY(ID)
);

INSERT INTO `Categories`(`Description`) 
VALUES ('Frühstück'),('Mittagessen'),('Abendessen'),('Dessert');

CREATE TABLE Quantity(
    ID int NOT NULL AUTO_INCREMENT,
    Description varchar(255),

    PRIMARY KEY(ID)
);

INSERT INTO `Quantity`(`Description`) 
VALUES ('mg'),('g'),('kg'),('ml'),('l'),('Stück'),('Esslöffel'),('Teelöffel');

CREATE TABLE Ingredients(
    ID int NOT NULL AUTO_INCREMENT,
    Name varchar(255),

    PRIMARY KEY(ID)
);

INSERT INTO `Ingredients` (`Name`) VALUES ("Kartoffeln");


CREATE TABLE IngredientsRecipe(
    ID int NOT NULL AUTO_INCREMENT,

    IngredientsID int NOT NULL,
    FOREIGN KEY (IngredientsID) REFERENCES Ingredients(ID),

    RecipeID int NOT NULL,
    FOREIGN KEY (RecipeID) REFERENCES Recipe(ID),

    QuantityID int NOT NULL,
    FOREIGN KEY (QuantityID) REFERENCES Quantity(ID),
    QuantityValue int NOT NULL,

    PRIMARY KEY(ID)
);

CREATE TABLE CategoriesRecipe(
    ID int NOT NULL AUTO_INCREMENT,
    CategoriesID int NOT NULL,
    FOREIGN KEY (CategoriesID) REFERENCES Categories(ID),

    RecipeID int NOT NULL,
    FOREIGN KEY (RecipeID) REFERENCES Recipe(ID),

    PRIMARY KEY(ID)
);

CREATE TABLE Rating(
    ID int NOT NULL AUTO_INCREMENT,
    UserID int NOT NULL,
    FOREIGN KEY (UserID) REFERENCES User(ID),

    RecipeID int NOT NULL,
    FOREIGN KEY (RecipeID) REFERENCES Recipe(ID),

    RatingValue int,

    PRIMARY KEY(ID)
);