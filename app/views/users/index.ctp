<div class="users index">
<h2><?php __('List Users');?></h2>
<?php
if(!empty($csv)){
	echo '<p>';
	echo '<a href="'.$csv['url'].'" target="_blank">'.$csv['name'].'</a>';
	echo '<br>CSVが出力されました。右クリック「リンク先を保存」を選択して保存してください。</p>';
}
?>
<?php
echo $form->create('User' ,array('action'=>'index'));
echo '名前検索';
echo $form->text('User.word', array('size'=>7));
echo '　';
echo $form->input('User.section_id', array(
	'type'=>'select',
	'label'=>false,
	'div'=>false,
	'options'=>$sections,
	'empty'=>'select',
));
echo '　';
echo $form->input('User.post_id', array(
	'type'=>'select',
	'label'=>false,
	'div'=>false,
	'options'=>$posts,
	'empty'=>'select',
));
echo '　';
echo $form->input('User.employment_id', array(
	'type'=>'select',
	'label'=>false,
	'div'=>false,
	'options'=>$employments,
	'empty'=>'select',
));
echo '　';
echo $form->submit('Seach', array('div'=>false));
if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
	echo '<br>';
	echo $form->checkbox('User.duty_code');
	echo '退職者を含む　　';
	echo $form->checkbox('User.csv');
	echo 'CSV出力';
}
echo $form->hidden('User.start', array('value'=>'1'));
echo $form->end();
?>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort(__('*', true),'id');?></th>
	<th><?php echo $paginator->sort(__('Users Name', true),'name');?></th>
	<th><?php echo $paginator->sort(__('Section', true),'section_id');?></th>
	<th><?php echo $paginator->sort(__('Post', true),'post_id');?></th>
	<th><?php echo $paginator->sort(__('Employment', true),'employment_id');?></th>
	<th><?php echo $paginator->sort(__('Updated', true),'updated');?></th>
</tr>
<?php
$i = 0;
foreach ($users as $user):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $user['User']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($user['User']['name'], array('action'=>'view', $user['User']['id']));
				  echo '<br>';
				  echo $user['User']['name_english'];
			?>
		</td>
		<td>
			<?php echo $html->link($user['Section']['name'], array('controller'=> 'sections', 'action'=>'view', $user['Section']['id'])); ?>
		</td>
		<td>
			<?php echo $user['Post']['name']; ?>
		</td>
		<td>
			<?php echo $user['Employment']['name']; ?>
		</td>
		<td>
			<?php echo $user['User']['updated']; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< previous', array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next('next >>', array(), null, array('class'=>'disabled'));?>
</div>