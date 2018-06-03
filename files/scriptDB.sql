CREATE TABLE Users(
  idUser INTEGER NOT NULL AUTO_INCREMENT,
  login VARCHAR(25) NOT NULL,
  pwdUser VARCHAR(128) NOT NULL,
  isManual BOOL DEFAULT 0,
  PRIMARY KEY(idUser)
)ENGINE=InnoDB;

CREATE TABLE Servers(
  idServer INTEGER NOT NULL AUTO_INCREMENT,
  nameServer VARCHAR(25) NOT NULL,
  descServer TEXT,
  idOwner INTEGER NOT NULL,
  unjoinable BOOL DEFAULT 0,
  PRIMARY KEY(idServer)
)ENGINE=InnoDB;

ALTER TABLE Servers
  ADD CONSTRAINT FOREIGN KEY (idOwner)
  REFERENCES Users(idUser)
  ON DELETE CASCADE;

CREATE TABLE Players(
  idServer INTEGER NOT NULL,
  idPlayer INTEGER NOT NULL,
  role ENUM('En attente', 'Loup Garou', 'Loup Blanc', 'Voyante', 'Statistiscien', 'Voyante Corrompue', 'Sorcière Corrompue') NOT NULL DEFAULT 'En attente',
  phase INTEGER DEFAULT 0,
  numPlayer INTEGER,
  roadSheet VARCHAR(256),
  isDead BOOL DEFAULT 0,
  PRIMARY KEY(idServer,idPlayer)
)ENGINE=InnoDB;

CREATE TABLE WerewolfTargets(
  idServer INTEGER NOT NULL,
  idTargeted INTEGER NOT NULL,
  idTargeter INTEGER NOT NULL,
  PRIMARY KEY (idServer,idTargeter,idTargeted)
) ENGINE=InnoDB;

CREATE TABLE VillageTargets(
  idServer INTEGER NOT NULL,
  idTargeted INTEGER NOT NULL,
  idTargeter INTEGER NOT NULL,
  PRIMARY KEY (idServer,idTargeter,idTargeted)
) ENGINE=InnoDB;

ALTER TABLE Players
  ADD CONSTRAINT FOREIGN KEY (idServer)
  REFERENCES Servers(idServer)
  ON DELETE CASCADE;

ALTER TABLE Players
  ADD CONSTRAINT FOREIGN KEY (idPlayer)
  REFERENCES Users(idUser)
  ON DELETE CASCADE;

ALTER TABLE WerewolfTargets
  ADD CONSTRAINT FOREIGN KEY (idServer)
  REFERENCES Servers(idServer)
  ON DELETE CASCADE;

ALTER TABLE WerewolfTargets
  ADD CONSTRAINT FOREIGN KEY (idTargeted)
  REFERENCES Users(idUser)
  ON DELETE CASCADE;

ALTER TABLE WerewolfTargets
  ADD CONSTRAINT FOREIGN KEY (idTargeter)
  REFERENCES Users(idUser)
  ON DELETE CASCADE;

ALTER TABLE VillageTargets
  ADD CONSTRAINT FOREIGN KEY (idServer)
  REFERENCES Servers(idServer)
  ON DELETE CASCADE;

ALTER TABLE VillageTargets
  ADD CONSTRAINT FOREIGN KEY (idTargeted)
  REFERENCES Users(idUser)
  ON DELETE CASCADE;

ALTER TABLE VillageTargets
  ADD CONSTRAINT FOREIGN KEY (idTargeter)
  REFERENCES Users(idUser)
  ON DELETE CASCADE;

