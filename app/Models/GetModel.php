<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GetModel extends Model
{
    protected $model;

    public function findBy($id)
    {
        switch ($id) {
            case "bank":
                $this->model = new Bank();
                break;
            case "member":
                $this->model = new Member();
                break;
        }

        return $this->model;
    }
}
