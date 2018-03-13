<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 18/03/13
 * Time: 23:36
 */
class SecretKey extends AppModel {
    //table指定
    public $useTable="secret_keys";

    #営業日取得byMonth
    public function getByApiName($name){
        $secret_key = $this->find('first', array(
            'conditions' => array('SecretKey.name' => $name,),
        ));
        return $secret_key;
    }

}