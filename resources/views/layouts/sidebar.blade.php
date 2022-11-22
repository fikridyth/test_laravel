@php
    use App\Models\CustomClass;
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/dist/img/icon_user_160x160.png') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @foreach ($stmtMenu as $menu)
                    <li
                        class="nav-item {{ !empty($stmtSubMenuId[0]->id_menu) && $menu->id == $stmtSubMenuId[0]->id_menu ? 'menu-open' : '' }}">
                        <a href="{{ app(CustomClass::class)->rootApp() }}{{ $menu->link }}"
                            class="nav-link {{ !empty($stmtMenuId[0]->id) && $menu->id == $stmtMenuId[0]->id ? 'active' : '' }}">
                            <i class='fas fa-chevron-circle-right'></i>
                            <p>{{ $menu->nama }}

                                @if ($menu->link == '#')
                                    <i class='fas fa-angle-left right'></i>
                                @endif

                            </p>
                        </a>

                        @foreach ($stmtSubMenu as $subMenu)
                            @if ($menu->id == $subMenu->id_menu)
                                <ul class='nav nav-treeview'>
                                    <li class='nav-item '>
                                        <a href='{{ app(CustomClass::class)->rootApp() }}{{ $subMenu->link }}'
                                            class="nav-link {{ !empty($stmtSubMenuId[0]->id) && $subMenu->id == $stmtSubMenuId[0]->id ? 'active' : '' }}">
                                            <i class='far fa-circle nav-icon'></i>
                                            <p>{{ $subMenu->nama }}</p>
                                        </a>
                                    </li>
                                </ul>
                            @endif
                        @endforeach

                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
