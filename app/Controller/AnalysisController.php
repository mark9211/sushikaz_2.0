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
		# Title
		$this->set('title_for_layout', 'メニュー単体分析');
		# クッキー値
		$location = $this->myData;
		# initial値取得
		$menus = $this->get_menus($location['Location']['id']);
		$this->set('menus', $menus);
		$brands = $this->get_brand($location['Location']['id']);
		$this->set('brands', $brands);
		$breakdowns = $this->get_breakdown($location['Location']['id']);
		$this->set('breakdowns', $breakdowns);
		$fds = $this->get_fd($location['Location']['id']);
		$this->set('fds', $fds);
		# POST
		if($this->request->is('post')){
			# params
			$menu_name = $this->request->data['menu_name'];
			$fd = $this->get_fd_by_menu($menu_name);
			$breakdown_name = $this->request->data['breakdown_name'];
			$start_date = $this->request->data['start_date'];
			$end_date = $this->request->data['end_date'];
			# メニューRank
			$sales_rank = $this->get_menu_rank($menu_name, $breakdown_name, $fd, $location['Location']['id'], $start_date, $end_date);
			$this->set('sales_rank', $sales_rank);
			# メニュー情報
			$menu_info = $this->get_menu_info($menu_name, $breakdown_name, $location['Location']['id'], $start_date, $end_date);
			$menu_info = $menu_info[0][0];
			$menu_info['menu_name'] = $menu_name;
			$menu_info['breakdown_name'] = $breakdown_name;
			$menu_info['fd'] = $fd;
			$menu_info['start_date'] = $start_date;
			$menu_info['end_date'] = $end_date;
			$this->set('menu_info', $menu_info);
			# レシート情報
			$receipt_ids = $this->get_receipt_id_by_menu_name($menu_name, $breakdown_name, $location['Location']['id'], $start_date, $end_date);
			$receipt_info = $this->get_receipt_info_by_receipt_ids($receipt_ids, $breakdown_name, $location['Location']['id'], $start_date, $end_date);
			$receipt_info = $receipt_info[0][0];
			$this->set('receipt_info', $receipt_info);
			# メニュー相性
			$food_menus = $this->get_compatible_menus('フード', $menu_name, $receipt_ids, $location['Location']['id'], $start_date, $end_date);
			$this->set('food_menus', $food_menus);
			$drink_menus = $this->get_compatible_menus('ドリンク', $menu_name, $receipt_ids, $location['Location']['id'], $start_date, $end_date);
			$this->set('drink_menus', $drink_menus);
		}
	}

	# init menus
	private function get_menus($location_id){
		$menus = $this->OrderSummary->find('all', array(
			'fields' => ['OrderSummary.menu_name', 'OrderSummary.fd', 'sum(OrderSummary.price * OrderSummary.order_num) as sales'],
			'conditions' => array(
				'OrderSummary.location_id' => $location_id,
				'NOT' => array( 'OrderSummary.menu_name' => '' )
			 ),
			'group' => array('OrderSummary.menu_name'),
			'order' => array('sales DESC'),
		));
		return $menus;
	}

	# init brand
	private function get_brand($location_id){
		$result = $this->OrderSummary->find('all', array(
			'fields' => ['OrderSummary.brand_name'],
			'conditions' => array(
				'OrderSummary.location_id' => $location_id,
				'NOT' => array( 'OrderSummary.brand_name' => '' )
			),
			'group' => array('OrderSummary.brand_name'),
			'order' => array('OrderSummary.brand_name'),
		));
		return $result;
	}

	# init breakdowns
	private function get_breakdown($location_id){
		$result = $this->OrderSummary->find('all', array(
			'fields' => ['OrderSummary.breakdown_name'],
			'conditions' => array(
				'OrderSummary.location_id' => $location_id,
				'NOT' => array( 'OrderSummary.breakdown_name' => '' )
			),
			'group' => array('OrderSummary.breakdown_name'),
			'order' => array('OrderSummary.breakdown_name'),
		));
		return $result;
	}

	# init fd
	private function get_fd($location_id){
		$result = $this->OrderSummary->find('all', array(
			'fields' => ['OrderSummary.fd'],
			'conditions' => array(
				'OrderSummary.location_id' => $location_id,
				'NOT' => array( 'OrderSummary.fd' => '' )
			),
			'group' => array('OrderSummary.fd'),
			'order' => array('OrderSummary.fd'),
		));
		return $result;
	}

	# get fd by menu
	private function get_fd_by_menu($menu_name){
		$result = $this->OrderSummary->find('first', array(
			'fields' => ['OrderSummary.fd'],
			'conditions' => array('OrderSummary.menu_name' => $menu_name),
		));
		return $result['OrderSummary']['fd'];
	}

	# menu sales ranking
	private function get_menu_rank($menu_name, $breakdown_name, $fd, $location_id, $start_date, $end_date){
		# 合計値
		$total = $this->OrderSummary->find('all', array(
			'fields' =>  [
				"sum(CASE WHEN OrderSummary.price > 0 THEN OrderSummary.price * OrderSummary.order_num ELSE OrderSummary.price * OrderSummary.order_num * -1 END) as sales",
				"sum(OrderSummary.order_num) as order_num",
			],
			'conditions' => array(
				'OrderSummary.location_id' => $location_id,
				'OrderSummary.working_day >=' => $start_date,
				'OrderSummary.working_day <=' => $end_date,
				'OrderSummary.breakdown_name' => $breakdown_name,
				'OrderSummary.fd' => $fd,
			),
		));
		$sales = $total[0][0]['sales'];
		# メニュー毎売上
		$result = $this->OrderSummary->find('all', array(
			'fields' =>  [
				"OrderSummary.menu_name",
				"sum(CASE WHEN OrderSummary.price > 0 THEN OrderSummary.price * OrderSummary.order_num ELSE OrderSummary.price * OrderSummary.order_num * -1 END) as sales",
				"sum(OrderSummary.order_num) as order_num",
			],
			'conditions' => array(
				'OrderSummary.location_id' => $location_id,
				'OrderSummary.working_day >=' => $start_date,
				'OrderSummary.working_day <=' => $end_date,
				'OrderSummary.breakdown_name' => $breakdown_name,
				'OrderSummary.fd' => $fd,
			),
			'group' => array('OrderSummary.menu_name'),
			'order' => array('sales DESC'),
		));
		$arr = [];$total_rate=0;
		if($result!=null){
			foreach($result as $r){
				$rate = $r[0]['sales']/$sales;
				$total_rate += $rate;
				$arr[] = array(
					'menu_name'=>$r['OrderSummary']['menu_name'],
					'sales'=>$r[0]['sales'],
					'rate'=>$rate,
					'total_rate'=>$total_rate,
				);
			}
		}
		$new_arr = [];
		$key = array_search($menu_name, array_column($arr, 'menu_name'));
		if($key===false){
			$new_arr['order'] = '圏外';
			$new_arr['denominator'] = count($arr);
			$new_arr['rank'] = 'Z';
		}
		else{
			$new_arr['order'] = $key;
			$new_arr['denominator'] = count($arr);
			switch ($arr[$key]['total_rate']){
				case $arr[$key]['total_rate']<0.7:
					$new_arr['rank'] = 'A';
					break;
				case $arr[$key]['total_rate']>=0.7 && $arr[$key]['total_rate']<0.9:
					$new_arr['rank'] = 'B';
					break;
				case $arr[$key]['total_rate']>=0.9 && $arr[$key]['total_rate']<1:
					$new_arr['rank'] = 'C';
					break;
			}
		}
		return $new_arr;
	}

	# menu info
	private function get_menu_info($menu_name, $breakdown_name, $location_id, $start_date, $end_date){
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
				'OrderSummary.breakdown_name' => $breakdown_name,
			),
		));
		#debug($result);
		return $result;
	}

	# receipt_id
	private function get_receipt_id_by_menu_name($menu_name, $breakdown_name, $location_id, $start_date, $end_date){
		$result = $this->OrderSummary->find('list', array(
			'fields' => ['OrderSummary.receipt_id'],
			'conditions' => array(
				'OrderSummary.location_id' => $location_id,
				'OrderSummary.working_day >=' => $start_date,
				'OrderSummary.working_day <=' => $end_date,
				'OrderSummary.menu_name' => $menu_name,
				'OrderSummary.breakdown_name' => $breakdown_name,
			),
			'group' => array('OrderSummary.receipt_id'),
			'order' => array('OrderSummary.receipt_id'),
		));
		#debug($result);
		return $result;
	}

	# receipt info
	private function get_receipt_info_by_receipt_ids($receipt_ids, $breakdown_name, $location_id, $start_date, $end_date){
		$array = implode("','",$receipt_ids);
		$fields = [
			"count(DISTINCT CASE WHEN ReceiptSummary.receipt_id in ('$array') THEN ReceiptSummary.receipt_id END) as menu_receipt_cnt",
			"sum(CASE WHEN ReceiptSummary.receipt_id in ('$array') THEN ReceiptSummary.total END) as menu_total",
			"sum(CASE WHEN ReceiptSummary.receipt_id in ('$array') THEN ReceiptSummary.quantity END) as menu_quantity",
			"sum(CASE WHEN ReceiptSummary.receipt_id in ('$array') THEN ReceiptSummary.visitors END) as menu_visitors",
			"count(DISTINCT ReceiptSummary.receipt_id) as receipt_cnt",
			"sum(ReceiptSummary.total) as total",
			"sum(ReceiptSummary.quantity) as quantity",
			"sum(ReceiptSummary.visitors) as visitors",
		];
		$result = $this->ReceiptSummary->find('all', array(
			'fields' => $fields,
			'conditions' => array(
				'ReceiptSummary.location_id' => $location_id,
				'ReceiptSummary.working_day >=' => $start_date,
				'ReceiptSummary.working_day <=' => $end_date,
				'ReceiptSummary.breakdown_name' => $breakdown_name,
			),
		));
		#debug($result);
		return $result;
	}

	# menu compatibility
	private function get_compatible_menus($fd, $menu_name, $receipt_ids, $location_id, $start_date, $end_date){
		$fields = [
			"OrderSummary.fd",
			"OrderSummary.category_name",
			"OrderSummary.menu_name",
			"count(OrderSummary.menu_name) as cnt",
		];
		$result = $this->OrderSummary->find('all', array(
			'fields' => $fields,
			'conditions' => array(
				'OrderSummary.location_id' => $location_id,
				'OrderSummary.working_day >=' => $start_date,
				'OrderSummary.working_day <=' => $end_date,
				'OrderSummary.receipt_id' => $receipt_ids,
				'OrderSummary.fd' => $fd,
				'NOT' => array( 'OrderSummary.menu_name' => $menu_name )
			),
			'group' => array('OrderSummary.menu_name'),
			'order' => array('cnt DESC'),
			'limit' => 10,
		));
		#debug($result);
		return $result;
	}

}