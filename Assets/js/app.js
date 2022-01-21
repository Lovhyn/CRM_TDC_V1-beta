//  ***********************************************************************************************
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
    } else {
        recallCalendarLabel.innerHTML = "Date de relance :" ;
        meetingDiv.style.display = "none";
        recallDiv.style.display = "inline";
        recallCalendar.setAttribute("required", "");
        meetingCalendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        submitBtn.style.display = "inline";
    }
}
//  ***********************************************************************************************
function displayInterlocutorInfosInputs(){
//  récupère le composant <div> qui englobe les deux inputs d'informations sur l'interlocuteur.
    var fullDiv = document.getElementById("displayInterlocutorInfosDiv");
    var typeOfContactDiv = document.getElementById("displayContactTypeDiv");
//  récupère le composant <div> qui englobe l'input du nom de l'interlocuteur.
    var nameDiv = document.getElementById("displayInputInterlocutorName");
//  récupère le composant <div> qui englobe l'input du n°tel de l'interlocuteur.
    var telDiv = document.getElementById("displayInputInterlocutorTel");
//  récupère le composant <div> qui englobe l'input du mail de l'interlocuteur.
    var mailDiv = document.getElementById("displayInputInterlocutorMail");
//  récupère la valeur de la selectBox des types d'interlocuteurs.
    var selectedInterlocutor = document.getElementById("NEWCONTACTINTERLOCUTOR").value;
//  récupère la valeur de la selectBox des types de contact.
    var selectedTypeOfContact = document.getElementById("NEWCONTACTTYPE").value;
//  récupère le composant <label> qui affiche le libellé du champs "nom" de l'interlocuteur.
    var interlocutorNameLabel = document.getElementById("interlocutorNameLabel");
//  récupère le composant <label> qui affiche le libellé du champs "tel" de l'interlocuteur.
    var interlocutorTelLabel = document.getElementById("interlocutorTelLabel");
//  récupère le composant <label> qui affiche le libellé du champs "mail" de l'interlocuteur.
    var interlocutorMailLabel = document.getElementById("interlocutorMailLabel");
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    switch (selectedInterlocutor) {
        case '1' : 
            typeOfContactDiv.style.display = "inline";
            fullDiv.style.display = "none";
        break;
        case '2' : 
            typeOfContactDiv.style.display = "inline";
            fullDiv.style.display = "inline";
            interlocutorNameLabel.innerHTML = "Nom secrétaire : ";
            if (selectedTypeOfContact === '3') {
                interlocutorTelLabel.innerHTML = "Tel secrétaire";
                telDiv.style.display = "inline";
                mailDiv.style.display = "none";
            } else if (selectedTypeOfContact === '4') {
                interlocutorMailLabel.innerHTML = "Mail secrétaire";
                telDiv.style.display = "none";
                mailDiv.style.display = "inline";
            } else {
                telDiv.style.display = "none";
                mailDiv.style.display = "none";
            }
        break;
        case '3' :
            fullDiv.style.display = "none";
            typeOfContactDiv.style.display = "none";
        break;
        case '4' :
            typeOfContactDiv.style.display = "inline";
            fullDiv.style.display = "inline";
            interlocutorNameLabel.innerHTML = "Nom de l'interlocuteur : ";
            if (selectedTypeOfContact === '3') {
                interlocutorTelLabel.innerHTML = "Tel de l'interlocuteur :";
                telDiv.style.display = "inline";
                mailDiv.style.display = "none";
            } else if (selectedTypeOfContact === '4') {
                interlocutorMailLabel.innerHTML = "Mail de l'interlocuteur";
                telDiv.style.display = "none";
                mailDiv.style.display = "inline";
            } else {
                telDiv.style.display = "none";
                mailDiv.style.display = "none";
            }
        break;
    }















    // if (selectedInterlocutor === '1') {
    //     fullDiv.style.display = "none";
    // } else if (selectedInterlocutor === '3') {
    //     typeOfContactDiv.style.display = "none";
    // } else {
    //     typeOfContactDiv.style.display = "inline";
    // }
    
    // if ((selectedTypeOfContact === '1') || (selectedTypeOfContact === '2')) {
    //     fullDiv.style.display = "none";
    // } else {
    //     fullDiv.style.display = "inline";
    //     if (selectedTypeOfContact === '3') {
    //         mailDiv.style.display = "none";
    //         telDiv.style.display = "inline";
    //     } else if (selectedTypeOfContact === '4') {
    //         mailDiv.style.display = "inline";
    //         telDiv.style.display = "none";
    //     }
    // }
}

    
