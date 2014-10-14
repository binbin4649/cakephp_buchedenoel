<div class="memoDatas view">
<p><?php echo $html->link(__('<<< List Board Index', true), array('action'=>'index')); ?> </p>
<p><?php echo $html->link('<< '.$memoSections[$this->viewVars['memoData']['MemoCategory']['memo_sections_id']].'index', array('action'=>'section_index/'.$this->viewVars['memoData']['MemoCategory']['memo_sections_id'])); ?> </p>
<p><?php echo $html->link('< '.$memoData['MemoCategory']['name'].'index', array('action'=>'category_index/'.$this->viewVars['memoData']['MemoData']['memo_category_id'])); ?> </p>
<?php
if(!empty($this->viewVars['memoData']['MemoData']['reply'])){
	echo '<p>返信元　>>　';
	echo $html->link($FrpmReplyData['MemoData']['name'], array('action'=>'view/'.$this->viewVars['memoData']['MemoData']['reply']));
	echo '</p>';
}
?>
<h2><?php  echo $memoSections[$this->viewVars['memoData']['MemoCategory']['memo_sections_id']].':'.$memoData['MemoCategory']['name'];?></h2>
<h4>Title</h4>
<div class="memodata">
<?php echo $memoData['MemoData']['name']; ?>
</div>
<h4>Contents</h4>
<div class="memodata">
<?php echo nl2br($memoData['MemoData']['contents']); ?>
</div>
<p>&nbsp;</p><p>&nbsp;</p>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('System No.'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $memoData['MemoData']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $memoData['MemoCategory']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Top Flag'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $memoData['MemoData']['top_flag']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('File'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo '<a href="/'.SITE_DIR.'/files/memo/'.$memoData['MemoData']['file'].'" target="_blank">'.$memoData['MemoData']['file'].'</a>'; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $memoData['MemoData']['created_user']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $memoData['MemoData']['updated_user']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $memoData['MemoData']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $memoData['MemoData']['updated']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<?php
		if($this->viewVars['loginUser']['User']['id'] == $created_user or $this->viewVars['loginUser']['User']['username'] == 'admin'){
			echo '<li>';
			echo $html->link(__('Edit MemoData', true), array('action'=>'edit', $memoData['MemoData']['id']));
			echo '</li><li>';
			echo $html->link(__('Delete MemoData', true), array('action'=>'delete', $memoData['MemoData']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $memoData['MemoData']['id']));
			echo '</li>';
		}
		 ?>
		<li><?php echo $html->link(__('Reply MemoData', true), array('action'=>'reply_add/'.$memoData['MemoData']['id'])); ?> </li>
	</ul>
</div>

<div class="memoDatas index">
<h2><?php __('Reply'); ?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php __('*');?></th>
	<th><?php __('Title');?></th>
	<th><?php __('Category');?></th>
	<th><?php __('created_user');?></th>
	<th><?php __('updated');?></th>
</tr>
<?php
$i = 0;
foreach ($replyMemoData as $memo_data):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $memo_data['MemoData']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($memo_data['MemoData']['name'], array('controller'=>'memo_datas', 'action'=>'view', $memo_data['MemoData']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($memoCategories[$memo_data['MemoData']['memo_category_id']], array('controller'=>'memo_datas', 'action'=>'category_index', $memoData['MemoData']['memo_category_id'])); ?>
		</td>
		<td>
			<?php echo $memo_data['MemoData']['created_user']; ?>
		</td>
		<td>
			<?php echo $memo_data['MemoData']['updated']; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>