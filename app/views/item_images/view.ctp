<div class="itemImages view">
<h2><?php  __('ItemImage');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $itemImage['ItemImage']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $itemImage['ItemImage']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Item'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($itemImage['Item']['name'], array('controller'=> 'items', 'action'=>'view', $itemImage['Item']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $itemImage['ItemImage']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $itemImage['ItemImage']['created_user']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit ItemImage', true), array('action'=>'edit', $itemImage['ItemImage']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete ItemImage', true), array('action'=>'delete', $itemImage['ItemImage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $itemImage['ItemImage']['id'])); ?> </li>
		<li><?php echo $html->link(__('List ItemImages', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New ItemImage', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Items', true), array('controller'=> 'items', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Item', true), array('controller'=> 'items', 'action'=>'add')); ?> </li>
	</ul>
</div>
