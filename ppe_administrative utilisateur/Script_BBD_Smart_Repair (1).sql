-- Smart Repair PPE 2018

-- BDD Creation 


-- Boutique d'un reparateur
CREATE TABLE reparateur
(
  id_reparateur int NOT NULL,
  nom char(255),
  id_adresse_ref int, 
  description char(255),
  moyen_paiement_cash boolean,
  moyen_paiement_carte boolean,
  moyen_paiement_cheque boolean,
  note float,
  site_internet varchar(255),
  mail varchar(255),
  mot_de_passe varchar(255),
  
  PRIMARY KEY (id_reparateur),
  FOREIGN KEY (id_adresse_ref) REFERENCES adresse(id_adresse)
);

CREATE TABLE adresse
(
	id_adresse int NOT NULL,
	adresse varchar(255),
	lat float,
	lng float

); 
CREATE TABLE utilisateur
(
   id_utilisateur int NOT NULL ,
   prenom varchar(255),
   nom varchar(255),
   mail varchar(255),
   mot_de_passe varchar(255),

   PRIMARY KEY (id_utilisateur)
);


CREATE TABLE concordance_note_reparateur_utilisateur
(
	id_concordance_note_reparateur_utilisateur int NOT NULL  ,
	id_utilisateur_ref int NOT NULL,
	id_reparateur_ref int NOT NULL,


	FOREIGN KEY (id_utilisateur_ref) REFERENCES utilisateur(id_utilisateur),
	FOREIGN KEY (id_reparateur_ref) REFERENCES reparateur(id_reparateur)


);

CREATE TABLE concordance_marque_reparateur
(
	id_concordance_marque_reparateur int NOT NULL  ,
	id_marque_ref int NOT NULL,
	id_reparateur_ref int NOT NULL,


	FOREIGN KEY (id_marque_ref) REFERENCES marque(id_marque),
	FOREIGN KEY (id_reparateur_ref) REFERENCES reparateur(id_reparateur)


);

CREATE TABLE concordance_probleme_reparateur
(
	id_concordance_probleme_reparateur int NOT NULL  ,
	id_probleme_ref int NOT NULL,
	id_reparateur_ref int NOT NULL,


	FOREIGN KEY (id_probleme_ref) REFERENCES probleme(id_probleme_ref),
	FOREIGN KEY (id_reparateur_ref) REFERENCES reparateur(id_reparateur)


);

CREATE TABLE note
(
   id_note int NOT NULL  ,
   prix int,
   amabilite int,
   temps int,
   fiabilite int,
   description varchar(255),
   date_poster date,
   utilisateur_ref int,
   reparateur_ref int,
   
    PRIMARY KEY (id_note),
	FOREIGN KEY (utilisateur_ref) REFERENCES utilisateur(id_utilisateur),
	FOREIGN KEY (reparateur_ref) REFERENCES reparateur(id_reparateur)
);

CREATE TABLE marque
(
	id_marque int NOT NULL,
    nom char(255),
	
    PRIMARY KEY (id_marque)

);

CREATE TABLE modele
(
	id_modele int NOT NULL,
    nom char(255),
    id_marque_ref int,
    
	PRIMARY KEY (id_modele),
    FOREIGN KEY (id_marque_ref) REFERENCES marque(id_marque)
 
);

CREATE TABLE probleme
(
	id_probleme int NOT NULL  ,
    nom char(255),
    description char(255),
    modele_ref int,
    prix float,

    PRIMARY KEY (id_probleme),
    FOREIGN KEY (modele_ref) REFERENCES modele(id_modele)


);
