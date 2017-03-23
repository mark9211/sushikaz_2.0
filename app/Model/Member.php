<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/07
 * Time: 23:39
 */
class Member extends AppModel {
	//table指定
	public $useTable="members";

	//アソシエーション
	public $belongsTo = array(
		'Post' => array(
			'className' => 'MemberPost',
			'foreignKey' => 'post_id'
		),
		'Position' => array(
			'className' => 'MemberPosition',
			'foreignKey' => 'position_id'
		),
		'Type' => array(
			'className' => 'MemberType',
			'foreignKey' => 'type_id'
		),
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id'
		)
	);

	#従業員検索（勤務地別）
	public function getMemberByLocationId($location_id){
		$members = $this->find('all', array(
			"conditions" => array("Member.location_id"=>$location_id)
		));
		return $members;
	}

}
