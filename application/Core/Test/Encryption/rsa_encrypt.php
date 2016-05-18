<?php

      $private_key = '-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQC++SsbogzteAwnbdd7OX9mFDlH9mwslsx0Xps13AwjFVkEqBPd
Rx0h/7fsor36xv2cDvgeawrYWzYJDaetYCW0IAbW5P/cBQTtewVHR6hEp5P40nat
OJz6bADOlzZRL6O/w0WIb0K33haMoSHdU4jenfgg5TjRJ1z5dm6OUA6cWwIDAQAB
AoGAQrEzi7/o8dlVrUNf2Cm5QwXXBzmYh23WUuFjJMkG+A2Re93SqhkWpHPwYFRp
MjXiBWj4326UaABae4joQNTt9UF0cpEpCok2qBV+dHQmaROE8zKxhrMeClkMKzwT
WIzhQDFJqc7cwDVcYMg9DMDvXmtHttv3KCeQw6hgYmHhF5kCQQD0I+cKlCEbmRLq
B1sbkBvp9phAWEFZxvV27hn7myYAqOWOiVRFBuOLKZJVjWPBZczwefDTjH4KmOp5
0UFMpHy9AkEAyEAWrpyuR9ig2/kDQ2f/d6ZcvPkf+Gt+5kIBXtRUiIskoKdGW5PQ
GDfcv2rxkWAAyqySb9qbw7snCKZDVcRq9wJBAKHcc79luhWMBSg3vEWn43nYTdTL
LniRGgjBj2Rq1mU1lQxNLBufl5iZ9TTXSr3b+mWs0ufOi3oHK92byIlBvJkCQQCc
AmIpc2PMEZdxCRVjxHghTXjeuPARaB4bYb0TljStlEna57dGzWfIFm1iq/y7l6HG
RKBpiFTmLr6AXJgFD9uNAkAFkRI2MbAx1NHyRQfgXrp5dtYmK7mFDS9w0p/ePpP9
vIFHGSlkYdRckaazpT/BfILjt0bpTx5EssfRX5nlm1fE
-----END RSA PRIVATE KEY-----
';

$public_key = '
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC++SsbogzteAwnbdd7OX9mFDlH
9mwslsx0Xps13AwjFVkEqBPdRx0h/7fsor36xv2cDvgeawrYWzYJDaetYCW0IAbW
5P/cBQTtewVHR6hEp5P40natOJz6bADOlzZRL6O/w0WIb0K33haMoSHdU4jenfgg
5TjRJ1z5dm6OUA6cWwIDAQAB
-----END PUBLIC KEY-----
';

//判断私钥是否可用
$pi_key = openssl_pkey_get_private($private_key);
//判断公钥是否可用
$pu_key = openssl_pkey_get_public($public_key);

var_dump($pi_key);echo "\n";
var_dump($pu_key);echo "\n";

$data = "aasssasssddd";//原始数据
$encrypted = "";
$decrpted  = "";

echo "source data:".$data."\n";
echo "private key encrypt:\n";

//私钥加密
openssl_private_encrypt($data,$encrypted,$pi_key);
$encrypted = base64_encode($encrypted);

echo $encrypted."\n";

echo "public key decrypt:\n";

openssl_public_decrypt(base64_decode($encrypted),$decrpted,$pu_key);
echo $decrpted."\n";


echo "--------------------------";
echo "public key encrypt: \n";

openssl_public_encrypt($data,$encrypted,$pu_key); //公钥加密

$encrypted = base64_encode($encrypted);

echo $encrypted."\n";

echo "private key decrypt:\n";

openssl_private_decrypt(base64_decode($encrypted),$decrpted,$pi_key);//私钥解密

echo $decrpted,"\n";







