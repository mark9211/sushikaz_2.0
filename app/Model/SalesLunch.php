<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/10/16
 * Time: 21:51
 */
class SalesLunch extends AppModel {
    //table指定
    public $useTable="sales_lunches";

    //アソシエーション
    public $belongsTo = array(
        'Attribute' => array(
            'className' => 'SalesAttribute',
            'foreignKey' => 'attribute_id'
        )
    );
}