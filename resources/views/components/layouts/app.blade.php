<x-layouts.base>

    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 ">
                <x-sidebars.menu></x-sidebars.menu>
            </div>
            <div class="col py-3 content">
                {{ $slot }}
            </div>
        </div>
    </div>

</x-layouts.base>
