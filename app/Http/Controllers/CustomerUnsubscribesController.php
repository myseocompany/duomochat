<?php

namespace App\Http\Controllers;

use App\Models\CustomerUnsubscribe;
use Illuminate\Http\Request;


class CustomerUnsubscribesController extends Controller{

    public function index(){
        $model = CustomerUnsubscribe::orderBy("created_at", "DESC")->paginate(10);


        return view('customers_unsubscribes.index', compact('model'));
    }

    public function save(Request $request)
    {
        $existing = CustomerUnsubscribe::where('phone', $request->phone)->first();
    
        if ($existing) {
            return redirect('/customers_unsubscribe')
                ->with('error', 'El número de teléfono ya está registrado.');
        }
    
        $model = new CustomerUnsubscribe;
        $model->phone = $request->phone;
        $model->save();
    
        return redirect('/customers_unsubscribe')
            ->with('success', 'Número guardado exitosamente.');
    }
    

    public function edit(Request $request, $phone){
        $model = CustomerUnsubscribe::where("phone", $phone)->first();

        

        return view('customers_unsubscribes.edit', compact('model'));
    }

    public function update(Request $request, $phone){
        $model = CustomerUnsubscribe::where("phone", $phone)->first();
        $model->phone = $request->phone;
        $model->save();

        return redirect('/customers_unsubscribe');

    }

    public function destroy(Request $request, $phone){
        $model = CustomerUnsubscribe::where("phone", $phone)->first();
        
        if ($model->delete()) {

            return redirect('customers_unsubscribe')->with('status', 'El telefono <strong>' . $model->phone . '</strong> fué eliminado con éxito!');
        }

        return redirect('/customers_unsubscribe');

    }

}