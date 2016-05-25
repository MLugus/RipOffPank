<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Pealeht</title>

        <!-- If IE use the latest rendering engine -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Set the page to the width of the device and set the zoon level -->
        <meta name="viewport" content="width = device-width, initial-scale = 1">

        <link rel="stylesheet" type="text/css" href="css/bootstrap/bootstrap.css">

        <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>

        <!-- Bootstrap core CSS -->
        <link href="css/theme.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="signin.css" rel="stylesheet">

    </head>
    <body>

    <nav class="navbar navbar-fixed-top navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">RipOFF Pank</a>
            </div>
        </div>
        <div class="nav navbar-nav navbar-right">
            <form method="post"  action="<?= $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="action" value="logout">
                <a type="button" href="#" class="btn btn-primary btn-lg">
                    <span class="glyphicon glyphicon-log-out"></span> Logi välja
                </a>
            </form>
        </div>
    </nav>
        <div class="container">

            <form class="form-signin">

                <h2 class="form-signin-heading text-center">Kontojääk: <?= model_user_kontoseis($_SESSION['login']); ?></h2>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Tehingud</button>
                <a href="<?= $_SERVER['PHP_SELF']; ?>?view=makse" class="btn btn-lg btn-primary btn-block" role="button">Uus makse</a>

            </form>

        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>

        <script src="js/bootstrap.min.js"></script>

    </body>
</html>