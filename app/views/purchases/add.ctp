<a href="javascript:history.back();">戻る</a>
<div class="purchases form">
<?php echo $form->create('Purchase');?>
	<fieldset>
 		<legend><?php __('Add Buying');?></legend>
	<?php

		echo '<div class="input"><label>'.__('Ordering No.', true).'</label>'.$ordering['Ordering']['id'].'　</div>';
		echo $form->hidden('Purchase.ordering_id', array('value'=>$ordering['Ordering']['id']));
		echo '<div class="input"><label>'.__('Factory Name', true).'</label>'.$ordering['Factory']['name'].'　</div>';
		echo $form->hidden('Purchase.factory_id', array('value'=>$ordering['Factory']['id']));
		echo $form->input('Purchase.invoices', array(
			'label'=>__('Invoices No', true),
			'size'=>30
		));
		echo $form->input('Purchase.date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Purchases Date', true),
			'empty'=>'(select)',
			'minYear'=>'2009',
			'maxYear' => MAXYEAR,
			'selected'=>array('year'=>date('Y'), 'month'=>date('m'), 'day'=>date('d'))
		));
		echo $form->input('Purchase.shipping', array(
			'label'=>__('Shipping', true),
			'size'=>5
		));
		echo $form->input('Purchase.adjustment', array(
			'label'=>__('Adjustment', true),
			'size'=>5,
			'value'=>$ordering['Ordering']['adjustment']
		));
		echo $form->input('Purchase.remark', array(
			'label'=>__('Remarks', true),
			'rows'=>6,
			'cols'=>45
		));

		$total_quantity = 0;
		$total_ordering = 0;
		echo '<table class="itemDetail"><tr><th>小品番</th><th>納期</th><th>受注</th><th>倉庫:No</th><th>発注@</th><th>仕入@</th><th>数量</th></tr>';
		foreach($details as $detail){
			$specified_date = substr($detail['OrderingsDetail']['specified_date'], 5, 5);
			//仕入済みと未仕入で表示を分ける
			//仕入済みの場合はその旨表示し、$this->dataに含まれないようにする
			if($detail['OrderingsDetail']['ordering_quantity'] <= $detail['OrderingsDetail']['stock_quantity']){
				echo '<tr><td>'.$detail['Subitem']['name'].'</td><td>'.$specified_date.'</td><td></td>';
				echo '<td></td><td></td>';
				if($detail['OrderingsDetail']['stock_quantity'] == 0){
					echo '<td>取消</td>';
				}else{
					echo '<td>仕入済み</td>';
				}
				echo '<td>'.$detail['OrderingsDetail']['stock_quantity'].'</td></tr>';
			}else{
				$detail_qty = $detail['OrderingsDetail']['ordering_quantity'] - $detail['OrderingsDetail']['stock_quantity'];
				echo '<tr>';
				echo '<td>'.$detail['Subitem']['name'].'</td>';
				echo '<td>'.$specified_date.'</td>';
				echo '<td>'.$detail['OrderingsDetail']['order_id'].'</td>';
				echo '<td>';
				echo $form->input('PurchaseDetail.'.$detail['OrderingsDetail']['id'].'.depot', array(
					'type'=>'select',
					'options'=>$depots,
					'div'=>false,
					'value'=>$detail['OrderingsDetail']['depot'],
					'label'=>false
				));
				echo '</td>';
				echo '<td>'.number_format($detail['OrderingsDetail']['bid']).'</td>';
				echo '<td>';
				echo $form->input('PurchaseDetail.'.$detail['OrderingsDetail']['id'].'.bid', array(
					'type'=>'text',
					'div'=>false,
					'label'=>false,
					'size'=>1,
					'value'=>$detail['OrderingsDetail']['bid']
				));
				echo '</td>';
				echo '<td>';
				echo $form->input('PurchaseDetail.'.$detail['OrderingsDetail']['id'].'.quantity', array(
					'type'=>'text',
					'div'=>false,
					'label'=>false,
					'size'=>1,
					'value'=>$detail_qty
				));
				echo '</td>';
				echo '</tr>';
				$total_quantity = $total_quantity + $detail_qty;
				$total_ordering = $total_ordering + ($detail['OrderingsDetail']['bid'] * $detail_qty);
			}
		}
		echo '<tr><td></td><td></td><td></td><td>合計</td><td>'.number_format($total_ordering).'</td><td></td><td>'.$total_quantity.'</td></tr>';
		echo '</table>';
	?>
	<?php echo $form->end('Submit');?>
	</fieldset>
</div>


<?php //pr($this->viewVars); ?>
<?php //pr($ordering); ?>
<?php //pr($details); ?>
<?php //pr($depots); ?>
