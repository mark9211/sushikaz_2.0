<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 0:40
 */
class CouponType extends AppModel {
	//table指定
	public $useTable="coupon_types";

	//アソシエーション
	public $hasMany = array(
		'CouponDiscount' => array(
			'className' => 'CouponDiscount',
			'foreignKey' => 'type_id'
		)
	);

}

