<div class="memoDatas index">
<h2><?php __('Board'); ?></h2>
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
foreach ($memoDatas as $memoData):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $memoData['MemoData']['id']; ?>
		</td>
		<td>
			<?php echo $html->link(mb_substr($memoData['MemoData']['name'], 0, 20), array('controller'=>'memo_datas', 'action'=>'view', $memoData['MemoData']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($memoCategories[$memoData['MemoData']['memo_category_id']], array('controller'=>'memo_datas', 'action'=>'category_index', $memoData['MemoData']['memo_category_id'])); ?>
		</td>
		<td>
			<?php echo $memoData['MemoData']['created_user_section']; ?>:
			<?php echo $memoData['MemoData']['created_user']; ?>
		</td>
		<td>
			<?php echo mb_substr($memoData['MemoData']['updated'], 5, 11); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<?php if($addForm->opneUser(open_users(), $opneuser, 'access_authority')): ?>
<h3><?php __('Office Staff Only'); ?></h3>
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
foreach ($onlyDatas as $memoData):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $memoData['MemoData']['id']; ?>
		</td>
		<td>
			<?php echo $html->link(mb_substr($memoData['MemoData']['name'], 0, 20), array('controller'=>'memo_datas', 'action'=>'view', $memoData['MemoData']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($memoCategories[$memoData['MemoData']['memo_category_id']], array('controller'=>'memo_datas', 'action'=>'category_index', $memoData['MemoData']['memo_category_id'])); ?>
		</td>
		<td>
			<?php echo $memoData['MemoData']['created_user_section']; ?>:
			<?php echo $memoData['MemoData']['created_user']; ?>
		</td>
		<td>
			<?php echo mb_substr($memoData['MemoData']['updated'], 5, 11); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
<ul>
	<li><a href="http://e5-os214.xbit.jp/office/zaseki.jpg" target="_blank">事務所座席表（内線番号）</a></li>
	<li><a href="http://e5-os214.xbit.jp/office/tanshuku.jpg" target="_blank">事務所短縮表</a></li>
</ul>
<?php endif; ?>
<ul>
	<li><?php echo $html->link(__('List Board Index', true), array('controller'=>'memo_datas', 'action'=>'index')); ?></li>
	<li><?php echo $html->link(__('About Resort House', true), array('controller'=>'pages', 'action'=>'resorthouse')); ?></li>
</ul>
<ul>
	<li><?php echo $html->link(__('Pentaho', true), array('controller'=>'amount_sections', 'action'=>'pentaho')); ?></li>
	<li><?php echo $html->link(__('Out Put Data', true), array('controller'=>'amount_sections', 'action'=>'outputdata')); ?></li>
</ul>
<ul>
	<li><a href="https://docs.google.com/forms/d/1GCeNGAw5wyGb-8LDurFSESDU22bPNvZ4KIQ2FxwQqCo/viewform?usp=send_form" target="_blank">金額訂正依頼</a></li>
	<li><a href="https://docs.google.com/forms/d/1lSPJggySNLKOZF_6pFGjfjW0ZhNsSZxvQHxDSudQyjI/viewform?usp=send_form" target="_blank">売上日変更依頼</a></li>
</ul>
<ul>
<li><a href="https://idempiere.thekiss-landh.com/webui/" target="_blank">Landh</a></li>
</ul>