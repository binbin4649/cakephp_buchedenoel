<div class="depots index">
<h2><?php __('Depots');?></h2>
<?php
echo $form->create('Depot' ,array('action'=>'index'));
echo $form->text('Depot.word');
echo $form->submit('Seach', array('div'=>false));
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
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('section_id');?></th>
	<th><?php echo $paginator->sort(__('Old Depot No.', true), 'old_system_no');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
</tr>
<?php
$i = 0;
foreach ($depots as $depot):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<input type="text" size="3" value="<?php echo $depot['Depot']['id']; ?>" />
		</td>
		<td>
			<?php echo $html->link($depot['Depot']['name'], array('action'=>'view', $depot['Depot']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($depot['Section']['name'], array('controller'=>'sections', 'action'=>'view', $depot['Depot']['section_id'])); ?>
		</td>
		<td>
			<?php echo $depot['Depot']['old_system_no']; ?>
		</td>
		<td>
			<?php echo $depot['Depot']['updated']; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>