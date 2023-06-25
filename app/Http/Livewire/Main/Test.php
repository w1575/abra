<?php

namespace App\Http\Livewire\Main;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use Illuminate\Contracts\Foundation\Application as ContractApplication;

class Test extends Component
{
    public int $counter = 0;

    public string $someData = "some data";

    public function __construct($id = null)
    {
        parent::__construct($id);
    }

    public function inc(): void
    {
        $this->counter++;
        sleep(2);
    }

    public function render(): View|Application|Factory|ContractApplication
    {
        return view('livewire.main.test');
    }
}
