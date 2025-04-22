<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Auth;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use App\Models\Category;
use App\Models\Customer;
use App\Models\SaleType;
use App\Models\Source;
use App\Models\CustomerFrequency;
use App\Models\OrderTransaction;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\OrderProduct;
use App\Models\OrderReason;
use App\Models\Payment;
use App\Services\WAToolboxService;
use Illuminate\Support\Facades\Cookie;


class OrderController extends Controller
{

    public function index(Request $request)
    {

        $model = $this->getModel($request);
        $group = $this->groupModel($request);
        $statuses = OrderStatus::where("status_id", "=", 1)->get();

        $users = User::all();
        $categories = Category::whereNotNull('parent_id')->get();
        $payments = Payment::all();
        $cookie = $this->getCookie($request);


        // Crear la vista
        $view = view('orders.index', compact('request', 'model', 'group', 'statuses', 'categories', 'users', 'payments'));

        // Crear la respuesta y adjuntar la cookie
        $response = response($view)->withCookie($cookie);

        return $response;
    }

    public function getModel($request)
    {
        $model = Order::where(

            // Búsqueda por...
            function ($query) use ($request) {
                $dates = $this->getDates($request);
                if (isset($request->from_date) && ($request->from_date != null)) {

                    if ((isset($request->created_updated) &&  ($request->created_updated == "updated")))
                        $query->whereBetween('orders.delivery_date', $dates);
                    else
                        $query->whereBetween('orders.created_at', $dates);
                }
                if (isset($request->payment_id)  && ($request->payment_id != null))
                    $query = $query->where('payments.id', $request->payment_id);
                if (isset($request->status_id)  && ($request->status_id != null))
                    $query = $query->where('orders.status_id', $request->status_id);
                if (isset($request->category_id)  && ($request->category_id != null))
                    $query = $query->where('category_id', $request->category_id);
                if (isset($request->user_id)  && ($request->user_id != null))
                    $query = $query->where('user_id', $request->user_id);
                if (isset($request->notes)  && ($request->notes != null))
                    $query = $query->where('notes', $request->notes);

                if (isset($request->search)  && ($request->search != null))
                    $query = $query->where(
                        function ($innerQuery) use ($request) {
                            $innerQuery = $innerQuery->orwhere('products.name', "like", "%" . $request->search . "%");
                        }
                    );
            }


        )
            ->select(DB::raw('orders.created_at, orders.status_id, user_id, orders.notes, orders.id, customer_id, delivery_date, delivery_address,  payment_id ,customer_id'))
            ->orderBy('delivery_date', 'DESC')
            ->paginate(50);

        return $model;
    }

    public function groupModel($request)
    {
        $model = Order::rightJoin('order_statuses', 'order_statuses.id', 'orders.status_id')
            ->where(

                // Búsqueda por...
                function ($query) use ($request) {
                    $query->where("order_statuses.status_id", "=", 1);
                    $dates = $this->getDates($request);
                    if (isset($request->from_date) && ($request->from_date != null)) {

                        if ((isset($request->created_updated) &&  ($request->created_updated == "updated")))
                            $query->whereBetween('orders.delivery_date', $dates);
                        else
                            $query->whereBetween('orders.created_at', $dates);
                    }
                    if (isset($request->status_id)  && ($request->status_id != null))
                        $query = $query->where('orders.status_id', $request->status_id);

                    if (isset($request->category_id)  && ($request->category_id != null))
                        $query = $query->where('category_id', $request->category_id);
                    if (isset($request->user_id)  && ($request->user_id != null))
                        $query = $query->where('user_id', $request->user_id);

                    if (isset($request->search)  && ($request->search != null))
                        $query = $query->where(
                            function ($innerQuery) use ($request) {
                                $innerQuery = $innerQuery->orwhere('orders.name', "like", "%" . $request->search . "%");
                            }
                        );
                }

            )
            ->select(DB::raw('order_statuses.id as status_id, order_statuses.name, order_statuses.color, count(orders.id) as count'))
            ->groupBy('order_statuses.id')
            ->groupBy('order_statuses.name')
            ->groupBy('order_statuses.color')
            ->groupBy('weight')
            ->orderBy('weight', 'ASC')
            ->get();

        return $model;
    }


    public function show($id)
    {
        $model = Order::find($id);
        $payments = Payment::all();
        $sale_type_options = SaleType::all();
        $sources = Source::all();
        $customer_frequency = CustomerFrequency::all();
        $statuses = OrderStatus::all();
        $products = Product::where("status_id", 1)->get();
        $product_types = ProductType::all();
        $referal = User::where('role_id', 3)->get();
        $users = User::where('role_id', 1)->get();

        return view('orders.show', compact('model', 'referal', 'users', 
            'payments', 'sale_type_options', 'sources', 'customer_frequency', 'statuses', 'products', 'product_types'));
    }



    public function quote($id)
    {
        $model = Order::find($id);

        $debits = OrderTransaction::where('order_id', $id)
            ->where('debit',  '>', 0)
            ->get();

        $credits = OrderTransaction::where('order_id', $id)
            ->where('credit', '>', 0)
            ->get();

        $transactions = OrderTransaction::where('order_id', $id)
            ->orderby('date', 'asc')
            ->get();

        $products = Product::where("status_id", 1)->get();
        $product_types = ProductType::all();


        return view('orders.quote', compact('model', 'debits', 'credits', 'transactions', 'products', 'product_types'));
    }

    public function store_payment_plan($id, Request $request)
    {

        $model = new OrderTransaction;
        $model->date = $request->date;
        $model->description = $request->description;
        $model->internal_id = $request->internal_id;
        $model->debit = $request->debit;

        $model->save();

        return redirect('/orders/' . $id . '/show');
    }

    public function store_payment($id, Request $request)
    {

        $model = new OrderTransaction;
        $model->date = $request->date;
        $model->description = $request->description;
        $model->internal_id = $request->internal_id;
        $model->credit = $request->credit;

        $model->save();

        return redirect('/orders/' . $id . '/show');
    }








    public function store_pagos(Request $request)
    {
        return $request->all();
    }

    public function create($cid)
    {


        $customer = Customer::find($cid);
        $model = new Order;
        $model->customer_id = $cid;
        $products = Product::where("status_id", 1)->get();
        $statuses = OrderStatus::all();
        $user =  Auth::id();
        $users = User::where('role_id', 1)->get();
        $referal = User::where('role_id', 3)->get();

        return view('orders.create', compact('customer', 'model', 'users', 'user', 'referal', 'products', 'statuses'));
    }
    public function edit($id)
    {


        $model = Order::find($id);
        $customer = Customer::all();
        $products = Product::where("status_id", 1)->get();
        $statuses = OrderStatus::all();
        $user =  Auth::id();
        $users = User::where('role_id', 1)->get();
        $referal = User::where('role_id', 3)->get();

        return view('orders.edit', compact('model', 'customer', 'users', 'user', 'referal', 'products', 'statuses'));
    }

    public function addProducts($oid)
    {


        $model = Order::find($oid);
        $payments = Payment::all();
        $products = Product::where("status_id", 1)->get();
        $statuses = OrderStatus::all();
        $users = User::where('role_id', 1)->get();
        $referal = User::where('role_id', 3)->get();
        $sale_type_options = SaleType::all();

        return view('orders.add_product', compact('model', 'users', 
                'sale_type_options', 'referal', 'payments', 'products', 'statuses'));
    }



    public function store(Request $request)
    {


        $model = new Order;
        $model->delivery_name = $request->delivery_name;
        //$model->delivery_document = $request->delivery_document;
        $model->delivery_phone = $request->delivery_phone;
        $model->delivery_date = $request->delivery_date;
        $model->delivery_address = $request->delivery_address;
        $model->delivery_email = $request->delivery_email;
        $model->notes = $request->notes;
        $model->updated_user_id = Auth::id();



        $model->customer_id = $request->customer_id;
        $model->status_id = $request->status_id;

        $model->user_id = $request->user_id;
        $model->referal_user_id = $request->referal_user_id;

        //dd($request->referal_user_id);

        // Guardar la IP del usuario
        $model->user_ip = $request->ip();

        // Guardar el User Agent
        $model->user_agent = $request->header('User-Agent');

        // Guardar la URL de la petición
        $model->request_url = $request->url();

        // Guardar datos de la petición (puede que necesites serializar si es un array)
        $model->request_data = json_encode($request->all());

        // Obtén solo el valor de la cookie 'unique_machine'
        $cookieValue = $request->cookie('unique_machine');
        // Si la cookie no existe, crea una y obtén el valor
        if (is_null($cookieValue)) {
            // Crea un nuevo valor de cookie y obtén ese valor
            $cookieValue = md5(uniqid(rand(), true));
            // Coloca la cookie en la cola para que se adjunte a la próxima respuesta
            Cookie::queue('unique_machine', $cookieValue, 60 * 24 * 365);
        }

        // Asigna el valor de la cookie a la propiedad correspondiente
        $model->unique_machine = $cookieValue;



        $model->save();


        return redirect('/orders/' . $model->id . '/add/product');

        //return $request->all();

    }

    public function storeProduct(Request $request)
    {



        $product = Product::where('name', $request->product)->first();

        if ($product) {
            $model = new OrderProduct;
            $model->product_id = $product->id;

            $model->order_id = $request->order_id;
            $model->price = $request->price;
            $model->quantity = $request->quantity;
            $model->discount = $request->dscto;
            $model->user_id = $request->user_id;
            $model->sale_type_id = $request->sale_type_id;
            
            $model->total = ((100 - $request->dscto) / 100) * $request->price * $request->quantity;


            $model->save();
        }

        return redirect('/orders/' . $request->order_id . '/add/product');
    }



    public function storePayment(Request $request)
    {


        $model = new OrderTransaction;

        $model->order_id = $request->order_id;
        $model->payment_id = $request->payment_id;
        $model->credit = $request->credit;
        $model->type_id = $request->type_id;
        //$model->date = date("Y-m-a h:i:s");
        $model->save();;

        return redirect('/orders/' . $model->order_id . '/show');
    }

    public function destroy($id)
    {
        $model = OrderProduct::find($id);
        $model->delete();



        return redirect()->back()->with('statustwo', 'El Producto fué eliminado con éxito de la orden!');
    }

    public function delete($id)
    {

        $model = Order::find($id);
        $model->status_id = 10;

        $model->save();

        return redirect()->back();
    }


    public function changeStatusProduct($pid, $sid)
    {
        $model = Product::find($pid);
        if ($model) {
            $model->status_id = $sid;

            $model->save();
        }
    }

    public function update($id, Request $request)
    {
        $model = Order::find($id);
    
        if (isset($request->payment_id) && $request->payment_id != "")
            $model->payment_id = $request->payment_id;

        if (isset($request->source_id) && $request->source_id != "")
            $model->source_id = $request->source_id;
    
        if (isset($request->delivery_name) && $request->delivery_name != "")
            $model->delivery_name = $request->delivery_name;
    
        if (isset($request->delivery_phone) && $request->delivery_phone != "")
            $model->delivery_phone = $request->delivery_phone;
    
        if (isset($request->delivery_date) && $request->delivery_date != "")
            $model->delivery_date = $request->delivery_date;
    
        if (isset($request->delivery_address) && $request->delivery_address != "")
            $model->delivery_address = $request->delivery_address;
    
        if (isset($request->delivery_email) && $request->delivery_email != "")
            $model->delivery_email = $request->delivery_email;
    
        if (isset($request->notes) && $request->notes != "")
            $model->notes = $request->notes;
    
        if (isset($request->customer_id) && $request->customer_id != "")
            $model->customer_id = $request->customer_id;
    
        if (isset($request->status_id) && $request->status_id != "") 
            $model->status_id = $request->status_id;

    
        if (isset($request->user_id) && $request->user_id != "")
            $model->user_id = $request->user_id;
    
        if (isset($request->referal_user_id) && $request->referal_user_id != "")
            $model->referal_user_id = $request->referal_user_id;
    
        if (isset($request->longitude) && $request->longitude != "" && is_numeric($request->longitude)) {
            $model->longitude = $request->longitude;
        }
    
        if (isset($request->latitude) && $request->latitude != "" && is_numeric($request->latitude)) {
            $model->latitude = $request->latitude;
        }
    
        $model->updated_user_id = Auth::id();
    
        // Guardar la IP del usuario
        $model->user_ip = $request->ip();
    
        // Guardar el User Agent
        $model->user_agent = $request->header('User-Agent');
    
        // Guardar la URL de la petición
        $model->request_url = $request->url();
    
        // Guardar datos de la petición (puede que necesites serializar si es un array)
        $model->request_data = json_encode($request->all());
    
        // Obtén solo el valor de la cookie 'unique_machine'
        $cookieValue = $request->cookie('unique_machine');
        // Si la cookie no existe, crea una y obtén el valor
        if (is_null($cookieValue)) {
            // Crea un nuevo valor de cookie y obtén ese valor
            $cookieValue = md5(uniqid(rand(), true));
            // Coloca la cookie en la cola para que se adjunte a la próxima respuesta
            Cookie::queue('unique_machine', $cookieValue, 60 * 24 * 365);
        }
    
        // Asigna el valor de la cookie a la propiedad correspondiente
        $model->unique_machine = $cookieValue;
    
        $model->save();
        
        if ($model->wasChanged('status_id')) {
            \Log::info('status=>'. $model->status_id );
            try {
                if ($model->status_id == 3) {
                    $this->sendCampaign(7, $model->customer_id);
                }
                if ($model->status_id == 4) {
                    $this->sendCampaign(8, $model->customer_id);
                }
                if ($model->status_id == 2) {
                    $this->sendCampaign(6, $model->customer_id);
                }
                if ($model->status_id == 11) {
                    $this->sendCampaign(9, $model->customer_id);
                }
            } catch (\Exception $e) {
                \Log::error('Error al enviar la campaña: ' . $e->getMessage());
            }
        }
    
        return redirect('/orders/' . $model->id . '/show');
    }

    public function updateProducts($id, Request $request)
    {
        $model = OrderProduct::find($id);
    
        $model->sale_type_id = $request->sale_type_id;
    
        $model->save();

    
        return redirect('/orders/' . $model->id . '/show');
    }
    
  

    public function getDates($request)
    {
        $to_date = Carbon::today()->subDays(0); // ayer
        $from_date = Carbon::today()->subDays(3000);

        if (isset($request->from_date) && ($request->from_date != null)) {


            $from_date = Carbon::createFromFormat('Y-m-d', $request->from_date);
            $to_date = Carbon::createFromFormat('Y-m-d', $request->to_date);
        }

        $to_date = $to_date->format('Y-m-d') . " 23:59:59";
        $from_date = $from_date->format('Y-m-d');

        return array($from_date, $to_date);
    }




    public function getCookie($request)
    {
        // Verificar si la cookie ya está establecida
        if (!$request->cookie('unique_machine')) {
            // La cookie no existe, así que crea un nuevo valor único
            $cookieValue = md5(uniqid(rand(), true));
            // Crea una nueva cookie con el valor único y la expiración de 1 año (525600 minutos)
            $cookie = Cookie::make('unique_machine', $cookieValue, 60 * 24 * 365);
        } else {
            // La cookie ya existe, obtén su valor
            $cookieValue = $request->cookie('unique_machine');
            // Crea una nueva cookie con el valor existente para renovar su expiración
            $cookie = Cookie::make('unique_machine', $cookieValue, 60 * 24 * 365);
        }
        return $cookie;
    }

    public function sendCampaign($campaign_id, $customer_id)
    {

        $campaign = Campaign::find($campaign_id);
        if (!$campaign) {
            return;
        }

        \Log::info('campaign=>' , [$campaign] );

        $user = User::find(Auth::id());
        $this->defaultMessageSource = $user?->getDefaultMessageSource();
        
        if ($this->defaultMessageSource) {
            //logger('reacched');
            $this->waToolboxService = new WAToolboxService($this->defaultMessageSource);
            
        
        }


        $customer = Customer::find($customer_id);
        if (!$customer) {
            return;
        }

        $phone = $customer->getPhone();
        if (empty($phone)) {
            return;
        }

        // 🔍 Evitar mensajes duplicados
        $sent_texts = [];
        
        \Log::info("campaign->messages: " ,[ $campaign->messages ]);

        foreach ($campaign->messages as $message) {
            if (empty($message->text) || in_array($message->text, $sent_texts)) {
                continue;
            }

            $sent_texts[] = $message->text; // Guardar texto para evitar repetidos

            $payload = [
                'phone_number' => $phone,
                'message' => $message->text,
                'action' => 'send-message',
                'type' => 'text',
            ];

            try {
                $this->waToolboxService->sendMessageToWhatsApp($payload);
            } catch (\Exception $e) {
                \Log::error("Error enviando mensaje en sendCampaign: " . $e->getMessage());
            }
        }
    }
    
}
