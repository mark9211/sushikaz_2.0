<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/10/16
 * Time: 21:52
 */
class SalesAttribute extends AppModel {
    //table指定
    public $useTable="sales_attributes";

    //アソシエーション
    public $hasMany = array(
        'SalesType' => array(
            'className' => 'SalesType',
            'foreignKey' => 'attribute_id'
        )
    );

}
