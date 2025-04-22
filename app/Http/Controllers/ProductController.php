<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use DB;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductStatus;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{

    public function index(Request $request)
    {
        if (!isset($request->type_id))
            $request->type_id == 1;

        $model = $this->getModel($request);
        //$group = $this->groupModel($request);
        $statuses = ProductStatus::all();
        $types = ProductType::where(function ($query) use ($request) {
            if (isset($request->category_id))
                $query->where('category_id', $request->category_id);
        })->orderBy('weight', 'ASC')->orderBy('category_id', 'ASC')->get();
        $root_types = ProductType::orderBy('weight', 'ASC')->whereNull('parent_id')->get();

        $categories = Category::all();


        //dd($request->type_id );
        return view('products.index', compact('request', 'model',  'statuses', 'categories', 'types', 'root_types'));
    }


    public function indexPublic(Request $request)
    {
        if (!isset($request->type_id))
            $request->type_id == 1;

        $model = $this->getModel($request);
        //$group = $this->groupModel($request);
        $statuses = ProductStatus::all();
        $types = ProductType::where(function ($query) use ($request) {
            if (isset($request->category_id))
                $query->where('category_id', $request->category_id);
        })->orderBy('weight', 'ASC')->orderBy('category_id', 'ASC')->get();
        $root_types = ProductType::orderBy('weight', 'ASC')->whereNull('parent_id')->get();

        $categories = Category::all();

        //dd($request->type_id );
        return view('products.index_public', compact('request', 'model',  'statuses', 'categories', 'types', 'root_types'));
    }

    public function getModel($request)
    {
        $model = Product::where(function ($query) use ($request) {
            $query->where("status_id", 1);
            if (isset($request->from_date) && ($request->from_date != null)) {
                $query->whereBetween('products.updated_at', [$request->from_date, $request->to_date . " 23:59:59"]);
            }
            if (isset($request->status_id) && ($request->status_id != null)) {
                $query->where('products.status_id', $request->status_id);
            }
            if (isset($request->category_id) && ($request->category_id != null)) {
                if ($request->category_id == 1) {
                    $query->whereIn('category_id', [1, 2, 3]);
                } elseif ($request->category_id == 4) {
                    $query->whereIn('category_id', [4, 5, 6]);
                } else {
                    $query->where('category_id', $request->category_id);
                }
            }
            if (isset($request->type_id) && ($request->type_id != null)) {
                if ($request->type_id == 11 || $request->type_id == 10) {
                    $query->whereIn('type_id', ProductType::getChilds(ProductType::getId($request->type_id)));
                } else {
                    $query->where('type_id', $request->type_id);
                }
            }
            if (isset($request->keyword) && ($request->keyword != null)) {
                $query->where(function ($innerQuery) use ($request) {
                    $innerQuery->orwhere('products.name', "like", "%$request->keyword%");
                });
            }

            $query->where('quantity', '>', 0);
        })
            ->select('id', 'name', 'status_id', 'price', 'type_id', 'updated_at', 'category_id', 'quantity','image_url')
            ->orderBy('name', 'ASC')
            ->get();

        return $model;
    }

    public function groupModel($request)
    {
        $model = Product::rightJoin('product_statuses', 'product_statuses.id', 'status_id')
            ->where(

                // Búsqueda por...
                function ($query) use ($request) {
                    $query->where("status_id", 1);
                    if (isset($request->status_id)  && ($request->status_id != null))
                        $query = $query->where('products.status_id', $request->status_id);

                    if (isset($request->category_id)  && ($request->category_id != null))
                        if ($request->category_id == 1)
                            $query->whereIn('category_id', [2, 3]);
                        elseif ($request->category_id == 4)
                            $query->whereIn('category_id', [5, 6]);
                        else
                            $query = $query->where('category_id', $request->category_id);


                    if (isset($request->type_id)  && ($request->type_id != null))
                        if ($request->type_id == 11 || $request->type_id == 10)
                            $query->whereIn('type_id', ProductType::getChilds(ProductType::getId($request->type_id)));
                        else
                            $query->where('type_id', $request->type_id);

                    if (isset($request->search)  && ($request->search != null))
                        $query = $query->where(
                            function ($innerQuery) use ($request) {
                                $innerQuery = $innerQuery->orwhere('products.name', "like", "%" . $request->search . "%");
                            }
                        );
                }

            )
            ->select(DB::raw('product_statuses.id as status_id, product_statuses.name, product_statuses.color, count(products.id) as count, sum(products.price) as price'))
            ->groupBy('product_statuses.id')
            ->groupBy('product_statuses.name')
            ->groupBy('product_statuses.color')
            ->groupBy('weight')
            ->orderBy('weight', 'ASC')
            ->get();

        return $model;
    }


    public function show($id)
    {
        $model = Product::find($id);
        // dd($model);
        $statuses = ProductStatus::all();
        $types = ProductType::all();
        $categories = Category::all();
        return view('products.show', compact('model', 'statuses', 'categories', 'types'));
    }

    public function edit($id)
    {
        $model = Product::find($id);

        $statuses = ProductStatus::all();
        $types = ProductType::all();
        $categories = Category::all();

        return view('products.edit', compact('model', 'statuses', 'categories', 'types'));
    }

    public function update($id, Request $request)
    {
        $model = Product::find($id);

        $model->location = $request->location;
        $model->name = $request->name;

        if ($request->has('category_id')) {
            if (!empty($request->category_id) && is_numeric($request->category_id)) {
                $model->category_id = $request->category_id;
            } else {
                $model->category_id = null;
            }
        }
        $model->reference = $request->reference;
        $model->quantity = $request->quantity;
        $model->type_id = $request->type_id;
        $model->status_id = $request->status_id;
        $model->price = $request->price;
        $model->notes = $request->notes;

        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $name = time() . '_' . $file->getClientOriginalName(); // Genera un nombre único
            $file->storeAs('public/products', $name); // Guarda el archivo en storage/app/public/products
            $product->image_url = 'products/' . $name; // Guarda solo la ruta relativa
        
        }

        $model->save();

        return redirect('/products/' . $id . '/show');
    }

    public function create()
    {

        $statuses = ProductStatus::all();

        $types = ProductType::all();
        $categories = Category::all();

        return view('products.create', compact('statuses', 'categories', 'types'));
    }

    public function store(Request $request)
{
    
    $product = new Product();
    $product->name = $request->name;
    $product->price = $request->price;
    $product->category_id = $request->category_id;
    $product->status_id = $request->status_id;
    $product->quantity = $request->quantity;
    $product->reference = $request->reference;

    $product->save();
    // Si se sube una imagen, procesarla
    if ($request->hasFile('image_url')) {
        $file = $request->file('image_url');
        $extension = $file->getClientOriginalExtension(); // Obtener la extensión del archivo
        $name = 'product_' . $product->id . '.' . $extension; // Nombre único basado en el ID
        // Usar ruta relativa para llegar a la carpeta destino
        $destinationPath = base_path().'/../img/products'; // Resuelve la ruta relativa desde "public"
        //$destinationPath = "/elemental.aricrm.co/img/products";
        //dd(base_path());
        // Asegurarse de que la carpeta exista
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true); // Crear la carpeta si no existe
        }

        $file->move($destinationPath, $name); // Mover el archivo a la carpeta destino
        $product->image_url = 'img/products/' . $name; // Guardar la ruta relativa en la base de datos

        // Actualizar nuevamente el producto con la ruta de la imagen
        $product->save();
    }

    
    return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
    

}



    /// importador
    public function import()
    {

        $statuses = ProductStatus::all();
        $types = ProductType::all();
        $categories = Category::whereNotNull('parent_id')->get();

        return view('products.import', compact('statuses', 'categories', 'types'));
    }


    public function uploadFile($request)
    {
        $data = "";
        $path = "";
        if ($request->hasFile('file')) {

            $path = $request->file('file')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            $data = array_slice($data, 1);


            /*
            dd($data);

            $file     = $request->file('file');
            $path = $file->getClientOriginalName();

            $destinationPath = 'public/imports/'.$request->customer_id;
            
            $res = $file->move($destinationPath,$path);

            */
        }

        return $data;
    }

    function str_getcsv($n)
    {
        return $n;
    }

    public function getIdFromName($name, $table)
    {
        $id = 0;
        $model = DB::table($table)->where('name', '=', $name)->first();
        if ($model)
            $id = $model->id;
        else {
            echo "<h4 style='color:red'>No existe :'" . $name . "'' en la tabla " . $table . "</h4>";
        }

        return $id;
    }


    public function getIdFromNameAndCategory($name, $cid, $table)
    {
        $id = 0;
        $model = DB::table($table)->where('name', '=', $name)
            ->where('category_id', '=', $cid)
            ->first();
        if ($model)
            $id = $model->id;
        else {
            echo "<h4 style='color:red'>No existe :" . $name . " " . $table . "</h4>";
        }

        return $id;
    }



    public function createFromArray($array)
    {
        $NAME = 0;
        $PRICE = 1;
        $STATUS = 2;
        $CATEGORY = 3;
        $TYPE = 4;
        $BUILT_AREA = 6;
        $PRIVATE_AREA = 7;
        $FINAL_PRICE_FULL_FINISHES = 8;
        $FINAL_PRICE_COMBO1 = 9;
        $FINAL_PRICE_BLACK_WORK = 10;
        $SET_CATEGORY = 11;
        $LOCATION = 12;
        $NOTES = 13;

        $category_id = $this->getIdFromName($array[$CATEGORY], 'categories');
        $status_id = $this->getIdFromName($array[$STATUS], 'product_statuses');
        $type_id = 0;



        $name = "";
        if (isset($array[$NAME])) {
            $name = $array[$NAME];
        }

        $model = Product::where('name', '=', $name)
            ->where('category_id', '=', $category_id)
            ->where(function ($query) use ($array, $SET_CATEGORY, $type_id) {
                if (!(isset($array[$SET_CATEGORY]) && ($array[$SET_CATEGORY] != ""))) {
                    $query->where('type_id', '=', $type_id);
                }
            })
            ->first();

        if (!$model) {
            $model = new Product;
            $model->name = $name;
        }

        if (intval($status_id)) {
            $model->status_id = $status_id;
        }
        if (intval($category_id)) {
            $model->category_id = $category_id;
        }
        if (intval($type_id)) {
            $model->type_id = $type_id;
        }

        if (isset($array[$PRICE]) && is_numeric($array[$PRICE])) {
            $model->price = floatval($array[$PRICE]);
        }




        if (isset($array[$BUILT_AREA]) && is_numeric($array[$BUILT_AREA])) {
            $model->built_area = floatval($array[$BUILT_AREA]);
        }

        if (isset($array[$PRIVATE_AREA]) && is_numeric($array[$PRIVATE_AREA])) {
            $model->private_area = floatval($array[$PRIVATE_AREA]);
        }

        if (isset($array[$FINAL_PRICE_BLACK_WORK]) && is_numeric($array[$FINAL_PRICE_BLACK_WORK])) {
            $model->price_black_work = floatval($array[$FINAL_PRICE_BLACK_WORK]);
        }

        if (isset($array[$FINAL_PRICE_COMBO1]) && is_numeric($array[$FINAL_PRICE_COMBO1])) {
            $model->price_semi_finished = floatval($array[$FINAL_PRICE_COMBO1]);
        }

        if (isset($array[$FINAL_PRICE_FULL_FINISHES]) && is_numeric($array[$FINAL_PRICE_FULL_FINISHES])) {
            $model->price_fully_finished = floatval($array[$FINAL_PRICE_FULL_FINISHES]);
        }

        if (isset($array[$LOCATION]) && is_string($array[$LOCATION])) {
            $model->location = $array[$LOCATION];
        }

        if (isset($array[$NOTES]) && is_string($array[$NOTES])) {
            $model->notes = $array[$NOTES];
        }

        if (!is_null($model->category_id)) {
            $model->save();
        }
    }
    public function bulkStore(Request $request)
    {
        $data = $this->uploadFile($request);
        $cont = 1;
        foreach ($data as $array) {
            echo "<br>" . $cont . ". ";
            $cont++;
            $this->updateOrCreateProduct($array);
        }

        return redirect('/products/');
    }

    public function updateOrCreateProduct($array)
    {
        $NAME = 0;
        $PRICE = 1;
        $CATEGORY = 3;

        $name = isset($array[$NAME]) ? $array[$NAME] : null;
        $category = isset($array[$CATEGORY]) ? $array[$CATEGORY] : null;

        if ($name && $category) {
            $model = Product::where('name', '=', $name)
                ->whereHas('category', function ($query) use ($category) {
                    $query->where('name', '=', $category);
                })
                ->first();

            if ($model) {
                $price = isset($array[$PRICE]) ? floatval($array[$PRICE]) : 0;
                $model->price = $price;
                $model->save();
            } else {
                $this->createFromArray($array);
            }
        }
    }
}
