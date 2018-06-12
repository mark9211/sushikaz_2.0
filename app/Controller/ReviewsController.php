<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 18/05/21
 * Time: 19:55
 */
class ReviewsController extends AppController{

    # Layout
    public $layout = 'simple';

    # 共通スクリプト
    public function beforeFilter(){
        parent::beforeFilter();
        $this->set('title_for_layout', 'お客様アンケート | 寿し和');
        # ログイン処理
        $this->to_login();
    }

    public function index(){

    }

}