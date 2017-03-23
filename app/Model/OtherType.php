<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 0:45
 */
class OtherType extends AppModel {
	//table指定
	public $useTable="other_types";

	//アソシエーション
	public $hasMany = array(
		'OtherDiscount' => array(
			'className' => 'OtherDiscount',
			'foreignKey' => 'type_id'
		)
	);

}
