<?php

include '../../../controllers/cont.main.php';

function create_captcha() {
	$md5_hash = md5(rand(0,999));
	$captcha = substr($md5_hash, 15, 5);
	$_SESSION['captcha'] = $captcha;
	$width = 100;
	$height = 30;
	$image = ImageCreate($width, $height);
	$nen = ImageColorAllocate($image, 119, 41, 83);
	$chu = ImageColorAllocate($image, 255, 255, 255);
	ImageFill($image, 0, 0, $nen);
	ImageString($image, 5, 30, 6, $captcha, $chu);
	header("Content-Type: image/jpeg");
	ImageJpeg($image);
	ImageDestroy($image);
}
create_captcha();