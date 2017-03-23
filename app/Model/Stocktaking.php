<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2016/01/12
 * Time: 23:54
 */
class Stocktaking extends AppModel {
    //table指定
    public $useTable="stocktakings";

    //アソシエーション
    public $belongsTo = array(
        'Type' => array(
            'className' => 'StocktakingType',
            'foreignKey' => 'type_id'
        )
    );

}
