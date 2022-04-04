<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{
    use WithPagination;

    public $userId = null;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $sortBy = 'name';
    public $sortDesc = true;
    public $actionAdd = false;
    public $q;
    public $confirmingUserDeletion = false;
    public $confirmingUserAddition = false;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'name'],
        'sortDesc' => ['except' => true],
    ];

    protected $rules = [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required|min:8',
    ];

    protected $messages = [
        'name.required' => 'Por favor, informe um nome para o usuário',
        'email.required' => 'Por favor, informe um e-mail para o usuário',
        'email.email' => 'Por favor, informe um e-mail válido para o usuário',
        'email.unique' => 'Este e-mail já está sendo utilizado por outro usuário',
        'password.required' => 'Por favor, informe uma senha para o usuário',
        'password.min' => 'A senha deve ter no mínimo :min caracteres',
        'password.confirmed' => 'As senhas não conferem',
    ];

    public function render()
    {
        $users = User::query()
            ->when($this->q, function ($query) {
                $query
                    ->where('id', '!=', auth()->user()->id)
                    ->where('name', 'like', "%{$this->q}%")
                    ->orWhere('email', 'like', "%{$this->q}%");
            })
            ->where('id', '!=', auth()->id())
            ->orderBy($this->sortBy, $this->sortDesc ? 'desc' : 'asc')
            ->paginate(10);

        return view('livewire.users', [
            'users' => $users,
        ]);	
    }

    public function saveUser() 
    {
        

        if (isset($this->userId)) {

            $user = User::find($this->userId);

            if(isset($this->password)) {

                $this->validate([
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                    'password' => 'required|min:8|confirmed',
                    'password_confirmation' => 'required|min:8',
                ]);

                $user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),	
                ]);

            } else {
                
                $this->validate([
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                ]);

                $user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                ]);
            }

        } else {

            $this->validate();
            
            User::create([
                'tenant_id' => auth()->user()->tenant_id,
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
        }        

        $this->reset(['name', 'email', 'password', 'password_confirmation']);
        $this->confirmingUserAddition = false;
    }

    public function editUser()
    {
        User::save([
            'id' => $this->userId,
            'name' => $this->name,
            'email' => $this->email
        ]);

        
        $this->confirmingUserAddition = false;
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        $this->confirmingUserDeletion = false;
        $this->reset(['userId']);
    }

    public function confirmUserAddition()
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation']);
        $this->actionAdd = true;
        $this->confirmingUserAddition = true;
        $this->resetValidation();
    }

    public function confirmUserEditing(User $user) 
    {
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->actionAdd = false;
        $this->resetValidation();
        $this->confirmingUserAddition = true;
    }

    public function confirmUserDeletion($id)
    {
        $this->confirmingUserDeletion = true;
        $this->userId = $id;
    }

    public function sortBy($field)
    {
        if ($field == $this->sortBy) {
            $this->sortDesc = !$this->sortDesc;
        }
        $this->sortBy = $field;
    }

    public function updatingQ()
    {
        $this->resetPage();
    }
}
