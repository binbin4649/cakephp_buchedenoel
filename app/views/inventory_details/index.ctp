<div class="inventoryDetails index">
<?php
	$inventory_id =  $this->params['pass'][0];
	echo $html->link('棚卸番号:'.$inventory_id.'　へ戻る', array('controller'=>'inventories', 'action'=>'view', $inventory_id));
	echo '　｜　';
	if($inventoryStatus['Inventory']['status'] == 1){
		echo $html->link('棚卸入力', array('controller'=>'inventory_details', 'action'=>'add', $inventory_id));
	}else{
		echo '棚卸入力';
	}
	
?>
<h2>棚卸番号：<?php echo $inventory_id; ?>の、棚卸明細</h2>
<?php
if(!empty($csv)){
	echo '<p>';
	echo '<a href="'.$csv['url'].'" target="_blank">'.$csv['name'].'</a>';
	echo '<br>CSVが出力されました。右クリック「リンク先を保存」を選択して保存してください。</p>';
}
?>
<?php
$modelName = 'InventoryDetail';
echo $form->create($modelName ,array('action'=>'index/'.$inventory_id));
echo __('Depot');
echo $form->text($modelName.'.depot_id', array('type'=>'text','size'=>2,'div'=>false));
echo '　';
echo 'Jan';
echo $form->text($modelName.'.jan', array('type'=>'text','size'=>13,'div'=>false));
echo '　';
echo 'Span';
echo $form->text($modelName.'.span', array('type'=>'text','size'=>2,'div'=>false));
echo '　';
echo 'Face';
echo $form->text($modelName.'.face', array('type'=>'text','size'=>2,'div'=>false));
echo '　';
echo __('Created User');
echo $form->text($modelName.'.created_user', array('type'=>'text','size'=>2,'div'=>false));
echo '　';
echo 'CSV';
echo $form->checkbox($modelName.'.csv');
echo '　';
echo '差のみ';
echo $form->checkbox($modelName.'.csv_diff');
echo '　';
echo $form->submit('Seach', array('div'=>false));

?>
<p>
<div id='datail'>
<a href="javascript:;" onmousedown="if(document.getElementById('in_dateil').style.display == 'none'){ document.getElementById('in_dateil').style.display = 'block'; }else{ document.getElementById('in_dateil').style.display = 'none'; }">
details</a>
<div id="in_dateil" style="display:none">
<p>
検索結果分を全削除
<?php echo $form->checkbox($modelName.'.all_delete'); ?><br>
※チェックを入れてSearchを押すと下に「total：○」と表示されている分、全部削除します。確認画面などは出てきません。<br>
また削除したデータを戻すこともできません。ご注意下さい。
</p>
</div></div>
<?php
echo $form->end();
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo __('Depot');?></th>
	<th><?php echo __('Item Name');?></th>
	<th>Jan Code</th>
	<th>Span</th>
	<th>Face</th>
	<th><?php echo __('Depot Qty');?></th>
	<th><?php echo __('Real Qty');?></th>
	<th><?php echo __('Created');?></th>
	<th><?php echo __('Created User');?></th>
	<th></th>
</tr>
<?php
$depot_total = 0;
$real_total = 0;
foreach ($inventoryDetails as $inventoryDetail):
$depot_total = $depot_total + $inventoryDetail['InventoryDetail']['depot_quantity'];
$real_total = $real_total + $inventoryDetail['InventoryDetail']['qty'];
?>
	<tr>
		<td>
			<?php echo $inventoryDetail['Depot']['name'].':'.$inventoryDetail['Depot']['id']; ?>
		</td>
		<td>
			<?php echo $inventoryDetail['Subitem']['name']; ?>
		</td>
		<td>
			<?php echo $inventoryDetail['Subitem']['jan']; ?>
		</td>
		<td>
			<?php echo $inventoryDetail['InventoryDetail']['span']; ?>
		</td>
		<td>
			<?php echo $inventoryDetail['InventoryDetail']['face']; ?>
		</td>
		<td>
			<?php echo $inventoryDetail['InventoryDetail']['depot_quantity']; ?>
		</td>
		<td>
			<?php echo $inventoryDetail['InventoryDetail']['qty']; ?>
		</td>
		<td>
			<?php echo substr($inventoryDetail['InventoryDetail']['created'], 5, 11); ?>
		</td>
		<td>
			<?php echo $inventoryDetail['InventoryDetail']['created_user']; ?>
		</td>
		<td>
			<?php
			if($inventoryStatus['Inventory']['status'] == 1){
				$detail_id = $inventoryDetail['InventoryDetail']['id'];
				$subitem_name = $inventoryDetail['Subitem']['name'];
				echo $html->link(__('Del', true), array('action'=>'delete', $detail_id), null, sprintf(__('Are you sure you want to delete # %s?', true), $subitem_name));
			}else{
				echo 'Del';
			}
			?>
		</td>
	</tr>
<?php endforeach; ?>
<tr>
	<td colspan="3"><td>
	<td>合計</td>
	<td><?php echo $depot_total; ?></td>
	<td><?php echo $real_total; ?></td>
	<td colspan="2"></td>
</tr>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<ul>
<li>倉庫は倉庫番号、作成者はユーザー番号で検索できます。</li>
<li>CSV出力は、CSVにチェックを入れてSearchボタンを押して下さい。totalに表示されている分のデータが出力されます。</li>
<li>CSV出力の際に「差のみ」にチェックを入れると、帳簿と実棚に差があるものだけがCSV出力されます。</li>
<li>まとめて削除したい場合は、detailsをクリックして、チェックを入れてSearchを押して下さい。</li>
<li>右側のDelを押すと個別に削除できます。</li>
</ul>