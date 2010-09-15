<div class="memoCategories view">
<p><?php echo $html->link(__('List MemoCategories', true), array('action'=>'index')); ?> </p>
<h2><?php  __('MemoCategory');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('System No.'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $memoCategory['MemoCategory']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Memo Category Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $memoCategory['MemoCategory']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Memo Sections'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $memoCategory['MemoCategory']['memo_sections_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $memoCategory['MemoCategory']['created_user']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $memoCategory['MemoCategory']['updated_user']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $memoCategory['MemoCategory']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $memoCategory['MemoCategory']['updated']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit MemoCategory', true), array('action'=>'edit', $memoCategory['MemoCategory']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete MemoCategory', true), array('action'=>'delete', $memoCategory['MemoCategory']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $memoCategory['MemoCategory']['id'])); ?> </li>
		<li><?php echo $html->link(__('List MemoCategories', true), array('action'=>'index')); ?> </li>
	</ul>
</div>
