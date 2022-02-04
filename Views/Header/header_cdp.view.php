<?php
    if (($_SESSION['rights'] === '3') AND (session_status() != 1)) {
?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!------------------------------IMPORTS------------------------------->
        <!--Bootstrap-->
        <link rel="stylesheet" href="/outils/Assets/css/bootstrap.css">
        <!--Font Awesome-->
        <link rel="stylesheet" href="/outils/Assets/css/all.min.css">
        <!--Bootstrap Table-->
        <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css">
        <!--CSS-->
        <link rel="stylesheet" href="/outils/Assets/css/style.css">
        <title>CRM - Toile de Com</title>
    </head>
    <body class="bg-dark">
        <header class="sticky-top">
            <div class="collapse" id="navbarToggleExternalContent" width="100%">
                <div class="bg-dark p-4 d-flex justify-content-center">
                    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
                        <h1>CRM</h1>
                        <div class="container-fluid">
                            <div class="resizeImg">
                                <a class="navbar-brand" href="/outils/Controllers/Controller_cdp.php?action=home">
                                    <img width="100%" height="100%" src="/outils/Src/Rubis-toile-de-com.png" alt="Logo Toile de Com" title="Accueil">
                                </a>
                            </div>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="/outils/Controllers/Controller_cdp.php?action=home" id="navLinks">Accueil</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarSuiviMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Listing</a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarSuiviMenuLink">
                                            <li><a class="dropdown-item" href="/outils/Controllers/Controller_cdp.php?action=prospectsListing">Prospects</a></li>
                                            <li><a class="dropdown-item" href="/outils/Controllers/Controller_cdp.php?action=clientsListing">Clients</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="/outils/Controllers/Logout.php" id="navLinks">Déconnexion</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <nav class="navbar navbar-dark bg-dark">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="connectedAsLabel">
                        Connecté(e) en tant que : <span class="connectedAsRole"><?php echo($_SESSION['role']);?></span>
                    </div>
                </div>
            </nav>
        </header>
<?php } else header('Location: /outils/index.php');?>