<!--$_POST = NOK-->
<?php
// var_dump($_POST);
$unknown = 'Non renseigné';
$userConnected = (int) $_SESSION['idUser'];
$rights = (int) $_SESSION['rights'];
$proId = (int) $_POST['ID_professionnel'];
?>
<div class="container">
<hr>
    <div class="container d-flex justify-content-center">
        <fieldset class="fieldsetManagement ps-1 pe-1">
            <legend class="fw-bold d-flex justify-content-center mb-4">Nouvelle prise de contact avec <?php echo($_POST['libelle_entreprise']);?> :</legend>
            <hr>
<?php 
        if ($rights === 1) {
?>
            <form action="/outils/Controllers/Controller_admin.php" method="post">
<?php
        } elseif ($rights === 2) {
?> 
            <form action="/outils/Controllers/Controller_responsable.php" method="post">
<?php
        } elseif ($rights === 3) {
?>
            <form action="/outils/Controllers/Controller_cdp.php" method="post">
            
<?php
        } 
?>
                <input type="hidden" name="action" value="addedNewContact">
                <input type="hidden" name="ID_professionnel" value="<?php echo($proId);?>">
                <input type="hidden" name="ID_utilisateur" value="<?php echo($userConnected);?>">
                <input type="hidden" name="libelle_entreprise" value="<?php echo($_POST['libelle_entreprise']);?>">
<!---------------------------------------------INTERLOCUTOR--------------------------------------->
                <div class="align-items-center d-md-flex flex-md-row justify-content-md-around w-md-100
                                d-xs-flex flex-xs-column justify-content-xs-center w-xs-100">
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2 text-center">
                            <label for="CONTACTINTERLOCUTOR" class="form-label">J'ai été en contact avec :</label>
                            <select class="form-select" name="idInterlocutorType" id="CONTACTINTERLOCUTOR" onchange="displayInterlocutorInfosInputs();">
<?php
//                      Récupère la liste des types d'interlocuteurs.
                        $tInterlocutors = Contacting_Mgr::getInterlocutorsList();
                        foreach($tInterlocutors as $tInterlocutor) {
                            echo
                                '<option value="';echo($tInterlocutor['ID_interlocuteur']);echo'">'.$tInterlocutor['libelle_interlocuteur'].'</option>';
                        }
?>
                            </select>
                        </div> 
                    </div>
<!------------------------------------------------TYPE OF----------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2 text-center">
                            <div id="displayContactTypeDiv">
                                <label for="CONTACTTYPE" class="form-label">Type de contact :</label>
                                <select class="form-select" name="idContactType" id="CONTACTTYPE" onchange="displayInterlocutorInfosInputs();">
<?php
//                          Récupère la liste des types de contact.
                            $tContactTypes = Contacting_Mgr::getContactTypeList();
                            foreach($tContactTypes as $tContactType) {
                                echo
                                    '<option value="';echo($tContactType['ID_nature']);echo'">'.$tContactType['libelle_nature'].'</option>';
                            }
?>
                                </select>
                            </div> 
                        </div>
                    </div>
<!----------------------------------------------CONCLUSION---------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2 text-center">
                            <label for="CONTACTCONCLUSION" class="form-label">Conclusion :</label>
                            <select class="form-select" name="contactConclusion" id="CONTACTCONCLUSION" onchange="displayCalendar();">
                                <option selected value="0">Précisez :</option>
<?php
//                          Récupère la liste des scénarios (conclusions) (le scénario "vente" est exclu via la boucle "for").
                            $tConclusions = Conclusions_Mgr::getConclusionsListExceptCreateNewCustomer();
                            foreach($tConclusions as $tConclusion) {
                                echo
                                    '<option value="';echo($tConclusion['ID_conclusion']);echo'">'.$tConclusion['libelle_conclusion'].'</option>';
                            }
?>
                            </select>
                        </div>
                    </div>
                </div>
<!------------------------------------------INFOS INTERLOCUTOR------------------------------------>
                <div id="displayInterlocutorInfosDiv">
                    <div class="align-items-center d-md-flex flex-md-row justify-content-md-evenly w-md-100
                                d-xs-flex flex-xs-column justify-content-xs-center w-xs-100">
<!-- CHAMP NOM-->
                        <div class="w-100 d-flex justify-content-center">
                            <div class="w-75 mb-2 text-center">
                                <div id="displayInputInterlocutorName">
                                    <label id="interlocutorNameLabel" for="CONTACTINTERLOCUTORNAME" class="form-label">Nom de l'interlocuteur :</label>
                                    <input placeholder="Ex : Mme Truc" type="text" class="form-control" name="contactInterlocutorName" id="CONTACTINTERLOCUTORNAME" minlength="2" maxlength="60" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,60}">
                                </div>
                            </div>
                        </div>
<!--LISTE TELS-->
                        <div class="w-100 d-flex justify-content-center">
                            <div class="w-75 mb-2 text-center">
                                <div id="displayProPhoneNumber">
                                    <label id="proTelLabel" for="PROTEL" class="form-label">Numéro de téléphone :</label>
                                    <select class="form-select" name="proTel" id="PROTEL" onchange="displayInterlocutorInfosInputs();">
                                
<?php
//                                  Récupère la liste des n°tel du professionnel.
                                    $proPhones = Pro_Mgr::getProPhonesList($proId);
                                    if (($proPhones[0]['tel']) != '') {
                                        echo
                                        '<option value="'.Pro_Mgr::phoneFormatToFrench($proPhones[0]['tel']).'">'.Pro_Mgr::phoneFormatToFrench($proPhones[0]['tel']).'</option>';
                                    } 
                                    if (($proPhones[0]['tel_2']) != '') {
                                        echo
                                        '<option value="'.Pro_Mgr::phoneFormatToFrench($proPhones[0]['tel_2']).'">'.Pro_Mgr::phoneFormatToFrench($proPhones[0]['tel_2']).'</option>';
                                    }
?>
                                        <option value="otherPhone">Autre</option>
                                    </select>
                                </div>
                            </div>
                        </div>
<!-- CHAMP TEL-->
                        <div class="w-100 d-flex justify-content-center">
                            <div class="w-75 mb-2 text-center">
                                <div id="displayInputInterlocutorTel">
                                    <label id="interlocutorTelLabel" for="CONTACTINTERLOCUTORINFOTEL" class="form-label">Numéro appelé :</label>
                                    <input placeholder="Ex : 0612233445" type="text" class="form-control" name="contactInterlocutorInfoTel" id="CONTACTINTERLOCUTORINFOTEL" minlength="10" maxlength="10" pattern="[0-9]{10}">
                                </div>
<!-- CHAMP MAIL-->
                                <div id="displayInputInterlocutorMail">
                                    <label id="interlocutorMailLabel" for="CONTACTINTERLOCUTORINFOMAIL" class="form-label">Adresse e-mail :</label>
<?php
                                $proMail = Pro_Mgr::getProMail($proId);
                                if (($proMail[0]['mail']) != '') {
?>
                                    <input value="<?php echo($proMail[0]['mail']);?>" type="mail" class="form-control" name="contactInterlocutorInfoMail" id="CONTACTINTERLOCUTORINFOMAIL" minlength="5" maxlength="60">
<?php
                                } else {
?>
                                    <input placeholder="Ex : adresse@mail.com" type="mail" class="form-control" name="contactInterlocutorInfoMail" id="CONTACTINTERLOCUTORINFOMAIL" minlength="5" maxlength="60">
<?php
                                }
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
<!----------------------------------------------CALENDAR------------------------------------------>
            <div class="align-items-center d-flex justify-content-center w-100">
                <div class="w-100 d-flex justify-content-center">
                    <div class="w-75 mb-2 text-center">
                        <div id="displayMeetingDiv">
                            <label for="MEETINGCALENDAR" id="meetingCalendarLabel"></label>
                            <input class="form-select" type="datetime-local" name="meetingCalendar" id="MEETINGCALENDAR">
                        </div>
                        <div id="displayRecallDiv">
                            <label for="RECALLCALENDAR" id="recallCalendarLabel"></label>
                            <input class="form-select" type="date" name="recallCalendar" id="RECALLCALENDAR">
                        </div>
                    </div>
                </div>
            </div>
<!---------------------------------------------COMMENTAIRE---------------------------------------->
                <div class="w-100 d-flex justify-content-center">
                    <div class="w-75">
                        <div class="mb-2 text-center">
                            <label for="CONTACTCOMMENT" class="form-label">Compte-rendu :</label>
                            <textarea required placeholder="Pour valider le formulaire, veuillez sélectionner une conclusion et remplir les champs requis." class="form-control" name="contactComment" id="CONTACTCOMMENT" maxlength="250"></textarea>
                        </div>
                    </div>
                </div>
                <hr>
<!---------------------------------------------SUBMIT BUTTON-------------------------------------->
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn" onclick="return confirm('Etes-vous sûr(e) de vouloir enregistrer ce nouveau suivi ?')" id="submitFormBtn"><span>Valider</span></button>
                </div>
            </form>
<!----------------------------------------BACK RETURN BUTTON-------------------------------------->
<?php
        if ($rights === 1) {
?>
            <form action="/outils/Controllers/Controller_admin.php" method="post">
<?php
        } elseif ($rights === 2) {
?>
            <form action="/outils/Controllers/Controller_responsable.php" method="post">
<?php
        } elseif ($rights === 3) {
?>
            <form action="/outils/Controllers/Controller_cdp.php" method="post">
<?php
        }
?>
                <input type="hidden" name="ID_professionnel" value="<?php echo($_POST['ID_professionnel']);?>">
                <input type="hidden" name="libelle_entreprise" value="<?php echo($_POST['libelle_entreprise']);?>">
                <input type="hidden" name="ID_utilisateur" value="<?php echo($_POST['ID_utilisateur']);?>">
                <input type="hidden" name="action" value="proActivity">
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn"><span>Retour</span></button>
                </div>
            </form>
        </fieldset>
    </div>
</div>