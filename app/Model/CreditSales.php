<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 0:27
 */
class CreditSales extends AppModel {
	//table指定
	public $useTable="credit_sales";

	//アソシエーション
	public $belongsTo = array(
		'CreditType' => array(
			'className' => 'CreditType',
			'foreignKey' => 'type_id'
		)
	);

}
