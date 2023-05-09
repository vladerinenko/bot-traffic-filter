<?php

require __DIR__ . '/vendor/autoload.php';
require_once 'db.php';

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();
$log = new Logger('traffic');
$CrawlerDetect = new CrawlerDetect;

$userAgent = $CrawlerDetect->getUserAgent();
$ip = $request->getClientIp();

$log->pushHandler(new StreamHandler(__DIR__ . '/traffic.log', Logger::DEBUG));
$log->pushHandler(new FirePHPHandler());

$black_list_check = $db->query("SELECT * FROM black_list WHERE ip = '$ip'");

if($black_list_check->num_rows > 0) {
    $log->info('black-list-bot-detected', ['bot-user-agent' => $userAgent, 'bot-ip' => $ip]);
    exit();
}

if($CrawlerDetect->isCrawler()) {
    $log->info('crawler-bot-detected', ['bot-user-agent' => $userAgent, 'bot-ip' => $ip]);
    $db->query("INSERT INTO black_list (ip, user_agent) VALUES ('$ip', '$userAgent')");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/index.css">
</head>
<body>
<header>
    <div class="container d-flex justify-content-center pt-4">
        <div class="content d-flex justify-content-center align-items-center">Контент</div>
        <a class="trap" href="/trap.php"></a>
    </div>
</header>
</body>
</html>
