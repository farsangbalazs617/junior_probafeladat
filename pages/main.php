<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <title>Junior próbafeladat</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.js"></script>

    <script src="js/script.js"></script>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="/home">WeLove</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <div class="navbar-nav">
                    <a class="nav-link <?php if ($uri['path'][0] == 'home' || $uri['path'][0] == '') echo 'active'; ?>" href="/home">Projektlista</a>
                    <a class="nav-link <?php if ($uri['path'][0] == 'create_edit') echo 'active'; ?>" href="create_edit">Szerkesztés/Létrehozás</a>
                </div>
            </div>
        </div>
    </nav>

    <?php 
        require_once(__DIR__ . "/../router.php");
    ?>

</body>

</html>