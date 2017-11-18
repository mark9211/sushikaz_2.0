<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/07
 * Time: 23:50
 */
class MemberPosition extends AppModel {
	//table指定
	public $useTable="member_positions";

	//アソシエーション
	public $hasMany = array(
		'Member' => array(
			'className' => 'Member',
			'foreignKey'=> 'position_id'
		)
	);

	public $belongsTo = array(
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id'
		)
	);

	public function getMemberPositionId($location_id, $name){
		$member_position = $this->find('first', array(
			'conditions' => array('MemberPosition.location_id' => $location_id, 'MemberPosition.name' => $name),
			'fields' => array('MemberPosition.id')
		));
		return $member_position['MemberPosition']['id'];
	}

}
