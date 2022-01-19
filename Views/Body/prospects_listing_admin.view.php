<div class="container">
<hr>
    <div class="d-flex justify-content-center mt-3">
        <h2 >Prospects</h2>
    </div>
    <form class="d-flex justify-content-center mt-3" action="/outils/Controllers/Controller_cdp.php?action=addNewProspectForm" method="post">
        <button type="submit" name="action" value="addNewProspectForm" class="addNewProspectIcon" title="Enregistrer un nouveau prospect">
            <i class="far fa-handshake"></i>
        </button>
    </form>
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
//      Récupère la liste des prospects de l'utilisateur connecté.
        $tProspects = Pro_Mgr::getFullProspectsList();
        foreach($tProspects as $tProspect) {
            
            echo
            '<tr>
                <td>
                    <form id="fullInfosProLink" action="/outils/Controllers/Controller_admin.php?action=fullInfosPro" method="post">
                        <input type="hidden" name="pro_ID" value="' . $tProspect['ID_professionnel']. '">
                        <input type="hidden" name="pro_name" value="' . $tProspect['libelle_entreprise']. '">
                        <input type="hidden" name="user_ID" value="' . $tProspect['ID_utilisateur']. '">
                        <input type="hidden" name="user_name" value="' . $tProspect['nom']. '">
                        <input type="hidden" name="user_surname" value="' . $tProspect['prenom']. '">
                        <input type="hidden" name="area_ID" value="' . $tProspect['ID_secteur']. '">
                        <input type="hidden" name="area_lib" value="' . $tProspect['libelle_secteur']. '">
                        <input type="hidden" name="pro_decision_maker" value="' . $tProspect['nom_decideur']. '">
                        <input type="hidden" name="pro_cp" value="' . $tProspect['cp']. '">
                        <input type="hidden" name="pro_city" value="' . $tProspect['ville']. '">
                        <input type="hidden" name="pro_mail" value="' . $tProspect['mail']. '">
                        <input type="hidden" name="pro_phone" value="' . $tProspect['tel']. '">
                        <input type="hidden" name="pro_phone2" value="' . $tProspect['tel_2']. '">
                        <input type="hidden" name="pro_adress" value="' . $tProspect['adresse']. '">
                        <input type="hidden" name="pro_adress2" value="' . $tProspect['adresse_2']. '">
                        <input type="hidden" name="pro_observation" value="' . $tProspect['observation']. '">
                        <input type="hidden" name="pro_status" value="' . $tProspect['prospect_ou_client']. '">
                        <input type="hidden" name="last_contact" value="' . $tProspect['date_derniere_pdc']. '">
                        <input class="proNameBtn" type="submit" title="Voir fiche détaillée du professionnel" name="pro_ID" value="' . $tProspect['libelle_entreprise']. '"> 
                    </form>
                </td> 
                <td>' . $tProspect['nom_decideur'] . '</td>';
                
            if ($tProspect['cp'] === '') {
                echo 
                '<td>' . $tProspect['ville'] . '</td>';
                if ($tProspect['ville' === '']) {
                    echo 
                    '<td>' . ' ' . '</td>';
                }
            } elseif ($tProspect['ville'] === '') {
                echo
                '<td>' . $tProspect['cp'] . '</td>';
            } else {
                echo
                '<td>' . $tProspect['lieu'] . '</td>';
            }
                echo
                '<td>' . $tProspect['suivi'] . '</td>
                <td>' . $tProspect['libelle_conclusion'] . '</td>
                <td>' . $lastContactDate = Dates_Mgr::dateFormatDayMonthYear($tProspect['date_derniere_pdc']) . '</td>
                <td>
                    <form class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php?action=updatePro" method="post">
                        <input type="hidden" name="pro_ID" value="' . $tProspect['ID_professionnel']. '">
                        <input type="hidden" name="pro_name" value="' . $tProspect['libelle_entreprise']. '">
                        <input type="hidden" name="user_ID" value="' . $tProspect['ID_utilisateur']. '">
                        <input type="hidden" name="user_name" value="' . $tProspect['nom']. '">
                        <input type="hidden" name="user_surname" value="' . $tProspect['prenom']. '">
                        <input type="hidden" name="area_ID" value="' . $tProspect['ID_secteur']. '">
                        <input type="hidden" name="area_lib" value="' . $tProspect['libelle_secteur']. '">
                        <input type="hidden" name="pro_decision_maker" value="' . $tProspect['nom_decideur']. '">
                        <input type="hidden" name="pro_cp" value="' . $tProspect['cp']. '">
                        <input type="hidden" name="pro_city" value="' . $tProspect['ville']. '">
                        <input type="hidden" name="pro_mail" value="' . $tProspect['mail']. '">
                        <input type="hidden" name="pro_phone" value="' . $tProspect['tel']. '">
                        <input type="hidden" name="pro_phone2" value="' . $tProspect['tel_2']. '">
                        <input type="hidden" name="pro_adress" value="' . $tProspect['adresse']. '">
                        <input type="hidden" name="pro_adress2" value="' . $tProspect['adresse_2']. '">
                        <input type="hidden" name="pro_observation" value="' . $tProspect['observation']. '">
                        <input type="hidden" name="pro_status" value="' . $tProspect['prospect_ou_client']. '">
                        <button class="updIcon" type="submit" title="Modifier / ajouter des informations sur le prospect" name="action" value="updatePro">
                            <i class="far fa-edit"></i>
                        </button>
                    </form>
                </td>
                <td>
                    <form class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php?action=prospectActivity" method="post">
                        <input type="hidden" name="pro_ID" value="' . $tProspect['ID_professionnel']. '">
                        <input type="hidden" name="pro_name" value="' . $tProspect['libelle_entreprise']. '">
                        <input type="hidden" name="user_ID" value="' . $tProspect['ID_utilisateur']. '">
                        <button class="followIcon" type="submit" title="Voir le suivi du prospect" name="action" value="prospectActivity">
                            <i class="fas fa-glasses"></i>
                        </button>
                    </form>
                </td>
                <td>';
                if ($tProspect['tel'] != '') {
                    echo
                    '<div class="d-flex justify-content-center">
                        <button class="phoneIcon">
                            <a title="Appeler : '.$tProspect['tel'].'" href="tel:'.$tProspect['tel'].'">
                                <i id="iconPhone" class="fas fa-phone"></i>
                            </a>
                        </button>
                    </div>';
                }
                '</td>
            </tr>';
        }
?>
        </table>
    </div>
</div>