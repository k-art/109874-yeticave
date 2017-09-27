<?php
require_once ('lots_data.php');
require_once ('functions.php');
require_once ('init.php');

$title = 'Лот';
$categories = db_select_data($connect, 'SELECT * FROM categories');
$lot_id = '';
$lot = '';
$bets = '';
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

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
http_response_code(404);
$content = "<h2>Error 404<br>Такой страницы не существует</h2>";
    $layout_data = [
        'title' => $title,
        'categories' => $categories,
        'content' => $content
    ];
    $layout_template = render_template('layout', $layout_data);
    print ($layout_template);
}

if (isset($_GET['id'])) {
    $lot_id = intval($_GET['id']);
    $lot_query = "
        SELECT lots.id, lots.lot_name, lots.description, lots.lot_image, lots.expire_date, lots.bet_step, 
        IFNULL(MAX(bets.price), lots.init_price) as lot_price, categories.name as cat_name, COUNT(bets.lot_id) as bets_count
        FROM lots
        JOIN bets ON bets.lot_id = lots.id
        JOIN categories ON categories.id = lots.category_id
        WHERE lots.id = $lot_id
        GROUP BY lots.id";

    if ($result = mysqli_query($connect, $lot_query)) {

        if (!mysqli_num_rows($result)) {
            http_response_code(404);
            $content = render_template('error.php', ['error' => 'Гифка с этим идентификатором не найдена']);
        }
        $lot = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $bets = db_select_data($connect,"
            SELECT users.id, users.name, bets.price, bets.date 
            FROM bets 
            JOIN lots ON bets.lot_id = lots.id
            JOIN users ON users.id = bets.user_id
            WHERE lots.id = $lot_id
            GROUP BY bets.id
            ORDER BY bets.date"
        );
    }
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

//    $id = $_GET['id'];

$content = render_template('lot',
    [
        'categories' => $categories,
        'lot' => $lot,
        'bets' => $bets,
        'id' => $lot_id,
        'validation_errors' => $validation_errors,
        'is_bet_exist' => $is_bet_exist,
        'user_bets' => $user_bets
    ]
);

$layout_data = [
    'title' => $title,
    'categories' => $categories,
    'content' => $content
];

$layout_template = render_template('layout', $layout_data);

print ($layout_template);
