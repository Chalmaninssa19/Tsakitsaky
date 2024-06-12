--Vue pour la matiere premiere et unite
CREATE VIEW v_matiere_premiere_unite AS
SELECT m.id_matiere_premiere, m.designation, m.prix_unitaire, m.etat, u.nom unite
FROM matiere_premiere m 
JOIN unite u
ON m.unite_id = u.id_unite;

--Vue pour la matiere premiere quantite
CREATE VIEW v_matiere_premiere_quantite AS
SELECT m.id_matiere_premiere, m.designation, m.unite, mp.quantite, mp.pack_id
FROM v_matiere_premiere_unite m
JOIN matiere_premiere_pack mp
ON m.id_matiere_premiere = mp.matiere_premiere_id;

--Vue pour relier matiere_premiere_pack et pack
CREATE VIEW v_matiere_premiere_pack AS
SELECT m.id_matiere_premiere_pack, m.matiere_premiere_id, m.quantite, p.id_pack, p.nom pack, p.photo, 
p.description, p.prix_unitaire prix_unitaire_pack, mp.designation matiere_premiere, mp.prix_unitaire 
prix_unitaire_mp, mp.unite
FROM matiere_premiere_pack m
JOIN pack p
ON m.pack_id = p.id_pack
JOIN v_matiere_premiere_unite mp
ON mp.id_matiere_premiere = m.matiere_premiere_id;

--Vue pour avoir le montant des matieres premieres necesaires
CREATE VIEW v_matiere_premiere_necessaire AS
select id_pack ,pack, sum(quantite * prix_unitaire_mp) prix_revient
from v_matiere_premiere_pack group by pack, id_pack;

--Vue pour relier vente billet et etudiant et pack
CREATE OR REPLACE VIEW v_vente_billet_etudiant_details AS
SELECT e.id_etudiant, e.nom nom_etudiant, e.prenom prenom_etudiant, e.email email_etudiant, 
e.contact contact_etudiant, v.id_vente_billet, v.pack_id, v.quantite, v.date_vente, v.etat, 
p.id_pack, p.nom pack, p.photo photo_pack, p.description description_pack,p.prix_unitaire,
l.nom nom_axe, l.axe, l.id_axe_livraison, v.nom_client, v.contact_client
FROM etudiant e
LEFT JOIN vente_billet v
ON e.id_etudiant = v.etudiant_id
LEFT JOIN pack p 
ON p.id_pack = v.pack_id
LEFT JOIN axe_livraison l 
ON v.axe_livraison_id = l.id_axe_livraison;

--Vue pour avoir les montant de m1res necessaire par etudiant
CREATE VIEW v_montant_mp_necessaire_etudiant AS
SELECT v.id_etudiant, sum(v.quantite * m.prix_revient) montant_mp_necessaire 
FROM  v_vente_billet_etudiant_details v
JOIN v_matiere_premiere_necessaire m
ON m.id_pack = v.pack_id
GROUP BY v.id_etudiant;

--Vue pour relier vente billet et pack
CREATE OR REPLACE VIEW v_etat_vente_etudiant AS
SELECT v.id_etudiant, v.nom_etudiant, v.prenom_etudiant, COALESCE(sum(v.quantite), 0)::NUMERIC(10, 2) quantite, 
COALESCE(sum(v.quantite * v.prix_unitaire), 0)::NUMERIC(10, 2) montant_billet,
COALESCE((select mne.montant_mp_necessaire from v_montant_mp_necessaire_etudiant mne 
where mne.id_etudiant=v.id_etudiant), 0)::NUMERIC(10, 2) AS montant_mp_necessaire
FROM v_vente_billet_etudiant_details v
GROUP BY v.id_etudiant, v.nom_etudiant, v.prenom_etudiant;

--Vue pour avoir les billets vendus par etudiant groupes par billets
CREATE OR REPLACE VIEW v_billet_vendu_etudiant AS
SELECT vbe.id_etudiant, vbe.pack_id, vbe.pack, COALESCE(sum(vbe.quantite), 0)::NUMERIC(10, 2) quantite,
vbe.prix_unitaire, COALESCE(sum(vbe.quantite) * vbe.prix_unitaire, 0)::NUMERIC(10, 2) as montant,
COALESCE((select mpn.prix_revient from v_matiere_premiere_necessaire mpn 
where mpn.id_pack = vbe.pack_id), 0)::NUMERIC(10, 2) as montant_mp_necessaire_unitaire
from v_vente_billet_etudiant_details vbe group by vbe.id_etudiant, vbe.pack_id, vbe.prix_unitaire
,vbe.pack;

--Vue pour avoir le paiement d'un etudiant
CREATE VIEW v_paiement_billet AS
SELECT etudiant_id, sum(montant_paye) montant_deja_paye 
FROM paiement_billet group by etudiant_id;

--Vue pour l'etat de paiement des billets par etudiant
CREATE VIEW v_etat_paiement AS
SELECT e.id_etudiant, e.nom_etudiant, e.prenom_etudiant,
COALESCE(p.montant_deja_paye, 0)::NUMERIC(10, 2) AS montant_deja_paye, 
COALESCE(e.montant_billet, 0)::NUMERIC(10, 2) AS montant_total_paye, 
(e.montant_billet - COALESCE(p.montant_deja_paye, 0))::NUMERIC(10, 2) AS montant_reste_paye
FROM v_etat_vente_etudiant e
LEFT JOIN v_paiement_billet p
ON e.id_etudiant = p.etudiant_id;

--Vue pour livraison par axe
CREATE OR REPLACE VIEW v_livraison_axe AS
SELECT l.id_axe_livraison, l.nom, l.axe,
(SELECT COALESCE(sum(v.quantite), 0)::NUMERIC(10, 2) FROM v_vente_billet_etudiant_details v 
WHERE v.id_axe_livraison = l.id_axe_livraison) AS quantite
FROM axe_livraison l;

--Vue pour avoir le montant et nombre des packs
CREATE OR REPLACE VIEW v_vente_pack AS
SELECT p.id_pack, p.nom, p.prix_unitaire,
COALESCE((SELECT sum(v.quantite) FROM vente_billet v WHERE p.id_pack = v.pack_id), 0)::NUMERIC(10, 2) quantite,
COALESCE((SELECT sum(v.quantite)*p.prix_unitaire FROM vente_billet v WHERE p.id_pack = v.pack_id), 0)::NUMERIC(10, 2) montant
FROM pack p where deleted_at IS NULL; 

--Suppression des donnees
TRUNCATE pack;
TRUNCATE etudiant;
TRUNCATE axe_livraison;
TRUNCATE paiement_billet;

--Repartition des donnees dans leurs propres tables
alter table pack alter column photo type varchar(255);
INSERT INTO pack(nom)
SELECT code_pack FROM import_vente_billet;  


--Script train importation csv
create database train_import_csv;
\c train_import_csv;

CREATE TABLE seance_temp (
    num_seance integer primary key,
    film varchar(255),
    categorie varchar(255),
    salle varchar(255),
    date date,
    heure time
);

create table categorie (
    id_categorie serial primary key,
    designation varchar(255)
);

create table salle (
    id_salle serial primary key,
    designation varchar(255)
);

create table film (
    id_film serial primary key,
    designation varchar(255),
    id_categorie integer references categorie(id_categorie)
);

create table seance(
    id_seance serial primary key,
    id_film integer references film(id_film),
    id_salle integer references salle(id_salle),
    date date, 
    heure time
);

insert into seance_temp(num_seance, film, categorie, salle, date, heure) values
(10,'Piège de cristal', 'Action', 'Salle 4', '2024-03-01', '10:30'),	
(14, 'Piège de cristal', 'Action', 'Salle 4', '2024-03-01', '15:30'),
(11, 'Piège de cristal', 'Action', 'Salle 4', '02-03-2024', '10:30'),
(90, 'Shrek 2', 'Animation', 'Salle 1', '2024-03-03', '10:00'),
(18, 'Piège de cristal', 'Action', 'Salle 3', '2024-03-02', '19:00'),
(17, 'Shrek 2', 'Animation', 'Salle 2', '2024-03-03', '10:00'),
(21, 'Hot Shot', 'Comédie', 'Salle 1', '2024-02-01', '21:00');

insert into salle (designation) select salle from seance_temp group by salle;
insert into categorie (designation) select categorie from seance_temp group by categorie;
insert into film(designation, id_categorie) 
select s.film, c.id_categorie from seance_temp s join categorie c 
on s.categorie = c.designation group by s.film, c.id_categorie;
insert into seance (id_seance, id_film, id_salle, date, heure)
select s.num_seance, f.id_film, salle.id_salle, s.date, s.heure
from seance_temp s join film f on f.designation = s.film
join salle salle on salle.designation = s.salle;