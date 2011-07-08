<div class="items form">
<?php echo $form->create('Stock',array('type'=>'file','url'=>'csv_add'));?>
	<fieldset>
 		<legend><?php __('CSV Add Stock');?></legend>
		<?php
		echo $form->input('Stock.depot', array(
			'type'=>'text',
			'label'=>'旧倉庫番号',
			'size'=>2
		));
		echo $form->input('Stock.upload_file',array('label'=>'Upload CSV ','type'=>'file'));
		?>

<fieldset style="padding-left:75px;">
<legend>Process Type</legend>
<input type="hidden" name="data[Stock][process_type]" id="StockProcessType_" value="" />
在庫加算<input type="radio" name="data[Stock][process_type]" id="StockProcessTypeA" value="kasan"  />　｜
在庫差替<input type="radio" name="data[Stock][process_type]" id="StockProcessTypeB" value="zaiko"  />　｜
原価差替<input type="radio" name="data[Stock][process_type]" id="StockProcessTypeC" value="genka"  />
</fieldset>
		<?php
		echo $form->end('submit');
		?>
	</fieldset>
</div>

<ul>
	<li>データの容量により、かなり時間がかかる場合があります。気長にお待ち下さい。</li>
	<li>目安：旧倉庫9700の場合、およそ15分くらいかかります。</li>
	<li>旧システムの在庫情報を、新システムに取り込むことができます。</li>
	<li>在庫加算：指定倉庫への在庫をプラス（加算）します。+原価差替</li>
	<li>在庫差替：指定倉庫の在庫を一旦リセットして、新たに在庫をセットします。+原価差替</li>
	<li>原価差替：型番別在庫.CSVの（在庫金額÷在庫数）を、小品番の総平均原価に差替える。</li>
	<li>在庫加算、在庫差替でも原価の差替は行われます。在庫を調整せずに原価だけ指し返したい時に、原価差替をチェックして下さい。</li>
</ul>
<p style="">
【やり方】<br />
旧システムで、在庫管理　→　在庫CSV出力。型番別在庫.CSVを保存する。<br />
在庫加算、在庫差替の場合は、旧倉庫番号を入力して下さい。（富士通システムの倉庫番号のこと）<br />
型番別在庫.CSVを参照する。<br />
プロセスタイプ（Process Type）を選択します。<br />
</p>