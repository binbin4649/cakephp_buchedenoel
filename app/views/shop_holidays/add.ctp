<div class="shopHolidays form">
<?php echo $form->create('ShopHoliday');?>
	<fieldset>
 		<legend><?php __('Add ShopHoliday');?></legend>
	<?php
		echo $form->input('section_id');
		echo $form->input('date');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List ShopHolidays', true), array('action'=>'index'));?></li>
	</ul>
</div>
<ul>
<li>Date：休業日の日付を半角数字8桁で入力する。（例）2009年12月7日は、20091207と入力する。</li>
</ul>