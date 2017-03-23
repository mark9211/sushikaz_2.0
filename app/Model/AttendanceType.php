<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 0:15
 */
class AttendanceType extends AppModel {
	//table指定
	public $useTable="attendance_types";

	//アソシエーション
	public $hasMany = array(
		'Attendance' => array(
			'className' => 'Attendance',
			'foreignKey' => 'type_id'
		)
	);

}
