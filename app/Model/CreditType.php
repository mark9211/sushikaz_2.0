<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 0:29
 */
class CreditType extends AppModel {
	//table指定
	public $useTable="credit_types";

	//アソシエーション
	public $hasMany = array(
		'CreditSales' => array(
			'className' => 'CreditSales',
			'foreignKey' => 'type_id'
		)
	);

}
