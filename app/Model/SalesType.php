<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 0:24
 */
class SalesType extends AppModel {
	//table指定
	public $useTable="sales_types";

	//アソシエーション
	public $belongsTo = array(
		'Attribute' => array(
			'className' => 'SalesAttribute',
			'foreignKey' => 'attribute_id'
		)
	);

}
