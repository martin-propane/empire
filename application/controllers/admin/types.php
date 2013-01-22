<?php

use Empire\Repositories\Type_Repository;
use Empire\Entities\Type;

class Admin_Types_Controller extends Base_Controller
{
	public $restful = true;
	public $layout = 'layouts.admin';

	public function __construct()
	{
		parent::__construct();
		$this->repo = IoC::resolve('type_repository');
	}
	public function get_index()
	{
		return Redirect::to_action('admin.types@view');
	}

	public function get_view()
	{
		$this->layout->title = 'View Types';
		$entities = $this->repo->get_all();

		$this->layout->nest('content', 'admin.types.view', array('entities'=>$entities));
	}

	public function get_add()
	{
		$this->layout->title = 'Add Type';

		$this->layout->nest('content', 'admin.types.add', array());
	}

	public function post_add()
	{
		$type = new Type(Input::get()); //Repository will validate before inserting into DB

		$this->repo->add($type);

		return Redirect::to_action('admin.types@view');
	}

	public function get_edit($id)
	{
		$entity = $this->repo->get($id);

		$this->layout->title = 'Edit Type';

		$this->layout->nest('content', 'admin.types.edit', get_object_vars($entity));
	}

	public function post_edit($id)
	{
		$entity = $this->repo->get($id);

		$entity->update(Input::get());

		$this->repo->save($entity);

		return Redirect::to_action('admin.types@view');
	}

	public function get_delete($id)
	{
		$entity = $this->repo->get($id);

		$this->repo->remove($entity);

		return Redirect::to_action('admin.types@view');
	}
}

