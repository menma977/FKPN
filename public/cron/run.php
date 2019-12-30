<?php
$url = $_SERVER['SERVER_NAME'] . '/api/cron/run';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);

print_r($result);
curl_close($ch);
