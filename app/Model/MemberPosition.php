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

}
