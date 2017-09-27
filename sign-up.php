<?php
require_once ('functions.php');
require_once ('init.php');

if (isset($_SESSION['user'])) {
    header("Location: /index.php");
}

$title = 'Регистрация';
$categories = get_all_categories($connect);
$validationRules = [
    'user_email' => [
        'required',
        'email'
    ],
    'user_password' => [
        'required'
    ],
    'user_name' => [
        'required'
    ],
    'user_contacts' => [
        'required'
    ],
    'user_avatar' => [
        'file'
    ]
];
$validation_errors = validate_form($validationRules);



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

}


$content = render_template('sign-up',
    [
        'categories' => $categories,
        'validation_errors' => $validation_errors
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
