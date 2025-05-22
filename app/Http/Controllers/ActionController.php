<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon;
use App\Models\Role;
use DB;
use Auth;
use App\Models\Action;
use App\Models\Customer;
use App\Models\CustomerStatus;
use App\Models\Email;
use Mail;
use App\Models\DateTime;
use App\Models\ActionType;

use App\Services\ActionService;

class ActionController extends Controller
{
    public function __construct(ActionService $actionService)
    {
        $this->actionService = $actionService;

    } 

   public function show($id)
    {
        $model = Action::find($id);
        return view('actions.show', compact('model')); 
    }
    

    // iud es user_id , eid es email_id 
    public function trackEmail($cid, $eid){   
        
        $customer = Customer::find($cid);
        if($customer){
            if(empty($customer->status_id)){
                $customer->status_id=19;            
            }
            else if($customer->status_id==1){
                $customer->status_id=19; 
            }
            else if ($customer->status_id==null) {
                $customer->status_id=19;
            } 
            
            $customer->save();
            $email = Email::find($eid);
            Action::saveAction($cid, $eid, 4); //LEYO EL EMAIL

            $subjet = 'El usuario '.$customer->name.' ha abierto el correo! '.$email->subjet;
            $body= 'El usuario '.$customer->name.' ha abierto el correo!</br>
            <a href="http:/xtensor.quirky.com.co/customers/'.$cid.'/show">http:/xtensor.quirky.com.co/customers/'.$cid.'/show</a>';
            $user = User::find(4);//4 Soporte Rapido
            
            $this->sendTrackEmail($user, $customer);
            /*
            $user = User::find(7);
            $this->sendTrackEmail($user, $customer);
            */
        }  
        return \Response::stream(function () {
            $filename = 'https:/xtensor.quirky.com.co/img/logo.png';
            readfile($filename);
        }, 200, ['content-type' => 'image/png']);
        
        if(false !== ($data = file_get_contents('https:/xtensor.quirky.com.co/img/logo.jpg'))){
          header('Content-type: image/jpg');
          echo $data;
        }
    }


    public function trackEmailCode(Request $request)
    {
        
    }

    public function sendTrackEmail($user, $customer){

        $subject = 'El usuario '.$customer->name.' ha abierto el correo!';
        $view = 'emails.trackEmail';
        $emailcontent = array (
            'name' => $customer->name,
            'cid' => $customer->id,
          
        );

        Mail::send($view, $emailcontent, function ($message) use ($user, $subject){
                $message->subject($subject);
                $message->to($user->email);
            });

    }

    public function sendMail($subjet,$body, $user) {

        $send = Email::raw($body, function ($message) use ($user, $subjet){
                
            $message->from('nicolascompany.co', 'My SEO Company');

            $message->to($user->email, $user->name)->subject($subjet);  
            return "mailed"; 

        });
    }
    public function index( Request $request){

        
        // calculo los request de las acciones pendientes
        $overdueRequest = $this->actionService->createFilteredRequest($request, 'overdue');
        $todayRequest = $this->actionService->createFilteredRequest($request, 'today');
        $upcomingRequest = $this->actionService->createFilteredRequest($request, 'upcoming');
        

        // calculo los recordSet de las acciones filtradas 
        $overdueActions = $this->actionService->filterModel($overdueRequest, true);
        $todayActions = $this->actionService->filterModel($todayRequest, true);
        $upcomingActions = $this->actionService->filterModel($upcomingRequest, true);
        $model = $this->actionService->filterModel($request, false);

        
        $users = User::where('status_id' , '=' , 1)->get();
        $action_options = ActionType::all();
        $statuses_options = CustomerStatus::orderBy("stage_id", "ASC")->orderBy("weight", "ASC")->get();
        

        return view('actions.index', compact('model','users', 'action_options','request',
                'overdueActions', 'todayActions', 'upcomingActions', 'statuses_options'));
    }

    public function getDates($request){
        $to_date = Carbon\Carbon::today()->subDays(0); // ayer
        $from_date = Carbon\Carbon::today()->subDays(3000);

        if(isset($request->from_date) && ($request->from_date!=null)){
            
            
            $from_date = Carbon\Carbon::createFromFormat('Y-m-d', $request->from_date);
            $to_date = Carbon\Carbon::createFromFormat('Y-m-d', $request->to_date);
        }

        $to_date = $to_date->format('Y-m-d')." 23:59:59";
        $from_date = $from_date->format('Y-m-d');

        return array($from_date, $to_date); 
    }

    public function filterModel(Request $request){
        $dates = $this->getDates($request);
        
//        $model = Customer::wherein('customers.status_id', $statuses)
        $model = Action::where(
                // Búsqueda por...
                 function ($query) use ($request, $dates) {
                    
                    if(isset($request->from_date)&& ($request->from_date!=null)){
                        if(isset($request->user_id)  && ($request->user_id!=null)){
                            $query = $query->whereBetween('updated_at', $dates);
                            
                        }
                        else{
                            $query = $query->whereBetween('created_at', $dates);
                            
                        }
                    }
                    if(isset($request->user_id)  && ($request->user_id!=null))
                        $query = $query->where('creator_user_id', $request->user_id);
                    if(isset($request->type_id)  && ($request->type_id!=null))
                        $query = $query->where('type_id', $request->type_id);
                    

                }
                   

             )
                
            ->orderBy('updated_at','desc')
            ->orderBy('type_id','asc')
            ->paginate(15);;


        $model->getActualRows = $model->currentPage()*$model->perPage();

        return $model;
    }

    public function edit($id)
    {
        $model = Action::find($id);
        $action_options = ActionType::all();
        $users = User::all();

        return view('actions.edit', compact('model', 'action_options', 'users')); 
    }

    public function update(Request $request){      
        $model = Action::find($request->id);
        $model->note = $request->note;
        $model->type_id = $request->type_id;
        
        //$model->creator_user_id = Auth::id();
        //$model->customer_id = $request->customer_id;

        $model->save();

        return back();
    } 

    public function destroy($id)
    {
        $model = Action::find($id);
        $customer_id = $model->customer_id;
        $model->updator_user_id = \Auth::id();
        $model->status_id = 2;
        $model->save();

        return redirect('customers/'.$customer_id."/show")->with('statustwo', 'La acción <strong>'.$model->name.'</strong> fué eliminado con éxito!');


/*
        if ($model->delete()) {
            return redirect('customers/'.$customer_id."/show")->with('statustwo', 'La acción <strong>'.$model->name.'</strong> fué eliminado con éxito!'); 
        }
        */
    }
}
