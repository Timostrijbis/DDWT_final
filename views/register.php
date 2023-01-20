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
        <div class="col-md-12">
            <!-- Error message -->
            <?php if (isset($error_msg)){echo $error_msg;} ?>

            <h1><?= $page_title ?></h1>
            <h5><?= $page_subtitle ?></h5>

            <div class="pd-15">&nbsp;</div>

            <form action="/DDWT_final/register/" method="POST">
                <div class="form-group">
                    <label for="inputUsername">Username</label>
                    <input type="text" class="form-control" id="inputUsername" placeholder="j.jansen" name="username" required>
                </div>
                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input type="password" class="form-control" id="inputPassword" placeholder="******" name="password" required>
                </div>
                <div class="form-group">
                    <label for="inputUsername">First name</label>
                    <input type="text" class="form-control" id="inputUsername" placeholder="Jan" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="inputUsername">Last Name</label>
                    <input type="text" class="form-control" id="inputLastname" placeholder="jansen" name="last_name" required>
                </div>
                <div class="form-group">
                    <label for="inputUsername">Occupation</label>
                    <input type="text" class="form-control" id="inputOccupation" placeholder="Banker" name="occupation" required>
                </div>
                <div class="form-group">
                    <label for="inputUsername">Date of birth</label>
                    <input type="date" class="form-control" id="inputUsername" placeholder="1-1-2001" name="birth_date" required>
                </div>
                <div class="form-group">
                    <label for="inputUsername">Phone number</label>
                    <input type="text" class="form-control" id="inputPhone" placeholder="06-18989735" name="phone_number" required>
                </div>
                <div class="form-group">
                    <label for="inputUsername">E-mail address</label>
                    <input type="text" class="form-control" id="inputEmail" placeholder="j.jansen@home.nl" name="email" required>
                </div>
                <div class="form-group">
                    <label for="inputUsername">Role</label>
                    <select id="inputRole", class="form-control" name="role" required>
                        <option value="owner">Owner</option>
                        <option value="tenant">Tenant</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputUsername">Biography</label>
                    <input type="text" class="form-control" id="inputBio" name="biography" required>
                </div>
                <button type="submit" class="btn btn-primary">Register now</button>
            </form>

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
