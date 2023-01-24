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

                <!-- Left column -->
                <div class="col-md-8">
                    <!-- Error message -->
                    <?php if (isset($error_msg)){echo $error_msg;} ?>

                    <h1><?= $page_title ?></h1>
                    <h5><?= $page_subtitle ?></h5>
                    <table class="table">
                        <tbody>
                        <tr>
                            <th scope="row">Postal Code</th>
                            <td><?= $postal ?></td>
                        </tr>
                        <tr>
                            <th scope="row">City</th>
                            <td><?= $city ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Price</th>
                            <td><?= $page_content ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Size (square meters)</th>
                            <td><?= $creators ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Room type</th>
                            <td><?= $nbr_seasons ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Added by user</th>
                            <td><?= $added_by ?></td>
                        </tr>
                        </tbody>
                    </table>
                    <?php if ($display_buttons) { ?>
                    <div class="row">
                        <div class="col-sm-2">
                            <a href="/DDWT_final/edit/<?= $room_id ?>" role="button" class="btn btn-warning">Edit</a>
                        </div>
                        <div class="col-sm-2">
                            <form action="/DDWT_final/remove/" method="POST">
                                <input type="hidden" value="<?= $room_id ?>" name="room_id">
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <!-- Right column -->
                <div class="col-md-4">

                    <?php include $right_column ?>

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

