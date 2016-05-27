<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Registreeri</title>

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
</nav>

<div class="container">
    <form class="form-signin" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
        <h2 class="form-signin-heading">Palun sisestage vajalikud andmed</h2>
        <input type="hidden" name="action" value="register">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
        <input type="text" class="form-control" name="kasutajanimi" placeholder="Kasutajanimi" autofocus required>
        <input type="password" class="form-control" name="parool" placeholder="Salasõna" required>
        <input type="password" class="form-control" name="parool2" placeholder="Kinnita salasõna" required>
        <label class="checkbox">
            <input type="checkbox" value="terms">Nõustun tingimustega
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Registreeri</button>
    </form>
</div>
<?php
foreach (message_list() as $message):
    ?>
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel-body">
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">Ć—</button>
                <strong>Pekki!</strong><?= $message; ?>
            </div>
        </div>
    </div>
    <?php
endforeach;
?>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>

<script src="js/bootstrap.min.js"></script>
</body>
</html>