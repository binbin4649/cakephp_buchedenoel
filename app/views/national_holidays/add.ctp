<div class="nationalHolidays form">
<?php echo $form->create('NationalHoliday');?>
	<fieldset>
 		<legend><?php __('Add NationalHoliday');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('date');
		echo $form->input('section_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List NationalHolidays', true), array('action'=>'index'));?></li>
	</ul>
</div>
<ul>
<li>Name：休日の名前。（例）春分の日とか。</li>
<li>Date：半角数字8桁で入力。（例）2009年01月11日なら20090111。</li>
<li>部門：部門ID（半角数字）を入力。海外店舗など特定の店舗にだけ適用したい時に入力する。通常は入力しない。</li>
</ul>