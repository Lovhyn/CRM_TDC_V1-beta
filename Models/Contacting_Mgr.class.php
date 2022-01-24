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
                - la liste de tous les types de contact enregistrés dans la bdd.
*/
            $sqlRequest = ' SELECT * 
                            FROM `nature_du_contact`; ';
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
    public static function getProspectActivity(Int $paramProId) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
            - la liste de tous les suivis enregistrés pour un prospect.
*/
            $sqlRequest = " SELECT 
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
                            WHERE p.prospect_ou_client = 0 AND s.`ID_professionnel` = :paramProId ;";
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
}