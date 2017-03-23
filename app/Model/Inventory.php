<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/07/02
 * Time: 2:59
 */
class Inventory extends AppModel {
	//table指定
	public $useTable="inventories";

	//アソシエーション
	public $belongsTo = array(
		'Type' => array(
			'className' => 'InventoryType',
			'foreignKey' => 'type_id'
		)
	);

	//指定営業日前日記録Bind
	/*
	public function bindRecordBeforeDay($inventory_type, $working_day, $location_id){
		$this->unbindModel(array('belongsTo' => array('Type')));
		$before_working_day = date('Y-m-d', strtotime("-1 day", strtotime($working_day)));
		$inventory = $this->find('first', array(
			'conditions' => array('location_id'=>$location_id, 'working_day'=>$before_working_day, 'type_id'=>$inventory_type['InventoryType']['id'])
		));
		return $inventory;
	}
	*/

	//指定営業日記録Bind
	public function bindRecordToday($inventory_type, $working_day, $location_id){
		$this->unbindModel(array('belongsTo' => array('Type')));
		$inventory = $this->find('first', array(
			'conditions' => array('location_id'=>$location_id, 'working_day'=>$working_day, 'type_id'=>$inventory_type['InventoryType']['id'])
		));
		return $inventory;
	}

}
