<?php

namespace App\Http\Livewire\CloudStorage;

use App\Models\CloudStorage;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cloudStorages = CloudStorage::query()->paginate();
        return view('livewire.cloud-storage.index', ['cloudStorages' => $cloudStorages]);
    }
}
