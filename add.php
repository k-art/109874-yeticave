<?php
require_once ('functions.php');
require_once ('lots_data.php');

$title = 'Добавление лота';

//Проверка формы
$required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
$numbers = ['lot-rate', 'lot-step', 'lot-date'];
$text = ['lot-name', 'message'];
$errors = [];
$err_messages = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {

        if (in_array($key, $required) && $value == '') {
            $errors[] = $key;
            $err_message[$key] = 'Заполните это поле';
        }
        if ($key === 'category' && $value === 'Выберите категорию') {
            $err_message[$key] = 'Выберите категорию';
        }
        if (in_array($key, $numbers) && !($value == '')) {
            $result = call_user_func('validate_number', $value);

            if (!$result) {
                $errors[] = $key;
                $err_message[$key] = 'Введите число';
            }
        }
    }
    $content = render_template('add', [
        'categories' => $categories,
        'lots' => [],
        'bets' => [],
        'lot_name_value' => '',
        'errors' => $errors,
        'err_message' => $err_message
    ]);

    $lot_name = filter_text($_POST['lot-name']);
    $message = filter_text($_POST['message']);
    $category = filter_text($_POST['category']);
    $lot_rate = $_POST['lot-rate'];
    $lot_step = $_POST['lot-step'];
    $lot_date = $_POST['lot-date'];

    if (isset($_FILES['item_photo'])) {
        $file_name = $_FILES['item_photo']['name'];
        $file_path = __DIR__ . '/img/';
        $file_type = $_FILES['item_photo']['type'];

        move_uploaded_file($_FILES['item_photo']['tmp_name'], $file_path . $file_name);

        $url_file = '/img/' . $file_name;
    }
    if (empty($errors)) {
        $new_lot = [
            [
                'name' => $lot_name,
                'category' => $category,
                'price' => $lot_rate,
                'url' => $url_file,
                'description' => $message,
                'id' => 0
            ]
        ];
        $lot_data['lots'] = $new_lot;

        $content = render_template('lot',
            [
                'categories' => $categories,
                'lots' => $new_lot,
                'id' => 0,
                'bets' => []
            ]
        );
    }

}
else {
    $lot_data = [
        'categories' => $categories,
        'lots' => [],
        'bets' => [],
        'lot_name_value' => '',
        'errors' => $errors
    ];
    $content = render_template('add', $lot_data);
}

$layout_data = [
    'title' => 'Добавление лота',
    'categories' => $categories,
    'user_name' => 'Константин',
    'user_avatar' => 'img/user.jpg',
    'is_auth' => (bool) rand(0, 1),
    'content' => $content
];

$layout_template = render_template('layout', $layout_data);
print ($layout_template);
