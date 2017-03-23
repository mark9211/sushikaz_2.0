<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2016/02/09
 * Time: 15:03
 */
class MenuSales extends AppModel {
    //table指定
    public $useTable="menu_sales";

    //アソシエーション
    public $belongsTo = array(
        'Association' => array(
            'className' => 'Association',
            'foreignKey' => 'association_id'
        ),
        'Menu' => array(
            'className' => 'Menu',
            'foreignKey' => 'menu_id'
        )
    );

}
