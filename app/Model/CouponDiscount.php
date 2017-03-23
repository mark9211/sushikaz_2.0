<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 0:39
 */
class CouponDiscount extends AppModel {
	//table指定
	public $useTable="coupon_discounts";

	//アソシエーション
	public $belongsTo = array(
		'CouponType' => array(
			'className' => 'CouponType',
			'foreignKey' => 'type_id'
		)
	);

}
