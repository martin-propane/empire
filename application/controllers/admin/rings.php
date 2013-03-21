<?php

use Empire\Services\Ring_Helper;
use Empire\Repositories\Ring_Repository;
use Empire\Entities\Ring;
use Empire\Services\Ring_Query;

class Admin_Rings_Controller extends Base_Controller
{
	public $restful = true;
	public $layout = 'layouts.admin';

	public function __construct()
	{
		parent::__construct();
		$this->repo = IoC::resolve('ring_repository');
	}
	public function get_index()
	{
		return Redirect::to_action('admin.rings@view');
	}

	public function get_view()
	{
		$name = Input::get('name');
		$type_id = Input::get('type_id', 'all');
		$sort = Input::get('sort', 'id');
		$order = Input::get('order', 'desc');
		$page = Input::get('page', 1);
		$pictures = Input::get('pictures');

		$per_page = 10;

		$query = new Ring_Query();

		$input = array();
		$input['name'] = $name;
		$input['type_id'] = $type_id;
		$input['sort'] = $sort;
		$input['order'] = $order;
		$input['page'] = $page;

		if ($type_id !== 'all')
			$query->type_id_is($type_id);

		if ($name != null)
			$query->name_like($name);
		
		switch ($sort)
		{
			case 'id':
				$query->sort_id($order);
				break;
			case 'name':
				$query->sort_name($order);
				break;
			case 'display_picture':
				$query->sort_display_picture($order);
				$query->sort_id($order); //makes the results sort nicer
				break;
			case 'type_id':
				$query->sort_type_id($order);
				break;
			case 'price':
				$query->sort_price($order);
				break;
			case 'ring_size':
				$query->sort_ring_size($order);
				break;
		}

		$entities = $query->get();
		$types = IoC::resolve('type_repository')->get_all();

		$count = $query->count();
		$page_count = $count / $per_page;
		if ($count % $per_page)
			$page_count++;

		$this->layout->title = 'View Rings';
		$this->layout->nest('content', 'admin.rings.view', array('count'=>$page_count, 'params'=>$input, 'entities'=>$entities, 'types'=>$types));
	}

	public function get_add()
	{
		$this->layout->title = 'Add Ring';
		$type_repo = IoC::resolve('type_repository');
		$types = $type_repo->get_all();
		$this->layout->nest('content', 'admin.rings.add', array('types'=>$types));
	}

	public function post_add()
	{
		$pictures = Input::get('pictures');

		$pics = Input::file('display_picture');

		$ring = Ring_Helper::create(Input::get(), $pics, $pictures); //helper method also saves

		return Redirect::to_action('admin.rings@view');
	}

	public function get_edit($id)
	{
		$entity = $this->repo->get($id);
		$types = IoC::resolve('type_repository')->get_all();
		$this->layout->title = 'Edit Ring';

		$this->layout->nest('content', 'admin.rings.edit', get_object_vars($entity) + array('types'=>$types));
	}

	public function post_edit($id)
	{
		$pictures = Input::get('pictures');

		$pics = Input::file('display_picture');

		$change = true;

		Ring_Helper::update($id, Input::get(), $pics, $pictures, $change); //will want to change to detect if picture was changed later

		return Redirect::to_action('admin.rings@view');
	}

	public function get_delete($id)
	{
		$entity = $this->repo->get($id);

		$this->repo->remove($entity);

		return Redirect::to_action('admin.rings@view');
	}
}

