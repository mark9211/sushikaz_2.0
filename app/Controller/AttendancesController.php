<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 16:01
 */
class AttendancesController extends AppController{

	# 使用コンポーネント
	public $components = array('Notification');

	#共通スクリプト
	public function beforeFilter(){
		parent::beforeFilter();
		$this->set('title_for_layout', 'タイムカード | 寿し和');
		$this->to_login();
	}

	# 従業員選択画面
	public function index(){
		$location_id=$this->myData['Location']['id'];
		#営業日取得
		$working_day = $this->Attendance->judge24Hour(time());
		$this->set('working_day', $working_day);
		#従業員取得
		$members=$this->Member->find('all', array(
			'conditions' => array('Member.location_id' => $location_id, 'Member.status' => 'active')
		));
		#従業員雇用形態
		$member_types = array();
		#勤務状態取得
		$member_flags = array();
		foreach($members as $member){
			$member_types[$member['Type']['id']] = $member['Type']['name'];
			$member_flags[$member['Member']['id']] = $this->Attendance->judgeJobState($working_day, $member['Member']['id'], $location_id);
		}
		$this->set('members', $members);
		$this->set('member_flags', $member_flags);
		$this->set('member_types', $member_types);
		#従業員雇用形態（数）
		$this->set('member_type_num', count($member_types));
	}

	#勤怠画面
	public function view(){
		$this->layout = 'simple';
		if($this->request->is('get')){
			#従業員情報
			$member = $this->Member->findById($this->params['url']['id']);
			$this->set('member', $member);
			#勤務状態
			$this->set('flag', $this->params['url']['flag']);
		}elseif($this->request->is('post')){
			#クッキー値
			$location_id=$this->myData['Location']['id'];
			#営業日取得
			$working_day = $this->Attendance->judge24Hour(time());
			#勤怠状態取得
			$attendance_type = $this->AttendanceType->find('first', array(
				'conditions' => array('name' => $this->request->data['state'])
			));
			if($attendance_type==null){
				throw new NotFoundException('不正なエラーが発生しました。担当者にお知らせください。');
			}
			#時間調整（15分毎）
			$time = $this->Attendance->timeOrganizer($this->request->data['state'], time());
			$data = array('Attendance' => array(
				'location_id' => $location_id,
				'member_id' => $this->request->data['member_id'],
				'working_day' => $working_day,
				'type_id' => $attendance_type['AttendanceType']['id'],
				'time' => $time
			));
			$this->Attendance->save($data);
			$this->Session->setFlash("完了しました！", 'sessions/flash_success');
			$this->redirect(array('controller'=>'locations', 'action'=>'index'));
		}
	}

	#勤怠管理
	public function edit(){
		if($this->request->is('get')){
			#リファラチェック
			if($this->referer()=='/'){
				throw new NotFoundException('このページは見つかりませんでした');
			}
			#クッキー値
			$location_id=$this->myData['Location']['id'];
			#営業日
			$working_day = $this->params['url']['date'];
			$this->set('working_day', $working_day);
			#従業員取得
			$members=$this->Member->find('all', array(
				'conditions' => array('Member.location_id' => $location_id, 'Member.status' => 'active')
			));
			$arr = array();
			foreach($members as $member){
				$member_id=$member['Member']['id'];
				#勤務記録
				$attendances = $this->Attendance->find('all', array(
					'conditions' => array('Attendance.working_day' => $working_day, 'Attendance.location_id' => $location_id, 'Attendance.member_id' => $member_id),
					'order' => array('Attendance.created' => 'asc')
				));
				if($attendances!=null){
					#20160609
					foreach($attendances as $attendance){
						$type_id=$attendance['Attendance']['type_id'];
						if($type_id==1||$type_id==2){
							$arr[$member_id][$type_id] = $attendance;
						}
						else{
							$arr[$member_id]['break'][] = $attendance;
						}
					}
					#まかない取得
					$this->loadModel("AttendanceResult");
					$attendance_result = $this->AttendanceResult->find('first', array(
						'conditions' => array('AttendanceResult.working_day'=>$working_day, 'AttendanceResult.location_id'=>$location_id, 'AttendanceResult.member_id'=>$member_id)
					));
					if($attendance_result!=null){
						$arr[$member_id]['makanai'] = $attendance_result['AttendanceResult']['makanai'];
					}
				}
			}
			$this->set('attendances', $arr);
			$this->set('members', $members);
		}
	}

	#削除
	public function delete(){
		if($this->request->is('get')){
			#リファラチェック
			if($this->referer()=='/'){
				throw new NotFoundException('このページは見つかりませんでした');
			}
			if(isset($this->params['url']['id'])){
				$this->Attendance->delete($this->params['url']['id'], false);
				if(isset($this->params['url']['id_two'])){
					$this->Attendance->delete($this->params['url']['id_two'], false);
					if(isset($this->params['url']['id_three'])&&isset($this->params['url']['id_four'])){
						$this->Attendance->delete($this->params['url']['id_three'], false);
						$this->Attendance->delete($this->params['url']['id_four'], false);
					}
				}
				$this->Session->setFlash("出退勤の削除が完了しました", 'sessions/flash_success');
				$this->redirect($this->referer());
			}else{
				throw new NotFoundException('このページは見つかりませんでした');
			}
		}
	}

	#追加andResult
	public function add(){
		if($this->request->is('post')){
			#debug($this->request->data);exit;
			#クッキー値
			$location_id=$this->myData['Location']['id'];
			$working_day = $this->request->data['working_day'];
			if(isset($this->request->data['AttendanceResult'])){
				foreach($this->request->data['AttendanceResult'] as $key => $attendance_result){
					//////////Update/////////////////////////////////////Update///////////////////////////
					#出勤
					$check_in_time = $attendance_result['attendance_start'][key($attendance_result['attendance_start'])];
					$data = array('Attendance' => array(
						'id' => key($attendance_result['attendance_start']),
						'time' => $check_in_time
					));
					$this->Attendance->create(false);$this->Attendance->save($data);
					#new退勤
					if(isset($attendance_result['attendance_end']['new'])){
						$data = array('Attendance' => array(
							'location_id' => $location_id,
							'member_id' => $key,
							'working_day' => $working_day,
							'type_id' => 2,
							'time' => $attendance_result['attendance_end']['new']
						));
						$this->Attendance->create(false);$this->Attendance->save($data);
						$check_out_time = $attendance_result['attendance_end']['new'];
					}else{
						$check_out_time = $attendance_result['attendance_end'][key($attendance_result['attendance_end'])];
						$data = array('Attendance' => array(
							'id' => key($attendance_result['attendance_end']),
							'time' => $check_out_time
						));
						$this->Attendance->create(false);$this->Attendance->save($data);
					}
					#休憩時間
					$break_arr = array();
					if(isset($attendance_result['break']['new'])){
						$i=0;
						foreach($attendance_result['break']['new'] as $break){
							if($break!=null){
								$i++;
								if($i%2!=0){
									$data = array('Attendance' => array(
										'location_id' => $location_id,
										'member_id' => $key,
										'working_day' => $working_day,
										'type_id' => 3,
										'time' => $break
									));
								}
								else{
									$data = array('Attendance' => array(
										'location_id' => $location_id,
										'member_id' => $key,
										'working_day' => $working_day,
										'type_id' => 4,
										'time' => $break
									));
								}
								$this->Attendance->create(false);$this->Attendance->save($data);
								$break_arr[] = $break;
							}
						}
					}
					else{
						# 2017/05/11
						if($attendance_result['break']!=null){
							if(count($attendance_result['break'])%2!=0){ array_pop($attendance_result['break']); }
							foreach($attendance_result['break'] as $id => $break){
								$data = array('Attendance' => array(
									'id' => $id,
									'time' => $break
								));
								$this->Attendance->create(false);$this->Attendance->save($data);
								$break_arr[] = $break;
							}
						}
					}
					#時間数計算
					$hours = $this->Attendance->diffCalculator($working_day,$check_in_time,$check_out_time, $break_arr);
					#現時点での給与
					$member = $this->Member->findById($key);
					#既存かどうか
					$already_result = $this->AttendanceResult->find('first', array(
						'conditions' => array('AttendanceResult.location_id'=>$location_id, 'member_id'=>$key, 'working_day'=>$working_day)
					));
					if($already_result==null){
						$data = array('AttendanceResult' => array(
							'location_id' => $location_id,
							'member_id' => $key,
							'working_day' => $working_day,
							'attendance_start' => $check_in_time,
							'attendance_end' => $check_out_time,
							'hours' => $hours['normal_hours'],
							'late_hours' => $hours['late_hours'],
							'makanai' => $attendance_result['makanai'],
							'day_hourly_wage' => $member['Member']['hourly_wage']
						));
					}else{
						$data = array('AttendanceResult' => array(
							'id' => $already_result['AttendanceResult']['id'],
							'attendance_start' => $check_in_time,
							'attendance_end' => $check_out_time,
							'hours' => $hours['normal_hours'],
							'late_hours' => $hours['late_hours'],
							'makanai' => $attendance_result['makanai']
						));
					}
					$this->AttendanceResult->create(false);
					if(!$this->AttendanceResult->save($data)){ var_dump($data);var_dump($this->AttendanceResult->validationErrors); }
				}
			}
			#新規
			foreach($this->request->data['NewAttendanceResult'] as $new_attendance_result){
				#空判定
				if($new_attendance_result['member_id']!=null&&$new_attendance_result['attendance_start']!=null&&$new_attendance_result['attendance_end']!=null){
					#現時点の時給取得
					$member = $this->Member->findById($new_attendance_result['member_id']);
					#既存かどうか
					$already_result = $this->AttendanceResult->find('first', array(
						'conditions' => array('AttendanceResult.location_id'=>$location_id, 'member_id'=>$new_attendance_result['member_id'], 'working_day'=>$working_day)
					));
					#休憩ありなし＝＞時間差分計算
					if($new_attendance_result['attendance_start_break']==null||$new_attendance_result['attendance_end_break']==null){
						$hours = $this->Attendance->twoDiffCalculator($working_day, $new_attendance_result['attendance_start'], $new_attendance_result['attendance_end']);
					}
					else{
						$hours = $this->Attendance->fourDiffCalculator($working_day,$new_attendance_result['attendance_start'],$new_attendance_result['attendance_start_break'],$new_attendance_result['attendance_end_break'],$new_attendance_result['attendance_end']);
					}
					if($already_result==null){
						$data = array('AttendanceResult' => array(
							'location_id' => $location_id,
							'member_id' => $new_attendance_result['member_id'],
							'working_day' => $working_day,
							'attendance_start' => $new_attendance_result['attendance_start'],
							'attendance_end' => $new_attendance_result['attendance_end'],
							'hours' => $hours['normal_hours'],
							'late_hours' => $hours['late_hours'],
							'makanai' => $new_attendance_result['makanai'],
							'day_hourly_wage' => $member['Member']['hourly_wage']
						));
						$this->AttendanceResult->create(false);
						if(!$this->AttendanceResult->save($data)){ var_dump($data);var_dump($this->AttendanceResult->validationErrors); }
					}/*
					else{
						$data = array('AttendanceResult' => array(
							'id' => $already_result['AttendanceResult']['id'],
							'attendance_start' => $new_attendance_result['attendance_start'],
							'attendance_end' => $new_attendance_result['attendance_end'],
							'hours' => $hours['normal_hours'],
							'late_hours' => $hours['late_hours']
						));
						$this->AttendanceResult->save($data);
					}
					*/
				}
			}
			# Slack通知
			$text = $this->myData['Location']['name'].$this->request->data['working_day']."勤怠データが送信されました";
			$this->Notification->slack_notify($text);
			# Redirect
			$this->Session->setFlash("勤怠管理を受け付けました。", 'sessions/flash_success');
			$this->redirect(array('controller' => 'sales', 'action' => 'view', '?' => array('date' => $this->request->data['working_day'])));
		}
	}

}
