//  GERE L'AFFICHAGE REACTIF DU FORMULAIRE SELON LE CHOIX DE CONCLUSION SELECTIONNE.
function displayCalendar() {
//  récupère la valeur de la selectBox des conclusions.
    var result = document.getElementById('NEWCONTACTCONCLUSION').value;
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
    if (result === '0') {
        meetingDiv.style.display = "none";
        recallDiv.style.display = "none";
        meetingCalendar.removeAttribute("required");
        recallCalendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Veuillez sélectionner une conclusion.";
        submitBtn.style.display = "none";
    } else if (result === '1') {
        meetingDiv.style.display = "none";
        recallDiv.style.display = "none";
        meetingCalendar.removeAttribute("required");
        recallCalendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Vous avez obtenu un barrage secrétaire ? Expliquez brièvement.";
        submitBtn.style.display = "inline";
    } else if (result ==='2') {
        meetingDiv.style.display = "none";
        recallDiv.style.display = "none";
        meetingCalendar.removeAttribute("required");
        recallCalendar.removeAttribute("required");
        comment.placeholder = "Résumez brièvement le motif du refus";
        comment.innerHTML = "";
        comment.innerHTML = "Refus catégorique, ce professionnel n'a pas besoin de nos services actuellement.";
        submitBtn.style.display = "inline";
    } else if (result === '3') {
        meetingDiv.style.display = "none";
        recallDiv.style.display = "none";
        meetingCalendar.removeAttribute("required");
        recallCalendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Quelle(s) information(s) avez-vous obtenue(s) / renseignée(s) ?"; 
        submitBtn.style.display = "inline";
    } else if (result === '4') {
        meetingDiv.style.display = "none";
        recallDiv.style.display = "none";
        meetingCalendar.removeAttribute("required");
        recallCalendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Résumez brièvement le propos du message laissé.";
        submitBtn.style.display = "inline";
    } else if (result === '5') {
        meetingCalendarLabel.innerHTML = "Date du rendez-vous :";
        recallDiv.style.display = "none";
        meetingDiv.style.display = "inline";
        meetingCalendar.setAttribute("required", "");
        recallCalendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Décrivez succintement le sujet du rendez-vous à venir.";
        submitBtn.style.display = "inline";
    } else if (result === '6') {
        meetingDiv.style.display = "none";
        recallDiv.style.display = "none";
        meetingCalendar.removeAttribute("required");
        recallCalendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.innerHTML = "Devis envoyé.";
        submitBtn.style.display = "inline";
    } else if (result === '7') {
        recallCalendarLabel.innerHTML = "Date de relance :" ;
        meetingDiv.style.display = "none";
        recallDiv.style.display = "inline";
        recallCalendar.setAttribute("required", "");
        meetingCalendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Sélectionnez une date dans le calendrier puis résumez brièvement.";
        submitBtn.style.display = "inline";
    } else if (result === '8') {
        meetingCalendar.removeAttribute("required");
        recallCalendar.removeAttribute("required");
        meetingDiv.style.display = "none";
        recallDiv.style.display = "none";
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.innerHTML = "Absence de réponse, relance automatique programmée dans 3 jours.";
        submitBtn.style.display = "inline";
    }
}



    
