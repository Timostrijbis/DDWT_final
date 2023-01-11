<?php
/**
 * Controller
 *
 * Final project
 * By Group 3
 */

include 'model.php';

/* Connect to DB */
$db = connect_db('localhost', 'DDWT_final', 'ddwt22','ddwt22');

/* Section for redundant code */
/* Get Number of Series */
$nbr_series = count_series($db);
$nbr_users = count_users($db);

$right_column = use_template('cards');

if (check_login()) {
    $template = Array(
        1 => Array(
            'name' => 'Home',
            'url' => '/DDWT_final/'
        ),
        2 => Array(
            'name' => 'Overview',
            'url' => '/DDWT_final/overview/'
        ),
        3 => Array(
            'name' => 'My Account',
            'url' => '/DDWT_final/myaccount/'
        ),
        4 => Array(
            'name' => 'Add series',
            'url' => '/DDWT_final/add/'
        ),
        7 => Array(
            'name' => 'Messages',
            'url' => 'DDWT_final/messages/'
        ));
}
else {
    $template = Array(
        1 => Array(
            'name' => 'Home',
            'url' => '/DDWT_final/'
        ),
        2 => Array(
            'name' => 'Overview',
            'url' => '/DDWT_final/overview/'
        ),
        5 => Array(
            'name' => 'Register',
            'url' => '/DDWT_final/register/'
        ),
        6 => Array(
            'name' => 'Login',
            'url' => '/DDWT_final/login/'
        ));
}

/* Landing page */
if (new_route('/DDWT_final/', 'get')) {

    /* Page info */
    $page_title = 'Home';
    $breadcrumbs = get_breadcrumbs([
        'Final' => na('/DDWT_final/', False),
        'Home' => na('/DDWT_final/', True)
    ]);
    $navigation = get_navigation($template, 1);

    /* Page content */
    $page_subtitle = 'Welkom bij onze website';
    $page_content = 'Zoek hier naar een nieuwe kamer in groningen, of geef je kamer beschikbaar voor een nieuwe huurder.';
    /* Choose Template */
    include use_template('main');
}

/* Overview page */
elseif (new_route('/DDWT_final/overview/', 'get')) {

    /* Page info */
    $page_title = 'Overview';
    $breadcrumbs = get_breadcrumbs([
        'Home' => na('/DDWT_final/', False),
        'Overview' => na('/DDWT22/overview', True)
    ]);
    $navigation = get_navigation($template, 2);

    /* Page content */
    $page_subtitle = 'The overview of all series';
    $page_content = 'Here you find all series listed on Series Overview.';
    $left_content = get_series_table(get_series($db), $db);
    if (isset($_GET['error_msg'])) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('main');
}


elseif (new_route('/DDWT_final/register/', 'get')) {

    /* Page info */
    $page_title = 'Register';
    $breadcrumbs = get_breadcrumbs([
        'Final' => na('/DDWT_final/', False),
        'Register' => na('/DDWT_final/register/', True)
    ]);
    $navigation = get_navigation($template, 5);

    /* Page content */
    $page_subtitle = 'Registreer account';
    $page_content = 'Maak hier een nieuwe accoount aan.';
    /* Choose Template */
    include use_template('register');
}

/* Register POST */
elseif (new_route('/DDWT_final/register/', 'post')) {

    /* Page info */
    $page_title = 'Register';
    $breadcrumbs = get_breadcrumbs([
        'Final' => na('/DDWT_final/', False),
        'Home' => na('/DDWT_final/', False),
        'Register' => na('/DDWT_final/register/', True)
    ]);
    $navigation = get_navigation($template, 5);

    /* Page content */
    $page_subtitle = 'Register account';

    /* Add series to database */
    $feedback = register_user($db, $_POST);
    if (isset($_GET['error_msg'])) {
        $error_msg = get_error($_GET['error_msg']);
    }
    redirect(sprintf('/DDWT_final/myaccount/?error_msg=%s',
        urlencode(json_encode($feedback))));

    include use_template('register');

}

elseif (new_route('/DDWT_final/myaccount/', 'get')) {

    /* Page info */
    $page_title = 'My Account';
    $breadcrumbs = get_breadcrumbs([
        'Final' => na('/DDWT_final/', False),
        'Home' => na('/DDWT_final/', False),
        'Register' => na('/DDWT_final/myaccount/', True)
    ]);
    $navigation = get_navigation($template, 3);

    /* Page content */
    $page_subtitle = 'My account';

    /* Include template */
    include use_template('account');
}

elseif (new_route('/DDWT_final/login/', 'get')) {

    /* Page info */
    $page_title = 'My Account';
    $breadcrumbs = get_breadcrumbs([
        'Final' => na('/DDWT_final/', False),
        'Home' => na('/DDWT_final/', False),
        'Login' => na('/DDWT_final/login/', True)
    ]);
    $navigation = get_navigation($template, 6);

    /* Page content */
    $page_subtitle = 'Log into your account';

    /* Include template */
    include use_template('login');
}

elseif (new_route('/DDWT_final/myaccount/', 'post')) {


}


else {
    http_response_code(404);
    echo '404 Not Found';
}