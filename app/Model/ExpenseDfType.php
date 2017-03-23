<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2016/01/18
 * Time: 15:00
 */
class ExpenseDfType extends AppModel {
    //table指定
    public $useTable="expense_df_types";

    //アソシエーション
    public $hasMany = array(
        'Intermediate' => array(
            'className' => 'IntermediateThree',
            'foreignKey' => 'type_id',
            'order' => 'association_id asc'
        )
    );

}
