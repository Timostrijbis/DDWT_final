<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css" integrity="sha512-T584yQ/tdRR5QwOpfvDfVQUidzfgc2339Lc8uBDtcp/wYu80d7jwBgAxbyMh0a9YM9F8N3tdErpFI8iaGx6x5g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Own CSS -->
        <link rel="stylesheet" href="/DDWT_final/css/main.css">

        <title><?= $page_title ?></title>
    </head>
    <body>
        <!-- Menu -->
        <?= $navigation ?>

        <!-- Content -->
        <div class="container">
            <!-- Breadcrumbs -->
            <div class="pd-15">&nbsp;</div>
            <?= $breadcrumbs ?>

            <div class="row">

                <div class="col-md-12">
                    <!-- Error message -->
                    <?php if (isset($error_msg)){echo $error_msg;} ?>

                    <h1><?= $page_title ?></h1>
                    <h5><?= $page_subtitle ?></h5>
<!--                    <p>--><?//= $page_content ?><!--</p>-->
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th scope="row">Username:</th>
                            <td> <?= $user ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Date of birth:</th>
                            <td> <?= $date_of_birth ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Email-address:</th>
                            <td> <?= $email ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Phone number:</th>
                            <td> <?= $phone_number ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Occupation:</th>
                            <td> <?= $occupation ?></td>
                        </tr>
                        <tr>
                            <th scope="row">role:</th>
                            <td> <?= $role ?></td>
                        </tr>
                        <tr>
                            <th scope="row">First name:</th>
                            <td> <?= $first ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Last name:</th>
                            <td> <?= $last ?></td>
                        </tr>
                        <tr>
                            <th scope="row">biography:</th>
                            <td> <?= $bio ?></td>
                        </tr>
                        </tbody>
                    </table>

                </div>

            </div>

            <div class="pd-15">&nbsp;</div>

            <div class="row">

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Welcome, <?= $_SESSION['user_id'] ?>
                        </div>
                        <div class="card-body">
                            <p>You're logged in to Series Overview.</p>
                            <a href="/DDWT_final/logout/" class="btn btn-primary">Logout</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Add series
                        </div>
                        <div class="card-body">
                            <p>Add your contribution to Series Overview.</p>
                            <a href="/DDWT_final/add/" class="btn btn-primary">Add a series</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js" integrity="sha512-/DXTXr6nQodMUiq+IUJYCt2PPOUjrHJ9wFrqpJ3XkgPNOZVfMok7cRw6CSxyCQxXn6ozlESsSh1/sMCTF1rL/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js" integrity="sha512-ubuT8Z88WxezgSqf3RLuNi5lmjstiJcyezx34yIU2gAHonIi27Na7atqzUZCOoY4CExaoFumzOsFQ2Ch+I/HCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.min.js" integrity="sha512-UR25UO94eTnCVwjbXozyeVd6ZqpaAE9naiEUBK/A+QDbfSTQFhPGj5lOR6d8tsgbBk84Ggb5A3EkjsOgPRPcKA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </body>
</html>
