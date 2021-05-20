<?php

include './sample_rsa.php';

$rsa = new sample_rsa();
$key = $rsa->createKey();

$encrypt_data = $rsa->encrypt_data($key, 'test');

echo $encrypt_data.PHP_EOL;

$decrypt_data = $rsa->decrypt_data($key, $encrypt_data);

echo $decrypt_data.PHP_EOL;
