<div class="container">
<hr>
    <div class="d-flex justify-content-center mt-3">
        <h2 >Liste des clients</h2>
    </div>
    <div class="d-flex justify-content-center">
        <table class="table table-hover table-striped table-dark mt-3 w-auto" 
                data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
            <thead>
                <tr>
                    <th class="text-center">Nom</th>
                    <th class="text-center">Décideur</th>
                    <th class="text-center">Lieu</th>
                    <th class="text-center">Téléphone</th>
                    <th class="text-center" data-sortable="true">Suivi</th>
                    <th class="text-center">Observation</th>
                    <th class="text-center" data-sortable="true">Secteur</th>
                    <th class="text-center">Modifier</th>
                    <th class="text-center">Voir suivi</th>
                </tr>
            </thead>
<?php
//      Récupère la liste des clients.
        $tCustomers = Pro_Mgr::getFullCustomersList();
        foreach($tCustomers as $tCustomer) {
            echo
            '<tr>
                <td class="text-center">
                    <form id="fullInfosProLink" class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php?action=fullInfosPro" method="post">
                        <input type="hidden" name="pro_ID" value="' . $tCustomer['ID_professionnel']. '">
                        <input type="hidden" name="pro_name" value="' . $tCustomer['libelle_entreprise']. '">
                        <input type="hidden" name="user_ID" value="' . $tCustomer['ID_utilisateur']. '">
                        <input type="hidden" name="user_name" value="' . $tCustomer['nom']. '">
                        <input type="hidden" name="user_surname" value="' . $tCustomer['prenom']. '">
                        <input type="hidden" name="area_ID" value="' . $tCustomer['ID_secteur']. '">
                        <input type="hidden" name="area_lib" value="' . $tCustomer['libelle_secteur']. '">
                        <input type="hidden" name="pro_decision_maker" value="' . $tCustomer['nom_decideur']. '">
                        <input type="hidden" name="pro_cp" value="' . $tCustomer['cp']. '">
                        <input type="hidden" name="pro_city" value="' . $tCustomer['ville']. '">
                        <input type="hidden" name="pro_mail" value="' . $tCustomer['mail']. '">
                        <input type="hidden" name="pro_phone" value="' . $tCustomer['tel']. '">
                        <input type="hidden" name="pro_phone2" value="' . $tCustomer['tel_2']. '">
                        <input type="hidden" name="pro_adress" value="' . $tCustomer['adresse']. '">
                        <input type="hidden" name="pro_adress2" value="' . $tCustomer['adresse_2']. '">
                        <input type="hidden" name="pro_observation" value="' . $tCustomer['observation']. '">
                        <input type="hidden" name="pro_status" value="' . $tCustomer['prospect_ou_client']. '">
                        <input type="hidden" name="pro_start" value="' . $tCustomer['debut']. '">
                        <input class="proNameBtn" type="submit" name="pro_ID" value="' . $tCustomer['libelle_entreprise']. '"> 
                    </form>
                </td> 
                <td class="text-center">' . $tCustomer['nom_decideur'] . '</td>
                <td class="text-center">' . $tCustomer['lieu'] . '</td>
                <td class="text-center"><a class="linkTel" href="tel:">' . $tCustomer['tel'] . '</a></td>
                <td class="text-center">' . $tCustomer['suivi'] . '</td>
                <td class="text-center">' . $tCustomer['observation'] . '</td>
                <td class="text-center">' . $tCustomer['libelle_secteur'] . '</td>
                <td>
                    <form class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php?action=updatePro" method="post">
                        <input type="hidden" name="pro_ID" value="' . $tCustomer['ID_professionnel']. '">
                        <input type="hidden" name="pro_name" value="' . $tCustomer['libelle_entreprise']. '">
                        <input type="hidden" name="user_ID" value="' . $tCustomer['ID_utilisateur']. '">
                        <input type="hidden" name="user_name" value="' . $tCustomer['nom']. '">
                        <input type="hidden" name="user_surname" value="' . $tCustomer['prenom']. '">
                        <input type="hidden" name="area_ID" value="' . $tCustomer['ID_secteur']. '">
                        <input type="hidden" name="area_lib" value="' . $tCustomer['libelle_secteur']. '">
                        <input type="hidden" name="pro_decision_maker" value="' . $tCustomer['nom_decideur']. '">
                        <input type="hidden" name="pro_cp" value="' . $tCustomer['cp']. '">
                        <input type="hidden" name="pro_city" value="' . $tCustomer['ville']. '">
                        <input type="hidden" name="pro_mail" value="' . $tCustomer['mail']. '">
                        <input type="hidden" name="pro_phone" value="' . $tCustomer['tel']. '">
                        <input type="hidden" name="pro_phone2" value="' . $tCustomer['tel_2']. '">
                        <input type="hidden" name="pro_adress" value="' . $tCustomer['adresse']. '">
                        <input type="hidden" name="pro_adress2" value="' . $tCustomer['adresse_2']. '">
                        <input type="hidden" name="pro_observation" value="' . $tCustomer['observation']. '">
                        <button class="updIcon" type="submit" name="action" value="updPro">
                            <i class="far fa-edit"></i>
                        </button>
                    </form>
                </td>
                <td>
                    <form action="/outils/Controllers/Controller_admin.php?action=clientActivity" method="post">
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
