<?php
#DUOMO
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Mail;

use App\Models\Customer;
use App\Models\CustomerStatus;
use App\Models\CustomerStatusPhase;
use App\Models\User;
use App\Models\CustomerSource;
use App\Models\CustomerHistory;
use App\Models\Products;

// use App\Account;
// use App\EmployeeStatus;
// use App\Mail;
use App\Models\EmailBrochure;
use App\Models\Action;
use App\Models\Project;
use App\Models\Campaign;
use App\Models\FindByPhone;
use App\Models\RfmGroup;
use App\Models\CustomerPoint;
use App\Models\CustomerUnsubscribe;
use App\Models\Email;
use App\Models\ActionType;
use Auth;
use Carbon;
use App\Models\SendWithData;
use App\Models\CustomerMetaData;
use App\Models\CustomerMetadataSemantic;
use App\Models\Audience;
use App\Models\AudienceCustomer;
use App\Services\CustomerService;
use App\Services\CustomerMetaDataService;



class CustomerController extends Controller
{

    protected $attributes = ['status_name'];

    protected $appends = ['status_name'];

    protected $status_name;
    protected $customerService;

    public function __construct(CustomerService $customerService) {
        $this->customerService = $customerService;
    }

    public function indexJson(Request $request)
    {
        return Customer::all();
    }

    public function index(Request $request)
    {

        return $this->getCustomers($request);
    }

    public function indexPhase($pid, Request $request)
    {


        $users = $this->getUsers();
        $customer_options = CustomerStatus::where('stage_id', $pid)
            ->orderBy("weight", "ASC")
            ->get();
        $statuses = $this->getStatuses($request, $pid);
        $allStatuses = $this->getAllStatusID();
        $customersGroup = $this->customerService->filterCustomers($request, $allStatuses, $pid, true, 5);
        
        //$customersGroup = $this->countFilterCustomers($request, $allStatuses);

        
        $projects = Project::all();
        $pending_actions = $this->getPendingActions();
        $phase = CustomerStatusPhase::find($pid);
        $audiences = Audience::all();

        $rfm_groups = RfmGroup::all();


        //$model = $this->getModel($request, $statuses, $pid, 50);
        $model = $this->customerService->filterCustomers($request, $statuses, $pid, false, 5);
        
        
        $sources = CustomerSource::all();


        return view('customers.index', compact('model', 'rfm_groups', 'request', 'customer_options', 'customersGroup', 'users', 'sources', 'projects', 'pending_actions', 'phase', 'audiences'));
    }

    public function getPendingActions()
    {
        $model = Action::whereNotNull('due_date')
            ->whereNull('delivery_date')
            //->where('creator_user_id', "=", Auth::id())
            ->get();
        //dd($model);
        return $model;
    }

    public function getCustomers(Request $request)
    {   
        
        $users = $this->getUsers();
        $customer_options = CustomerStatus::all();
        $statuses = $this->getStatuses($request, 1);
        $phase_id = 0;
        //$model = $this->getModel($request, $statuses, $phase_id, 50);
        $rfm_groups = RfmGroup::all();
        
        $model = $this->customerService->filterCustomers($request, $statuses, $phase_id, false, 5);
        
        $customersGroup =  $this->customerService->filterCustomers($request, $statuses, $phase_id, true, 5);
        //dd($customersGroup);
        $projects = Project::all();

        
        $sources = CustomerSource::orderby('name')->get();

        //$pending_actions = $this->getPendingActions();

        
        return view('customers.index', compact('model', 'request', 'rfm_groups', 'customer_options', 'customersGroup', 'users', 'sources', 'projects'));
    }



    // public function excel(Request $request)
    // {
    //     $users = $this->getUsers();
    //     $customer_options = CustomerStatus::all();
    //     $statuses = $this->getStatuses($request, 1);

    //     $model = $this->getModel($request, $statuses, 1, 500000);

    //     $customersGroup = $this->countFilterCustomers($request, $statuses);

    //     $sources = CustomerSource::all();

    //     return view('customers.excel', compact('model', 'request', 'customer_options', 'customersGroup', 'users', 'sources'));
    // }

    public function excel(Request $request)
    {
        $statuses = $this->getStatuses($request, 1);
        //$model = $this->getModel($request, $statuses, 1, 500000);
        $model = $this->customerService->filterCustomers($request, $statuses, 1, false, 500000);

        $unsubscribedPhoneNumbers = CustomerUnsubscribe::pluck('phone')->toArray();

        // Filtra los clientes que no están en la lista de desuscripción

        $filteredModel = $model->filter(function ($customer) use ($unsubscribedPhoneNumbers) {
            return !in_array($customer->phone_wp, $unsubscribedPhoneNumbers);
        });

        return view('customers.excel', ['model' => $filteredModel]);
    }


    public function whatsapp(Request $request)
    {
        /*
        $model = Customer::leftJoin('customer_unsubscribes', 'customers.phone_wp', 'customer_unsubscribes.phone')
            ->whereRaw("LENGTH(phone_wp)>=10")

            ->whereNull("customer_unsubscribes.phone")
            ->orderBy("net_total", "DESC")
            ->distinct()
            ->get();
        */
        $model = Customer::whereNotNull('phone_wp')
            ->whereRaw("LENGTH(phone_wp) >= 10")
            ->whereNotIn('phone_wp', function ($query) {
                $query->select('phone')
                    ->from('customer_unsubscribes');
            })
            ->orderBy('net_total', 'desc')
            ->get();


        return view('customers.whatsapp', compact('model'));
    }

    public function daily_birthday2(Request $request)
    {

        $actualMonth = Carbon\Carbon::now()->format('m');
        $actualDay = Carbon\Carbon::now()->format('d');

        $model = Customer::leftJoin('customer_unsubscribes', 'customers.phone_wp', 'customer_unsubscribes.phone')
            ->whereMonth('birthday', $actualMonth)
            ->whereDay('birthday', $actualDay)
            ->whereRaw("LENGTH(phone_wp)=10")
            ->whereNull("customer_unsubscribes.phone")
            ->distinct()
            ->get();

        return view('customers.whatsapp', compact('model'));
    }


    public function daily_birthday(Request $request)
    {
        $from_date_carbon = null;
        $to_date_carbon = null;
        $actualMonth = null;
        $actualDay = null;

        // Verificamos si el request incluye las fechas 'from_date' y 'to_date'
        if (!empty($request->from_date) && !empty($request->to_date)) {
            list($from_date, $to_date) = $this->getDates($request);

            // Ya que getDates devuelve las fechas con las horas al inicio/final del día, no es necesario agregar la hora nuevamente
            $from_date_carbon = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $from_date);
            $to_date_carbon = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $to_date);
        } else {
            // Definimos el mes y día actual para la búsqueda predeterminada
            $actualMonth = Carbon\Carbon::now()->format('m');
            $actualDay = Carbon\Carbon::now()->format('d');
        }
        //dd(array($from_date_carbon, $to_date_carbon));

        $model = Customer::leftJoin('customer_unsubscribes', 'customers.phone_wp', 'customer_unsubscribes.phone')
            ->where(function ($query) use ($from_date_carbon, $to_date_carbon, $actualMonth, $actualDay) {
                if ($from_date_carbon && $to_date_carbon) {
                    // Filtramos los cumpleaños que caen dentro del rango de fechas
                    $query->whereBetween(DB::raw("DATE_FORMAT(birthday, '%m-%d')"), [$from_date_carbon->format('m-d'), $to_date_carbon->format('m-d')]);
                } else {
                    // Búsqueda predeterminada por día y mes actual
                    $query->whereMonth('birthday', $actualMonth)
                        ->whereDay('birthday', $actualDay);
                }
            })
            ->whereRaw("LENGTH(phone_wp)=10")
            ->whereNull("customer_unsubscribes.phone")
            ->distinct()
            ->get();

        return view('customers.whatsapp', compact('model'));
    }



    public function getDates($request)
    {
        $to_date = Carbon\Carbon::today()->subDays(0); // hoy
        $from_date = Carbon\Carbon::today()->subDays(3000); // hace 3000 días

        if (isset($request->from_date) && ($request->from_date != null)) {
            $from_date = Carbon\Carbon::createFromFormat('Y-m-d', $request->from_date);
            $to_date = Carbon\Carbon::createFromFormat('Y-m-d', $request->to_date);
        }

        $to_date = $to_date->format('Y-m-d') . " 23:59:59";
        $from_date = $from_date->format('Y-m-d') . " 00:00:00";

        return array($from_date, $to_date);
    }

    public function monthly_birthday(Request $request)
    {

        $month = Carbon\Carbon::now()->format('m');

        $model = Customer::leftJoin('customer_unsubscribes', 'customers.phone_wp', 'customer_unsubscribes.phone')
            ->whereMonth('birthday', $month)
            ->whereRaw("LENGTH(phone_wp)=10")
            ->whereNull("customer_unsubscribes.phone")
            ->distinct()
            ->get();

        return view('customers.whatsapp', compact('model'));
    }

    public function leads(Request $request)
    {
        $users = $this->getUsers();
        $customer_options = CustomerStatus::all();
        $statuses = $this->getStatuses($request, 1);
        //$model = $this->getModel($request, $statuses, 1);
        $model = $this->customerService->filterCustomers($request, $statuses, 1, false, 5);


        //$customersGroup = $this->countFilterCustomers($request, $statuses);
        $customersGroup = $this->customerService->filterCustomers($request, $statuses, 1, true, 5);

        $projects = Project::all();
        $pending_actions = $this->getPendingActions();


        $sources = CustomerSource::all();


        return view('customers.index', compact('model', 'request', 'customer_options', 'customersGroup', 'query', 'users', 'sources', 'projects', 'pending_actions'));
    }

    public function getModel(Request $request, $statuses, $phase_id, $paginate)
    {
        $model = $this->filterModel($request, $statuses, $phase_id, $paginate);


        $model->getActualRows = $model->currentPage() * $model->perPage();


        if ($model->perPage() > $model->total())
            $model->getActualRows = $model->total();
        /*
        foreach ($model as $items) {
            if (isset($items->status_id)) {
                $status = CustomerStatus::find($items->status_id);
                if (isset($status))
                    $items->status_name = $status->name;
            }
        }
         */
        $model->phase_id = $phase_id;

        return $model;
    }



    public function getUsers()
    {
        return  User::orderBy('name')
            ->where('users.status_id', 1)
            ->get();
    }

    public function getStatuses(Request $request, $step)
    {
        $statuses;
        if (($step == 0) || (isset($request->from_date) || ($request->from_date != "")))
            $statuses = $this->getAllStatusID();
        else
            $statuses = $this->getStatusID($request, $step);


        return $statuses;
    }






    
    public function filterModel(Request $request, $statuses, $phase_id, $paginate)
    {
        //dd($request);

        $status_array = array();
        foreach ($statuses as $item)
            $status_array[] = $item;
        $dates = $this->getDates($request);

        //        $model = Customer::wherein('customers.status_id', $statuses)
        /*
        $model = Customer::
                lefJoin('customer_points')
                ->select('recency')

*/      //dd($status_array);

        $model = Customer::select(
            'address',
            'total_sold',
            'bought_products',
            'scoring',
            'customers.id',
            'customers.status_id',
            'customers.project_id',
            'customers.user_id',
            'customers.source_id',
            'customers.created_at',
            'customers.updated_at',
            'customers.name',
            'customers.phone',
            'customers.phone2',
            'customers.document',
            'customers.email',
            'customers.phone_wp'
        )

            ->where(
                // Búsqueda por...
                function ($query) use ($request, $phase_id, $status_array, $dates) {


                    if ((isset($phase_id) && ($phase_id != null) && ($phase_id != 0)) && (!isset($request->search))) {
                        //$query->where('stage_id', $phase_id);
                        $query->whereIn('customers.status_id', $status_array);
                    }


                    if (isset($request->scoring_interest)  && ($request->scoring_interest != null))
                        $query->where('customers.scoring_interest', $request->scoring_interest);
                    if (isset($request->audience_id)  && ($request->audience_id != null)) {
                        $query->where('audience_customer.audience_id', $request->audience_id);
                    }



                    /*
                if ( (isset($request->created_updated) &&  ($request->created_updated=="updated")) ) 
                    $query->whereBetween('customers.updated_at', $dates);
                else
                    $query->whereBetween('customers.created_at', $dates);
                */

                    // Asumimos que $query ya está definido y que $dates contiene el rango de fechas deseado.

                    // Define variables para fechas y mes/día actuales
                    $from_date_carbon = null;
                    $to_date_carbon = null;
                    $actualMonth = null;
                    $actualDay = null;

                    // Verifica si el request incluye las fechas 'from_date' y 'to_date'
                    if (!empty($request->from_date) && !empty($request->to_date)) {
                        list($from_date, $to_date) = $this->getDates($request);

                        // getDates devuelve las fechas con las horas al inicio/final del día, no es necesario agregar la hora nuevamente
                        $from_date_carbon = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $from_date);
                        $to_date_carbon = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $to_date);
                    } else {
                        // Definimos el mes y día actual para la búsqueda predeterminada
                        $actualMonth = Carbon\Carbon::now()->format('m');
                        $actualDay = Carbon\Carbon::now()->format('d');
                    }

                    // Filtrar por cumpleaños
                    switch ($request->created_updated ?? 'created') {
                        case "updated":
                            // Filtra por la fecha de actualización entre el rango de fechas especificado
                            $query->whereBetween('customers.updated_at', $dates);
                            break;
                        case "birthday":
                            if ($from_date_carbon && $to_date_carbon) {
                                // Filtra por cumpleaños dentro del rango de fechas proporcionado
                                $query->whereBetween(DB::raw("DATE_FORMAT(customers.birthday, '%m-%d')"), [$from_date_carbon->format('m-d'), $to_date_carbon->format('m-d')]);
                            } else {
                                // Filtra por cumpleaños que coincidan con el mes y día actuales
                                $query->whereMonth('customers.birthday', '=', $actualMonth)
                                    ->whereDay('customers.birthday', '=', $actualDay);
                            }
                            break;
                        default:
                            // El caso por defecto es filtrar por la fecha de creación entre el rango de fechas especificado
                            $query->whereBetween('customers.created_at', $dates);
                            break;
                    }
                    if (isset($request->status_id)  && ($request->status_id != null))
                        $query->where('customers.status_id', $request->status_id);

                    /*
                if (isset($request->user_id)  && ($request->user_id != null))
                    $query->where('user_id', $request->user_id);
                
                    if (isset($request->source_id)  && ($request->source_id != null))
                    $query->where('source_id', $request->source_id);
                if (isset($request->project_id)  && ($request->project_id != null))
                    $query->where('project_id', $request->project_id);
                
                
                if (isset($request->scoring)  && ($request->scoring != null))
                        $query = $query->where('customers.scoring', $request->scoring);
                */
                    if (isset($request->search)) {
                        $query->where(
                            function ($innerQuery) use ($request) {

                                $search = html_entity_decode($request->search);

                                $innerQuery->orwhere('customers.name', "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.email',   "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.document', "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.position', "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.business', "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.phone',   "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.phone2',   "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.phone_wp',   "like", "%" . $search . "%");

                                $innerQuery->orwhere('customers.notes',   "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.city',    "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.country', "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.bought_products', "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.contact_name', "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.contact_phone2', "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.contact_email', "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.contact_position', "like", "%" . $search . "%");
                            }
                        );
                    }
                    if (isset($request->actions_number)) {
                        $query->havingRaw('count(actions.id) = ?', [$request->actions_number]);
                        $query->where('outbound', '1');
                    }
                }


            )->orderBy('customers.status_id', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate($paginate);




        return $model;
    }

    public function filterModelFull(Request $request, $statuses, $paginate)
    {

        //        $model = Customer::wherein('customers.status_id', $statuses)

        $model = Customer::where(
            // Búsqueda por...
            function ($query) use ($request) {

                if (isset($request->from_date) && ($request->from_date != null)) {

                    if ((isset($request->created_updated) &&  ($request->created_updated == "updated")))
                        $query->whereBetween('updated_at', array($request->from_date, $request->to_date));
                    else
                        $query->whereBetween('created_at', array($request->from_date, $request->to_date));
                }

                if (isset($request->user_id)  && ($request->user_id != null))
                    $query->where('user_id', $request->user_id);
                if (isset($request->status_id)  && ($request->status_id != null))
                    $query->where('status_id', $request->status_id);
                if (isset($request->source_id)  && ($request->source_id != null))
                    $query->where('source_id', $request->source_id);
                if (isset($request->project_id)  && ($request->project_id != null))
                    $query->where('project_id', $request->project_id);

                if (isset($request->search)) {
                    $query->where(function ($innerQuery) use ($request) {
                        $innerQuery->orwhere('customers.name', "like", "%" . $request->search . "%");
                        $innerQuery->orwhere('customers.email',   "like", "%" . $request->search . "%");
                        $innerQuery->orwhere('customers.document', "like", "%" . $request->search . "%");
                        $innerQuery->orwhere('customers.business', "like", "%" . $request->search . "%");
                        $innerQuery->orwhere('customers.position', "like", "%" . $request->search . "%");
                        $innerQuery->orwhere('customers.phone',   "like", "%" . $request->search . "%");
                        $innerQuery->orwhere('customers.phone_wp',   "like", "%" . $request->search . "%");

                        $innerQuery->orwhere('customers.phone2',   "like", "%" . $request->search . "%");
                        $innerQuery->orwhere('customers.notes',   "like", "%" . $request->search . "%");
                        $innerQuery->orwhere('customers.city',    "like", "%" . $request->search . "%");
                        $innerQuery->orwhere('customers.country', "like", "%" . $request->search . "%");
                        $innerQuery->orwhere('customers.bought_products', "like", "%" . $request->search . "%");
                        $innerQuery->orwhere('customers.contact_name', "like", "%" . $request->search . "%");
                    });
                }
            }


        )
            ->orderBy('status_id', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return $model;
    }

    public function getDatesOld($request)
    {
        $to_date = Carbon\Carbon::today()->subDays(0); // ayer
        $from_date = Carbon\Carbon::today()->subDays(3000);

        if (isset($request->from_date) && ($request->from_date != null)) {


            $from_date = Carbon\Carbon::createFromFormat('Y-m-d', $request->from_date);
            $to_date = Carbon\Carbon::createFromFormat('Y-m-d', $request->to_date);
        }

        $to_date = $to_date->format('Y-m-d') . " 23:59:59";
        $from_date = $from_date->format('Y-m-d');

        return array($from_date, $to_date);
    }

    public function countFilterCustomers($request, $statuses)
    {
        //$customersGroup = Customer::wherein('customers.status_id', $statuses)
        $dates = $this->getDates($request);

        $customersGroup = CustomerStatus::wherein('customer_statuses.id', $statuses)
            ->leftJoin("customers", 'customers.status_id', '=', 'customer_statuses.id')
            ->where(

                // Búsqueda por...
                function ($query) use ($request, $dates) {
                    /*
                    if (isset($request->from_date) && ($request->from_date != null)) {

                        if ( (isset($request->created_updated) &&  ($request->created_updated=="updated")) ) 
                            $query->whereBetween('customers.updated_at', $dates);
                        else
                            $query->whereBetween('customers.created_at', $dates);
                    }

*/
                    // Define el mes y el día actual
                    // Define variables para fechas y mes/día actuales
                    $from_date_carbon = null;
                    $to_date_carbon = null;
                    $actualMonth = null;
                    $actualDay = null;

                    // Verifica si el request incluye las fechas 'from_date' y 'to_date'
                    if (!empty($request->from_date) && !empty($request->to_date)) {
                        list($from_date, $to_date) = $this->getDates($request);

                        // getDates devuelve las fechas con las horas al inicio/final del día, no es necesario agregar la hora nuevamente
                        $from_date_carbon = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $from_date);
                        $to_date_carbon = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $to_date);
                    } else {
                        // Definimos el mes y día actual para la búsqueda predeterminada
                        $actualMonth = Carbon\Carbon::now()->format('m');
                        $actualDay = Carbon\Carbon::now()->format('d');
                    }

                    // Filtrar por cumpleaños
                    switch ($request->created_updated ?? 'created') {
                        case "updated":
                            // Filtra por la fecha de actualización entre el rango de fechas especificado
                            $query->whereBetween('customers.updated_at', $dates);
                            break;
                        case "birthday":
                            if ($from_date_carbon && $to_date_carbon) {
                                // Filtra por cumpleaños dentro del rango de fechas proporcionado
                                $query->whereBetween(DB::raw("DATE_FORMAT(customers.birthday, '%m-%d')"), [$from_date_carbon->format('m-d'), $to_date_carbon->format('m-d')]);
                            } else {
                                // Filtra por cumpleaños que coincidan con el mes y día actuales
                                $query->whereMonth('customers.birthday', '=', $actualMonth)
                                    ->whereDay('customers.birthday', '=', $actualDay);
                            }
                            break;
                        default:
                            // El caso por defecto es filtrar por la fecha de creación entre el rango de fechas especificado
                            $query->whereBetween('customers.created_at', $dates);
                            break;
                    }
                    if (isset($request->user_id)  && ($request->user_id != null))
                        $query->where('customers.user_id', $request->user_id);
                    if (isset($request->source_id)  && ($request->source_id != null))
                        $query->where('customers.source_id', $request->source_id);
                    if (isset($request->status_id)  && ($request->status_id != null))
                        $query->where('customers.status_id', $request->status_id);
                    if (isset($request->scoring)  && ($request->scoring != null))
                        $query->where('customers.scoring', $request->scoring);

                    if (isset($request->project_id)  && ($request->project_id != null))
                        $query->where('project_id', $request->project_id);

                    /* ACA */

                    if (isset($request->search)) {
                        $query->where(
                            function ($innerQuery) use ($request) {

                                $search = html_entity_decode($request->search);

                                $innerQuery->orwhere('customers.name', "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.email',   "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.document', "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.position', "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.business', "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.phone',   "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.phone2',   "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.phone_wp',   "like", "%" . $search . "%");

                                $innerQuery->orwhere('customers.notes',   "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.city',    "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.country', "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.bought_products', "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.contact_name', "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.contact_phone2', "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.contact_email', "like", "%" . $search . "%");
                                $innerQuery->orwhere('customers.contact_position', "like", "%" . $search . "%");
                            }
                        );
                    }
                }
            )
            ->select(DB::raw('customer_statuses.id as status_id, count(customers.id) as count'))
            ->groupBy('customer_statuses.id')
            ->groupBy('weight')

            ->orderBy('weight', 'ASC')

            ->get();

        //dd($customersGroup);
        foreach ($customersGroup as $item) {
            $included = false;
            foreach ($statuses as $status => $value) {
                if ($value == $item->status_id) {
                    $included = true;
                }
            }
            if ($included) {
                $item->color = CustomerStatus::getColor($item->status_id);
                $item->name = CustomerStatus::getName($item->status_id);
                $item->id = $item->status_id;
            }
        }
        return $customersGroup;
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CustomerMetaDataService $metaService)
    {
        $users = User::all();
        $customers_statuses = CustomerStatus::orderBy('stage_id', 'ASC')->orderBy('weight', 'ASC')->get();
        $customer_sources = CustomerSource::all();
        $projects = Project::all();
        $meta_fields = $metaService->getFieldsForCustomer(1, null); // null porque aún no hay cliente

        $products = Products::all();

        return view('customers.create', compact('customers_statuses', 'users',
        'products',
        'customer_sources', 'projects', 'meta_fields'));
    }


    public function storeMetaDataFromSelect($model, $mid, $select)
    {
        if (is_array($select)) {
            foreach ($select as $item) {
                if ($this->isValidMeta($item)) {
                    $meta = new CustomerMeta;
                    $meta->customer_id = $model->id;
                    $meta->metadata_id = $item;
                    $meta->metadata_type_id = $mid;
                    $meta->save();
                }
            }
        } else {
            if ($this->isValidMeta($select)) {
                $meta = new CustomerMeta;
                $meta->customer_id = $model->id;
                $meta->metadata_id = $select;
                $meta->metadata_type_id = $mid;
                $meta->save();
            }
        }
    }

    public function insertMetaData($cid, $mid, $mdid)
    {
        $model = CustomerMeta::where('customer_id', $cid)
            ->where('metadata_id', $mid)
            ->first();


        if (!$model) {

            $new = new CustomerMeta;
            $new->customer_id = $cid;
            $new->metadata_id = $mid;
            $new->metadata_type_id = $mdid;
            $new->save();
        }
    }

    public function selectToArray($select)
    {
        $array = array();

        if (is_array($select)) {

            foreach ($select as $item) {
                if ($this->isValidMeta($item))
                    $array[] = $item;
            }
        } else {
            if ($this->isValidMeta($select))
                $array[] = $select;
        }


        return $array;
    }

    public function elocuentToArray($model)
    {
        $array = array();

        if ($model)
            foreach ($model as $item)
                $array[] = $item->id;


        return $array;
    }


    public function updateMetaDataFromSelect($model, $mid, $select)
    {
        $newMeta = $this->selectToArray($select);

        // busco las metadata actuales
        $cm = CustomerMeta::select('id')
            ->where('customer_id', $model->id)
            ->where('metadata_type_id', $mid)
            ->where('customer_id', $model->id)
            //->whereNotIn('metadata_id', $select)
            ->get();

        // eliminar las actuales  que no están en la lista

        if ($cm) {
            CustomerMeta::destroy($this->elocuentToArray($cm));
        }

        foreach ($newMeta as $item) {
            $this->insertMetaData($model->id, $item, $mid);
        }
    }


    public function isValidMeta($meta)
    {
        $valid = true;
        if ($meta == "Seleccione...")
            $valid = false;
        return $valid;
    }
    public function storeFromRequest(Request $request)
    {

        $model = new Customer;
        $model->name = $request->name;
        $model->document = $request->document;
        $model->position = $request->position;
        $model->business = $request->business;
        $model->phone = $request->phone;
        $model->phone2 = $request->phone2;
        $model->email = $request->email;
        $model->notes = $request->notes;

        $model->pathology = $request->pathology;
        $model->total_sold = $request->total_sold;
        $model->bought_products = $request->bought_products;

        $model->hobbie = $request->hobbie;
        $model->facebook_url = $request->facebook_url;
        $model->instagram_url = $request->instagram_url;


        $model->address = $request->address;
        $model->city = $request->city;
        $model->country = $request->country;
        $model->department = $request->department;
        $model->bought_products = $request->bought_products;
        $model->status_id = $request->status_id;
        $model->user_id = $request->user_id;
        $model->source_id = $request->source_id;
        $model->project_id = $request->project_id;

        $model->interested_product_id = $request->interested_product_id;


        if (isset($request->birthday) && ($request->birthday != null))
            $model->birthday = $request->birthday;
        //$model->first_installment_date = $request->first_installment_date;

        //datos de contacto
        $model->contact_name = $request->contact_name;
        $model->contact_phone2 = $request->contact_phone2;
        $model->contact_email = $request->contact_email;
        $model->contact_position = $request->contact_position;
        $model->scoring = $request->scoring;

        if (isset($request->meta_gender_id) && ($this->isValidMeta($request->meta_gender_id)))
            $model->meta_gender_id = $request->meta_gender_id;
        if (isset($request->meta_economic_activity_id) && ($this->isValidMeta($request->meta_economic_activity_id)))
            $model->meta_economic_activity_id = $request->meta_economic_activity_id;
        if (isset($request->meta_income_id) && ($this->isValidMeta($request->meta_income_id)))
            $model->meta_income_id = $request->meta_income_id;
        /*
        if(isset($request->meta_investment_id)&& ($this->isValidMeta($request->meta_investment_id)))
            $model->meta_investment_id = $request->meta_investment_id;
        */



        if ($model->save()) {
            /*
            $this->storeMetaDataFromSelect($model, 1, $request->meta_house_mates_id);
            $this->storeMetaDataFromSelect($model, 2, $request->meta_funding_source_id);
            $this->storeMetaDataFromSelect($model, 3, $request->meta_final_fundig_source_id);
            */

            //$this->sendWelcomeMail($model);

            //$this->sendMail(1, $model);
            $this->storeOrUpdateCustomerMetaData($request, $model->id);

            return redirect('customers/' . $model->id . '/show')->with('status', 'El Cliente <strong>' . $model->name . '</strong> fué añadido con éxito!');
        }
        dd($model);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //    $count = $this->isEqual($request);
        $similar = $this->getSimilar($request);

        if (($similar == null) || ($similar->count() == 0))

            return $this->storeFromRequest($request);
        else
            return redirect('/customers/' . $similar[0]->id . '/show');
    }



    private function storeOrUpdateCustomerMetaData(Request $request, $customerId)
    {
        // Elimina los anteriores para reemplazarlos completamente
        CustomerMetaData::where('customer_id', $customerId)->delete();

        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'meta_')) {
                $metaId = str_replace('meta_', '', $key);

                if (is_array($value)) {
                    foreach ($value as $v) {
                        CustomerMetaData::create([
                            'customer_id' => $customerId,
                            'master_meta_data_id' => $metaId,
                            'value' => $v,
                        ]);
                    }
                } else {
                    CustomerMetaData::create([
                        'customer_id' => $customerId,
                        'master_meta_data_id' => $metaId,
                        'value' => $value,
                    ]);
                }
            }
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function show(Request $request, $id, CustomerMetaDataService $metaService)
    {
        $model = Customer::with(['project', 'status', 'user', 'source'])->find($id);

        $meta_fields = $metaService->getFieldsForCustomer(1, $model->id); // 1 = master padre


        $actions = Action::where('customer_id', '=', $id)
            ->orderBy("created_at", "DESC")
            ->get();

        $action_options = ActionType::orderBy("weight", "ASC")->get();
        $histories = CustomerHistory::where('customer_id', '=', $id)->get();
        $email_options = Email::all();
        $statuses_options = CustomerStatus::orderBy("stage_id", "ASC")
            ->orderBy("weight", "ASC")
            ->get();

        $actual = true;
        $today = Carbon\Carbon::now();

        $pending_action = null;

        $customer_sources_options = CustomerSource::all();
        $projects_options = Project::all();
        

        return view('customers.show', compact(
            'model',
            'histories',
            'actions',
            'action_options',
            'email_options',
            'statuses_options',
            'actual',
            'today',
            'pending_action',
            'meta_fields',
            'customer_sources_options',
            'projects_options'
        ));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, CustomerMetaDataService $metaService)
    {
        $model = Customer::find($id);
        $customer_statuses = CustomerStatus::orderBy("stage_id", "ASC")->orderBy("weight", "ASC")->get();
        $customer_sources = CustomerSource::all();
        $users = User::all();
        $products = Products::all();

        $projects = Project::all();

        $meta_fields = $metaService->getFieldsForCustomer(1, $model->id); // 1 = master padre

        return view('customers.edit', compact('model', 
        'customer_statuses',
        'users',
        'customer_sources',
        'projects',
        'products',
        'meta_fields'));
    }


    public function assignMe($id)
    {
        $model = Customer::find($id);
        if (is_null($model->user_id) || $model->user_id == 0) {
            $user =  Auth::id();
            $model->user_id = $user;
            $model->save();
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = Customer::find($id);


        $cHistory = new CustomerHistory;
        $cHistory->saveFromModel($model);

        $fields = [
            'name', 'document', 'position', 'business', 'phone', 'email',
            'notes', 'birthday_updated', 'pathology', 'hobbie', 'facebook_url',
            'instagram_url', 'phone2', 'department', 'address', 'city', 'country',
            'bought_products', 'total_sold', 'user_id', 'source_id', 'status_id',
            'project_id', 'birthday', 'scoring', 'contact_name', 'contact_phone2',
            'contact_email', 'contact_position'
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $model->{$field} = $request->{$field};
            }
        }


        if (isset($request->meta_gender_id) && ($this->isValidMeta($request->meta_gender_id)))
            $model->meta_gender_id = $request->meta_gender_id;
        if (isset($request->meta_economic_activity_id) && ($this->isValidMeta($request->meta_economic_activity_id)))
            $model->meta_economic_activity_id = $request->meta_economic_activity_id;
        if (isset($request->meta_income_id) && ($this->isValidMeta($request->meta_income_id)))
            $model->meta_income_id = $request->meta_income_id;

        $model->interested_product_id = $request->interested_product_id;

        /*
        if(isset($request->meta_investment_id)&& ($this->isValidMeta($request->meta_investment_id)))
            $model->meta_investment_id = $request->meta_investment_id;
        */


        if ($model->save()) {
            $this->updateDynamicMetaData($request, $model->id);
            /*
            $this->updateMetaDataFromSelect($model, 1, $request->meta_house_mates_id);
            $this->updateMetaDataFromSelect($model, 2, $request->meta_funding_source_id);
            $this->updateMetaDataFromSelect($model, 3, $request->meta_final_fundig_source_id);
            */



            return redirect('/customers/' . $id . '/show')->with('statusone', 'El Cliente <strong>' . $model->name . '</strong> fué modificado con éxito!');
        }
    }


    public function updateDynamicMetaData(Request $request, $customer_id)
    {
        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'meta_')) {
                $meta_id = str_replace('meta_', '', $key);

                \App\Models\CustomerMetaData::updateOrCreate(
                    [
                        'customer_id' => $customer_id,
                        'master_meta_data_id' => $meta_id,
                    ],
                    [
                        'value' => is_array($value) ? json_encode($value) : $value,
                    ]
                );
            }
        }
    }

    public function storeActionText($customer_id, $action_id, $action_note)
    {

        $model = new Action;
        $model->note = $action_note;
        $model->type_id = $action_id;


        $model->customer_id = $customer_id;

        $model->save();

        return back();
    }

    public function activate($id)
    {
        $model = Customer::find($id);


        $cHistory = new CustomerHistory;
        $cHistory->saveFromModel($model);

        $model->status_id = 2; // seguimiento
        if ($model->scoring == 0)
            $model->scoring = 1;


        if ($model->save()) {
            $this->storeActionText($id, 4, 'Se activó desde un email');
            return redirect('https://trujillogutierrez.com.co/');
        }
    }
    
    public function unsubscribe($id)
    {
        $model = Customer::find($id);


        $cHistory = new CustomerHistory;
        $cHistory->saveFromModel($model);

        $model->status_id = 9; // descartado


        if ($model->save()) {
            $this->storeActionText($id, 4, 'Se dio de baja desde un email');
            return redirect('https://trujillogutierrez.com.co/');
        }
    }
    // Color



    public function filterCustomers($request)
    {
        return Customer::where(
            function ($query) use ($request) {
                if (sizeof($request->status_id))
                    $query = $query->where('customers.status_id', "=", $request->status_id);
            }
        )
            ->select(DB::raw('customers.*'))

            ->orderBy('customers.status_id', 'asc', 'created_at', 'asc')
            ->paginate(20);
    }

    function getStatusID($request, $stage_id)
    {
        $url = $request->fullurl();
        $paramenters = explode("&", $url);
        $res = array();
        foreach ($paramenters as $key => $value) {
            if (strpos($value, "status_id") !== false && (str_replace("status_id=", "", $value) != 0)) {
                $res[] = str_replace("status_id=", "", $value);
            }
        }
        if (!count($res)) {

            $model = CustomerStatus::where("stage_id", $stage_id)
                ->orderBy("weight", "ASC")
                ->get();
            //$model = CustomerStatus::all();

            foreach ($model as $item)
                $res[] = $item->id;
        }

        return $res;
    }
    // Enviar email
    public function sendMail($id, $user)
    {
        $model = Email::find($id);
        $subjet = 'Gracias por escribirnos';


        Email::raw($model->body, function ($message) use ($user, $subjet) {
            $message->from('noresponder@mqe.com.co', 'Maquiempanadas');

            $message->to($user->email, $user->user_name)->subject($subjet);
        });
    }

    public function mail($cui)
    {
        //$model = Email::find(1);
        $customer = Customer::find($cui);
        $subjet = 'Bro';

        //dd($customer);
        /*
    Mail::raw($model->body, function ($message) use ($customer, $subjet){
        $message->from('noresponder@mqe.com.co', 'Maquiempanadas');

        $message->to($customer->email, $customer->user_name)->subject($subjet);   
    });
*/

        $emailcontent = array(
            'subject' => 'Gracias por contactarme',
            'emailmessage' => 'Este es el contenido',
            'customer_id' => $cui
        );

        //dd($emailcontent);
        // Mail::send('emails.brochure', $emailcontent, function ($message) use ($customer){

        //         $message->subject('MQE');

        //         $message->to('nicolas@myseocompany.co');

        //     });


    }

    function getAllStatusID()
    {

        $res = array();
        $model = CustomerStatus::orderBy("weight", "ASC")->get();
        //$model = CustomerStatus::all();

        foreach ($model as $item)
            $res[] = $item->id;
        return $res;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Customer::find($id);
        $model->actions()->delete();

        if ($model->delete()) {

            return redirect('customers')->with('statustwo', 'El Cliente <strong>' . $model->name . '</strong> fué eliminado con éxito!');
        }
    }

    public function saveAPICustomer($request)
    {

        $model = new Customer;
        $model->name        = $request->name;
        $model->phone       = $request->phone;
        $model->phone2      = $request->phone2;
        $model->email       = $request->email;
        $model->country     = $request->country;
        $model->city        = $request->city;
        $model->project_id  = $request->project_id;
        if (is_int($model->source_id))
            $model->source_id  = $request->source_id;

        if (isset($request->platform) && ($request->platform == 'fb'))
            $model->source_id = 6;
        elseif (isset($request->platform) && ($request->platform == 'ig'))
            $model->source_id = 40;


        $model->notes       = $request->notes . ' ' . $request->email;


        $model->bought_products = $request->bought_products;
        $model->cid = $request->cid;
        $model->src = $request->src;
        $model->department = $request->department;
        $model->status_id = 1;



        $model->save();

        return $model;
    }



    public function isEqual($request)
    {
        $model = Customer::where(
            // Búsqueda por...
            function ($query) use ($request) {
                if (isset($request->user_id)  && ($request->user_id != null))
                    $query = $query->where('user_id', $request->user_id);

                if (isset($request->source_id)  && ($request->source_id != null))
                    $query = $query->where('source_id', $request->source_id);

                if (isset($request->status_id)  && ($request->status_id != null))
                    $query = $query->where('status_id', $request->status_id);

                if (isset($request->business)  && ($request->business != null))
                    $query = $query->where('business', $request->business);

                if (isset($request->phone)  && ($request->phone != null))
                    $query = $query->where('phone', $request->phone);

                if (isset($request->email)  && ($request->email != null))
                    $query = $query->where('email', $request->email);

                if (isset($request->phone2)  && ($request->phone2 != null))
                    $query = $query->where('phone2', $request->phone2);

                if (isset($request->notes)  && ($request->notes != null))
                    $query = $query->where('notes', $request->notes);

                if (isset($request->city)  && ($request->city != null))
                    $query = $query->where('city', $request->city);

                if (isset($request->country)  && ($request->country != null))
                    $query = $query->where('country', $request->country);
            }
        )
            ->count();
        return $model;
    }

    public function getSimilar($request)
    {
        if (
            (isset($request->phone)  && ($request->phone != null)) ||
            (isset($request->phone2)  && ($request->phone2 != null)) ||
            (isset($request->email)  && ($request->email != null)) ||
            (isset($request->document) && ($request->document != null))
        ) {
            $model = Customer::where(
                // Búsqueda por...
                function ($query) use ($request) {
                    if (isset($request->phone)  && ($request->phone != null))
                        $query->orwhere('phone', $request->phone);
                    if (isset($request->phone)  && ($request->phone != null))
                        $query->orwhere('phone2', $request->phone);

                    if (isset($request->phone2)  && ($request->phone2 != null))
                        $query->orwhere('phone', $request->phone2);
                    if (isset($request->phone2)  && ($request->phone2 != null))
                        $query->orwhere('phone2', $request->phone2);

                    if (isset($request->email)  && ($request->email != null))
                        $query->orwhere('email', $request->email);


                    if (isset($request->document)  && ($request->document != null))
                        $query->orwhere('document', $request->document);
                }
            )
                ->get();
        } else {
            $model = null;
        }

        return $model;
    }

    public function getEmailByProjectId($project_id)
    {

        $project_id_laquinta = '1';
        $project_id_torres = '2';


        $email_id_laquinta = 2;
        $email_id_torres = 4;

        $email_id = 0;


        switch ($project_id) {
            case $project_id_laquinta:
                $email_id = $email_id_laquinta;
                break;
            case $project_id_torres:
                $email_id = $email_id_torres;
                break;
        }

        return $email_id;
    }

    public function sendWelcomeMail($customer)
    {
        $email_id = $this->getEmailByProjectId($customer->project_id);


        if ($email_id != 0) {
            $email = Email::find($email_id);
            // $email, $user, $count, $sended_at
            Email::addEmailQueue($email, $customer, 0, Carbon\Carbon::now());
            $this->storeEmailAction($email, $customer, "Correo automático de bienvenida");
        }
    }

    public function redirectingPage1()
    {

        return redirect('https://trujillogutierrez.com.co/site/gracias-la-quinta.html');
    }

    public function redirectingPage2()
    {

        return redirect('https://trujillogutierrez.com.co/site/gracias-torres-del-bosque.html');
    }

    public function saveAPI(Request $request)
    {

        //Customer::create($request->all());
        $count = $this->isEqual($request);

        if (is_null($count) || ($count == 0)) {
            $similar = $this->getSimilar($request);


            if ($similar->count() == 0) {

                $model = $this->saveAPICustomer($request);

                $this->sendWelcomeMail($model);
                if ($request->project_id == '1') {
                    return $this->redirectingPage1();
                } else {
                    return $this->redirectingPage2();
                }
            }
            // este cliente ya existe. Se agrega una nueva nota
            else {

                $model = $similar[0];


                $this->storeActionAPI($request, $model->id);
                $this->updateCreateDate($request, $model->id);
                if ($request->project_id == '1') {
                    return $this->redirectingPage1();
                } else {
                    return $this->redirectingPage2();
                }
            }
        } else {


            $similar = $this->getSimilar($request);


            $model = $similar[0];


            $this->storeActionAPI($request, $model->id);
            $this->updateCreateDate($request, $model->id);
            if ($request->project_id == '1') {
                return $this->redirectingPage1();
            } else {
                return $this->redirectingPage2();
            }
        }
        if ($request->project_id == '1') {
            return $this->redirectingPage1();
        } else {
            return $this->redirectingPage2();
        }
    }

    public function storeActionAPI(Request $request, $customer_id)
    {

        $model = new Action;

        $str = "";
        if (isset($request->phone))
            $str .= " telefono1:" . $request->phone;
        if (isset($request->phone2))
            $str .= " telefono2:" . $request->phone2;
        if (isset($request->email))
            $str .= " email:" . $request->email;
        if (isset($request->city))
            $str .= " ciudad:" . $request->city;
        if (isset($request->country))
            $str .= " pais:" . $request->country;

        if (isset($request->name))
            $str .= " Nombre:" . $request->name;

        $model->note = $request->notes . $str;
        $model->type_id = 16; // actualización


        $model->customer_id = $customer_id;

        $model->save();

        return back();
    }


    public function updateCreateDate(Request $request, $customer_id)
    {

        $customer = Customer::find($customer_id);
        $model = new Action;


        $model->note = "se actualizó la fecha de creación " . $customer->created_at;
        $model->type_id = 16; // actualización
        $model->customer_id = $customer_id;
        $model->save();


        $mytime = Carbon\Carbon::now();
        $customer->created_at = $mytime->toDateTimeString();
        $customer->status_id = 1;
        $customer->save();


        return back();
    }

    public function storeEmailAction($mail, $customer, $note)
    {
        $today = Carbon\Carbon::now();
        // envio mail
        $action_type_id = 2;

        $model = new Action;

        $model->note = $note;
        $model->type_id = $action_type_id;
        $model->creator_user_id = 0;
        $model->customer_id = $customer->id;


        $model->delivery_date = $today;
        $model->save();
    }

    public function changeCustomerStatus($request, $customer)
    {
        if (!is_null($request->status_id)) {
            $cHistory = new CustomerHistory;
            $cHistory->saveFromModel($customer);
            $customer->status_id = $request->status_id;
            $customer->save();
        }
    }

    public function changeCustomerScoring($request, $customer)
    {
        if (!is_null($request->scoring)) {
            $cHistory = new CustomerHistory;
            $cHistory->saveFromModel($customer);
            $customer->scoring = $request->scoring;
            $customer->save();
        }
    }

    public function createNewAction($request)
    {
        $due_date = Carbon\Carbon::parse($request->due_date);

        $model = new Action;

        $model->type_id = $request->type_id;
        $model->creator_user_id = Auth::id();
        $model->customer_id = $request->customer_id;
        $model->note = $request->note;

        if (isset($request->due_date) && ($request->due_date != "")) {
            $model->due_date = $due_date;
        }
        $model->save();
    }

    public function updateAction($request)
    {
        $today = Carbon\Carbon::now();

        $model = Action::find($request->pending_action_id);

        $model->type_id = $request->type_id;
        $model->creator_user_id = Auth::id();
        //$model->customer_id = $request->customer_id;
        $model->note = $model->note . " / " . $request->note;
        $model->delivery_date = $today;
        $model->save();
    }
    public function storeAction(Request $request)
    {
        //dd($today);
        $customer = Customer::find($request->customer_id);
        if (is_null($request->type_id)) {
            return back()->with('statustwo', 'El Cliente <strong>' . $customer->name . '</strong> no fue modificado!');
        }
        if (!isset($request->pending_action_id))
            $this->createNewAction($request);
        else
            $this->updateAction($request);

        $this->changeCustomerStatus($request, $customer);

        $this->changeCustomerScoring($request, $customer);


        return redirect('/customers/' . $request->customer_id . '/show')->with('statusone', 'El Cliente <strong>' . $customer->name . '</strong> fué modificado con éxito!');
    }

    public function storeMail(Request $request)
    {
        $customer = Customer::find($request->customer_id);
        $email = Email::find($request->email_id);

        $count = Email::sendUserEmail($request->customer_id, $email->subject, $email->view, $email->id);
        if ($count > 0) {
            Action::saveActionManually($request->customer_id, $request->email_id, 5);
        } else {
            Action::saveActionManually($request->customer_id, $request->email_id, 2);
        }

        //Email::addEmailQueue($email, $customer, 0, Carbon\Carbon::now());
        /*
	    $emailcontent = array (
			'subject' => $email->subject,
			'emailmessage' => 'Este es el contenido',
			'customer_id' => $model->id,
			'email_id' => $email->id,
            'model' => $model,
			 );
        
        Mail::send($email->view, $emailcontent, function ($message) use ($model, $email){
                    $message->subject($email->subject);
                    $message->to($model->email);
            });
        */
        //Action::saveAction($customer->id,$email->id, 2);
        return back();
    }

    public function change_status(Request $request)
    {


        $statuses = $this->getStatuses($request, 0);
        $model = $this->filterModelFull($request, $statuses, 5000000);

        // cada registro se le actualiza el estado
        foreach ($model as $item) {
            $item->status_id = $request->modal_status_id;
            $item->save();
        }
        return redirect()->back();
    }

    public function quickUpdate(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        if ($request->has('project_id')) {
            $customer->project_id = $request->project_id;
        }

        if ($request->has('source_id')) {
            $customer->source_id = $request->source_id;
        }

        $customer->save();

        return redirect()->back()->with('statusone', 'Proyecto y origen actualizados con éxito.');
    }



}
