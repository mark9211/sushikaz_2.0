<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2016/01/18
 * Time: 15:00
 */
class KaikakeStore extends AppModel {
    //table指定
    public $useTable="kaikake_stores";

    //アソシエーション
    public $belongsTo = array(
        'Type' => array(
            'className' => 'StocktakingType',
            'foreignKey' => 'type_id'
        )
    );

}
