<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Buche de Noel:<?php echo $title_for_layout; ?></title>
<?php
echo $html->charset("UTF-8");
echo $html->meta('icon');
echo $html->css('css');
echo $html->css("cake.ajax");
echo $html->css("redmond/jquery-ui-1.8.14.custom");
echo $html->css("jquery.autocomplete");
echo $html->css('thickbox');
echo $scripts_for_layout;
?>
<style type="text/css">
#index-main {
	margin-right:0;
}
</style>
</head>
<body id="yahoo-com" class=" yui-skin-sam">

<div id="index-main"><!--Content Start-->
<?php $session->flash(); ?>
<?php echo $content_for_layout; ?>
</div><!--Content End-->

<?php echo $cakeDebug; ?>
</body>
</html>
