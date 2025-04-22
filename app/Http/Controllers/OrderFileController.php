<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderFile;
use Illuminate\Support\Facades\Storage;

class OrderFileController extends Controller
{
    public function store(Request $request)
    {
        // Guardar el archivo en storage/app/public/orders
        
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('orders', $fileName, 'public');

        $orderFile = new OrderFile();
        $orderFile->order_id = $request->order_id;
        $orderFile->url = 'orders/' . $fileName;
        $orderFile->name = $file->getClientOriginalName();
        $orderFile->save();

        return response()->json(['success' => true, 'file' => $fileName]);
    }
    public function delete($id)
    {
        $file = OrderFile::find($id);
        
        if (!$file) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        // Marcar el archivo como eliminado (sin borrarlo físicamente)
        $file->is_deleted = true;
        $file->save();

        return response()->json(['success' => true, 'message' => 'Archivo marcado como eliminado']);
    }

}
