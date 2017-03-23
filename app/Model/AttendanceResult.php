<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 0:21
 */
class AttendanceResult extends AppModel {
	//table指定
	public $useTable="attendance_results";

	//アソシエーション
	public $belongsTo = array(
		'Member' => array(
			'className' => 'Member',
			'foreignKey' => 'member_id'
		)
	);

	#ランチorディナーorランチ・ディナー判定func
	public function judgeLunchDinner($attendance_result){
		$working_day = $attendance_result['AttendanceResult']['working_day'];
		$start_timestamp = strtotime($attendance_result['AttendanceResult']['attendance_start']);
		$end_timestamp = strtotime($attendance_result['AttendanceResult']['attendance_end']);
		#エラー処理
		if($working_day==null||$start_timestamp==null||$end_timestamp==null){
			echo "ERROR:AttendanceResult(judgeLunchDinner)";
			exit;
		}
		$flag_timestamp = strtotime("$working_day 17:00:00");
		#退社が17:00以前
		if($end_timestamp <= $flag_timestamp){
			return "lunch";
		}
		#出社が17:00以後
		elseif($start_timestamp >= $flag_timestamp){
			return "dinner";
		}
		elseif($start_timestamp < $flag_timestamp && $end_timestamp > $flag_timestamp){
			#ランチ・ディナー勤務1時間以上
			$lunch_diff = ($flag_timestamp - $start_timestamp) / (60 * 60);
			$dinner_diff = ($end_timestamp - $flag_timestamp) / (60 * 60);
			if($lunch_diff > 1 && $dinner_diff > 1){
				return "lunch/dinner";
			}
			elseif($lunch_diff > 1 && $dinner_diff <= 1){
				return "lunch";
			}
			elseif($lunch_diff <= 1 && $dinner_diff > 1){
				return "dinner";
			}
		}
		else{
			return null;
		}
	}

	#ランチorディナー総数計算func
	public function calculateLunchDinner($attendance_results){
		$num = array();
		$num['lunch'] = 0;
		$num['dinner'] = 0;
		foreach($attendance_results as $attendance_result){
			$timezone = $this->judgeLunchDinner($attendance_result);
			if($timezone=='lunch'){
				$num['lunch'] += 1;
			}
			elseif($timezone=='dinner'){
				$num['dinner'] += 1;
			}
			elseif($timezone=='lunch/dinner'){
				$num['lunch'] += 1;
				$num['dinner'] += 1;
			}
		}
		return $num;
	}

}
