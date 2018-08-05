<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 0:11
 */
class Attendance extends AppModel {
	//table指定
	public $useTable="attendances";

	//アソシエーション
	public $belongsTo = array(
		'Type' => array(
			'className' => 'AttendanceType',
			'foreignKey' => 'type_id'
		),
		'Member' => array(
			'className' => 'Member',
			'foreignKey' => 'member_id'
		)
	);

	#営業日判定（引数：ミリ秒）
	public function judge24Hour($now){
		#日付
		$working_day = date('Y-m-d', $now);
		#時刻
		$hour = date('G', $now);
		if ($hour < 8) {
			$working_day = date('Y-m-d', strtotime("$working_day -1 day"));
			return $working_day;
		} else{
			return $working_day;
		}
	}

	public function judge24HourString($working_day, $time){
		$hour = date('G', strtotime($time));
		if ($hour < 8) {
			$working_day = date('Y-m-d', strtotime("$working_day +1 day"));
			return date('Y-m-d H:i:s', strtotime("$working_day $time"));
		}
		return date('Y-m-d H:i:s', strtotime("$working_day $time"));
	}

	#出退勤判定（現在の状況）
	public function judgeJobState($working_day, $member_id, $location_id){
		/*出社しているかどうか*/
		$attendance = $this->find('first', array(
			'conditions' => array('member_id' => $member_id, 'Attendance.location_id' => $location_id, 'working_day' => $working_day),
			'order' => array('Attendance.created' => 'desc')
		));
		/*①出社していない*/
		if ($attendance==null) {
			$flag = 1;/*出社ボタンのみ選択可能*/
			return $flag;
		}elseif($attendance['Type']['name']=='出勤'){
			/*②出社のみしている  break_in と check_out が空*/
			$flag = 2;/*休憩開始ボタンと退社ボタンが選択可能*/
			return $flag;
		}elseif($attendance['Type']['name']=='休憩開始') {
			/*③休憩開始しているが、終了していない */
			$flag = 3;/*休憩終了ボタンのみ選択可能*/
			return $flag;
		}elseif($attendance['Type']['name']=='休憩終了') {
			/*④休憩終了しているが、退社していない */
			$flag = 4;/*退社ボタンと休憩開始ボタンが選択可能*/
			return $flag;
		}elseif($attendance['Type']['name']=='退勤'){
			/*⑤退社している*/
			$flag = 5;/*全てのボタン選択不可*/
			return $flag;
		}
	}

	#時間調整（15分毎）
	function timeOrganizer($state, $time){
		/*日付*/
		$date = date('Y-m-d', $time);
		/*時*/
		$hours = date('H', $time);
		/*分*/
		$minutes = date('i', $time);
		$minutes = preg_replace('/^0/','',$minutes);//頭の0を取る

		/*分数調整（15分刻み）*/
		if ($state == '出勤' || $state == '休憩終了') {
			if($minutes == 0){
				$time = $date.' '.$hours.':'.'00:00';
			}
			elseif($minutes >= 1 && $minutes <= 15) {
				$time = $date.' '.$hours.':'.'15:00';
			}
			elseif($minutes >= 16 && $minutes <= 30){
				$time = $date.' '.$hours.':'.'30:00';
			}
			elseif($minutes >= 31 && $minutes <= 45){
				$time = $date.' '.$hours.':'.'45:00';
			}
			elseif($minutes >= 46){
				if ($hours == 23) {
					$hours = '00';
					$date = date('Y-m-d', strtotime("$date +1 day"));
				}else{
					$hours += 1;
				}
				$time = $date.' '.$hours.':'.'00:00';
			}
		}
		elseif($state == '休憩開始' || $state == '退勤'){
			if($minutes >= 0 && $minutes < 15) {
				$time = $date.' '.$hours.':'.'00:00';
			}
			elseif($minutes >= 15 && $minutes < 30){
				$time = $date.' '.$hours.':'.'15:00';
			}
			elseif($minutes >= 30 && $minutes < 45){
				$time = $date.' '.$hours.':'.'30:00';
			}
			elseif($minutes >= 45){
				$time = $date.' '.$hours.':'.'45:00';
			}
		}
		return $time;
	}

	# 時間差分計算（引数：yyyy-mm-dd hh:ii:ss ２つ）
	public function twoDiffCalculator($working_day, $check_in_time, $check_out_time){
		# 返り値
		$hours = array('normal_hours' => 0, 'late_hours' => 0, 'max_hours' => 0);
		# 出勤と休憩開始
		$start_time = strtotime("$check_in_time");
		$end_time = strtotime("$check_out_time");
		$hours['max_hours'] = ($end_time - $start_time) / (60 * 60);
		# 深夜時間判定
		$ten_hours = strtotime("$working_day 22:00:00");
		if($start_time > $ten_hours){
			$late_hours = ($end_time - $start_time) / (60 * 60);
			$hours['late_hours'] = $late_hours;
		}elseif($end_time > $ten_hours){
			$normal_hours = ($ten_hours - $start_time) / (60 * 60);
			$late_hours = ($end_time - $ten_hours) / (60 * 60);
			$hours['normal_hours'] = $normal_hours;
			$hours['late_hours'] = $late_hours;
		}else{
			$normal_hours = ($end_time - $start_time) / (60 * 60);
			$hours['normal_hours'] = $normal_hours;
		}
		#マイナス値エラー
		if($hours['normal_hours']<0||$hours['late_hours']<0){
			debug($hours);debug($working_day);
			debug($check_in_time);debug($check_out_time);
			debug("時間が正しくありません。もう一度やり直してください。");
			exit;
		}
		return $hours;
	}

	#時間差分計算（引数：00:004つ）
	public function fourDiffCalculator($working_day,$check_in_time,$break_in_time,$break_out_time,$check_out_time){
		# 返り値
		$hours = array('normal_hours' => 0, 'late_hours' => 0, 'max_hours' => 0);
		#出勤と休憩開始
		$start_time = strtotime($check_in_time);
		$break_start_time = strtotime($break_in_time);
		#休憩終了と退勤
		$break_end_time = strtotime($break_out_time);
		$end_time = strtotime($check_out_time);
		$hours['max_hours'] = ($end_time - $start_time) / (60 * 60);
		#深夜時間判定
		$ten_hours = strtotime("$working_day 22:00:00");
		if($start_time > $ten_hours){
			$hours_one = ($break_start_time - $start_time) / (60 * 60);
			$hours_two = ($end_time - $break_end_time) / (60 * 60);
			$late_hours = $hours_one + $hours_two;
			$hours['late_hours'] = $late_hours;
		}elseif($break_start_time > $ten_hours){
			$normal_hours = ($ten_hours - $start_time) / (60 * 60);
			$hours_one = ($break_start_time - $ten_hours) / (60 * 60);
			$hours_two = ($end_time - $break_end_time) / (60 * 60);
			$late_hours = $hours_one + $hours_two;
			$hours['normal_hours'] = $normal_hours;
			$hours['late_hours'] = $late_hours;
		}elseif($break_end_time > $ten_hours){
			$normal_hours = ($break_start_time - $start_time) / (60 * 60);
			$late_hours = ($end_time - $break_end_time) / (60 * 60);
			$hours['normal_hours'] = $normal_hours;
			$hours['late_hours'] = $late_hours;
		}elseif($end_time > $ten_hours){
			$hours_one = ($break_start_time - $start_time) / (60 * 60);
			$hours_two = ($ten_hours - $break_end_time) / (60 * 60);
			$normal_hours = $hours_one + $hours_two;
			$late_hours = ($end_time - $ten_hours) / (60 * 60);
			$hours['normal_hours'] = $normal_hours;
			$hours['late_hours'] = $late_hours;
		}else{
			$hours_one = ($break_start_time - $start_time) / (60 * 60);
			$hours_two = ($end_time - $break_end_time) / (60 * 60);
			$normal_hours = $hours_one + $hours_two;
			$hours['normal_hours'] = $normal_hours;
		}
		#マイナス値エラー
		if($hours['normal_hours']<0||$hours['late_hours']<0){
			debug($hours);debug($working_day);
			debug($check_in_time);debug($break_in_time);debug($break_out_time);debug($check_out_time);
			debug("時間が正しくありません。もう一度やり直してください。");
			exit;
		}
		return $hours;
	}

	#時間差分計算③
	public function diffCalculator($working_day,$check_in_time,$check_out_time, $break_arr){
		#　返り値
		$hours = array('normal_hours' => 0, 'late_hours' => 0, 'max_hours' => 0);
		#　出勤and退勤
		$start_time = strtotime("$check_in_time");
		$end_time = strtotime("$check_out_time");
		$hours['max_hours'] = ($end_time - $start_time) / (60 * 60);
		#　深夜時間
		$ten_hours = strtotime("$working_day 22:00:00");
		# 休憩時間配列が空でなくかつcount数が偶数だったら、休憩加味して計算
		if($break_arr!=null && count($break_arr)%2==0){
			$arr = array();$arr2 = array();$i=0;
			foreach($break_arr as $break){
				$arr[] = strtotime("$break");
			}
			array_unshift($arr, $start_time);array_push($arr, $end_time);
			#②コイチで分配
			foreach($arr as $a){
				$i++;$s=ceil($i/2);
				$arr2[$s][] = $a;
			}
			foreach($arr2 as $a){
				#深夜時間判定
				if($a[0] > $ten_hours){
					$late_hours = ($a[1] - $a[0]) / (60 * 60);
					$hours['late_hours'] += $late_hours;
				}
				elseif($a[1] > $ten_hours){
					$normal_hours = ($ten_hours - $a[0]) / (60 * 60);
					$late_hours = ($a[1] - $ten_hours) / (60 * 60);
					$hours['normal_hours'] += $normal_hours;
					$hours['late_hours'] += $late_hours;
				}
				else{
					$normal_hours = ($a[1] - $a[0]) / (60 * 60);
					$hours['normal_hours'] += $normal_hours;
				}
			}
		}
		# 配列が空or休憩時間配列のcount数が奇数の場合、休憩加味せず計算
		else{
			#深夜時間判定
			if($start_time > $ten_hours){
				$late_hours = ($end_time - $start_time) / (60 * 60);
				$hours['late_hours'] = $late_hours;
			}elseif($end_time > $ten_hours){
				$normal_hours = ($ten_hours - $start_time) / (60 * 60);
				$late_hours = ($end_time - $ten_hours) / (60 * 60);
				$hours['normal_hours'] = $normal_hours;
				$hours['late_hours'] = $late_hours;
			}else{
				$normal_hours = ($end_time - $start_time) / (60 * 60);
				$hours['normal_hours'] = $normal_hours;
			}
		}
		return $hours;
	}

}
