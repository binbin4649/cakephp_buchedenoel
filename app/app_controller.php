<?php
/* SVN FILE: $Id: app_controller.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Short description for class.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 * * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {
    //var $components = array('Session', 'Auth', 'NoHash', 'DebugKit.Toolbar');
    var $components = array('Session', 'Auth', 'NoHash');
    var $uses = array('User', 'Section', 'AmountItem', 'AmountSection', 'AmountUser');
    var $helpers = array('Html', 'Form', 'AddForm', 'Javascript', 'Ajax');

    function beforeFilter(){

    	 // ログインしたユーザーの情報取得
        if (isset($this->Auth)) {
            $this->Auth->authenticate = $this->NoHash;
            $login_user = $this->Auth->user();
            $params = array(
				'conditions'=>array('Section.id'=>$login_user['User']['section_id']),
				'recursive'=>-1,
    			'fields'=>array('Section.name')
			);
			$section_name = $this->Section->find('first', $params);
			$login_user['User']['section_name'] = $section_name['Section']['name'];
			$this->set(array('loginUser'=>$login_user));
        }else{
        	$login_user = false;
        	$this->set(array('loginUser'=>$login_user));
        }

		//actionがaddおよびeditだった場合に、誰がやったのか？ユーザーIDを自動挿入
		if(isset($this->data)){
			if($this->action == 'add'){
				$this->data[$this->modelClass]['created_user'] = $this->Auth->user('id');
			}
			if($this->action == 'reply_add'){
				$this->data[$this->modelClass]['created_user'] = $this->Auth->user('id');
			}
			if($this->action == 'edit'){
				$this->data[$this->modelClass]['updated_user'] = $this->Auth->user('id');
			}
		}
    }

    function beforeRender(){

    	$this->set('opneuser', $this->Auth->user());

    	//created_userとupdated_userを書き換える
    	$ClassName = $this->modelClass;
    	$MethodName = Inflector::variable($ClassName);
    	if(isset($this->viewVars[$MethodName][$ClassName]['created_user'])){
    		$created_user = $this->viewVars[$MethodName][$ClassName]['created_user'];
    		$params = array(
				'conditions'=>array('User.id'=>$created_user),
				'recursive'=>0,
    			'fields'=>array('User.name')
			);
			$created_name = $this->User->find('first', $params);
			$this->viewVars[$MethodName][$ClassName]['created_user'] = $created_name['User']['name'];
		}
		if(isset($this->viewVars[$MethodName][$ClassName]['updated_user'])){
			$updated_user = $this->viewVars[$MethodName][$ClassName]['updated_user'];
			$params = array(
				'conditions'=>array('User.id'=>$updated_user),
				'recursive'=>0,
    			'fields'=>array('User.name')
			);
			$updated_name = $this->User->find('first', $params);
			$this->viewVars[$MethodName][$ClassName]['updated_user'] = $updated_name['User']['name'];
		}
    	if(isset($this->data[$ClassName]['created_user'])){
			$created_user = $this->data[$ClassName]['created_user'];
			$params = array(
				'conditions'=>array('User.id'=>$created_user),
				'recursive'=>0,
    			'fields'=>array('User.name')
			);
			$created_name = $this->User->find('first', $params);
			$this->data[$ClassName]['created_user'] = $created_name['User']['name'];
		}
    	if(isset($this->data[$ClassName]['updated_user'])){
			$updated_user = $this->data[$ClassName]['updated_user'];
			$params = array(
				'conditions'=>array('User.id'=>$updated_user),
				'recursive'=>0,
    			'fields'=>array('User.name')
			);
			$updated_name = $this->User->find('first', $params);
			$this->data[$ClassName]['updated_user'] = $updated_name['User']['name'];
		}

		//ライトメニューに表示する内容
		//$this->set('item_right', $this->AmountItem->top_week());
		//$this->set('section_right', $this->AmountSection->top_week());
		//$this->set('user_right', $this->AmountUser->top_week());
		$amount_data = $this->AmountItem->cacheMethod('86400','top_week', array()); //24時間
		$this->set('item_right', $amount_data);
		$amount_data = $this->AmountSection->cacheMethod('86400','top_week', array()); //24時間
		$this->set('section_right', $amount_data);
		$amount_data = $this->AmountUser->cacheMethod('86400','top_week', array()); //24時間
		$this->set('user_right', $amount_data);
    }



}
?>