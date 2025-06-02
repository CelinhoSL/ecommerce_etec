<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';

    protected $primaryKey = 'id_product';


    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'status',
        'size',
        'color',
        'slug',
        'height',
        'width',
        'weight',
        'category',
        'image',
    ];


   public function registerProduct($data){
    $this->name = $data['name'];
    $this->description = $data['description'];
    $this->price = $data['price'];
    $this->quantity = $data['quantity'];
    $this->status = $data['status'];
    $this->size = $data['size'];
    $this->color = $data['color'];
    $this->slug = $data['slug'];
    $this->height = $data['height'];
    $this->width = $data['width'];
    $this->weight = $data['weight'];
    $this->category = $data['category'];

    if (isset($data['image'])) {
        $this->image = file_get_contents($data['image']->getRealPath()); // salva como BLOB
    }

    return $this->save();
}


    public static function searchByName($name)
    {
        return self::where('name', 'like', '%' . $name . '%')->get();
    }

    public static function updateById($id, array $data)
    {
        return self::where('id_product', $id)->update($data);
    }


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'id_product', 'id_product');
    }


}