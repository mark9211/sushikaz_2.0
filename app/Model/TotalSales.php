<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 1:01
 */
class TotalSales extends AppModel {
	//table指定
	public $useTable="total_sales";

	//アソシエーション
	public $hasOne = array(
		'Payroll' => array(
			'className' => 'Payroll',
			'foreignKey' => 'total_sales_id'
		)
	);


}
