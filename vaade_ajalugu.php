<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="UTF-8">

        <title>Makse ajalugu</title>

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
                    <a class="navbar-brand" href="<?= $_SERVER['PHP_SELF']; ?>?view=pealeht">RipOFF Pank</a>
                </div>
            </div>
            <div class="nav navbar-nav navbar-right">
                <form method="post"  action="<?= $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="action" value="logout">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <span class="glyphicon glyphicon-log-out"></span> Logi välja
                    </button>
                </form>
            </div>
            </nav>

        <div class="container">
            <h2 class="form-signin-heading text-center">Konto väljavõte</h2>
            <table class="ajaloo-table table table-striped table-hover">
                <thead>
                <tr>
                    <th>Tehingu Id</th>
                    <th>Maksja</th>
                    <th>Saaja</th>
                    <th>Summa</th>
                </tr>
                </thead>

                <tbody>
                <?php
                // koolon tsükli lõpus tähendab, et tsükkel koosneb HTML osast
                foreach (model_load() as $rida): ?>
                    <tr>
                        <td>
                            <?= $rida['id']; ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($rida['maksja']); ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($rida['saaja']); ?>
                        </td>
                        <td>
                            <?= $rida['summa']; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>

    <script src="js/bootstrap.min.js"></script>

</body>
</html>