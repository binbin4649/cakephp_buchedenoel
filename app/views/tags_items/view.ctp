<div class="tagsItems view">
<h2><?php  __('TagsItem');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tagsItem['TagsItem']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Item Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tagsItem['TagsItem']['item_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tag Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tagsItem['TagsItem']['tag_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tagsItem['TagsItem']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tagsItem['TagsItem']['created_user']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit TagsItem', true), array('action'=>'edit', $tagsItem['TagsItem']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete TagsItem', true), array('action'=>'delete', $tagsItem['TagsItem']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tagsItem['TagsItem']['id'])); ?> </li>
		<li><?php echo $html->link(__('List TagsItems', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New TagsItem', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
