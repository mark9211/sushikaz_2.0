<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/07/04
 * Time: 2:40
 */
class Target extends AppModel {
	//table指定
	public $useTable="targets";

	public function getTargetByDay($location_id, $working_day){
		$target = $this->find('first', array(
			'conditions' => array('location_id' => $location_id)
		));
		if($target!=null){
			#曜日で返す
			if(date('w', strtotime($working_day))==0){
				return $target['Target']['target_three'];
			}elseif(date('w', strtotime($working_day))==5){
				return $target['Target']['target_two'];
			}elseif(date('w', strtotime($working_day))==6){
				return $target['Target']['target_four'];
			}
			else{
				return $target['Target']['target_one'];
			}
		}else{
			return null;
		}
	}
}
