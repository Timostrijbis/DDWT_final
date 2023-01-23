<?php
/**
 * Controller
 *
 * Final project
 * By Group 3
 */

include 'model.php';

/* Connect to DB */
$db = connect_db('localhost', 'ddwt_22_final', 'ddwt22','ddwt22');

// Set credentials for authentication
$cred = set_cred('DDWT_final', 'DDWT_final');

/* Require composer autoloader */
require __DIR__ . '/vendor/autoload.php';

/* Section for redundant code */
/* Get Number of Series */
$nbr_series = count_series($db);
$nbr_users = count_users($db);

/* Call session on every load to maintain information */
session_start();

/* Breadcrumb template */
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
        7 => Array(
            'name' => 'Messages',
            'url' => '/DDWT_final/messages/'
        ));
    /* Add add_room crumbs if user is owner */
    if ($_SESSION['user_role'] == 'owner') {
        $add_room_crumbs = Array(
            'name' => 'Add Room',
            'url' => '/DDWT_final/add/');
        array_push($template, $add_room_crumbs);
    }
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

/* Create Router instance */
$router = new \Bramus\Router\Router();

/* landing page */
$router->get('/', function () use ($template, $db, $nbr_series, $nbr_users) {
    if (new_route('/DDWT_final/', 'get')) {

        /* Page info */
        $page_title = 'Home';
        $breadcrumbs = get_breadcrumbs([
            'Home' => na('/DDWT_final/', True)
        ]);
        $navigation = get_navigation($template, 1);

        /* Page content */
        $page_subtitle = 'Welkom bij onze website';
        $page_content = 'Zoek hier naar een nieuwe kamer in groningen, of geef je kamer beschikbaar voor een nieuwe huurder.';
        $right_column = use_template('cards');
        /* Choose Template */
        include use_template('main');
    }
});

/* Overview page */
$router->get('overview/', function () use ($template, $db, $nbr_series, $nbr_users) {
    /* Page info */
    $page_title = 'Overview';
    $breadcrumbs = get_breadcrumbs([
        'Home' => na('/DDWT_final/', False),
        'Overview' => na('/DDWT_final/overview', True)
    ]);
    $navigation = get_navigation($template, 2);

    /* Page content */
    $page_subtitle = 'The overview of all series';
    $page_content = 'Here you find all series listed on Series Overview.';
    $left_content = get_room_table(get_series($db), $db);
    if (isset($_GET['error_msg'])) {
        $error_msg = get_error($_GET['error_msg']);
    }
    $right_column = use_template('cards');

    /* Choose Template */
    include use_template('main');
});

$router->get('rooms/edit/(\d+)', function ($room_id) use ($template, $db, $nbr_series, $nbr_users) {
    $login_status = check_login();

    /* Get series info from db */
    $room_info = get_series_info($db, $room_id);

    /* Page info */
    $page_title = 'Overview';
    $breadcrumbs = get_breadcrumbs([
        'Home' => na('/DDWT_final/', False),
        'Overview' => na('/DDWT_final/overview', True)
    ]);
    $navigation = get_navigation($template, 3);

    /* Page content */
    $page_subtitle = sprintf("Edit %s", $room_info['name']);
    $page_content = 'Edit the series below.';
    $submit_btn = "Edit Series";
    $form_action = '/DDWT22/week2/edit/';

    /* Choose Template */
    include use_template('edit');
});

$router->get('room/(\d+)', function ($room_id) use ($template, $db, $nbr_series, $nbr_users) {
    /* Get series from db */
    $room_info = get_room_info($db, $room_id);

    /* Page info */
    $page_title = 'Overview';
    $breadcrumbs = get_breadcrumbs([
        'Home' => na('/DDWT_final/', False),
        'Overview' => na('/DDWT_final/overview', True)
    ]);
    $navigation = get_navigation($template, 3);

    /* Page content */
    $added_by = $room_info['owner'];
    $page_subtitle = sprintf("Information about %s", $room_info['address']);
    $page_content = $room_info['price'];
    $nbr_seasons = $room_info['type'];
    $creators = $room_info['size'];

    $display_buttons = False;
    if ($_SESSION['user_id'] == $room_info['owner']) {
        $display_buttons = True;
    }
    $right_column = use_template('cards');
    /* Choose Template */
    include use_template('series');
});


/* add room get */
$router->get('add/', function () use ($template, $db, $nbr_series, $nbr_users) {
    $login_status = check_login();
    if (!$login_status) {
        redirect("/DDWT_final/login/");
    }
    /* Page info */
    $page_title = 'Add Room';
    $breadcrumbs = get_breadcrumbs([
        'DDWT_final' => na('/DDWT_final/', False),
        '' => na('/DDWT_final/', False),
        'Add Room' => na('/DDWT_final/new/', True)
    ]);
    $navigation = get_navigation($template, 4);

    /* Page content */
    $page_subtitle = 'Add your room here';
    $page_content = 'Fill in the details of your room.';
    $submit_btn = "Submit room";
    $form_action = '/DDWT_final/add/';
    if (isset($_GET['error_msg'])) {
        $error_msg = get_error($_GET['error_msg']);
    }
    include use_template('new');
});

/* add room post */
$router->post('add/', function () use ($template, $db, $nbr_series, $nbr_users) {
    $login_status = check_login();
    if (!$login_status) {
        redirect("/DDWT_final/login/");
    }
    /* Page info */
    $page_title = 'Add Room';
    $breadcrumbs = get_breadcrumbs([
        'DDWT_final' => na('/DDWT_final/', False),
        '' => na('/DDWT_final/', False),
        'Add Room' => na('/DDWT_final/new/', True)
    ]);
    $navigation = get_navigation($template, 5);

    /* Page content */
    $page_subtitle = 'Add your room here';
    $page_content = 'Fill in the details of your room.';
    $submit_btn = "Submit room";
    $form_action = '/DDWT_final/add/';

    $feedback = add_series($db, $_POST);
    if (isset($_GET['error_msg'])) {
        $error_msg = get_error($_GET['error_msg']);
    }
    redirect(sprintf('/DDWT_final/overview/?error_msg=%s',
        urlencode(json_encode($feedback))));
    include use_template('new');
});

/* Remove room */
$router->post('remove/', function () use ($template, $db, $nbr_series, $nbr_users) {
    /* Remove series in database */
    $series_id = $_POST['series_id'];
    $feedback = remove_series($db, $series_id);
    if (isset($_GET['error_msg'])) {
        redirect(sprintf('/DDWT_final/overview/?error_msg=%s',
            urlencode(json_encode($feedback))));
    } else{

    }
});

/* register get */
$router->get('register/', function () use ($template, $db) {
    /* Page info */
    $page_title = 'Register';
    $breadcrumbs = get_breadcrumbs([
        'Register' => na('/DDWT_final/register/', True)
    ]);
    $navigation = get_navigation($template, 5);

    /* Page content */
    $page_subtitle = 'Registreer account';
    $page_content = 'Maak hier een nieuwe accoount aan.';
    /* Choose Template */
    include use_template('register');

    /* Page info */
    $page_title = 'Add Series';
    $breadcrumbs = get_breadcrumbs([
        'DDWT_final' => na('/DDWT_final/', False),
        '' => na('/DDWT_final/', False),
        'Add Series' => na('/DDWT_final/new/', True)
    ]);
    $navigation = get_navigation($template, 5);

});

/* Register POST */
$router->post('register/', function () use ($template, $db) {
    /* Page info */
    $page_title = 'Register';
    $breadcrumbs = get_breadcrumbs([
        'Home' => na('/DDWT_final/', False),
        'Register' => na('/DDWT_final/register/', True)
    ]);
    $navigation = get_navigation($template, 5);

    /* Page content */
    $page_subtitle = 'Register account';

    $feedback = register_user($db, $_POST);
    if (isset($_GET['error_msg'])) {
        $error_msg = get_error($_GET['error_msg']);
    }
    redirect(sprintf('/DDWT_final/myaccount/?error_msg=%s',
        urlencode(json_encode($feedback))));

    include use_template('register');
});

/* my account get */
$router->get('myaccount/', function () use ($template, $db) {
    /* Page info */
    $page_title = 'My Account';
    $breadcrumbs = get_breadcrumbs([
        'Home' => na('/DDWT_final/', False),
        'Register' => na('/DDWT_final/myaccount/', True)
    ]);
    $navigation = get_navigation($template, 3);
    if (isset($_GET['error_msg'])) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Page content */
    $page_content = get_user_info($db);
    $page_subtitle = 'My account';

    /* Include template */
    include use_template('account');
});

/* ???? */
$router->get('myaccount/', function () use ($template, $db) {
    /* Page info */
    $page_title = 'My Account';
    $breadcrumbs = get_breadcrumbs([
        'Home' => na('/DDWT_final/', False),
        'Login' => na('/DDWT_final/login/', True)
    ]);
    $navigation = get_navigation($template, 6);

    /* Page content */
    $page_subtitle = 'Log into your account';

    /* Include template */
    include use_template('login');
});

/* my account post */
$router->post('myaccount/', function () use ($template, $db) {
    /* Page info */
    $page_title = 'My Account';
    $breadcrumbs = get_breadcrumbs([
        'Home' => na('/DDWT_final/', False),
        'Login' => na('/DDWT_final/login/', True)
    ]);
    $navigation = get_navigation($template, 6);

    /* Page content */
    $page_subtitle = 'Log into your account';
    $user = get_user_name();

    /* Include template */
    include use_template('login');
});

/* login get */
$router->get('login/', function () use ($template, $db) {
    /* Page info */
    $page_title = 'Login';
    $breadcrumbs = get_breadcrumbs([
        'Home' => na('/DDWT_final/', False),
        'Login' => na('/DDWT_final/login', True)
    ]);
    $navigation = get_navigation($template, False);

    /* Page content */
    if (isset($_GET['error_msg'])) {
        $error_msg = get_error($_GET['error_msg']);
    }
    $page_subtitle = 'Login';
    $page_content = 'Login to your account here';

    /* Choose Template */
    include use_template('login');
});

/* login post */
$router->post('login/', function () use ($template, $db) {
    /* Page info */
    $page_title = 'Login';
    $breadcrumbs = get_breadcrumbs([
        'Home' => na('/DDWT_final/', False),
        'Login' => na('/DDWT_final/login/', True)
    ]);
    $navigation = get_navigation($template, False);

    /* Page content */
    $page_subtitle = 'Login to account';

    $feedback = login_user($db, $_POST);
    $error_msg = get_error($_GET['error_msg']);
    if (check_login()) {
        redirect(sprintf('/DDWT_final/myaccount/?error_msg=%s',
            urlencode(json_encode($feedback))));
    } else {
        redirect(sprintf('/DDWT_final/login/?error_msg=%s',
            urlencode(json_encode($feedback))));
        $error_msg = get_error($_GET['error_msg']);
    }

    include use_template('login');
});

/* messages get */
$router->get('messages/', function () use ($template, $db) {
    /* Page info */
    $page_title = 'Berichten';
    $breadcrumbs = get_breadcrumbs([
        'DDWT_final' => na('/DDWT_final/', False),
        'Login' => na('/DDWT_final/login', True)
    ]);
    $navigation = get_navigation($template, False);

    /* Page content */
    if (isset($_GET['error_msg'])) {
        $error_msg = get_error($_GET['error_msg']);
    }
    $page_subtitle = 'Mijn berichten';
    $page_content = get_message_table(get_messages(get_user_id(), $db), $db);

    /* Choose Template */
    include use_template('messages');
});

/* messages post */
$router->post('messages/', function () use ($template, $db) {

    /* Page info */
    $page_title = 'Berichten';
    $breadcrumbs = get_breadcrumbs([
        'DDWT_final' => na('/DDWT_final/', False),
        'Login' => na('/DDWT_final/login', True)
    ]);
    $navigation = get_navigation($template, False);

    /* Page content */
    $feedback = send_message($db, $_POST);
    if (isset($_GET['error_msg'])) {
        $error_msg = get_error($_GET['error_msg']);
    }
    redirect(sprintf('/DDWT_final/messages/?error_msg=%s',
        urlencode(json_encode($feedback))));

    include use_template('messages');
});

/* Logout account */
$router->get('logout/', function () use ($template, $db, $nbr_series, $nbr_users) {
    $feedback = logout_user();
    redirect(sprintf('/DDWT_final/login/?error_msg=%s',
        urlencode(json_encode($feedback))));
});

// Set404 for when user puts in wrong path
$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
    echo "404 page not found";
});

/* Run the router */
$router->run();

