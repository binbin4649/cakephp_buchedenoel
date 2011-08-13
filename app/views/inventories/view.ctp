<div class="inventories view">
<h2><?php  __('Inventory');?></h2>
<?php
	if(!empty($csv)){
		echo '<p>';
		echo 'CSVを出力しました。右クリック「～リンク先を保存」を選択してダウンロードして下さい。<br>';
		echo '<a href="'.$csv['url'].'" target="_blank">'.$csv['name'].'</a>';
		echo '</p>';
	}
?>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>>棚卸番号</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $inventory['Inventory']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Section'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $inventory['Section']['name'].':'.$inventory['Inventory']['section_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $status[$inventory['Inventory']['status']]; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Print File'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $inventory['Inventory']['print_file']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $inventory['Inventory']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $inventory['Inventory']['created_user']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $inventory['Inventory']['updated']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $inventory['Inventory']['updated_user']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Inventory Detail', true), array('controller'=>'inventory_details', 'action'=>'index', $inventory['Inventory']['id'])); ?> </li>
		<li><?php 
			if($inventory['Inventory']['status'] == 1){
				echo $html->link(__('Inventory Input', true), array('controller'=>'inventory_details', 'action'=>'add', $inventory['Inventory']['id']));
			}else{
				echo __('Inventory Input', true);
			}
		?></li>
	</ul>
</div>
<h3>倉庫</h3>
<?php echo $form->create('Inventory' ,array('action'=>'view/'.$inventory['Inventory']['id'])); ?>
<table>
<tr>
	<th>CSV</th>
	<th>No</th>
	<th>名前</th>
	<th>帳簿数</th>
	<th>実棚数</th>
	<th>差異</th>
	<th></th>
</tr>
<?php
	$depot_total = 0;
	$real_total = 0;
	$sai_total = 0;
	$messe = 'CSVファイルを出力します。ちょっと時間がかかると思いますので気長にお待ち下さい。';
	foreach($depots['Depot'] as $depot){
		if(empty($depot['inventory'])) $depot['inventory'] = 0;
		if(empty($depot['stock_total'])) $depot['stock_total'] = 0;
		if(empty($depot['name'])) $depot['name'] = '-';
		$sai = $depot['stock_total'] - $depot['inventory'];
		$depot_total = $depot_total + $depot['stock_total'];
		$real_total = $real_total + $depot['inventory'];
		$sai_total = $sai_total + $sai;
		echo '<tr>';
		echo '<td>';
		echo $html->link('Full', array('controller'=>'inventories', 'action'=>'view/'.$inventory['Inventory']['id'].'/'.$depot['id'].'/full'), array(), $messe, true);
		echo ' | ';
		echo $html->link('Diff', array('controller'=>'inventories', 'action'=>'view/'.$inventory['Inventory']['id'].'/'.$depot['id'].'/diff'), array(), $messe, true);
		echo '</td>';
		echo '<td>';
		echo $depot['id'];
		//echo $html->link($depot['id'], array('controller'=>'inventories', 'action'=>'view/'.$inventory['Inventory']['id'].'/'.$depot['id']), array(), $messe, true);
		echo '</td>';
		echo '<td>'.$depot['name'].'</td>';
		echo '<td>'.$depot['stock_total'].'</td>';
		echo '<td>'.$depot['inventory'].'</td>';
		echo '<td>'.$sai.'</td>';
		echo '<td>';
		if($loginUser['User']['username'] == 'admin') echo $form->checkbox('Inventory.'.$depot['id'], array('checked'=>1));
		echo '</td>';
		echo '</tr>';
	}
?>
<tr>
	<td>合計</td>
	<td></td>
	<td><?php echo $depot_total; ?></td>
	<td><?php echo $real_total; ?></td>
	<td><?php echo $sai_total; ?></td>
	<td><?php if($loginUser['User']['username'] == 'admin') echo $form->submit('Submit', array('div'=>false)); ?></td>
</tr>
</table>
<?php echo $form->end(); ?>
<ul>
<li>Full:その倉庫の棚卸状況を全てダウンロードします。正確な過不足を調べる時はFullで出してください。</li>
<li>Diff:帳簿数と実棚数が合っていない品番のみダウンロードします。合計値は、ダウンロードされたデータだけで計算しています。</li>
<li>差異は、（帳簿数　－　実棚数　＝　差異）となっています。実棚数が多ければマイナス表示になります。</li>
<li>当システムは帳簿数をベースに考えて作られています。実棚を正とした場合は逆になります。</li>
<li>棚卸が終わったら、システム管理者までご連絡下さい。棚卸終了の作業を行います。</li>
<li>倉庫単位で、「在庫を入れ替える」、「在庫はそのままにする」が選択可能です。システム管理者にどうするのかを伝えてください。</li>
</ul>