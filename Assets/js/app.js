//  ***********************************************************************************************
//  GERE L'AFFICHAGE REACTIF DU FORMULAIRE SELON LE CHOIX DE CONCLUSION SELECTIONNE.
function displayCalendar() {
//  récupère la valeur de la selectBox des conclusions.
    var conclusionValue = document.getElementById('CONTACTCONCLUSION').value;
//  récupère le composant <div> qui englobe le calendrier rdv.
    var meetingDiv = document.getElementById('displayMeetingDiv');
//  récupère le composant <div> qui englobe le calendrier de relance manuelle.
    var recallDiv = document.getElementById('displayRecallDiv');
//  récupère le composant <label> qui affiche le libellé du calendrier rdv.
    var meetingCalendarLabel = document.getElementById('meetingCalendarLabel');
//  récupère le composant <label> qui affiche le libellé du calendrier rdv.
    var recallCalendarLabel = document.getElementById('recallCalendarLabel');
//  récupère le composant calendrier de rdv (avec heures/minutes).
    var meetingCalendar = document.getElementById('MEETINGCALENDAR');
//  récupère le composant calendrier de relance (date).
    var recallCalendar = document.getElementById('RECALLCALENDAR');
//  récupère le composant <text area> destiné au commentaire de l'utilisateur.
    var comment = document.getElementById('CONTACTCOMMENT');
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
        comment.placeholder = "Vous avez eu un barrage secrétaire ? Définissez une date de relance et expliquez brièvement.";
        submitBtn.style.display = "inline";
    } else if (conclusionValue === '2') {
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
    } else if (conclusionValue === '8') {
        recallCalendarLabel.innerHTML = "Date de relance :" ;
        meetingDiv.style.display = "none";
        recallDiv.style.display = "inline";
        recallCalendar.setAttribute("required", "");
        meetingCalendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Veuillez renseigner la référence du dossier de la vente.";
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
function displayInterlocutorInfosInputs() {

    var divFull = document.getElementById('displayInterlocutorInfosDiv');

    var labelName = document.getElementById('interlocutorNameLabel');

    var divName = document.getElementById('displayInputInterlocutorName');

    var divPhonesList = document.getElementById('displayProPhoneNumber');
        var phoneSelected = document.getElementById('PROTEL').value;
    
    var divPhoneInput = document.getElementById('displayInputInterlocutorTel');

    var divMailInput = document.getElementById('displayInputInterlocutorMail');

    var interlocutorSelected = document.getElementById('CONTACTINTERLOCUTOR').value;

    var divTypeOfContact = document.getElementById('displayContactTypeDiv');
        var typeOfContactSelected = document.getElementById('CONTACTTYPE').value;


    switch(interlocutorSelected) {
        case '1' :
            divFull.style.display = "none";
            divTypeOfContact.style.display = "inline";
            if (typeOfContactSelected === '3') {
                divFull.style.display = "inline";
                divName.style.display = "none";
                divPhonesList.style.display = "inline";
                divPhoneInput.style.display = "none";
                divMailInput.style.display = "none";
                if (phoneSelected === 'otherPhone') {
                    divPhoneInput.style.display = "inline";
                }
            } else if (typeOfContactSelected === '4') {
                divFull.style.display = "inline";
                divName.style.display = "none";
                divPhonesList.style.display = "none";
                divPhoneInput.style.display = "none";
                divMailInput.style.display = "inline";
            } else {
                divFull.style.display = "none";
            }
            break;
        case '2' :
            divFull.style.display = "inline";
            divTypeOfContact.style.display = "inline";
            labelName.innerHTML = "Nom secrétaire : ";
            divName.style.display = "inline";
            if (typeOfContactSelected === '3') {
                divFull.style.display = "inline";
                divPhonesList.style.display = "inline";
                divPhoneInput.style.display = "none";
                divMailInput.style.display = "none";
                if (phoneSelected === 'otherPhone') {
                    divPhoneInput.style.display = "inline";
                }
            } else if (typeOfContactSelected === '4') {
                divFull.style.display = "inline";
                divPhonesList.style.display = "none";
                divPhoneInput.style.display = "none";
                divMailInput.style.display = "inline";
            } else {
                divFull.style.display = "inline";
                divPhoneInput.style.display = "none";
                divMailInput.style.display = "none";
                divPhonesList.style.display = "none";
                divPhoneInput.style.display = "none";
            }
            break;
        case '3' :
            divFull.style.display = "inline";
            divTypeOfContact.style.display = "none";
            divName.style.display = "none";
            divMailInput.style.display = "none";
            divPhoneInput.style.display = "none";
            divPhonesList.style.display = "inline";
            if(phoneSelected === 'otherPhone') {
                divPhoneInput.style.display = "inline";
            }
            break;
        case '4' :
            divFull.style.display = "inline";
            divTypeOfContact.style.display = "inline";
            labelName.innerHTML = "Nom interlocuteur : ";
            divName.style.display = "inline";
            if (typeOfContactSelected === '3') {
                divFull.style.display = "inline";
                divPhonesList.style.display = "inline";
                divPhoneInput.style.display = "none";
                divMailInput.style.display = "none";
                if (phoneSelected === 'otherPhone') {
                    divPhoneInput.style.display = "inline";
                }
            } else if (typeOfContactSelected === '4') {
                divFull.style.display = "inline";
                divPhonesList.style.display = "none";
                divPhoneInput.style.display = "none";
                divMailInput.style.display = "inline";
            } else {
                divFull.style.display = "inline";
                divPhoneInput.style.display = "none";
                divMailInput.style.display = "none";
                divPhonesList.style.display = "none";
                divPhoneInput.style.display = "none";
            }
            break;
    }
}

//  ***********************************************************************************************
function displayInterlocutorInfosInputsAddProspect() {
    var divFull = document.getElementById('displayInterlocutorInfosDiv');

    var labelName = document.getElementById('interlocutorNameLabel');

    var divName = document.getElementById('displayInputInterlocutorName');
    
    var divPhoneInput = document.getElementById('displayInputInterlocutorTel');

    var divMailInput = document.getElementById('displayInputInterlocutorMail');

    var interlocutorSelected = document.getElementById('CONTACTINTERLOCUTOR').value;

    var divTypeOfContact = document.getElementById('displayContactTypeDiv');
        var typeOfContactSelected = document.getElementById('CONTACTTYPE').value;


    switch(interlocutorSelected) {
        case '1' :
            divFull.style.display = "none";
            divTypeOfContact.style.display = "inline";
            // if (typeOfContactSelected === '3') {
            //     divFull.style.display = "inline";
            //     divName.style.display = "none";
            //     divPhoneInput.style.display = "none";
            //     divMailInput.style.display = "none";
            // } else if (typeOfContactSelected === '4') {
            //     divFull.style.display = "inline";
            //     divName.style.display = "none";
            //     divPhoneInput.style.display = "none";
            //     divMailInput.style.display = "inline";
            // } else {
            //     divFull.style.display = "none";
            // }
            break;
        case '2' :
            divFull.style.display = "inline";
            divTypeOfContact.style.display = "inline";
            labelName.innerHTML = "Nom secrétaire : ";
            divName.style.display = "inline";
            if (typeOfContactSelected === '3') {
                divFull.style.display = "inline";              
                divPhoneInput.style.display = "inline";
                divMailInput.style.display = "none";
            } else if (typeOfContactSelected === '4') {
                divFull.style.display = "inline";
                divPhoneInput.style.display = "none";
                divMailInput.style.display = "inline";
            } else {
                divFull.style.display = "inline";
                divPhoneInput.style.display = "none";
                divMailInput.style.display = "none";
                divPhoneInput.style.display = "none";
            }
            break;
        case '3' :
            divFull.style.display = "inline";
            divTypeOfContact.style.display = "none";
            divName.style.display = "none";
            divMailInput.style.display = "none";
            divPhoneInput.style.display = "inline";
            break;
        case '4' :
            divFull.style.display = "inline";
            divTypeOfContact.style.display = "inline";
            labelName.innerHTML = "Nom interlocuteur : ";
            divName.style.display = "inline";
            if (typeOfContactSelected === '3') {
                divFull.style.display = "inline";
                divPhoneInput.style.display = "inline";
                divMailInput.style.display = "none";
            } else if (typeOfContactSelected === '4') {
                divFull.style.display = "inline";
                divPhoneInput.style.display = "none";
                divMailInput.style.display = "inline";
            } else {
                divFull.style.display = "inline";
                divPhoneInput.style.display = "none";
                divMailInput.style.display = "none";
                divPhoneInput.style.display = "none";
            }
            break;
    }
}

