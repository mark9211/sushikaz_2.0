<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 0:33
 */
class CustomerCount extends AppModel {
	//table指定
	public $useTable="customer_counts";

	//アソシエーション
	public $belongsTo = array(
		'Timezone' => array(
			'className' => 'CustomerTimezone',
			'foreignKey' => 'timezone_id'
		)
	);

	#検索func
	public function getByLocationDayTimezone($location_id, $working_day, $timezone_id){
		$customer_count = $this->find('first', array(
			'conditions' => array('CustomerCount.location_id' => $location_id, 'CustomerCount.working_day' => $working_day, 'CustomerCount.timezone_id' => $timezone_id)
		));
		if($customer_count!=null){
			return $customer_count;
		}else{
			return null;
		}
	}

	#ランチディナー仕分けfunc
	public function diviseLunchDinner($customer_counts){
		$num_l = array();
		$num_d = array();
		foreach ($customer_counts as $customer_count) {
			#総計
			if((int)$customer_count['Timezone']['name'] < 16){
				if(isset($num_l[$customer_count['Timezone']['Attribute']['name']])){
					$num_l[$customer_count['Timezone']['Attribute']['name']] += $customer_count['CustomerCount']['count'];
				}else{
					$num_l[$customer_count['Timezone']['Attribute']['name']] = $customer_count['CustomerCount']['count'];
				}
			}else{
				if(isset($num_d[$customer_count['Timezone']['Attribute']['name']])){
					$num_d[$customer_count['Timezone']['Attribute']['name']] += $customer_count['CustomerCount']['count'];
				}else{
					$num_d[$customer_count['Timezone']['Attribute']['name']] = $customer_count['CustomerCount']['count'];
				}
			}
		}
		return array("lunch" => $num_l, "dinner" => $num_d);

	}

}
