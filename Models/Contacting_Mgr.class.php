<?php
require_once("../Models/_BddConnexion.class.php");
class Contacting_Mgr {
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getInterlocutorsList() {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - la liste de tous les types d'interlocuteurs enregistrés dans la bdd.
*/
            $sqlRequest = ' SELECT * 
                            FROM `interlocuteur`; ';
//          Connexion PDO + soumission de la requête.
            $repPDO = $PDOconnexion->query($sqlRequest);
//          On définit sous quelle forme nous souhaitons récupérer le résultat.
            $repPDO->setFetchMode(PDO::FETCH_ASSOC);
//          On récupère le résultat de la requête sous la forme d'un tableau associatif.
            $records = $repPDO->fetchAll();
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
//          Puis on retourne ce tableau.
            return $records;
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }            
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getContactTypeList() {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - la liste de tous les types de contact enregistrés dans la bdd sauf le cas "autre".
*/
            $sqlRequest = " SELECT * 
                            FROM `nature_du_contact` WHERE `libelle_nature` <> 'Autre' ;";
//          Connexion PDO + soumission de la requête.
            $repPDO = $PDOconnexion->query($sqlRequest);
//          On définit sous quelle forme nous souhaitons récupérer le résultat.
            $repPDO->setFetchMode(PDO::FETCH_ASSOC);
//          On récupère le résultat de la requête sous la forme d'un tableau associatif.
            $records = $repPDO->fetchAll();
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
//          Puis on retourne ce tableau.
            return $records;
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }            
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getIdContactTypeWhereCaseIsOther() {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - l'identifiant du cas "autre" qui servira pour l'ajout de suivi automatique
                lors de l'enregistrement direct d'un client.
*/
            $sqlRequest = " SELECT ID_nature 
                            FROM `nature_du_contact` WHERE `libelle_nature` = 'Autre' ;";
//          Connexion PDO + soumission de la requête.
            $repPDO = $PDOconnexion->query($sqlRequest);
//          On définit sous quelle forme nous souhaitons récupérer le résultat.
            $repPDO->setFetchMode(PDO::FETCH_ASSOC);
//          On récupère le résultat de la requête sous la forme d'un tableau associatif.
            $records = $repPDO->fetchAll();
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
//          Puis on retourne ce tableau.
            return $records;
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }            
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function createNewContactMeeting(Int $userId, Int $proId, Int $interlocutorId, Int $infosInterlocutorId,
                                                Int $contactTypeId, Int $conclusionId, String $contactComment, 
                                                String $lastContact, String $meetingDate) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici insérer une nouvelle prise de contact avec rdv dans la bdd. 
*/
            $sqlRequest = ' INSERT INTO `suivre` (
                            `ID_utilisateur`, `ID_professionnel`, `ID_interlocuteur`, `ID_infos_interlocuteur`, `ID_nature`, 
                            `ID_conclusion`, `commentaire`, `date_derniere_pdc`, `date_rdv`) 
                            VALUES (
                            :userId, :proId, :interlocutorId, :infosInterlocutorId, :contactTypeId, :conclusionId, :contactComment,
                            :lastContact, :meetingDate); ';
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':userId' => $userId, ':proId' => $proId, ':interlocutorId' => $interlocutorId, 
                                    ':infosInterlocutorId' => $infosInterlocutorId, ':contactTypeId' => $contactTypeId, 
                                    ':conclusionId' => $conclusionId, ':contactComment' => $contactComment, 
                                    ':lastContact' => $lastContact,
                                    ':meetingDate' => $meetingDate));
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }  
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function createNewContactRecall(Int $userId, Int $proId, Int $interlocutorId, Int $infosInterlocutorId,
                                                Int $contactTypeId, Int $conclusionId, String $contactComment, 
                                                String $lastContact, String $recallDate) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici insérer une nouvelle prise de contact avec relance dans la bdd. 
*/
            $sqlRequest = ' INSERT INTO `suivre` (
                            `ID_utilisateur`, `ID_professionnel`, `ID_interlocuteur`, `ID_infos_interlocuteur`, `ID_nature`, 
                            `ID_conclusion`, `commentaire`, `date_derniere_pdc`, `date_relance`) 
                            VALUES (
                            :userId, :proId, :interlocutorId, :infosInterlocutorId, :contactTypeId, :conclusionId, :contactComment,
                            :lastContact,:recallDate); ';
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':userId' => $userId, ':proId' => $proId, ':interlocutorId' => $interlocutorId, 
                                    ':infosInterlocutorId' => $infosInterlocutorId, ':contactTypeId' => $contactTypeId, 
                                    ':conclusionId' => $conclusionId, ':contactComment' => $contactComment, 
                                    ':lastContact' => $lastContact,
                                    ':recallDate' => $recallDate));
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }  
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function createNewContactWhenAddedCustomer(Int $userId, Int $proId, Int $interlocutorId, Int $infosInterlocutorId,
                                                Int $contactTypeId, Int $conclusionId, String $contactComment, 
                                                String $lastContact) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici insérer une nouvelle prise de contact dans le contexte d'un enregistrement client. 
*/
            $sqlRequest = ' INSERT INTO `suivre` (
                            `ID_utilisateur`, `ID_professionnel`, `ID_interlocuteur`, `ID_infos_interlocuteur`, `ID_nature`, 
                            `ID_conclusion`, `commentaire`, `date_derniere_pdc`) 
                            VALUES (
                            :userId, :proId, :interlocutorId, :infosInterlocutorId, :contactTypeId, :conclusionId, :contactComment,
                            :lastContact); ';
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':userId' => $userId, ':proId' => $proId, ':interlocutorId' => $interlocutorId, 
                                    ':infosInterlocutorId' => $infosInterlocutorId, ':contactTypeId' => $contactTypeId, 
                                    ':conclusionId' => $conclusionId, ':contactComment' => $contactComment, 
                                    ':lastContact' => $lastContact));
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }  
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getIdInterlocutorTypeWhereCaseIsOther() {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - l'identifiant du cas "autre" qui servira pour l'ajout de suivi automatique
                lors de l'enregistrement direct d'un client.
*/
            $sqlRequest = " SELECT ID_interlocuteur 
                            FROM `interlocuteur` WHERE `libelle_interlocuteur` = 'Autre' ;";
//          Connexion PDO + soumission de la requête.
            $repPDO = $PDOconnexion->query($sqlRequest);
//          On définit sous quelle forme nous souhaitons récupérer le résultat.
            $repPDO->setFetchMode(PDO::FETCH_ASSOC);
//          On récupère le résultat de la requête sous la forme d'un tableau associatif.
            $records = $repPDO->fetchAll();
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
//          Puis on retourne ce tableau.
            return $records;
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }            
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getProActivity(Int $paramProId) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
            - la liste de tous les suivis enregistrés pour un professionnel.
*/
            $sqlRequest = " SELECT 
                            s.`ID_suivre`,
                            s.`date_derniere_pdc`, 
                            s.`ID_utilisateur`, CONCAT(SUBSTRING(u.`nom`, 1, 1), '.', u.`prenom`) as `suivi`,
                            u.`nom`, u.`prenom`, 
                            s.`ID_interlocuteur`, i.`libelle_interlocuteur`,
                            s.`ID_infos_interlocuteur`, inf.`nom_interlocuteur`, inf.`contact_interlocuteur`,
                            s.`ID_nature`, n.`libelle_nature`,
                            s.`ID_conclusion`, c.`libelle_conclusion`,
                            s.`commentaire`,
                            s.`date_derniere_pdc`,
                            s.`date_rdv`,
                            s.`date_relance`,
                            p.ID_professionnel, p.`libelle_entreprise`, p.`nom_decideur`, p.`tel`, p.`tel_2`, p.`mail`,
                            p.prospect_ou_client
                            FROM `suivre` s
                            INNER JOIN `utilisateur` u ON s.`ID_utilisateur` = u.`ID_utilisateur`
                            INNER JOIN `interlocuteur` i ON s.`ID_interlocuteur` = i.`ID_interlocuteur`
                            INNER JOIN `infos_interlocuteur` inf ON s.`ID_infos_interlocuteur` = inf.`ID_infos_interlocuteur`
                            INNER JOIN `nature_du_contact` n ON s.`ID_nature` = n.`ID_nature`
                            INNER JOIN `conclusion` c ON s.`ID_conclusion` = c.`ID_conclusion`
                            INNER JOIN `professionnel` p ON s.`ID_professionnel` = p.`ID_professionnel`
                            WHERE s.`ID_professionnel` = :paramProId ORDER BY s.`date_derniere_pdc` DESC ;";
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':paramProId' => $paramProId));
//          On définit sous quelle forme nous souhaitons récupérer le résultat.
            $repPDO->setFetchMode(PDO::FETCH_ASSOC);
//          On récupère le résultat de la requête sous la forme d'un tableau associatif.
            $records = $repPDO->fetchAll();
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
//          Puis on retourne ce tableau.
            return $records;
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function checkIfExists(Int $paramId) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici contrôler si la chaîne passée en paramètre 
            est un doublon d'un élement existant dans la bdd 
*/
            $sqlRequest = " SELECT ID_suivre FROM suivre 
                            WHERE ID_suivre = :paramId ;";
//          Lance la requête.
            $launchRequest = $PDOconnexion->prepare($sqlRequest);
            $launchRequest->execute(array(':paramId' => $paramId));
//          Compte le nombre de retours de la requêtes. 
            $count = $launchRequest->rowCount();
//          Réinitialise le curseur.
            $launchRequest->closeCursor();
//          Ferme la connexion.
            BddConnexion::disconnect();
            return (int) $count;
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getLastAutoIncrementValue() {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - l'identifiant du dernier enregistrement dans la table suivre.
*/
            $sqlRequest = " SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES 
                            WHERE TABLE_SCHEMA = 'dbs5021355' AND TABLE_NAME = 'suivre'; ";
//          Connexion PDO + soumission de la requête.
            $repPDO = $PDOconnexion->query($sqlRequest);
//          On définit sous quelle forme nous souhaitons récupérer le résultat.
            $repPDO->setFetchMode(PDO::FETCH_ASSOC);
//          On récupère le résultat de la requête sous la forme d'un tableau associatif.
            $records = $repPDO->fetchAll();
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
//          Puis on retourne ce tableau.
            return $records;
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getInfosContactWhereDateIs(String $paramDate) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - l'identifiant, le commentaire et le libelle de la conclusion d'une prise de contact 
                dont la date est donnée en paramètre sous forme de valeur unix string.
*/
            $sqlRequest = " SELECT 
                            s.`ID_conclusion`, 
                            s.`commentaire`,
                            c.`libelle_conclusion`
                            FROM `suivre` s
                            INNER JOIN `conclusion` c ON s.`ID_conclusion` = c.`ID_conclusion`
                            WHERE s.`date_derniere_pdc` = :paramDate ; ";
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':paramDate' => $paramDate));
//          On définit sous quelle forme nous souhaitons récupérer le résultat.
            $repPDO->setFetchMode(PDO::FETCH_ASSOC);
//          On récupère le résultat de la requête sous la forme d'un tableau associatif.
            $records = $repPDO->fetchAll();
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
//          Puis on retourne ce tableau.
            return $records;
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }            
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getOldestContactingDate() {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - la date de la première prise de contact effectuée.
*/
            $sqlRequest = " SELECT 
                            MIN(date_derniere_pdc) as 'oldestContact'
                            FROM `suivre`; ";
//          Exécute la requête
            $repPDO = $PDOconnexion->query($sqlRequest);
//          On définit sous quelle forme nous souhaitons récupérer le résultat.
            $repPDO->setFetchMode(PDO::FETCH_ASSOC);
//          On récupère le résultat de la requête sous la forme d'un tableau associatif.
            $records = $repPDO->fetchAll();
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
//          Puis on retourne ce tableau.
            return $records;
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }            
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getLastContactingDate() {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - la date de de la dernière prise de contact effectuée.
*/
            $sqlRequest = " SELECT 
                            MAX(date_derniere_pdc) as 'lastContact'
                            FROM `suivre`; ";
//          Exécute la requête
            $repPDO = $PDOconnexion->query($sqlRequest);
//          On définit sous quelle forme nous souhaitons récupérer le résultat.
            $repPDO->setFetchMode(PDO::FETCH_ASSOC);
//          On récupère le résultat de la requête sous la forme d'un tableau associatif.
            $records = $repPDO->fetchAll();
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
//          Puis on retourne ce tableau.
            return $records;
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }            
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getAllPlannedMeetings(Int $paramUser) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer un ensemble d'informations pour le widget de rappels de rendez-vous.
*/
            $sqlRequest = " SELECT 
                            s.`date_rdv`,
                            s.`ID_professionnel`, 
                            s.`ID_utilisateur`,
                            s.`date_derniere_pdc`,
                            s.`commentaire`,
                            p.`libelle_entreprise`,
                            p.`nom_decideur`,
                            p.`tel`,
                            p.`adresse`,
                            p.`cp`,
                            p.`ville`
                            FROM suivre s
                            INNER JOIN professionnel p ON p.`ID_professionnel` = s.`ID_professionnel`
                            WHERE `date_rdv` IS NOT NULL
                            AND s.ID_utilisateur = :paramUser 
                            ORDER BY s.`date_rdv` ASC; ";
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':paramUser' => $paramUser));
//          On définit sous quelle forme nous souhaitons récupérer le résultat.
            $repPDO->setFetchMode(PDO::FETCH_ASSOC);
//          On récupère le résultat de la requête sous la forme d'un tableau associatif.
            $records = $repPDO->fetchAll();
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
//          Puis on retourne ce tableau.
            return $records;
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }            
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getAllPlannedRecalls(Int $paramUser) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer un ensemble d'informations pour le widget de rappels de rendez-vous.
*/
            $sqlRequest = " SELECT 
                            s.`date_relance`,
                            s.`ID_professionnel`, 
                            s.`ID_utilisateur`,
                            s.`date_derniere_pdc`,
                            s.`ID_conclusion`,
                            c.`libelle_conclusion`,
                            s.`commentaire`,
                            p.`libelle_entreprise`,
                            p.`tel`
                            FROM suivre s
                            INNER JOIN professionnel p ON p.`ID_professionnel` = s.`ID_professionnel`
                            INNER JOIN conclusion c ON s.`ID_conclusion` = c.`ID_conclusion`
                            WHERE `date_relance` IS NOT NULL
                            AND s.ID_utilisateur = :paramUser 
                            LIMIT 8; ";
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':paramUser' => $paramUser));
//          On définit sous quelle forme nous souhaitons récupérer le résultat.
            $repPDO->setFetchMode(PDO::FETCH_ASSOC);
//          On récupère le résultat de la requête sous la forme d'un tableau associatif.
            $records = $repPDO->fetchAll();
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
//          Puis on retourne ce tableau.
            return $records;
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }            
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getUpdatableContactByIdPro(Int $paramIdPro) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer la date de la dernière prise de contact effectuée
            avec un professionnel où la conclusion obtenue n'est pas "Création client".
*/
            $sqlRequest = " SELECT MAX(`date_derniere_pdc`) AS 'last_pdc'
                            FROM suivre 
                            WHERE `ID_professionnel` = :paramIdPro AND `ID_conclusion` <> 21; ";
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':paramIdPro' => $paramIdPro));
//          On définit sous quelle forme nous souhaitons récupérer le résultat.
            $repPDO->setFetchMode(PDO::FETCH_ASSOC);
//          On récupère le résultat de la requête sous la forme d'un tableau associatif.
            $records = $repPDO->fetchAll();
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
//          Puis on retourne ce tableau.
            return $records;
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }            
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function updateMeetingDate(String $paramComment, String $paramDate, Int $paramIdContact) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici mettre à jour une prise de contact dans le cas où l'utilisateur 
            est amené à changer la date d'un rendez-vous.
*/
            $sqlRequest = " UPDATE `suivre`
                            SET `commentaire` = :paramComment, 
                                `date_rdv` = :paramDate
                            WHERE `ID_suivre` = :paramIdContact ; ";
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':paramComment' => $paramComment,
                                    ':paramDate' => $paramDate,
                                    ':paramIdContact' => $paramIdContact));
//          On définit sous quelle forme nous souhaitons récupérer le résultat.
            $repPDO->setFetchMode(PDO::FETCH_ASSOC);
//          On récupère le résultat de la requête sous la forme d'un tableau associatif.
            $records = $repPDO->fetchAll();
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
//          Puis on retourne ce tableau.
            return $records;
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }            
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function updateRecallDate(String $paramDate, Int $paramIdContact) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici mettre à jour une prise de contact dans le cas où l'utilisateur 
            est amené à changer la date d'une relance.
*/
            $sqlRequest = " UPDATE `suivre`
                            SET `date_relance` = :paramDate
                            WHERE `ID_suivre` = :paramIdContact ; ";
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':paramDate' => $paramDate,
                                    ':paramIdContact' => $paramIdContact));
//          On définit sous quelle forme nous souhaitons récupérer le résultat.
            $repPDO->setFetchMode(PDO::FETCH_ASSOC);
//          On récupère le résultat de la requête sous la forme d'un tableau associatif.
            $records = $repPDO->fetchAll();
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
//          Puis on retourne ce tableau.
            return $records;
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }            
    }
}