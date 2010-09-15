<div class="form">
<?php
	if ($session->check('Message.auth')) $session->flash('auth');
	echo $form->create('User', array('action' => 'login'));
	echo $form->input('User.username', array('label'=>__('Login ID', true),));
	echo $form->input('User.password', array('label'=>__('Password', true),));
	echo $form->end('Login');
?>
</div>
