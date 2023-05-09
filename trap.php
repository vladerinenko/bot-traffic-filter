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

$log->info('pixel-trap-bot-detected', ['bot-user-agent' => $userAgent, 'bot-ip' => $ip]);
$db->query("INSERT INTO black_list (ip, user_agent) VALUES ('$ip', '$userAgent')");
