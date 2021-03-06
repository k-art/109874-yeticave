<?php
require_once ('functions.php');
require_once ('init.php');
require_once ('vendor/autoload.php');

if (isset($_SESSION['user'])) {
    header("Location: /index.php");
}

$title = 'Регистрация';
$categories = get_all_categories($connect);
$input_values = [
    'email' => '',
    'name' => '',
    'contacts' => ''
];
$errors = [];
$url_file = '';
$validationRules = [
    'email' => [
        'required',
        'email',
        'text'
    ],
    'password' => [
        'required',
        'text'
    ],
    'name' => [
        'required',
        'text'
    ],
    'contacts' => [
        'required',
        'text'
    ]
];
$errors = validate_form($validationRules);

if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
    $input_values = [
        'email' => $_POST['email'],
        'name' => $_POST['name'],
        'contacts' => $_POST['contacts']
    ];
}

if (($_SERVER['REQUEST_METHOD'] == 'POST') && empty($errors)) {
    $date = date('Y-m-d H:i:s',$_POST['date']);
    $email_received = $_POST['email'];
    $password_received = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name_received = $_POST['name'];
    $contacts_received = $_POST['contacts'];

    //проверка на email
    if (search_user_by_email($connect, $email_received)) {
        $errors['email']['message'] = 'Пользователь с таким email уже существует';
    }

    if (isset($_FILES['avatar'])) {
        $file_name = $_FILES['avatar']['name'];
        $file_path = __DIR__ . IMG_DIR;
        $file_type = $_FILES['avatar']['type'];
        $file_size = $_FILES['avatar']['size'];

        $errors = validate_file($file_type, $file_size, 'avatar');

        if (empty($errors['avatar'])) {
            move_uploaded_file($_FILES['avatar']['tmp_name'], $file_path . $file_name);
            $url_file = IMG_DIR . $file_name;
        }

    }

    if(!empty($errors)) {
        $content = render_template('sign-up', ['categories' => $categories, 'errors' => $errors, 'input_values' => $input_values]);
        $layout_template = render_template('layout', ['title' => $title, 'categories' => $categories, 'content' => $content]);
        print ($layout_template);
        exit();
    }

    db_insert_data($connect, 'users', [
        'creation_date' => $date,
        'email' => $email_received,
        'name' => $name_received,
        'password' => $password_received,
        'user_contacts' => $contacts_received,
        'avatar' => $url_file
    ]);
    header("Location: /login.php?new_user=ok");
}

$content = render_template('sign-up',
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
