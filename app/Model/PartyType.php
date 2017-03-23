<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 0:51
 */
class PartyType extends AppModel {
	//table指定
	public $useTable="party_types";

	//アソシエーション
	public $hasMany = array(
		'PartyInformation' => array(
			'className' => 'PartyInformation',
			'foreignKey' => 'type_id'
		)
	);

}
