<?php 
foreach($this->viewVars['memoSections'] as $key=>$value):
$category = 'category'.$key;
?>
<div class="memoDatas index">
<h2><?php echo $value; ?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php __('*');?></th>
	<th><?php __('Title');?></th>
	<th><?php __('Category');?></th>
	<th><?php __('top_flag');?></th>
	<th><?php __('created_user');?></th>
	<th><?php __('updated');?></th>
</tr>
<?php
$i = 0;
foreach ($this->viewVars[$category] as $memoData):
?>
	<tr>
		<td>
			<?php echo $memoData['MemoData']['id']; ?>
		</td>
		<td>
			<?php echo $html->link(mb_substr($memoData['MemoData']['name'], 0, 30), array('action'=>'view', $memoData['MemoData']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($memoCategories[$memoData['MemoData']['memo_category_id']], array('action'=>'category_index', $memoData['MemoData']['memo_category_id'])); ?>
		</td>
		<td>
			<?php echo $memoData['MemoData']['top_flag']; ?>
		</td>
		<td>
			<?php echo $memoData['MemoData']['created_user']; ?>
		</td>
		<td>
			<?php echo $memoData['MemoData']['updated']; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link($value.'index', array('action'=>'section_index/'.$key)); ?></li>
		<li><?php echo $html->link(__('New MemoData', true), array('action'=>'add/'.$key)); ?></li>
	</ul>
</div>
<?php endforeach; ?>