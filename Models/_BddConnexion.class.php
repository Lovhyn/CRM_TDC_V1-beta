<?php
class BddConnexion {
//  Données membres------------------------------------------------------------
    private static $connexion;
//  ---------------------------------------------------------------------------
//  Cette fonction permet la connexion à la base de données. 
//  (Elle utilise le fichier parameters.ini qui peut être modifié par l'utilisateur).
    private static function connect() {
        $file = '../Param/parameters.ini';
        if (file_exists($file)) {
            $tParam = parse_ini_file($file);
//          Génère les variables dynamiquement
            extract($tParam); 
            $dsn = "mysql:host=" . $host . "; port=" . $port . "; dbname=" . $bdd . "; charset=utf8";
            $mysqlPDO = new PDO(
                $dsn,
                $user,
                $password,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
            BddConnexion::$connexion = $mysqlPDO;
            return BddConnexion::$connexion;
        } else {
            throw new Exception("ERR:Fichier de paramètre inconnu");
        }
    }
//  Fonction de 'déconnexion' de la BDD.
    public static function disconnect() {
        BddConnexion::$connexion = null;
    }
//  Pattern singleton.
    public static function getConnexion() {

        if (BddConnexion::$connexion != null) {
            return BddConnexion::$connexion;
        } else {
            return BddConnexion::connect();
        }
    }
}
