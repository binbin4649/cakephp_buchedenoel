<?php
class PostsController extends AppController {

	var $name = 'Posts';
	var $uses = array( 'Post', 'Section', 'User', 'Employment');

	function index() {
		$this->Post->recursive = 0;
		$this->paginate = array(
				'limit'=>20,
				'order'=>array('Post.updated'=>'desc')
			);
		$this->set('posts', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Post', true), array('action'=>'index'));
		}
		$post = $this->Post->read(null, $id);
		$this->set('post', $post);
		$this->set('section', $this->Section->find('list'));
		$this->set('employment', $this->Employment->find('list'));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Post->create();
			if ($this->Post->save($this->data)) {
				$id = $this->Post->getInsertID();
				$this->redirect('/posts/view/'.$id);
			} else {
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Post', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Post->save($this->data)) {
				$this->redirect('/posts/view/'.$id);
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Post->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Post', true), array('action'=>'index'));
		}
		if ($this->Post->del($id) == false) {
			$this->flash(__('Post deleted', true), array('action'=>'index'));
		}
	}


}
?>