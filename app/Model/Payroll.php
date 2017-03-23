<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/07/03
 * Time: 23:11
 */
class Payroll extends AppModel {
	//table指定
	public $useTable="payrolls";

	//アソシエーション
	public $belongsTo = array(
		'TotalSales' => array(
			'className' => 'TotalSales',
			'foreignKey' => 'total_sales_id'
		)
	);

	#人件費率計算（池袋・赤羽）
	public function ratioCalculator($total_sales, $attendance_results){
		$hall = 0;
		$kitchen = 0;
		foreach ($attendance_results as $attendance_result) {
			#勤怠管理時時給
			if($attendance_result['AttendanceResult']['day_hourly_wage']!=0){
				$day_hourly_wage = $attendance_result['AttendanceResult']['day_hourly_wage'];
			}else{
				$day_hourly_wage = $attendance_result['Member']['hourly_wage'];
			}
			if($attendance_result['Member']['Type']['name'] == 'アルバイト') {	#アルバイト
				if ($attendance_result['Member']['Position']['name'] == 'ホール') {
					$hall += floor($attendance_result['AttendanceResult']['hours'] * $day_hourly_wage) + floor($attendance_result['AttendanceResult']['late_hours'] * floor($day_hourly_wage * 1.25));
				} elseif ($attendance_result['Member']['Position']['name'] == 'キッチン') {
					$kitchen += floor($attendance_result['AttendanceResult']['hours'] * $day_hourly_wage) + floor($attendance_result['AttendanceResult']['late_hours'] * floor($day_hourly_wage * 1.25));
				}
			}elseif($attendance_result['Member']['Type']['name']=='社員'){	#社員
				if($attendance_result['Member']['Position']['name']=='ホール'){
					$hall += floor($attendance_result['Member']['hourly_wage']/26);
				}elseif($attendance_result['Member']['Position']['name']=='キッチン'){
					$kitchen += floor($attendance_result['Member']['hourly_wage']/26);
				}
			}
		}
		$ratio = floor(($hall + $kitchen) / $total_sales['TotalSales']['sales'] * 1000) / 10;
		return array("hall" => $hall, "kitchen" => $kitchen, "ratio" => $ratio);
	}

	#人件費率計算（和光）
	public function monthlyPayrollCalculatorWako($month, $member, $attendance_results, $location){
		#時間数
		$hours_arr = array();
		$hours_arr['weekday']['normal'] = 0;
		$hours_arr['weekday']['late'] = 0;
		$hours_arr['weekend']['normal'] = 0;
		$hours_arr['weekend']['end'] = 0;
		#給与金額
		$salary_arr = array();
		$salary_arr['weekday']['normal'] = 0;
		$salary_arr['weekday']['late'] = 0;
		$salary_arr['weekend']['normal'] = 0;
		$salary_arr['weekend']['late'] = 0;


		$hours = 0;
		$late_hours = 0;
		$special_fee = 0;
		#20150807追記
		$salaries = 0;
		$late_salaries = 0;
		#交通費
		if(count($attendance_results) < 16){    //日ごと
			if($member['Member']['compensation_daily']!=0){
				$compensation = count($attendance_results)*$member['Member']['compensation_daily'];
			}else{
				$compensation = $member['Member']['compensation_monthly'];
			}
		}elseif(count($attendance_results) >= 16){   //定期
			if($member['Member']['compensation_monthly']!=0){
				#定期の方が高かったら,日割り
				if($member['Member']['compensation_monthly'] > count($attendance_results)*$member['Member']['compensation_daily']&&$member['Member']['compensation_daily']!=0){
					$compensation = count($attendance_results)*$member['Member']['compensation_daily'];
				}else{
					$compensation = $member['Member']['compensation_monthly'];
				}
			}else{
				$compensation = count($attendance_results)*$member['Member']['compensation_daily'];
			}
		}else{
			echo "Fatal Error : Attendance Results are not availables";
			exit;
		}
		#交通費補正
		if($compensation > 10000){
			$compensation = 10000;
		}
		#加算
		foreach($attendance_results as $attendance_result){
			$hours += $attendance_result['AttendanceResult']['hours'];
			$salaries += floor($attendance_result['AttendanceResult']['hours']*$member['Member']['hourly_wage']);
			$late_hours += $attendance_result['AttendanceResult']['late_hours'];
			$late_salaries += floor($attendance_result['AttendanceResult']['late_hours']*floor($member['Member']['hourly_wage']*1.25));
			#大入り判定
			$total_sales = $this->TotalSales->find('first', array(
				'conditions' => array('TotalSales.location_id' => $location['Location']['id'], 'TotalSales.working_day' => $attendance_result['AttendanceResult']['working_day'], 'sales >' => '400000')
			));
			if($total_sales!=null){
				$special_fee += 500;
			}
		}

	}

	/*祝日一覧取得*/
	public function getHolidays(){
		// カレンダーID
		$calendar_id = urlencode('japanese__ja@holiday.calendar.google.com');
		// 取得期間
		$start  = date("Y-01-01\T00:00:00\Z");
		$end = date("Y-12-31\T00:00:00\Z");
		$url = "https://www.google.com/calendar/feeds/{$calendar_id}/public/basic?start-min={$start}&start-max={$end}&max-results=30&alt=json";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ;
		$result = curl_exec($ch);
		curl_close($ch);
		if (!empty($result)) {
			$json = json_decode($result, true);
			if (!empty($json['feed']['entry'])) {
				$datas = array();
				foreach ($json['feed']['entry'] as $val) {
					$date = preg_replace('#\A.*?(2\d{7})[^/]*\z#i', '$1', $val['id']['$t']);
					$datas[$date] = array(
						'date' => preg_replace('/\A(\d{4})(\d{2})(\d{2})/', '$1/$2/$3', $date),
						'title' => $val['title']['$t'],
					);
				}
				ksort($datas);
				return $datas;
			}
		}
	}

	public function get_holidays(){
		$holidays = array();
		$path = WWW_ROOT."files".DS."log".DS."holiday.log";
		$file_array = file($path);
		for($i=0;$i<count($file_array);$i++){
			if($file_array[$i]){
				$file_array[$i] = str_replace(array("\r\n","\r","\n"),'',$file_array[$i]);
				$val = explode(',',$file_array[$i]);
				$holidays["$val[1]"] = $val[0];
			}
		}
		return $holidays;
	}

}
