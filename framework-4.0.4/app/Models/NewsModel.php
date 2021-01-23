<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';

    public function getNews()
    {
        return $this->findAll();
    }
}
