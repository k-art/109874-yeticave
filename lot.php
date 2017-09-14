<?php
require_once ('functions.php');
require_once ('lots_data.php');

$title = 'Лот';
$id = '';
$user_bets_data = [];
$cost = '';
$err_message = '';
$user_bets = [];
$is_bet_exist = false;
$validationRules = [
    'cost' => [
        'required',
        'numeric'
    ]
];
$validation_errors = validate_form($validationRules);

if (isset($_COOKIE['user_bets'])) {
    $user_bets = json_decode($_COOKIE['user_bets'], true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['lot-id'];
    $date = $_POST['date'];

    if (empty($validation_errors)) {
        $cost = $_POST['cost'];

        $user_bet = ['cost' => $cost, 'id' => $id, 'date' => $date];
        $user_bets[] = $user_bet;

        setcookie('user_bets', json_encode($user_bets), strtotime('Mon, 25-Jan-2027 10:00:00 GMT'), '/');
        header("Location: /mylots.php");
    }

    print_r($validation_errors);

}


if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] >= count($lots)) {
http_response_code(404);
$content = "<h2>Error 404<br>Такой страницы не существует</h2>";

}
else {

    $id = $_GET['id'];

    $content = render_template('lot',
        [
            'categories' => $categories,
            'lots' => $lots,
            'bets' => $bets,
            'id' => $id,
            'validation_errors' => $validation_errors,
            'is_bet_exist' => $is_bet_exist,
            'user_bets' => $user_bets
        ]
    );

}

$layout_data = [
    'title' => $title,
    'categories' => $categories,
    'content' => $content
];

$layout_template = render_template('layout', $layout_data);

print ($layout_template);
