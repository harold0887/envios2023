<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Membership;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class IndexMemberships extends Component
{
    public $search = '';
    public $sortDirection = 'desc';
    public $sortField = 'created_at';
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'delete' => 'delete',
    ];

    public function render()
    {
        $memberships = Membership::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })->withCount('sales')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(50);
        return view('livewire.index-memberships', compact('memberships'));
    }

    
    public function changeStatusMembership($id, $status)
    {
        try {
            Membership::findOrFail($id)->update([
                'status' => $status == 0 ? true : false
            ]);
            $this->emit('success-auto-close', [
                'message' => 'El cambio se realizo con éxito',
            ]);
        } catch (QueryException $e) {
            $this->emit('error', [
                'message' => $e->getMessage(),
            ]);
        }
    }


    //sort
    public function setSort($field)
    {

        $this->sortField = $field;

        if ($this->sortDirection == 'desc') {
            $this->sortDirection = 'asc';
        } else {
            $this->sortDirection = 'desc';
        }
    }

    public function clearSearch()
    {
        $this->reset(['search']);
    }
}
