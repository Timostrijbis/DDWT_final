<?php

/**
 * Model
 *
 * Database-driven Webtechnology
 * Written by group 3
 */

/* Enable error reporting */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Connects to the database using PDO
 * @param string $host Database host
 * @param string $db Database name
 * @param string $user Database user
 * @param string $pass Database password
 * @return PDO Database object
 */
function connect_db($host, $db, $user, $pass)
{
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        echo sprintf("Failed to connect. %s", $e->getMessage());
    }
    return $pdo;
}

/**
 * Check if the route exists
 * @param string $route_uri URI to be matched
 * @param string $request_type Request method
 * @return bool
 *
 */
function new_route($route_uri, $request_type)
{
    $route_uri_expl = array_filter(explode('/', $route_uri));
    $current_path_expl = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    if ($route_uri_expl == $current_path_expl && $_SERVER['REQUEST_METHOD'] == strtoupper($request_type)) {
        return True;
    } else {
        return False;
    }
}

/**
 * Creates a new navigation array item using URL and active status
 * @param string $url The URL of the navigation item
 * @param bool $active Set the navigation item to active or inactive
 * @return array
 */
function na($url, $active)
{
    return [$url, $active];
}

/**
 * Creates filename to the template
 * @param string $template Filename of the template without extension
 * @return string
 */
function use_template($template)
{
    $template_doc = sprintf("views/%s.php", $template);
    return $template_doc;
}

/**
 * Creates breadcrumb HTML code using given array
 * @param array $breadcrumbs Array with as Key the page name and as Value the corresponding URL
 * @return string HTML code that represents the breadcrumbs
 */
function get_breadcrumbs($breadcrumbs)
{
    $breadcrumbs_exp = '
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">';
    foreach ($breadcrumbs as $name => $info) {
        if ($info[1]) {
            $breadcrumbs_exp .= '<li class="breadcrumb-item active" aria-current="page">' . $name . '</li>';
        } else {
            $breadcrumbs_exp .= '<li class="breadcrumb-item"><a href="' . $info[0] . '">' . $name . '</a></li>';
        }
    }
    $breadcrumbs_exp .= '
    </ol>
    </nav>';
    return $breadcrumbs_exp;
}

/**
 * Creates navigation HTML code using given array
 * @param array $navigation Array with as Key the page name and as Value the corresponding URL
 * @return string HTML code that represents the navigation
 */
function get_navigation($template, $active_id)
{
    $navigation_exp = '
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand">Room Overview</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">';
    foreach ($template as $id => $info) {
        if ($id == $active_id) {
            $navigation_exp .= '<li class="nav-item active">';
            $navigation_exp .= '<a class="nav-link" href="' . $info["url"] . '">' . $info["name"] . '</a>';
        } else {
            $navigation_exp .= '<li class="nav-item">';
            $navigation_exp .= '<a class="nav-link" href="' . $info["url"] . '">' . $info["name"] . '</a>';
        }

        $navigation_exp .= '</li>';
    }
    $navigation_exp .= '
    </ul>
    </div>
    </nav>';
    return $navigation_exp;
}

/**
 * Creates a Bootstrap table with a list of room
 * @param array $room Associative array of room
 * @return string
 */
function get_room_table($room, $pdo)
{
    $table_exp = '
    <table class="table table-hover">
    <thead
    <tr>
        <th scope="col">Address</th>
        <th scope="col">Price</th>
        <th scope="col">size</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>';
    foreach ($room as $key => $value) {
        $table_exp .= '
        <tr>
            <th scope="row">' . $value['address'] . '</th>
            <th scope="row">' . $value['price'] . '</th>
            <th scope="row">' . $value['size'] . '</th>
            <td><a href="/DDWT_final/room/' . $value['id'] . '" role="button" class="btn btn-primary">More info</a></td>
        </tr>
        ';
    }
    $table_exp .= '
    </tbody>
    </table>
    ';
    return $table_exp;
}

/**
 * Pretty Print Array
 * @param $input
 */
function p_print($input)
{
    echo '<pre>';
    print_r($input);
    echo '</pre>';
}

/**
 * Get array with all listed rooms from the database
 * @param PDO $pdo Database object
 * @return array Associative array with all rooms
 */
function get_room($pdo)
{
    $stmt = $pdo->prepare('SELECT * FROM room');
    $stmt->execute();
    $room = $stmt->fetchAll();
    $room_exp = array();

    /* Create array with htmlspecialchars */
    foreach ($room as $key => $value) {
        foreach ($value as $user_key => $user_input) {
            $room_exp[$key][$user_key] = htmlspecialchars($user_input);
        }
    }
    return $room_exp;
}

/**
 * Generates an array with room information
 * @param PDO $pdo Database object
 * @param int $room_id ID from the room
 * @return mixed
 */
function get_room_info($pdo, $room_id)
{
    $stmt = $pdo->prepare('SELECT * FROM room WHERE id = ?');
    $stmt->execute([$room_id]);
    $room_info = $stmt->fetch();
    $room_info_exp = array();

    /* Create array with htmlspecialchars */
    foreach ($room_info as $key => $value) {
        $room_info_exp[$key] = htmlspecialchars($value);
    }
    return $room_info_exp;
}

/**
 * Creates HTML alert code with information about the success or failure
 * @param array $feedback Associative array with keys type and message
 * @return string
 */
function get_error($feedback)
{
    if ($feedback) {
        $feedback = json_decode($feedback, True);
        $error_exp = '
        <div class="alert alert-' . $feedback['type'] . '" role="alert">
            ' . $feedback['message'] . '
        </div>';
        return $error_exp;
    } else {
        return False;
    }
}

/**
 * Add room to the database
 * @param PDO $pdo Database object
 * @param array $room_info Associative array with room info
 * @return array Associative array with key type and message
 */
function add_room($pdo, $room_info)
{
    /* Check if all fields are set */
    if (
        empty($room_info['address']) or
        empty($room_info['postal']) or
        empty($room_info['city']) or
        empty($room_info['type']) or
        empty($room_info['size'])
    ) {
        return [
            'type' => 'danger',
            'message' => 'There was an error. Not all fields were filled in.'
        ];
    }

    /* Check data type */
    if (!is_numeric($room_info['size']) or
        !is_numeric($room_info['size']))
    {
        return [
            'type' => 'danger',
            'message' => 'There was an error. You should enter a number in the field size.'
        ];
    }

    /* Check if room already exists */
    $stmt = $pdo->prepare('SELECT * FROM room WHERE address = ?');
    $stmt->execute([$room_info['address']]);
    $room = $stmt->rowCount();
    if ($room) {
        return [
            'type' => 'danger',
            'message' => 'This room was already added.'
        ];
    }

    /* Add room */
    $stmt = $pdo->prepare("INSERT INTO room (address, postal_code, city, price, type, size, owner) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $room_info['address'],
        $room_info['postal'],
        $room_info['city'],
        $room_info['price'],
        $room_info['type'],
        $room_info['size'],
        $_SESSION['user_id']
    ]);
    $inserted = $stmt->rowCount();
    if ($inserted == 1) {
        return [
            'type' => 'success',
            'message' => sprintf("Room has been added!")
        ];
    } else {
        return [
            'type' => 'danger',
            'message' => 'There was an error. The room was not added. Try it again.'
        ];
    }
}

/**
 * Updates a room in the database
 * @param PDO $pdo Database object
 * @param array $room_info Associative array with room info
 * @return array
 */
function update_room($pdo, $room_info, $id, $owner)
{
    /* Check if all fields are set */
    if (
        empty($room_info['address']) or
        empty($room_info['postal']) or
        empty($room_info['city']) or
        empty($room_info['price']) or
        empty($room_info['type']) or
        empty($room_info['size'])
    ) {
        return [
            'type' => 'danger',
            'message' => 'There was an error. Not all fields were filled in.'
        ];
    }

    /* Check data type */
    if (
        !is_numeric($room_info['price']) or
        !is_numeric($room_info['size'])) {
        return [
            'type' => 'danger',
            'message' => 'There was an error. You should enter a number in the field Seasons.'
        ];
    }


    /* Check if room already exists */
    $stmt = $pdo->prepare('SELECT * FROM room WHERE address = ? AND id != ?');
    $stmt->execute([$room_info['address'], $id]);
    $room = $stmt->rowCount();
    if ($room) {
        return [
            'type' => 'danger',
            'message' => 'This address is already taken.'
        ];
    }

    /* Update room */
    $stmt = $pdo->prepare("UPDATE room SET address = ?, postal_code = ?, city = ?, price = ?, type = ?, size = ?  WHERE id = ?");
    $stmt->execute([
        $room_info['address'],
        $room_info['postal'],
        $room_info['city'],
        $room_info['price'],
        $room_info['type'],
        $room_info['size'],
        $id
    ]);
    $updated = $stmt->rowCount();
    if ($_SESSION['user_id'] == $owner) {
        if ($updated == 1) {
            return [
                'type' => 'success',
                'message' => "room was edited!"
            ];
        } else {
            return [
                'type' => 'warning',
                'message' => 'The room was not edited. No changes were detected.'
            ];
        }
    }

}

/**
 * Removes a room with a specific room ID
 * @param PDO $pdo Database object
 * @param int $room_id ID of the room
 * @return array
 */
function remove_room($pdo, $room_id)
{
    /* Get room info */
    $room_info = get_room_info($pdo, $room_id);

    /* Delete room */
    $stmt = $pdo->prepare("DELETE FROM room WHERE id = ?");
    $stmt->execute([$room_id]);
    $deleted = $stmt->rowCount();
    if ($_SESSION['user_id'] == $room_info['owner']) {
        if ($deleted == 1) {
            return [
                'type' => 'success',
                'message' => sprintf("room '%s' was removed!", $room_info['owner'])
            ];
        } else {
            return [
                'type' => 'warning',
                'message' => 'An error occurred. The room was not removed.'
            ];
        }
    }

}

/**
 * Count the number of room listed on room Overview
 * @param PDO $pdo Database object
 * @return int
 */
function count_room($pdo)
{
    $stmt = $pdo->prepare('SELECT * FROM room');
    $stmt->execute();
    $room = $stmt->rowCount();
    return $room;
}

function count_users($pdo)
{
    $stmt = $pdo->prepare('SELECT * FROM user');
    $stmt->execute();
    $users = $stmt->rowCount();
    return $users;
}

/**
 * Changes the HTTP Header to a given location
 * @param string $location Location to redirect to
 */
function redirect($location)
{
    header(sprintf('Location: %s', $location));
    die();
}

/**
 * Get current user ID
 * @return bool Current user ID or False if not logged in
 */
function get_user_id()
{
    if (isset($_SESSION['user_id'])) {
        return $_SESSION['user_id'];
    } else {
        return False;
    }
}

/**
 * Get the full name of the user that is logged in
 * @param $user_id The username
 * @param $pdo
 * @return string First and last name
 */
function get_user_name($user_id, $pdo)
{
    $stmt = $pdo->prepare('SELECT first_name, last_name FROM user WHERE username = ?');
    $stmt->execute([$user_id]);
    $full_name_info = $stmt->fetch();
    $full_name = $full_name_info["first_name"]." ".$full_name_info["last_name"];
    return $full_name;
}

/**
 * Get data from posted form to add new user to the database
 * @param $pdo
 * @param $form_data
 * @return array|string[]
 */
function register_user($pdo, $form_data)
{
    /* Check if all fields are set */
    if (
        empty($form_data['username']) or
        empty($form_data['password']) or
        empty($form_data['first_name']) or
        empty($form_data['last_name'])
    ) {
        return [
            'type' => 'danger',
            'message' => 'You should enter a username, password, first- and last name.'
        ];
    }


    /* Check if user already exists */
    $stmt = $pdo->prepare('SELECT * FROM user WHERE username = ?');
    $stmt->execute([$form_data['username']]);
    $room = $stmt->rowCount();
    if ($room) {
        return [
            'type' => 'danger',
            'message' => 'This Username is already taken.'
        ];
    }

    /* hash password */
    $password = password_hash($form_data['password'], PASSWORD_DEFAULT);
    /* Add user */
    $stmt = $pdo->prepare("INSERT INTO user (username, password, occupation, role, biography, first_name, last_name, birth_date, email, phone_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $form_data['username'],
        $password,
        $form_data['occupation'],
        $form_data['role'],
        $form_data['biography'],
        $form_data['first_name'],
        $form_data['last_name'],
        $form_data['birth_date'],
        $form_data['email'],
        $form_data['phone_number']
    ]);
    $inserted = $stmt->rowCount();
    if ($inserted == 1) {
        login_user($pdo, $form_data);
        return [
            'type' => 'success',
            'message' => sprintf("User '%s' succesfully made an account.", $form_data['username'])
        ];
        redirect('/DDWT_final/myaccount/');
    } else {
        return [
            'type' => 'danger',
            'message' => 'There was an error. The room was not added. Try it again.'
        ];
    }
}

/**
 * This function is used to check if the user is already in the database, and start the session
 * @param $pdo
 * @param $form_data
 * @return array|string[]
 */
function login_user($pdo, $form_data)
{
    /* Check if all fields are set */
    if (
        empty($form_data['username']) or
        empty($form_data['password'])
    ) {
        return [
            'type' => 'danger',
            'message' => 'You should enter a username and password.'
        ];
    }
    /* Check if user exists */
    try {
        $stmt = $pdo->prepare('SELECT * FROM user WHERE username = ?');
        $stmt->execute([$form_data['username']]);
        $user_info = $stmt->fetch();
    } catch (PDOException $e) {
        return [
            'type' => 'danger',
            'message' => 'PDOException.'
        ];
    }
    /* Return error message for wrong username */
    if (empty($user_info)) {
        return [
            'type' => 'danger',
            'message' => 'This Username does not exist.'
        ];
    }
    /* check password */
    if (!password_verify($form_data['password'], $user_info['password'])) {
        return [
            'type' => 'danger',
            'message' => 'wrong password.'];
    } else {
        session_start();
        $_SESSION['user_id'] = $user_info['username'];
        $_SESSION['user_role'] = $user_info['role'];
        return [
            'type' => 'success',
            'message' => sprintf('%s, you were logged in successfully!',
                get_user_name($_SESSION['user_id'], $pdo))
        ];
    }
}

/**
 * Retrieve all info from logged in user
 * @param $pdo
 * @return mixed Returns a dictionary
 */
function get_user_info($pdo) {
    $stmt = $pdo->prepare('SELECT * FROM user WHERE username = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user_info = $stmt->fetchAll();

    return $user_info[0];
}

/**
 * Check if the user is logged in
 * @return bool
 */
function check_login()  {
    if (isset($_SESSION['user_id'])) {
        return True;
    } else {
        return False;
    }
}

/**
 * Used to end the session and log out
 * @return string[]
 */
function logout_user()
{
    session_start();
    session_destroy();
    return [
        'type' => 'success',
        'message' => 'You were logged out successfully!'
    ];
}

/**
 * @param $username
 * @param $password
 * @return array
 */
function set_cred($username, $password){
    return [
        'username'=> $username,
        'password'=> $password
    ];
}

/**
 * Get all messages sent to the user
 * @param $username
 * @param $pdo
 * @return Dictionary of messages
 */
function get_messages($username, $pdo){
    $stmt = $pdo->prepare('SELECT * FROM message WHERE receiver_username = ?');
    $stmt->execute([$username]);
    $message = $stmt->fetchAll();
    $message_exp = array();

    /* Create array with htmlspecialchars */
    foreach ($message as $key => $value) {
        foreach ($value as $user_key => $user_input) {
            $message_exp[$key][$user_key] = htmlspecialchars($user_input);
        }
    }
    return $message;
}

/**
 * Make a bootstrap table of all the messages
 * @param $message
 * @param $pdo
 * @return string
 */
function get_message_table($message, $pdo)
{
    $table_exp = '
    <table class="table table-hover">
    <thead
    <tr>
        <th scope="col">From:</th>
        <th scope="col">Content</th>
        <th scope="col">Date</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>';
    foreach ($message as &$value) {
        $table_exp .= '
        <tr>
            <td scope="row">' . $value['sender_username'] . '</td>
            <td scope="row">' . $value['text'] . '</td>
            <td scope="row">' . $value['datetime'] . '</td>
            <td><a href="/DDWT_final/message/' . $value['id'] . '" role="button" class="btn btn-primary">More info</a></td>
        </tr>
        ';
    }
    $table_exp .= '
    </tbody>
    </table>
    ';
    return $table_exp;
}

/**
 * Use the filled out form data to add a message to the database
 * @param $pdo
 * @param $message
 * @return array|string[]
 */
function send_message($pdo, $message){
    /* Check if all fields are set */
    if (
        empty($message['username']) or
        empty($message['message_text'])
    ) {
        return [
            'type' => 'danger',
            'message' => 'There was an error. Not all fields were filled in.'
        ];
    }

    /*check if the user exists */
    $stmt = $pdo->prepare('SELECT * FROM user WHERE username = ?');
    $stmt->execute([$message['username']]);
    $room = $stmt->rowCount();
    if ($room) {
        $stmt = $pdo->prepare("INSERT INTO message (datetime, text, sender_username , receiver_username) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            date("Y-m-d H:i:s"),
            $message['message_text'],
            $_SESSION['user_id'],
            $message['username'],

        ]);
        $inserted = $stmt->rowCount();
        if ($inserted == 1) {
            return [
                'type' => 'success',
                'message' => sprintf("Message sent!")
            ];
        } else {
            return [
                'type' => 'danger',
                'message' => 'There was an error. The message was not sent. Try it again.'
            ];
        }
    } else {
        return [
            'type' => 'danger',
            'message' => 'This user does not exist.'
        ];
    }


}

/**
 * Get all opt-ins that a tenant has sent for other peoples rooms
 * @param $pdo
 * @param $user_id
 * @return array
 */
function opt_in_tennant ($pdo, $user_id){
    $stmt = $pdo->prepare('SELECT room.owner, room.id, room.address, room.price, room.size FROM room JOIN opt_in ON opt_in.room_id=room.id WHERE opt_in.username = ?');
    $stmt->execute([$user_id]);
    $message = $stmt->fetchAll();
    $message_exp = array();

    /* Create array with htmlspecialchars */
    foreach ($message as $key => $value) {
        foreach ($value as $user_key => $user_input) {
            $message_exp[$key][$user_key] = htmlspecialchars($user_input);
        }
    }
    return $message_exp;
}

/**
 * Make a table with all the opt-ins from the previous function
 * @param $pdo
 * @param $message
 * @return string
 */
function make_opt_in_table ($pdo, $message) {
    $table_exp = '
    <table class="table table-hover">
    <thead
    <tr>
        <th scope="col">Address</th>
        <th scope="col">Price</th>
        <th scope="col">Size</th>
        <th scope="col">Owner</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>';
    foreach ($message as &$value) {
        $table_exp .= '
        <tr>
            <td>' . $value['address'] . '</td>
            <td>' . $value['price'] . '</td>
            <td>' . $value['size'] . '</td>
            <td>' . $value['owner'] . '</td>
            <td> <form action="/DDWT_final/remove_opt_in/" method="POST">
                <input type="hidden" value='. $value['id'] .' name="room_id">
                <button type="submit" class="btn btn-danger">Remove Opt-in</button>
                </form></td>
        </tr>
        ';
    }
    $table_exp .= '
    </tbody>
    </table>
    ';
    return $table_exp;
}

/**
 * Get all opt-ins that an owner has received for his rooms
 * @param $pdo
 * @param $user_id
 * @return array
 */
function opt_in_owner ($pdo, $user_id){
    $stmt = $pdo->prepare('SELECT 
    user.username, user.first_name, user.last_name, user.birth_date, user.occupation 
    FROM user 
    JOIN opt_in ON opt_in.username=user.username
    JOIN room ON room.id = opt_in.room_id
    WHERE room.owner = ?');
    $stmt->execute([$user_id]);
    $message = $stmt->fetchAll();
    $message_exp = array();

    /* Create array with htmlspecialchars */
    foreach ($message as $key => $value) {
        foreach ($value as $user_key => $user_input) {
            $message_exp[$key][$user_key] = htmlspecialchars($user_input);
        }
    }
    return $message_exp;
}

/**
 * Make a table with all the opt-ins from the previous function
 * @param $pdo
 * @param $message
 * @return string
 */
function make_opt_in_table_owner ($pdo, $message) {
    $table_exp = '
    <table class="table table-hover">
    <thead
    <tr>
        <th scope="col">Username</th>
        <th scope="col">First name</th>
        <th scope="col">Last name</th>
        <th scope="col">date of birth</th>
        <th scope="col">Occupation</th>
    </tr>
    </thead>
    <tbody>';
    foreach ($message as &$value) {
        $table_exp .= '
        <tr>
            <td>' . $value['username'] . '</td>
            <td>' . $value['first_name'] . '</td>
            <td>' . $value['last_name'] . '</td>
            <td>' . $value['birth_date'] . '</td>
            <td>' . $value['occupation'] . '</td>
        </tr>
        ';
    }
    $table_exp .= '
    </tbody>
    </table>
    ';
    return $table_exp;
}

/**
 * Add an opt-in with the click of a button
 * @param $pdo
 * @param $room_id
 * @return string[]
 */
function add_opt_in($pdo, $room_id) {

    $username = get_user_id();

    $stmt = $pdo->prepare('SELECT * FROM opt_in WHERE username = ? and room_id = ?');
    $stmt->execute([$username, $room_id]);
    $room = $stmt->rowCount();
    if ($room) {
        return [
            'type' => 'danger',
            'message' => 'You have already responded to this room.'
        ];
    }

    $stmt = $pdo->prepare("INSERT INTO opt_in (username, room_id) VALUES (?, ?)");
    $stmt->execute([$username, $room_id]);
    $deleted = $stmt->rowCount();
    if ($deleted == 1) {
        return [
            'type' => 'success',
            'message' => 'Your response has been submitted'
        ];
    } else {
        return [
            'type' => 'warning',
            'message' => 'An error occurred. The room was not removed.'
        ];
    }

}

/**
 * Remove an opt-in with the click of a button
 * @param $pdo
 * @param $room_id
 * @return string[]
 */
function remove_opt_in($pdo, $room_id) {
    /* Delete room */
    $username = get_user_id();
    $stmt = $pdo->prepare("DELETE FROM opt_in WHERE room_id = ? AND username = ?");
    $stmt->execute([$room_id, $username]);
    $deleted = $stmt->rowCount();
    if ($deleted == 1) {
        return [
            'type' => 'success',
            'message' => 'Your opt-in was removed'
        ];
    } else {
        return [
            'type' => 'warning',
            'message' => 'An error occurred. The opt-in was not removed.'
        ];
    }
}

/**
 * Extra table added on the overview page for owners for their rooms
 * @param $room
 * @param $pdo
 * @return string
 */
function get_owner_table($room, $pdo)
{
    $table_exp = '
    <table class="table table-hover">
    <thead
    <tr>
        <th scope="col">Address</th>
        <th scope="col">Price</th>
        <th scope="col">size</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>';
    foreach ($room as $key => $value) {
        $table_exp .= '
        <tr>
            <th scope="row">' . $value['address'] . '</th>
            <th scope="row">' . $value['price'] . '</th>
            <th scope="row">' . $value['size'] . '</th>
            <td><a href="/DDWT_final/room/' . $value['id'] . '" role="button" class="btn btn-primary">More info</a></td>
        </tr>
        ';
    }
    $table_exp .= '
    </tbody>
    </table>
    ';
    return $table_exp;
}

/**
 * Get all rooms from the user from the database
 * @param $pdo
 * @param $username
 * @return array
 */
function get_owner_room($pdo, $username)
{
    $stmt = $pdo->prepare('SELECT * FROM room WHERE owner = ?');
    $stmt->execute([$username]);
    $room = $stmt->fetchAll();
    $room_exp = array();

    /* Create array with htmlspecialchars */
    foreach ($room as $key => $value) {
        foreach ($value as $user_key => $user_input) {
            $room_exp[$key][$user_key] = htmlspecialchars($user_input);
        }
    }
    return $room_exp;
}
