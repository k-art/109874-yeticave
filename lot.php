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

if (isset($_COOKIE['user_bets'])) {
    $user_bets = json_decode($_COOKIE['user_bets'], true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['lot-id'];
    $date = $_POST['date'];

//    if(isset($_POST['cost']) && $_POST['cost'] != '' && validate_number($_POST['cost']) && $_POST['cost'] >= 12000) {
        $cost = $_POST['cost'];

        $user_bet = ['cost' => $cost, 'id' => $id, 'date' => $date];
        $user_bets[] = $user_bet;

        setcookie('user_bets', json_encode($user_bets), strtotime('Mon, 25-Jan-2027 10:00:00 GMT'), '/');
        header("Location: /mylots.php");
//    }
//    else {
////      Не получается правильно вернуться на страницу и показать ошибку
//        $err_message = 'Ваша ставка не действительна';
//        header("Location: /lot.php?id=$id");
//    }
}

elseif (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] >= count($lots)) {
    http_response_code(404);
    $content = "<h2>Error 404<br>Такой страницы не существует</h2>";

}
else {
    $id = $_GET['id'];

    $lot_data = [
        'categories' => $categories,
        'lots' => $lots,
        'bets' => $bets,
        'id' => $id,
        'err_message' => $err_message,
        'is_bet_exist' => $is_bet_exist,
        'user_bets' => $user_bets
    ];

    $content = render_template('lot', $lot_data);
}

$layout_data = [
    'title' => $title,
    'categories' => $categories,
    'content' => $content
];

$layout_template = render_template('layout', $layout_data);

print ($layout_template);
