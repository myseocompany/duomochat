<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use DB;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Category;


class ProductTypesController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }


	public function index(){
        $model = ProductType::orderBy('id','ASC')->paginate();
        $categories = Category::all();
        $product_types = ProductType::all();
        return view('product_types.index', compact('model','categories','product_types'));
    }

    public function create(){
        $categories = Category::all();
        $product_types = ProductType::all();
        //$categories = Category::whereNotNull('parent_id')->get();
        //$product_types = ProductType::whereNotNull('parent_id')->get();
        return view('product_types.create', compact('categories','product_types'));
    }

    public function store(Request $request){
        $model = new ProductType;
        $model->name = $request->name;
        //$model->parent_id = $request->parent;
        $model->weight = $request->weight;
        if(intval($request->category_id))
            $model->category_id = $request->category_id;

        if(intval($request->parent_id))
            $model->parent_id = $request->parent_id;

        $path = "";
        if($request->hasFile('file')){
            $file     = $request->file('file');
            $path = $file->getClientOriginalName();
            $destinationPath = 'public/product_types/';
            $file->move($destinationPath,$path); 
        }    
        $model->image_url = $path;
        $model->save();
        return redirect('/product_types/');
        //return back();
    }

    public function destroy($id)
    {
        $model = ProductType::find($id);
        $previousRoute = 'public/product_types/';
        $previousImage = $model->image_url;
        if ($model->delete()) {
            if(is_file($previousRoute.$previousImage)){
                unlink($previousRoute.$previousImage);
            }
            return redirect('/product_types')->with('statustwo', 'El Tipo de Producto <strong>'.$model->name.'</strong> fué eliminado con éxito!'); 
        }
    }

    public function edit($id){
        $model = ProductType::find($id);
        $categories = Category::all();
        $product_types = ProductType::all();
        return view('product_types.edit', compact('model','categories','product_types'));
    }

    public function update($id, Request $request){
        $model = ProductType::find($id);
        $model->name = $request->name;
        $model->parent_id = $request->parent_id;
        $model->weight = $request->weight;
        $model->category_id = $request->category_id;
        $path = "";
        $previousRoute = 'public/product_types/';
        $previousImage = $model->image_url;
        if($request->hasFile('file')){
            $file = $request->file('file');
            $path = $file->getClientOriginalName();
            $destinationPath = 'public/product_types/';
            $file->move($destinationPath,$path);
            $model->image_url = $path;
            if(is_file($previousRoute.$previousImage)){//VALIDA SI ESTA LA IMAGEN EN EL SERVIDOR
                unlink($previousRoute.$previousImage);//ELIMINA LA IMAGEN
            }
        }else{
            $model->image_url = $request->image;
        }
        $model->save();
        return redirect('/product_types/');
    }
}