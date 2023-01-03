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

$template = Array(
    1 => Array(
        'name' => 'Home',
        'url' => '/DDWT22/week2/'
    ),
    2 => Array(
        'name' => 'Overview',
        'url' => '/DDWT22/week2/overview/'
    ),
    3 => Array(
        'name' => 'My Account',
        'url' => '/DDWT22/week2/myaccount/'
    ),
    4 => Array(
        'name' => '‘Register’',
        'url' => '/DDWT22/week2/register/'
    ),
    5 => Array(
        'name' => '‘Add series’',
        'url' => '/DDWT22/week2/add/'
    ));

/* Landing page */
if (new_route('/DDWT22/week2/', 'get')) {
    /* Page info */
    $page_title = 'Home';
    $breadcrumbs = get_breadcrumbs([
        'DDWT22' => na('/DDWT22/', False),
        'Week 2' => na('/DDWT22/week2/', False),
        'Home' => na('/DDWT22/week2/', True)
    ]);
    $navigation = get_navigation($template, 1);

    /* Page content */
    $page_subtitle = 'The online platform to list your favorite series';
    $page_content = 'On Series Overview you can list your favorite series. You can see the favorite series of all Series Overview users. By sharing your favorite series, you can get inspired by others and explore new series.';
    /* Choose Template */
    include use_template('main');
}