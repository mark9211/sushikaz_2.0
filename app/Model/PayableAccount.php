<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/07/06
 * Time: 20:12
 */
class PayableAccount extends AppModel {
	//table指定
	public $useTable="payable_accounts";

	//アソシエーション
	public $belongsTo = array(
		'Type' => array(
			'className' => 'AccountType',
			'foreignKey' => 'type_id'
		)
	);

	#検索関数By 店舗and営業日and支出先
	public function getByLocationDayType($location_id, $working_day, $type_id){
		$payable_account = $this->find('first', array(
			'conditions' => array('PayableAccount.location_id' => $location_id, 'PayableAccount.working_day' => $working_day, 'PayableAccount.type_id' => $type_id)
		));
		if($payable_account!=null){
			return $payable_account;
		}else{
			return null;
		}
	}

}
