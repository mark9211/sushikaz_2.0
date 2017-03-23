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

}
