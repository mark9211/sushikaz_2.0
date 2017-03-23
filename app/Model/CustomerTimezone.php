<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 0:36
 */
class CustomerTimezone extends AppModel {
	//table指定
	public $useTable="customer_timezones";

	//アソシエーション
	public $belongsTo = array(
		'Attribute' => array(
			'className' => 'SalesAttribute',
			'foreignKey' => 'attribute_id'
		)
	);

}
