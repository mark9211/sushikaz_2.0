<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/07/23
 * Time: 12:23
 */
class Holiday extends AppModel {
	//table指定
	public $useTable="holidays";

	//アソシエーション
	public $belongsTo = array(
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id'
		)
	);

	//指定営業日前日記録Bind
	public function beforeWorkingDayIs($working_day, $location_id){
		$i=0;
		while($i < 7){
			$working_day = date('Y-m-d', strtotime("-1 day", strtotime($working_day)));
			$holiday = $this->find('first', array(
				'conditions' => array('location_id' => $location_id, 'day' => date('N', strtotime($working_day)))
			));
			if($holiday==null){
				return $working_day;
				break;
			}
			$i++;
		}
	}

}
