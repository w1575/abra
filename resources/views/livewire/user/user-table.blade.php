<div>
    <table class="table table-striped">
        <tr>
            <th>
                {{ __('user.id') }}
            </th>
            <th>
                {{ __('user.name') }}
            </th>
            <th>
                {{ __('user.email') }}
            </th>
            <th>
                {{ __('user.email_verified_at') }}
            </th>
            <th>
                {{ __('user.remember_token') }}
            </th>
            <th>
                {{ __('user.created_at') }}
            </th>
            <th>
                {{ __('user.updated_at') }}
            </th>
        </tr>

        @foreach($users as $user)
            <?php /** @var \App\Models\User $user */   ?>
            <tr>
                <td> {{$user->id}} </td>
                <td> {{$user->name}} </td>
                <td> {{$user->email}} </td>
                <td> {{$user->email_verified_at}} </td>
                <td> {{$user->remember_token}} </td>
                <td> {{$user->created_at}} </td>
                <td> {{$user->updated_at}} </td>
            </tr>
        @endforeach
    </table>

    {{ $users->links() }}

</div>
