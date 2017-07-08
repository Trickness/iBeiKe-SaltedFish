<?php
session_start();
include(__DIR__.'/../CaptchaBuilderInterface.php');
include(__DIR__.'/../PhraseBuilderInterface.php');
include(__DIR__.'/../CaptchaBuilder.php');
include(__DIR__.'/../PhraseBuilder.php');
use Gregwar\Captcha\CaptchaBuilder;
$builder = new CaptchaBuilder;
$builder->build();
if (isset($_GET['action'])) {
	if (trim($_GET['action'])=="getcap") {
		
		$_SESSION['captcha'] = $builder->build()->inline();
		$_SESSION['phrase'] = $builder->getPhrase();
		// echo $_SESSION['phrase'];
		// $cap = $builder->build()->inline();
		echo $builder->inline();
	}elseif (trim($_GET['action']=="check") && isset($_GET['phr'])) {
			if ($_GET['phr']==$_SESSION['phrase']) {
				echo true;
			}else{
				echo false;
			}
	}
}
?>
	