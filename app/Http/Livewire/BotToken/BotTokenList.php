<?php

namespace App\Http\Livewire\BotToken;

use App\Models\BotToken;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class BotTokenList extends Component
{
    use WithPagination;

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $tokens = BotToken::query()->paginate();
        return view('livewire.bot-token.bot-token-list', ['tokens' => $tokens]);
    }

    public function createToken(): void
    {
        $token = new BotToken();
        $token->token = Str::random(32);
        $token->save();
    }
}
