<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 0:23
 */
class Sales extends AppModel {
	//table指定
	public $useTable="sales";

	//アソシエーション
	public $belongsTo = array(
		'Type' => array(
			'className' => 'SalesType',
			'foreignKey' => 'type_id'
		)
	);

	#売上合計計算（引数：配列）
	public function totalSalesCalculator($sales, $credit_sales, $customer_counts, $coupon_discounts, $other_discounts, $expenses, $other_informations, $add_cashes){
		#売上合計
		$total_sales = 0;
		foreach($sales as $sales_one){
			$total_sales += $sales_one['Sales']['fee'];
		}
		#クレジット合計
		$total_credit = 0;
		if($credit_sales!=null){
			foreach($credit_sales as $credit_sales_one){
				$total_credit += $credit_sales_one['CreditSales']['fee'];
			}
		}
		#客数合計
		$total_customer = 0;
		foreach($customer_counts as $customer_count){
			$total_customer += $customer_count['CustomerCount']['count'];
		}
		#クーポン合計
		$total_coupon = 0;
		if($coupon_discounts!=null){
			foreach($coupon_discounts as $coupon_discount){
				#20151005ホットペッパー除外
				if($coupon_discount['CouponDiscount']['location_id']==1 && $coupon_discount['CouponType']['name']=="ホットペッパー"){
					$total_coupon += 0;
				}else{
					$total_coupon += $coupon_discount['CouponDiscount']['fee'];
				}
			}
		}
		#その他割引合計
		$total_discount = 0;
		if($other_discounts!=null){
			foreach($other_discounts as $other_discount){
				$total_discount += $other_discount['OtherDiscount']['fee'];
			}
		}
		#支出合計
		$total_expense = 0;
		if($expenses!=null){
			foreach($expenses as $expense){
				$total_expense += $expense['Expense']['fee'];
			}
		}
		#外税
		$tax = 0;
		if($other_informations!=null){
			$tax = $other_informations['OtherInformation']['tax'];
		}
		#売掛集金
		$add = 0;
		if($add_cashes!=null){
			foreach($add_cashes as $add_cash){
				$add += $add_cash['AddCash']['fee'];
			}
		}
		#残り現金計
		$cash = $total_sales - $total_credit - $total_coupon - $total_discount - $total_expense + $tax + $add;
		$result = array("sales" => $total_sales, "credit_sales" => $total_credit, "customer_counts" => $total_customer, "coupon_discounts" => $total_coupon, "other_discounts" => $total_discount, "expenses" => $total_expense, "tax" => $tax, "add" => $add, "cash" => $cash);
		return $result;
	}

	#検索func
	public function getByLocationDayType($location_id, $working_day, $type_id){
		$sales = $this->find('first', array(
			'conditions' => array('Sales.location_id' => $location_id, 'Sales.working_day' => $working_day, 'Sales.type_id' => $type_id)
		));
		if($sales!=null){
			return $sales;
		}else{
			return null;
		}
	}

	#寿司焼肉振り分け（数字）func
	public function diviseSushiYakiniku($sales){
		$attributes = array();
		foreach($sales as $sales_one){
			if(isset($attributes[$sales_one['Type']['Attribute']['name']])){
				$attributes[$sales_one['Type']['Attribute']['name']] += $sales_one['Sales']['fee'];
			}else{
				$attributes[$sales_one['Type']['Attribute']['name']] = $sales_one['Sales']['fee'];
			}
		}
		#共同売上分割
		if(isset($attributes['寿司'])&&isset($attributes['焼肉'])&&isset($attributes['寿司・焼肉'])){
			if($attributes['寿司・焼肉']!=0){
				$attributes['寿司'] += $attributes['寿司・焼肉']/2;
				$attributes['焼肉'] += $attributes['寿司・焼肉']/2;
			}
			unset($attributes['寿司・焼肉']);
		}
		return $attributes;
	}

	#寿司焼肉振り分け（数字）func
	public function diviseSushiYakinikuAddTax($sales){
		$attributes = array();
		foreach($sales as $sales_one){
			if(isset($attributes[$sales_one['Type']['Attribute']['name']])){
				$attributes[$sales_one['Type']['Attribute']['name']] += floor($sales_one['Sales']['fee']*1.08);
			}else{
				$attributes[$sales_one['Type']['Attribute']['name']] = floor($sales_one['Sales']['fee']*1.08);
			}
		}
		#共同売上分割
		if(isset($attributes['寿司'])&&isset($attributes['焼肉'])&&isset($attributes['寿司・焼肉'])){
			if($attributes['寿司・焼肉']!=0){
				$attributes['寿司'] += $attributes['寿司・焼肉']/2;
				$attributes['焼肉'] += $attributes['寿司・焼肉']/2;
			}
			unset($attributes['寿司・焼肉']);
		}
		return $attributes;
	}

	#ディナー売上計算func
	public function calculateDinnerSales($sales_lunches, $divise_sales){
		#ディナー計算
		foreach($sales_lunches as $sales_lunch){
			if(isset($divise_sales[$sales_lunch['Attribute']['name']])){
				$divise_sales[$sales_lunch['Attribute']['name']] -= $sales_lunch['SalesLunch']['fee'];
			}
		}
		return $divise_sales;
	}

	#寿司焼肉振り分け（配列）func
	public function diviseSushiYakinikuArray($sales){
		$attribute_sales = array();
		foreach ($sales as $sales_one){
			$attribute_sales[$sales_one['Type']['Attribute']['name']][] = $sales_one;
		}
		#共同売上分割
		if(isset($attribute_sales['寿司'])&&isset($attribute_sales['焼肉'])&&isset($attribute_sales['寿司・焼肉'])){
			//debug($attribute_sales['寿司・焼肉'][0]['Sales']['fee']);
			if($attribute_sales['寿司・焼肉'][0]['Sales']['fee']!=0){
				$attribute_sales['寿司・焼肉'][0]['Sales']['fee'] = $attribute_sales['寿司・焼肉'][0]['Sales']['fee']/2;
				$attribute_sales['寿司'][] = $attribute_sales['寿司・焼肉'][0];
				$attribute_sales['焼肉'][] = $attribute_sales['寿司・焼肉'][0];
			}
			unset($attribute_sales['寿司・焼肉']);
		}
		return $attribute_sales;
	}

	#売上合計値取得
	public function salesAddition($location_id, $working_day){
		$sales = $this->find('all', array(
			'conditions' => array('Sales.location_id' => $location_id, 'Sales.working_day' => $working_day)
		));
		$total_fee = 0;
		foreach($sales as $sales_one){
			$total_fee += $sales_one['Sales']['fee'];
		}
		return $total_fee;
	}

	#月間累計売上
	public function monthlySalesAddition($location_id, $month, $type_id_arr){
		$total_fee = 0;
		foreach($type_id_arr as $type_id){
			$sales = $this->find('all', array(
				'conditions' => array('Sales.location_id' => $location_id, 'Sales.working_day LIKE' => '%'.$month.'%', 'Sales.type_id' => $type_id['SalesType']['id'])
			));
			foreach($sales as $sales_one){
				$total_fee += $sales_one['Sales']['fee'];
			}
		}
		return $total_fee;
	}

	#飲料集計
	public function drinkCalculate($sales){
		$attributes = array();
		foreach($sales as $sales_one){
			if(isset($attributes[$sales_one['Type']['Attribute']['name']])){
				if($sales_one['Type']['id']==3||$sales_one['Type']['id']==7||$sales_one['Type']['id']==11||$sales_one['Type']['id']==13){
					$attributes[$sales_one['Type']['Attribute']['name']] += $sales_one['Sales']['fee'];
				}
			}else{
				if($sales_one['Type']['id']==3||$sales_one['Type']['id']==7||$sales_one['Type']['id']==11||$sales_one['Type']['id']==13) {
					$attributes[$sales_one['Type']['Attribute']['name']] = $sales_one['Sales']['fee'];
				}
			}
		}
		#共同売上分割
		if(isset($attributes['寿司'])&&isset($attributes['焼肉'])&&isset($attributes['寿司・焼肉'])){
			if($attributes['寿司・焼肉']!=0){
				$attributes['寿司'] += $attributes['寿司・焼肉']/2;
				$attributes['焼肉'] += $attributes['寿司・焼肉']/2;
			}
			unset($attributes['寿司・焼肉']);
		}
		return $attributes;
	}

}
