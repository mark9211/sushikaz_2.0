<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2016/01/19
 * Time: 21:16
 */
class IntermediateOne extends AppModel {
    //table指定
    public $useTable="intermediate_one";

    //アソシエーション
    public $belongsTo = array(
        'Association' => array(
            'className' => 'Association',
            'foreignKey' => 'association_id'
        ),
        'Store' => array(
            'className' => 'KaikakeStore',
            'foreignKey' => 'store_id'
        )
    );

}
