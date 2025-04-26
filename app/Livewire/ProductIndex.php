<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class ProductIndex extends Component
{
    use WithPagination;

    public $name, $description, $price;
    public $updateMode = false;
    public $id;

    public function save()
    {
        $this->validate();
        // dd($this->name, $this->description, $this->price);
        $input['name']=$this->name;   
        $input['description']=$this->description;   
        $input['price']=$this->price;  

        if($this->updateMode){
            $product = Product::findOrFail($this->id);
            $product->update($input);
            $this->reset(['name', 'description', 'price']);
            session()->flash('message', 'Product Updated'); 
            $this->updateMode = false;
            $this->id = '';
        }
        else{
            Product::create($input);
            $this->reset(['name', 'description', 'price']);
            session()->flash('message', 'Product Added');
        }
        
    
    }

    public function delete($productId)
    {
        $product = Product::findOrFail($productId);
        // dd($product);
        $product->delete();
        session()->flash('message', 'Product Deleted');
    }

    public function edit($productId)
    {
        $product = Product::findOrFail($productId);
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;

        $this->updateMode = true;

        $this->id = $productId;
        
    }

    protected $rules = [
        'name' => 'required',
        'description' => 'required',
        'price' => 'required|numeric',
    ];

    public function render()
    {
        $data['products'] = Product::latest()->paginate(10);
        // dd($data['product']);
        return view('livewire.product-index', $data);
    }
}
