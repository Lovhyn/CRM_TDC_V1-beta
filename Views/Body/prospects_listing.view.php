<div class="container">
<hr>
    <div class="d-flex justify-content-center mt-3">
        <h2 >Liste des prospects</h2>
    </div>
    <div class="d-flex justify-content-center">
        <table class="table table-hover table-striped table-dark mt-3 w-auto" 
                data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
            <thead>
                <tr>
                    <th class="text-center">Nom</th>
                    <th class="text-center">Interlocuteur</th>
                    <th class="text-center">Téléphone</th>
                    <th class="text-center" data-sortable="true">Suivi</th>
                    <th class="text-center">Observation</th>
                    <th class="text-center">Modifier</th>
                    <th class="text-center">Voir suivi</th>
                </tr>
            </thead>
<?php
//      Récupère la liste des prospects.
        $tProspects = Pro_Mgr::getFullProspectsList();
        foreach($tProspects as $tProspect) {
            echo
            '<tr>
                <td class="text-center">
                    <form id="fullInfosProLink" class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php?action=fullInfosPro" method="post">
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
                        <input class="proNameBtn" type="submit" name="pro_ID" value="' . $tProspect['libelle_entreprise']. '"> 
                    </form>
                </td> 
                <td class="text-center">' . $tProspect['nom_decideur'] . '</td>
                <td class="text-center"><a class="linkTel" href="tel:">' . $tProspect['tel'] . '</a></td>
                <td class="text-center">' . $tProspect['suivi'] . '</td>
                <td class="text-center">' . $tProspect['observation'] . '</td>
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
                        <button class="updIcon" type="submit" name="action" value="updPro">
                            <i class="far fa-edit"></i>
                        </button>
                    </form>
                </td>
                <td>
                    <form action="/outils/Controllers/Controller_admin.php?action=prospectActivity" method="post">
                        <button class="followIcon" type="submit" name="action" value="followPro">
                            <i class="fas fa-glasses"></i>
                        </button>
                    </form>
                </td>
            </tr>';
        }
?>
        </table>
    </div>
</div>
