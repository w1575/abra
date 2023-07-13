<div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">

    <a href="{{ route('main.index') }}" class="d-flex align-items-center pb-3 mb-md-0 text-white text-decoration-none">
        <x-sidebars.logo></x-sidebars.logo>
    </a>
    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
        <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link align-middle px-0">
                <span class="ms-1 d-none d-sm-inline"> {{ __('sidebar.user') }} </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('t.a.index') }}" class="nav-link align-middle px-0">
                <span class="ms-1 d-none d-sm-inline"> {{ __('sidebar.telegram_accounts') }} </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('b.t.index') }}" class="nav-link align-middle px-0">
                <span class="ms-1 d-none d-sm-inline"> {{ __('sidebar.bot_tokens') }} </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link align-middle px-0">
                <span class="ms-1 d-none d-sm-inline"> {{ __('sidebar.clouds') }} </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link align-middle px-0">
                <span class="ms-1 d-none d-sm-inline"> {{ __('sidebar.cloud_accounts') }} </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link align-middle px-0">
                <span class="ms-1 d-none d-sm-inline"> {{ __('sidebar.files') }} </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link align-middle px-0">
                <span class="ms-1 d-none d-sm-inline"> {{ __('sidebar.user_settings') }} </span>
            </a>
        </li>
    </ul>
</div>
