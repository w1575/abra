<?php

namespace App\Http\Livewire\TelegramAccount;

use App\Models\TelegramAccount;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use Livewire\WithPagination;

class TelegramAccountList extends Component
{

    use WithPagination;

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $telegramAccounts = TelegramAccount::query()->paginate();
        return view('livewire.telegram-account.telegram-account-list', ['telegramAccounts' => $telegramAccounts]);
    }
}
