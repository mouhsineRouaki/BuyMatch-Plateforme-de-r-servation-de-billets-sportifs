CREATE DATABASE buymatch ;
USE buymatch;

CREATE TABLE utilisateur (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    actif BOOLEAN DEFAULT TRUE,
    role ENUM('ACHETEUR', 'ORGANISATEUR', 'ADMINISTRATEUR') NOT NULL
);

CREATE TABLE utilisateur (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    actif BOOLEAN DEFAULT TRUE,
    role ENUM('ACHETEUR', 'ORGANISATEUR', 'ADMINISTRATEUR') NOT NULL
);

CREATE TABLE acheteur (
    id_user INT PRIMARY KEY,
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE
);

CREATE TABLE organisateur (
    id_user INT PRIMARY KEY,
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE
);

CREATE TABLE administrateur (
    id_user INT PRIMARY KEY,
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE
);

CREATE TABLE equipe (
    id_equipe INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    logo VARCHAR(255)
);

CREATE TABLE statistique (
    id_statistique INT AUTO_INCREMENT PRIMARY KEY,
    nb_billet_vendus INT DEFAULT 0,
    chiffre_affaire FLOAT DEFAULT 0
);

CREATE TABLE match (
    id_match INT AUTO_INCREMENT PRIMARY KEY,
    date_match DATE NOT NULL,
    heure TIME NOT NULL,
    duree INT NOT NULL,
    statut VARCHAR(50),
    note_moyenne FLOAT,
    nb_total INT,
    id_organisateur INT NOT NULL,
    id_statistique INT UNIQUE,

    FOREIGN KEY (id_organisateur) REFERENCES organisateur(id_user),
    FOREIGN KEY (id_statistique) REFERENCES statistique(id_statistique)
);

CREATE TABLE match_equipe (
    id_match INT,
    id_equipe INT,
    PRIMARY KEY (id_match, id_equipe),
    FOREIGN KEY (id_match) REFERENCES match(id_match) ON DELETE CASCADE,
    FOREIGN KEY (id_equipe) REFERENCES equipe(id_equipe) ON DELETE CASCADE
);

/* =====================================================
   CATEGORY
===================================================== */
CREATE TABLE category (
    id_category INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prix FLOAT NOT NULL,
    nb_place INT NOT NULL,
    id_match INT NOT NULL,
    FOREIGN KEY (id_match) REFERENCES match(id_match) ON DELETE CASCADE
);

/* =====================================================
   BILLET
===================================================== */
CREATE TABLE billet (
    id_billet INT AUTO_INCREMENT PRIMARY KEY,
    date_achat DATETIME NOT NULL,
    prix FLOAT NOT NULL,
    place INT NOT NULL,
    id_match INT NOT NULL,
    id_acheteur INT NOT NULL,
    FOREIGN KEY (id_match) REFERENCES match(id_match),
    FOREIGN KEY (id_acheteur) REFERENCES acheteur(id_user)
);

/* =====================================================
   COMMENTAIRE
===================================================== */
CREATE TABLE commentaire (
    id_commentaire INT AUTO_INCREMENT PRIMARY KEY,
    contenu TEXT NOT NULL,
    note INT CHECK (note BETWEEN 1 AND 5),
    date_commentaire DATETIME NOT NULL,
    id_match INT NOT NULL,
    id_acheteur INT NOT NULL,

    FOREIGN KEY (id_match) REFERENCES match(id_match) ON DELETE CASCADE,
    FOREIGN KEY (id_acheteur) REFERENCES acheteur(id_user) ON DELETE CASCADE
);


