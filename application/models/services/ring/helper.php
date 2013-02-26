<?php namespace Empire\Services;

use Empire\Entities\Ring;
use Empire\Entities\RingPicture;
use Laravel\Validator;
use Laravel\IoC;
use Laravel\File;

class Ring_Helper
{
	public static function create($values, $new_pictures = null, $mapping = null)
	{
		$repo = IoC::resolve('ring_repository');

		$entity = new Ring($values);
		$id = $repo->add($entity);
		$ring_dir = 'rings/'.$id.'/';
		$pictures_dir = 'rings/pictures/';
		if (!is_dir(path('public').$ring_dir))
			mkdir(path('public').$ring_dir); //permissions should be investigated
		if (!is_dir(path('public').$pictures_dir))
			mkdir(path('public').$pictures_dir);

		foreach ($mapping as $o=>$map)
		{
			$map_items = explode(' ', $map);
			$upload_id = $map_items[1];
			$ext = File::extension($new_pictures['name'][$upload_id]); //continue working on this

			//since this method is for creating first time, all pictures should be uploaded

			//first create a new picture
			$picture = new RingPicture(array());
			$pic_id = $repo->add_picture($picture);

			$pic_url = $pictures_dir . $pic_id . '.' . $ext;
			$picture->update(array('order'=>$o, 'url'=>$pic_url, 'ring_id'=>$id));

			$tmp_path = $new_pictures['tmp_name'][$upload_id];
			move_uploaded_file($tmp_path, path('public').$pic_url);

			$repo->save_picture($picture);
		}

		return $entity;
	}

	public static function update($id, $values, $new_pictures = null, $mapping = null, $change = false)
	{
		$repo = IoC::resolve('ring_repository');
		
		$ring_dir = 'rings/'.$id.'/';
		$pictures_dir = 'rings/pictures/';
		if (!is_dir(path('public').$ring_dir)) //technically should already be created, but just in case
			mkdir(path('public').$ring_dir); //permissions should be investigated

		$entity = $repo->get($id);
		unset($values['pictures']);
		$entity->update($values);

		$ring_dir = 'rings/'.$id.'/';
		if (!is_dir(path('public').$ring_dir))
			mkdir(path('public').$ring_dir); //permissions should be investigated
		if (!is_dir(path('public').$pictures_dir))
			mkdir(path('public').$pictures_dir);

		$repo->save($entity);

		if ($change)
		{
			//TODO: Only remove pictures that are not in mapping (although it's only a small efficiency boost)
			foreach ($entity->pictures as $picture)
			{
				$picture->update(array('ring_id'=>null, 'order'=>null));
				$repo->save_picture($picture);
			}

			if ($mapping !== null)
			{
				foreach ($mapping as $o=>$map)
				{
					$map_items = explode(' ', $map);
					$type = $map_items[0];
					if ($type === 'old')
					{
						$pic_id = $map_items[1];
						$picture = $repo->get_picture($pic_id);
						$picture->update(array('ring_id'=>$id, 'order'=>$o));
					}
					else
					{
						$upload_id = $map_items[1];
						$ext = File::extension($new_pictures['name'][$upload_id]); //continue working on this

						//since this method is for creating first time, all pictures should be uploaded

						//first create a new picture
						$picture = new RingPicture(array());
						$pic_id = $repo->add_picture($picture);

						$pic_url = $pictures_dir . $pic_id . '.' . $ext;
						$picture->update(array('order'=>$o, 'url'=>$pic_url, 'ring_id'=>$id));

						$tmp_path = $new_pictures['tmp_name'][$upload_id];
						move_uploaded_file($tmp_path, path('public').$pic_url);
					}

					$repo->save_picture($picture);
				}
			}
		}

	}
}

