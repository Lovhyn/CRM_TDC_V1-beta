<!--$_POST = OK-->
<?php 
$userConnected = (int) $_SESSION['idUser'];
$rights = (int) $_SESSION['rights'];
?>
<div class="container">
<hr>
    <div class="container d-flex justify-content-center">
        <fieldset class="fieldsetManagement">
            <legend class="fw-bold d-flex justify-content-center mb-4">NOUVEAU PROSPECT :</legend>
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
                <input type="hidden" name="action" value="addedNewProspect">
                <div class="w-100 d-flex justify-content-between">
<!-------------->
<!-----PRO------>
<!-------------->
<!---------------------------------------------PRO NAME------------------------------------------->
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="PROSPECTNAME" class="form-label">Nom de l'entreprise (requis):</label>
                            <input required placeholder="Ex : Toile de Com" type="text" class="form-control" name="prospectName" id="PROSPECTNAME" minlength="2" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,50}">
                        </div>
                    </div>
<!-------------------------------------------DECISION MAKER--------------------------------------->
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="PROSPECTDECISIONMAKERNAME" class="form-label">Nom du décideur :</label>
                            <input placeholder="Ex : COSSON" type="text" class="form-control" name="prospectDecisionMakerName" id="PROSPECTDECISIONMAKERNAME" minlength="2" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,50}">
                        </div>
                    </div>
                </div>
<!-------------------------------------------ACTIVITY AREA---------------------------------------->
                <div class="w-100 d-flex justify-content-between">
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="PROSPECTACTIVITYAREA" class="form-label">Secteur d'activité :</label>
                            <select class="form-select" name="prospectActivityArea" id="PROSPECTACTIVITYAREA">
<?php
//                      Récupère la liste des secteurs d'activité.
                        $tActivityAreas = ActivityArea_Mgr::getActivityAreaList();
                        foreach($tActivityAreas as $tActivityArea) {
                            echo
                                '<option value="';echo($tActivityArea['ID_secteur']);echo'">'.$tActivityArea['libelle_secteur'].'</option>';
                        }
?>
                            </select>
                        </div> 
                    </div>   
<!----------------------------------------------MAIN MAIL----------------------------------------->
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="PROSPECTMAIL" class="form-label">Adresse mail :</label>
                            <input placeholder="Ex : adresse@mail.com" type="mail" class="form-control" name="prospectMail" id="PROSPECTMAIL" minlength="5" maxlength="60">
                        </div>
                    </div>
                </div>
<!---------------------------------------------MAIN PHONE----------------------------------------->
                <div class="w-100 d-flex justify-content-between">
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="PROSPECTMAINPHONE" class="form-label">N° Téléphone principal :</label>
                            <input placeholder="Ex : 0612233445" type="text" class="form-control" name="prospectMainPhone" id="PROSPECTMAINPHONE" minlength="10" maxlength="10" pattern="[0-9]{10}">
                        </div>
                    </div>
<!-------------------------------------------SECONDARY PHONE-------------------------------------->
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="PROSPECTSECONDARYPHONE" class="form-label">N° Téléphone secondaire :</label>
                            <input placeholder="Ex : 0674859330" type="text" class="form-control" name="prospectSecondaryPhone" id="PROSPECTSECONDARYPHONE" minlength="10" maxlength="10" pattern="[0-9]{10}">
                        </div>
                    </div>
                </div>
<!---------------------------------------------MAIN ADRESS---------------------------------------->
                <div class="w-100 d-flex justify-content-between">
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="PROSPECTMAINADRESS" class="form-label">Adresse principale :</label>
                            <input placeholder="Ex : 3 rue des bidules" type="text" class="form-control" name="prospectMainAdress" id="PROSPECTMAINADRESS" minlength="5" maxlength="50">
                        </div>
                    </div>
<!-------------------------------------------SECONDARY ADRESS------------------------------------->
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="PROSPECTSECONDARYADRESS" class="form-label">Complément d'adresse :</label>
                            <input placeholder="Ex : 12 impasse des choses" type="text" class="form-control" name="prospectSecondaryAdress" id="PROSPECTSECONDARYADRESS" minlength="5" maxlength="50">
                        </div>
                    </div>
                </div>
<!-------------------------------------------------CP--------------------------------------------->
                <div class="w-100 d-flex justify-content-between">
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-4">
                            <label for="PROSPECTCP" class="form-label">Code postal :</label>
                            <input placeholder="Ex : 14692" type="text" class="form-control" name="prospectCp" id="PROSPECTCP" minlength="5" maxlength="5" pattern="[0-9]{5}">
                        </div>
                    </div>
<!------------------------------------------------VILLE------------------------------------------->
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-4">
                            <label for="PROSPECTCITY" class="form-label">Ville :</label>
                            <input placeholder="Ex : Saint-Martin-Des-Besaces" type="text" class="form-control" name="prospectCity" id="PROSPECTCITY" minlength="2" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,50}">
                        </div>
                    </div>
                </div>
<!----------------------------------------------OBSERVATION--------------------------------------->
                <div class="w-100 d-flex justify-content-center">
                    <div class="w-75">
                        <div class="mb-2 text-center">
                            <label for="PROSPECTOBSERVATION" class="form-label">Observation(s) / Commentaire(s) :</label>
                            <textarea placeholder="Entrez une note à propos du prospect (facultatif)" class="form-control" name="prospectObservation" id="PROSPECTOBSERVATION" maxlength="250"></textarea>
                        </div>
                    </div>
                </div>
                <hr>
<!-------------->
<!--CONTACTING-->
<!-------------->
<!---------------------------------------------INTERLOCUTOR--------------------------------------->
                <div class="w-100 d-flex justify-content-between">
                    <div class="w-25 mb-4 text-center">
                        <label for="CONTACTINTERLOCUTOR" class="form-label">J'ai été en contact avec :</label>
                        <select class="form-select" name="idInterlocutorType" id="CONTACTINTERLOCUTOR" onchange="displayInterlocutorInfosInputsAddProspect();">
<?php
//                  Récupère la liste des types d'interlocuteurs.
                    $tInterlocutors = Contacting_Mgr::getInterlocutorsList();
                    foreach($tInterlocutors as $tInterlocutor) {
                        echo
                            '<option value="';echo($tInterlocutor['ID_interlocuteur']);echo'">'.$tInterlocutor['libelle_interlocuteur'].'</option>';
                    }
?>
                        </select>
                    </div> 
<!------------------------------------------------TYPE OF----------------------------------------->
                    <div class="w-25 mb-4 text-center">
                        <div id="displayContactTypeDiv">
                            <label for="CONTACTTYPE" class="form-label">Type de contact :</label>
                            <select class="form-select" name="idContactType" id="CONTACTTYPE" onchange="displayInterlocutorInfosInputsAddProspect();">
<?php
//                      Récupère la liste des types de contact.
                        $tContactTypes = Contacting_Mgr::getContactTypeList();
                        foreach($tContactTypes as $tContactType) {
                            echo
                                '<option value="';echo($tContactType['ID_nature']);echo'">'.$tContactType['libelle_nature'].'</option>';
                        }
?>
                            </select>
                        </div> 
                    </div>
<!----------------------------------------------CONCLUSION---------------------------------------->
                    <div class="w-25 mb-4 text-center">
                        <label for="CONTACTCONCLUSION" class="form-label">Conclusion :</label>
                        <select class="form-select" name="contactConclusion" id="CONTACTCONCLUSION" onchange="displayCalendar();">
                            <option selected value="0">Précisez :</option>
<?php
//                  Récupère la liste des scénarios (conclusions) (le scénario "vente" est exclu via la boucle "for").
                    $tConclusions = Conclusions_Mgr::getConclusionsListExcept();
                    foreach ($tConclusions as $tConclusion) {
                        echo
                            '<option value="';echo($tConclusion['ID_conclusion']);echo'">'.$tConclusion['libelle_conclusion'].'</option>';
                    }
?>
                        </select>
                    </div>
                </div>
<!------------------------------------------INFOS INTERLOCUTOR------------------------------------>
                <div id="displayInterlocutorInfosDiv">
                    <div class="w-100 d-flex justify-content-evenly">
                        <div id="displayInputInterlocutorName" class="w-25 mb-4 text-center">
                            <label id="interlocutorNameLabel" for="CONTACTINTERLOCUTORNAME" class="form-label">Nom de l'interlocuteur :</label>
                            <input placeholder="Ex : Mme Truc" type="text" class="form-control" name="contactInterlocutorName" id="CONTACTINTERLOCUTORNAME" minlength="2" maxlength="60" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,60}">
                        </div>
                        <div id="displayInputInterlocutorTel" class="w-25 mb-4 text-center">
                            <label id="interlocutorTelLabel" for="CONTACTINTERLOCUTORINFOTEL" class="form-label">Numéro appelé :</label>
                            <input placeholder="Ex : 0612233445" type="text" class="form-control" name="contactInterlocutorInfoTel" id="CONTACTINTERLOCUTORINFOTEL" minlength="10" maxlength="10" pattern="[0-9]{10}">
                        </div>
                        <div id="displayInputInterlocutorMail" class="w-25 mb-4 text-center">
                            <label id="interlocutorMailLabel" for="CONTACTINTERLOCUTORINFOMAIL" class="form-label">Adresse e-mail :</label>
                            <input placeholder="Ex : adresse@mail.com" type="mail" class="form-control" name="contactInterlocutorInfoMail" id="CONTACTINTERLOCUTORINFOMAIL" minlength="5" maxlength="60">
                        </div>
                    </div>
                </div>
<!----------------------------------------------CALENDAR------------------------------------------>
                <div id="displayMeetingDiv">
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-25 mb-4 text-center">
                            <label for="MEETINGCALENDAR" id="meetingCalendarLabel"></label>
                            <input class="form-select" type="datetime-local" name="meetingCalendar" id="MEETINGCALENDAR">
                        </div>
                    </div>
                </div>
                <div id="displayRecallDiv">
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-25 mb-4 text-center">
                            <label for="RECALLCALENDAR" id="recallCalendarLabel"></label>
                            <input class="form-select" type="date" name="recallCalendar" id="RECALLCALENDAR">
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
<!---------------------------------------------RETURN BUTTON-------------------------------------->
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
            <input type="hidden" name="action" value="prospectsListing">
            <div class="d-flex justify-content-center">
                    <button type="submit" class="btn"><span>Retour</span></button>
                </div>
            </form>
        </fieldset>
    </div>
</div>