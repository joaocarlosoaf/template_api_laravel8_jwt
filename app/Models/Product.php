<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image', 'category_id'];

    public function getResults($data, $totalPage)
    {
        if(!isset($data['filter']) && !isset($data['name']) && !isset($data['description']))
            return $this->paginate($totalPage);

        return $this->where(function ($query) use ($data) {
                    if(isset($data['filter'])){
                        $filter = $data['filter'];
                        $query->where('name', $filter);
                        $query->orWhere('description', 'LIKE', "%{$filter}%");
                    }
                    if(isset($data['name'])){
                        $query->where('name', $data['name']);
                    }
                    if(isset($data['description'])){
                        $description = $data['description'];
                        $query->where('description', 'LIKE', "%{$description}%");
                    }
                })
                ->paginate($totalPage); // toSql - para verificar o sql que esta sendo executado
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
