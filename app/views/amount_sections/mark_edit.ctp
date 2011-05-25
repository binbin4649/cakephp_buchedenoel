<div class="index">
<h2>部門予算・目標 - <?php echo $section['Section']['name']; ?></h2>
<?php
echo $form->create('AmountSections', array('action'=>'mark_edit/'.$section['Section']['id']));
echo '　';
echo $html->link(__('List Sections', true), array('controller'=>'sections', 'action'=>'index'));
echo '　/　';
echo $html->link($section['Section']['name'].'詳細', array('controller'=>'sections', 'action'=>'view', $section['Section']['id']));
echo '　';
echo $form->input("AmountSections.year", array(
	'type'=>'select',
	'div'=>false,
	'label'=>'Year',
	'options'=>$yearList
));
echo '　';
echo $form->input("AmountSections.month", array(
	'type'=>'select',
	'div'=>false,
	'label'=>'Month',
	'options'=>$monthList
));
echo '　';
echo $form->submit('Seach', array('div'=>false));
echo $form->end();
?>
<br>
<table id="order_by_column_table">
	<thead>
	<tr>
	<th>年月</th>
	<th>日付</th>
	<th>売上金額</th>
	<th>未完金額</th>
	<th>売上加減</th>
	<th>売上予算</th>
	<th>売上目標</th>
	<th>予算達成率</th>
	<th>目標達成率</th>
	</tr>
	</thead>
<tbody>
<?php
echo $form->create('AmountSections', array('action'=>'mark_edit/'.$section['Section']['id']));
foreach($days as $day){
	echo $form->hidden("AmountSections.mark.".$day['day'].".year", array('value'=>$day['year']));
	echo $form->hidden("AmountSections.mark.".$day['day'].".month", array('value'=>$day['month']));
	echo $form->hidden("AmountSections.mark.".$day['day'].".day", array('value'=>$day['day']));
	echo $form->hidden("AmountSections.mark.".$day['day'].".section_id", array('value'=>$day['section_id']));
	echo '<tr id="item-index">';
	echo '<td>'.$day['year'].$day['month'].'</td>';
	echo '<td>'.$day['day'].'</td>';
	echo '<td>'.number_format($day['sales_total']).'</td>';
	echo '<td>'.number_format($day['incomplete_total']).'</td>';
	echo '<td>';
	echo $form->input("AmountSections.mark.".$day['day'].".addsub", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>5,
		'value'=>$day['addsub']
	));
	echo '</td>';
	echo '<td>';
	echo $form->input("AmountSections.mark.".$day['day'].".plan", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>5,
 		'value'=>$day['plan']
	));
	echo '</td>';
	echo '<td>';
	echo $form->input("AmountSections.mark.".$day['day'].".mark", array(
		'type'=>'text',
		'div'=>false,
		'label'=>false,
		'size'=>5,
 		'value'=>$day['mark']
	));
	echo '</td>';	
	echo '<td>'.$day['plan_achieve_rate'].'%</td>';
	echo '<td>'.$day['mark_achieve_rate'].'%</td>';
	echo '</tr>';
}
echo '<tr>';
echo '<td></td>';
echo '<td>合計</td>';
echo '<td>'.number_format($total['month_total']).'</td>';
echo '<td>'.number_format($total['month_incomplete']).'</td>';
echo '<td></td>';
echo '<td>'.number_format($total['month_plan']).'</td>';
echo '<td>'.number_format($total['month_mark']).'</td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
?>
</tbody>
</table>
<input type="submit" value="Submit" />
</div>
<ul>
<li>数字の入力は、半角数字のみ、カンマ抜きです。</li>
<li>売上加減：売上を調整する時に入力する。</li>
<li>売上金額：入力された売上全体の金額</li>
<li>未完金額：お渡しがまだ済んでいない売上の金額</li>
<li>定休日を設定する：予算または目標に、半角シャープ「 # 」を入力して下さい。Submitを押した後に「 休 」と表示されますので確認して下さい。</li>
</ul>