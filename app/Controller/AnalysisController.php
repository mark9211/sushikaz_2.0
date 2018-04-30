<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 3:44
 */
class AnalysisController extends AppController{

	#共通スクリプト
	public function beforeFilter(){
		#ページタイトル設定
		parent::beforeFilter();
		$this->set('title_for_layout', '各種分析');
		$this->to_login();
	}

	#インデックス
	public function index(){

	}

	# メニュー単体分析
	public function menu(){
		# クッキー値
		$location = $this->myData;
		# メニュー取得
		$menus = $this->get_menus($location['Location']['id']);
		$this->set('menus', $menus);
		# POST
		if($this->request->is('post')){
			# params
			$menu_name = $this->request->data['menu_name'];
			$start_date = $this->request->data['start_date'];
			$end_date = $this->request->data['end_date'];
			# メニュー情報
			$menu_info = $this->get_menu_info($menu_name, $location['Location']['id'], $start_date, $end_date);
			$menu_info = $menu_info[0][0];
			$menu_info['menu_name'] = $menu_name;
			$menu_info['start_date'] = $start_date;
			$menu_info['end_date'] = $end_date;
			$this->set('menu_info', $menu_info);
			# レシート情報

		}
	}

	# init menus
	private function get_menus($location_id){
		$menus = $this->OrderSummary->find('all', array(
			'conditions' => array(
				'OrderSummary.location_id' => $location_id,
				'NOT' => array( 'OrderSummary.menu_name' => '' )
			 ),
			'group' => array('OrderSummary.menu_name'),
			'order' => array('OrderSummary.menu_name'),
		));
		return $menus;
	}

	# menu info
	private function get_menu_info($menu_name, $location_id, $start_date, $end_date){
		$fields = [
			"avg(CASE WHEN OrderSummary.price > 0 AND OrderSummary.menu_name = '$menu_name' THEN OrderSummary.price END) as menu_price",
			"sum(CASE WHEN OrderSummary.menu_name = '$menu_name' THEN OrderSummary.order_num END) as menu_order_num",
			"count(DISTINCT CASE WHEN OrderSummary.menu_name = '$menu_name' THEN OrderSummary.receipt_id END) as menu_receipt_cnt",
			"sum(CASE WHEN OrderSummary.price > 0 THEN OrderSummary.price * OrderSummary.order_num ELSE OrderSummary.price * OrderSummary.order_num * -1 END) as sales",
			"sum(OrderSummary.order_num) as order_num",
			"count(DISTINCT OrderSummary.receipt_id) as receipt_cnt",
		];
		$result = $this->OrderSummary->find('all', array(
			'fields' => $fields,
			'conditions' => array(
				'OrderSummary.location_id' => $location_id,
				'OrderSummary.working_day >=' => $start_date,
				'OrderSummary.working_day <=' => $end_date,
			),
		));
		return $result;
	}

	# receipt_id
	private function get_receipt_id_by_menu_name($menu_name, $location_id, $start_date, $end_date){

	}

}