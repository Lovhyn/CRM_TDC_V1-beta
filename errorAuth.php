<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="/outils/Assets/css/bootstrap.css">
    <!--Style-->
    <link rel="stylesheet" href="/outils/Assets/css/style.css">
    <title>Authentification - CRM Toile de Com</title>
</head>
<body class="bg-dark">     
    <div class="container d-flex justify-content-center">
        <fieldset class="fieldsetLogin">
        <img id="logoLogin" class="rounded mx-auto d-block mb-3" src="/outils/Src/Rubis-toile-de-com.png" alt="logo toile de com">
        <p class="text-center">Adresse mail et / ou mot de passe incorrect(s).</p>
        <legend class="mb-3">Veuillez saisir vos identifiants :</legend>
            <form name="authentication" action="/outils/Controllers/Controller_login.php" method="post" class="LOGIN">
                <div class="mb-2">
                    <label for="USERNAMEINPUT" class="form-label">Adresse Mail :</label>
                    <input required placeholder="Saisissez votre adresse Mail" type="email" class="form-control" name="userMail" id="USERNAMEINPUT">
                </div>
                <div class="mb-4">
                    <label for="USERPASSWORDINPUT" class="form-label">Mot de passe :</label>
                    <input required placeholder="Saisissez votre mot de passe" type="password" class="form-control" name="userPassword" id="USERPASSWORDINPUT">
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn"><span>Se connecter</span></button>
                </div>
            </form>
        </fieldset>
    </div>
</body>
</html>