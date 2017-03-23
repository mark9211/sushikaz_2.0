<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2016/01/18
 * Time: 15:01
 */
class KaikakeFee extends AppModel {
    //table指定
    public $useTable="kaikake_fees";

    //アソシエーション
    public $belongsTo = array(
        'Store' => array(
            'className' => 'KaikakeStore',
            'foreignKey' => 'store_id'
        )
    );

}
