<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Audience;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class AudienceCustomerManager extends Component
{
    public $audienceId;
    public $search = '';
    public $selectedCustomerId = null;

    public function mount($audienceId)
    {
        $this->audienceId = $audienceId;
    }

    public function addCustomerToAudience($customerId)
{
    if ($customerId) {
        DB::table('audience_customer')->updateOrInsert(
            [
                'customer_id' => $customerId,
                'audience_id' => $this->audienceId
            ],
            [
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        session()->flash('message', 'Cliente agregado correctamente.');
        $this->reset('search');
    }
}


    public function render()
    {
        // Clientes sugeridos por búsqueda
        $matchingCustomers = Customer::where(function ($query) {
            $query->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('phone', 'like', "%{$this->search}%");
        })
        ->limit(10)
        ->get();

        // Clientes ya en la audiencia
        $audienceCustomers = Customer::whereIn('id', function ($query) {
            $query->select('customer_id')
                  ->from('audience_customer')
                  ->where('audience_id', $this->audienceId);
        })->get();

        return view('livewire.audience-customer-manager', [
            'matchingCustomers' => $matchingCustomers,
            'audienceCustomers' => $audienceCustomers
        ]);
    }

    public function updateNote($audienceCustomerId, $value)
{
    DB::table('audience_customer')
        ->where('id', $audienceCustomerId)
        ->update([
            'note' => $value,
            'updated_at' => now()
        ]);
}

public function removeCustomerFromAudience($customerId)
{
    DB::table('audience_customer')
        ->where('audience_id', $this->audienceId)
        ->where('customer_id', $customerId)
        ->delete();

    

    session()->flash('message', 'Cliente eliminado de la audiencia.');
}


}
