<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 18/02/07
 * Time: 14:48
 */
class LaborRecordsController extends AppController{

    # 共通スクリプト
    public function beforeFilter(){
        parent::beforeFilter();
        $this->set('title_for_layout', '勤怠連携 | 寿し和');
        #ログイン処理
        $this->to_login();
    }

    public function index(){
        if ($this->request->is('post')) {
            # クッキー値
            $location = $this->myData;
            # FileInfo
            $tmp = $this->request->params['form']['file']['tmp_name'];
            $name = $this->request->params['form']['file']['name'];
            # 店舗条件分岐
            if ($location['Location']['name'] == '池袋店' || $location['Location']['name'] == '赤羽店') {
                # Airレジ出力CSV連携
                if (mb_substr($name, 0, 5, "UTF-8") == '概算人件費') {
                    #アップロード処理
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    $save_path = WWW_ROOT . "files" . DS . "csv" . DS . $name;
                    if (is_uploaded_file($tmp)) {
                        if ($ext == 'CSV' || $ext == 'csv') {
                            if (move_uploaded_file($tmp, $save_path)) {
                                $handle = fopen($save_path, "r");
                                if ($handle !== false) {
                                    # Data格納
                                    $records = [];
                                    while (($line = fgetcsv($handle, 1000, ",")) !== false) {
                                        if ($line[0] != null) {
                                            $records[] = $line;
                                        }
                                    }
                                    fclose($handle);
                                    #エンコードエラー
                                    if ($records == null) {
                                        echo "Error:Character Encoding Error";
                                        exit;
                                    } else {
                                        #文字エンコード変換（SJIS=>UTF-8）
                                        mb_convert_variables('UTF-8', 'SJIS', $records);
                                    }
                                    # 不要カラム削除
                                    unset($records[0]);
                                    if($records!=null){
                                        foreach($records as $record){
                                            $member_id = $record[0];
                                            $member = $this->Member->findById($member_id);
                                            $working_day = date('Y-m-d', strtotime($record[2]));
                                            # 既存チェック
                                            $attendance_result = $this->AttendanceResult->find('first', [
                                                'conditions' => ['AttendanceResult.working_day' => $working_day, 'AttendanceResult.member_id' => $member_id]
                                            ]);
                                            if($attendance_result==null){
                                                $start_date_time = $this->Attendance->judge24HourString($working_day, $record[3]);
                                                $end_date_time = $this->Attendance->judge24HourString($working_day, $record[4]);
                                                $break = $record[5];
                                                $late_hours = $record[8];
                                                $hours = $record[6]-$late_hours;
                                                if($record[14]<0){ $makanai = 1; } else{ $makanai = 0; }
                                                $day_hourly_wage = $member['Member']['hourly_wage'];
                                                # 新規インサート
                                                $insert = array('AttendanceResult' => array(
                                                    'location_id' => $location['Location']['id'],
                                                    'member_id' => $member_id,
                                                    'working_day' => $working_day,
                                                    'attendance_start' => $start_date_time,
                                                    'attendance_end' => $end_date_time,
                                                    'hours' => $hours,
                                                    'late_hours' => $late_hours,
                                                    'break' => $break,
                                                    'makanai' => $makanai,
                                                    'day_hourly_wage' => $day_hourly_wage,
                                                ));
                                                $this->AttendanceResult->create(false);
                                                $this->AttendanceResult->save($insert);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $this->Session->setFlash('Import完了しました');
            $this->redirect(array('controller' => 'locations', 'action' => 'index'));
        }
    }

}