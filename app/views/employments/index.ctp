<div class="employments index">
<h2><?php __('Employments');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort(__('*', true),'id');?></th>
	<th><?php echo $paginator->sort(__('Employment Name', true),'name');?></th>
	<th><?php echo $paginator->sort(__('Updated', true),'updated');?></th>
</tr>
<?php
$i = 0;
foreach ($employments as $employment):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $employment['Employment']['id']; ?>
		</td>
		<td>
			<?php
			echo $html->link($employment['Employment']['name'], array('action'=>'view', $employment['Employment']['id']));
			echo '<br>';
			echo $employment['Employment']['name_english'];
			?>
		</td>
		<td>
			<?php echo $employment['Employment']['updated']; ?>
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
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Employment', true), array('action'=>'add')); ?></li>
	</ul>
</div>
