<?php

class Association extends AppModel {
    //table指定
    public $useTable="associations";

    // アソシエーション
    public $belongsTo = array(
        'Location' => array(
            'className' => 'Location',
            'foreignKey' => 'location_id'
        ),
        'Attribute' => array(
            'className' => 'SalesAttribute',
            'foreignKey' => 'attribute_id'
        )
    );

    # Location To Association
    public function convertLocationToAssociation($location){
        $location_id = $location['Location']['id'];
        $associations = $this->find('all', array(
            'conditions' => array('location_id' => $location_id)
        ));
        if($associations!=null){
            $cnt = count($associations);
            return $associations;
        }else{
            return false;
        }
    }

}