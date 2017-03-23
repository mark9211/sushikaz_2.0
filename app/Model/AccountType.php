<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/07/06
 * Time: 20:15
 */
class AccountType extends AppModel {
	//table指定
	public $useTable="account_types";

	//アソシエーション
	public $belongsTo = array(
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id'
		)
	);
}
