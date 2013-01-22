<?php namespace Empire\Services;

use Empire\Entities\Ring;
use Laravel\Validator;
use Laravel\IoC;
use Laravel\File;

class Ring_Helper
{
	public static function create($values, $file_info = null)
	{
		$repo = IoC::resolve('ring_repository');

		$entity = new Ring($values);
		$id = $repo->add($entity);
		$ring_dir = 'rings/'.$id.'/';
		if (!is_dir(path('public').$ring_dir))
			mkdir(path('public').$ring_dir); //permissions should be investigated

		if ($file_info !== null && (File::is('png', $file_info['tmp_name']) || File::is('jpg', $file_info['tmp_name'])))
		{
			$ext = File::extension($file_info['name']); //continue working on this
			$tmp_path = $file_info['tmp_name'];
			$display_path = $ring_dir . 'display.' . $ext;

			move_uploaded_file($tmp_path, path('public').$display_path);

			$entity->display_picture = $display_path;

			$repo->save($entity);
		}

		return $entity;
	}

	public static function update($id, $values, $file_info = null, $change = false)
	{
		$repo = IoC::resolve('ring_repository');
		
		$ring_dir = 'rings/'.$id.'/';
		if (!is_dir(path('public').$ring_dir)) //technically should already be created, but just in case
			mkdir(path('public').$ring_dir); //permissions should be investigated

		$entity = $repo->get($id);
		$entity->update($values);

		$ring_dir = 'rings/'.$id.'/';
		if (!is_dir(path('public').$ring_dir))
			mkdir(path('public').$ring_dir); //permissions should be investigated
		if ($change)
		{
			if ($file_info === null)
				$entity->display_picture = null;
			else
			{
				$ext = File::extension($file_info['name']); //continue working on this
				$tmp_path = $file_info['tmp_name'];
				$display_path = $ring_dir . 'display.' . $ext;

				move_uploaded_file($tmp_path, path('public').$display_path);

				$entity->display_picture = $display_path;
			}
		}

		$repo->save($entity);
	}
}

