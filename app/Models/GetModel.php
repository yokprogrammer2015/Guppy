<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GetModel extends Model
{
    protected $model;

    public function findBy($id)
    {
        switch ($id) {
            case "agent":
                $this->model = new Agent();
                break;
            case "bank":
                $this->model = new Bank();
                break;
            case "branch":
                $this->model = new Branch();
                break;
            case "route":
                $this->model = new Route();
                break;
            case "member":
                $this->model = new Member();
                break;
            case "destination":
                $this->model = new Destination();
                break;
            case "time":
                $this->model = new Time();
                break;
            case "bestSeller":
                $this->model = new BestSeller();
                break;
        }

        return $this->model;
    }
}
