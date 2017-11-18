<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/07
 * Time: 23:51
 */
class MemberType extends AppModel {
	//table指定
	public $useTable="member_types";

	//アソシエーション
	public $hasMany = array(
		'Member' => array(
			'className' => 'Member',
			'foreignKey'=> 'type_id'
		)
	);

	public $belongsTo = array(
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id'
		)
	);

	public function getMemberTypeId($location_id, $name){
		$member_type = $this->find('first', array(
			'conditions' => array('MemberType.location_id' => $location_id, 'MemberType.name' => $name),
			'fields' => array('MemberType.id')
		));
		return $member_type['MemberType']['id'];
	}

}
