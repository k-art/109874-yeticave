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
 * @return array|null
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
    return set_filter_for_all_strings(mysqli_fetch_all($result, MYSQLI_ASSOC));
}

/**
 * Записывает данные в БД
 *
 * @param $connect mysqli Ресурс соединения
 * @param $table_name string Имя таблицы
 * @param array $data Данные для записи
 *
 * @return bool|int|string
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

/**
 * Делает произвольный запрос в БД
 *
 * @param $connect mysqli Ресурс соединения
 * @param $sql string Строка запроса
 * @param array $data Данные для записи
 *
 * @return bool
 */
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

/**
 * Находит все категории из бд
 *
 * @param $connect mysqli Ресурс соединения
 * @return array
 */
function get_all_categories($connect) {
    $sql = 'SELECT * FROM categories';
    return db_select_data($connect, $sql);
}

/**
 * Устанавливает имя категории
 *
 * @param $id
 * @param array $categories Список категорий
 * @return bool|string
 */
function set_category($id, $categories) {
    $cat = '';

    foreach ($categories as $key => $value) {

        if ($value['id'] == $id) {
            $cat = $value['name'];
        }
    }
    if (!empty($cat)) {
        return $cat;
    }
    return false;
};

/**
 * Фильтрует текствый контент
 *
 * @param string $content Исходный текстовый контент
 * @return string Экранированный текстовый контент
 */
function filter_content($content) {
    return htmlentities($content, ENT_QUOTES, "UTF-8");
}

/**
 * Функция обертка для рекурсивной фильтрации текствого
 * контента.
 *
 * @param $arr array Исходный массив
 * @return array Экранированный массив
 */
function set_filter_for_all_strings($arr) {

    $result = array_map(function($something) {
        if (gettype($something)=== 'array') {
            return set_filter_for_all_strings($something);
        }

        if (gettype($something) === 'string') {
            return filter_content($something);
        }

        return $something;
    }, $arr);


    return $result;
}

/**
 * Валидирует форму
 *
 * @param $rules array Правила для валидации
 * @return array
 */
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
                        if (! validate_email($_POST[$key])) {
                            $all_errors[$key]['message'] = 'Введите корректный email';
                        }
                    }
                }

                if ($current_rule === 'text') {
                    if (isset($_POST[$key]) && !empty($_POST[$key])) {
                        if (! filter_text($_POST[$key])) {
                            $all_errors[$key]['message'] = 'Введите корректные данные';
                        }
                    }
                }

                if ($current_rule === 'numeric') {
                    if (isset($_POST[$key])) {
                        if (! validate_number($_POST[$key])) {
                            $all_errors[$key]['message'] = 'Введите число';
                        }
                    }
                }

                if ($current_rule === 'date') {
                    if (isset($_POST[$key])) {
                        if (! validate_date($_POST[$key])) {
                            $all_errors[$key]['message'] = 'Введите корректную дату';
                        }
                    }
                }

                if ($current_rule === 'category') {
                    if (isset($_POST[$key]) && $_POST[$key] === 'Выберите категорию') {
                        $all_errors[$key]['message'] = 'Выберите категорию';
                    }
                }
            }
        }
    }
    return $all_errors;
}

/**
 * Валидирует число
 *
 * @param $value
 * @return mixed
 */
function validate_number($value) {
    return filter_var($value, FILTER_VALIDATE_FLOAT);
}

/**
 * Валидирует текст
 *
 * @param $value
 * @return mixed
 */
function filter_text($value) {
    return filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

/**
 * Валидирует email
 *
 * @param $value
 * @return mixed
 */
function validate_email($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
}

/**
 * Валидирует дату
 *
 * @param $date
 * @return bool
 */
function validate_date($date) {
    return (preg_match('/^(\\d{2})\\.(\\d{2})\\.(\\d{4})$/', $date, $m) and checkdate($m[2], $m[1], $m[3]));
};

/**
 * Валидирует файл
 *
 * @param $type string Тип файла
 * @param $size int Размер файла
 * @param $file string Имя файла для формирования ошибки
 * @return array
 */
function validate_file ($type, $size, $file) {
    $valid_file_types = ['image/jpeg', 'image/png'];
    $file_error = [];

    if (!in_array($type, $valid_file_types)) {
        $file_error[$file]['message'] = 'Загрузите фото в формате jpg или png';
    }
    if ($size > MAX_FILE_SIZE) {
        $file_error[$file]['message'] = 'Максимальный размер файла: 200кб';
    }
    return $file_error;
}

/**
 * Ищет пользователя по email
 *
 * @param $connect mysqli Ресурс соединения
 * @param $email string email для проверки
 * @return mixed|null
 */
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

/**
 * Подставляет правильное окончание слова 'день'
 *
 * @param $value int День в виде числа
 * @return string
 */
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
/**
 * Выводит оставшееся время до завершения торгов лота
 *
 * @param $value
 * @return false|string
 */
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

/**
 * Форматирует время
 *
 * @param $time_stamp
 * @return false|string
 */
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

/**
 * Отрисовывает шаблон
 *
 * @param $file_name string Имя шаблона
 * @param $data array Данные для вставки
 * @return string Сгенерированный шаблон
 */
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

/**
 * Проверяет наличие открытой сессии
 */
function init_session() {
    if (!session_start()) {
        print "я закрылась";
        throw new Exeption('Can\'t start session');
    }
}
init_session();
