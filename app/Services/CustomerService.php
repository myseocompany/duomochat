<?php

namespace App\Services;

use DB;
use Auth;
use Carbon;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\CustomerStatus;
use App\Models\Customer;

use App\Models\RoleProduct;

class CustomerService {


    public function filterCustomers(Request $request, $statuses, $stage_id, $countOnly = false, $pageSize = 0)
    {
        $status_array = CustomerStatus::where('stage_id', $stage_id)->pluck('id')->toArray();
        $dates = $this->getDates($request);

        $query = Customer::leftJoin('customer_statuses', 'customers.status_id', '=', 'customer_statuses.id')
            ->where(function ($query) use ($stage_id, $dates, $request) {
                if (!empty($stage_id) && empty($request->search))
                    $query->where('customer_statuses.stage_id', $stage_id);

                if (!empty($request->from_date)) {
                    $column = ($request->created_updated === "created") ? 'created_at' : 'updated_at';
                    $query->whereBetween("customers.$column", $dates);
                }

                if (!empty($request->user_id)) {
                    $query->where('customers.user_id', $request->user_id === "null" ? null : $request->user_id);
                }
                if (!empty($request->rfm_group_id)) {
                    $query->where('customers.rfm_group_id', $request->rfm_group_id === "null" ? null : $request->rfm_group_id);
                }

                if (isset($request->maker)) {
                    is_numeric($request->maker) ? 
                        $query->where('customers.maker', $request->maker) : 
                        $query->whereNull('customers.maker');
                }
                

                if (!empty($request->product_id)) {
                    $query->whereIn(
                        'customers.product_id', 
                        $request->product_id == 1 ? [1, 6, 7, 8, 9, 10, 11] : [$request->product_id]
                    );
                }

                if (!empty($request->source_id)) $query->where('customers.source_id', $request->source_id);
                if (!empty($request->country)) $query->where('customers.country', $request->country);
                if (!empty($request->status_id)) $query->where('customers.status_id', $request->status_id);
                if (!empty($request->scoring_interest)) $query->where('customers.scoring_interest', $request->scoring_interest);
                if (!empty($request->inquiry_product_id)) $query->where('customers.inquiry_product_id', $request->inquiry_product_id);

                if (!empty($request->search)) {
                    $normalizedSearch = $this->normalizePhoneNumber($request->search);
                    $query->where(function ($innerQuery) use ($request, $normalizedSearch) {
                        $innerQuery->orWhere('customers.name', 'like', "%{$request->search}%")
                            ->orWhere('customers.email', 'like', "%{$request->search}%")
                            ->orWhere('customers.document', 'like', "%{$request->search}%")
                            ->orWhere('customers.position', 'like', "%{$request->search}%")
                            ->orWhere('customers.business', 'like', "%{$request->search}%")
                            ->orWhere('customers.notes', 'like', "%{$request->search}%")
                            ;

                        if ($this->looksLikePhoneNumber($request->search)) {
                            $innerQuery->orWhereRaw("REPLACE(REPLACE(REPLACE(customers.phone, ' ', ''), '-', ''), '(', '') LIKE ?", ["%$normalizedSearch%"]);
                            $innerQuery->orWhereRaw("REPLACE(REPLACE(REPLACE(customers.phone2, ' ', ''), '-', ''), '(', '') LIKE ?", ["%$normalizedSearch%"]);
                            $innerQuery->orWhereRaw("REPLACE(REPLACE(REPLACE(customers.contact_phone2, ' ', ''), '-', ''), '(', '') LIKE ?", ["%$normalizedSearch%"]);
                        }
                    });
                }
            });

        if ($countOnly) {
            $query = $query->select(
                DB::raw('count(distinct(customers.id)) as count'),
                'customers.status_id',
                DB::raw('COALESCE(customer_statuses.name, "Sin Estado") as status_name'),
                DB::raw('COALESCE(customer_statuses.color, "#000000") as status_color'),
                
            )
            ->groupBy('customers.status_id', 'customer_statuses.name', 'customer_statuses.color') // Asegurar compatibilidad en MySQL
            ->orderBy('customer_statuses.weight', 'ASC')
            ->get();
        } else {
            
            if($pageSize>0){
                $query = $query->select(
                    'customers.*',
                    DB::raw('COALESCE(customer_statuses.name, "Sin Estado") as status_name'),
                    DB::raw('COALESCE(customer_statuses.color, "#000000") as status_color') // Color por defecto
                )->orderBy('customers.created_at', 'DESC')
                ->paginate($pageSize);
            }else{
                $query = $query->select(
                    'customers.*',
                    DB::raw('COALESCE(customer_statuses.name, "Sin Estado") as status_name'),
                    DB::raw('COALESCE(customer_statuses.color, "#000000") as status_color') // Color por defecto
                )->orderBy('customers.created_at', 'DESC')
                ->get();
            }
            
        }

        $query->action = "customers/phase/" . $stage_id;
        $query->phase_id = $stage_id;
        return $query;
    }




    public function filterModel(Request $request, $statuses)
    {
        //        $model = Customer::wherein('customers.status_id', $statuses)
        $dates = $this->getDates($request);
        $model = Customer::leftjoin('customer_statuses', 'customer_statuses.id', 'customers.status_id')
            ->select(
                'customers.maker',
                'customers.id',
                'customers.status_id',
                'customers.product_id',
                'customers.user_id',
                'customers.created_at',
                'customers.updated_at',
                'customers.name',
                'customers.phone',
                'customers.email',
                'customers.country',
                'customers.rd_public_url',
                'notes',
                'source_id',
                'scoring_interest',
                'scoring_profile',
                'customers.document',
                'customers.phone2',
                'customers.department',
                'customers.bought_products',
                'customers.contact_name',
                'customers.contact_email',
                'customers.position',
                'customers.contact_phone2',
                'customers.contact_position',
                'customers.business',
                'customers.updated_user_id',
                'customers.count_empanadas',
                'customers.empanadas_size',
                'customers.number_venues',
                'customers.image_url'
            )
            ->where(
                // Búsqueda por...
                function ($query) use ($request, $dates) {
                    if (isset($request->from_date) && $request->from_date) {
                        $column = ($request->created_updated === "created") ? 'created_at' : 'updated_at';
                        $query = $query->whereBetween("customers.$column", $dates);
                    }
                    if (isset($request->product_id)  && ($request->product_id != null)) {
                        if ($request->product_id == 1)
                            $query = $query->whereIn('customers.product_id', array(1, 6, 7, 8, 9, 10, 11));
                        else
                            $query = $query->where('customers.product_id', $request->product_id);
                    }
                    if (isset($request->user_id)  && ($request->user_id != null)) {
                        if ($request->user_id != "null")
                            $query = $query->where('customers.user_id', $request->user_id);
                        else
                            $query = $query->whereNull('customers.user_id');
                    }
                    if (isset($request->maker)  && ($request->maker != null)) {
                        if ($request->maker != "null") {
                            $query->where('customers.maker', $request->maker);
                        } else
                            $query->whereNull('customers.maker');
                    }
                    if (isset($request->source_id)  && ($request->source_id != null))
                        $query = $query->where('customers.source_id', $request->source_id);
                    if (isset($request->status_id)  && ($request->status_id != null))
                        $query = $query->where('customers.status_id', $request->status_id);
                    if (isset($request->scoring_interest)  && ($request->scoring_interest != null))
                        $query->where('customers.scoring_interest', $request->scoring_interest);
                    if (isset($request->country)  && ($request->country != null))
                        $query->where('customers.country', $request->country);
                    if (isset($request->search)) {
                        $query->where(
                            function ($innerQuery) use ($request) {
                                $innerQuery->orwhere('customers.name', "like", "%" . $request->search . "%");
                                $innerQuery->orwhere('customers.email',   "like", "%" . $request->search . "%");
                                $innerQuery->orwhere('customers.document', "like", "%" . $request->search . "%");
                                $innerQuery->orwhere('customers.position', "like", "%" . $request->search . "%");
                                $innerQuery->orwhere('customers.business', "like", "%" . $request->search . "%");
                                $innerQuery->orwhere('customers.phone',   "like", "%" . $request->search . "%");
                                $innerQuery->orwhere('customers.phone2',   "like", "%" . $request->search . "%");
                                $innerQuery->orwhere('customers.notes',   "like", "%" . $request->search . "%");
                                $innerQuery->orwhere('customers.city',    "like", "%" . $request->search . "%");
                                $innerQuery->orwhere('customers.country', "like", "%" . $request->search . "%");
                                $innerQuery->orwhere('customers.bought_products', "like", "%" . $request->search . "%");
                                //$innerQuery->orwhere('customers.status_temp',"like", "%".$request->search."%");
                                $innerQuery->orwhere('customers.contact_name', "like", "%" . $request->search . "%");
                                $innerQuery->orwhere('customers.contact_phone2', "like", "%" . $request->search . "%");
                                $innerQuery->orwhere('customers.contact_email', "like", "%" . $request->search . "%");
                                $innerQuery->orwhere('customers.contact_position', "like", "%" . $request->search . "%");
                                //$innerQuery->orwhere('actions.note',"like", "%".$request->search."%");
                            }
                        );
                    }
                }
            )
            ->select(
                'customers.maker',
                'customers.id',
                'customers.status_id',
                'customers.email',
                'customers.rd_public_url',
                'customers.name',
                'customers.phone',
                'customers.product_id',
                'customers.user_id',
                'customers.created_at',
                'customers.updated_at',
                'customers.country',
                'notes',
                'source_id',
                'scoring_interest',
                'scoring_profile',
                'customers.document',
                'customers.phone2',
                'customers.department',
                'customers.bought_products',
                'customers.contact_name',
                'customers.contact_email',
                'customers.position',
                'customers.contact_phone2',
                'customers.contact_position',
                'customers.business',
                'customers.updated_user_id',
                'customers.count_empanadas',
                'customers.empanadas_size',
                'customers.number_venues',
                'customers.image_url'
            )
            ->orderBy('customer_statuses.weight', 'ASC')
            ->orderBy('customers.created_at', 'DESC')
            //->havingRaw('(count(if(outbound=0, actions.created_at, null)))','is not null')
            ->paginate(10);
        return $model;
    }


    

    public function getUserMenu($user)
    {
        $menu = Menu::select('menus.name', 'menus.url')
            ->leftJoin("role_menus", "menus.id", "role_menus.menu_id")
            ->leftJoin("roles", "roles.id", "role_menus.role_id")
            ->where("roles.id", $user->role_id)
            ->get();
        return $menu;
    }
    public function getCustomerWithParent($pid)
    {

        $parent = CustomerStatus::select(DB::raw('customer_statuses.*'))
            //->whereNotNull('customer_statuses.next_id')
            ->join('customer_statuses AS next', 'next.id', '=', 'customer_statuses.next_id')
            ->where('next.stage_id', '=', $pid)
            ->orderBy('customer_statuses.weight', 'ASC');
        $model = CustomerStatus::where('stage_id', '=', $pid)
            ->union($parent)
            ->orderBy('weight', 'ASC')
            ->get();
        //    dd($parent);
        return $model;
    }

    public function getDates($request)
    {
        $to_date = Carbon\Carbon::today()->subDays(2); // ayer
        $from_date = Carbon\Carbon::today()->subDays(5000);
        if (isset($request->from_date) && ($request->from_date != null)) {
            $from_date = Carbon\Carbon::createFromFormat('Y-m-d', $request->from_date);
            $to_date = Carbon\Carbon::createFromFormat('Y-m-d', $request->to_date);
        }
        $to_date = $to_date->format('Y-m-d') . " 23:59:59";
        $from_date = $from_date->format('Y-m-d');
        return array($from_date, $to_date);
    }

    public function getLead($lead)
    {
        $str = "";
        switch ($lead) {
            case "7":
                $str = "lead07";
                break;
            case "14":
                $str = "lead14";
                break;
            case "21":
                $str = "lead21";
                break;
            case "28":
                $str = "lead28";
                break;
            case "total":
                $str = "has_actions";
                break;
            default:
                $str = "lead";
                break;
        }
        return $str;
    }

    public function getRoleProducts()
    {
        $role_products_elocuent = RoleProduct::where('role_id', '=', Auth::user()->role_id)->get();
        foreach ($role_products_elocuent as $item) {
            $role_product_array[] = $item->product_id;
        }
        if (isset($role_product_array) && $role_product_array != "")
            return $role_product_array;
        else
            $role_product_array = "";
        return $role_product_array;
    }

    function looksLikePhoneNumber($input)
    {
        return preg_match('/^\+?\d{1,4}(\s|-)?(\d{1,4}(\s|-)?){1,4}$/', $input);
    }
    // Función para normalizar números de teléfono
    function normalizePhoneNumber($phoneNumber)
    {
        return preg_replace('/[^0-9]/', '', $phoneNumber);
    }
    
}