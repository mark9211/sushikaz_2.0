<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 18/02/07
 * Time: 14:15
 */
class TBreakdown extends AppModel {
    //table指定
    public $useTable="t_breakdowns";

    # アソシ設定
    public $belongsTo = array(
        'MBreakdown' => array(
            'className' => 'MBreakdown',
            'foreignKey' => 'm_id'
        )
    );

}