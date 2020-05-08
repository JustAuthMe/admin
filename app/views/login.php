<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel=icon type="image/png" href="<?= IMG ?>icon.png">

    <title><?= NAME ?> - Login</title>

    <link href="<?= ASSETS ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="<?= ASSETS ?>css/sb-admin-2.min.css" rel="stylesheet">
    <meta http-equiv="refresh" content="50" />
</head>

<body class="bg-gradient-primary">

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <img src="<?= IMG ?>logo_big.png" style="width:300px;max-width:100%;padding:10px 40px;background-color:#3498db;border-radius:40px" />
                                    <br /><br />
                                    <img src="<?= $qr ?>" />
                                    <br /><br />
                                    <a href="jam://<?= $token ?>" class="btn btn-primary">Login on mobile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<script src="<?= ASSETS ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= ASSETS ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="<?= ASSETS ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<script src="<?= ASSETS ?>js/sb-admin-2.min.js"></script>

<script type="text/javascript" src="<?= JAM_API ?>auth_listener.js?token=<?= $token ?>"></script>

</body>

</html>
