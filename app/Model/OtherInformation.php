<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 1:00
 */
class OtherInformation extends AppModel {
	//table指定
	public $useTable="other_informations";

	//アソシエーション
	public $belongsTo = array(
		'Member' => array(
			'className' => 'Member',
			'foreignKey' => 'member_id'
		)
	);

}
