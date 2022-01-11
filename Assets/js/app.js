
//  GERE L'AFFICHAGE REACTIF DU FORMULAIRE SELON LE CHOIX DE CONCLUSION.
function displayCalendar() {
//  récupère la valeur de la selectBox des conclusions.
    var result = document.getElementById('NEWCONTACTCONCLUSION').value;
//  récupère le composant <div> qui englobe le calendrier.
    var div = document.getElementById('displayDiv');
//  récupère le composant <label> qui affiche le libellé du calendrier.
    var label = document.getElementById('calendarLabel');
//  récupère le composant calendrier.
    var calendar = document.getElementById('calendar');
//  récupère le composant <text area> destiné au commentaire de l'utilisateur.
    var comment = document.getElementById('NEWCONTACTCOMMENT');
//  récupère le composant <button> servant à soumettre le formulaire.
    var submitBtn = document.getElementById('submitFormBtn');
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    if (result === '0') {
        div.style.display = "none";
        calendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Veuillez sélectionner une conclusion.";
        submitBtn.style.display = "none";
    } else if (result === '1') {
        div.style.display = "none";
        calendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Vous avez obtenu un barrage secrétaire ? Expliquez brièvement.";
        submitBtn.style.display = "inline";
    } else if (result ==='2') {
        div.style.display = "none";
        calendar.removeAttribute("required");
        comment.placeholder = "Résumez brièvement le motif du refus";
        comment.innerHTML = "";
        comment.innerHTML = "Refus catégorique, ce professionnel n'a pas besoin de nos services actuellement.";
        submitBtn.style.display = "inline";
    } else if (result === '3') {
        div.style.display = "none";
        calendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Quelle(s) information(s) avez-vous obtenue(s) ?"; 
        submitBtn.style.display = "inline";
    } else if (result === '4') {
        div.style.display = "none";
        calendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Résumez brièvement le propos du message laissé.";
        submitBtn.style.display = "inline";
    } else if (result === '5') {
        label.innerHTML = "Date du rendez-vous :";
        div.style.display = "inline";
        calendar.setAttribute("required", "");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Résumez brièvement le sujet du rendez-vous.";
        submitBtn.style.display = "inline";
    } else if (result === '6') {
        div.style.display = "none";
        calendar.removeAttribute("required");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.innerHTML = "Devis envoyé.";
        submitBtn.style.display = "inline";
    } else if (result === '7') {
        label.innerHTML = "Date de relance :" ;
        div.style.display = "inline";
        calendar.setAttribute("required", "");
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.placeholder = "Relance programmée manuellement, résumez brièvement.";
        submitBtn.style.display = "inline";
    } else if (result === '8') {
        calendar.removeAttribute("required");
        div.style.display = "none";
        comment.placeholder = "";
        comment.innerHTML = "";
        comment.innerHTML = "Absence de réponse, à relancer.";
        submitBtn.style.display = "inline";
    }
}



    
