<?php


namespace App\Services;


use App\Models\Product;

class ProductService
{
    protected $file;
    public function __construct(FileService $file)
    {
        $this->file = $file;
    }

    public function setter($value) : array
    {
        return  [
            'name' => $value['name'],
            'description' => $value['description'],
            'price' => $value['price'],
            'qty' => $value['qty'],
        ];
    }

    public function store($data, $request): void
    {
        $product = new Product();
        $property = $this->setter($data);
        if ($request->hasFile('image')) {
            $property['image'] = $this->file->storeFile($request);
        }
        $product->create($property);
    }

    public function update($data, $request, $model): void
    {
        $property = $this->setter($data);
        if ($request->hasFile('image')) {
            if($model->image){
                $this->file->removeFile($model->image);
            }
            $property['image'] = $this->file->storeFile($request);
        }
        $model->update($property);
    }

    public function destroy($model) : void
    {
        if($model->image){
            $this->file->removeFile($model->image);
        }
        $model->delete();
    }

    public function updateQty($order): void
    {
        $product = $order->product()->first();
        $updatedQty = $product->qty - $order->qty;
        $product->qty = $updatedQty;
        $product->save();
    }

}
