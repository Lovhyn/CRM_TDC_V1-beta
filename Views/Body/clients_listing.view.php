<!--$_POST = OK-->
<?php
$userConnected = (int) $_SESSION['idUser'];
$rights = (int) $_SESSION['rights'];
?>
<div class="container">
<hr>
    <div class="d-flex justify-content-center mt-3">
        <h2 >Clients</h2>
    </div>
<?php 
if ($rights != 1 ) {
    if($rights === 2) {
        echo
        '<form class="d-flex justify-content-center mt-3" action="/outils/Controllers/Controller_responsable.php" method="post">';
    } else {
        echo
        '<form class="d-flex justify-content-center mt-3" action="/outils/Controllers/Controller_cdp.php" method="post">';
    }
} else {
    echo
        '<form class="d-flex justify-content-center mt-3" action="/outils/Controllers/Controller_admin.php" method="post">';
}
    echo
            '<input type="hidden" name="action" value="addNewClientForm">
            <button type="submit" class="addNewClientIcon" title="Enregistrer un nouveau client">
                <i class="fas fa-user-tie"></i>
            </button>
        </form>';
?>
    <div class="d-flex justify-content-center">
        <table class="table table-hover table-striped table-dark mt-3 w-auto" 
                data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
            <thead>
                <tr>
                    <th data-sortable="true">Nom</th>
                    <th>Décideur</th>
                    <th>Lieu</th>
                    <th data-sortable="true">Suivi par</th>
                    <th data-sortable="true">Dernier contact</th>
                    <th data-sortable="true">Date</th>
                    <th>Modifier</th>
                    <th>Voir suivi</th>
                    <th>Appeler</th>
                </tr>
            </thead>
<?php
//      Récupère la liste de tous les prospects enregistrés dans la BDD.
        $tCustomers = Pro_Mgr::getFullCustomersList();
        foreach($tCustomers as $tCustomer) {
//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°

//          Si l'utilisateur n'est pas un administrateur

//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
        if ($rights != 1) {
            echo
            '<tr>
                <td>';
//              Si l'utilisateur est un responsable ou un chargé de projet, affiche =>
                if ($rights === 2) {
                    echo
                    '<form action="/outils/Controllers/Controller_responsable.php" method="post">';
                } else {
                    echo
                    '<form action="/outils/Controllers/Controller_cdp.php" method="post">';
                }
                        echo
                        '<input type="hidden" name="ID_professionnel" value="'.$tCustomer['ID_professionnel'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tCustomer['libelle_entreprise'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tCustomer['ID_utilisateur'].'">
                        <input type="hidden" name="nom" value="'.$tCustomer['nom'].'">
                        <input type="hidden" name="prenom" value="'.$tCustomer['prenom'].'">
                        <input type="hidden" name="ID_secteur" value="'.$tCustomer['ID_secteur'].'">
                        <input type="hidden" name="libelle_secteur" value="'.$tCustomer['libelle_secteur'].'">
                        <input type="hidden" name="nom_decideur" value="'.$tCustomer['nom_decideur'].'">
                        <input type="hidden" name="cp" value="'.$tCustomer['cp'].'">
                        <input type="hidden" name="ville" value="'.$tCustomer['ville'].'">
                        <input type="hidden" name="mail" value="'.$tCustomer['mail'].'">
                        <input type="hidden" name="tel" value="'.$tCustomer['tel'].'">
                        <input type="hidden" name="tel_2" value="'.$tCustomer['tel_2'].'">
                        <input type="hidden" name="adresse" value="'.$tCustomer['adresse'].'">
                        <input type="hidden" name="adresse_2" value="'.$tCustomer['adresse_2'].'">
                        <input type="hidden" name="observation" value="'.$tCustomer['observation'].'">
                        <input type="hidden" name="prospect_ou_client" value="'.$tCustomer['prospect_ou_client'].'">
                        <input type="hidden" name="date_derniere_pdc" value="'.$tCustomer['date_derniere_pdc'].'">
                        <input type="hidden" name="action" value="fullInfosPro">
                        <input class="fullInfosBtn" type="submit" title="Voir fiche détaillée du professionnel" value="'.$tCustomer['libelle_entreprise'].'">
                    </form>
                </td> 
                <td>'.$tCustomer['nom_decideur'].'</td>';
                if ($tCustomer['cp'] === '') {
                    echo 
                    '<td>'.$tCustomer['ville'].'</td>';
                    if ($tCustomer['ville'=== '']) {
                        echo 
                        '<td>'.' '.'</td>';
                    }
                } elseif ($tCustomer['ville'] === '') {
                    echo
                    '<td>'.$tCustomer['cp'].'</td>';
                } else {
                    echo
                    '<td>'.$tCustomer['lieu'].'</td>';
                }
                echo
                '<td>'.$tCustomer['suivi'].'</td>
                <td>'.$tCustomer['libelle_conclusion'].'</td>
                <td>'.$lastContactDate = Dates_Mgr::dateFormatDayMonthYear($tCustomer['date_derniere_pdc']).'</td>
                <td>';
/*                  
                Un chargé de projet ou un responsable peut consulter tous les prospects / clients de la base de données
                Mais ne peut modifier que ceux dont il est en charge du suivi.
*/
                if ($userConnected == $tCustomer['ID_utilisateur']) {
                    if ($rights === 2) {
                        echo
                    '<form class="d-flex justify-content-center" action="/outils/Controllers/Controller_responsable.php" method="post">';
                    } else {
                        echo 
                    '<form class="d-flex justify-content-center" action="/outils/Controllers/Controller_cdp.php" method="post">';
                    }
                    echo
                        '<input type="hidden" name="ID_professionnel" value="'.$tCustomer['ID_professionnel'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tCustomer['libelle_entreprise'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tCustomer['ID_utilisateur'].'">
                        <input type="hidden" name="nom" value="'.$tCustomer['nom'].'">
                        <input type="hidden" name="prenom" value="'.$tCustomer['prenom'].'">
                        <input type="hidden" name="ID_secteur" value="'.$tCustomer['ID_secteur'].'">
                        <input type="hidden" name="libelle_secteur" value="'.$tCustomer['libelle_secteur'].'">
                        <input type="hidden" name="nom_decideur" value="'.$tCustomer['nom_decideur'].'">
                        <input type="hidden" name="cp" value="'.$tCustomer['cp'].'">
                        <input type="hidden" name="ville" value="'.$tCustomer['ville'].'">
                        <input type="hidden" name="mail" value="'.$tCustomer['mail'].'">
                        <input type="hidden" name="tel" value="'.$tCustomer['tel'].'">
                        <input type="hidden" name="tel_2" value="'.$tCustomer['tel_2'].'">
                        <input type="hidden" name="adresse" value="'.$tCustomer['adresse'].'">
                        <input type="hidden" name="adresse_2" value="'.$tCustomer['adresse_2'].'">
                        <input type="hidden" name="observation" value="'.$tCustomer['observation'].'">
                        <input type="hidden" name="prospect_ou_client" value="'.$tCustomer['prospect_ou_client'].'">
                        <input type="hidden" name="action" value="updatePro">
                        <button class="updIcon" type="submit" title="Modifier / Ajouter des informations sur le prospect">
                            <i class="far fa-edit"></i>
                        </button>
                    </form>';
                }
                echo
                '</td>
                <td>';
                if ($rights === 2) {
                    echo 
                    '<form class="d-flex justify-content-center" action="/outils/Controllers/Controller_responsable.php" method="post">';
                        
                } else {
                    echo
                    '<form class="d-flex justify-content-center" action="/outils/Controllers/Controller_cdp.php" method="post">';
                }
                    echo 
                        '<input type="hidden" name="ID_professionnel" value="'.$tCustomer['ID_professionnel'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tCustomer['ID_utilisateur'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tCustomer['libelle_entreprise'].'">
                        <input type="hidden" name="action" value="proActivity">
                        <button class="followIcon" type="submit" title="Voir le suivi du prospect">
                            <i class="fas fa-glasses"></i>
                        </button>
                    </form>
                </td>
                <td>';
                if ($tCustomer['tel'] != '') {
                    echo
                    '<div class="d-flex justify-content-center">
                        <button class="phoneIcon">
                            <a title="Appeler : '.$tCustomer['tel'].'" href="tel:'.$tCustomer['tel'].'">
                                <i id="iconPhone" class="fas fa-phone"></i>
                            </a>
                        </button>
                    </div>';
                }
                '</td>
            </tr>';
//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°

//          Sinon, l'utilisateur connecté est "forcément" un administrateur.

//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
        } else {
            echo
            '<tr>
                <td>
                    <form action="/outils/Controllers/Controller_admin.php" method="post">
                        <input type="hidden" name="ID_professionnel" value="'.$tCustomer['ID_professionnel'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tCustomer['libelle_entreprise'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tCustomer['ID_utilisateur'].'">
                        <input type="hidden" name="nom" value="'.$tCustomer['nom'].'">
                        <input type="hidden" name="prenom" value="'.$tCustomer['prenom'].'">
                        <input type="hidden" name="ID_secteur" value="'.$tCustomer['ID_secteur'].'">
                        <input type="hidden" name="libelle_secteur" value="'.$tCustomer['libelle_secteur'].'">
                        <input type="hidden" name="nom_decideur" value="'.$tCustomer['nom_decideur'].'">
                        <input type="hidden" name="cp" value="'.$tCustomer['cp'].'">
                        <input type="hidden" name="ville" value="'.$tCustomer['ville'].'">
                        <input type="hidden" name="mail" value="'.$tCustomer['mail'].'">
                        <input type="hidden" name="tel" value="'.$tCustomer['tel'].'">
                        <input type="hidden" name="tel_2" value="'.$tCustomer['tel_2'].'">
                        <input type="hidden" name="adresse" value="'.$tCustomer['adresse'].'">
                        <input type="hidden" name="adresse_2" value="'.$tCustomer['adresse_2'].'">
                        <input type="hidden" name="observation" value="'.$tCustomer['observation'].'">
                        <input type="hidden" name="prospect_ou_client" value="'.$tCustomer['prospect_ou_client'].'">
                        <input type="hidden" name="date_derniere_pdc" value="'.$tCustomer['date_derniere_pdc'].'">
                        <input type="hidden" name="action" value="fullInfosPro">
                        <input class="fullInfosBtn" type="submit" title="Voir fiche détaillée du professionnel" value="'.$tCustomer['libelle_entreprise'].'">
                    </form>
                </td> 
                <td>'.$tCustomer['nom_decideur'].'</td>';
                if ($tCustomer['cp'] === '') {
                    echo 
                    '<td>'.$tCustomer['ville'].'</td>';
                    if ($tCustomer['ville'=== '']) {
                        echo 
                        '<td>'.' '.'</td>';
                    }
                } elseif ($tCustomer['ville'] === '') {
                    echo
                    '<td>'.$tCustomer['cp'].'</td>';
                } else {
                    echo
                    '<td>'.$tCustomer['lieu'].'</td>';
                }
                echo
                '<td>'.$tCustomer['suivi'].'</td>
                <td>'.$tCustomer['libelle_conclusion'].'</td>
                <td>'.$lastContactDate = Dates_Mgr::dateFormatDayMonthYear($tCustomer['date_derniere_pdc']).'</td>
                <td>
                    <form class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php" method="post">
                        <input type="hidden" name="ID_professionnel" value="'.$tCustomer['ID_professionnel'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tCustomer['libelle_entreprise'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tCustomer['ID_utilisateur'].'">
                        <input type="hidden" name="nom" value="'.$tCustomer['nom'].'">
                        <input type="hidden" name="prenom" value="'.$tCustomer['prenom'].'">
                        <input type="hidden" name="ID_secteur" value="'.$tCustomer['ID_secteur'].'">
                        <input type="hidden" name="libelle_secteur" value="'.$tCustomer['libelle_secteur'].'">
                        <input type="hidden" name="nom_decideur" value="'.$tCustomer['nom_decideur'].'">
                        <input type="hidden" name="cp" value="'.$tCustomer['cp'].'">
                        <input type="hidden" name="ville" value="'.$tCustomer['ville'].'">
                        <input type="hidden" name="mail" value="'.$tCustomer['mail'].'">
                        <input type="hidden" name="tel" value="'.$tCustomer['tel'].'">
                        <input type="hidden" name="tel_2" value="'.$tCustomer['tel_2'].'">
                        <input type="hidden" name="adresse" value="'.$tCustomer['adresse'].'">
                        <input type="hidden" name="adresse_2" value="'.$tCustomer['adresse_2'].'">
                        <input type="hidden" name="observation" value="'.$tCustomer['observation'].'">
                        <input type="hidden" name="prospect_ou_client" value="'.$tCustomer['prospect_ou_client'].'">
                        <input type="hidden" name="action" value="updatePro">
                        <button class="updIcon" type="submit" title="Modifier / Ajouter des informations sur le prospect">
                            <i class="far fa-edit"></i>
                        </button>
                    </form>
                </td>
                <td>
                    <form class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php" method="post">
                        <input type="hidden" name="ID_professionnel" value="'.$tCustomer['ID_professionnel'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tCustomer['ID_utilisateur'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tCustomer['libelle_entreprise'].'">
                        <input type="hidden" name="action" value="proActivity">
                        <button class="followIcon" type="submit" title="Voir le suivi du prospect">
                            <i class="fas fa-glasses"></i>
                        </button>
                    </form>
                </td>
                <td>';
                if ($tCustomer['tel'] != '') {
                echo
                    '<div class="d-flex justify-content-center">
                        <button class="phoneIcon">
                            <a title="Appeler : '.$tCustomer['tel'].'" href="tel:'.$tCustomer['tel'].'">
                                <i id="iconPhone" class="fas fa-phone"></i>
                            </a>
                        </button>
                    </div>';
                }
                '</td>
            </tr>';
            }
        }
?>
        </table>
    </div>
</div>
