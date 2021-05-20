# sample_php_rsa

PHP RSA加解密原理实现(不调用php内置的rsa函数,纯方法实现)


`
$rsa = new sample_rsa();
$key = $rsa->createKey();

$encrypt_data = $rsa->encrypt_data($key, 'test');

echo $encrypt_data.PHP_EOL;

$decrypt_data = $rsa->decrypt_data($key, $encrypt_data);

echo $decrypt_data.PHP_EOL;
`
