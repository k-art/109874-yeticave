<?php
require_once ('functions.php');
require_once ('lots_data.php');

$title = 'Лот';
$id = '';
$user_bets_data = [];
$cost = '';
$err_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['lot-id'];
    $date = $_POST['date'];

    if(isset($_POST['cost']) && $_POST['cost'] != '' && validate_number($_POST['cost']) && $_POST['cost'] >= 12000) {
        $cost = $_POST['cost'];

        $user_bets = json_encode(['cost' => $cost, 'id' => $id, 'date' => $date]);

        setcookie('user_bets', $user_bets, strtotime('Mon, 25-Jan-2027 10:00:00 GMT'), '/');
//        print_r($user_bets_data);

        header("Location: /mylots.php");
    }
    else {
        $err_message = 'Ваша ставка не действительна';
        header("Location: /lot.php?id=$id");
    }

}




$lot_data = [
    'categories' => $categories,
    'lots' => $lots,
    'bets' => $bets,
    'id' => $id,
    'err_message' => $err_message
];

$content = render_template('lot', $lot_data);

$layout_data = [
    'title' => $title,
    'categories' => $categories,
    'content' => $content
];

$layout_template = render_template('layout', $layout_data);

print ($layout_template);
