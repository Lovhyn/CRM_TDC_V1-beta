<?php 
$userConnected = (int) $_SESSION['idUser'];
$rights = (int) $_SESSION['rights'];
$proId = (int) $_POST['ID_professionnel'];
?>
<div class="container">
<hr>
    <div class="container d-flex justify-content-center">
        <fieldset class="fieldsetManagement ps-1 pe-1">
<?php 
    if ((isset($_POST['date_rdv'])) AND ($_POST['date_rdv'] != '')) {
        $meeting = true;
        $recall = false;
        echo '<legend class="text-center fw-bold d-flex justify-content-center mb-4">Modifier la date du rendez-vous</legend>';
    } else {
        $meeting = false;
        $recall = true;
        echo '<legend class="text-center fw-bold d-flex justify-content-center mb-4">Modifier la date de relance</legend>';
    }
?>
        
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
    if ($meeting) {
?>
        <div class="align-items-center d-flex justify-content-center w-100">
            <div class="w-100 d-flex justify-content-center">
                <div class="w-75 mb-2 text-center">
                    <label for="MAJMEETINGCALENDAR" id="majMeetingCalendarLabel"></label>
                    <input class="form-select" type="datetime-local" name="majMeetingCalendar" id="MAJMEETINGCALENDAR">
                </div>
            </div>
        </div>
<?php
    } else {
?>
        <div class="align-items-center d-flex justify-content-center w-100">
            <div class="w-100 d-flex justify-content-center">
                <div class="w-75 mb-2 text-center">
                    <label for="MAJRECALLCALENDAR" id="majRecallCalendarLabel"></label>
                    <input class="form-select" type="date" name="majRecallCalendar" id="MAJRECALLCALENDAR">
                </div>
            </div>
        </div>
<?php
    }
?>
                <input type="hidden" name="action" value="updatedContact">
                <input type="hidden" name="ID_professionnel" value="<?php echo($_POST['ID_professionnel']);?>">
                <input type="hidden" name="libelle_entreprise" value="<?php echo($_POST['libelle_entreprise']);?>">
                <input type="hidden" name="ID_utilisateur" value="<?php echo($_POST['ID_utilisateur']);?>">
                <input type="hidden" name="ID_suivre" value="<?php echo($_POST['ID_suivre']);?>"> 
                <input type="hidden" name="commentaire" value="<?php echo($_POST['commentaire']);?>">
                <input type="hidden" name="oldDate" value="<?php echo($_POST['date_rdv']);?>">
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn" onclick="return confirm('Etes-vous sûr(e) de vouloir modifier ces informations ?')"><span>Valider</span></button>
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
                <input type="hidden" name="action" value="proActivity">
                <input type="hidden" name="prospect_ou_client" value="<?php echo($_POST['prospect_ou_client']);?>">
                <input type="hidden" name="ID_professionnel" value="<?php echo($_POST['ID_professionnel']);?>">
                <input type="hidden" name="libelle_entreprise" value="<?php echo($_POST['libelle_entreprise']);?>">
                <input type="hidden" name="ID_utilisateur" value="<?php echo($_POST['ID_utilisateur']);?>">
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btnBack"><span>Retour</span></button>
                </div>
            </form>
        </fieldset>
    </div>
</div>