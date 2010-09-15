<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Buche de Noel:<?php echo $title_for_layout; ?></title>
<?php
echo $html->charset("UTF-8");
echo $html->meta('icon');
echo $html->css('css');
echo $html->css("cake.ajax");
echo $scripts_for_layout;
?>

<style type="text/css">
p#compressor {margin-top:0.2em;}
#index-main #promo li {list-style-type:disc; font-size:100%; margin-top:.2em; margin-left:1em;}
#index-main #promo ul {margin:0;}
#index-main #promo .yui-gb .yui-u {width:31%;}
</style>
</head>
<body id="yahoo-com" class=" yui-skin-sam" onLoad="document.form1.input1.focus()">
<div id="doc3" class="yui-t2">


<div id="hd"><!--Header Start-->
<div id="ygunav"><!--Header Step1 Start-->
	<p>
<?php
//var_dump($loginUser);
if($loginUser){
	echo '<em>';
	echo sprintf(__('　Logon:　%s' ,true) ,$html->link($loginUser['User']['section_name'], array('controller'=>'sections', 'action'=>'view/'.$loginUser['User']['section_id'])).' ： '.$html->link($loginUser['User']['name'], array('controller'=>'users', 'action'=>'view/'.$loginUser['User']['id'])));
	echo '　- ';
	echo '　( <a href="/buchedenoel/users/logout">'.__('Logout' ,true).'</a> )';
	echo '</em>';
}
?>
	</p>
</div><!--Header Step1 End-->
<div id="ygma"><?php echo $html->link($html->image('titlle-1.png', array('border'=>'0')), '/', array('escape'=>false));?></div><!--Header Step2 End-->
<div id="pagetitle"><h1><?php echo $title_for_layout; ?></h1></div><!--Header Step3 End-->
</div><!--Header End-->


<div id="bd">

<div id="yui-main">
<div class="yui-b">

<div id="index-secondary"><!--RightMenu Start-->
<?php
	//echo $this->element('right_content1', array('cache'=>1800)); //キャッシュ30
	//echo $this->element('right_content2', array('cache'=>1800));
	//echo $this->element('right_content1', array('cache'=>array('time'=>"+1hours")));
	echo $this->element('right_content1');
	//echo $this->element('right_content2');
?>
</div><!--RightMenu End-->

<div id="index-main"><!--Content Start-->
<?php $session->flash(); ?>
<?php echo $content_for_layout; ?>
</div><!--Content End-->

</div>
</div>
<?php
$page_title = str_replace(' ', '', $title_for_layout);
$page_title = Inflector::underscore($page_title);
//var_dump($this->action);
//exit;
if($this->action == 'display'){
	$selected = 'pages/'.$page_title;
}else{
	$selected = $page_title.'/'.$this->action;
}
echo $this->element('left_menu', array('selected'=>$selected));
?>

<div id="ft">
<p class="first">Hideichi System's | <?php global $TIME_START; echo round(getMicrotime() - $TIME_START, 4)."sec"; ?></p>
<p><a href="">Under construction</a> -
<a href="">Under construction</a></p>
</div>

</div>
</div>
<?php echo $cakeDebug; ?>
</body>
</html>
