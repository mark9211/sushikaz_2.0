<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 0:48
 */
class ExpenseType extends AppModel {
	//table指定
	public $useTable="expense_types";

	//アソシエーション
	public $hasMany = array(
		'Expense' => array(
			'className' => 'Expense',
			'foreignKey' => 'type_id'
		)
	);

}
