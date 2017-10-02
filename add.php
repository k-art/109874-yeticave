<?php
require_once ('functions.php');
require_once ('init.php');

$title = 'Добавление лота';
$categories = get_all_categories($connect);
$input_values = [
    'lot-name' => '',
    'description' => '',
    'category' => '',
    'lot-rate' => '',
    'lot-step' => '',
    'lot-expire' => ''
];
$errors = [];
$validationRules = [
    'lot-name' => [
        'required',
        'text'
    ],
    'category' => [
        'required',
        'text',
        'category'
    ],
    'description' => [
        'required',
        'text'
    ],
    'lot-rate' => [
        'required',
        'numeric'
    ],
    'lot-step' => [
        'required',
        'numeric'
    ],
    'lot-expire' => [
        'required',
        'date'
    ]
];
$errors = validate_form($validationRules);

if (!isset($_SESSION['user'])) {
    http_response_code(403);

    $error = 'Залогиньтесь для добавления лота! Ошибка 403';
    $content = render_template('error', ['categories' => $categories, 'error' => $error]);

    $layout_template = render_template('layout', [
        'title' => '403',
        'categories' => $categories,
        'content' => $content
    ]);
    print ($layout_template);
    exit();
}

if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
    $input_values = [
        'lot-name' => $_POST['lot-name'],
        'description' => $_POST['description'],
        'category' => $_POST['category'],
        'lot-rate' => $_POST['lot-rate'],
        'lot-step' => $_POST['lot-step'],
        'lot-expire' => $_POST['lot-expire']
    ];
}


if (($_SERVER['REQUEST_METHOD'] == 'POST') && empty($errors)) {
    $creation_date = date('Y-m-d H:i:s',$_POST['lot-date']);
    $lot_name = $_POST['lot-name'];
    $description = $_POST['description'];
    $category_id = $_POST['category'];
    $init_price = $_POST['lot-rate'];
    $bet_step = $_POST['lot-step'];
    $expire_date = $_POST['lot-expire'];

    if (isset($_FILES['lot-image'])) {
        $file_name = $_FILES['lot-image']['name'];
        $file_path = __DIR__ . IMG_DIR;
        $file_type = $_FILES['lot-image']['type'];
        $file_size = $_FILES['lot-image']['size'];

        $errors = validate_file($file_type, $file_size, 'lot-image');

        if (empty($errors['lot-image'])) {
            move_uploaded_file($_FILES['lot-image']['tmp_name'], $file_path . $file_name);
            $url_file = IMG_DIR . $file_name;
        }
    }

    if (empty($errors)) {
        $last_id = db_insert_data($connect, 'lots', [
            'creation_date' => $creation_date,
            'lot_name' => $lot_name,
            'description' => $description,
            'category_id' => $category_id,
            'init_price' => $init_price,
            'bet_step' => $bet_step,
            'expire_date' => $expire_date,
            'lot_image' => $url_file,
            'author_id' => $_SESSION['user']['id']
        ]);
        header("Location: /lot.php?id=$last_id");
        exit();
    }
}

$content = render_template('add',
    [
        'categories' => $categories,
        'errors' => $errors,
        'input_values' => $input_values
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
