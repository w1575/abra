<div>
    <table class="table table-primary table-responsive">
        <tr>
            <td> {{ __('telegram_accounts.id') }} </td>
            <td> {{ __('telegram_accounts.username') }} </td>
            <td> {{ __('telegram_accounts.name') }} </td>
            <td> {{ __('telegram_accounts.avatar') }} </td>
            <td> {{ __('telegram_accounts.token') }} </td>
            <td> {{ __('telegram_accounts.linked_account') }} </td>
            <td> {{ __('telegram_accounts.status') }} </td>
        </tr>

        <?php /** @var \App\Models\TelegramAccount $telegramAccount  */ ?>
        @foreach($telegramAccounts as $telegramAccount)
            <tr>
                <td> {{ $telegramAccount->id }} </td>
                <td> {{ $telegramAccount->telegram_id }} </td>
                <td> {{ $telegramAccount->username }} </td>
                <td> {{ $telegramAccount->name }} </td>
                <td> {{ $telegramAccount->avatar }} </td>
                <td> {{ $telegramAccount->token }} </td>
                <td> {{ $telegramAccount->user->name }} </td>
                <td> {{ $telegramAccount->status }} </td>
            </tr>
        @endforeach
    </table>

    <div class="d-flex">
        <?php /** @var \Illuminate\Pagination\Paginator $telegramAccounts  */ ?>

        {{ $telegramAccounts->links('pagination::tailwind') }}
    </div>
</div>
