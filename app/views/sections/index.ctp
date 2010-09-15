<div class="sections index">
<h2><?php __('List Sections');?></h2>
<?php
if(!empty($ehStore)){
	echo '<p>';
	echo '<a href="'.$ehStore['url'].'" target="_blank">'.$ehStore['name'].'</a>';
	echo '<br>e飛伝データ一括出力(営業部門（店舗)が出力されています。右クリック「名前を付けてリンク先を保存」を選択して保存してください。</p>';
}
?>
<p>
<?php
$paginator->options(array('url' => $this->passedArgs));
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
echo '　｜　';
echo $html->link(__('Sales(Shops)',true), array('action'=>'index', 1));
echo '　｜　';
echo $html->link(__('Sales(Not Shops)',true), array('action'=>'index', 2));
echo '　｜　';
echo $html->link(__('Non-business sector',true), array('action'=>'index', 3));
echo '　｜　';
echo $html->link(__('Close sector',true), array('action'=>'index', 4));
echo '　｜　';
echo $html->link('ALL', array('action'=>'index'));
?>

</p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort(__('*', true),'id');?></th>
	<th><?php echo $paginator->sort(__('Section Name', true),'name');?></th>
	<th><?php echo $paginator->sort(__('kuwake', true),'sales_code');?></th>
	<th><?php echo $paginator->sort(__('Section Code', true),'kanjo_bugyo_code');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
</tr>
<?php
$i = 0;
$sales_code = get_sales_code();
foreach ($sections as $section):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php 
			echo $html->link($section['Section']['id'], array('action'=>'view', $section['Section']['id']));
			?>
		</td>
		<td>
			<?php
			echo $html->link($section['Section']['name'], array('controller'=>'amount_sections', 'action'=>'mark', $section['Section']['id']));
			echo '<br>';
			echo $section['Section']['name_english'];
			?>
		</td>
		<td>
			<?php
			if(!empty($section['Section']['sales_code']))echo $sales_code[$section['Section']['sales_code']];
			?>
		</td>
		<td>
			<?php echo $section['Section']['kanjo_bugyo_code']; ?>
		</td>
		<td>
			<?php echo $section['Section']['updated']; ?>
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
<?php if($addForm->opneUser(open_users(), $opneuser, 'access_authority')):?>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Section', true), array('action'=>'add')); ?></li>
		<li><?php echo $addForm->switchAnchor('sections/eh_store', array(), 'Sagawa store bulk e secret CSV output. Are you sure?', 'Stores e-hiden', null); ?></li>
	</ul>
	<ul>
		<li>Stores e-hiden：区分けが営業部門（店舗）の佐川e秘伝用のＣＳＶを一括出力します。ただし都道府県が「その他」になっている店舗は出力されません。</li>
	</ul>
</div>
<?php endif; ?>