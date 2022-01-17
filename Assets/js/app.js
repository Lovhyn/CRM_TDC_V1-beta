//  GERE L'AFFICHAGE REACTIF DU FORMULAIRE SELON LE CHOIX DE CONCLUSION SELECTIONNE.
function displayCalendar() {
//  récupère la valeur de la selectBox des conclusions.
    var conclusionValue = document.getElementById('NEWCONTACTCONCLUSION').value;
//  récupère le composant <div> qui englobe le calendrier rdv.
    var meetingDiv = document.getElementById('displayMeetingDiv');
//  récupère le composant <div> qui englobe le calendrier de relance manuelle.
    var recallDiv = document.getElementById('displayRecallDiv');
//  récupère le composant <label> qui affiche le libellé du calendrier rdv.
    var meetingCalendarLabel = document.getElementById('meetingCalendarLabel');
//  récupère le composant <label> qui affiche le libellé du calendrier rdv.
    var recallCalendarLabel = document.getElementById('recallCalendarLabel');
//  récupère le composant calendrier de rdv (avec heures/minutes).
    var meetingCalendar = document.getElementById('meetingCalendar');
//  récupère le composant calendrier de relance (date).
    var recallCalendar = document.getElementById('recallCalendar');
//  récupère le composant <text area> destiné au commentaire de l'utilisateur.
    var comment = document.getElementById('NEWCONTACTCOMMENT');
//  récupère le composant <button> servant à soumettre le formulaire.
    var submitBtn = document.getElementById('submitFormBtn');
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    if (conclusionValue === '0') {
        meetingDiv.style.display = "none";
        recallDiv.style.display = "none";
        meetingCalendar.removeAttribute("required");
        recallCalendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Pour valider le formulaire, veuillez sélectionner une conclusion et remplir les champs requis.";
        submitBtn.style.display = "none";
    } else if (conclusionValue === '1') {
        recallCalendarLabel.innerHTML = "Date de relance :" ;
        meetingDiv.style.display = "none";
        recallDiv.style.display = "inline";
        recallCalendar.setAttribute("required", "");
        meetingCalendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Vous avez eu un barrage secrétaire ? Séléctionnez une date de relance et expliquez brièvement.";
        submitBtn.style.display = "inline";
    } else if (conclusionValue ==='2') {
        recallCalendarLabel.innerHTML = "Date de relance :" ;
        meetingDiv.style.display = "none";
        recallDiv.style.display = "inline";
        recallCalendar.setAttribute("required", "");
        meetingCalendar.removeAttribute("required");
        comment.placeholder = "Résumez brièvement le motif du refus";
        comment.innerHTML = "";
        comment.innerHTML = "Refus catégorique, ce professionnel n'a guère besoin de nos services pour le moment...";
        submitBtn.style.display = "inline";
    } else if (conclusionValue === '3') {
        recallCalendarLabel.innerHTML = "Date de relance :" ;
        meetingDiv.style.display = "none";
        recallDiv.style.display = "inline";
        recallCalendar.setAttribute("required", "");
        meetingCalendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Quelle(s) information(s) avez-vous obtenue(s) / renseignée(s) ?"; 
        submitBtn.style.display = "inline";
    } else if (conclusionValue === '4') {
        recallCalendarLabel.innerHTML = "Date de relance :" ;
        meetingDiv.style.display = "none";
        recallDiv.style.display = "inline";
        recallCalendar.setAttribute("required", "");
        meetingCalendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Résumez brièvement le propos du message laissé.";
        submitBtn.style.display = "inline";
    } else if (conclusionValue === '5') {
        meetingCalendarLabel.innerHTML = "Date du rendez-vous :";
        recallDiv.style.display = "none";
        meetingDiv.style.display = "inline";
        meetingCalendar.setAttribute("required", "");
        recallCalendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Décrivez succintement le sujet du rendez-vous à venir.";
        submitBtn.style.display = "inline";
    } else if (conclusionValue === '6') {
        recallCalendarLabel.innerHTML = "Date de relance :" ;
        meetingDiv.style.display = "none";
        recallDiv.style.display = "inline";
        recallCalendar.setAttribute("required", "");
        meetingCalendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Veuillez renseigner le numéro du devis envoyé.";
        submitBtn.style.display = "inline";
    } else if (conclusionValue === '7') {
        recallCalendarLabel.innerHTML = "Date de relance :" ;
        meetingDiv.style.display = "none";
        recallDiv.style.display = "inline";
        recallCalendar.setAttribute("required", "");
        meetingCalendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.innerHTML = "Absence de réponse, relance prévue.";
        submitBtn.style.display = "inline";
    } 
}

//  GERE L'AFFICHAGE REACTIF DU FORMULAIRE DE MAJ UTILISATEUR SELON.
function displayInputConfirmPassword () {
//  récupère le composant <div> du champ de saisie d'un nouveau mot de passe. 
    var newPasswordDiv = document.getElementById("newPasswordDiv");
//  récupère le composant <div> du champ de saisie de la confirmation du nouveau mot de passe.
    var confirmNewPasswordDiv = document.getElementById("confirmNewPasswordDiv");
}



    
