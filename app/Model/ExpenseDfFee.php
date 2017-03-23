<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2016/01/18
 * Time: 15:00
 */
class ExpenseDfFee extends AppModel {
    //table指定
    public $useTable="expense_df_fees";

    //アソシエーション
    public $belongsTo = array(
        'Type' => array(
            'className' => 'ExpenseDfType',
            'foreignKey' => 'type_id'
        )
    );

}