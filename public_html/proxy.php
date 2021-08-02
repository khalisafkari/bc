<?php
$img = $_GET['data'];
preg_match('#\.(png|jpg|gif|jpeg)#is', $img, $file_extension);
switch(strtolower($file_extension[1])) {
	case "gif": $ctype="image/gif";
	break;
	case "png": $ctype="image/png";
	break;
	case "jpeg": $ctype="image/jpeg";
	break;
	case "jpg": $ctype="image/jpeg";
	break;
	default: $ctype="image/jpeg";
	break;
}
header('Content-type: ' . $ctype);
function encodeImage($image, $password = 'JDZyUVL8V0', $method = 'aes-256-cbc')
{

	$key = substr(hash('sha256', $password, true), 0, 32);
	$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

	$encrypted = urlencode(base64_encode(openssl_encrypt($image, $method, $key, OPENSSL_RAW_DATA, $iv)));
	return $encrypted;
}

function decodeImage($imageEncode, $password = 'JDZyUVL8V0', $method = 'aes-256-cbc')
{
	$key = substr(hash('sha256', $password, true), 0, 32);
	$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

	$decrypted = openssl_decrypt(base64_decode($imageEncode), $method, $key, OPENSSL_RAW_DATA, $iv);
	return $decrypted;
}
function showImg($url) {
	preg_match('#\.(png|jpg|gif|jpeg)#is', $url, $file_extension);
	switch(strtolower($file_extension[1])) {
		case "gif": $ctype="image/gif";
		break;
		case "png": $ctype="image/png";
		break;
		case "jpeg": $ctype="image/jpeg";
		break;
		case "jpg": $ctype="image/jpeg";
		break;
		default: $ctype="image/jpeg";
		break;
	}
	header('Content-type: ' . $ctype);
	$opts = array(
		'http'=>array(
			'method'=>"GET",
			'header'=>"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9\r\n" .
			"Accept-Language: vi-VN,vi;q=0.9,fr-FR;q=0.8,fr;q=0.7,en-US;q=0.6,en;q=0.5\r\n".
			"Referer: https://lovehug.net/\r\n".
			"Cookie: iUserID=%3DkXWE1ENjpWT; __cfduid=d38ba0ea9943a945c5376364accae84091554217851\r\n".
			"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.116 Safari/537.36\r\n"
		)
	);

	$context = stream_context_create($opts);
	$page = readfile($url, 0, $context);
	return $page;
}
$urlDecode = decodeImage(trim($img));
preg_match('#https?://.+?/.+?/(.+?)/(.+?)$#is', $urlDecode, $data);
$image = readfile('backend/'.$data[1].'/'.$data[2]);
echo $image;