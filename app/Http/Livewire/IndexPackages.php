<?php

namespace App\Http\Livewire;

use App\Models\Package;
use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Database\QueryException;

class IndexPackages extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $sortDirection = 'desc';
    public $sortField = 'created_at';


    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $packages = Package::where(function ($query) {
            $query->where('packages.title', 'like', '%' . $this->search . '%');
        })->orderBy($this->sortField, $this->sortDirection)
            ->paginate(50);
        return view('livewire.index-packages', compact('packages'));
    }
    public function deletePackage($id)
    {
       
    }
    public function changeStatusPackage($id, $status)
    {
        try {
            Package::findOrFail($id)->update([
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

    public function clearSearch()
    {
        $this->reset(['search']);
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
}
