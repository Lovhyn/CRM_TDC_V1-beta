<?php
require_once("../Models/_BddConnexion.class.php");
class InfosInterlocutor_Mgr {
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function createInterlocutorInfos($paramName, $paramContact) {
        if ($paramName === '') {
            $paramName = NULL;
        } 
        if ($paramContact === '') {
            $paramContact = NULL;
        }
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici insérer une nouvelle prise de contact avec rdv dans la bdd. 
*/
            $sqlRequest = ' INSERT INTO `infos_interlocuteur` (
                            `nom_interlocuteur`, `contact_interlocuteur`) 
                            VALUES (
                            :paramName, :paramContact); ';
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':paramName' => $paramName, ':paramContact' => $paramContact));
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }  
    }
}
