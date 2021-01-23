<?php

namespace App\Controllers;

use App\Models\NewsModel;

class News extends BaseController
{
	public function index()
	{
		$model = new NewsModel();
        var_dump($model->getNews());
	}
}
