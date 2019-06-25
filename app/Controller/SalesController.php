<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/09
 * Time: 12:47
 */
#Zaim用Oauth認証ライブラリ
App::import('Vendor', 'OAuth/OAuthClient');

class SalesController extends AppController{

	#共通スクリプト
	public function beforeFilter(){
		#ページタイトル設定
		parent::beforeFilter();
		$this->set('title_for_layout', '日報入力 | 寿し和');
		#ログイン処理
		$this->to_login();
	}

	#インデックス
	public function index(){
		if($this->request->is('get')){
			#クッキー値
			$location = $this->myData;
			#営業日
			$working_day = $this->params['url']['date'];
			$this->set('working_day', $working_day);
			#支出種類
			$expense_types = $this->ExpenseType->find('all', array(
				'conditions' => array('ExpenseType.location_id' => $location['Location']['id'])
			));
			$this->set('expense_types', $expense_types);
			#全従業員
			$members = $this->Member->find('all', array(
				'conditions' => array('Member.location_id' => $location['Location']['id'], 'Member.status' => 'active')
			));
			$this->set('members', $members);
			#宴会コース種類
			$party_types = $this->PartyType->find('all', array(
				'conditions' => array('PartyType.location_id' => $location['Location']['id'])
			));
			$this->set('party_types', $party_types);
			#伝票内訳
			$slip_types = $this->SlipType->find('all', array(
				'conditions' => array('SlipType.location_id' => $location['Location']['id'])
			));
			#20150723-休業日設定
			$new_working_day = $this->Holiday->beforeWorkingDayIs($working_day, $location['Location']['id']);
			#既存データ補完
			$slip_arr = array();
			foreach($slip_types as $slip_type){
				$slip_type['Before'] = $this->SlipNumber->getByLocationDayType($location['Location']['id'], $new_working_day, $slip_type['SlipType']['id']);
				$slip_type['Today'] = $this->SlipNumber->getByLocationDayType($location['Location']['id'], $working_day, $slip_type['SlipType']['id']);
				$slip_arr[] = $slip_type;
			}
			$this->set('slip_types', $slip_arr);
			#買掛種類
			$account_types = $this->AccountType->find('all', array(
				'conditions' => array('AccountType.location_id' => $location['Location']['id'])
			));
			#既存データ補完
			$account_arr = array();
			foreach($account_types as $account_type){
				$account_type['Today'] = $this->PayableAccount->getByLocationDayType($location['Location']['id'], $working_day, $account_type['AccountType']['id']);
				$account_arr[] = $account_type;
			}
			$this->set('account_types', $account_arr);
			########################################既存データの補完########################################
			#支出
			$expenses = $this->Expense->find('all', array(
				'conditions' => array('Expense.location_id' => $location['Location']['id'], 'working_day' => $working_day)
			));
			if($expenses!=null){
				$this->set('expenses', $expenses);
			}
			#その他情報
			$other_informations = $this->OtherInformation->find('first', array(
				'conditions' => array('OtherInformation.location_id' => $location['Location']['id'], 'working_day' => $working_day)
			));
			if($other_informations!=null){
				$this->set('other_informations', $other_informations);
			}
			#宴会情報
			$party_informations = $this->PartyInformation->find('all', array(
				'conditions' => array('PartyInformation.location_id' => $location['Location']['id'], 'working_day' => $working_day)
			));
			if($party_informations!=null){
				$this->set('party_informations', $party_informations);
			}
			#売掛集金
			$add_cashes = $this->AddCash->find('all', array(
				'conditions' => array('AddCash.location_id' => $location['Location']['id'], 'AddCash.working_day' => $working_day)
			));
			if($add_cashes!=null){
				$this->set('add_cashes', $add_cashes);
			}
		}
	}

	#フォーム入力内容
	public function add(){
		if($this->request->is('post')){
			//debug($this->request->data);exit;
			#クッキー値
			$location = $this->myData;
			#支出新規
			if(isset($this->request->data['new_expense'])){
				foreach($this->request->data['new_expense'] as $new_expense){
					#validation
					if($new_expense['product_name']!=null&&$new_expense['store_name']!=null&&$new_expense['fee']!=null&&is_numeric($new_expense['fee'])&&$new_expense['type_id']!=null){
						$data = array('Expense' => array(
							'location_id' => $location['Location']['id'],
							'type_id' => $new_expense['type_id'],
							'working_day' => $this->request->data['working_day'],
							'store_name' => $new_expense['store_name'],
							'product_name' => $new_expense['product_name'],
							'fee' => $new_expense['fee']
						));
						#ループ実行文
						$this->Expense->create(false);
						$this->Expense->save($data);
					}
				}
			}
			#支出既存
			if(isset($this->request->data['expense'])){
				foreach($this->request->data['expense'] as $key => $expense){
					#validation
					if($expense['product_name']!=null&&$expense['store_name']!=null&&$expense['fee']!=null&&is_numeric($expense['fee'])&&$expense['type_id']!=null) {
						$data = array('Expense' => array(
							'id' => $key,
							'location_id' => $location['Location']['id'],
							'type_id' => $expense['type_id'],
							'working_day' => $this->request->data['working_day'],
							'store_name' => $expense['store_name'],
							'product_name' => $expense['product_name'],
							'fee' => $expense['fee']
						));
						#ループ実行文
						$this->Expense->create(false);
						$this->Expense->save($data);
					}
				}
			}
			#その他情報
			if(!isset($this->request->data['OtherInformation']['id'])){
				#新規
				$data = array('OtherInformation' => array(
					'location_id' => $location['Location']['id'],
					'working_day' => $this->request->data['working_day'],
					'member_id' => $this->request->data['OtherInformation']['member_id'],
					'weather' => $this->request->data['OtherInformation']['weather'],
					'absence_one_id' => $this->request->data['OtherInformation']['absence_one_id'],
					'absence_two_id' => $this->request->data['OtherInformation']['absence_two_id'],
					'absence_three_id' => $this->request->data['OtherInformation']['absence_three_id'],
					'notes' => $this->request->data['OtherInformation']['notes'],
				));
			}else{
				#既存
				$data = array('OtherInformation' => array(
					'id' => $this->request->data['OtherInformation']['id'],
					'location_id' => $location['Location']['id'],
					'working_day' => $this->request->data['working_day'],
					'member_id' => $this->request->data['OtherInformation']['member_id'],
					'weather' => $this->request->data['OtherInformation']['weather'],
					'absence_one_id' => $this->request->data['OtherInformation']['absence_one_id'],
					'absence_two_id' => $this->request->data['OtherInformation']['absence_two_id'],
					'absence_three_id' => $this->request->data['OtherInformation']['absence_three_id'],
					'notes' => $this->request->data['OtherInformation']['notes'],
				));
			}
			$this->OtherInformation->save($data);
			#伝票番号
			if(isset($this->request->data['slip'])){
				foreach($this->request->data['slip'] as $key => $slip_number){
					#validation
					if($slip_number['start_number']!=null&&is_numeric($slip_number['start_number'])&&$slip_number['end_number']!=null&&is_numeric($slip_number['end_number'])){
						if($slip_number['id']==null){
							#新規
							$data = array('SlipNumber' => array(
								'location_id' => $location['Location']['id'],
								'type_id' => $key,
								'working_day' => $this->request->data['working_day'],
								'start_number' => $slip_number['start_number'],
								'end_number' => $slip_number['end_number']
							));
						}else{
							#既存
							$data = array('SlipNumber' => array(
								'id' => $slip_number['id'],
								'start_number' => $slip_number['start_number'],
								'end_number' => $slip_number['end_number']
							));
						}
						#ループ実行文
						$this->SlipNumber->create(false);
						$this->SlipNumber->save($data);
					}
				}
			}
			#宴会新規
			if(isset($this->request->data['new_party'])){
				foreach($this->request->data['new_party'] as $new_party){
					#validation
					if($new_party['customer_name']!=null&&$new_party['customer_count']!=null&&is_numeric($new_party['customer_count'])&&$new_party['starting_time']!=null&&$new_party['type_id']!=null){
						$data = array('PartyInformation' => array(
							'location_id' => $location['Location']['id'],
							'type_id' => $new_party['type_id'],
							'working_day' => $this->request->data['working_day'],
							'starting_time' => $new_party['starting_time'],
							'customer_count' => $new_party['customer_count'],
							'customer_name' => $new_party['customer_name']
						));
						#ループ実行文
						$this->PartyInformation->create(false);
						$this->PartyInformation->save($data);
					}
				}
			}
			#宴会既存
			if(isset($this->request->data['party'])){
				foreach($this->request->data['party'] as $key => $party){
					if($party['customer_name']!=null&&$party['customer_count']!=null&&is_numeric($party['customer_count'])&&$party['starting_time']!=null&&$party['type_id']!=null) {
						$data = array('PartyInformation' => array(
							'id' => $key,
							'location_id' => $location['Location']['id'],
							'type_id' => $party['type_id'],
							'working_day' => $this->request->data['working_day'],
							'starting_time' => $party['starting_time'],
							'customer_count' => $party['customer_count'],
							'customer_name' => $party['customer_name']
						));
						#ループ実行文
						$this->PartyInformation->create(false);
						$this->PartyInformation->save($data);
					}
				}
			}
			#売掛集金新規
			if(isset($this->request->data['new_addCash'])){
				foreach($this->request->data['new_addCash'] as $new_addCash){
					if($new_addCash['name']!=null&&$new_addCash['fee']!=null&&is_numeric($new_addCash['fee'])){
						$data = array('AddCash' => array(
							'location_id' => $location['Location']['id'],
							'working_day' => $this->request->data['working_day'],
							'name' => $new_addCash['name'],
							'fee' => $new_addCash['fee']
						));
						#ループ実行文
						$this->AddCash->create(false);
						$this->AddCash->save($data);
					}
				}
			}
			#売掛集金既存
			if(isset($this->request->data['addCash'])){
				foreach($this->request->data['addCash'] as $key => $addCash){
					if($addCash['name']!=null&&$addCash['fee']!=null&&is_numeric($addCash['fee'])) {
						$data = array('AddCash' => array(
							'id' => $key,
							'name' => $addCash['name'],
							'fee' => $addCash['fee']
						));
						#ループ実行文
						$this->AddCash->create(false);
						$this->AddCash->save($data);
					}
				}
			}
			#買掛管理
			if(isset($this->request->data['account'])){
				foreach($this->request->data['account'] as $key => $account){
					#validation
					if($account['fee']!=null&&is_numeric($account['fee'])){
						#既存か新規か
						if($account['id']==null){   //新規
							$data = array('PayableAccount' => array(
								'location_id' => $location['Location']['id'],
								'working_day' => $this->request->data['working_day'],
								'type_id' => $key,
								'fee' => $account['fee']
							));
						}else{  //既存
							$data = array('PayableAccount' => array(
								'id' => $account['id'],
								'fee' => $account['fee']
							));
						}
						#ループ実行文
						$this->PayableAccount->create(false);
						$this->PayableAccount->save($data);
					}
				}
			}
			$this->Session->setFlash("日報を受け付けました");
			$this->redirect(array('controller' => 'sales', 'action' => 'view', '?' => array('date' => $this->request->data['working_day'])));
		}
	}

	#クレジット削除
	public function credit_delete(){
		if($this->request->is('get')){
			#リファラチェック
			if($this->referer()=='/'){
				throw new NotFoundException('このページは見つかりませんでした');
			}
			if(isset($this->params['url']['id'])){
				$this->CreditSales->delete($this->params['url']['id'], false);
				$this->Session->setFlash("クレジットカード売上の削除が完了しました");
				$this->redirect($this->referer());
			}
		}
	}
	#クーポン削除
	public function coupon_delete(){
		if($this->request->is('get')){
			#リファラチェック
			if($this->referer()=='/'){
				throw new NotFoundException('このページは見つかりませんでした');
			}
			if(isset($this->params['url']['id'])){
				$this->CouponDiscount->delete($this->params['url']['id'], false);
				$this->Session->setFlash("クーポン情報の削除が完了しました");
				$this->redirect($this->referer());
			}
		}
	}
	#その他割引削除
	public function discount_delete(){
		if($this->request->is('get')){
			#リファラチェック
			if($this->referer()=='/'){
				throw new NotFoundException('このページは見つかりませんでした');
			}
			if(isset($this->params['url']['id'])){
				$this->OtherDiscount->delete($this->params['url']['id'], false);
				$this->Session->setFlash("その他割引の削除が完了しました");
				$this->redirect($this->referer());
			}
		}
	}
	#支出削除
	public function expense_delete(){
		if($this->request->is('get')){
			#リファラチェック
			if($this->referer()=='/'){
				throw new NotFoundException('このページは見つかりませんでした');
			}
			if(isset($this->params['url']['id'])){
				$this->Expense->delete($this->params['url']['id'], false);
				$this->Session->setFlash("支出の削除が完了しました");
				$this->redirect($this->referer());
			}
		}
	}
	#宴会削除
	public function party_delete(){
		if($this->request->is('get')){
			#リファラチェック
			if($this->referer()=='/'){
				throw new NotFoundException('このページは見つかりませんでした');
			}
			if(isset($this->params['url']['id'])){
				$this->PartyInformation->delete($this->params['url']['id'], false);
				$this->Session->setFlash("宴会の削除が完了しました");
				$this->redirect($this->referer());
			}
		}
	}
	#売掛集金
	public function addCash_delete(){
		if($this->request->is('get')){
			#リファラチェック
			if($this->referer()=='/'){
				throw new NotFoundException('このページは見つかりませんでした');
			}
			if(isset($this->params['url']['id'])){
				$this->AddCash->delete($this->params['url']['id'], false);
				$this->Session->setFlash("売掛集金の削除が完了しました");
				$this->redirect($this->referer());
			}
		}
	}

	#日報一覧
	public function view(){
		if($this->request->is('get')){
			#営業日
			$working_day = $this->params['url']['date'];
			$this->set('working_day', $working_day);
			#クッキー値
			$location = $this->myData;
			#売上/客数/客単
			$brand_summaries = $this->ReceiptSummary->brandSummarize($location['Location']['id'], $working_day);
			debug($brand_summaries);
			$new_brand_summaries = [];
			if($brand_summaries!=null){
				foreach($brand_summaries as $brand_name => $brand_summary){
					$brand_summary['Breakdown'] = $this->ReceiptSummary->breakdownSummarize($location['Location']['id'], $working_day, $brand_name);
					$new_brand_summaries[$brand_name] = $brand_summary;
				}
			}
			$this->set('summaries', $new_brand_summaries);
			#売掛データ
			$credit_data = $this->ReceiptSummary->creditData($location['Location']['id'], $working_day);
			$this->set('credit_data', $credit_data);
			#金券データ
			$voucher_data = $this->ReceiptSummary->voucherData($location['Location']['id'], $working_day);
			$this->set('voucher_data', $voucher_data);
			#割引/割増データ
			$discount_data = $this->ReceiptSummary->discountData($location['Location']['id'], $working_day);
			$this->set('discount_data', $discount_data);
			#税集計
			$tax_daily = $this->ReceiptSummary->taxDaily($location['Location']['id'], $working_day);
			$this->set('tax_daily', $tax_daily);
			#支出種類
			$expense_types = $this->ExpenseType->find('all', array(
				'conditions' => array('ExpenseType.location_id' => $location['Location']['id'])
			));
			$this->set('expense_types', $expense_types);
			#全従業員
			$members = $this->Member->getMemberByLocationId($location['Location']['id']);
			$this->set('members', $members);
			#宴会コース種類
			$party_types = $this->PartyType->find('all', array(
				'conditions' => array('PartyType.location_id' => $location['Location']['id'])
			));
			$this->set('party_types', $party_types);
			#伝票内訳
			$slip_types = $this->SlipType->find('all', array(
				'conditions' => array('SlipType.location_id' => $location['Location']['id'])
			));
			$this->set('slip_types', $slip_types);
			#売掛集金
			$add_cashes = $this->AddCash->find('all', array(
				'conditions' => array('AddCash.location_id' => $location['Location']['id'], 'AddCash.working_day' => $working_day)
			));
			if($add_cashes!=null){
				$this->set('add_cashes', $add_cashes);
			}
			#支出
			$expenses = $this->Expense->find('all', array(
				'conditions' => array('Expense.location_id' => $location['Location']['id'], 'working_day' => $working_day)
			));
			if($expenses!=null){
				$this->set('expenses', $expenses);
			}
			#その他情報
			$other_informations = $this->OtherInformation->find('first', array(
				'conditions' => array('OtherInformation.location_id' => $location['Location']['id'], 'working_day' => $working_day)
			));
			if($other_informations!=null){
				$this->set('other_informations', $other_informations);
				$absences = array();
				$absences["one"] = $this->Member->find('first', array(
					'conditions' => array('Member.id' => $other_informations['OtherInformation']['absence_one_id'])
				));
				$absences["two"] = $this->Member->find('first', array(
					'conditions' => array('Member.id' => $other_informations['OtherInformation']['absence_two_id'])
				));
				$absences["three"] = $this->Member->find('first', array(
					'conditions' => array('Member.id' => $other_informations['OtherInformation']['absence_three_id'])
				));
				$this->set('absences', $absences);
			}
			#伝票番号
			$slip_numbers = $this->SlipNumber->find('all', array(
				'conditions' => array('SlipNumber.location_id' => $location['Location']['id'], 'working_day' => $working_day)
			));
			if($slip_numbers!=null){
				$this->set('slip_numbers', $slip_numbers);
				#出前数算出
				foreach($slip_numbers as $slip_number){
					if($slip_number['Type']['name'] == "出前"){
						$num_demae = $slip_number['SlipNumber']['end_number'] - $slip_number['SlipNumber']['start_number'] + 1;
						$this->set('num_demae', $num_demae);
					}
				}
			}
			#宴会情報
			$party_informations = $this->PartyInformation->find('all', array(
				'conditions' => array('PartyInformation.location_id' => $location['Location']['id'], 'working_day' => $working_day)
			));
			if($party_informations!=null){
				$this->set('party_informations', $party_informations);
			}
			#出勤記録
			$this->AttendanceResult->recursive = 2;
			$attendance_results = $this->AttendanceResult->find('all', array(
				'conditions' => array(
					'AttendanceResult.location_id' => $location['Location']['id'],
					'AttendanceResult.working_day' => $working_day,
					'not' => array('Member.id' => null)
				),
				'order' => Array('AttendanceResult.attendance_start' => 'asc')
			));
			# 総労働時間計算
			$working_hours = $this->AttendanceResult->daily_total_working_hours($location['Location']['id'], $working_day);
			$this->set('working_hours', $working_hours);
			#勤務時間帯挿入（ランチorディナー）
			$new_attendance_results = array();
			foreach($attendance_results as $attendance_result){
				$attendance_result['timezone'] = $this->AttendanceResult->judgeLunchDinner($attendance_result);
				# 休憩時間
				$hours = (strtotime($attendance_result['AttendanceResult']['attendance_end']) - strtotime($attendance_result['AttendanceResult']['attendance_start'])) / (60 * 60);
				$hours = $hours - $attendance_result['AttendanceResult']['hours'] - $attendance_result['AttendanceResult']['late_hours'];
				$attendance_result['break'] = $hours;
				$new_attendance_results[] = $attendance_result;
			}
			$this->set('attendance_results', $new_attendance_results);
			#日次L高
			$labor_cost = $this->Payroll->laborCostCalculator($attendance_results, date('t', strtotime($working_day)));
			$this->set('labor_cost', $labor_cost);
		}
	}

	#月末報告
	public function monthly_report(){
		if($this->request->is('post')){
			#クッキー値
			$location = $this->myData;
			if($this->request->data['month']==null){
				debug("月が入力されていません");exit;
			}
			// // エクセル出力用ライブラリ
			App::import('Vendor', 'PHPExcel/Classes/PHPExcel');
			App::import('Vendor', 'PHPExcel/Classes/PHPExcel/IOFactory');
			// Excel2007形式(xlsx)テンプレートの読み込み
			$reader = PHPExcel_IOFactory::createReader('Excel2007');
			$template = realpath(TMP);
			$template .= '/excel/';
			#曜日配列
			$weekday = array( "日", "月", "火", "水", "木", "金", "土" );
			if($this->request->data['data_type']==1){
				//店舗毎エクセルシート切り替え
				if($location['Location']['name']=='池袋店'){
					$data_name = 'monthly-report-sales-ikebukuro';
				}elseif($location['Location']['name']=='赤羽店'){
					$data_name = 'monthly-report-sales-akabane';
				}elseif($location['Location']['name']=='和光店'){
					$data_name = 'monthly-report-sales-wako';
				}else{
					echo "Error : 404";
					exit;
				}
				$templatePath = $template.$data_name.'.xlsx';
				$obj = $reader->load($templatePath);
				######################################２店舗用###############################################
				if($location['Location']['name']=='和光店'){
					for ($i=1; $i <= 31; $i++) {
						$working_day = $this->request->data['month'] . '-' . $i;
						$day = $weekday[date('w', strtotime($working_day))];
						$row_number = date('j', strtotime($working_day)) + 4;
						#売上内訳
						$this->Sales->recursive = 2;
						$sales = $this->Sales->find('all', array(
							'conditions' => array('Sales.location_id' => $location['Location']['id'], 'Sales.working_day' => $working_day)
						));
						if($sales!=null){
							$attribute_sales = $this->Sales->diviseSushiYakinikuArray($sales);
							$divise_sales = $this->Sales->diviseSushiYakiniku($sales);
							#寿司
							$sushi_sales = array();
							$sushi_sales['itaba'] = 0;
							$sushi_sales['yakiba'] = 0;
							$sushi_sales['drink'] = 0;
							foreach($attribute_sales['寿司'] as $attribute_sales_one){
								#板場
								if($attribute_sales_one['Type']['name']=='板場売上'){
									$sushi_sales['itaba'] = $attribute_sales_one['Sales']['fee'];
								}
								#焼き場
								if($attribute_sales_one['Type']['name']=='焼場売上'){
									$sushi_sales['yakiba'] = $attribute_sales_one['Sales']['fee'];
								}
								#飲料
								if($attribute_sales_one['Type']['name']=='飲料売上'){
									$sushi_sales['drink'] = $attribute_sales_one['Sales']['fee'];
								}
								#共同（焼場に加算）
								if($attribute_sales_one['Type']['name']=='共同売上'){
									$sushi_sales['yakiba'] += $attribute_sales_one['Sales']['fee'];
								}
							}
							#焼肉
							$yakiniku_sales = array();
							$yakiniku_sales['chori'] = 0;
							$yakiniku_sales['drink'] = 0;
							foreach($attribute_sales['焼肉'] as $attribute_sales_one){
								#調理場
								if($attribute_sales_one['Type']['name']=='調理場売上'){
									$yakiniku_sales['chori'] = $attribute_sales_one['Sales']['fee'];
								}
								#飲料
								if($attribute_sales_one['Type']['name']=='飲料売上'){
									$yakiniku_sales['drink'] = $attribute_sales_one['Sales']['fee'];
								}
								#共同（調理場に加算）
								if($attribute_sales_one['Type']['name']=='共同売上'){
									$yakiniku_sales['chori'] += $attribute_sales_one['Sales']['fee'];
								}
							}
							#ランチ売上
							$sales_lunches = $this->SalesLunch->find('all', array(
								'conditions' => array('SalesLunch.location_id' => $location['Location']['id'], 'SalesLunch.working_day' => $working_day)
							));
							if($sales_lunches!=null){
								$lunch = array();
								$lunch['sushi'] = 0;
								$lunch['yakiniku'] = 0;
								foreach($sales_lunches as $sales_lunch){
									#寿司
									if($sales_lunch['Attribute']['name']=='寿司'){
										$lunch['sushi'] = $sales_lunch['SalesLunch']['fee'];
									}
									#焼肉
									if($sales_lunch['Attribute']['name']=='焼肉'){
										$lunch['yakiniku'] = $sales_lunch['SalesLunch']['fee'];
									}
								}
								#ディナー売上
								$dinner_sales = $this->Sales->calculateDinnerSales($sales_lunches, $divise_sales);
								#客数
								$this->CustomerCount->recursive = 2;
								$customer_counts = $this->CustomerCount->find('all', array(
									'conditions' => array('CustomerCount.location_id' => $location['Location']['id'], 'working_day' => $working_day)
								));
								$divise_customers = $this->CustomerCount->diviseLunchDinner($customer_counts);

								# 宴会人数 2017/02/28
								$party_cnt = 0;
								$party_information = $this->PartyInformation->find('all', array(
									'fields' => array('sum(PartyInformation.customer_count) as cnt'),
									'conditions' => array('PartyInformation.location_id' => $location['Location']['id'],'PartyInformation.working_day' => $working_day),
									'group' => array('PartyInformation.working_day'),
								));
								if($party_information!=null){ $party_cnt = $party_information[0]['cnt']; }

								//page 1
								$obj->setActiveSheetIndex(0)
									->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])))
									->setCellValue('C'.$row_number, $day)
									->setCellValue('D'.$row_number, floor($lunch['sushi']*1.08))
									->setCellValue('E'.$row_number, $divise_customers['lunch']['寿司'])
									->setCellValue('F'.$row_number, floor($dinner_sales['寿司']*1.08))
									->setCellValue('G'.$row_number, $divise_customers['dinner']['寿司'])
									->setCellValue('J'.$row_number, floor($sushi_sales['itaba']*1.08))
									->setCellValue('K'.$row_number, floor($sushi_sales['yakiba']*1.08))
									->setCellValue('L'.$row_number, floor($sushi_sales['drink']*1.08));
								//page 2
								$obj->setActiveSheetIndex(1)
									->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])))
									->setCellValue('C'.$row_number, $day)
									->setCellValue('D'.$row_number, floor($lunch['yakiniku']*1.08))
									->setCellValue('E'.$row_number, $divise_customers['lunch']['焼肉'])
									->setCellValue('F'.$row_number, floor($dinner_sales['焼肉']*1.08))
									->setCellValue('G'.$row_number, $divise_customers['dinner']['焼肉'])
									->setCellValue('J'.$row_number, floor($yakiniku_sales['chori']*1.08))
									->setCellValue('K'.$row_number, floor($yakiniku_sales['drink']*1.08));
								//page 3
								$obj->setActiveSheetIndex(2)
									->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])))
									->setCellValue('C'.$row_number, $day)
									->setCellValue('M'.$row_number, $party_cnt);
							}
						}
					}
					#########################################################################################
				}else{
					//年度と月
					$obj->setActiveSheetIndex(0)
						->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));
					#総売上取得
					$total_sales = $this->TotalSales->find('all', array(
						'conditions' => array('TotalSales.location_id' => $location['Location']['id'], 'TotalSales.working_day LIKE' => '%'.$this->request->data['month'].'%')
					));
					foreach ($total_sales as $total_sales_one) {
						#営業日
						$working_day = $total_sales_one['TotalSales']['working_day'];
						//曜日取得
						$day = $weekday[date('w', strtotime($working_day))];
						//開始番号設定
						$row_number = date('j', strtotime($working_day)) + 4;
						#伝票番号
						$maisu = 0;
						$slip_numbers = $this->SlipNumber->find('all', array(
							'conditions' => array('SlipNumber.location_id' => $location['Location']['id'], 'SlipNumber.working_day' => $working_day)
						));
						if($slip_numbers!=null){
							foreach($slip_numbers as $slip_number){
								if($slip_number['Type']['name']=='出前'){
									$maisu = $slip_number['SlipNumber']['end_number'] - $slip_number['SlipNumber']['start_number'] + 1;
								}
							}
						}
						#シート毎分岐
						if($location['Location']['name']=='池袋店'){
							$obj->setActiveSheetIndex(0)
								->setCellValue('C'.$row_number, $day)
								->setCellValue('E'.$row_number, $total_sales_one['TotalSales']['customer_counts'])
								->setCellValue('H'.$row_number, $total_sales_one['TotalSales']['demae_cnt']);
						}elseif($location['Location']['name']=='赤羽店'){
							$obj->setActiveSheetIndex(0)
								->setCellValue('C'.$row_number, $day)
								->setCellValue('E'.$row_number, $total_sales_one['TotalSales']['customer_counts'])
								->setCellValue('I'.$row_number, $maisu);
						}
						#内訳
						$tennai = 0;
						$demae = 0;
						$drink = 0;
						$itaba = 0;
						$cyubo = 0;
						$sales = $this->Sales->find('all', array(
							'conditions' => array('Sales.location_id' => $location['Location']['id'], 'Sales.working_day' => $working_day)
						));
						foreach($sales as $sales_one){
							if($sales_one['Type']['name']=='店内売上'){
								$tennai = $sales_one['Sales']['fee'];
							}elseif($sales_one['Type']['name']=='出前売上'){
								$demae = $sales_one['Sales']['fee'];
							}elseif($sales_one['Type']['name']=='飲料売上'){
								$drink = $sales_one['Sales']['fee'];
							}elseif($sales_one['Type']['name']=='板場売上'){
								$itaba = $sales_one['Sales']['fee'];
							}elseif($sales_one['Type']['name']=='厨房売上'){
								$cyubo = $sales_one['Sales']['fee'];
							}
						}

						#店舗毎分岐
						if($location['Location']['name']=='池袋店'){
							$obj->setActiveSheetIndex(0)
								->setCellValue('D'.$row_number, $tennai)
								->setCellValue('F'.$row_number, $drink)
								->setCellValue('G'.$row_number, $demae);
						}elseif($location['Location']['name']=='赤羽店'){
							$obj->setActiveSheetIndex(0)
								->setCellValue('D'.$row_number, $itaba)
								->setCellValue('F'.$row_number, $cyubo)
								->setCellValue('G'.$row_number, $drink)
								->setCellValue('H'.$row_number, $demae);
						}
					}
				}
			}
			elseif($this->request->data['data_type']==2){
				//店舗毎エクセルシート切り替え
				if($location['Location']['name']=='池袋店'){
					$data_name = 'monthly-report-expense-ikebukuro';
				}elseif($location['Location']['name']=='赤羽店'){
					$data_name = 'monthly-report-expense-akabane';
				}elseif($location['Location']['name']=='和光店'){
					$data_name = 'monthly-report-expense-wako';
				}
				else{
					echo "Error : 404";
					exit;
				}
				$templatePath = $template.$data_name.'.xlsx';
				$obj = $reader->load($templatePath);
				// 3シートを指定して、セルに書き込む
				//年度と月
				$obj->setActiveSheetIndex(0)
					->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));
				#客数取得
				$total_sales = $this->TotalSales->find('all', array(
					'conditions' => array('TotalSales.location_id' => $location['Location']['id'], 'TotalSales.working_day LIKE' => '%'.$this->request->data['month'].'%')
				));
				#支出カテゴリー
				$this->loadModel("ExpenseType");
				$expense_types = $this->ExpenseType->find('all', array(
					'conditions' => array('ExpenseType.location_id' => $location['Location']['id'])
				));
				$char = 'G';
				$expense_arr = array();
				foreach($expense_types as $expense_type){
					$obj->setActiveSheetIndex(0)
						->setCellValue($char.'4', $expense_type['ExpenseType']['name']);
					$expense_arr[$expense_type['ExpenseType']['id']] = $char;
					$char = ++$char;
				}
				#その他割引カテゴリー
				$this->loadModel("OtherType");
				$other_types = $this->OtherType->find('all', array(
					'conditions' => array('OtherType.location_id' => $location['Location']['id'])
				));
				$char = 'V';
				$other_arr = array();
				foreach($other_types as $other_type){
					$obj->setActiveSheetIndex(0)
						->setCellValue($char.'4', $other_type['OtherType']['name']);
					$other_arr[$other_type['OtherType']['id']] = $char;
					$char = ++$char;
				}
				#Excel入力
				foreach ($total_sales as $total_sales_one) {
					#営業日
					$working_day = $total_sales_one['TotalSales']['working_day'];
					//曜日取得
					$day = $weekday[date('w', strtotime($working_day))];
					//開始番号設定
					$row_number = date('j', strtotime($working_day)) + 4;

					$obj->setActiveSheetIndex(0)
						->setCellValue('C'.$row_number, $day)
						->setCellValue('D'.$row_number, $total_sales_one['TotalSales']['sales']+$total_sales_one['TotalSales']['tax'])
						->setCellValue('E'.$row_number, $total_sales_one['TotalSales']['credit_sales'])
						->setCellValue('U'.$row_number, $total_sales_one['TotalSales']['coupon_discounts']);
					#売掛集金if文
					if($location['Location']['name']=='和光店'){
						$obj->setActiveSheetIndex(0)
							->setCellValue('Z'.$row_number, $total_sales_one['TotalSales']['add']);
					}

					#支出
					$expenses = $this->Expense->find('all', array(
						'conditions' => array('Expense.location_id' => $location['Location']['id'], 'Expense.working_day' => $working_day)
					));
					#種類別累計計算
					$expense_arr_two = array();
					foreach ($expenses as $expense){
						if(isset($expense_arr_two[$expense['Type']['id']])){
							$expense_arr_two[$expense['Type']['id']] += (int)$expense['Expense']['fee'];
						}else{
							$expense_arr_two[$expense['Type']['id']] = (int)$expense['Expense']['fee'];
						}
					}
					#挿入
					foreach($expense_arr_two as $key => $e){
						$obj->setActiveSheetIndex(0)
							->setCellValue($expense_arr[$key].$row_number, $e);
					}
					#その他割引
					$other_discounts = $this->OtherDiscount->find('all', array(
						'conditions' => array('OtherDiscount.location_id' => $location['Location']['id'], 'OtherDiscount.working_day' => $working_day)
					));
					#種類別累計計算
					$other_arr_two = array();
					foreach ($other_discounts as $other_discount){
						if(isset($other_arr_two[$other_discount['OtherType']['id']])){
							$other_arr_two[$other_discount['OtherType']['id']] += (int)$other_discount['OtherDiscount']['fee'];
						}else{
							$other_arr_two[$other_discount['OtherType']['id']] = (int)$other_discount['OtherDiscount']['fee'];
						}
					}
					#挿入
					if($other_arr_two!=null){
						foreach($other_arr_two as $key => $o){
							$obj->setActiveSheetIndex(0)
								->setCellValue($other_arr[$key].$row_number, $o);
						}
					}
				}

			}
			elseif($this->request->data['data_type']==3){
				//店舗毎エクセルシート切り替え
				if($location['Location']['name']=='池袋店'){
					$data_name = 'payroll-ikebukuro';
				}elseif($location['Location']['name']=='赤羽店'){
					$data_name = 'payroll-akabane';
				}elseif($location['Location']['name']=='和光店'){
					$data_name = 'monthly-payroll-wako';
				}
				else{
					echo "Error : 404";
					exit;
				}
				$templatePath = $template.$data_name.'.xlsx';
				$obj = $reader->load($templatePath);
				######################################２店舗用###############################################
				if($location['Location']['name']=='和光店'){
					$month = $this->request->data['month'];
					#全従業員
					$members = $this->Member->getMemberByLocationId($location['Location']['id']);
					#エクセルnum
					$num = 5;
					#大入り日
					$special_days = array();
					#祝日取得
					$datas = $this->Payroll->get_holidays();
					#売上取得
					$total_sales = $this->TotalSales->find('all', array(
						'conditions' => array('TotalSales.location_id' => $location['Location']['id'], 'TotalSales.working_day LIKE' => '%'.$month.'%')
					));
					$sales_arr = array();
					foreach($total_sales as $total_sales_one){
						$w = $total_sales_one['TotalSales']['working_day'];
						$s = $total_sales_one['TotalSales']['sales'];
						$sales_lunches = $this->SalesLunch->find('all', array(
							'conditions' => array('SalesLunch.location_id' => $location['Location']['id'], 'SalesLunch.working_day' => $w)
						));
						$l=0;
						if($sales_lunches!=null){
							foreach($sales_lunches as $sales_lunch){
								$l += $sales_lunch['SalesLunch']['fee'];
							}
						}
						$sales_arr[$w]['lunch']=floor($l*1.08);$sales_arr[$w]['dinner']=floor(($s-$l)*1.08);
					}
					$w_arr = array( "日" => "bonus_four", "土" => "bonus_three", "金" => "bonus_two", "木" => "bonus_one", "水" => "bonus_one", "火" => "bonus_one", "月" => "bonus_one" );
					foreach($members as $member) {
						if($member['Type']['name'] == "アルバイト") {
							$attendance_results = $this->AttendanceResult->find('all', array(
								'conditions' => array('AttendanceResult.location_id' => $location['Location']['id'], 'AttendanceResult.working_day LIKE' => '%' . $month . '%', 'AttendanceResult.member_id' => $member['Member']['id'])
							));
							if($attendance_results!=null) {
								#時間数
								$hours_arr = array();
								$hours_arr['weekday']['normal'] = 0;$hours_arr['weekday']['late'] = 0;$hours_arr['weekend']['normal'] = 0;$hours_arr['weekend']['late'] = 0;
								#給与金額
								$salary_arr = array();
								$salary_arr['weekday']['normal'] = 0;$salary_arr['weekday']['late'] = 0;$salary_arr['weekend']['normal'] = 0;$salary_arr['weekend']['late'] = 0;
								#大入り手当
								$special_fee = 0;
								#交通費
								$compensation = 0;
								#まかない
								$makanai = 0;
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
								}
								#交通費補正
								if($compensation > 10000){
									$compensation = 10000;
								}
								#計算
								foreach($attendance_results as $attendance_result){
									#時給
									$hourly_wage = 0;
									#曜日取得
									$working_day = $attendance_result['AttendanceResult']['working_day'];
									$day = $weekday[date('w', strtotime($working_day))];
									#平日or休日判定（休日なら時給1.25倍）
									$flag = 0;
									$result = array_key_exists($working_day, $datas);
									#勤怠管理時時給
									if($attendance_result['AttendanceResult']['day_hourly_wage']!=0){
										$day_hourly_wage = $attendance_result['AttendanceResult']['day_hourly_wage'];
									}else{
										$day_hourly_wage = $member['Member']['hourly_wage'];
									}
									if ($result==true || $day=='日' || $day=='土') {
										$hourly_wage = $day_hourly_wage+50;
										$flag = 1;//休日フラグ
									}else{
										$hourly_wage = $day_hourly_wage;
										$flag = 2;//平日フラグ
									}
									/*
                                    foreach ($datas as $data) {
                                        $data['date'] = date('Y-m-d', strtotime($data['date']));
                                        if ($working_day==$data['date'] || $day=='日' || $day=='土') {
                                            $hourly_wage = floor($member['Member']['hourly_wage']*1.25);
                                            $flag = 1;//休日フラグ
                                        }else{
                                            $hourly_wage = $member['Member']['hourly_wage'];
                                            $flag = 2;//平日フラグ
                                        }
                                    }
                                    */
									#休日
									if($flag==1){
										#時間数
										$hours_arr['weekend']['normal'] += $attendance_result['AttendanceResult']['hours'];
										$hours_arr['weekend']['late'] += $attendance_result['AttendanceResult']['late_hours'];
										#給与
										$salary_arr['weekend']['normal'] += $hourly_wage*$attendance_result['AttendanceResult']['hours'];
										$salary_arr['weekend']['late'] += $attendance_result['AttendanceResult']['late_hours']*floor($hourly_wage*1.25);
									}
									#平日
									elseif($flag==2){
										#時間数
										$hours_arr['weekday']['normal'] += $attendance_result['AttendanceResult']['hours'];
										$hours_arr['weekday']['late'] += $attendance_result['AttendanceResult']['late_hours'];
										#給与
										$salary_arr['weekday']['normal'] += $hourly_wage*$attendance_result['AttendanceResult']['hours'];
										$salary_arr['weekday']['late'] += $attendance_result['AttendanceResult']['late_hours']*floor($hourly_wage*1.25);
									}
									else{
										echo "ERROR:Holiday";
										exit;
									}
									#大入り判定
									$timezone = $this->AttendanceResult->judgeLunchDinner($attendance_result);	//勤務時間帯
									if($timezone=='lunch'||$timezone=='dinner'){
										/*
										$score = $lunch_customers / $timezone_arr['lunch'];
										if($score>=10){
											$fee = $total_hours*50;
											if($fee > 300){	#限度額
												$fee = 300;
											}
											$special_fee += $fee;
											$special_days[$working_day]['lunch'] = $score;
										}
										*/
										$target = $this->Target->find('first', array(
											'conditions' => array('Target.location_id' => $location['Location']['id'], 'Target.working_month' => $month.'-01', 'Target.type' => $timezone)
										));
										if($target!=null){
											# 祝日判定
											if($result==true){
												if($sales_arr[$working_day][$timezone]>=$target['Target']['bonus_five']){
													$special_fee += 300;
													$special_days[$working_day][$timezone] = $sales_arr[$working_day][$timezone];
												}
											}else{
												if($sales_arr[$working_day][$timezone]>=$target['Target'][$w_arr[$day]]){
													$special_fee += 300;
													$special_days[$working_day][$timezone] = $sales_arr[$working_day][$timezone];
												}
											}
										}
									}
									elseif($timezone=='lunch/dinner'){
										$t_arr = array(0=>"lunch", 1=>"dinner");$f=0;
										foreach($t_arr as $type){
											$target = $this->Target->find('first', array(
												'conditions' => array('Target.location_id' => $location['Location']['id'], 'Target.working_month' => $month.'-01', 'Target.type' => $type)
											));
											if($target!=null){
												# 祝日判定
												if($result==true){
													if($sales_arr[$working_day][$type]>=$target['Target']['bonus_five']){
														if($f==0){
															$special_fee += 300;
															$f = 300;
														}
														$special_days[$working_day][$type] = $sales_arr[$working_day][$type];
													}
												}else{
													if($sales_arr[$working_day][$type]>=$target['Target'][$w_arr[$day]]){
														if($f==0){
															$special_fee += 300;
															$f = 300;
														}
														$special_days[$working_day][$type] = $sales_arr[$working_day][$type];
													}
												}
											}
										}
									}
									#賄い
									if($attendance_result['AttendanceResult']['makanai']==1){
										$makanai += 300;
									}
								}
								#page 1
								$obj->setActiveSheetIndex(0)
									->setCellValue('B2', date('Y年m月', strtotime($month)))
									->setCellValue('C'.$num, $member['Member']['name'])
									->setCellValue('D'.$num, count($attendance_results))
									->setCellValue('E'.$num, $hours_arr['weekday']['normal']+$hours_arr['weekday']['late']+$hours_arr['weekend']['normal']+$hours_arr['weekend']['late'])
									->setCellValue('F'.$num, $hours_arr['weekday']['normal'])
									->setCellValue('G'.$num, $hours_arr['weekend']['normal'])
									->setCellValue('H'.$num, $hours_arr['weekday']['late'])
									->setCellValue('I'.$num, $hours_arr['weekend']['late'])
									->setCellValue('J'.$num, floor($salary_arr['weekday']['normal']))
									->setCellValue('K'.$num, floor($salary_arr['weekend']['normal']))
									->setCellValue('L'.$num, floor($salary_arr['weekday']['late']))
									->setCellValue('M'.$num, floor($salary_arr['weekend']['late']))
									/*
                                    ->setCellValue('J'.$num, floor($hours_arr['weekday']['normal']*$member['Member']['hourly_wage']))
                                    ->setCellValue('K'.$num, floor($hours_arr['weekend']['normal']*($member['Member']['hourly_wage']+50)))
                                    ->setCellValue('L'.$num, floor($hours_arr['weekday']['late']*floor($member['Member']['hourly_wage']*1.25)))
                                    ->setCellValue('M'.$num, floor($hours_arr['weekend']['late']*floor(($member['Member']['hourly_wage']+50)*1.25)))
                                    */
									->setCellValue('N'.$num, $special_fee)
									->setCellValue('P'.$num, $compensation)
									->setCellValue('R'.$num, $makanai);
								$num += 1;
							}
						}
					}
					#page 2
					//$obj->setActiveSheetIndex(1)
						//->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));
					#page 3
					#和光大入り日
					$obj->setActiveSheetIndex(1)
						->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));
					#エクセルnum
					$num = 5;
					ksort($special_days);
					foreach($special_days as $key => $special_day){
						#ランチ
						if(isset($special_day['lunch'])){
							$obj->setActiveSheetIndex(1)
								->setCellValue('C'.$num, $key)
								->setCellValue('D'.$num, 'ランチ')
								->setCellValue('E'.$num, $special_day['lunch']);
							$num +=1;
						}
						#ディナー
						if(isset($special_day['dinner'])){
							$obj->setActiveSheetIndex(1)
								->setCellValue('C'.$num, $key)
								->setCellValue('D'.$num, 'ディナー')
								->setCellValue('E'.$num, $special_day['dinner']);
							$num +=1;
						}
					}
				}else{##################################１店舗用###################################################
					$obj->setActiveSheetIndex(0)
						->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));
					#全従業員
					$members = $this->Member->getMemberByLocationId($location['Location']['id']);
					#エクセルnum
					$num = 5;
					foreach($members as $member){
						if($member['Type']['name']=="アルバイト"){
							$attendance_results = $this->AttendanceResult->find('all', array(
								'conditions' => array('AttendanceResult.location_id' => $location['Location']['id'], 'AttendanceResult.working_day LIKE' => '%'.$this->request->data['month'].'%', 'AttendanceResult.member_id' => $member['Member']['id'])
							));
							if($attendance_results!=null){
								#パラメータ初期化
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
									#特定の従業員除外
									if($member['Member']['id']!=23){
										$compensation = 10000;
									}
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
								#書き込み（店舗毎きりかえ）
								#店舗毎分岐
								if($location['Location']['name']=='池袋店'){
									$obj->setActiveSheetIndex(0)
										->setCellValue('C'.$num, $member['Member']['name'])
										->setCellValue('D'.$num, count($attendance_results))
										->setCellValue('E'.$num, $hours+$late_hours)
										->setCellValue('F'.$num, $hours)
										->setCellValue('G'.$num, $late_hours)
										->setCellValue('H'.$num, $salaries)
										->setCellValue('I'.$num, $late_salaries)
										->setCellValue('J'.$num, $special_fee)
										->setCellValue('L'.$num, $compensation);
								}elseif($location['Location']['name']=='赤羽店'){  //大入りなし
									$obj->setActiveSheetIndex(0)
										->setCellValue('C'.$num, $member['Member']['name'])
										->setCellValue('D'.$num, count($attendance_results))
										->setCellValue('E'.$num, $hours+$late_hours)
										->setCellValue('F'.$num, $hours)
										->setCellValue('G'.$num, $late_hours)
										->setCellValue('H'.$num, $salaries)
										->setCellValue('I'.$num, $late_salaries)
										->setCellValue('L'.$num, $compensation);
								}
								$num += 1;
							}
						}
					}
					#池袋大入り
					if($location['Location']['name']=='池袋店') {
						// sheet 2
						$obj->setActiveSheetIndex(1)
							->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));
						//大入り日
						#大入り判定
						$special_days = $this->TotalSales->find('all', array(
							'fields' => array('TotalSales.working_day'),
							'conditions' => array('TotalSales.location_id' => $location['Location']['id'], 'TotalSales.working_day LIKE' => '%' . $this->request->data['month'] . '%', 'sales >' => '400000')
						));
						if ($special_days != null) {
							//エクセルnum
							$num = 5;
							foreach ($special_days as $special_day) {
								$obj->setActiveSheetIndex(1)
									->setCellValue('C' . $num, $special_day['TotalSales']['working_day']);
								$num += 1;
							}
						}
					}
				}
			}
			elseif($this->request->data['data_type']==4){
				$data_name = 'monthly-report-laborcostratio';
				$templatePath = $template.$data_name.'.xlsx';
				$obj = $reader->load($templatePath);
				// sheet 1
				$obj->setActiveSheetIndex(0)
					->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])))
					->setCellValue('J2', $location['Location']['name']);
				#人件費率取得
				$payrolls = $this->Payroll->find('all', array(
					'conditions' => array('Payroll.location_id' => $location['Location']['id'], 'Payroll.working_day LIKE' => '%'.$this->request->data['month'].'%')
				));
				if($payrolls!=null){
					foreach($payrolls as $payroll){
						#営業日
						$working_day = $payroll['Payroll']['working_day'];
						//曜日取得
						$day = $weekday[date('w', strtotime($working_day))];
						//開始番号設定
						$row_number = date('j', strtotime($working_day)) + 4;

						$obj->setActiveSheetIndex(0)
							->setCellValue('C'.$row_number, $day)
							->setCellValue('D'.$row_number, $payroll['TotalSales']['sales'])
							->setCellValue('E'.$row_number, $payroll['Payroll']['hall'])
							->setCellValue('F'.$row_number, $payroll['Payroll']['kitchen']);
					}
				}
			}
			elseif($this->request->data['data_type']==5){
				//店舗毎エクセルシート切り替え
				if($location['Location']['name']=='池袋店'){
					$data_name = 'monthly-report-purchase-ikebukuro';
				}else{
					echo "Error: 404";
					exit;
				}
				$templatePath = $template.$data_name.'.xlsx';
				$obj = $reader->load($templatePath);
				// sheet 1
				$obj->setActiveSheetIndex(0)
					->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));
				for ($i=1; $i <= 31; $i++) {
					$working_day = $this->request->data['month'].'-'.$i;
					//曜日取得
					$day = $weekday[date('w', strtotime($working_day))];
					#小計考慮
					$day_num = date('j', strtotime($working_day));
					if($day_num<=7){
						//開始番号設定
						$row_number = $day_num + 4;
					}elseif($day_num<=14){
						//開始番号設定
						$row_number = $day_num + 5;
					}elseif($day_num<=21){
						//開始番号設定
						$row_number = $day_num + 6;
					}elseif($day_num<=28){
						//開始番号設定
						$row_number = $day_num + 7;
					}elseif($day_num<=31){
						//開始番号設定
						$row_number = $day_num + 8;
					}else{
						echo "ERROR :Day Number is not exist.";
						exit;
					}
					#初期化
					$yasai = 0; //現金のみ
					$chomiryo = 0;  //現金のみ
					$shomohin = 0;
					$kome = 0;
					$sonota = 0;
					$neta = 0;
					$sake = 0;
					#支出（現金分）
					$expenses = $this->Expense->find('all', array(
						'conditions' => array('Expense.location_id' => $location['Location']['id'], 'Expense.working_day' => $working_day)
					));
					if($expenses!=null){
						foreach($expenses as $expense){
							if($expense['Type']['name']=='野菜'){
								$yasai += $expense['Expense']['fee'];
							}elseif($expense['Type']['name']=='調味料'){
								$chomiryo += $expense['Expense']['fee'];
							}elseif($expense['Type']['name']=='消耗品'){
								$shomohin += $expense['Expense']['fee'];
							}elseif($expense['Type']['name']=='米（賄い）'){
								$kome += $expense['Expense']['fee'];
							}elseif($expense['Type']['name']=='その他'){
								$sonota += $expense['Expense']['fee'];
							}elseif($expense['Type']['name']=='ネタ'){
								$neta += $expense['Expense']['fee'];
							}elseif($expense['Type']['name']=='飲料'){
								$sake += $expense['Expense']['fee'];
							}
						}
					}
					#買掛合計
					$payable_accounts = $this->PayableAccount->find('all', array(
						'conditions' => array('PayableAccount.location_id' => $location['Location']['id'], 'PayableAccount.working_day' => $working_day)
					));
					if($payable_accounts!=null){
						foreach($payable_accounts as $payable_account){
							if($payable_account['Type']['name']=='消耗品'){
								$shomohin += $payable_account['PayableAccount']['fee'];
							}elseif($payable_account['Type']['name']=='米（賄い）'){
								$kome += $payable_account['PayableAccount']['fee'];
							}elseif($payable_account['Type']['name']=='その他'){
								$sonota += $payable_account['PayableAccount']['fee'];
							}elseif($payable_account['Type']['name']=='ネタ（仲買）'){
								$neta += $payable_account['PayableAccount']['fee'];
							}elseif($payable_account['Type']['name']=='酒（飲料）'){
								$sake += $payable_account['PayableAccount']['fee'];
							}
						}
					}
					#Excel挿入
					$obj->setActiveSheetIndex(0)
						->setCellValue('C'.$row_number, $day)
						->setCellValue('D'.$row_number, $yasai)
						->setCellValue('E'.$row_number, $chomiryo)
						->setCellValue('F'.$row_number, $shomohin)
						->setCellValue('G'.$row_number, $kome)
						->setCellValue('H'.$row_number, $sonota)
						->setCellValue('I'.$row_number, $neta)
						->setCellValue('K'.$row_number, $sake);
				}
			}
			elseif($this->request->data['data_type']==6){
				//店舗毎エクセルシート切り替え
				if($location['Location']['name']=='池袋店'){
					$data_name = 'monthly-report-saekirate-ikebukuro';
				}else{
					echo "Error: 404";
					exit;
				}
				$templatePath = $template.$data_name.'.xlsx';
				$obj = $reader->load($templatePath);
				// sheet 1
				$obj->setActiveSheetIndex(0)
					->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));
				// sheet 2
				$obj->setActiveSheetIndex(1)
					->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));
				for ($i=1; $i <= 31; $i++) {
					$working_day = $this->request->data['month'].'-'.$i;
					//曜日取得
					$day = $weekday[date('w', strtotime($working_day))];
					#小計考慮
					$day_num = date('j', strtotime($working_day));
					if($day_num<=7){
						//開始番号設定
						$row_number = $day_num + 4;
					}elseif($day_num<=14){
						//開始番号設定
						$row_number = $day_num + 5;
					}elseif($day_num<=21){
						//開始番号設定
						$row_number = $day_num + 6;
					}elseif($day_num<=28){
						//開始番号設定
						$row_number = $day_num + 7;
					}elseif($day_num<=31){
						//開始番号設定
						$row_number = $day_num + 8;
					}else{
						echo "ERROR :Day Number is not exist.";
						exit;
					}
					#初期化
					$sushi_sales = 0;
					$drink_sales = 0;
					#売上（飲料売上のみドリンク売上）
					$sales = $this->Sales->find('all', array(
						'conditions' => array('Sales.location_id' => $location['Location']['id'], 'working_day' => $working_day)
					));
					if($sales!=null){
						foreach($sales as $sales_one){
							if($sales_one['Type']['name']=='店内売上'){
								$sushi_sales += $sales_one['Sales']['fee'];
							}elseif($sales_one['Type']['name']=='出前売上'){
								$sushi_sales += $sales_one['Sales']['fee'];
							}elseif($sales_one['Type']['name']=='飲料売上'){
								$drink_sales += $sales_one['Sales']['fee'];
							}
						}
					}
					#初期化
					$sushi_purchases = 0;
					$drink_purchases = 0;
					#支出（飲料のみドリンク仕入）
					$expenses = $this->Expense->find('all', array(
						'conditions' => array('Expense.location_id' => $location['Location']['id'], 'Expense.working_day' => $working_day)
					));
					if($expenses!=null){
						foreach($expenses as $expense){
							if($expense['Type']['name']=='飲料'){
								$drink_purchases += $expense['Expense']['fee'];
							}else{
								$sushi_purchases += $expense['Expense']['fee'];
							}
						}
					}
					#買掛合計（飲料のみドリンク仕入）
					$payable_accounts = $this->PayableAccount->find('all', array(
						'conditions' => array('PayableAccount.location_id' => $location['Location']['id'], 'PayableAccount.working_day' => $working_day)
					));
					if($payable_accounts!=null){
						foreach($payable_accounts as $payable_account){
							if($payable_account['Type']['name']=='酒（飲料）'){
								$drink_purchases += $payable_account['PayableAccount']['fee'];
							}else{
								$sushi_purchases += $payable_account['PayableAccount']['fee'];
							}
						}
					}
					#Excel挿入
					// sheet 1
					$obj->setActiveSheetIndex(0)
						->setCellValue('C'.$row_number, $day)
						->setCellValue('D'.$row_number, $sushi_sales)
						->setCellValue('E'.$row_number, $sushi_purchases);
					// sheet 2
					$obj->setActiveSheetIndex(1)
						->setCellValue('C'.$row_number, $day)
						->setCellValue('D'.$row_number, $drink_sales)
						->setCellValue('E'.$row_number, $drink_purchases);
				}
			}
			elseif($this->request->data['data_type']==7){
				//店舗毎エクセルシート切り替え
				if($location['Location']['name']=='池袋店'){
					$data_name = 'monthly-report-mix-ikebukuro';
				}elseif($location['Location']['name']=='赤羽店'){
					$data_name = 'monthly-report-mix-akabane';
				}else{
					echo "Error: 404";
					exit;
				}
				$templatePath = $template.$data_name.'.xlsx';
				$obj = $reader->load($templatePath);
				// sheet 1
				$obj->setActiveSheetIndex(0)
					->setCellValue('B2', date('Y年m月', strtotime($this->request->data['month'])));

				#客単価平均算出
				$d = 0;
				$total_averages = 0;
				for ($i=1; $i <= 31; $i++) {
					$working_day = $this->request->data['month'].'-'.$i;
					//曜日取得
					$day = $weekday[date('w', strtotime($working_day))];
					#小計考慮
					$day_num = date('j', strtotime($working_day));
					if($day_num<=7){
						//開始番号設定
						$row_number = $day_num + 4;
					}elseif($day_num<=14){
						//開始番号設定
						$row_number = $day_num + 5;
					}elseif($day_num<=21){
						//開始番号設定
						$row_number = $day_num + 6;
					}elseif($day_num<=28){
						//開始番号設定
						$row_number = $day_num + 7;
					}elseif($day_num<=31){
						//開始番号設定
						$row_number = $day_num + 8;
					}else{
						echo "ERROR :Day Number is not exist.";
						exit;
					}
					#20150923 akabane
					$target = $this->Target->getTargetByDay($location['Location']['id'], $working_day);
					#総売上取得
					$total_sales = $this->TotalSales->find('first', array(
						'conditions' => array('TotalSales.location_id' => $location['Location']['id'], 'TotalSales.working_day' => $working_day)
					));
					#出前売上取得
					$demae_sales = 0;
					$sales = $this->Sales->find('all', array(
						'conditions' => array('Sales.location_id' => $location['Location']['id'], 'working_day' => $working_day)
					));
					if($sales!=null){
						foreach($sales as $sales_one){
							if($sales_one['Type']['name']=='出前売上'){
								$demae_sales = $sales_one['Sales']['fee'];
							}
						}
					}
					#伝票番号取得
					$num_demae = 0;
					$slip_numbers = $this->SlipNumber->find('all', array(
						'conditions' => array('SlipNumber.location_id' => $location['Location']['id'], 'working_day' => $working_day)
					));
					if($slip_numbers!=null){
						#出前数算出
						foreach($slip_numbers as $slip_number){
							if($slip_number['Type']['name'] == "出前"){
								$num_demae = $slip_number['SlipNumber']['end_number'] - $slip_number['SlipNumber']['start_number'] + 1;
							}
						}
					}
					#支出
					$total_expenses = 0;
					$expenses = $this->Expense->find('all', array(
						'conditions' => array('Expense.location_id' => $location['Location']['id'], 'Expense.working_day' => $working_day)
					));
					foreach($expenses as $expense){
						$total_expenses += $expense['Expense']['fee'];
					}
					#買掛
					$total_accounts = 0;
					$payable_accounts = $this->PayableAccount->find('all', array(
						'conditions' => array('PayableAccount.location_id' => $location['Location']['id'], 'PayableAccount.working_day' => $working_day)
					));
					foreach($payable_accounts as $payable_account){
						$total_accounts += $payable_account['PayableAccount']['fee'];
					}
					#Excel挿入
					if($total_sales!=null){
						#客単価計算
						$average = 0;
						if($total_sales['TotalSales']['customer_counts']!=0){
							$average = ($total_sales['TotalSales']['sales'] - $demae_sales) / $total_sales['TotalSales']['customer_counts'];
						}
						#for akabane
						if($location['Location']['name']=='池袋店'){
							// sheet 1
							$obj->setActiveSheetIndex(0)
								->setCellValue('C'.$row_number, $day)
								->setCellValue('D'.$row_number, $total_sales['TotalSales']['sales'])
								->setCellValue('E'.$row_number, $total_expenses + $total_accounts)
								->setCellValue('L'.$row_number, $total_sales['TotalSales']['customer_counts'])
								->setCellValue('N'.$row_number, $num_demae)
								->setCellValue('P'.$row_number, $average);
						}elseif($location['Location']['name']=='赤羽店'){
							// sheet 1
							$obj->setActiveSheetIndex(0)
								->setCellValue('C'.$row_number, $day)
								->setCellValue('D'.$row_number, $target)
								->setCellValue('F'.$row_number, $total_sales['TotalSales']['sales'])
								->setCellValue('H'.$row_number, $total_expenses + $total_accounts)
								->setCellValue('P'.$row_number, $total_sales['TotalSales']['customer_counts'])
								->setCellValue('R'.$row_number, $num_demae)
								->setCellValue('T'.$row_number, $average);
						}
						#客単価平均
						$d += 1;
						$total_averages += $average;
					}
				}
				/*
                if($d!=0){
                    if($location['Location']['name']=='池袋店'){
                        // sheet 1
                        $obj->setActiveSheetIndex(0)
                            ->setCellValue('P42', $total_averages / $d);
                    }
                }
                */
			}
			else{
				echo "Fatal Error: Your Request is not available";
				exit;
			}
			// Excel2007
			$filename = $data_name.'-'.$this->request->data['month'].'.xlsx';
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header("Content-Disposition: attachment;filename=$filename");
			header('Cache-Control: max-age=0');
			$writer = PHPExcel_IOFactory::createWriter($obj, 'Excel2007');
			$writer->save('php://output');
			exit;
		}
	}

	# 日次報告
	public function daily_report(){
		if($this->request->is('post')){
			# クッキー値
			$location = $this->myData;
			if($this->request->data['date']==null){
				echo "日付が入力されていません";
				exit;
			}
			else{
				# 曜日配列
				$weekday = array( "日", "月", "火", "水", "木", "金", "土" );
				$working_day = $this->request->data['date'];
				$day = $weekday[date('w', strtotime($working_day))];
			}
			# エクセル出力用ライブラリ
			App::import('Vendor', 'PHPExcel/Classes/PHPExcel');
			App::import('Vendor', 'PHPExcel/Classes/PHPExcel/IOFactory');
			# Excel2007形式(xlsx)テンプレートの読み込み
			$reader = PHPExcel_IOFactory::createReader('Excel2007');
			$template = realpath(WWW_ROOT);
			$template .= '/excel/';
			//////////////////////////////////////////////////////////////////////
			//店舗毎エクセルシート切り替え
			if($location['Location']['name']=='池袋店'||$location['Location']['name']=='赤羽店'){
				$data_name = 'work_schedule_1';
				$h_arr = array('15'=>8,'16'=>12,'17'=>16,'18'=>20,'19'=>24,'20'=>28,'21'=>32,'22'=>36,'23'=>40,'00'=>44,'01'=>48,'02'=>52,'03'=>56,'04'=>60,'05'=>64,'06'=>68);
				$m_arr = array('00'=>0,'15'=>1,'30'=>2,'45'=>3);
			}elseif($location['Location']['name']=='和光店'){
				$data_name = 'work_schedule_2';
				$h_arr = array('09'=>4, '10'=>8,'11'=>12,'12'=>16,'13'=>20,'14'=>24,'15'=>28,'16'=>32,'17'=>36,'18'=>40,'19'=>44,'20'=>48,'21'=>52,'22'=>56,'23'=>60,'00'=>64,'01'=>68);
				$m_arr = array('00'=>0,'15'=>1,'30'=>2,'45'=>3);
			}else{
				echo "Error: 404";
				exit;
			}
			$templatePath = $template.$data_name.'.xlsx';
			$obj = $reader->load($templatePath);
			# Sheet1
			$obj->setActiveSheetIndex(0)
				->setCellValue('C2', date('Y年m月d日', strtotime($working_day)).'('.$day.')');
			# アルバイト（ホール）勤怠記録
			$member_type_id = $this->MemberType->getMemberTypeId($location['Location']['id'], 'アルバイト');
			$member_position_id = $this->MemberPosition->getMemberPositionId($location['Location']['id'], 'ホール');
			$members = $this->Attendance->find('all', array(
				'conditions' => array('Attendance.location_id' => $location['Location']['id'], 'Attendance.working_day' => $working_day, 'Member.type_id' => $member_type_id, 'Member.position_id' => $member_position_id),
				'group' => array('Member.id'),
				'order' => array('Attendance.time'),
			));
			$line_num = 25;
			$this->work_schedule_func($line_num, $members, $h_arr, $m_arr, $obj, $location, $working_day);
			# アルバイト（キッチン）勤怠記録
			$member_type_id = $this->MemberType->getMemberTypeId($location['Location']['id'], 'アルバイト');
			$member_position_id = $this->MemberPosition->getMemberPositionId($location['Location']['id'], 'キッチン');
			$members = $this->Attendance->find('all', array(
				'conditions' => array('Attendance.location_id' => $location['Location']['id'], 'Attendance.working_day' => $working_day, 'Member.type_id' => $member_type_id, 'Member.position_id' => $member_position_id),
				'group' => array('Member.id'),
				'order' => array('Attendance.time'),
			));
			$line_num = 15;
			$this->work_schedule_func($line_num, $members, $h_arr, $m_arr, $obj, $location, $working_day);
			# 社員（キッチン）勤怠記録
			$member_type_id = $this->MemberType->getMemberTypeId($location['Location']['id'], '社員');
			$member_position_id = $this->MemberPosition->getMemberPositionId($location['Location']['id'], 'キッチン');
			$members = $this->Attendance->find('all', array(
				'conditions' => array('Attendance.location_id' => $location['Location']['id'], 'Attendance.working_day' => $working_day, 'Member.type_id' => $member_type_id, 'Member.position_id' => $member_position_id),
				'group' => array('Member.id'),
				'order' => array('Attendance.time'),
			));
			$line_num = 5;
			$this->work_schedule_func($line_num, $members, $h_arr, $m_arr, $obj, $location, $working_day);
			# 時間帯別売上
			$timezone_summaries = $this->ReceiptSummary->timezoneSummarize($location['Location']['id'], $working_day);
			if($timezone_summaries!=null){
				foreach($timezone_summaries as $timezone_summary){
					if(isset($timezone_summary[0])){
						$t = $timezone_summary[0];
						# 売上
						$obj->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow($h_arr[$t['hour']], 43, $t['total']);
						# 客数
						$obj->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow($h_arr[$t['hour']], 44, $t['visitors']);
					}
				}
			}
			//////////////////////////////////////////////////////////////////////
			// Excel2007
			$filename = $data_name.'-'.$this->request->data['date'].'.xlsx';
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header("Content-Disposition: attachment;filename=$filename");
			header('Cache-Control: max-age=0');
			$writer = PHPExcel_IOFactory::createWriter($obj, 'Excel2007');
			$writer->save('php://output');
			exit;
		}
	}

	private function work_schedule_func($line_num, $members, $h_arr, $m_arr, $obj, $location, $working_day){
		if($members!=null){
			foreach($members as $member){
				# 氏名
				$obj->setActiveSheetIndex(0)
					->setCellValue('D'.$line_num, $member['Member']['name']);
				# 勤怠記録
				$attendances = $this->Attendance->find('all', array(
					'conditions' => array('Attendance.location_id' => $location['Location']['id'], 'Attendance.working_day' => $working_day, 'Attendance.member_id' => $member['Member']['id']),
					'order' => array('Attendance.time'=> 'asc'),
				));
				if($attendances!=null){
					$p_arr = array();
					foreach($attendances as $key => $attendance){
						$h = date('H', strtotime($attendance['Attendance']['time']));
						$i = date('i', strtotime($attendance['Attendance']['time']));
						$row_num = $h_arr[$h]+$m_arr[$i];
						$key++;
						$key=ceil($key/2);
						$p_arr[$key][] = $row_num;
					}
					if($p_arr!=null){
						foreach($p_arr as $p){
							$st = $p[0];
							$en = $p[1];
							for($i=$st;$i<$en;$i++){
								# 1代入
								$obj->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow($i, $line_num, 1);
							}
						}
					}
				}
				$line_num++;
			}
		}
	}

	#売上目標値設定
	public function target(){
		#クッキー値
		$location = $this->myData;
		if($this->request->is('post')){
			if($this->request->data['Target']['target_one']!=null&&$this->request->data['Target']['target_two']!=null&&$this->request->data['Target']['target_three']!=null&&$this->request->data['Target']['target_four']!=null){
				if($this->Target->save($this->request->data)){
					$this->Session->setFlash("目標値を設定しました");
					$this->redirect(array('controller'=>'admin', 'action'=>'index'));
				}
			}else{
				$this->Session->setFlash("全項目を設定してください");
				$this->redirect(array('controller'=>'sales', 'action'=>'target'));
			}
		}else{
			$target = $this->Target->find('first', array(
				'conditions' => array('Target.location_id' => $location['Location']['id'])
			));
			if($target!=null){
				$this->set('target', $target);
			}
		}
	}

	#売上目標値計算
	public function calculate(){
		# クッキー値
		$location = $this->myData;
		//$association=$location['Association'];$cnt=count($association);
		# 掛率デフォルト
		$t1=105;$t2=15;
		$this->set('t1', $t1);$this->set('t2', $t2);
		# POST
		if($this->request->is('post')){
			# post data
			$location_id = $this->request->data['location_id'];
			$month = $this->request->data['month'];
			$this->set("month", $month);
			#祝日取得
			$datas = $this->Payroll->get_holidays();
			if($location_id!=null&&$month!=null){
				# 去年
				$year = date('Y', strtotime(("-1 year")));
				$date  = $year.'-'.$month;
				# 総売上取得
				$total_sales = $this->TotalSales->find('all', array(
					'conditions' => array('TotalSales.location_id' => $location_id, 'TotalSales.working_day LIKE' => '%'.$date.'%')
				));
				if($total_sales!=null){
					# ディナー
					$target_arr = array();
					$target_arr['1']['fee']=0;$target_arr['2']['fee']=0;$target_arr['3']['fee']=0;$target_arr['4']['fee']=0;$target_arr['5']['fee']=0;
					$target_arr['1']['num']=0;$target_arr['2']['num']=0;$target_arr['3']['num']=0;$target_arr['4']['num']=0;$target_arr['5']['num']=0;
					# ランチ
					$target_arr_lunch = array();
					$target_arr_lunch['1']['fee']=0;$target_arr_lunch['2']['fee']=0;$target_arr_lunch['3']['fee']=0;$target_arr_lunch['4']['fee']=0;$target_arr_lunch['5']['fee']=0;
					$target_arr_lunch['1']['num']=0;$target_arr_lunch['2']['num']=0;$target_arr_lunch['3']['num']=0;$target_arr_lunch['4']['num']=0;$target_arr_lunch['5']['num']=0;
					# ランチある場合Totalから分離
					foreach($total_sales as $total_sales_one){
						# 営業日etc
						$working_day = $total_sales_one['TotalSales']['working_day'];
						$w = (int)date('w',strtotime($working_day));
						$result = array_key_exists($working_day, $datas);
						# TotalSalesFee
						$sales = $total_sales_one['TotalSales']['sales'];
						# ランチ or not
						$sales_lunches = $this->SalesLunch->find('all', array(
							'conditions' => array('SalesLunch.location_id' => $location_id, 'SalesLunch.working_day' => $working_day)
						));
						if($sales_lunches!=null){
							# ランチ総額
							$lunch_total=0;
							foreach($sales_lunches as $sales_lunch){
								$lunch_total += $sales_lunch['SalesLunch']['fee'];
							}
							# ディナー
							$sales = $sales-$lunch_total;
							# Exception ランチ消費税
							if($location_id==3){
								$lunch_total = floor($lunch_total*1.08);
							}
							# ランチarray
							if($result==true){
								$target_arr_lunch['5']['fee'] += $lunch_total;
								$target_arr_lunch['5']['num']++;
							}else{
								if($w==0){
									$target_arr_lunch['4']['fee'] += $lunch_total;
									$target_arr_lunch['4']['num']++;
								}
								elseif($w==6){
									$target_arr_lunch['3']['fee'] += $lunch_total;
									$target_arr_lunch['3']['num']++;
								}
								elseif($w==5){
									$target_arr_lunch['2']['fee'] += $lunch_total;
									$target_arr_lunch['2']['num']++;
								}
								else{
									$target_arr_lunch['1']['fee'] += $lunch_total;
									$target_arr_lunch['1']['num']++;
								}
							}
						}
						# Exception ディナー消費税
						if($location_id==3){
							$sales = floor($sales*1.08);
						}
						# ディナーarray
						if($result==true){
							$target_arr['5']['fee'] += $sales;
							$target_arr['5']['num']++;
						}else{
							if($w==0){
								$target_arr['4']['fee'] += $sales;
								$target_arr['4']['num']++;
							}
							elseif($w==6){
								$target_arr['3']['fee'] += $sales;
								$target_arr['3']['num']++;
							}
							elseif($w==5){
								$target_arr['2']['fee'] += $sales;
								$target_arr['2']['num']++;
							}
							else{
								$target_arr['1']['fee'] += $sales;
								$target_arr['1']['num']++;
							}
						}
					}
					$this->set("target_arr", $target_arr);
					$this->set("target_arr_lunch", $target_arr_lunch);
					# ディナー
					$new_target_arr = array();
					foreach($target_arr as $key => $target){
						$fee = $target['fee'];$num = $target['num'];
						if($num!=0){
							$average = floor($fee/$num);
							$new_target_arr[$key]['fee'] = $average;
							$new_target_arr[$key]['t1'] = floor($average*$t1/100);
							$new_target_arr[$key]['t2'] = floor($average*$t2/10);
						}else{
							$new_target_arr[$key]['fee'] = 0;
							$new_target_arr[$key]['t1'] = 0;
							$new_target_arr[$key]['t2'] = 0;
						}
					}
					$this->set("new_target_arr", $new_target_arr);
					# ランチ
					$new_target_arr_lunch = array();
					foreach($target_arr_lunch as $key => $target){
						$fee = $target['fee'];$num = $target['num'];
						if($num!=0){
							$average = floor($fee/$num);
							$new_target_arr_lunch[$key]['fee'] = $average;
							$new_target_arr_lunch[$key]['t1'] = floor($average*$t1/100);
							$new_target_arr_lunch[$key]['t2'] = floor($average*$t2/10);
						}else{
							$new_target_arr_lunch[$key]['fee'] = 0;
							$new_target_arr_lunch[$key]['t1'] = 0;
							$new_target_arr_lunch[$key]['t2'] = 0;
						}
					}
					$this->set("new_target_arr_lunch", $new_target_arr_lunch);
				}
				else{
					debug("データがありません。");
				}
			}
			else{
				debug("Submit Error!!");
			}
		}
	}

	public function calculate_excel(){
		# POST
		if($this->request->is('post')){
			$location_id=$this->request->data['location_id'];
			$month=$this->request->data['month'];
			$dinner=$this->request->data['portlet_tab2_1'];$lunch=$this->request->data['portlet_tab2_2'];
			if($month!=null){
				$working_month = date('Y').'-'.$month;
				# Database
				$type_arr = array('portlet_tab2_1' => 'dinner', 'portlet_tab2_2' => 'lunch');
				foreach($type_arr as $key => $type){
					$arr = $this->request->data[$key];
					# 既存チェック
					$target = $this->Target->find('first', array(
						'conditions' => array('Target.location_id' => $location_id, 'Target.working_month' => $working_month.'-01', 'Target.type' => $type)
					));
					if($target==null){
						$data = array('Target' => array(
							'location_id' => $location_id,
							'working_month' => $working_month.'-01',
							'type' => $type,
							'target_one' => $this->ceilBudget((int)$arr['numOne']['tOne']),
							'target_two' => $this->ceilBudget((int)$arr['numTwo']['tOne']),
							'target_three' => $this->ceilBudget((int)$arr['numThree']['tOne']),
							'target_four' => $this->ceilBudget((int)$arr['numFour']['tOne']),
							'target_five' => $this->ceilBudget((int)$arr['numFive']['tOne']),
							'bonus_one' => $this->ceilBudget((int)$arr['numOne']['tTwo']),
							'bonus_two' => $this->ceilBudget((int)$arr['numTwo']['tTwo']),
							'bonus_three' => $this->ceilBudget((int)$arr['numThree']['tTwo']),
							'bonus_four' => $this->ceilBudget((int)$arr['numFour']['tTwo']),
							'bonus_five' => $this->ceilBudget((int)$arr['numFive']['tTwo'])
						));
					}
					else {
						$data = array('Target' => array(
							'id' => $target['Target']['id'],
							'target_one' => $this->ceilBudget((int)$arr['numOne']['tOne']),
							'target_two' => $this->ceilBudget((int)$arr['numTwo']['tOne']),
							'target_three' => $this->ceilBudget((int)$arr['numThree']['tOne']),
							'target_four' => $this->ceilBudget((int)$arr['numFour']['tOne']),
							'target_five' => $this->ceilBudget((int)$arr['numFive']['tOne']),
							'bonus_one' => $this->ceilBudget((int)$arr['numOne']['tTwo']),
							'bonus_two' => $this->ceilBudget((int)$arr['numTwo']['tTwo']),
							'bonus_three' => $this->ceilBudget((int)$arr['numThree']['tTwo']),
							'bonus_four' => $this->ceilBudget((int)$arr['numFour']['tTwo']),
							'bonus_five' => $this->ceilBudget((int)$arr['numFive']['tTwo'])
						));
					}
					# Sql
					$this->Target->create(false);
					$this->Target->save($data);
				}
				# Excel
				App::import('Vendor', 'PHPExcel/Classes/PHPExcel');
				App::import('Vendor', 'PHPExcel/Classes/PHPExcel/IOFactory');
				$reader = PHPExcel_IOFactory::createReader('Excel2007');
				$template = realpath(TMP);
				$template .= '/excel/';
				$data_name = 'monthly_budget';
				$templatePath = $template.$data_name.'.xlsx';
				$obj = $reader->load($templatePath);
				$weekday = array( "日", "月", "火", "水", "木", "金", "土" );
				$datas = $this->Payroll->get_holidays();
				# sheet1
				$obj->setActiveSheetIndex(0)
					->setCellValue('B2', date('Y年m月', strtotime($working_month)));
				for ($i=1; $i <= 31; $i++) {
					# 0補完
					if($i<10){
						$i = '0'.$i;
					}
					$working_day = $working_month.'-'.$i;
					$w = date('w', strtotime($working_day));
					$day = $weekday[$w];
					# 小計考慮
					$day_num = date('j', strtotime($working_day));
					if($day_num<=7){
						//開始番号設定
						$row_number = $day_num + 4;
					}elseif($day_num<=14){
						//開始番号設定
						$row_number = $day_num + 5;
					}elseif($day_num<=21){
						//開始番号設定
						$row_number = $day_num + 6;
					}elseif($day_num<=28){
						//開始番号設定
						$row_number = $day_num + 7;
					}elseif($day_num<=31){
						//開始番号設定
						$row_number = $day_num + 8;
					}else{
						echo "ERROR :Day Number is not exist.";
						exit;
					}
					# 曜日別予算
					$w_arr = array( "日" => "numFour", "土" => "numThree", "金" => "numTwo", "木" => "numOne", "水" => "numOne", "火" => "numOne", "月" => "numOne" );
					$budget['dinner']=0;$budget['lunch']=0;
					$result = array_key_exists($working_day, $datas);
					if ($result==true) {
						$budget['dinner']=$this->ceilBudget((int)$dinner['numFive']['tOne']);
						$budget['lunch']=$this->ceilBudget((int)$lunch['numFive']['tOne']);
					}
					else {
						$key = $w_arr[$day];
						$budget['dinner']=$this->ceilBudget((int)$dinner[$key]['tOne']);
						$budget['lunch']=$this->ceilBudget((int)$lunch[$key]['tOne']);
					}
					$obj->setActiveSheetIndex(0)
						->setCellValue('B'.$row_number, $i)
						->setCellValue('C'.$row_number, $day)
						->setCellValue('D'.$row_number, $budget['lunch'])
						->setCellValue('E'.$row_number, $budget['dinner']);
				}
				# sheet2
				$obj->setActiveSheetIndex(1)
					->setCellValue('B2', date('Y年m月', strtotime($working_month)));
				$obj->setActiveSheetIndex(1)
					->setCellValue('E5', $this->ceilBudget($lunch['numOne']['tTwo']))
					->setCellValue('E6', $this->ceilBudget($lunch['numTwo']['tTwo']))
					->setCellValue('E7', $this->ceilBudget($lunch['numThree']['tTwo']))
					->setCellValue('E8', $this->ceilBudget($lunch['numFour']['tTwo']))
					->setCellValue('E9', $this->ceilBudget($lunch['numFive']['tTwo']));
				$obj->setActiveSheetIndex(1)
					->setCellValue('I5', $this->ceilBudget($dinner['numOne']['tTwo']))
					->setCellValue('I6', $this->ceilBudget($dinner['numTwo']['tTwo']))
					->setCellValue('I7', $this->ceilBudget($dinner['numThree']['tTwo']))
					->setCellValue('I8', $this->ceilBudget($dinner['numFour']['tTwo']))
					->setCellValue('I9', $this->ceilBudget($dinner['numFive']['tTwo']));
				$filename = $data_name.'-'.$working_month.'.xlsx';

				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header("Content-Disposition: attachment;filename=$filename");
				header('Cache-Control: max-age=0');
				$writer = PHPExcel_IOFactory::createWriter($obj, 'Excel2007');
				$writer->save('php://output');
				exit;

			}

		}

	}

	public function ceilBudget($fee){
		if($fee!=0){
			$result = ceil($fee/10000)*10000;
		}else{
			$result = 0;
		}
		return $result;
	}

    # Zaim
    public function zaim(){
        $client = $this->createClient();
        #$requestToken = $client->getRequestToken('https://api.zaim.net/v2/auth/request', 'http://localhost/sushikaz_2.0/sales/callback');
		$requestToken = $client->getRequestToken('https://api.zaim.net/v2/auth/request', 'http://localhost/sushikaz_2.0/sales/callback');
        if ($requestToken) {
            $this->Session->write('zaim_request_token', $requestToken);
            $this->redirect('https://auth.zaim.net/users/auth?oauth_token=' . $requestToken->key);
        }
    }

    public function callback(){
        $requestToken = $this->Session->read('zaim_request_token');
        $client = $this->createClient();
        $accessToken = $client->getAccessToken('https://api.zaim.net/v2/auth/access', $requestToken);
        if ($accessToken) {
			$socketResponse=$client->get($accessToken->key, $accessToken->secret, 'https://api.zaim.net/v2/home/money');
            $results = json_decode($socketResponse->body, true);
			debug($results);
        }
    }

    private function createClient() {
        return new OAuthClient('04d7e7839d5ec3c2c687cc577194db7103d41844', '9e5705f1121889c835942ba3ecd016c3df5b295c');
    }

	#SqlImport
	public function sql(){
		if($this->request->is('post')){
			#クッキー値
			$location = $this->myData;
			if($location['Location']['name']=='和光店'){
				#使用モデル宣言
				$this->loadModel("Tgroupsales");
				$this->loadModel("Tdenominationsales");
				$this->loadModel("Ttransaction");
				$this->loadModel("Tstaytimesales");
				$this->loadModel("Tmenusales");
				$this->loadModel("Tmenumaster");
				$model_table_arr = array(
					'`t_グループ別売上`' => 'Tgroupsales',
					'`t_金種別売上`' => 'Tdenominationsales',
					'`t_トランザクション`' => 'Ttransaction',
					'`t_滞留時間帯別売上`' => 'Tstaytimesales',
					'`t_メニュー別売上`' => 'Tmenusales',
					'`t_メニューマスタ`' => 'Tmenumaster'
				);
				$tmp = $this->request->params['form']['file']['tmp_name'];
				$name = $this->request->params['form']['file']['name'];
				$ext = pathinfo($name, PATHINFO_EXTENSION);
				$save_path = WWW_ROOT."files".DS."sql".DS.$name;	//保存先パス
				//if(is_uploaded_file($tmp)) {	//不正なアップロードではないか
					if($ext=='sql'){
						if(move_uploaded_file($tmp, $save_path)){
							$sqls = file($save_path);
							foreach ($sqls as $sql){
								$kws = preg_split('/[\s]+/', $sql, -1, PREG_SPLIT_NO_EMPTY);
								if(isset($kws[0])&&$kws[0]=='INSERT'&&$kws[1]=='IGNORE'){
									if(isset($model_table_arr[$kws[3]])){
										$model_name = $model_table_arr[$kws[3]];
										$this->$model_name->query($sql);
									}
								}
							}
							$this->Session->setFlash('インポートが終了しました。');
							$this->redirect(array('controller'=>'locations', 'action'=>'index'));
						}else{
							echo "Error";
							exit;
						}
					}else{
						$this->Session->setFlash('拡張子が正しくありません。');
					}
				//}
			}
			elseif($location['Location']['name']=='池袋店'||$location['Location']['name']=='赤羽店'){
				#使用モデル宣言
				$this->loadModel("Menu");
				$this->loadModel("MenuSales");
				$this->loadModel("MenuType");
				$this->loadModel("Association");
				$this->loadModel("AirAccountingDetail");

				$tmp = $this->request->params['form']['file']['tmp_name'];
				$name = $this->request->params['form']['file']['name'];
				#ファイルname（売上内訳andメニュー別売上）
				#Airレジ追記2016/12/03
				$file_type=0;
				if(mb_substr($name, 0, 4,"UTF-8")=='会計明細'){
					$file_type = 3;
				}
				else{
					if(substr($name, 0, 4)=='X011'){
						$file_type = 1;	//内訳CSV
					}
					elseif(substr($name, 0, 4)=='Z213'){
						$file_type = 2;	//メニュー別CSV
					}
					#営業月
					$year = date('Y');$month = substr($name, 4, 2);$day = substr($name, 6, 2);
					$date = $year.'-'.$month.'-'.$day;
					$working_day = date('Y-m-d H:i:s',strtotime("$date -1 day"));
				}
				if($file_type==0){echo "File Name Error!!";exit;}
				#アップロード処理
				$ext = pathinfo($name, PATHINFO_EXTENSION);
				$save_path = WWW_ROOT."files".DS."sql".DS.$name;
				if(is_uploaded_file($tmp)) {
					if($ext=='CSV'||$ext=='csv'){
						if(move_uploaded_file($tmp, $save_path)){
							$handle = fopen($save_path, "r");
							if ($handle !== false) {
								# Data 格納
								$records = array();
								while (($line = fgetcsv($handle, 1000, ",")) !== false) {
									if($line[0]!=null){
										$records[] = $line;
									}
								}
								fclose($handle);
								#エンコードエラー
								if($records==null){
									echo "Error:Character Encoding Error";
									exit;
								}else{
									#文字エンコード変換（SJIS=>UTF-8）
									mb_convert_variables('UTF-8','SJIS',$records);
								}
								#ファイル種類分岐
								if($file_type==1){
									#インサート
									$itaba = 0;$drink = 0;$demae = 0;
									foreach($records as $record){
										$num = (int)$record[0];
										if($num <= 10){		//板場
											$itaba += (int)$record[5];
										}elseif($num >= 11 && $num <= 18){	//飲料
											$drink += (int)$record[5];
										}elseif($num == 19){
											$demae += (int)$record[5];
										}elseif($num == 20){
											$itaba += (int)$record[5];
										}
									}
									$sales = $this->Sales->find('first', array(
										'conditions' => array('Sales.location_id'=>$location['Location']['id'], 'Sales.working_day'=>$working_day)
									));
									if($sales==null){
										#店内
										$sales_type = $this->SalesType->find('first', array(
											'conditions' => array('SalesType.location_id' => $location['Location']['id'], 'SalesType.name' => '店内売上')
										));
										$data = array('Sales' => array(
											'location_id' => $location['Location']['id'],
											'type_id' => $sales_type['SalesType']['id'],
											'working_day' => $working_day,
											'fee' => $itaba
										));
										$this->Sales->create(false);
										$this->Sales->save($data);
										#飲料
										$sales_type = $this->SalesType->find('first', array(
											'conditions' => array('SalesType.location_id' => $location['Location']['id'], 'SalesType.name' => '飲料売上')
										));
										$data = array('Sales' => array(
											'location_id' => $location['Location']['id'],
											'type_id' => $sales_type['SalesType']['id'],
											'working_day' => $working_day,
											'fee' => $drink
										));
										$this->Sales->create(false);
										$this->Sales->save($data);
										#出前
										$sales_type = $this->SalesType->find('first', array(
											'conditions' => array('SalesType.location_id' => $location['Location']['id'], 'SalesType.name' => '出前売上')
										));
										$data = array('Sales' => array(
											'location_id' => $location['Location']['id'],
											'type_id' => $sales_type['SalesType']['id'],
											'working_day' => $working_day,
											'fee' => $demae
										));
										$this->Sales->create(false);
										$this->Sales->save($data);
									}

								}
								elseif($file_type==2){
									# location_id=>association_id
									$association = $this->Association->find('all', array(
										'conditions' => array('Association.location_id' => $location['Location']['id'])
									));
									if($association==null||count($association)>=2){
										echo "Association Error!!";
										exit;
									}
									$association_id = $association[0]['Association']['id'];
									foreach($records as $record){
										$menu_id = (int)$record[0];
										$type_id = (int)$record[1];
										$menu_name = $record[2];
										$num = (int)$record[3];$num = $num/100;
										$fee = (int)$record[5];
										# Menu 取得
										$menu = $this->Menu->find('first', array(
											'conditions' => array('Menu.association_id' => $association_id, 'Menu.menu_id' => $menu_id)
										));
										# Menu 新規
										if($menu==null&&$type_id!=null){
											$menu_type = $this->MenuType->find('first', array(
												'conditions' => array('MenuType.association_id' => $association_id, 'MenuType.type_id' => $type_id)
											));
											if($menu_type!=null){
												# MenuType id update
												$type_id = $menu_type['MenuType']['id'];
												$data = array('Menu' => array(
													'menu_id' => $menu_id,
													'association_id' => $association_id,
													'type_id' => $type_id,
													'name' => $menu_name
												));
												$this->Menu->create(false);
												$this->Menu->save($data);
												# Menu 再取得
												$menu = $this->Menu->find('first', array(
													'conditions' => array('Menu.association_id' => $association_id, 'Menu.menu_id' => $menu_id)
												));
											}
										}
										if($menu!=null){
											# Menu id update
											$menu_id = $menu['Menu']['id'];
											# 既存チェック
											$menu_sales = $this->MenuSales->find('first', array(
												'conditions' => array('MenuSales.association_id' => $association[0]['Association']['id'], 'MenuSales.menu_id' => $menu_id, 'MenuSales.working_day' => $working_day)
											));
											if($menu_sales!=null){
												$data = array('MenuSales' => array(
													'id' => $menu_sales['MenuSales']['id'],
													'fee' => $fee,
													'num' => $num
												));
												$this->MenuSales->create(false);
												$this->MenuSales->save($data);
											}else{
												$data = array('MenuSales' => array(
													'association_id' => $association[0]['Association']['id'],
													'menu_id' => $menu_id,
													'working_day' => $working_day,
													'fee' => $fee,
													'num' => $num
												));
												$this->MenuSales->create(false);
												$this->MenuSales->save($data);
											}
										}
									}
								}
								elseif($file_type==3){
									unset($records[0]);
									# 飲料カテゴリ指定
									if($location['Location']['name']=='池袋店'){
										$drink_arr=array("ドリンクその他", "ビール", "ウィスキー", "焼酎", "サワー", "ワイン", "ソフトドリンク", "日本酒", "果実酒");
										$itaba_arr=array();
									}
									elseif($location['Location']['name']=='赤羽店'){
										$drink_arr=array("ドリンクその他", "ソフトドリンク", "割り物", "焼酎ボトル", "焼酎グラス", "サワー・カクテル", "ウイスキー", "ワイン", "日本酒",  "ビール");
										$itaba_arr=array("お造り", "にぎり", "お好みにぎり", "一品料理", "速一品");
									}
									else{
										echo "ERROR: Cookie ID Missing or Incorrect";exit;
									}
									$arr=array();$demae=array();$drink=array();$itaba=array();$kosmo=array();
									foreach($records as $record){
										$air_id = $record[34];
										$air_accounting_detail = $this->AirAccountingDetail->find('first', array(
											'conditions' => array('AirAccountingDetail.location_id' => $location['Location']['id'], 'AirAccountingDetail.air_id' => $air_id)
										));
										if($air_accounting_detail!=null){
											if($this->AirAccountingDetail->getLastInsertID()==null){
												continue;
											}
											else{
												$lastInserted = $this->AirAccountingDetail->find('first', array('conditions' => array('AirAccountingDetail.id' => $this->AirAccountingDetail->getLastInsertID())));
												if($lastInserted['AirAccountingDetail']['air_id']!=$air_id){ continue; }
											}
										}
										$data = array('AirAccountingDetail' => array(
											'location_id' => $location['Location']['id'],
											'取引No' => $record[0],
											'会計日' => $record[1],
											'会計時間' => $record[2],
											'合計' => $record[3],
											'小計' => $record[4],
											'内消費税' => $record[5],
											'現金' => $record[6],
											'Pontaポイント（Airウォレット）' => $record[7],
											'クレジットカード（Airペイ）' => $record[8],
											'電子マネー（Airペイ）' => $record[9],
											'ポイント（Airレジ）' => $record[10],
											'クレジットカード（Square）' => $record[11],
											'モバイル決済（Airレジ）' => $record[12],
											'金券合計' => $record[13],
											'売掛合計' => $record[14],
											'おつり' => $record[15],
											'現金以外おつり不支払額' => $record[16],
											'割引割増' => $record[17],
											'人数' => $record[18],
											'商品点数' => $record[19],
											'滞在時間' => $record[20],
											'テーブルID' => $record[21],
											'レジID' => $record[22],
											'レジ担当者名' => $record[23],
											'カテゴリ名' => $record[24],
											'メニュー名' => $record[25],
											'種別１' => $record[26],
											'種別２' => $record[27],
											'価格' => $record[28],
											'注文数量' => $record[29],
											'割引割増数量' => $record[30],
											'割引割増単価' => $record[31],
											'単位' => $record[32],
											'割引割増合計額' => $record[33],
											'air_id' => $record[34]
										));
										$this->AirAccountingDetail->create(false);
										$this->AirAccountingDetail->save($data);
										# 営業日判定
										if($record[1]!=null&&$record[2]!=null){
											$time = date("Y-m-d H:i:s", strtotime("$record[1] $record[2]"));
											$working_day = $this->judge24Hour($time);
											$arr[$working_day][] = $record;
										}
										# 出前
										if($record[24]=="出前"){
											if(isset($demae[$working_day]['fee'])){ $demae[$working_day]['fee']+=$record[28]*$record[29]; } else { $demae[$working_day]['fee']=$record[28]*$record[29]; }
											if(isset($demae[$working_day]['cnt'])){ $demae[$working_day]['cnt']+=$record[29]; } else { $demae[$working_day]['cnt']=$record[29]; }
										}
										# 飲料
										elseif(in_array($record[24], $drink_arr)){
											if(isset($drink[$working_day])){ $drink[$working_day]+=$record[28]*$record[29]; }else{ $drink[$working_day]=$record[28]*$record[29]; }
										}
										# 板場
										elseif(in_array($record[24], $itaba_arr)){
											if(isset($itaba[$working_day])){ $itaba[$working_day]+=$record[28]*$record[29]; }else{ $itaba[$working_day]=$record[28]*$record[29]; }
										}
										# 宴会（板場/厨房/飲料分割）
										elseif($record[24]=="コース"){
											if(isset($drink[$working_day])){ $drink[$working_day]+=floor($record[28]*$record[29]/3); }else{ $drink[$working_day]=floor($record[28]*$record[29]/3); }
											if(isset($itaba[$working_day])){ $itaba[$working_day]+=floor($record[28]*$record[29]/3); }else{ $itaba[$working_day]=floor($record[28]*$record[29]/3); }
										}
									}
									# データ統合
									if($arr!=null){
										$customer_timezones=$this->CustomerTimezone->find('all', array('conditions' => array('CustomerTimezone.location_id'=>$location['Location']['id'])));
										foreach($arr as $key => $ar){
											$total_fee=0;$customer_arr=array();
											# sales
											$sales = $this->Sales->find('first', array( 'conditions' => array('Sales.location_id'=>$location['Location']['id'], 'Sales.working_day'=>$key) ));
											# credit
											$credit_sales = $this->CreditSales->find('first', array( 'conditions' => array('CreditSales.location_id'=>$location['Location']['id'], 'CreditSales.working_day'=>$key) ));
											# coupon_discount
											$coupon_discount = $this->CouponDiscount->find('first', array( 'conditions' => array('CouponDiscount.location_id'=>$location['Location']['id'], 'CouponDiscount.working_day'=>$key) ));
											# other_discount
											$other_discount = $this->OtherDiscount->find('first', array( 'conditions' => array('OtherDiscount.location_id' => $location['Location']['id'], 'OtherDiscount.working_day' => $key) ));
											# customer_counts
											$customer_count = $this->CustomerCount->find('first', array( 'conditions' => array('CustomerCount.location_id'=>$location['Location']['id'], 'CustomerCount.working_day'=>$key) ));
											# total_sales
											$total_sales = $this->TotalSales->find('first', array( 'conditions' => array('TotalSales.location_id'=>$location['Location']['id'], 'TotalSales.working_day'=>$key) ));
											foreach($ar as $a){
												$total_fee+=$a[3];
												if($location['Location']['name']=='池袋店'){ $credit_type_id = 1; } elseif($location['Location']['name']=='赤羽店'){ $credit_type_id = 4; } else{ $credit_type_id = null; }
												# クレジット
												if($a[14]>0 && $credit_sales==null){
													$data = array('CreditSales' => array(
														'location_id' => $location['Location']['id'],
														'type_id' => $credit_type_id,
														'working_day' => $key,
														'fee' => $a[14]
													));
													$this->CreditSales->create(false);
													$this->CreditSales->save($data);
												}
												# ポイント
												if($location['Location']['name']=='池袋店'){ $other_type_id = 1; } elseif($location['Location']['name']=='赤羽店'){ $other_type_id = 5; } else{ $other_type_id = null; }
												if($a[13]>0&&$other_discount==null){
													$data = array('OtherDiscount' => array(
														'location_id' => $location['Location']['id'],
														'type_id' => $other_type_id,
														'working_day' => $key,
														'customer_name' => '-',
														'fee' => $a[13],
													));
													$this->OtherDiscount->create(false);
													$this->OtherDiscount->save($data);
												}
												# 割引
												if($location['Location']['name']=='池袋店'){ $coupon_type_id = 8; } elseif($location['Location']['name']=='赤羽店'){ $coupon_type_id = 9; } else{ $coupon_type_id = null; }
												if($a[17]<0&&$coupon_discount==null){
													$data = array('CouponDiscount' => array(
														'location_id' => $location['Location']['id'],
														'type_id' => $coupon_type_id,
														'working_day' => $key,
														'customer_name' => '-',
														'fee' => $a[17]*-1,
													));
													$this->CouponDiscount->create(false);
													$this->CouponDiscount->save($data);
												}
												# 客数
												$customer_arr[date("H:i:s", strtotime($a[2])-strtotime($a[20])-60*60*9)] = $a[18];
											}
											if($sales==null){
												# sales 1
												$sales_type = $this->SalesType->find('first', array('conditions' => array('SalesType.location_id' => $location['Location']['id'], 'SalesType.name' => "出前売上")));
												if($sales_type!=null){
													$data = array('Sales' => array(
														'location_id' => $location['Location']['id'],
														'type_id' => $sales_type['SalesType']['id'],
														'working_day' => $key,
														'fee' => $demae[$key]['fee']
													));
													$this->Sales->create(false);
													$this->Sales->save($data);
												}
												# sales 2
												$sales_type = $this->SalesType->find('first', array('conditions' => array('SalesType.location_id' => $location['Location']['id'], 'SalesType.name' => "飲料売上")));
												if($sales_type!=null){
													$data = array('Sales' => array(
														'location_id' => $location['Location']['id'],
														'type_id' => $sales_type['SalesType']['id'],
														'working_day' => $key,
														'fee' => $drink[$key]
													));
													$this->Sales->create(false);
													$this->Sales->save($data);
												}
												# sales 3（池袋と赤羽違うよ）
												if($location['Location']['name']=='池袋店'){
													$sales_type = $this->SalesType->find('first', array('conditions' => array('SalesType.location_id' => $location['Location']['id'], 'SalesType.name' => "店内売上")));
													if($sales_type!=null){
														$data = array('Sales' => array(
															'location_id' => $location['Location']['id'],
															'type_id' => $sales_type['SalesType']['id'],
															'working_day' => $key,
															'fee' => $total_fee-$drink[$key]-$demae[$key]['fee']
														));
														$this->Sales->create(false);
														$this->Sales->save($data);
													}
												}
												elseif($location['Location']['name']=='赤羽店'){
													# sales 3-1
													$sales_type = $this->SalesType->find('first', array('conditions' => array('SalesType.location_id' => $location['Location']['id'], 'SalesType.name' => "板場売上")));
													if($sales_type!=null){
														$data = array('Sales' => array(
															'location_id' => $location['Location']['id'],
															'type_id' => $sales_type['SalesType']['id'],
															'working_day' => $key,
															'fee' => $itaba[$key]
														));
														$this->Sales->create(false);
														$this->Sales->save($data);
													}
													# sales 3-2
													$sales_type = $this->SalesType->find('first', array('conditions' => array('SalesType.location_id' => $location['Location']['id'], 'SalesType.name' => "厨房売上")));
													if($sales_type!=null){
														$data = array('Sales' => array(
															'location_id' => $location['Location']['id'],
															'type_id' => $sales_type['SalesType']['id'],
															'working_day' => $key,
															'fee' => $total_fee-$drink[$key]-$demae[$key]['fee']-$itaba[$key]
														));
														$this->Sales->create(false);
														$this->Sales->save($data);
													}
												}
											}
											if($customer_count==null){
												foreach($customer_timezones as $customer_timezone){
													$count=0;
													$timezone_id = $customer_timezone['CustomerTimezone']['id'];
													$H = date('H', strtotime($customer_timezone['CustomerTimezone']['name']));
													foreach($customer_arr as $k => $customer){
														$explode = explode(":", $k);
														if($H==$explode[0]){ $count+=$customer; }
													}
													$data = array('CustomerCount' => array(
														'location_id' => $location['Location']['id'],
														'timezone_id' => $timezone_id,
														'working_day' => $key,
														'count' => $count
													));
													$this->CustomerCount->create(false);
													$this->CustomerCount->save($data);
												}
											}
											if($total_sales==null){
												# sales
												$sales = $this->Sales->find('all', array(
													'conditions' => array('Sales.location_id'=>$location['Location']['id'], 'Sales.working_day'=>$key)
												));
												# credit
												$credit_sales = $this->CreditSales->find('all', array(
													'conditions' => array('CreditSales.location_id'=>$location['Location']['id'], 'CreditSales.working_day'=>$key)
												));
												# customer_counts
												$customer_counts = $this->CustomerCount->find('all', array(
													'conditions' => array('CustomerCount.location_id'=>$location['Location']['id'], 'CustomerCount.working_day'=>$key)
												));
												#クーポン割引
												$coupon_discounts = array();
												#その他割引
												$other_discounts = $this->OtherDiscount->find('all', array(
													'conditions' => array('OtherDiscount.location_id' => $location['Location']['id'], 'OtherDiscount.working_day' => $key)
												));
												#支出
												$expenses = $this->Expense->find('all', array(
													'conditions' => array('Expense.location_id' => $location['Location']['id'], 'Expense.working_day' => $key)
												));
												#その他情報
												$other_informations = $this->OtherInformation->find('first', array(
													'conditions' => array('OtherInformation.location_id' => $location['Location']['id'], 'OtherInformation.working_day' => $key)
												));
												#売掛集金
												$add_cashes = $this->AddCash->find('all', array(
													'conditions' => array('AddCash.location_id' => $location['Location']['id'], 'AddCash.working_day' => $key)
												));
												$result = $this->Sales->totalSalesCalculator($sales, $credit_sales, $customer_counts, $coupon_discounts, $other_discounts, $expenses, $other_informations, $add_cashes);
												$data = array('TotalSales' => array(
													'location_id' => $location['Location']['id'],
													'working_day' => $key,
													'sales' => $result['sales'],
													'credit_sales' => $result['credit_sales'],
													'customer_counts' => $result['customer_counts'],
													'coupon_discounts' => $result['coupon_discounts'],
													'other_discounts' => $result['other_discounts'],
													'expenses' => $result['expenses'],
													'tax' => $result['tax'],
													'add' => $result['add'],
													'cash' => $result['cash'],
													'demae_cnt' => $demae[$key]['cnt']
												));
												$this->TotalSales->create(false);
												$this->TotalSales->save($data);
											}
										}
									}
								}
								$this->Session->setFlash('インポートが正常に行われました。');
								$this->redirect(array('controller'=>'locations', 'action'=>'index'));
							}

						}
					}
				}
			}
			else{
				$this->Session->setFlash('現在まだ対応していません。');
				$this->redirect(array('controller'=>'locations', 'action'=>'index'));
			}

		}
	}

	#WakoMdb
	private function mdb($working_day, $location_id){
		#売上関連
		$this->loadModel("Tgroupsales");
		$tgroupsales = $this->Tgroupsales->find('all', array(
			'conditions' => array('Tgroupsales.営業日' => $working_day)
		));
		#売上内訳
		$sales_types = $this->SalesType->find('all', array(
			'conditions' => array('SalesType.location_id' => $location_id)
		));
		$sales = $this->Sales->find('first', array(
			'conditions' => array('Sales.location_id'=>$location_id, 'Sales.working_day'=>$working_day)
		));
		#メニュー別売上
		$this->loadModel("Tmenusales");
		$sushi_d = 0;	#寿司飲み放題合計
		$yaki_d = 0;	#焼肉飲み放題合計
		#お得4000円コース
		$sushi4000 = $this->Tmenusales->find('all', array(	#寿司
			'conditions' => array('Tmenusales.営業日' => $working_day, 'Tmenusales.メニュー№' => 1916)
		));
		if($sushi4000!=null){
			foreach($sushi4000 as $sushi4000_one){
				$ct = $sushi4000_one['Tmenusales']['グランド数量'];
				$sushi_d += $ct*1000;
			}
		}
		$yaki4000 = $this->Tmenusales->find('all', array(	#焼肉
			'conditions' => array('Tmenusales.営業日' => $working_day, 'Tmenusales.メニュー№' => 2903)
		));
		if($yaki4000!=null){
			foreach($yaki4000 as $yaki4000_one){
				$ct = $yaki4000_one['Tmenusales']['グランド数量'];
				$yaki_d += $ct*1000;
			}
		}
		#お得5000円コース
		$sushi5000 = $this->Tmenusales->find('all', array(	#寿司
			'conditions' => array('Tmenusales.営業日' => $working_day, 'Tmenusales.メニュー№' => 1913)
		));
		if($sushi5000!=null){
			foreach($sushi5000 as $sushi5000_one){
				$ct = $sushi5000_one['Tmenusales']['グランド数量'];
				$sushi_d += $ct*1200;
			}
		}
		$yaki5000 = $this->Tmenusales->find('all', array(	#焼肉
			'conditions' => array('Tmenusales.営業日' => $working_day, 'Tmenusales.メニュー№' => 2914)
		));
		if($yaki5000!=null){
			foreach($yaki5000 as $yaki5000_one){
				$ct = $yaki5000_one['Tmenusales']['グランド数量'];
				$yaki_d += $ct*1200;
			}
		}

		#新規の場合のみインサート
		if($sales==null){
			if($tgroupsales!=null){
				foreach($tgroupsales as $tgroupsale){
					#金額
					$fee = (int)$tgroupsale['Tgroupsales']['金額'];
					#寿司・板場
					$type_id = 0;
					if($tgroupsale['Tgroupsales']['グループコード']==1){
						foreach ($sales_types as $sales_type){
							if($sales_type['SalesType']['name']=='板場売上'&&$sales_type['Attribute']['name']=='寿司'){
								$type_id = $sales_type['SalesType']['id'];
							}
						}
					}
					#寿司・焼場
					if($tgroupsale['Tgroupsales']['グループコード']==2){
						foreach ($sales_types as $sales_type){
							if($sales_type['SalesType']['name']=='焼場売上'&&$sales_type['Attribute']['name']=='寿司'){
								$type_id = $sales_type['SalesType']['id'];
							}
						}
					}
					#寿司・飲料
					if($tgroupsale['Tgroupsales']['グループコード']==4){
						foreach ($sales_types as $sales_type){
							if($sales_type['SalesType']['name']=='飲料売上'&&$sales_type['Attribute']['name']=='寿司'){
								$type_id = $sales_type['SalesType']['id'];
								#お得コース飲み放題プラス
								$fee = $fee + $sushi_d;
							}
						}
					}
					#焼肉・調理場
					if($tgroupsale['Tgroupsales']['グループコード']==3){
						foreach ($sales_types as $sales_type){
							if($sales_type['SalesType']['name']=='調理場売上'&&$sales_type['Attribute']['name']=='焼肉'){
								$type_id = $sales_type['SalesType']['id'];
								#お得コース飲み放題マイナス
								$fee = $fee - $yaki_d;
							}
						}
					}
					#焼肉・飲料
					if($tgroupsale['Tgroupsales']['グループコード']==5){
						foreach ($sales_types as $sales_type){
							if($sales_type['SalesType']['name']=='飲料売上'&&$sales_type['Attribute']['name']=='焼肉'){
								$type_id = $sales_type['SalesType']['id'];
								#お得コース飲み放題プラス
								$fee = $fee + $yaki_d;
							}
						}
					}
					#寿司（板場・焼場）２分割
					if($tgroupsale['Tgroupsales']['グループコード']==29){
						$itaba_yakiba = (int)$tgroupsale['Tgroupsales']['金額'];
						#お得コース飲み放題マイナス
						$itaba_yakiba = $itaba_yakiba - $sushi_d;
					}
					#寿司・焼肉
					if($tgroupsale['Tgroupsales']['グループコード']==30){
						foreach ($sales_types as $sales_type){
							if($sales_type['SalesType']['name']=='共同売上'&&$sales_type['Attribute']['name']=='寿司・焼肉'){
								$type_id = $sales_type['SalesType']['id'];
							}
						}
					}
					#インサート
					if($type_id!=0){
						$data = array('Sales' => array(
							'location_id' => $location_id,
							'type_id' => $type_id,
							'working_day' => $working_day,
							'fee' => $fee
						));
						#ループ実行文
						$this->Sales->create(false);
						$this->Sales->save($data);
					}
				}
				#寿司（板場・焼場）２分割
				if(isset($itaba_yakiba)&&$itaba_yakiba!=0){
					#寿司・焼き台売上
					$fee = floor($itaba_yakiba/2);
					#板場
					$type_id = 0;
					foreach ($sales_types as $sales_type){
						if($sales_type['SalesType']['name']=='板場売上'&&$sales_type['Attribute']['name']=='寿司'){
							$type_id = $sales_type['SalesType']['id'];
						}
					}
					if($type_id!=0){
						$sales = $this->Sales->find('first', array(
							'conditions' => array('Sales.location_id'=>$location_id, 'Sales.working_day'=>$working_day, 'Sales.type_id'=>$type_id)
						));
						if($sales!=null){
							#既存
							$data = array('Sales' => array(
								'id' => $sales['Sales']['id'],
								'fee' => $sales['Sales']['fee']+$fee
							));
							#ループ実行文
							$this->Sales->create(false);
							$this->Sales->save($data);
						}
					}
					#焼場
					$type_id = 0;
					foreach ($sales_types as $sales_type){
						if($sales_type['SalesType']['name']=='焼場売上'&&$sales_type['Attribute']['name']=='寿司'){
							$type_id = $sales_type['SalesType']['id'];
						}
					}
					if($type_id!=0){
						$sales = $this->Sales->find('first', array(
							'conditions' => array('Sales.location_id'=>$location_id, 'Sales.working_day'=>$working_day, 'Sales.type_id'=>$type_id)
						));
						if($sales!=null){
							#既存
							$data = array('Sales' => array(
								'id' => $sales['Sales']['id'],
								'fee' => $sales['Sales']['fee']+$fee
							));
							#ループ実行文
							$this->Sales->create(false);
							$this->Sales->save($data);
						}
					}
				}
			}
		}
		#ランチ売上
		$sales_lunches = $this->SalesLunch->find('all', array(
			'conditions' => array('SalesLunch.location_id' => $location_id, 'SalesLunch.working_day' => $working_day)
		));
		if($sales_lunches==null){
			#レジデータあり
			if($tgroupsales!=null){
				#寿司
				$data = array('SalesLunch' => array(
					'location_id' => $location_id,
					'working_day' => $working_day,
					'attribute_id' => 1,
					'fee' => 0
				));
				$this->SalesLunch->create();
				$this->SalesLunch->save($data);
				#焼肉
				$data = array('SalesLunch' => array(
					'location_id' => $location_id,
					'working_day' => $working_day,
					'attribute_id' => 2,
					'fee' => 0
				));
				$this->SalesLunch->create();
				$this->SalesLunch->save($data, false);
			}else{
				$today = $this->Attendance->judge24Hour(time());
				#営業日が本日だったらインサート
				if($today==$working_day){
					#寿司
					$data = array('SalesLunch' => array(
						'location_id' => $location_id,
						'working_day' => $working_day,
						'attribute_id' => 1,
						'fee' => 0
					));
					$this->SalesLunch->create();
					$this->SalesLunch->save($data);
					#焼肉
					$data = array('SalesLunch' => array(
						'location_id' => $location_id,
						'working_day' => $working_day,
						'attribute_id' => 2,
						'fee' => 0
					));
					$this->SalesLunch->create();
					$this->SalesLunch->save($data, false);
				}
			}
		}

		#クレジット
		$this->loadModel("Ttransaction");
		$ttransactions = $this->Ttransaction->find('all', array(
			'conditions' => array('Ttransaction.営業日' => $working_day, 'Ttransaction.区分' => 24)
		));
		$credit_types = $this->CreditType->find('all', array(
			'conditions' => array('CreditType.location_id' => $location_id)
		));
		$credit_sales = $this->CreditSales->find('first', array(
			'conditions' => array('CreditSales.location_id' => $location_id, 'CreditSales.working_day' => $working_day)
		));
		#新規の場合のみインサート
		if ($credit_sales == null) {
			if($ttransactions!=null) {
				foreach ($ttransactions as $ttransaction) {
					$type_id = 0;
					#JCB
					if ($ttransaction['Ttransaction']['部門コード'] == 1) {
						foreach ($credit_types as $credit_type) {
							if ($credit_type['CreditType']['name'] == 'JCB') {
								$type_id = $credit_type['CreditType']['id'];
							}
						}
					}
					#DINERS
					if ($ttransaction['Ttransaction']['部門コード'] == 2) {
						foreach ($credit_types as $credit_type) {
							if ($credit_type['CreditType']['name'] == 'VISA') {
								$type_id = $credit_type['CreditType']['id'];
							}
						}
					}
					#DINERS
					if ($ttransaction['Ttransaction']['部門コード'] == 3) {
						foreach ($credit_types as $credit_type) {
							if ($credit_type['CreditType']['name'] == 'DINERS') {
								$type_id = $credit_type['CreditType']['id'];
							}
						}
					}
					#NICOS
					if ($ttransaction['Ttransaction']['部門コード'] == 4) {
						foreach ($credit_types as $credit_type) {
							if ($credit_type['CreditType']['name'] == 'NICOS') {
								$type_id = $credit_type['CreditType']['id'];
							}
						}
					}
					#クレジットインサート
					if ($type_id != 0) {
						$fee = (int)$ttransaction['Ttransaction']['金額'];
						#新規
						$data = array('CreditSales' => array(
							'location_id' => $location_id,
							'type_id' => $type_id,
							'working_day' => $working_day,
							'fee' => $fee
						));
						#ループ実行文
						$this->CreditSales->create(false);
						$this->CreditSales->save($data);

					}
				}
			}
		}

		#支払いオプション種類
		$other_types = $this->OtherType->find('all', array(
			'conditions' => array('OtherType.location_id' => $location_id)
		));
		#支払いオプション（ポイント）
		$this->loadModel("Ttransaction");
		$ttransactions = $this->Ttransaction->find('all', array(
			'conditions' => array('Ttransaction.営業日' => $working_day, 'Ttransaction.区分' => 7)
		));
		$type_id = 0;
		foreach ($other_types as $other_type) {
			if ($other_type['OtherType']['name'] == 'ポイント') {
				$type_id = $other_type['OtherType']['id'];
			}
		}
		if($type_id!=0){
			$other_discounts = $this->OtherDiscount->find('first', array(
				'conditions' => array('OtherDiscount.location_id' => $location_id, 'OtherDiscount.working_day' => $working_day, 'OtherDiscount.type_id' => $type_id)
			));
			#新規のときのみインサート
			if($other_discounts==null){
				if($ttransactions!=null) {
					foreach ($ttransactions as $ttransaction) {
						$fee = (int)$ttransaction['Ttransaction']['金額'];
						$data = array('OtherDiscount' => array(
							'location_id' => $location_id,
							'type_id' => $type_id,
							'working_day' => $working_day,
							'customer_name' => '-',
							'fee' => $fee
						));
						#ループ実行文
						$this->OtherDiscount->create(false);
						$this->OtherDiscount->save($data);
					}
				}
			}
		}

		#支払いオプション（売掛）
		$this->loadModel("Ttransaction");
		$ttransactions = $this->Ttransaction->find('all', array(
			'conditions' => array('Ttransaction.営業日' => $working_day, 'Ttransaction.区分' => 23)
		));
		$type_id = 0;
		foreach ($other_types as $other_type) {
			if ($other_type['OtherType']['name'] == '売掛') {
				$type_id = $other_type['OtherType']['id'];
			}
		}
		if($type_id!=0){
			$other_discounts = $this->OtherDiscount->find('first', array(
				'conditions' => array('OtherDiscount.location_id' => $location_id, 'OtherDiscount.working_day' => $working_day, 'OtherDiscount.type_id' => $type_id)
			));
			#新規のときのみインサート
			if($other_discounts==null){
				if($ttransactions!=null) {
					foreach ($ttransactions as $ttransaction) {
						$fee = (int)$ttransaction['Ttransaction']['金額'];
						$data = array('OtherDiscount' => array(
							'location_id' => $location_id,
							'type_id' => $type_id,
							'working_day' => $working_day,
							'customer_name' => '-',
							'fee' => $fee
						));
						#ループ実行文
						$this->OtherDiscount->create(false);
						$this->OtherDiscount->save($data);
					}
				}
			}
		}
		/*
		$this->loadModel("Tdenominationsales");
		$tdenominationsales = $this->Tdenominationsales->find('all', array(
			'conditions' => array('Tdenominationsales.営業日' => $working_day)
		));
		$other_types = $this->OtherType->find('all', array(
			'conditions' => array('OtherType.location_id' => $location_id)
		));
		$type_id = 0;
		foreach ($other_types as $other_type) {
			if ($other_type['OtherType']['name'] == '売掛') {
				$type_id = $other_type['OtherType']['id'];
			}
		}
		if($type_id!=0){
			$other_discounts = $this->OtherDiscount->find('first', array(
				'conditions' => array('OtherDiscount.location_id' => $location_id, 'OtherDiscount.working_day' => $working_day, 'OtherDiscount.type_id' => $type_id)
			));
			#新規のときのみインサート
			if($other_discounts==null){
				if($tdenominationsales!=null){
					foreach($tdenominationsales as $tdenominationsale) {
						if ($tdenominationsale['Tdenominationsales']['金種コード'] == 6) {
							$fee = (int)$tdenominationsale['Tdenominationsales']['金額'];
							$data = array('OtherDiscount' => array(
								'location_id' => $location_id,
								'type_id' => $type_id,
								'working_day' => $working_day,
								'customer_name' => '-',
								'fee' => $fee
							));
							#ループ実行文
							$this->OtherDiscount->create(false);
							$this->OtherDiscount->save($data);
						}
					}
				}
			}
		}
		*/

		#クーポン
		$this->loadModel("Ttransaction");
		$ttransactions = $this->Ttransaction->find('all', array(
			'conditions' => array('Ttransaction.営業日' => $working_day, 'Ttransaction.区分' => 64)
		));
		$coupon_types = $this->CouponType->find('all', array(
			'conditions' => array('CouponType.location_id'=>$location_id)
		));
		$coupon_discount = $this->CouponDiscount->find('first', array(
			'conditions' => array('CouponDiscount.location_id'=>$location_id, 'CouponDiscount.working_day'=>$working_day)
		));
		#新規の場合のみインサート（食べログ）
		if($coupon_discount==null){
			if($ttransactions!=null){
				foreach($ttransactions as $ttransaction){
					$type_id = 0;
					#金額により場合分け（100以下は値引き、以上は食べログ）
					$fee = (int)$ttransaction['Ttransaction']['金額']*-1;
					if($fee>=100){
						if($ttransaction['Ttransaction']['部門コード']==3){
							foreach($coupon_types as $coupon_type){
								if($coupon_type['CouponType']['name']=='食べログ'){
									$type_id = $coupon_type['CouponType']['id'];
									$data = array('CouponDiscount' => array(	#新規
										'location_id' => $location_id,
										'type_id' => $type_id,
										'working_day' => $working_day,
										'customer_name' => '-',
										'fee' => $fee
									));
									#ループ実行文
									$this->CouponDiscount->create(false);
									$this->CouponDiscount->save($data);
								}
							}
						}
					}
				}
			}
		}

		#端数割引
		$service_type_id = 0;
		foreach ($other_types as $other_type) {
			if ($other_type['OtherType']['name']=='サービス（端数割引）') {
				$service_type_id = $other_type['OtherType']['id'];
			}
		}
		if($service_type_id!=0){
			$other_discount = $this->OtherDiscount->find('first', array(
				'conditions' => array('OtherDiscount.location_id' => $location_id, 'OtherDiscount.working_day' => $working_day, 'OtherDiscount.type_id' => $service_type_id)
			));
			#新規の場合のみインサート（端数割引）
			if($other_discount==null){
				if($ttransactions!=null){
					foreach($ttransactions as $ttransaction){
						#金額により場合分け（100以下は値引き、以上は食べログ）
						$fee = (int)$ttransaction['Ttransaction']['金額']*-1;
						if($fee<100){
							if($ttransaction['Ttransaction']['部門コード']==3){
								#インサート
								$data = array('OtherDiscount' => array(	#新規
									'location_id' => $location_id,
									'type_id' => $service_type_id,
									'working_day' => $working_day,
									'customer_name' => '-',
									'fee' => $fee
								));
								#ループ実行文
								$this->OtherDiscount->create(false);
								$this->OtherDiscount->save($data);
							}
						}
					}
				}
			}
		}

		/*
		$this->loadModel("Tdiscount");
		$tdiscounts = $this->Tdiscount->find('all', array(
			'conditions' => array('Tdiscount.営業日' => $working_day)
		));
		$coupon_types = $this->CouponType->find('all', array(
			'conditions' => array('CouponType.location_id'=>$location_id)
		));
		if($tdiscounts!=null){
			foreach($tdiscounts as $tdiscount){
				$type_id = 0;
				if($tdiscount['Tdiscount']['値引・割引コード']==3){
					foreach($coupon_types as $coupon_type){
						if($coupon_type['CouponType']['name']=='食べログ'){
							$type_id = $coupon_type['CouponType']['id'];
						}
					}
				}
				#インサート
				if($type_id!=0){
					$fee = (int)$tdiscount['Tdiscount']['金額'];
					$coupon_discount = $this->CouponDiscount->find('first', array(
						'conditions' => array('CouponDiscount.location_id'=>$location_id, 'CouponDiscount.working_day'=>$working_day, 'CouponDiscount.type_id'=>$type_id)
					));
					if($coupon_discount==null){
						$data = array('CouponDiscount' => array(	#新規
							'location_id' => $location_id,
							'type_id' => $type_id,
							'working_day' => $working_day,
							'customer_name' => '-',
							'fee' => $fee
						));
					}else{
						$data = array('CouponDiscount' => array(	##既存
							'id' => $coupon_discount['CouponDiscount']['id'],
							'customer_name' => '-',
							'fee' => $fee
						));
					}
					#ループ実行文
					$this->CouponDiscount->create(false);
					$this->CouponDiscount->save($data);
				}
			}
		}
		*/

		#外税
		$this->loadModel("Tstaytimesales");
		$tstaytimesales = $this->Tstaytimesales->find('all', array(
			'conditions' => array('Tstaytimesales.営業日' => $working_day)
		));
		if($tstaytimesales!=null){
			$tax =0;
			foreach($tstaytimesales as $tstaytimesale){
				$tax += $tstaytimesale['Tstaytimesales']['外税'];
			}
			#insert or update
			$other_information = $this->OtherInformation->find('first', array(
				'conditions' => array('OtherInformation.location_id'=>$location_id, 'OtherInformation.working_day'=>$working_day)
			));
			if($other_information==null){
				$data = array('OtherInformation' => array(	#新規
					'location_id' => $location_id,
					'working_day' => $working_day,
					'tax' => $tax
				));
			}else{
				$data = array('OtherInformation' => array(	##既存
					'id' => $other_information['OtherInformation']['id'],
					'tax' => $tax
				));
			}
			#ループ実行文
			$this->OtherInformation->create(false);
			$this->OtherInformation->save($data);
		}

		#支出
		$this->loadModel("Ttransaction");
		$ttransactions = $this->Ttransaction->find('all', array(
			'conditions' => array('Ttransaction.営業日' => $working_day, 'Ttransaction.区分' => 6)
		));
		$expense_types = $this->ExpenseType->find('all', array(
			'conditions' => array('ExpenseType.location_id'=>$location_id)
		));;
		$expenses = $this->Expense->find('first', array(
			'conditions' => array('Expense.location_id'=>$location_id, 'Expense.working_day'=>$working_day)
		));
		#新規のときだけインサート
		if($expenses==null){
			if($ttransactions!=null){
				foreach($ttransactions as $ttransaction){
					$type_id = 0;
					#その他
					foreach ($expense_types as $expense_type) {
						if ($expense_type['ExpenseType']['name'] == 'その他') {
							$type_id = $expense_type['ExpenseType']['id'];
						}
					}
					#インサート
					if($type_id!=0){
						$fee = (int)$ttransaction['Ttransaction']['金額']*-1;
						#新規のときだけインサート
						#新規
						$data = array('Expense' => array(
							'location_id' => $location_id,
							'type_id' => $type_id,
							'working_day' => $working_day,
							'store_name' => '-',
							'product_name' => '-',
							'fee' => $fee
						));
						#ループ実行文
						$this->Expense->create(false);
						$this->Expense->save($data);
					}
				}
			}
		}
		/*
		$this->loadModel("Texpense");
		$texpenses = $this->Texpense->find('all', array(
			'conditions' => array('Texpense.営業日' => $working_day)
		));
		$expense_types = $this->ExpenseType->find('all', array(
			'conditions' => array('ExpenseType.location_id'=>$location_id)
		));;
		if($texpenses!=null){
			foreach($texpenses as $texpense){
				$type_id = 0;
				#その他
				if ($texpense['Texpense']['出金№'] == 1) {
					foreach ($expense_types as $expense_type) {
						if ($expense_type['ExpenseType']['name'] == 'その他') {
							$type_id = $expense_type['ExpenseType']['id'];
						}
					}
				}
				#インサート
				if($type_id!=0){
					$fee = (int)$texpense['Texpense']['金額'];
					$expense = $this->Expense->find('first', array(
						'conditions' => array('Expense.location_id'=>$location_id, 'Expense.working_day'=>$working_day, 'Expense.type_id'=>$type_id)
					));
					#既存
					if($expense==null){
						#新規
						$data = array('Expense' => array(
							'location_id' => $location_id,
							'type_id' => $type_id,
							'working_day' => $working_day,
							'store_name' => '-',
							'product_name' => '-',
							'fee' => $fee
						));
					}else{
						#既存
						$data = array('Expense' => array(
							'id' => $expense['Expense']['id'],
							'fee' => $fee
						));
					}
					#ループ実行文
					$this->Expense->create(false);
					$this->Expense->save($data);
				}
			}
		}
		*/

	}

	# 引数（文字列）
	public function judge24Hour($now){
		#日付
		$working_day = date('Y-m-d', strtotime($now));
		#時刻
		$hour = date('G', strtotime($now));
		if ($hour < 8) {
			$working_day = date('Y-m-d', strtotime("$working_day -1 day"));
			return $working_day;
		} else{
			return $working_day;
		}
	}

}
