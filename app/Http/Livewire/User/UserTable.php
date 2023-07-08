<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{

    use WithPagination;

    public function render()
    {
        $users = User::paginate();
        return view('livewire.user.user-table', ['users' => $users]);
    }
}
