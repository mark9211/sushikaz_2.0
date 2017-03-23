<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 0:46
 */
class Expense extends AppModel {
	//table指定
	public $useTable="expenses";

	//アソシエーション
	public $belongsTo = array(
		'Type' => array(
			'className' => 'ExpenseType',
			'foreignKey' => 'type_id'
		)
	);

}
