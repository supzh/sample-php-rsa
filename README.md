# sample-php-rsa

PHP RSA encryption and decryption principle implementation (does not call PHP’s built-in rsa function, pure method implementation)

PHP RSA加解密原理实现(不调用php内置的rsa函数,纯方法实现)


eg 示例:
```php
$rsa = new sample_rsa();
$key = $rsa->createKey();

$encrypt_data = $rsa->encrypt_data($key, 'test');

echo $encrypt_data."\n";

$decrypt_data = $rsa->decrypt_data($key, $encrypt_data);

echo $decrypt_data."\n";
```
