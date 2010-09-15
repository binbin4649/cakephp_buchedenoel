<div class="shopHolidays view">
<h2><?php  __('ShopHoliday');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopHoliday['ShopHoliday']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Section'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($shopHoliday['Section']['name'], array('controller'=> 'sections', 'action'=>'view', $shopHoliday['Section']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopHoliday['ShopHoliday']['date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopHoliday['ShopHoliday']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopHoliday['ShopHoliday']['created_user']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopHoliday['ShopHoliday']['updated']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopHoliday['ShopHoliday']['updated_user']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit ShopHoliday', true), array('action'=>'edit', $shopHoliday['ShopHoliday']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete ShopHoliday', true), array('action'=>'delete', $shopHoliday['ShopHoliday']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $shopHoliday['ShopHoliday']['id'])); ?> </li>
		<li><?php echo $html->link(__('List ShopHolidays', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New ShopHoliday', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Sections', true), array('controller'=> 'sections', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Section', true), array('controller'=> 'sections', 'action'=>'add')); ?> </li>
	</ul>
</div>
