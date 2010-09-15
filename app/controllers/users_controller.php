<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $uses = array('User', 'Employment', 'Post', 'Section', 'Depot', 'MemoData');
	var $components = array('OutputCsv', 'Cleaning');

	function login(){
		$this->render('login','login');
	}

	function logout(){
		$this->Session->setFlash('ログアウトしました。');
		$this->Auth->logout();
		$this->redirect(array('controller'=>'top',  'action' => 'index'));
	}

	function index() {
		if ($this->data['User']['start'] == 1) {
			//pr($this->data['User']);
			$conditions = array();
			if(!empty($this->data['User']['word'])){
				$seach_word = $this->data['User']['word'];
				$conditions['or'][] = array('User.name LIKE'=>'%'.$seach_word.'%');
			}
			if(!empty($this->data['User']['section_id'])) $conditions['and'][] = array('section_id'=>$this->data['User']['section_id']);
			if(!empty($this->data['User']['post_id'])) $conditions['and'][] = array('post_id'=>$this->data['User']['post_id']);
			if(!empty($this->data['User']['employment_id'])) $conditions['and'][] = array('employment_id'=>$this->data['User']['employment_id']);
			if($this->data['User']['duty_code'] == '0') $conditions['and'][] = array('duty_code <>'=>'30');
			$this->User->recursive = 0;
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>20,
				'order'=>array('User.updated'=>'desc')
			);
			if($this->data['User']['csv'] == 1){
				$params = array(
					'conditions'=>$conditions,
				);
				$users = $this->User->find('all' ,$params);
				$output_csv = $this->OutputCsv->users($users);
				$file_name = 'user_csv'.date('Ymd-His').'.csv';
				$path = WWW_ROOT.'/files/user_csv/';
				$output_csv = mb_convert_encoding($output_csv, 'SJIS', 'UTF-8');
				file_put_contents($path.$file_name, $output_csv);
				$output['url'] = '/buchedenoel/files/user_csv/'.$file_name;
				$output['name'] = $file_name;
				$this->set('csv', $output);
			}
		}else{
			$this->User->recursive = 0;
			$this->paginate = array(
				'conditions'=>array('duty_code <>'=>'30'),
				'limit'=>20,
				'order'=>array('User.updated'=>'desc')
			);
		}
		$users = $this->paginate();
		foreach($users as $key=>$value){
			$users[$key]['Section']['name'] = $this->Cleaning->sectionName($value['Section']['name']);
		}
		$this->set('users', $users);
		$sections = $this->Section->cleaningList();
		$posts = $this->User->Post->find('list');
		$employments = $this->User->Employment->find('list');
		$this->set(compact('sections', 'posts', 'employments'));
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid User', true), array('action'=>'index'));
		}
		$access_authority = get_access_authority();
		$duty_code = get_duty_code();
		$sex = get_sex();
		$user = $this->User->read(null, $id);
		if(!empty($user['User']['duty_code']))$user['User']['duty_code'] = $duty_code[$user['User']['duty_code']];
		if(!empty($user['User']['access_authority']))$user['User']['access_authority'] = $access_authority[$user['User']['access_authority']];
		if(!empty($user['User']['sex']))$user['User']['sex'] = $sex[$user['User']['sex']];
		$this->set('user', $user);
	}

	function add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$id = $this->User->getInsertID();
				$this->redirect('/users/view/'.$id);
			} else {
				//var_dump($this->User->validationErrors);
			}
		}
		$access_authority = get_access_authority();
		$duty_code = get_duty_code();
		$blood_type = get_blood_type();
		$sex = get_sex();
		$sections = $this->User->Section->find('list');
		$posts = $this->User->Post->find('list');
		$employments = $this->User->Employment->find('list');
		$this->set(compact('sections', 'posts', 'employments', 'sex', 'blood_type', 'duty_code', 'access_authority'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid User', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->redirect('/users/view/'.$id);
			} else {
				$this->data = $this->User->read(null, $id);
				$this->Session->setFlash(__('The Users could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
		$access_authority = get_access_authority();
		$duty_code = get_duty_code();
		$blood_type = get_blood_type();
		$sex = get_sex();
		$posts = $this->User->Post->find('list');
		$employments = $this->User->Employment->find('list');
		$this->set(compact('posts','employments', 'sex', 'blood_type', 'duty_code', 'access_authority'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid User', true), array('action'=>'index'));
		}
		if ($this->User->del($id) == false) {
			$this->flash(__('User deleted', true), array('action'=>'index'));
		}
	}


	function csv_update(){
		if (!empty($this->data['User']['upload_file']['tmp_name'])) {
			$file_name = date('Ymd-His').'user.csv';
			rename($this->data['User']['upload_file']['tmp_name'], WWW_ROOT.DS.'files/temp/'.$file_name);
			$file_stream = file_get_contents(WWW_ROOT.DS.'files/temp/'.$file_name);
			$file_stream = mb_convert_encoding($file_stream, 'UTF-8', 'ASCII,JIS,EUC-JP,SJIS');
			$rename_opne = fopen(WWW_ROOT.DS.'files/temp/en'.$file_name, 'w');
			$result = fwrite($rename_opne, $file_stream);
			fclose($rename_opne);
			$file_open = fopen(WWW_ROOT.DS.'files/temp/en'.$file_name, 'r');
			$csv_header = fgetcsv($file_open, 0, "\t");
			$starter = true;
			if(trim($csv_header[0]) != '所属') $starter = false;
			if(trim($csv_header[1]) != '氏名') $starter = false;
			if(trim($csv_header[2]) != '給与体系コード') $starter = false;
			if(trim($csv_header[3]) != '退職年月日') $starter = false;
			if(trim($csv_header[4]) != '役職コード') $starter = false;
			if(trim($csv_header[5]) != '入社年月日') $starter = false;
			if(trim($csv_header[6]) != '社員番号') $starter = false;
			if(trim($csv_header[7]) != '氏名(ﾌﾘｶﾞﾅ)') $starter = false;
			if(trim($csv_header[8]) != '在籍区分') $starter = false;
			if(trim($csv_header[9]) != '性別') $starter = false;
			if(trim($csv_header[10]) != '生年月日') $starter = false;
			if(trim($csv_header[11]) != '旧姓') $starter = false;
			if(trim($csv_header[12]) != '郵便番号') $starter = false;
			if(trim($csv_header[13]) != '住所１') $starter = false;
			if(trim($csv_header[14]) != '住所２') $starter = false;
			if(trim($csv_header[15]) != '電話番号') $starter = false;
			if($starter == false){
				$this->Session->setFlash('給与奉行から出力したファイルの、項目が足りないか、または項目を間違えています。');
				$this->redirect('/users/csv_update/');
			}

			while($row = fgetcsv($file_open, 0, "\t")){
				$message_counter_save = 0;
				$message_counter_update = 0;
				$user_remarks = '';
				$user_name = trim($row[1]);
				$bugyo_employment = trim($row[2]);
				$params = array(
					'conditions'=>array('Employment.kyuuyo_bugyo_code'=>$bugyo_employment),
					'recursive'=>0
				);
				$find_employment = $this->Employment->find('first' ,$params);
				if($find_employment){
					$user_employment_id = $find_employment['Employment']['id'];
				}else{
					$user_employment_id = '';
				}
				$user_exit_day = $row[3];
				$bugyo_post = trim($row[4]);
				$params = array(
					'conditions'=>array('Post.kyuuyo_bugyo_code'=>$bugyo_post),
					'recursive'=>0
				);
				$find_post = $this->Post->find('first' ,$params);
				if($find_post){
					$user_post_id = $find_post['Post']['id'];
				}else{
					$user_post_id = '';
				}
				$user_join_day = $row[5];
				$user_name_kana = trim($row[7]);//半角ｶﾅ
				$switch_zaishoku = trim($row[8]);//在職区分
				switch($switch_zaishoku){
					case '在籍':
						$user_duty_code = 10;
						break;
					case '退職':
						$user_duty_code = 30;
						break;
					case '休職(支給なし)':
						$user_duty_code = 20;
						break;
					default:
						$user_duty_code = '';
						break;
				}
				if($row[9] == '男性'){
					$user_sex = 'm';
				}elseif($row[9] == '女性'){
					$user_sex = 'f';
				}else{
					$user_sex = '';
				}
				$user_birth_day = $row[10];
				$user_remarks .= trim($row[11]);
				$user_post_code = trim($row[12]);
				$user_adress_one = trim($row[13]);
				$user_adress_two = trim($row[14]);
				$user_tel = trim($row[15]);

				$user_kyuuyo_bugyo_code = trim($row[6]);//社員番号
				$params = array(
					'conditions'=>array('User.kyuuyo_bugyo_code'=>$user_kyuuyo_bugyo_code),
					'recursive'=>0
				);
				$find_user = $this->User->find('first' ,$params);
				if($find_user){//userがあったらidを付けてupdate
					$save_user = array('User'=>array(
						'id'=>$find_user['User']['id'],
						'name'=>$user_name,
						'kyuuyo_bugyo_code'=>$user_kyuuyo_bugyo_code,
						'post_id'=>$user_post_id,
						'employment_id'=>$user_employment_id,
						'name_kana'=>$user_name_kana,
						'sex'=>$user_sex,
						'post_code'=>$user_post_code,
						'adress_one'=>$user_adress_one,
						'adress_two'=>$user_adress_two,
						'tel'=>$user_tel,
						'birth_day'=>$user_birth_day,
						'duty_code'=>$user_duty_code,
						'join_day'=>$user_join_day,
						'exit_day'=>$user_exit_day,
					));
					if($user_duty_code == '30'){//退職者はIDを消す
						//$username = $save_user['User']['username'];
						$randam = mt_rand();
						//$save_user['User']['username'] = $username.$randam;
						$save_user['User']['username'] = $randam;
					}
					$result = $this->User->save($save_user);
					if($result){
						$this->User->id = null;
						$message_counter_update++;
					}else{
						pr($save_user);
						exit;
					}
				}else{//userが無かったら新規追加
					$save_user = array('User'=>array(
						'name'=>$user_name,
						'kyuuyo_bugyo_code'=>$user_kyuuyo_bugyo_code,
						'post_id'=>$user_post_id,
						'employment_id'=>$user_employment_id,
						'name_kana'=>$user_name_kana,
						'sex'=>$user_sex,
						'post_code'=>$user_post_code,
						'adress_one'=>$user_adress_one,
						'adress_two'=>$user_adress_two,
						'tel'=>$user_tel,
						'birth_day'=>$user_birth_day,
						'duty_code'=>$user_duty_code,
						'join_day'=>$user_join_day,
						'exit_day'=>$user_exit_day,
						'username'=>$user_kyuuyo_bugyo_code,
						'password'=>'1122',
						'remarks'=>$user_remarks,
						'access_authority'=>'2',
					));
					if($user_duty_code == '30'){//退職者はIDを消す
						$username = $save_user['User']['username'];
						$randam = mt_rand();
						$save_user['User']['username'] = $username.$randam;
					}
					$result = $this->User->save($save_user);
					if($result){
						$this->User->id = null;
						$message_counter_save++;
						//掲示板に告知
						$contents = $user_name.'さんを新規登録しました。'."\n";
						$contents .= "\n".'自店舗、自部門の方は、'.$user_name.'さんへ教えてあげて下さい。'."\n";
						$contents .= "\n".'マニュアルをよく読んで、早速ログイン＆ユーザー情報を編集しましょう！、と、'.$user_name.'さんへお伝えください。'."\n";
						$contents .= "\n\n".'Buche de Noel へようこそ！！'."\n";
						$contents .= 'この投稿はシステムから半自動で登録されています。'."\n";
						$new_face = array();
						$new_face = array('MemoData'=>array(
							'name'=>$user_name.'　さん。新規登録',
							'memo_category_id'=>22,
							'top_flag'=>'top',
							'contents'=>$contents,
							'created_user'=>'1135',//admin
						));
						$this->MemoData->save($new_face);
					}else{
						pr($save_user);
						exit;
					}
				}
			}
			$this->Session->setFlash(__('CSV UPDATEが終了しました。', true));
			//$this->Session->setFlash(__('CSV UPDATEが終了しました。<br>新規登録：'.$message_counter_save.'<br>更新:'.$message_counter_update, true));
		}
	}


}
?>