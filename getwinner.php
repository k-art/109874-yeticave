<?php
require_once ('functions.php');
require_once ('init.php');
require_once ('vendor/autoload.php');

$transport = (new Swift_SmtpTransport('smtp.mail.ru', 465, 'ssl'))
    ->setUsername('doingsdone@mail.ru')
    ->setPassword('rds7BgcL');

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

$winners = [];

$closed_lots = db_select_data($connect, '
    SELECT 
      lots.id, 
      lots.lot_name 
    FROM lots 
    WHERE lots.expire_date <= NOW()
    AND lots.winner_id IS NULL');


foreach ($closed_lots as $lot) {

    $winners[] = db_select_data($connect, '
    SELECT 
      users.id AS user_id, 
      users.name AS user_name, 
      users.email, 
      lots.id AS lot_id, 
      lots.lot_name,
      bets.price
	FROM bets
	INNER JOIN lots ON bets.lot_id = lots.id
	INNER JOIN users ON bets.user_id = users.id
	WHERE lot_id= ?
	ORDER BY bets.date DESC
	LIMIT 1', [$lot['id']]);
}

foreach ($winners as $winner) {
    $winner = array_pop($winner);

    if (!empty($winner)) {

    $letter = render_template('email', ['winner' => $winner]);

// Create a message
    $message = (new Swift_Message('Ваша ставка победила'))
        ->setFrom(['doingsdone@mail.ru' => 'Интернет-аукцион «Yeti Cave»'])
        ->setTo([$winner['email'] => $winner['user_name']])
        ->setBody($letter, 'text/html');
// Send the message
    $result = $mailer->send($message);

    db_exec_query($connect, '
        UPDATE lots 
        SET lots.winner_id = ?
        WHERE lots.id = ?', [$winner['user_id'], $winner['lot_id']]);
    }
}
