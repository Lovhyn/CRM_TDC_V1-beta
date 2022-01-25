<!--$_POST = OK-->
<?php
$unknown = 'Non renseigné';
$userConnected = (int) $_SESSION['idUser'];
$rights = (int) $_SESSION['rights'];
?>
<div class="container">
<hr>
    <div class="container container d-flex justify-content-center">
        <fieldset class="fieldsetManagement">
            <legend class="fw-bold d-flex justify-content-center mb-5">Détail de la prise de contact :</legend>
                <div class="d-flex justify-content-center">
                    <div class="w-50 text-center">
<!--------------------------------------------DATE------------------------------------------------>              
                        <div class="mb-3">
                            <label id="infosContact" class="form-label">Contact effectué le :</label>
                                <span class="infosContact"><?php echo(Dates_Mgr::dateFormatDayMonthYear($_POST['date_derniere_pdc']));?></span>
                            <hr>
                        </div>
<!-----------------------------------------FOLLOWED BY-------------------------------------------->
                        <div class="mb-3">
                            <label id="infosContact" class="form-label">Par :</label>
                                <span class="infosContact"><?php echo($_POST['prenom'] . ' ' . $_POST['nom']);?></span>
                            <hr>
                        </div>
<!----------------------------------------INTERLOCUTOR TYPE--------------------------------------->
                        <div class="mb-3">
                            <label id="infosContact" class="form-label">Type d'interlocuteur  :</label>
                                <span class="infosContact"><?php echo($_POST['libelle_interlocuteur']);?></span>
                            <hr>
                        </div>
<!----------------------------------------INTERLOCUTOR NAME--------------------------------------->
                        <div class="mb-3">
                            <label id="infosContact" class="form-label">Nom de l'interlocuteur :</label>
<?php 
                        if ($_POST['ID_interlocuteur'] === '1') {
                            if ($_POST['nom_decideur'] === '') {
?>
                                <span class="infosContact"><?php echo($unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosContact"><?php echo($_POST['nom_decideur']);?></span>
<?php
                            }
                        } else {
                            if ($_POST['nom_interlocuteur'] === '') {
?>
                                <span class="infosContact"><?php echo($unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosContact"><?php echo($_POST['nom_interlocuteur']);?></span>
<?php
                            }
                        }
?>
                            <hr>
                        </div>
<!-----------------------------------------CONTACT TYPE------------------------------------------->
                        <div class="mb-3">
                            <label id="infosContact" class="form-label">Nature du contact :</label>
                                <span class="infosContact"><?php echo($_POST['libelle_nature']);?></span>
                            <hr>
                        </div>
<!-----------------------------------------CONTACT TYPE------------------------------------------->
<?php
                if (($_POST['ID_nature'] === '3') OR ($_POST['ID_nature'] === '4')) {
                    if ($_POST['contact_interlocuteur'] != '') {
?>
                        <div class="mb-3">
                            <label id="infosContact" class="form-label">Contacté au / à :</label>
                                <span class="infosContact"><?php echo($_POST['contact_interlocuteur']);?></span>
                            <hr>
                        </div>
<?php
                    } else {
?>
                        <div class="mb-3">
                            <label id="infosContact" class="form-label">Contacté au / à :</label>
                                <span class="infosContact"><?php echo($unknown);?></span>
                            <hr>
                        </div>
<?php
                    }
                }
?>
<!------------------------------------------CONCLUSION-------------------------------------------->
                        <div class="mb-3">
                            <label id="infosContact" class="form-label">Conclusion :</label>
                                <span class="infosContact"><?php echo($_POST['libelle_conclusion']);?></span>
                            <hr>
                        </div>
<!-----------------------------------------MEETING DATE------------------------------------------->
<?php
                    if ($_POST['date_rdv'] != '') {
?>
                        <div class="mb-3">
                            <label id="infosContact" class="form-label">Rendez-vous le :</label>
                                <span class="infosContact"><?php echo(Dates_Mgr::dateFormatDayMonthYearHourMinutesSeconds($_POST['date_rdv']));?></span>
                            <hr>
                        </div>
<?php
                    } else {
?>
                        <div class="mb-3">
                            <label id="infosContact" class="form-label">Relance prévue le :</label>
                                <span class="infosContact"><?php echo(Dates_Mgr::dateFormatDayMonthYear($_POST['date_relance']));?></span>
                            <hr>
                        </div>
<?php
                    }
?>
<!-------------------------------------------COMMENTAIRE------------------------------------------>
                        <div class="mb-3 text-center">

<?php
                        if ($_POST['commentaire'] === "") {
?>
                            <label id="infosContact" class="form-label">Observation :</label>
                                <span class="infosContact"><?php echo($unknown);?></span>
<?php
                        } else {
?>
                                <textarea class="w-100 form-control">Commentaire : <?php echo($_POST['commentaire']);?></textarea>
<?php
                        }
?>
                            <hr>
                        </div>
<!----------------------------------------BACK RETURN BUTTON-------------------------------------->
<?php
                if ($_POST['prospect_ou_client'] === "0") {
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
                            <input type="hidden" name="action" value="prospectActivity">
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn"><span>Retour</span></button>
                            </div>
                        </form>
<?php
                } else {
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
                            <input type="hidden" name="action" value="clientActivity">
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn"><span>Retour</span></button>
                            </div>
                        </form>
<?php
                }
?>
        </fieldset>
    </div>
</div>




