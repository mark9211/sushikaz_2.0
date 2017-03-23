<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 0:50
 */
class PartyInformation extends AppModel {
	//table指定
	public $useTable="party_informations";

	//アソシエーション
	public $belongsTo = array(
		'Type' => array(
			'className' => 'PartyType',
			'foreignKey' => 'type_id'
		)
	);

}
