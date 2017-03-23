<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/07
 * Time: 23:47
 */
class MemberPost extends AppModel {
	//table指定
	public $useTable="member_posts";

	//アソシエーション
	public $hasMany = array(
		'Member' => array(
			'className' => 'Member',
			'foreignKey'=> 'post_id'
		)
	);

	public $belongsTo = array(
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id'
		)
	);
}
