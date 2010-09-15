<div class="transports view">
<h2><?php  __('Transport View');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $transportStatus[$transport['Transport']['transport_status']]; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Transport No.'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $transport['Transport']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Out Section'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $transport['Transport']['out_section_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Out Depot'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $transport['Transport']['out_depot_name'].':'.$transport['Transport']['out_depot']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('In Section'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $transport['Transport']['in_section_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('In Depot'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $transport['Transport']['in_depot_name'].':'.$transport['Transport']['in_depot']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Delivary Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $transport['Transport']['delivary_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Arrival Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $transport['Transport']['arrival_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Layaway Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php
			if(!empty($transport['Transport']['layaway_type'])){
				echo $layawayType[$transport['Transport']['layaway_type']];
			}
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Layaway User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $transport['Transport']['layaway_user_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Remarks'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo nl2br($transport['Transport']['remark']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $transport['Transport']['created_user'].'　'.$transport['Transport']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $transport['Transport']['updated_user'].'　'.$transport['Transport']['updated']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('File'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php if(!empty($print)) echo '<a href="'.$print['url'].'" target="_blank">'.$print['file'].'</a>'; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php if($transport['Transport']['transport_status'] != 4): ?>
<div class="actions">
	<ul>
		<li><?php echo $addForm->switchAnchor('transports/add/'.$transport['Transport']['id'], array(3, 4), null, 'Transport Edit', $transport['Transport']['transport_status']); ?></li>
		<li><?php echo $addForm->switchAnchor('transports/file_print/'.$transport['Transport']['id'], array(), 'Print OK?', 'Print', $transport['Transport']['transport_status']); ?></li>
		<li><?php echo $addForm->switchAnchor('transports/edit/'.$transport['Transport']['id'], array(3, 4), null, 'Warehousing', $transport['Transport']['transport_status']); ?></li>
		<?php
			if(!empty($transport['Transport']['layaway_type'])){
				echo '<li>';
				echo $addForm->switchAnchor('transports/input_reserve/'.$transport['Transport']['id'], array(2), null, 'Input Reserve', $transport['Transport']['layaway_type']);
				echo '</li>';
			}
		?>
		<li><?php echo $addForm->switchAnchor('transports/cancell/'.$transport['Transport']['id'], array(3, 4), 'Cancell OK?', 'Cancell', $transport['Transport']['transport_status']); ?></li>
	</ul>
</div>
<?php endif; ?>
<?php
	echo '<table class="itemDetail"><tr><th>子品番</th><th>出庫数</th><th>引当数</th><th>入庫数</th><th>受注番号</th></tr>';
	foreach($transport['TransportDateil'] as $dateil){
		echo '<tr>';
		echo '<td>'.$dateil['subitem_name'].'</td>';
		echo '<td>'.$dateil['out_qty'].'</td>';
		echo '<td>'.$dateil['pairing_quantity'].'</td>';
		echo '<td>'.$dateil['in_qty'].'</td>';
		echo '<td>'.$dateil['order_id'].'</td>';
		echo '</tr>';
	}
	echo '</table>';
?>
<ul>
	<li>Cancell：キャンセル（取消）すると未入庫分は出庫倉庫に戻ります。入庫済みの分は戻りません。</li>
</ul>
<?php //pr($transport['Transport']['transport_status']);?>
