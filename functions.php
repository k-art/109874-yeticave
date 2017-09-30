<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set('Europe/Moscow');

require_once ('config.php');
require_once ('mysql_helper.php');

/**
 * Читает данные из БД
 *
 * @param $connect mysqli Ресурс соединения
 * @param $sql string SQL запрос
 * @param array $data Пользовательские данные
 *
 * @return array Массив данных
 */
function db_select_data($connect, $sql, $data = []) {

    $stmt = db_get_prepare_stmt($connect, $sql, $data);

    if (!$stmt) {
        return [];
    }
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        return [];
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Записывает данные в БД
 *
 * @param $connect mysqli Ресурс соединения
 * @param $table_name string Имя таблицы
 * @param array $data Данные для записи
 *
 * @return mixed
 */
function db_insert_data($connect, $table_name, $data = []) {

    $field_names = [];
    $values = [];
    $placeholders = [];

    foreach ($data as $key => $value) {
        $field_names[] = $key;
        $values[] = $value;
        $placeholders[] = '?';
    }

    $sql = 'INSERT INTO ' . $table_name . ' ('. implode(", ", $field_names) .')' . ' VALUES (' . implode(", ", $placeholders) . ')';

    $stmt = db_get_prepare_stmt($connect, $sql, $values);

    if (!$stmt) {
        return false;
    }
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        return false;
    }
    return mysqli_insert_id($connect);
}

//Произвольный запрос
function db_exec_query($connect, $sql, $data = []) {

    $stmt = db_get_prepare_stmt($connect, $sql, $data);

    if (!$stmt) {
        return false;
    }
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        return false;
    }
    return true;
}

function get_all_categories($connect) {
    $sql = 'SELECT * FROM categories';
    return db_select_data($connect, $sql);
}

//Валидация формы
function validate_form($rules) {
    $all_errors = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        foreach ($rules as $key => $rule) {

            foreach ($rule as $current_rule) {
                if ($current_rule === 'required') {
                    if (! isset($_POST[$key]) || $_POST[$key] == '') {
                        $all_errors[$key]['message'] = 'Пожалуйста, заполните это поле';
                    }
                }

                if ($current_rule === 'email') {
                    if (isset($_POST[$key]) && !empty($_POST[$key])) {
                        if (! filter_var($_POST[$key], FILTER_VALIDATE_EMAIL)) {
                            $all_errors[$key]['message'] = 'Введите корректный email';
                        }
                    }
                }

                if ($current_rule === 'text') {
                    if (isset($_POST[$key]) && !empty($_POST[$key])) {
                        if (! filter_var($_POST[$key], FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                            $all_errors[$key]['message'] = 'Введите корректные данные';
                        }
                    }
                }

                if ($current_rule === 'numeric') {
                    if (isset($_POST[$key])) {
                        if (! filter_var($_POST[$key], FILTER_VALIDATE_FLOAT)) {
                            $all_errors[$key]['message'] = 'Для данного поля предсмотрен ввод только чисел';
                        }
                    }
                }

                if ($current_rule === 'date') {
                    if (isset($_POST[$key])) {
                        if (!validate_date($_POST[$key])) {
                            $all_errors[$key]['message'] = 'Введите корректную дату';
                        }
                    }
                }

//                if ($current_rule === 'file') {
//                    if (isset($_FILES[$key])) {
//                        if ($_FILES[$key]['type'] !== 'image/jpeg') {
//                            $all_errors[$key]['message'] = 'Загрузите фото в формате jpg';
//                        }
//                        elseif ($_FILES[$key]['size'] > MAX_FILE_SIZE) {
//                            $all_errors[$key]['message'] = 'Максимальный размер файла: 200кб';
//                        }
//                    }
//                }

                // функцию можно доработать для проверки других типов.

            }
        }
    }
    return $all_errors;
}
//Проверка отдельных полей, необходимо интегрировать в основную функцию валидации...
function validate_number($value) {
    return filter_var($value, FILTER_VALIDATE_INT);
}
function filter_text($value) {
    return trim(htmlspecialchars($value));
}
function validate_email($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
}
function validate_date($date) {
    return (preg_match('/^(\\d{2})\\.(\\d{2})\\.(\\d{4})$/', $date, $m) and checkdate($m[2], $m[1], $m[3]));
};

function search_user_by_email($connect, $email) {
    $users = db_select_data($connect, 'SELECT * FROM users');

    $result = null;
    foreach ($users as $user) {
        if ($user['email'] == $email) {
            $result = $user;
            break;
        }
    }
    return $result;
}

function days($value) {
    $res_1 = $value % 10;
    $res_2 = $value / 10 % 10;
    if ($res_1 == 1) {
        return "день";
    }
    if ($res_2 && $res_2 == 1) {
        return "дней";
    }
    if (in_array($res_1,["2,3,4"])) {
        return "дня";
    }
    return "дней";
}
//Подсчет оставшегося времени
function set_lot_time_remaining ($value) {
    $expire_date = strtotime($value);
    $now = strtotime('now');
    $time_remaining = $expire_date - $now;

    if ($time_remaining <= TIME_24_HOURS) {
        return gmdate('H:i:s',$time_remaining);
    }
    if ($time_remaining > TIME_24_HOURS * 30) {
        return gmdate('Больше месяца',$time_remaining);
    }
    $result = gmdate('j',$time_remaining);
    $day_name = days($result);

    return "$result $day_name";
}

//Форматирование времени
function format_time ($time_stamp) {
    $time = strtotime($time_stamp);
    $now = strtotime('now');
    $past_time = $now - $time ;

    if ($past_time > TIME_24_HOURS) {
        return gmdate('d.m.y в H:i', $time);
    }
    if ($past_time < TIME_1_HOUR) {
        return gmdate('i минут назад', $past_time);
    }
    return gmdate('G часов назад', $past_time);
}

function is_bet_exist ($user_bets, $lot_id) {
    foreach ($user_bets as $bet) {
        if (intval($bet['lot_id']) === intval($lot_id)) {
            return true;
        }
    }
    return false;
};


//Отрисовка шаблона
function render_template ($file_name, $data) {

    $path_to_template_file = TEMPLATES_DIR . $file_name . TEMPLATE_EXT;

    if (file_exists($path_to_template_file)) {
        ob_start('ob_gzhandler');
        extract($data, EXTR_SKIP);
        require $path_to_template_file;
        return ob_get_clean();
    }
    return '';
}

//Проверка сессии
function init_session() {
    if (!session_start()) {
        print "я закрылась";
        throw new Exeption('Can\'t start session');
    }
}
init_session();
