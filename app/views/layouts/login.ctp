<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>[Buche de Noel]</title>
<link href="/buchedenoel/favicon.ico" type="image/x-icon" rel="icon" />
<?php echo $html->charset(); ?>
<?php echo $html->css('css'); ?>
</head>

<body id="yahoo-com" class=" yui-skin-sam">
<div id="doc3" class="yui-t2">

<div id="hd"><!--Header Start-->

<div id="ygma"><a href=""><?php echo $html->image('titlle-1.png')?></a></div><!--Header Step2 End-->
<div id="pagetitle"><h1>ログイン画面 - Login</h1></div><!--Header Step3 End-->
</div><!--Header End-->


<div id="bd">
<div id="yui-main">
<div class="yui-b">

<div id="index-main">
<!--1Unit Start-->
<p>
<?php
/*
if($loginUser){
	echo sprintf(__('Logon:%s' ,true) ,$loginUser['User']['name']);
	echo '　(<a href="/buchedenoel/users/logout">Logout</a>)';
}
*/
$session->flash();
echo $content_for_layout;
?>
</p>
<h2>Start UP Buche de Noel</h2>
<p>
インターネットエクスプローラー(Internet Explorer) Ver.6および7では表示が崩れ、一部機能が働きません。<br>
当システムは FireFox3 以降を推奨します。<br>
下記からインストーラーをダウンロードできます。<br>
<a href="http://download.mozilla.org/?product=firefox-3.6.11&os=win&lang=ja" target="_blank">Firefox Setup 3.6.11.exe</a><br>
</p>
<p>
印刷ソフトとして、当システムは PXDoc を使用します。<br>
下記からダウンロード、インストールして下さい。<br>
<a href="http://www.pxdoc.com/download-11821.php" target="_blank">PXDoc本体ダウンロード 1.18.21</a><br>
</p>
<p>
詳しくは配布資料、セットアップガイドをご覧下さい。<br>
</p>
<!--1Unit End-->

</div>
</div>
</div>
</div>

<div class="yui-b" id="tocWrapper"><!--Menu Start-->
</div><!--Menu End-->

<div id="ft">
<p class="first">Hideichi System's</p>
</div>
</div>
<?php echo $cakeDebug; ?>
</body>
</html>
