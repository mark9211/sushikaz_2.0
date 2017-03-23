<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 0:43
 */
class OtherDiscount extends AppModel {
	//table指定
	public $useTable="other_discounts";

	//アソシエーション
	public $belongsTo = array(
		'OtherType' => array(
			'className' => 'OtherType',
			'foreignKey' => 'type_id'
		)
	);

}
