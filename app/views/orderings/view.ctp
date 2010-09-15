<div class="orderings view">
<p><?php echo $html->link(__('List Orderings', true), array('action'=>'index')); ?></p>
<h2><?php  __('Ordering');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ordering No.'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ordering['Ordering']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ordering['Ordering']['ordering_status']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ordering Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $type[$ordering['Ordering']['orderings_type']]; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Factory'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ordering['Ordering']['factory_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ordering Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ordering['Ordering']['date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Total'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo number_format($ordering['Ordering']['total']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Dateil Total'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo number_format($ordering['Ordering']['dateil_total']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Total Tax'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo number_format($ordering['Ordering']['total_tax']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Adjustment'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo number_format($ordering['Ordering']['adjustment']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Remarks'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo nl2br($ordering['Ordering']['remark']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('File'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php
			if(!empty($print)){
				echo '<a href="'.$print['url'].'" target="_blank">'.$print['file'].'</a>';
			}
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ordering['Ordering']['created_user'].' : '.$ordering['Ordering']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ordering['Ordering']['updated_user'].' : '.$ordering['Ordering']['updated']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions-sideline">
<ul>
	<li><?php echo $addForm->switchAnchor('orderings/edit/'.$ordering['Ordering']['id'], array(3, 4, 5 ,6), null, 'Edit Ordering', $ordering['Ordering']['status']); ?></li>
	<li><?php echo $addForm->switchAnchor('orderings/add/decision/'.$ordering['Ordering']['id'], array(2, 3, 4, 5 ,6), 'Order to confirm the status updates. Are you sure?', 'Ordering Decision', $ordering['Ordering']['status']); ?></li>
	<li><?php echo $addForm->switchAnchor('orderings/add/print/'.$ordering['Ordering']['id'], array(1, 3, 4, 5, 6), 'Print. Are you sure?', 'Ordering Print', $ordering['Ordering']['status']); ?></li>
	<li><?php echo $addForm->switchAnchor('orderings/add/fax/'.$ordering['Ordering']['id'], array(1, 2, 4, 5, 6), 'FAX sent to update the status. Are you sure?', 'Ordering FAX', $ordering['Ordering']['status']); ?></li>
</ul>

<ul>
	<li><?php echo $addForm->switchAnchor('orderings/add/alteration/'.$ordering['Ordering']['id'], array(1, 5), 'Returns the status. Are you sure?', 'Ordering Alterration', $ordering['Ordering']['status']); ?></li>
	<li><?php echo $addForm->switchAnchor('orderings/add/cancell/'.$ordering['Ordering']['id'], array(6), 'To cancel the order. Are you sure?', 'Ordering Cancell', $ordering['Ordering']['status']); ?></li>
	<li><?php echo $addForm->switchAnchor('purchases/add/buying/'.$ordering['Ordering']['id'], array(1,5,6), null, 'Buying process', $ordering['Ordering']['status']); ?></li>
</ul>
</div>
<div id='datail'>
	<h3><?php __('Ordering Detail');?></h3>
	<?php if (!empty($ordering['OrderingsDetail'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('*'); ?></th>
		<th><?php __('Subitem'); ?></th>
		<th><?php __('Ordering Qty'); ?></th>
		<th><?php __('Stock Qty'); ?></th>
		<th><?php __('sf Date'); ?></th>
		<th><?php __('Order No.'); ?></th>
		<th><?php __('Depot'); ?></th>
		<th><?php __('Created User'); ?></th>
		<th><?php __('Created'); ?></th>
	</tr>
	<?php
		$i = 0;
		$total_ordering = 0;
		$total_stock = 0;
		foreach ($ordering['OrderingsDetail'] as $OrderingsDetail):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
			$total_ordering = $total_ordering + $OrderingsDetail['ordering_quantity'];
			$total_stock = $total_stock + $OrderingsDetail['stock_quantity'];
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $OrderingsDetail['id'];?></td>
			<td>
			<?php echo $addForm->switchAnchor('orderings_details/edit/'.$OrderingsDetail['id'], array(5,6), null, $OrderingsDetail['subitem_name'], $ordering['Ordering']['status']); ?>
			</td>
			<td><?php echo $OrderingsDetail['ordering_quantity'];?></td>
			<td><?php echo $OrderingsDetail['stock_quantity'];?></td>
			<td><?php echo substr($OrderingsDetail['specified_date'], 5, 5);?></td>
			
			<td><?php echo $html->link($OrderingsDetail['order_id'], array('controller'=>'orders', 'action'=>'view/'.$OrderingsDetail['order_id'])); ?></td>

			<td><?php echo $OrderingsDetail['depot_name'].':'.$OrderingsDetail['depot'];?></td>
			<td><?php echo $OrderingsDetail['created_user'];?></td>
			<td><?php echo substr($OrderingsDetail['created'], 5, 5);?></td>
		</tr>
	<?php endforeach; ?>
	<tr><td></td><td>合計</td>
	<td><?php echo $total_ordering; ?></td>
	<td><?php echo $total_stock; ?></td>
	<td></td><td></td><td></td><td></td><td></td></tr>
	</table>
<?php endif; ?>
</div>
<ul>
	<li>状態：保留、1工場に対する追加発注を受け付けます。※未引当自動発注も含まれます。</li>
	<li>状態：確定、追加の発注を受け付けなくなります。修正は可能です。</li>
	<li>確定処理をすると、合計金額、消費税、調整金額が自動計算され、上書きされます。発送日が入っていない場合は当日の日付が入ります。</li>
	<li>合計金額　＝　（明細合計　＋　消費税合計）　＋　調整金額</li>
	<li>消費税の計算が請求単位の場合は、発注の段階で消費税は計算されません。</li>
	<li>工場・仕入先マスタで、消費税計算方法・端数処理が設定されていない場合は、伝票単位・切り捨てで計算されます。</li>
	<li>仕入が行われると発注詳細ではなく仕入詳細にリンクされ、編集は出来なくなります。</li>
</ul>
<ul>
	<li>※注：発注を取消した場合、仕入済み数量や、受注（客注）発注分の数量などは計算されません。または元には戻りません。（例えば、一度仕入れたものが既に売上られていた場合、どこまでデータを戻せばいいのか？判断できないため）</li>
	<li>※注：ステータスを戻すを押すと、状態だけ保留になります。その他は一切変更されません。</li>
</ul>
