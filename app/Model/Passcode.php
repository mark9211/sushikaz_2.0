<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/10/27
 * Time: 22:58
 */
class Passcode extends AppModel {
    //table指定
    public $useTable="passcodes";

    //アソシエーション
    public $belongsTo = array(
        'Location' => array(
            'className' => 'Location',
            'foreignKey' => 'location_id'
        )
    );

}
