<?
class Main extends App {

	static $urlPattern = array();

	function __construct() {
		$this->lib(array('Template', 'Uri'));
		$this->model('User');
		$this->helper('misc');
		$this->libs->Template->set(array(
			'message' => $this->lib('Session')->flash('AdminMessage')
		));
		
		//
	}

	function index() {
		if(!$this->models->User->loggedIn()) { return $this->libs->Uri->redirect('admin');}
		//V::get('admin/pages/brief', array('page' => $v))
		$this->libs->Template->set(array(
			'title' => 'Pages',
			'actions' => B::a(array('href'=> SITE_URL .'admin/addpage'), 'Add Page'),
			'items' => $this->model('Pages')->limit(10)->all(),
			'itemsEach' => function($v) {
				return B::li(V::get('pages/brief', array('page'=> $v)));
			}
		))->render('bases/list');
	}
	
	function single() {
		if(!$this->models->User->loggedIn()) { return $this->libs->Uri->redirect('admin');}
		$page = $this->model('pages')->get($this->libs->Uri->get(2))->one();
		$this->libs->Template->set(array(
			'title' => 'Page: ' . $page->title,
			'content' => 'page test'
		));
		/*
		@todo
		Make this template a genric for a listing
		*/
		$this->libs->Template->render('bases/content');
	}
	
	function add() {
		if(!$this->models->User->loggedIn()) { return $this->libs->Uri->redirect('admin');}
		$this->libs->Template->set(array(
			'title' => 'Add Page',
			'form' => $this->libs->Template->get('parts/addpage')
		));
		
		$this->libs->Template->render('bases/form');
	}
	
	function doadd() {
		if(!$this->models->User->loggedIn()) { return $this->libs->Uri->redirect('admin');}
		if(!$this->model('Pages')->add($_POST)) {
			$this->lib('Session')->flash('AdminMessage', 'Add Page Failed');
			return $this->libs->Uri->redirect('admin/addpage');
		}
		$this->lib('Session')->flash('AdminMessage', $_POST['title'] . ' Added Successfully');
		return $this->libs->Uri->redirect('admin/pages');
	}
}





		/*
		Any time there is a key:
			- there is a sub join needed 
				- Sub joins need:
					- left field name
						- is the key in the parents relation ship structure
							/%
							*'user'* => array(
								'User',
								'id'
							),
							%/
					- right field name
						- is the last element in the parents relation ship structure
							/%
							'user' => array(
								'User',
								*'id'*
							),
							%/
					- table alias
					- right table name = table alias
					- left table name
						- Is the parents alias 
					
					
			- this sub join is based on the realtionShip structure of the key in the current model
		
		
		//Example of a good query:		
		SELECT
		Pages.id, Pages.user, Pages.slug, Pages.title, Pages.description, Pages.content, Pages.dateCreated, user.id AS 'user.id', user.username AS 'user.username', user.email AS 'user.email', user.fullname AS 'user.fullname', user.password AS 'user.password', tags.page AS 'tags.page', tags.tag AS 'tags.tag', tags.user AS 'tags.user', tags_tag.id AS 'tags.tag.id', tags_tag.name AS 'tags.tag.name', tags_user.id AS 'tags.user.id', tags_user.username AS 'tags.user.username', tags_user.email AS 'tags.user.email', tags_user.fullname AS 'tags.user.fullname', tags_user.password AS 'tags.user.password'
		
		FROM (SELECT * FROM Pages) AS Pages	
		 LEFT JOIN Users AS user
			ON Pages.user = user.id 
		 LEFT JOIN PageTags AS tags
			ON Pages.id = tags.page
		 LEFT JOIN Tags AS tags_tag
			ON tags.tag = tags_tag.id
		 LEFT JOIN Users AS tags_user
			ON tags.user = tags_user.id
		
		
		//////////////////==========
		
		pull('user', array('tags' => array('tag', 'user') )):
		SELECT
		Pages.id, Pages.user, Pages.slug, Pages.title, Pages.description, Pages.content, Pages.dateCreated, user.id AS 'user.id', user.username AS 'user.username', user.email AS 'user.email', user.fullname AS 'user.fullname', user.password AS 'user.password', tags.page AS 'tags.page', tags.tag AS 'tags.tag', tags.user AS 'tags.user', tags_tag.id AS 'tags.tag.id', tags_tag.name AS 'tags.tag.name', tags_user.id AS 'tags.user.id', tags_user.username AS 'tags.user.username', tags_user.email AS 'tags.user.email', tags_user.fullname AS 'tags.user.fullname', tags_user.password AS 'tags.user.password'
		
		FROM (SELECT * FROM Pages) AS Pages	
		LEFT JOIN Users AS user
			ON Pages.user = user.id 
		LEFT JOIN PageTags AS tags
			ON Pages.id = tags.page
		LEFT JOIN Tags AS tags_tag
			ON tags.tag = tags_tag.id
		LEFT JOIN Users AS tags_user
			ON tags.user = tags_user.id
		*/

