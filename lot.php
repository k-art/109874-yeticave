<?php
require_once ('functions.php');
require_once ('init.php');

$title = 'Лот';
$categories = get_all_categories($connect);
$lot_id = null;
$lot = '';
$user_id = null;
$bets = [];
$lots = db_select_data($connect, "
    SELECT 
      lots.id
    FROM lots ");

$price = null;
$user_bets = [];
$validationRules = [
    'cost' => [
        'required',
        'numeric'
    ]
];
$errors = validate_form($validationRules);

if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['id'];
}
$user_bets = db_select_data($connect, "
    SELECT  
      bets.lot_id
    FROM bets");


if (($_SERVER['REQUEST_METHOD'] == 'POST') && empty($errors)) {
    $lot_id = $_POST['lot-id'];
    $lot_price = $_POST['lot_price'];
    $bet_step = $_POST['bet_step'];
    $date = date('Y-m-d H:i:s',$_POST['date']);
    $price = $_POST['cost'];

    if ($price < $lot_price + $bet_step) {
        $errors['cost']['message'] = 'Ваша ставка слишком мала';
        $_GET['errors']['cost'] = $errors['cost']['message'];
        header("Location: /lot.php?id=$lot_id");
        exit();
    }

    db_insert_data($connect, 'bets', ['user_id' => $user_id, 'lot_id' => $lot_id, 'date' => $date, 'price' => $price]);
    header("Location: /mylots.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] > array_pop($lots)['id']) {
    http_response_code(404);
    $error = 'Такой страницы не существует! Ошибка 404';
    $content = render_template('error', ['categories' => $categories, 'error' => $error]);

    $layout_template = render_template('layout', [
        'title' => '404',
        'categories' => $categories,
        'content' => $content
    ]);
    print ($layout_template);
    exit();
}

$lot_id = $_GET['id'];

$lot = db_select_data($connect, "
    SELECT
      lots.id, 
      lots.lot_name, 
      lots.description, 
      lots.lot_image, 
      lots.expire_date, 
      lots.bet_step, 
      IFNULL(MAX(bets.price), 
      lots.init_price) as lot_price, 
      categories.name as cat_name, 
      COUNT(bets.lot_id) as bets_count
    FROM lots
    LEFT JOIN bets ON bets.lot_id = lots.id
    LEFT JOIN categories ON categories.id = lots.category_id
    WHERE lots.id = ?
    GROUP BY lots.id", [$lot_id]);

$bets = db_select_data($connect,"
    SELECT 
      users.id as user_id, 
      users.name, 
      bets.price, 
      bets.date 
    FROM bets 
    JOIN lots ON bets.lot_id = lots.id
    JOIN users ON users.id = bets.user_id
    WHERE lots.id = ?
    GROUP BY bets.id
    ORDER BY bets.date DESC", [$lot_id]);

$is_bet_made = false;

foreach($bets as $key => $bet) {
    if (intval($bet['user_id']) === $user_id) {
        $is_bet_made = true;
        break;
    }
}

$content = render_template('lot',
    [
        'categories' => $categories,
        'lot' => $lot,
        'bets' => $bets,
        'user_bets' => $user_bets,
        'lot_id' => $lot_id,
        'is_auth' => !empty($user_id),
        'is_bet_made' => $is_bet_made
    ]
);
$layout_template = render_template('layout',
    [
        'title' => $title,
        'categories' => $categories,
        'content' => $content
    ]
);
print ($layout_template);
