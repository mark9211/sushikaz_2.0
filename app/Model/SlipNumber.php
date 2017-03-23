<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 0:57
 */
class SlipNumber extends AppModel {
	//table指定
	public $useTable="slip_numbers";

	//アソシエーション
	public $belongsTo = array(
		'Type' => array(
			'className' => 'SlipType',
			'foreignKey' => 'type_id'
		)
	);

	public function getByLocationDayType($location_id, $working_day, $type_id){
		$slip_number = $this->find('first', array(
			'conditions' => array('SlipNumber.location_id' => $location_id, 'SlipNumber.working_day' => $working_day, 'SlipNumber.type_id' => $type_id)
		));
		if($slip_number!=null){
			return $slip_number;
		}else{
			return null;
		}
	}

}
