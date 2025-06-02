<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $products = \App\Models\Product::all();
    return view('product.index', compact('products'));
    }


    public function image($id)
    {
        $product = Product::findOrFail($id);

        return response($product->image)->header('Content-Type', 'image/jpeg');
    }


    /**
     * Show the form for creating a new resource.
     */
   public function store(Request $request)
{
    $request->merge([
        'price' => str_replace(',', '.', $request->price)
    ]);

    $request->validate([
        'name' => 'required|string|max:100',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'quantity' => 'nullable|integer',
        'status' => 'required|in:1,0',
        'slug' => 'nullable|string|unique:products,slug',
        'size' => 'nullable|string|max:50',
        'color' => 'nullable|string|max:50',
        'height' => 'nullable|string|max:50',
        'width' => 'nullable|string|max:50',
        'weight' => 'nullable|string|max:50',
        'category' => 'required|string|max:100',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $product = new Product();
    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->quantity = $request->quantity ?? 0;
    $product->status = $request->status;
    // Gera o slug automaticamente a partir do nome
    $product->slug = $request->slug ?? Str::slug($request->name, '-');
    $product->size = $request->size;
    $product->color = $request->color;
    $product->height = $request->height;
    $product->width = $request->width;
    $product->weight = $request->weight;
    $product->category = $request->category;
    $product->image = file_get_contents($request->file('image')->getRealPath());
    $product->save();

    return redirect()->back()->with('success', 'Produto cadastrado com sucesso!');
}


    /**
     * Store a newly created resource in storage.
     */
    
    /**
     * Display the specified resource.
     */

   

    public function search(Request $request){
        $searchTerm = $request->input('search');

    if ($searchTerm) {
        $products = Product::searchByName($searchTerm);
    } else {
        // Pode carregar todos ou nenhum produto por padrão
        $products = collect(); // coleção vazia
    }

    return view('admin/editProducts', compact('products', 'searchTerm'));
    }


    public function ajaxSearch(Request $request)
    {
        $search = $request->input('search');
        $products = Product::select('id_product as id', 'name', 'description') // Mapeia jid_product para id
                    ->where('name', 'like', "%{$search}%")
                    ->get();
        
        return response()->json($products);
    }





    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
     
       
        

    }


    public function show($id) 
    {
    $product = Product::where('id_product', $id)->where('quantity', '>', 0)->firstOrFail();
    return view('product.show', compact('product'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->input('product_id');

        // Ajusta vírgulas para pontos no campo 'price' antes da validação
        if ($request->has('price')) {
    $price = str_replace(',', '.', $request->input('price'));
    $request->merge(['price' => $price]);
}


        $data = $request->validate([
            'name' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'quantity' => 'nullable|integer',
            'status' => 'nullable|in:1,0',
            'slug' => 'nullable|string|unique:products,slug,' . $id . ',id_product',
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'height' => 'nullable|string|max:50',
            'width' => 'nullable|string|max:50',
            'weight' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $filteredData = array_filter($data, function ($value) {
    // Remove valores nulos, strings vazias e espaços em branco
            if (is_null($value)) return false;
            if (is_string($value) && trim($value) === '') return false;
            return true;
        });

        Product::updateById($id, $filteredData);

        return redirect()->back()->with('success', 'Produto atualizado com sucesso!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
{
    $productId = $request->product_id;
    $product = Product::find($productId);
    
    if (!$product) {
        return redirect()->back()->with('error', 'Produto não encontrado!');
    }
    
    try {
        \DB::beginTransaction();
        
        // Remove das tabelas dependentes na ordem correta
        \DB::table('cart_item')->where('id_product', $productId)->delete();
        
        // Adicione outras se tiver:
        // \DB::table('order_items')->where('product_id', $productId)->delete();
        // \DB::table('product_reviews')->where('product_id', $productId)->delete();
        
        // Deleta o produto
        $product->delete();
        
        \DB::commit();
        
        return redirect()->back()->with('success', 'Produto excluído com sucesso!');
        
    } catch (\Exception $e) {
        \DB::rollback();
        return redirect()->back()->with('error', 'Erro ao excluir produto.');
    }
}
}
