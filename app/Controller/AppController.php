<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	# ヘルパー
	public $helpers = array('Html', 'Form');
	# コンポーネンツ
	var $components = array('DebugKit.Toolbar', 'Session', 'Cookie');
	# 使用モデル
	public $uses = array(
		"Location", "Sales", "SalesType", "TotalSales", "CreditSales", "CreditType", "CustomerCount", "CustomerTimezone", "CouponDiscount",
		"CouponType", "OtherDiscount", "OtherType", "Expense", "ExpenseType", "OtherInformation", "SlipNumber", "Attendance", "AttendanceResult",
		"PartyInformation", "Inventory", "Payroll", "Target", "PayableAccount", "Holiday", "SalesLunch", "SalesAttribute", "AddCash", "Member",
		"MemberPost", "MemberPosition", "MemberType", "Passcode", "AccountType",
	);

	public function beforeFilter(){
		#username&passcode
		if($this->Cookie->check('myData')){
			$passcode = $this->Passcode->find('first', array(
				'conditions' => array('Passcode.location_id' => $this->Cookie->read('myData'))
			));
			if($passcode!=null){
				$this->set('passcode', $passcode);
			}
		}
	}

}
