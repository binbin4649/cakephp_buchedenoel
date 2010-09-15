<?php
class MemoDatasController extends AppController {

	var $name = 'MemoDatas';
	var $uses = array('MemoData', 'MemoCategory');

	function index() {
		$memo_sections = get_memo_sections();
		$this->MemoData->recursive = 0;
		foreach($memo_sections as $key=>$value){
			$category = 'category'.$key;
			$conditions = array('MemoCategory.memo_sections_id'=>$key);
			//店舗ユーザーの場合は、onlyを表示しない
			if($this->Auth->user('access_authority') == '2') $conditions['MemoData.top_flag <>'] = 'only';
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>5,
				'order'=>array('MemoData.updated'=>'desc')
			);
			$memo_datas = $this->paginate();
			$memo_datas_ext = array();
			foreach($memo_datas as $memo_data){
				$params = array(
					'conditions'=>array('User.id'=>$memo_data['MemoData']['created_user']),
					'recursive'=>0,
    				'fields'=>array('User.name')
				);
				$created_name = $this->User->find('first', $params);
				$memo_data['MemoData']['created_user'] = $created_name['User']['name'];
				$memo_datas_ext[] = $memo_data;
			}
			$this->set($category, $memo_datas_ext);
		}

		$top_flag = get_top_flag();
		$memo_categories = $this->MemoData->MemoCategory->find('list');
		$this->set(compact('memo_categories', 'top_flag', 'memo_sections'));
	}

	function search(){
		$conditions = array();
		$modelName = 'MemoData';
		if (!empty($this->data[$modelName]['word'])) {
			$seach_word = $this->data[$modelName]['word'];
			$conditions['or'] = array($modelName.'.contents LIKE'=>'%'.$seach_word.'%', $modelName.'.name LIKE'=>'%'.$seach_word.'%');
		}else{

		}
		//店舗ユーザーの場合は、onlyを表示しない
		if($this->Auth->user('access_authority') == '2') $conditions['MemoData.top_flag <>'] = 'only';
		$this->paginate = array(
			'conditions'=>$conditions,
			'limit'=>30,
			'order'=>array($modelName.'.created'=>'desc')
		);
		$this->MemoData->recursive = 0;
		$this->set('memoDatas', $this->paginate());
		$memo_sections = get_memo_sections();
		$top_flag = get_top_flag();
		$memo_categories = $this->MemoData->MemoCategory->find('list');
		$this->set(compact('memo_categories', 'top_flag', 'memo_sections'));
	}


	function category_index($id = null) {
		$memo_sections = get_memo_sections();
		$this->MemoData->recursive = 0;
		$conditions = array('MemoData.memo_category_id'=>$id);
		//店舗ユーザーの場合は、onlyを表示しない
		if($this->Auth->user('access_authority') == '2') $conditions['MemoData.top_flag <>'] = 'only';
		$this->paginate = array(
			'conditions'=>$conditions,
			'limit'=>30,
			'order'=>array('MemoData.updated'=>'desc')
		);
		$memo_datas = $this->paginate();
		$memo_datas_ext = array();
		foreach($memo_datas as $memo_data){
			$params = array(
				'conditions'=>array('User.id'=>$memo_data['MemoData']['created_user']),
				'recursive'=>0,
    			'fields'=>array('User.name')
			);
			$created_name = $this->User->find('first', $params);
			$memo_data['MemoData']['created_user'] = $created_name['User']['name'];
			$memo_datas_ext[] = $memo_data;
		}
		$this->set('memoDatas', $memo_datas_ext);

		$top_flag = get_top_flag();
		$memo_categories = $this->MemoData->MemoCategory->find('list');

		$params = array(
			'conditions'=>array('MemoCategory.id'=>$id),
			'recursive'=>0
		);
		$category_page = $this->MemoCategory->find('first', $params);
		$category_name = $category_page['MemoCategory'];
		$section_name = $memo_sections[$category_page['MemoCategory']['memo_sections_id']];
		$this->set(compact('memo_categories', 'top_flag', 'memo_sections', 'section_name', 'category_name'));
	}

	function section_index($id = null) {
		$memo_sections = get_memo_sections();
		$this->MemoData->recursive = 0;
		$conditions = array('MemoCategory.memo_sections_id'=>$id);
		//店舗ユーザーの場合は、onlyを表示しない
		if($this->Auth->user('access_authority') == '2') $conditions['MemoData.top_flag <>'] = 'only';
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>30,
				'order'=>array('MemoData.updated'=>'desc')
			);
		$memo_datas = $this->paginate();
		$memo_datas_ext = array();
		foreach($memo_datas as $memo_data){
			$params = array(
				'conditions'=>array('User.id'=>$memo_data['MemoData']['created_user']),
				'recursive'=>0,
    			'fields'=>array('User.name')
			);
			$created_name = $this->User->find('first', $params);
			$memo_data['MemoData']['created_user'] = $created_name['User']['name'];
			$memo_datas_ext[] = $memo_data;
		}
		$this->set('memoDatas', $memo_datas_ext);

		$top_flag = get_top_flag();
		$memo_categories = $this->MemoData->MemoCategory->find('list');

		$section_name = $memo_sections[$id];
		$this->set(compact('memo_categories', 'top_flag', 'memo_sections', 'section_name'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid MemoData.', true));
			$this->redirect(array('action'=>'index'));
		}
		$memoData = $this->MemoData->read(null, $id);
		$FrpmReplyData = $this->MemoData->read(null, $memoData['MemoData']['reply']);
		$this->set('FrpmReplyData', $FrpmReplyData);
		$this->set('memoData', $memoData);
		$this->set('created_user', $memoData['MemoData']['created_user']);

		$memo_sections = get_memo_sections();

		$params = array(
			'conditions'=>array('MemoData.reply'=>$id),
			'recursive'=>0,
			'order'=>array('MemoData.updated'=>'desc')
		);
		$replymemodata = $this->MemoData->find('all', $params);

		$reply_memo_data = array();
		foreach($replymemodata as $memo_data){
			$params = array(
				'conditions'=>array('User.id'=>$memo_data['MemoData']['created_user']),
				'recursive'=>0,
    			'fields'=>array('User.name')
			);
			$created_name = $this->User->find('first', $params);
			$memo_data['MemoData']['created_user'] = $created_name['User']['name'];
			$reply_memo_data[] = $memo_data;
		}

		//var_dump($reply_memo_data);

		$memo_categories = $this->MemoData->MemoCategory->find('list');
		$this->set(compact('memo_categories', 'memo_sections', 'reply_memo_data'));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->MemoData->create();
			if($this->data['MemoData']['upload_file']['size'] > 8000000){
				$file_name = 'Upload Error:アップロードできるファイルは8MBまで';
			}elseif(!empty($this->data['MemoData']['upload_file']['name'])){
				//$upload_file_name = mb_convert_kana($this->data['MemoData']['upload_file']['name'], 'a', 'UTF-8');
				$upload_file_name = ereg_replace("[^0-9a-z.-_]", "", $this->data['MemoData']['upload_file']['name']);//半角英数記 . - _  ドット　ハイフン　アンダースコア以外を削除
				$file_name = date('Ymd-His').'-'.$upload_file_name;
				$path_name = '/files/memo/';
				rename($this->data['MemoData']['upload_file']['tmp_name'], WWW_ROOT.$path_name.$file_name);
				$this->data['MemoData']['file'] = $file_name;
			}
			if ($this->MemoData->save($this->data)) {
				$memo_data_id = $this->MemoData->getInsertID();
				$this->redirect('/memo_datas/view/'.$memo_data_id);
			} else {
				$this->Session->setFlash(__('The MemoData could not be saved. Please, try again.', true));
			}
		}
		$memo_sections = get_memo_sections();
		$top_flag = get_top_flag();
		//店舗ユーザーの場合は、onlyを省く
		if($this->Auth->user('access_authority') == '2') unset($top_flag['only']);
		if(!empty($id)){
			$params = array('conditions'=>array('MemoCategory.memo_sections_id'=>$id));
			$section_name = $memo_sections[$id];
		}else{
			$params = array();
			$section_name = '';
		}
		$memo_categories = $this->MemoData->MemoCategory->find('list' ,$params);
		$this->set(compact('memo_categories', 'top_flag', 'section_name'));
	}

	function reply_add($id = null) {
		if (!empty($this->data)) {
			$this->MemoData->create();
			if($this->data['MemoData']['upload_file']['size'] > 8000000){
				$file_name = 'Upload Error:アップロードできるファイルは8MBまで';
			}elseif(!empty($this->data['MemoData']['upload_file']['name'])){
				$file_name = date('Ymd-His').'_'.$this->data['MemoData']['upload_file']['name'];
				$path_name = '/files/memo/';
				rename($this->data['MemoData']['upload_file']['tmp_name'], WWW_ROOT.$path_name.$file_name);
				$this->data['MemoData']['file'] = $file_name;
			}
			if ($this->MemoData->save($this->data)) {
				$this->redirect('/memo_datas/view/'.$this->data['MemoData']['reply']);
			} else {
				$this->Session->setFlash(__('The MemoData could not be saved. Please, try again.', true));
			}
		}
		$memo_sections = get_memo_sections();
		$top_flag = get_top_flag();
		$params = array(
			'conditions'=>array('MemoData.id'=>$id),
			'recursive'=>0
		);
		$memo_data = $this->MemoData->find('first', $params);
		$section_name = $memo_sections[$memo_data['MemoCategory']['memo_sections_id']];
		$this->set(compact('memo_data', 'top_flag', 'section_name'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid MemoData', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if(!empty($this->data['MemoData']['upload_file']['name'])){
				$file_name = date('Ymd-His').'_'.$this->data['MemoData']['upload_file']['name'];
				$path_name = '/files/memo/';
				rename($this->data['MemoData']['upload_file']['tmp_name'], WWW_ROOT.$path_name.$file_name);
				$this->data['MemoData']['file'] = $file_name;
			}
			if ($this->MemoData->save($this->data)) {
				$this->redirect('/memo_datas/view/'.$this->data['MemoData']['id']);
			} else {
				$this->Session->setFlash(__('The MemoData could not be saved. Please, try again.', true));
			}
		}

			$this->data = $this->MemoData->read(null, $id);

		$memo_sections = get_memo_sections();
		$top_flag = get_top_flag();
		$params = array('conditions'=>array('MemoCategory.memo_sections_id'=>$this->data['MemoCategory']['memo_sections_id']));
		$memo_categories = $this->MemoData->MemoCategory->find('list' ,$params);
		$section_name = $memo_sections[$this->data['MemoCategory']['memo_sections_id']];
		$this->set(compact('memo_categories', 'top_flag', 'section_name'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for MemoData', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->MemoData->del($id) == false) {
			$this->Session->setFlash(__('MemoData deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


}
?>