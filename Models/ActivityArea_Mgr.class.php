<?php
require_once("../Models/_BddConnexion.class.php");
class ActivityArea_Mgr {
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getActivityAreaList() {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - la liste de tous les libellés de secteurs d'activité enregistrés dans la bdd.
*/
            $sqlRequest = ' SELECT * 
                            FROM secteur_activite; ';
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
    public static function createActivityArea(String $paramString) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici insérer un nouveau secteur d'activité dans la liste.
*/
            $sqlRequest = ' INSERT INTO `secteur_activite`(`libelle_secteur`) 
                            VALUES (:string) ;';
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':string' => $paramString));
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function checkIfExists(String $paramString) {
//      Etablit une connexion à la base de données.
        $PDOconnexion = BddConnexion::getConnexion();
/*
        Prépare la requête SQL et l'enregistre dans une variable =>
        On souhaite ici contrôler si la chaîne passée en paramètre 
        est un doublon d'un élement existant dans la bdd 
*/
        $sqlRequest = ' SELECT libelle_secteur FROM secteur_activite 
                        WHERE LOWER(libelle_secteur) = LOWER(?) ';
//      Lance la requête.
        $launchRequest = $PDOconnexion->prepare($sqlRequest);
        $launchRequest->execute(array($paramString));
//      Compte le nombre de retours de la requêtes. 
        $count = $launchRequest->rowCount();
//      Réinitialise le curseur.
        $launchRequest->closeCursor();
//      Ferme la connexion.
        BddConnexion::disconnect();
        return $count;
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getUndetailedProsList() {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - une liste non détaillée des professionnels qui nous servira à 
                vérifier si la suppression d'un secteur d'activité est possible
                (si non associée à un professionnel).
*/
            $sqlRequest = ' SELECT s.ID_secteur, s.libelle_secteur, p.ID_professionnel, 
                                    p.ID_secteur, p.libelle_entreprise 
                            FROM professionnel p 
                            INNER JOIN secteur_activite s ON s.ID_secteur = p.ID_secteur; ';
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
    public static function getActivityAreaLibById(Int $paramId) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer le libellé d'une conclusion par le biais de son ID.
*/
            $sqlRequest = ' SELECT libelle_secteur
                            FROM secteur_activite
                            WHERE ID_secteur = :paramId ;' ;
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':paramId' => $paramId));
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
    public static function deleteActivityAreaById(Int $paramId) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici supprimer un secteur d'activité par son ID.
*/
            $sqlRequest = ' DELETE FROM `secteur_activite` 
                            WHERE `ID_secteur` = :secteurID; ';
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':secteurID' => $paramId));
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function updateActivityAreaById(Int $paramId, String $paramNewLabel) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici modifier un secteur d'activité par son ID.
*/
            $sqlRequest = ' UPDATE `secteur_activite` 
                            SET `libelle_secteur` = :newLabel 
                            WHERE `ID_secteur` = :paramId; ';
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':newLabel' => $paramNewLabel, ':paramId' => $paramId));
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }
    }
}
?>