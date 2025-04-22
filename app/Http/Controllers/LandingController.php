<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use GuzzleHttp\Client;

class LandingController extends Controller
{
    public function productList()
    {
        // Obtener productos en oferta flash usando Eloquent
        $flashProducts = Product::whereIn('id', function($query) {
            $query->select('product_id')->from('flash_deals');
        })->get();
    
        // Obtener categorías con productos
        $categories = Category::where('promoted', 1)->with('products')->get();
    
        // Obtener productos disponibles
        $products = Product::where('quantity', '>', 0)
            ->where('status_id', 1)
            ->get();
    
        return view('landings.product_list', compact('flashProducts', 'categories', 'products'));
    }
    
    
    

    public function sendOrder(Request $request)
    {
        // Paso 1: Recoger los datos del formulario
        $name = $request->input('name');
        $phone = $request->input('phone');
        $address = $request->input('address');
        $orderDetails = $request->input('order_details'); // Detalles del pedido como string

        // Paso 2: Procesar los detalles del pedido
        $orderItems = explode(',', $orderDetails); // Convertir el string en un array
        $formattedOrderItems = array_map(function ($item) {
            list($productId, $productName, $price) = explode(':', $item);
            return "{$productName} (ID: {$productId}) - {$price}";
        }, $orderItems);

        // Calcular el total de la compra
        $total = array_reduce($orderItems, function ($carry, $item) {
            list(, , $price) = explode(':', $item);
            return $carry + (float) $price;
        }, 0);

        // Paso 3: Formatear el mensaje
        $message = "Nuevo pedido de: {$name}\n";
        $message .= "Teléfono: {$phone}\n";
        $message .= "Dirección: {$address}\n";
        $message .= "Detalles del Pedido:\n" . implode("\n", $formattedOrderItems);
        $message .= "\n\nTotal de la compra: *{$total}*";

        // Paso 4: Codificar el mensaje para URL
        $encodedMessage = urlencode($message);

        //$fallback = $this->sendMessage($phone, $message);
        //dd($fallback);
        // Crear la URL de wa.me con tu número de tienda
        // Depuración: mostrar el mensaje y la URL
        //dd(compact('message', 'whatsAppUrl'));
         $whatsAppUrl = "https://wa.me/573142132987?text={$encodedMessage}"; // Reemplaza 573142132987 con tu número de tienda

        // Redirigir al usuario a WhatsApp
        return redirect()->away($whatsAppUrl);
    }

    public function sendMessage($phone, $message)
    {
        $client = new Client();
        $endPoint = "https://api.watoolbox.com/webhooks/19YC5Q41W";
        $response = $client->post($endPoint, [
            'json' => [
                'phone' => $phone,
                'message' => $message,
            ],
        ]);

        return response()->json(json_decode($response->getBody()->getContents()), $response->getStatusCode());
    }
}