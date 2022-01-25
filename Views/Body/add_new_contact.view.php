<!--$_POST = NOK-->
<?php
// var_dump($_POST);
$unknown = 'Non renseigné';
$userConnected = (int) $_SESSION['idUser'];
$rights = (int) $_SESSION['rights'];
?>
<div class="container">
<hr>
    <div class="container d-flex justify-content-center">
        <fieldset class="fieldsetManagement">
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
            <input type="hidden" name="ID_professionnel" value="<?php echo($_POST['ID_professionnel']);?>">
<!---------------------------------------------INTERLOCUTOR--------------------------------------->
                <div class="w-100 d-flex justify-content-between">
                    <div class="w-25 mb-4 text-center">
                        <label for="NEWCONTACTINTERLOCUTOR" class="form-label">J'ai été en contact avec :</label>
                        <select class="form-select" name="idInterlocutorType" id="NEWCONTACTINTERLOCUTOR" onchange="displayInterlocutorInfosInputs();">
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
                            <label for="NEWCONTACTTYPE" class="form-label">Type de contact :</label>
                            <select class="form-select" name="idContactType" id="NEWCONTACTTYPE" onchange="displayInterlocutorInfosInputs();">
<?php
    //                  Récupère la liste des types de contact.
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
                        <label for="NEWCONTACTCONCLUSION" class="form-label">Conclusion :</label>
                        <select class="form-select" name="contactConclusion" id="NEWCONTACTCONCLUSION" onchange="displayCalendar();">
                            <option selected value="0">Précisez :</option>
<?php
//                  Récupère la liste des scénarios (conclusions) (le scénario "vente" est exclu via la boucle "for").
                    $tConclusions = Conclusions_Mgr::getConclusionsList();
                    foreach($tConclusions as $tConclusion) {
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
                            <label id="interlocutorNameLabel" for="NEWCONTACTINTERLOCUTORNAME" class="form-label">Nom de l'interlocuteur :</label>
                            <input placeholder="Ex : Mme Truc" type="text" class="form-control" name="contactInterlocutorName" id="NEWCONTACTINTERLOCUTORNAME" minlength="2" maxlength="60" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,60}">
                        </div>
                        <div id="displayInputInterlocutorTel" class="w-25 mb-4 text-center">
                            <label id="interlocutorTelLabel" for="NEWCONTACTINTERLOCUTORINFOTEL" class="form-label">Tel de l'interlocuteur :</label>
                            <input placeholder="Ex : 0612233445" type="text" class="form-control" name="contactInterlocutorInfoTel" id="NEWCONTACTINTERLOCUTORINFOTEL" minlength="10" maxlength="10" pattern="[0-9]{10}">
                        </div>
                        <div id="displayInputInterlocutorMail" class="w-25 mb-4 text-center">
                            <label id="interlocutorMailLabel" for="NEWCONTACTINTERLOCUTORINFOMAIL" class="form-label">Mail de l'interlocuteur :</label>
                            <input placeholder="Ex : adresse@mail.com" type="mail" class="form-control" name="contactInterlocutorInfoMail" id="newContactInterlocutorInfoMail" minlength="5" maxlength="60">
                        </div>
                    </div>
                </div>
<!----------------------------------------------CALENDAR------------------------------------------>
                <div id="displayMeetingDiv">
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-25 mb-4 text-center">
                            <label for="meetingCalendar" id="meetingCalendarLabel"></label>
                            <input class="form-select" type="datetime-local" name="meetingCalendar" id="meetingCalendar">
                        </div>
                    </div>
                </div>
                <div id="displayRecallDiv">
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-25 mb-4 text-center">
                            <label for="recallCalendar" id="recallCalendarLabel"></label>
                            <input class="form-select" type="date" name="recallCalendar" id="recallCalendar">
                        </div>
                    </div>
                </div>
<!---------------------------------------------COMMENTAIRE---------------------------------------->
                <div class="w-100 d-flex justify-content-center">
                    <div class="w-75">
                        <div class="mb-2 text-center">
                            <label for="NEWCONTACTCOMMENT" class="form-label">Compte-rendu :</label>
                            <textarea required placeholder="Pour valider le formulaire, veuillez sélectionner une conclusion et remplir les champs requis." class="form-control" name="contactComment" id="NEWCONTACTCOMMENT" maxlength="250"></textarea>
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