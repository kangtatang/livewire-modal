<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Anggota;

class Anggotas extends Component
{

    public $anggotas, $name, $email, $anggota_id;
    public $updateMode = false;

    public function render()
    {
        $this->anggotas = Anggota::all();
        return view('livewire.anggotas');
    }

    private function resetInputFields(){
        $this->name = '';
        $this->email = '';
    }

    public function store()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        Anggota::create($validatedDate);

        session()->flash('message', 'Users Created Successfully.');

        $this->resetInputFields();

        $this->emit('anggotaStore'); // Close model to using to jquery
    }
    public function edit($id)
    {
        $this->updateMode = true;
        $anggota = Anggota::where('id',$id)->first();
        $this->anggota_id = $id;
        $this->name = $anggota->name;
        $this->email = $anggota->email;
     }
    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }
    public function update()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        if ($this->anggota_id) {
            $anggota = Anggota::find($this->anggota_id);
            $anggota->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);
            $this->updateMode = false;
            session()->flash('message', 'Users Updated Successfully.');
            $this->resetInputFields();
        }
    }
    public function delete($id)
    {
        if($id){
            Anggota::where('id',$id)->delete();
            session()->flash('message', 'Users Deleted Successfully.');
        }
    }
}
