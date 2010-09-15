<?php

class DateCalComponent extends Object {

//--------------
// 月の末日計算
//--------------
	//その月の月末の日を返す
	function last_day($year, $month) {
		return lastday($year, $month);
	}

	//日付から、その週の始まりの日と終わりの日を返す
	function this_week($yyyy, $mm, $dd){
		$yyyy = (int)$yyyy;
		$mm = (int)$mm;
		$dd = (int)$dd;
    	$now_date = mktime(0,0,0,$mm,$dd,$yyyy);
    	$w = (intval(date("w",$now_date)) + 6) % 7;
		$this_week['start_day'] = date("Y-m-d",$now_date - 86400 * $w);
		$this_week['end_day'] = date("Y-m-d",$now_date + 86400 * (6 - $w));
		return $this_week;
	}

	//翌月の月を返す
	function next_date($year, $month){
		if($month == 12){
			$next['month'] = 1;
			$next['year'] = $year +1;
		}else{
			$next['month'] = $month +1;
			$next['year'] = $year;
		}
		return $next;
	}

	//翌々月の月を返す
	function next_next_date($year, $month){
		if($month == 12){
			$next['month'] = 2;
			$next['year'] = $year +1;
		}elseif($month == 11){
			$next['month'] = 1;
			$next['year'] = $year +1;
		}else{
			$next['month'] = $month +2;
			$next['year'] = $year;
		}
		return $next;
	}

	//日だけじゃなく、YYYY-MM-DD形式で返す
	function this_last_day(){
		$this_year = date('Y');
		$this_month = date('m');
		$simeday = lastday($this_year, $this_month);
		return $this_year.'-'.$this_month.'-'.$simeday;
	}

	//前月を返す
	function prev_month($year, $month){
		$prev = array();
		if($month == '01' or $month == 1){
			$prev['year'] = $year -1;
			$prev['month'] = 12;
		}else{
			$prev['year'] = $year;
			$prev['month'] = $month -1;
			$prev['month'] = str_pad($prev['month'], 2, '0', STR_PAD_LEFT);
		}
		return $prev;
	}

	//指定された日数 $controll_day を引いた日を返す
	function controll_day($date, $controll_day){
		$prev = array();
		$date = str_replace('-', '', $date);
		$yyyy = substr($date, 0, 4);
		$mm = substr($date, 4, 2);
		$dd = substr($date, 6, 2);
		$stamp = mktime(0, 0, 0, $mm, $dd, $yyyy);//その日のタイムスタンプ
		$prev_stamp = $stamp - (86400 * $controll_day);
		$prev_date = date('Ymd', $prev_stamp);
		return $prev_date;
	}

}

function lastday($year, $month) {
  $day = 1; //デフォルトを1日にする。12/24意味不明なエラーのため
  switch($month) {
    case  1: $day = 31; break;
    case  2:
      //4で割り切れる年はうるう年
      if(($year % 4) == 0) {
        $day = 29;
      } else {
        $day = 28;
      }
      //100で割り切れる年はうるう年から除外
      if(($year % 100) == 0) {
        $day = 28;
      }
      //400で割り切れる年はうるう年
      if(($year % 400) == 0) {
        $day = 29;
      }
      break;
    case  3: $day = 31; break;
    case  4: $day = 30; break;
    case  5: $day = 31; break;
    case  6: $day = 30; break;
    case  7: $day = 31; break;
    case  8: $day = 31; break;
    case  9: $day = 30; break;
    case 10: $day = 31; break;
    case 11: $day = 30; break;
    case 12: $day = 31; break;
  }
  return $day;
}

?>