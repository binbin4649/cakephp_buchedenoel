<div class="nationalHolidays view">
<h2><?php  __('NationalHoliday');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $nationalHoliday['NationalHoliday']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $nationalHoliday['NationalHoliday']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $nationalHoliday['NationalHoliday']['date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $nationalHoliday['NationalHoliday']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $nationalHoliday['NationalHoliday']['created_user']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $nationalHoliday['NationalHoliday']['updated']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $nationalHoliday['NationalHoliday']['updated_user']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit NationalHoliday', true), array('action'=>'edit', $nationalHoliday['NationalHoliday']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete NationalHoliday', true), array('action'=>'delete', $nationalHoliday['NationalHoliday']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $nationalHoliday['NationalHoliday']['id'])); ?> </li>
		<li><?php echo $html->link(__('List NationalHolidays', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New NationalHoliday', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
