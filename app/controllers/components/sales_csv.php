<?php
class SalesCsvComponent extends Object {
	
	//直営店の売上実績
	//./cake prepare importSales -app /var/www/html/buchedenoel/app
	function dairyReport(){
		App::import('Model', 'AmountSection');
    	$AmountSectionModel = new AmountSection();
		App::import('Model', 'Section');
    	$SectionModel = new Section();
    	App::import('Component', 'DateCal');
   		$DateCalComponent = new DateCalComponent();
   		App::import('Component', 'Total');
   		$TotalComponent = new TotalComponent();
   		$year = date('Y');
   		$month = date('m');
   		$day = date('d');
		//////////////////////////////////////////////テストデータ
    	//$year = '2011';
   		//$month = '03';
   		//$day = '15';
   		
   		//昨年の売上に含める店舗、つまり既存店のリストを作成
		$prev_days_total = 0; //既存店同日前期実績、同日までの合計、既存店＝1年以上前から売上がある店舗
		$prev_existing_total = 0; //既存店同月昨年実績、ひと月合計
		$this_existing_total = 0; //既存店同月今年実績
		$prev_all_total = 0; //全店同日前期実績 
		$this_all_total = 0; //全店同日今期実績
		$prev_all_month_total = 0;//全店同月前期実績
   		$full_sections = $SectionModel->amountSectionList4();// 営業開始日と終了日だけでsectionsを出力。つまりこの二つのうち何れかが入っている部門は、集計対象となる。 全店合計を出す時用。
   		$exis_sections = $SectionModel->amountSectionList3(); //既存店一覧を返す
   		foreach($exis_sections as $section_id=>$section_name){//既存店
   		 	$this_value = $AmountSectionModel->markIndex($section_id, $year, $month);
   		 	$prev_value = $AmountSectionModel->markIndex($section_id, $year -1, $month);
   		 	$prev_existing_total = $prev_existing_total + $prev_value['month_total'];
   		 	$this_existing_total = $this_existing_total + $this_value['month_total'];
   		 	for($i=1; $i <= $day; $i++){
   				foreach($prev_value['days'] as $days){
   					if($days['day'] == $i){
   						$prev_days_total = $prev_days_total + $days['sales_total'];
   					}
   				}
   			}
   		}
   		foreach($full_sections as $section_id=>$section_name){//全店
   			$this_value = $AmountSectionModel->markIndex($section_id, $year, $month);
   		 	$prev_value = $AmountSectionModel->markIndex($section_id, $year -1, $month);
   		 	$prev_all_month_total = $prev_all_month_total + $prev_value['month_total'];
   		 	$this_all_total = $this_all_total + $this_value['month_total'];
   		 	for($i=1; $i <= $day; $i++){
   				foreach($prev_value['days'] as $days){
   					if($days['day'] == $i){
   						$prev_all_total = $prev_all_total + $days['sales_total'];
   					}
   				}
   			}
   		}
   		
   		$summary1 = array(
   			'既存店同日昨年実績',
   			$prev_days_total,
   			'既存店同月昨年実績',
   			$prev_existing_total,
   			'全店同日昨年実績',
   			$prev_all_total,
   			'全店同月昨年実績',
   			$prev_all_month_total
   		);
   		$summary2 = array(
   			'既存店同日今年実績',
   			$this_existing_total,
   			'既存店同月今年実績',
   			$this_existing_total,
   			'全店同日今年実績',
   			$this_all_total,
   			'全店同月今年実績',
   			$this_all_total
   		);
   		$days_total_comp = $TotalComponent->fprate2($this_existing_total, $prev_days_total);//既存店同日対比
   		$existing_total_comp = $TotalComponent->fprate2($this_existing_total, $prev_existing_total);//既存店同月対比
   		$all_total_comp = $TotalComponent->fprate2($this_all_total, $prev_all_total);//全店同日対比
   		$all_month_total_comp = $TotalComponent->fprate2($this_all_total, $prev_all_month_total);//全店同月対比
   		$summary3 = array(
   			'既存店同日対比',
   			$days_total_comp,
   			'既存店同月対比',
   			$existing_total_comp,
   			'全店同日対比',
   			$all_total_comp,
   			'全店同月対比',
   			$all_month_total_comp
   		);
   		
   		//////////////////////////////////////////////
   		$prev_date = $DateCalComponent->prev_month($year, $month);
   		$prev_month = $prev_date['month'];
   		$thisTerm = $DateCalComponent->this_term($year, $month);
   		$outReport = array(); //色々配列にして格納
		$sections = $SectionModel->amountSectionList(); //集計対象の部門一覧を返す
		
		$sections_counter = count($sections); //対象の部門数
		///////////////////////////////////////////////集計の部
		foreach($sections as $section_id=>$section_name){
			$outReport[$section_id]['section_name'] = $section_name;
			$outReport[$section_id]['this_month'] = $AmountSectionModel->markIndex($section_id, $year, $month); //今月
			$outReport[$section_id]['prev_month'] = $AmountSectionModel->markIndex($section_id, $year, $prev_month); //前月
			foreach($thisTerm as $term_year => $values){
				foreach($values as $term_month){
					$outReport[$section_id]['this_term'][$term_month] = $AmountSectionModel->markIndex($section_id, $term_year, $term_month); //今期を月毎に
					$outReport[$section_id]['prev_term'][$term_month] = $AmountSectionModel->markIndex($section_id, $term_year -1, $term_month); //前期を月毎に
				}
			}
		}
		/////////////////////////////////////////////出力用配列作成の部
		$line = array(); //配列一つに対して、出力1行
		$line[] = $year.'年'.$month.'月'.$day.'日集計 販売実績';
		$line[] = ','.implode(',',$sections).',合計';
		
		for($i=1; $i<=31; $i++){
			$value = array(); // 各店の日割り売上
			$amont = 0; //日割り合計
			foreach($sections as $section_id=>$section_name){
				$section_amount = 0; //部門別合計
				foreach($outReport[$section_id]['this_month']['days'] as $days){
					if($days['day'] == $i){
						$value[] = $days['sales_total'];
						$amont = $amont + $days['sales_total'];
						$youbi = $days['youbi'];
					}
				}
			}
			$line[] = $i.'('.$youbi.'),'.implode(',',$value).','.$amont;
		}
		
		$section_total = array(); //部門番号=>当月合計
		$days_total = 0; //当月全店合計
		$prev_section_month = array(); //部門別 昨年同月実績
		$prev_month_total = 0; //昨年同月実績 合計
		$section_month_cont = array(); //部門別 昨対%
		$section_month_mark = array(); //部門別 今月目標
		$month_mark_total = 0; //目標金額合計
		$section_mark_cont = array(); //部門別 達成率
		$this_term = array(); //今期実績
		$term_section_total = array(); //部門別 今期の合計
		$term_all_total = 0; //今期総合計
		$section_mark_term = array(); // 部門別 今期の目標合計
		$section_mark_rate = array(); // 部門別 今期の目標達成率
		$section_mark_term_total = 0; // 今期 目標総合計
		$section_mark_total_rate = 0; //今期の目標 総合計達成率
		$section_mark_exp = array(); //部門別目標見込
		$all_mark_exp = 0; //全店合計 目標見込の合計
		$all_mark_exp_avg = 0; //全店合計 目標見込の平均
		$passd_term_arr = $DateCalComponent->this_passd_term_arr($month);
		$prev_sction_total = array(); // 部門別 昨年同日実績合計
		$prev_section_comp = array(); // 部門別 昨年対比
		$prev_total = 0; //昨年実績 全店合計
		$section_comp_profit = array(); //部門別 昨年差益 今期-前期
		$all_comp_profit = 0; //総合計 昨年差益 今期-前期
		$section_comp_exp = array(); //部門別 昨対見込
		$all_comp_exp = 0; //総合計 昨対見込
		$section_exp_avg = array(); //部門別 平均見込
		
		foreach($sections as $section_id=>$section_name){
			$this_month_total = $outReport[$section_id]['this_month']['month_total']; //当月合計
			$section_total[$section_id] = $this_month_total;
			$days_total = $days_total + $this_month_total;
			$prev_term_month_total = $outReport[$section_id]['prev_term'][$month]['month_total']; //前年同月合計
			$prev_section_month[$section_id] = $prev_term_month_total;
			$prev_month_total = $prev_month_total + $prev_term_month_total;
			$section_month_cont[$section_id] = $TotalComponent->fprate2($this_month_total, $prev_term_month_total);
			$this_month_mark = $outReport[$section_id]['this_month']['month_mark'];
			$section_month_mark[$section_id] = $this_month_mark;
			$month_mark_total = $month_mark_total + $this_month_mark;
			$section_mark_cont[$section_id] = $TotalComponent->fprate2($this_month_total, $this_month_mark);
			$term_section_sub = 0; //部門別 今期の合計 仮入れ
			$mark_section_sub = 0; //部門別 今期の目標合計 仮入れ
			foreach($outReport[$section_id]['this_term'] as $term_month=>$term_days){
				$this_term[$term_month][] = $term_days['month_total'];
				$term_section_sub = $term_section_sub + $term_days['month_total'];
				$mark_section_sub = $mark_section_sub + $term_days['month_mark'];
			}
			$prev_total_passd = 0; //昨年実績 仮入れ 、これが昨年 [同日] 実績になる
			/* //昨年実績が、昨年の月単位の実績と勘違いしてて使っていたもの
			foreach($passd_term_arr as $passd_month){
				$prev_total_passd = $prev_total_passd + $outReport[$section_id]['prev_term'][$passd_month]['month_total'];
			}
			*/
			for($i=1; $i <= $day; $i++){
				foreach($outReport[$section_id]['prev_term'][$month]['days'] as $days ){
					if($days['day'] == $i){
						$prev_total_passd = $prev_total_passd + $days['sales_total'];
					}
				}
			}
			
			$prev_total = $prev_total + $prev_total_passd;
			$prev_sction_total[$section_id] = $prev_total_passd;
			$prev_section_comp[$section_id] = $TotalComponent->fprate2($term_section_sub , $prev_total_passd);
			$term_section_total[$section_id] = $term_section_sub;
			$term_all_total = $term_all_total + $term_section_sub;
			$section_mark_term[$section_id] = $mark_section_sub;
			$section_mark_term_total = $section_mark_term_total + $mark_section_sub;
			$this_section_mark_rate = $TotalComponent->fprate2($term_section_sub, $mark_section_sub);
			$section_mark_rate[$section_id] = $this_section_mark_rate;
			$this_section_mark_exp = floor($this_month_mark * ($this_section_mark_rate / 100));
			$section_mark_exp[$section_id] = $this_section_mark_exp; //部門別目標見込
			$all_mark_exp = $all_mark_exp + $this_section_mark_exp;
			$section_comp_profit[$section_id] = $term_section_sub - $prev_total_passd;
			$this_section_mark_exp = floor($this_month_mark * ($prev_section_comp[$section_id] / 100));
			$section_comp_exp[$section_id] = $this_section_mark_exp; //部門別昨対見込
			$all_comp_exp = $all_comp_exp + $this_section_mark_exp;
			$section_exp_avg[$section_id] = floor(($this_section_mark_exp + $this_section_mark_exp) / 2);
		}
		$all_comp_profit = $term_all_total - $prev_total;
		$all_mark_exp_avg = floor($all_mark_exp / $sections_counter);
		$section_mark_total_rate = $TotalComponent->fprate2($term_all_total, $section_mark_term_total);
		$prev_section_comp_avg = $TotalComponent->fprate2($term_all_total, $prev_total);
		foreach($this_term as $line_month=>$line_array){
			$term_month_sub = 0; //月別 今期の合計 仮入れ
			foreach($line_array as $line_arr){
				$term_month_sub = $term_month_sub + $line_arr;
			}
			$this_term[$line_month][] = $term_month_sub;
		}
		$term_section_avg = array(); //部門別 月平均額
		$passd_month = $DateCalComponent->this_passd_term($month);
		foreach($term_section_total as $section_id=>$val){
			$term_section_avg[$section_id] = floor($val / $passd_month);
		}
		$term_total_avg = floor(($term_all_total / $sections_counter) / $passd_month);
		
		$line[] = '合計,'.implode(',', $section_total).','.$days_total;
		$days_section_ranking = $TotalComponent->not_chang_rank($section_total);
		$line[] = '順位,'.implode(',', $days_section_ranking);
		$line[] = ',';
		$line[] = '昨年実績,'.implode(',', $prev_section_month).','.$prev_month_total;
		$line[] = '今年実績,'.implode(',', $section_total).','.$days_total;
		$section_cont_avg = $TotalComponent->fprate2($days_total, $prev_month_total);
		$line[] = '昨対%,'.implode(',', $section_month_cont).','.$section_cont_avg;
		$section_cont_ranking = $TotalComponent->not_chang_rank($section_month_cont);
		$line[] = '順位,'.implode(',', $section_cont_ranking);
		$line[] = ',';
		$line[] = '目標,'.implode(',', $section_month_mark).','.$month_mark_total;
		$mark_cont_avg = $TotalComponent->fprate2($days_total, $month_mark_total);
		$line[] = '達成率,'.implode(',', $section_mark_cont).','.$mark_cont_avg;
		$line[] = ',';
		$line[] = '月別,'.implode(',',$sections).',合計';
		foreach($this_term as $line_month=>$line_array){
			$line[] = $line_month.'月,'.implode(',', $line_array);
		}
		$line[] = '合計,'.implode(',', $term_section_total).','.$term_all_total;
		$term_section_ranking = $TotalComponent->not_chang_rank($term_section_total);
		$line[] = '順位,'.implode(',', $term_section_ranking);
		$line[] = ',';
		$line[] = '月平均高,'.implode(',', $term_section_avg).','.$term_total_avg;
		$section_avg_ranking = $TotalComponent->not_chang_rank($term_section_avg);
		$line[] = '順位,'.implode(',', $section_avg_ranking);
		$line[] = ',';
		$line[] = '目標%,'.implode(',', $section_mark_rate).','.$section_mark_term_total;
		$line[] = '目標見込,'.implode(',', $section_mark_exp).','.$all_mark_exp_avg;
		$line[] = '昨対%,'.implode(',', $prev_section_comp).','.$prev_section_comp_avg;
		$line[] = '昨対差益,'.implode(',', $section_comp_profit).','.$all_comp_profit;
		$line[] = '昨対見込,'.implode(',', $section_comp_exp).','.$all_comp_exp;
		$line[] = '昨年実績,'.implode(',', $prev_sction_total).','.$prev_total;
		$all_exp_avg = floor(($all_mark_exp_avg + $all_comp_exp) / 2);
		$line[] = '平均見込,'.implode(',', $section_exp_avg).','.$all_exp_avg;
		$line[] = ',';
		$line[] = ',';
		$line[] = ',';
		$line[] = implode(',', $summary1);
		$line[] = implode(',', $summary2);
		$line[] = implode(',', $summary3);
		
		/////////////////////////////////////////出力用文字列の部
		$out = '';
		foreach($line as $li){
			$out .= $li."\r\n";
		}
		////////////////////////////////////////出力部
		$file_name = 'store_sales'.date('Ymd-His').'.csv';
		$path = WWW_ROOT.'/files/store_sales/';
		$output_csv = mb_convert_encoding($out, 'SJIS', 'UTF-8');
		file_put_contents($path.$file_name, $output_csv);
	}
	
	
	
	
	//部門別売上集計してCSV出力
	//とりあえず直営店だけ
	function storeSales(){
		App::import('Model', 'AmountSection');
    	$AmountSectionModel = new AmountSection();
		App::import('Model', 'Section');
    	$SectionModel = new Section();
    	App::import('Component', 'DateCal');
   		$DateCalComponent = new DateCalComponent();
   		App::import('Component', 'Total');
   		$TotalComponent = new TotalComponent();
   		
   		$year = date('Y');
   		$month = date('m');
   		$day = date('d');
   		//////////////////////////////////////////////テストデータ
    	$year = '2010';
   		$month = '12';
   		$day = '31';
   		
   		//////////////////////////////////////////////
   		
    	$days = $DateCalComponent->last_day($year, $month);
    	$d = 1;
    	//はじめ//////////////////////////////////////売上金額
    	$rankings = array();
    	$out = '直営店売上集計,'.$year.'年'.$month.'月'.$day.'日'."\r\n";
    	$out .= '部門,';
    	while($days >= $d){
    		$out .= $d.'日,';
    		$d++;
    	}
		$out .= '店別合計'."\r\n";
		$sections = $SectionModel->amountSectionList(); //集計対象の部門一覧を返す
		$total = array();
		$all_total = 0;
		$prev_ranking = array();
		$prevComparison = array();
		$today_total = 0;
		$prev_today = 0;
		$prev_year = $year -1;
		$sectionMark = array();
		foreach($sections as $section_id=>$section_name){
			$section_total = 0;
			$section_mark_total = 0;
			$i = array();
			$amounts = $AmountSectionModel->markIndex($section_id, $year, $month);
			$prev_amounts = $AmountSectionModel->markIndex($section_id, $prev_year, $month); //昨年同月
			$prevComparison[$section_id]['this_total'] = $amounts['month_total'];
			$prevComparison[$section_id]['last_year_total'] = $prev_amounts['month_total'];
			$prevComparison[$section_id]['comparison_avg'] = $TotalComponent->fprate2($amounts['month_total'], $prev_amounts['month_total']);
			$prev_ranking[$section_id] = $prevComparison[$section_id]['comparison_avg'];
			foreach($prev_amounts['days'] as $prev_days){
				if($prev_days['day'] == $day){
					$prev_today = $prev_today + $prev_days['sales_total'];
					break;
				} 
			}
			foreach($amounts['days'] as $days){
				if($days['day'] == $day){
					$today_total = $today_total + $days['sales_total'];
				}
				@$total[$days['day']] = $total[$days['day']] + $days['sales_total'];
				$i[] = $days['sales_total'];
				$section_total = $section_total + $days['sales_total'];
				$all_total = $all_total + $days['sales_total'];
				$section_mark_total = $section_mark_total + $days['mark'];
			}
			$sectionMark[$section_id]['name'] = $section_name;
			$sectionMark[$section_id]['mark_total'] = $section_mark_total;
			$out .= $section_name.',';
			$out .= implode(',', $i);
			$out .= ','.$section_total."\r\n";
			//$out .= ','.$amounts['month_total']."\r\n";
			$rankings[$section_id] = $section_total;
		}
		
		
		$out .= '日計,';
		$out .= implode(',', $total);
		$out .= ','.$all_total."\r\n";
		$out .= "\r\n";
		//////////////////////////////////////////月売上金額ランキング
		$out .= '売上順位,';
		$out .= "\r\n";
		arsort($rankings);
		$out .= '部門,';
		foreach($rankings as $section_id=>$ranking){
			$out .= $sections[$section_id].',';
		}
		$out .= "\r\n";
		$out .= '金額,';
		foreach($rankings as $section_id=>$ranking){
			$out .= $ranking.',';
		}
		$out .= "\r\n";
		$out .= '順位,';
		$rank = 1;
		foreach($rankings as $section_id=>$ranking){
			$out .= $rank.',';
			$rank++;
		}
		/////////////////////////////////////////月昨対＆達成率ランキング
		$out .= "\r\n";
		$out .= '昨対順位,';
		$out .= "\r\n";
		$out .= '部門,';
		$all_prev_comparison = 0;
		arsort($prev_ranking);
		foreach($prev_ranking as $section_id=>$comparison_avg){
			$out .= $sections[$section_id].',';
		}
		$out .= "\r\n";
		$out .= '昨月実績,';
		foreach($prev_ranking as $section_id=>$comparison_avg){
			$out .= $prevComparison[$section_id]['last_year_total'].',';
		}
		$out .= "\r\n";
		$out .= '今月実績,';
		foreach($prev_ranking as $section_id=>$comparison_avg){
			$out .= $prevComparison[$section_id]['this_total'].',';
		}
		$out .= "\r\n";
		$out .= '昨対%,';
		foreach($prev_ranking as $section_id=>$comparison_avg){
			$out .= $comparison_avg.',';
		}
		$out .= "\r\n";
		$out .= '順位,';
		$rank = 1;
		foreach($prev_ranking as $section_id=>$comparison_avg){
			$out .= $rank.',';
			$rank++;
		}
		$out .= "\r\n";
		//////////////////////////////////////////今月の目標合計と達成率ランキング
		$mark_list = array();
		foreach($sectionMark as $id_mark => $mark_value){
			$sectionMark[$id_mark]['mark_rate'] = $TotalComponent->fprate2($mark_value['mark_total'], $rankings[$id_mark]);
			$mark_list[$id_mark] = $sectionMark[$id_mark]['mark_rate'];
		}
		arsort($mark_list);
		$out .= '目標順位,';
		$out .= "\r\n";
		$out .= '部門,';
		foreach($mark_list as $section_id=>$value){
			$out .= $sectionMark[$section_id]['name'].',';
		}
		$out .= "\r\n";
		$out .= '目標金額,';
		foreach($mark_list as $section_id=>$value){
			$out .= $sectionMark[$section_id]['mark_total'].',';
		}
		$out .= "\r\n";
		$out .= '実績金額,';
		foreach($mark_list as $section_id=>$value){
			$out .= $prevComparison[$section_id]['this_total'].',';
		}
		$out .= "\r\n";
		$out .= '達成%,';
		foreach($mark_list as $section_id=>$value){
			$out .= $value.',';
		}
		$out .= "\r\n";
		$out .= '順位,';
		$rank = 1;
		foreach($mark_list as $section_id=>$value){
			$out .= $rank.',';
			$rank++;
		}
		
		$out .= "\r\n";
		$out .= "\r\n";
		//////////////////////////////////////////今期実績
		$out .= '今期実績,';
		$thisTerm = $DateCalComponent->this_term($year, $month);
   		foreach($thisTerm as $term_year => $values){
   			foreach($values as $value){
   				$out .= $value.'月,';
   				$value_month[$value] = 0; // notice が出るので追加したけど、意味無いかも
   			}
   		}
   		$out .= '合計';
   		$out .= "\r\n";
   		$all_total = 0;
   		$value_month = array(); //今期の月合計を出す
   		$value_mark = array(); //今期の月目標をいろいろ入れる配列
   		$mark_list = array(); //今期の月目標の達成率をソートする配列
   		$total_list = array(); //今期の売上ソート用
   		foreach($sections as $section_id=>$section_name){
   			$out .= $section_name.',';
   			$section_total = 0; //部門別、今期の売上合計
   			$mark_total = 0; //部門別、今期の月目標合計
			foreach($thisTerm as $term_year => $values){
				foreach($values as $term_month){
					$this_term_amount = $AmountSectionModel->markIndex($section_id, $term_year, $term_month);
					$out .= $this_term_amount['month_total'].',';
					$section_total = $section_total + $this_term_amount['month_total'];
					@$value_month[$term_month] = $value_month[$term_month] + $this_term_amount['month_total'];
					$mark_total = $mark_total + $this_term_amount['month_mark'];
				}
			}
			$value_mark[$section_id]['mark_total'] = $mark_total;
			$value_mark[$section_id]['mark_month_rate'] = $TotalComponent->fprate2($section_total, $mark_total);
			$mark_list[$section_id] = $value_mark[$section_id]['mark_month_rate'];
			$total_list[$section_id] = $section_total;
			$all_total = $all_total + $section_total;
			$out .= $section_total.',';
			$out .= "\r\n";
   		}
   		$out .= '合計,';
		$out .= implode(',', $value_month);
		$out .= ','.$all_total;
		$out .= "\r\n";
		$out .= "\r\n";
		
		//////////////////////////////////////////月売上金額ランキング
		$out .= '今期売順,';
		$out .= "\r\n";
		$out .= '部門,';
		arsort($total_list);
		foreach($total_list as $section_id=>$term_month){
			$out .= $sections[$section_id].',';
		}
		$out .= "\r\n";
		$out .= '売上金額,';
		foreach($total_list as $section_id=>$term_month){
			$out .= $term_month.',';
		}
		$out .= "\r\n";
		$out .= '順位,';
		$rank = 1;
		foreach($total_list as $section_id=>$term_month){
			$out .= $rank.',';
			$rank++;
		}
		$out .= "\r\n";
		
		////////////////////////////////////////今期達成率ランキング
		$out .= '今期達成,';
		$out .= "\r\n";
		$out .= '部門,';
		arsort($mark_list);
		foreach($mark_list as $section_id=>$term_mark){
			$out .= $sections[$section_id].',';
		}
		$out .= "\r\n";
		$out .= '目標金額,';
		foreach($mark_list as $section_id=>$term_mark){
			$out .= $value_mark[$section_id]['mark_total'].',';
		}
		
		$out .= "\r\n";
		$out .= '売上金額,';
		foreach($mark_list as $section_id=>$term_mark){
			$out .= $total_list[$section_id].',';
		}
		
		$out .= "\r\n";
		$out .= '達成%,';
		foreach($mark_list as $section_id=>$term_mark){
			$out .= $term_mark.',';
		}
		$out .= "\r\n";
		$out .= '順位,';
		$rank = 1;
		foreach($mark_list as $section_id=>$term_mark){
			$out .= $rank.',';
			$rank++;
		}
		$out .= "\r\n";
		$out .= "\r\n";
		
		//////////////////////////////////////////今日のまとめ
		$out .= $prev_year.'年'.$month.'月'.$day.'日の売上合計,'.$prev_today."\r\n";
		$out .= $year.'年'.$month.'月'.$day.'日の売上合計,'.$today_total."\r\n";
		$today_sakutai = $TotalComponent->fprate2($today_total, $prev_today);
		$out .= $prev_year.'年'.$month.'月'.$day.'日時点での昨対,'.$today_sakutai."\r\n";
		
		/*
		$out .= "\r\n";
		$out .= "\r\n";
		////////////////////////////////////////客数
		$rankings = array();
		$out .= '直営店客数集計,'.$year.'年'.$month.'月,'."\r\n";
    	$out .= '部門,';
    	$days = $DateCalComponent->last_day($year, $month);
    	$d = 1;
    	while($days >= $d){
    		$out .= $d.'日,';
    		$d++;
    	}
		$out .= '店別合計'."\r\n";
		$sections = $SectionModel->amountSectionList();
		$total = array();
		$all_total = 0;
		foreach($sections as $section_id=>$section_name){
			$section_total = 0;
			$i = array();
			$amounts = $AmountSectionModel->markIndex($section_id, $year, $month);
			foreach($amounts['days'] as $day){
				@$total[$day['day']] = $total[$day['day']] + $day['guest_qty'];
				$i[] = $day['guest_qty'];
				$section_total = $section_total + $day['guest_qty'];
				$all_total = $all_total + $day['guest_qty'];
			}
			$out .= $section_name.',';
			$out .= implode(',', $i);
			$out .= ','.$section_total."\r\n";
			$rankings[$section_id] = $section_total;
		}
		
		$out .= '日計,';
		$out .= implode(',', $total);
		$out .= ','.$all_total."\r\n";
		$out .= "\r\n";
		$out .= '客数ランキング,';
		$out .= "\r\n";
		$out .= '部門,';
		arsort($rankings);
		foreach($rankings as $section_id=>$ranking){
			$out .= $sections[$section_id].',';
		}
		$out .= "\r\n";
		$out .= '客数,';
		foreach($rankings as $section_id=>$ranking){
			$out .= $ranking.',';
		}
		$out .= "\r\n";
		$out .= '順位,';
		$rank = 1;
		foreach($rankings as $section_id=>$ranking){
			$out .= $rank.',';
			$rank++;
		}
		
		$out .= "\r\n";
		$out .= "\r\n";
		////////////////////////////////////////ブランド集計
		App::import('Model', 'AmountBrand');
    	$AmountBrandModel = new AmountBrand();
    	App::import('Model', 'Brand');
    	$BrandModel = new Brand();
    	$brands = $BrandModel->find('list');
		
		$out .= 'ブランド別売上,'.$year.'年'.$month.'月,'."\r\n";
    	$out .= 'ブランド,';
    	$days = $DateCalComponent->last_day($year, $month);
    	$d = 1;
    	while($days >= $d){
    		$out .= $d.'日,';
    		$d++;
    	}
		$out .= '合計'."\r\n";
		
		$total = array();
		$all_total = 0;
		$amounts = $AmountBrandModel->markIndex($brands, $year, $month);
		foreach($brands as $brand_id=>$brand_name){
			$brand_total = 0;
			$out .= $brand_name.',';
			foreach($amounts as $day=>$amount){
				$out .= $amount[$brand_id]['sales'].',';
				$brand_total = $brand_total + $amount[$brand_id]['sales'];
			}
			$out .= $brand_total."\r\n";
		}
		
		
		$out .= "\r\n";
		$out .= "\r\n";
		////////////////////////////////////////店舗別 在庫
		$out .= '部門別集計,'.$year.'年'.$month.'月'.$day.'日,'."\r\n";
		$out .= "\r\n";
		$stock_qty = 0;
		$stock_price = 0;
    	$sections = $SectionModel->amountSectionList2();
    	foreach($sections as $section_id=>$section_name){
    		$out .= $section_name."\r\n";
    		$out_val = $AmountSectionModel->dayAmount($section_id);
    		$out .= $out_val['value'];
    		$stock_qty = $stock_qty + $out_val['out']['stock_qty'];
			$stock_price = $stock_price + $out_val['out']['stock_price'];
    		$out .= "\r\n";
    	}
		$out .= "\r\n";
		$out .= '全社合計'."\r\n";
		$out .= '在庫数,'.$stock_qty."\r\n";
		$out .= '在庫上代,'.$stock_price."\r\n";
		*/
		
		
		////////////////////////////////////////出力部
		$file_name = 'store_sales'.date('Ymd-His').'.csv';
		$path = WWW_ROOT.'/files/store_sales/';
		$output_csv = mb_convert_encoding($out, 'SJIS', 'UTF-8');
		file_put_contents($path.$file_name, $output_csv);
		
		
	}//集計終わり
	
	
	
	
	function inSales($file_name){
		ignore_user_abort(true);
		set_time_limit(0);
		ini_set('memory_limit', '512M');
		$path = WWW_ROOT.DS.'files'.DS.'prepare'.DS;

		App::import('Model', 'Item');
    	$ItemModel = new Item();
    	App::import('Model', 'Sale');
    	$SaleModel = new Sale();
    	App::import('Model', 'SalesDateil');
    	$SalesDateilModel = new SalesDateil();
    	App::import('Model', 'Depot');
    	$DepotModel = new Depot();
    	App::import('Model', 'Destination');
    	$DestinationModel = new Destination();
    	App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();

    	App::import('Component', 'StratCsv');
   		$StratCsvComponent = new StratCsvComponent();
   		App::import('Component', 'Selector');
   		$SelectorComponent = new SelectorComponent();

   		App::import('Model', 'AmountBrand');
    	$AmountBrandModel = new AmountBrand();
    	App::import('Model', 'AmountCompany');
    	$AmountCompanyModel = new AmountCompany();
    	App::import('Model', 'AmountDepot');
    	$AmountDepotModel = new AmountDepot();
    	App::import('Model', 'AmountDestination');
    	$AmountDestinationModel = new AmountDestination();
    	App::import('Model', 'AmountFactory');
    	$AmountFactoryModel = new AmountFactory();
    	App::import('Model', 'AmountItem');
    	$AmountItemModel = new AmountItem();
    	App::import('Model', 'AmountItemproperty');
    	$AmountItempropertyModel = new AmountItemproperty();
    	App::import('Model', 'AmountItemtype');
    	$AmountItemtypeModel = new AmountItemtype();
    	App::import('Model', 'AmountMajorSize');
    	$AmountMajorSizeModel = new AmountMajorSize();
    	App::import('Model', 'AmountMaterial');
    	$AmountMaterialModel = new AmountMaterial();
    	App::import('Model', 'AmountPair');
    	$AmountPairModel = new AmountPair();
    	App::import('Model', 'AmountProcess');
    	$AmountProcessModel = new AmountProcess();
    	App::import('Model', 'AmountSalesCode');
    	$AmountSalesCodeModel = new AmountSalesCode();
    	App::import('Model', 'AmountSalesStateCode');
    	$AmountSalesStateCodeModel = new AmountSalesStateCode();
    	App::import('Model', 'AmountSection');
    	$AmountSectionModel = new AmountSection();
    	App::import('Model', 'AmountStone');
    	$AmountStoneModel = new AmountStone();
    	App::import('Model', 'AmountUser');
    	$AmountUserModel = new AmountUser();

		$file_stream = file_get_contents($path.$file_name);
		$file_stream = mb_convert_encoding($file_stream, 'UTF-8', 'ASCII,JIS,EUC-JP,SJIS');
		unlink($path.$file_name);
		$rename_opne = fopen($path.$file_name, 'w');
		$result = fwrite($rename_opne, $file_stream);
		fclose($rename_opne);
		$file_open = fopen($path.$file_name, 'r');

		while($row = fgetcsv($file_open)){
			if($row[0] == '売上伝票No') continue;
			$item_name = trim($row[51]);
			$params = array(
				'conditions'=>array('Item.name'=>$item_name),
				'recursive'=>0,
			);
			$item = $ItemModel->find('first' ,$params);
			if(!$item){//itemが無かったら保存
				$item = '';
				//$sj12_zen = mb_convert_kana($row[58], 'K', 'UTF-8'); //新マスターダンプ対応のため、お蔵入り
				$item['Item']['stone_id'] = $StratCsvComponent->masterDump('Stone', $row[58]);//ルースのid
				$item['Item']['material_id'] = $StratCsvComponent->masterDump('Material', $row[56]);//マテリアルのid
				$item['Item']['price'] = floor($row[67]);//上代 切捨て整数化floor
				$item['Item']['cost'] = floor($row[71]);//在庫原価
				/*新マスターダンプ対応のため、お蔵入り
				if(!empty($row[62])){
					$pre_sj36 = mb_convert_kana($row[62], 'K', 'UTF-8');
				}else{
					$pre_sj36 = '';
				}
				*/
				$item['Item']['factory_id'] = $StratCsvComponent->masterDump('Factory', $row[62]);//工場のid
				$item['Item']['brand_id'] = $StratCsvComponent->masterDump('Brand', $row[60]);//ブランドのid
				$item['Item']['title'] = $row[49];
				if($item['Item']['brand_id'] == 10 or $item['Item']['brand_id'] == 11 or $item['Item']['brand_id'] == 12){
					$stock_code = 3;
				}else{
					$stock_code = 1;
				}
				$item['Item']['stock_code'] = $stock_code;
				$item['Item']['name'] = $item_name;
				$result = $ItemModel->save($item);
				if(!$result) $this->log('Item save error : item_name:'.$item_name, LOG_ERROR);
				$item['Item']['id'] = $ItemModel->getInsertID();
				$ItemModel->id = null;
			}

			$sale = array();
			$sale_dateil = array();
			$sale_id = '';
			$start_juge = true;
			$params = array(
				'conditions'=>array('Sale.old_system_no'=>$row[0]),
				'recursive'=>0,
			);
			$sale = $SaleModel->find('first' ,$params);
			if($sale){//old_noがあったら、次にdetailを探す。detailでもあったら無視する。
				$params = array(
					'conditions'=>array('and'=>array('SalesDateil.old_system_line'=>$row[1], 'SalesDateil.sale_id'=>$sale['Sale']['id'])),
					'recursive'=>0,
				);
				$sale_dateil = $SalesDateilModel->find('first' ,$params);
				if($sale_dateil) $start_juge = false;
			}
			if($StratCsvComponent->selectCustom($row[47])){//客注品番ははじく
				$start_juge = false;
			}
			if($start_juge){
				if(!$sale){ //saleが無ければ新規登録する
					//初めは全て請求済みにする。saleにold_system_noを設け、請求書を見ながら1つずつステータスを印刷済みに変えて請求書を発行する。
					if($row[3] == '卸売上'){
						$sale['Sale']['sale_type'] = '1';//卸売上
						$sale['Sale']['sale_status'] = '3';//請求済
					}elseif($row[3] == '卸返品'){
						$sale['Sale']['sale_type'] = '1';//卸売上
						$sale['Sale']['sale_status'] = '4';//赤伝
					}elseif($row[3] == '売上'){
						$sale['Sale']['sale_type'] = '2';//通常売上
						$sale['Sale']['sale_status'] = '7';//通常売上
					}elseif($row[3] == '売返'){
						$sale['Sale']['sale_type'] = '2';//通常売上
						$sale['Sale']['sale_status'] = '4';//赤伝
					}
					$params = array(
						'conditions'=>array('Depot.old_system_no'=>$row[4]),
						'recursive'=>0,
					);
					$depot = $DepotModel->find('first' ,$params);
					if(!$depot){//なかったらJOKERで
						$params = array(
							'conditions'=>array('Depot.id'=>1047),
							'recursive'=>0,
						);
						$depot = $DepotModel->find('first' ,$params);
					}
					$sale['Sale']['depot_id'] = $depot['Depot']['id'];
					if(!empty($row[40])){//得意先CDが入っていたら出荷先登録
						$destination_old_system_no = $row[40].'-'.$row[41];
						$params = array(
							'conditions'=>array('Destination.old_system_no'=>$destination_old_system_no),
							'recursive'=>0,
						);
						$destination = $DestinationModel->find('first' ,$params);
						if($destination){
							$sale['Sale']['destination_id'] = $destination['Destination']['id'];
							if(!empty($destination['Company']['user_id'])){
								$sale['Sale']['contact1'] = $destination['Company']['user_id'];
							}
						}else{
							$sale['Sale']['destination_id'] = '';
						}
					}else{
						$sale['Sale']['destination_id'] = '';
					}
					$sale['Sale']['date'] = $row[6];
					if(empty($sale['Sale']['contact1'])){
						$sale['Sale']['contact1'] = $StratCsvComponent->oldContact($row[10], $row[6]);
					}
					$sale['Sale']['contact2'] = $StratCsvComponent->oldContact($row[13], $row[6]);
					$sale['Sale']['contact3'] = $StratCsvComponent->oldContact($row[16], $row[6]);
					$sale['Sale']['contact4'] = $StratCsvComponent->oldContact($row[19], $row[6]);
					$total_moth = $StratCsvComponent->totalMoth($row, $sale['Sale']['sale_status']);
					$sale['Sale']['total'] = $total_moth['total'];
					$sale['Sale']['item_price_total'] = $total_moth['item_price_total'];
					$sale['Sale']['tax'] = $total_moth['tax'];
					$sale['Sale']['remark'] = $row[46];
					$sale['Sale']['old_system_no'] = $row[0];
				}else{//$saleがあったら金額を加算
					$total_moth = $StratCsvComponent->totalMoth($row, $sale['Sale']['sale_status']);
					$sale['Sale']['total'] = (int)$total_moth['total'] + (int)$sale['Sale']['total'];
					$sale['Sale']['item_price_total'] = (int)$total_moth['item_price_total'] + (int)$sale['Sale']['item_price_total'];
					$sale['Sale']['tax'] = (int)$total_moth['tax'] + (int)$sale['Sale']['tax'];
					$sale['Sale']['id'] = $sale['Sale']['id'];
				}
				$result = $SaleModel->save($sale);
				if(!$result) $this->log('Sales save error : sales_csv.php 123', LOG_ERROR);
				$sale_id = $SaleModel->getInsertID();
				$SaleModel->id = null;
				//詳細登録開始
				$sale_dateil['SalesDateil']['sale_id'] = $sale_id;
				$params = array(
					'conditions'=>array('Subitem.jan'=>$row[47]),
					'recursive'=>0,
				);
				$subitem = $SubitemModel->find('first' ,$params);
				if(!$subitem){
					$subitem = '';
					//子品番を新規登録
					$subitem['Subitem']['minority_size'] = '';
					$subitem['Subitem']['major_size'] = $StratCsvComponent->baseMajorSize(trim($row[52]));
					if($subitem['Subitem']['major_size'] == 'other'){
						$subitem['Subitem']['minority_size'] = trim($row[52]);
					}
					$subitem['Subitem']['item_id'] = $item['Item']['id'];
					$subitem['Subitem']['jan'] = $row[47];
					$subitem['Subitem']['name_kana'] = $row[58];
					$subitem['Subitem']['cost'] = floor($row[71]);
					$item_name = trim($row[51]);
					$subitem_sub_name = substr($row[52], 1, 2);
					$subitem['Subitem']['name'] = $StratCsvComponent->sjSubItemName($subitem_sub_name, $item_name);
					$SubitemModel->save($subitem);
					$subitem['Subitem']['id'] = $SubitemModel->getInsertID();
					$SubitemModel->id = null;
				}
				$size = $SelectorComponent->sizeSelector($subitem['Subitem']['major_size'], $subitem['Subitem']['minority_size']);
				$sale_dateil['SalesDateil']['item_id'] = $subitem['Subitem']['item_id'];
				$sale_dateil['SalesDateil']['subitem_id'] = $subitem['Subitem']['id'];
				$sale_dateil['SalesDateil']['size'] = $size;
				$sale_dateil['SalesDateil']['bid'] = $total_moth['bid'];
				$sale_dateil['SalesDateil']['bid_quantity'] = $total_moth['bid_quantity'];
				$sale_dateil['SalesDateil']['cost'] = $total_moth['cost'];
				$sale_dateil['SalesDateil']['tax'] = $total_moth['dateil_tax'];
				$sale_dateil['SalesDateil']['ex_bid'] = $total_moth['ex_bid'];
				$sale_dateil['SalesDateil']['old_system_line'] = $row[1];
				if($SalesDateilModel->save($sale_dateil)){
					$SalesDateilModel->id = null;
					$AmountBrandModel->csv($sale, $sale_dateil, $total_moth);
					$AmountCompanyModel->csv($sale, $sale_dateil, $total_moth);
					$AmountDepotModel->csv($sale, $sale_dateil, $total_moth);
					$AmountDestinationModel->csv($sale, $sale_dateil, $total_moth);
					$AmountFactoryModel->csv($sale, $sale_dateil, $total_moth);
					$AmountItemModel->csv($sale, $sale_dateil, $total_moth);
					$AmountItempropertyModel->csv($sale, $sale_dateil, $total_moth);
					$AmountItemtypeModel->csv($sale, $sale_dateil, $total_moth);
					$AmountMajorSizeModel->csv($sale, $sale_dateil, $total_moth);
					$AmountMaterialModel->csv($sale, $sale_dateil, $total_moth);
					$AmountPairModel->csv($sale, $sale_dateil, $total_moth);
					$AmountProcessModel->csv($sale, $sale_dateil, $total_moth);
					$AmountSalesCodeModel->csv($sale, $sale_dateil, $total_moth);
					$AmountSalesStateCodeModel->csv($sale, $sale_dateil, $total_moth);
					$AmountSectionModel->csv($sale, $sale_dateil, $total_moth);
					$AmountStoneModel->csv($sale, $sale_dateil, $total_moth);
					$AmountUserModel->csv($sale, $sale_dateil, $total_moth);
				}else{
					$this->log('SalesDateil save error : prepare.php 183', LOG_ERROR);
					$SalesDateilModel->id = null;
				}
			}//strat_juge の終わり
		}//foreach終わり
		fclose($file_open);
		$result = unlink($path.$file_name);
		return memory_get_usage();
		//return $result;
	}

	//日付から年次、月次、週次、日次の範囲日付を返す
	function amountSpan($date, $key){
		$return = array();
		App::import('Component', 'DateCal');
   		$DateCalComponent = new DateCalComponent();
		$date = str_replace('-', '', $date);
		$yyyy = substr($date, 0, 4);
		$mm = substr($date, 4, 2);
		$dd = substr($date, 6, 2);
		if($key == 4){//日次
			$start_day = $date;
			$end_day = $date;
		}elseif($key == 3){//週次
			$this_week = $DateCalComponent->this_week($yyyy, $mm, $dd);
			$start_day = $this_week['start_day'];
			$end_day = $this_week['end_day'];
		}elseif($key == 2){//月次
			$month = (int)$mm;
			$last_day = $DateCalComponent->last_day($yyyy, $month);
			$start_day = $yyyy.$mm.'01';
			$end_day = $yyyy.$mm.$last_day;
		}elseif($key == 1){//年次
			$start_day = $yyyy.'0101';
			$end_day = $yyyy.'1231';
		}
		$return['start_day'] = str_replace('-', '', $start_day);
		$return['end_day'] = str_replace('-', '', $end_day);
		return $return;
	}

	//日付から前年、前月、前週、前日の範囲日付を返す
	function amountPrevSpan($date, $key){
		$return = array();
		App::import('Component', 'DateCal');
   		$DateCalComponent = new DateCalComponent();
		$date = str_replace('-', '', $date);
		$yyyy = substr($date, 0, 4);
		$mm = substr($date, 4, 2);
		$dd = substr($date, 6, 2);
		if($key == 4){//前日
			$start_day = $DateCalComponent->controll_day($date, 1);
			$end_day = $DateCalComponent->controll_day($date, 1);
		}elseif($key == 3){//前週
			$this_week = $DateCalComponent->this_week($yyyy, $mm, $dd);
			$start_day = $DateCalComponent->controll_day($this_week['start_day'], 7);
			$end_day = $DateCalComponent->controll_day($this_week['end_day'], 7);
		}elseif($key == 2){//前月
			$month = (int)$mm;
			$prev_month = $DateCalComponent->prev_month($yyyy, $month);
			$last_day = $DateCalComponent->last_day($prev_month['year'], $prev_month['month']);
			$start_day = $prev_month['year'].$prev_month['month'].'01';
			$end_day = $prev_month['year'].$prev_month['month'].$last_day;
		}elseif($key == 1){//前年
			$prev_year = (int)$yyyy -1;
			$start_day = $prev_year.'0101';
			$end_day = $prev_year.'1231';
		}
		$return['start_day'] = str_replace('-', '', $start_day);
		$return['end_day'] = str_replace('-', '', $end_day);
		return $return;
	}

	//日付から前年、前年同月、前年同週、前年同日の範囲日付を返す
	function amountPrevYear($date, $key){
		$return = array();
		App::import('Component', 'DateCal');
   		$DateCalComponent = new DateCalComponent();
		$date = str_replace('-', '', $date);
		$yyyy = substr($date, 0, 4);
		$mm = substr($date, 4, 2);
		$dd = substr($date, 6, 2);
		$prev_year = (int)$yyyy -1;
		if($key == 4){//前年同日
			$start_day = $prev_year.$mm.$dd;
			$end_day = $prev_year.$mm.$dd;
		}elseif($key == 3){//前年同週
			$this_week = $DateCalComponent->this_week($prev_year, $mm, $dd);
			$start_day = $this_week['start_day'];
			$end_day = $this_week['end_day'];
		}elseif($key == 2){//前年同月
			$month = (int)$mm;
			$last_day = $DateCalComponent->last_day($prev_year, $month);
			$start_day = $prev_year.$month.'01';
			$end_day = $prev_year.$month.$last_day;
		}elseif($key == 1){//前年
			$start_day = $prev_year.'0101';
			$end_day = $prev_year.'1231';
		}
		$return['start_day'] = str_replace('-', '', $start_day);
		$return['end_day'] = str_replace('-', '', $end_day);
		return $return;
	}

	//刻印品番かどうか？＿判断する
	function kokuin_juge($item){
		$juge = false;
		if($item == '9000000005006') $juge = true;
		if($item == '9000000006003') $juge = true;
		if($item == '9000000007000') $juge = true;
		if($item == '9000000008007') $juge = true;
		return $juge;
	}

	function cleaningkit_juge($item){
		$juge = false;
		if($item == '5000144390000') $juge = true;
		if($item == '5000144170008') $juge = true;
		if($item == '5000144180007') $juge = true;
		if($item == '5000109940004') $juge = true;
		if($item == '5000109930005') $juge = true;
		if($item == '5000144210001') $juge = true;
		if($item == '5000144200002') $juge = true;
		if($item == '5000144190006') $juge = true;
		return $juge;
	}

	//在庫移動プログラム　旧(型番別在庫.CSV)　→　新　古いやつ、基本的に使わない
	function inStock($path, $file_name){
		$old_system_no = $file_name;
		$file_name = $file_name.'.CSV';
		App::import('Model', 'Depot');
    	$DepotModel = new Depot();
    	App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
    	App::import('Model', 'Item');
    	$ItemModel = new Item();
		App::import('Model', 'Stock');
    	$StockModel = new Stock();
		$is_depot = false;
		$params = array(
			'conditions'=>array('Depot.old_system_no'=>$old_system_no),
			'recursive'=>0
		);
		$is_depot = $DepotModel->find('first' ,$params);
		if($is_depot){
			$sj_file_stream = file_get_contents($path.$file_name);
			$sj_file_stream = mb_convert_encoding($sj_file_stream, 'UTF-8', 'ASCII,JIS,EUC-JP,SJIS');
			$sj_rename_opne = fopen($path.$file_name, 'w');
			$result = fwrite($sj_rename_opne, $sj_file_stream);
			fclose($sj_rename_opne);
			$sj_opne = fopen($path.$file_name, 'r');
			$csv_header = fgetcsv($sj_opne);
			while($sj_row = fgetcsv($sj_opne)){
				$StockModel->create();
				$subitem = array();
				$params = array(
					'conditions'=>array('Subitem.jan'=>$sj_row[8]),
					'recursive'=>0
				);
				$subitem = $SubitemModel->find('first' ,$params);
				if(!$subitem){//なかった場合
					$params = array(
						'conditions'=>array('Item.name'=>$sj_row[0]),
						'recursive'=>0
					);
					$item = $ItemModel->find('first' ,$params);
					if(!$item){//なかった場合
						$item = $ItemModel->NewItem($sj_row[0], $sj_row[7], $sj_row[5]);
					}
					$subitem = $SubitemModel->NewSubitem($item['Item']['id'], $sj_row[3], $sj_row[8], $sj_row[0]);
				}
				$qty = floor($sj_row[10]);
				$StockModel->Plus($subitem['Subitem']['id'], $is_depot['Depot']['id'], $qty, 1135, 2);
			}
			fclose($sj_opne);
			$result = unlink($path.$file_name);
			return memory_get_usage();
		}else{
			return 'not depot';
		}
	}
	
	//在庫移動プログラム　旧(ZAIKO.CSV)　→　新　こちらが新しい方、
	function inStock2($path, $file_name){
		$old_system_no = $file_name;
		$file_name = $file_name.'.CSV';
		App::import('Model', 'Depot');
    	$DepotModel = new Depot();
    	App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
    	App::import('Model', 'Item');
    	$ItemModel = new Item();
		App::import('Model', 'Stock');
    	$StockModel = new Stock();
		$is_depot = false;
		$params = array(
			'conditions'=>array('Depot.old_system_no'=>$old_system_no),
			'recursive'=>0
		);
		$is_depot = $DepotModel->find('first' ,$params);
		if($is_depot){
			$sj_file_stream = file_get_contents($path.$file_name);
			$sj_file_stream = mb_convert_encoding($sj_file_stream, 'UTF-8', 'ASCII,JIS,EUC-JP,SJIS');
			$sj_rename_opne = fopen($path.$file_name, 'w');
			$result = fwrite($sj_rename_opne, $sj_file_stream);
			fclose($sj_rename_opne);
			$sj_opne = fopen($path.$file_name, 'r');
			$csv_header = fgetcsv($sj_opne);
			while($sj_row = fgetcsv($sj_opne)){
				$subitem_jan = trim($sj_row[2]);
				$subitem_size = trim($sj_row[6]);
				$item_name = trim($sj_row[5]);
				$item_title = trim($sj_row[3]);
				$item_brand = trim($sj_row[14]);
				$subitem_cost = floor($sj_row[19]);
				$subitem_kana = trim($sj_row[12]);
				$qty = floor($sj_row[17]);
				$stock_code = '';
				$StockModel->create();
				$subitem = array();
				$params = array(
					'conditions'=>array('Subitem.jan'=>$subitem_jan),
					'recursive'=>0
				);
				$subitem = $SubitemModel->find('first' ,$params);
				if(!$subitem){//なかった場合
					$params = array(
						'conditions'=>array('Item.name'=>$item_name),
						'recursive'=>-1,
					);
					$item = $ItemModel->find('first' ,$params);
					if(!$item){//なかった場合
						$item = $ItemModel->NewItem($item_name, $item_title, $item_brand);//品番、タイトル、ブランド名
					}
					$subitem = $SubitemModel->NewSubitem($item['Item']['id'], $subitem_size, $subitem_jan, $item_name, $subitem_kana);//item_id、サイズ、JAN、品番
				}
				if(!empty($subitem['Item']['stock_code'])) $stock_code = $subitem['Item']['stock_code'];
				if(!empty($item['Item']['stock_code'])) $stock_code = $item['Item']['stock_code'];
				if($stock_code == '3'){
					$save_value = array();
					$SubitemModel->create();
					$save_value['Subitem']['cost'] = $subitem_cost;
					$save_value['Subitem']['id'] = $subitem['Subitem']['id'];
					$SubitemModel->save($save_value);
				}
				$result = $StockModel->Plus($subitem['Subitem']['id'], $is_depot['Depot']['id'], $qty, 1135, 2);
				
			}
			fclose($sj_opne);
			$result = unlink($path.$file_name);
			return memory_get_usage();
		}else{
			return 'not depot';
		}
	}
	
	
	//旧システム→在庫管理→在庫一覧表　ZAIKO.CSV
	//コストが0以下だったら、CSVの原価を入れとく
	// 2011年3月8日NEXTタスク
	//上代も0だったらCSVの上代に差し替える
	function reTryCost($path, $file_name){
		//$file_name = $file_name.'.CSV';
		App::import('Component', 'Selector');
   		$SelectorComponent = new SelectorComponent();
   		App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
		App::import('Model', 'Item');
    	$ItemModel = new Item();
		
		$sj_file_stream = file_get_contents($path.$file_name);
		$sj_file_stream = mb_convert_encoding($sj_file_stream, 'UTF-8', 'ASCII,JIS,EUC-JP,SJIS');
		$sj_rename_opne = fopen($path.$file_name, 'w');
		$result = fwrite($sj_rename_opne, $sj_file_stream);
		fclose($sj_rename_opne);
		$sj_opne = fopen($path.$file_name, 'r');
		$csv_header = fgetcsv($sj_opne);
		while($sj_row = fgetcsv($sj_opne)){
			$subitem_cost = floor($sj_row[19]);
			$price = floor($sj_row[20]);
			$subitem_jan = trim($sj_row[2]);
			
			$params = array(
				'conditions'=>array('Subitem.jan'=>$subitem_jan),
				'recursive'=>0
			);
			$subitem = $SubitemModel->find('first' ,$params);
			$cost = $SelectorComponent->costSelector2($subitem['Subitem']['id']);
			if(empty($cost)){
				if($subitem_cost > 1){
					$save_value = array();
					$ItemModel->create();
					$save_value['Item']['cost'] = $subitem_cost;
					$save_value['Item']['id'] = $subitem['Item']['id'];
					$ItemModel->save($save_value);
				}
			}
			if(empty($subitem['Item']['price'])){
				if($price > 1){
					$save_value = array();
					$ItemModel->create();
					$save_value['Item']['price'] = $price;
					$save_value['Item']['id'] = $subitem['Item']['id'];
					$ItemModel->save($save_value);
				}
			}
		}
		fclose($sj_opne);
		return unlink($path.$file_name);
	}

	//ホンさんシステムから売上吸い上げ
	function uptakeSale($path, $file_name){
		//$file_name = $file_name.'.CSV';
		App::import('Component', 'Selector');
   		$SelectorComponent = new SelectorComponent();
   		App::import('Model', 'Section');
    	$SectionModel = new Section();
    	App::import('Model', 'AmountSection');
    	$AmountSectionModel = new AmountSection();
		
		$tenpo_path = WWW_ROOT.'files'.DS.'default'.DS;
		$tenpo_name = 'tenpo.csv';
		/*2回回すと何故か文字化け
		$tenpo_stream = file_get_contents($tenpo_path.$tenpo_name);
		$tenpo_stream = mb_convert_encoding($tenpo_stream, 'UTF-8', 'ASCII,JIS,EUC-JP,SJIS');
		$tenpo_opne = fopen($tenpo_path.$tenpo_name, 'w');
		$result = fwrite($tenpo_opne, $tenpo_stream);
		fclose($tenpo_opne);
		*/
		$tenpOpne = fopen($tenpo_path.$tenpo_name, 'r');
		$tenpos = array();
		while($val = fgetcsv($tenpOpne)){
			$tenpos[] = $val;
		}
		
		$sj_file_stream = file_get_contents($path.$file_name);
		$sj_file_stream = mb_convert_encoding($sj_file_stream, 'UTF-8', 'ASCII,JIS,EUC-JP,SJIS');
		$sj_rename_opne = fopen($path.$file_name, 'w');
		$result = fwrite($sj_rename_opne, $sj_file_stream);
		fclose($sj_rename_opne);
		$sj_opne = fopen($path.$file_name, 'r');
		//$csv_header = fgetcsv($sj_opne);
		
		while($rows = fgetcsv($sj_opne)){
			mysql_ping();
			$saveData = array();
			//"売上日"	"店舗ID"	"フロアＮＯ"	"売上実績"	"販売目標"	"確定目標"
			//$saveData['start_day'] = mb_substr(str_replace("/", "-", $rows[0]),0,8); //売上日
			//$saveData['end_day'] = mb_substr(str_replace("/", "-", $rows[0]),0,8); //売上日
			$saveData['start_day'] = $rows[0];
			$saveData['end_day'] = $rows[0];
			$saveData['addsub'] = str_replace("\\", "", $rows[3]); //売上実績
			//$saveData['full_amount'] = str_replace("\\", "", $rows[4]); //販売目標、昔店側で設定していた目標。今使ってない。
 			$saveData['mark'] = str_replace("\\", "", $rows[5]); //確定目標、本社側で設定している目標。本社で割り振ったものを、店側が日割りにしてそれを目標にしている。
			
			// section_id をゲットする、無かったら作ってしまう。
			$hon_id = $rows[1]; //店舗ID
			$params = array(
				'conditions'=>array('Section.kyuuyo_bugyo5'=>$hon_id),
				'recursive'=>-1
			);
			$section = $SectionModel->find('first' ,$params);
			if($section){
				$saveData['section_id'] = $section['Section']['id'];
			}else{
				$new_sec = array();
				$SectionModel->create();
				foreach($tenpos as $tenpo){
					if($tenpo[0] == $hon_id){
						$new_sec['Section']['id'] = '';
						$new_sec['Section']['name'] = $tenpo[1];
						$new_sec['Section']['kyuuyo_bugyo5'] = $hon_id;
						$new_sec['Section']['sales_code'] = 4;
						$SectionModel->save($new_sec);
						$saveData['section_id'] = $SectionModel->getInsertID();
					}
				}
			}
			if(empty($saveData['section_id'])) $saveData['section_id'] = '407';
			
			//その店舗の、その日の売上が、あったら加算
			$saveData['id'] = '';
			$sData = array();
			$params = array(
				'conditions'=>array(
					'AmountSection.start_day'=>$saveData['start_day'],
					'AmountSection.end_day'=>$saveData['end_day'],
					'AmountSection.section_id'=>$saveData['section_id'],
				),
				'recursive'=>-1
			);
			$amount = $AmountSectionModel->find('first' ,$params);
			if($amount){
				$saveData['id'] = $amount['AmountSection']['id'];
				$saveData['addsub'] = $saveData['addsub'] + $amount['AmountSection']['addsub'];
				$saveData['mark'] = $saveData['mark'] + $amount['AmountSection']['mark'];
			}
			$AmountSectionModel->create();
			$sData['AmountSection'] = $saveData;
			$AmountSectionModel->save($sData);
		}
		fclose($sj_opne);
		return unlink($path.$file_name);
	}

}
?>