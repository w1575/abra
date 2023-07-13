<div>

    <form wire:submit.prevent="createToken">
        <button class="btn btn-primary" type="submit"> {{ __('bot_tokens.create') }} </button>
    </form>

    <hr class="hr">

    <table class="table table-primary table-responsive">
        <tr>
            <td>
                {{ __('bot_tokens.token') }}
            </td>
            <td>
                {{ __('bot_tokens.telegram_account') }}
            </td>
            <td>
                {{ __('bot_tokens.created_at') }}
            </td>
        </tr>

        <?php /** @var \App\Models\BotToken[]|\Illuminate\Database\Eloquent\Collection $tokens */ ?>
        @foreach($tokens as $token)
            <tr>
                <td>
                    {{ $token->token }}
                </td>
                <td>
                    {{ $token->telegramAccount?->name }}
                </td>
                <td>
                    {{$token->created_at }}
                </td>
            </tr>
        @endforeach

        {{ $tokens->links() }}

    </table>
</div>
