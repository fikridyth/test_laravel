<div class="d-flex align-items-stretch" id="kt_header_nav">
    <div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu"
        data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
        data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
        data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend"
        data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
        <div class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-400 fw-semibold my-5 my-lg-0 align-items-stretch px-2 px-lg-0"
            id="#kt_header_menu" data-kt-menu="true">

            @php
                $sub_menu_menu_ids = array_column($stmtSubMenu->toArray(), 'id_menu');
            @endphp

            @foreach ($stmtMenu as $menu)
                @php
                    $have_sub_menu = in_array($menu->id, $sub_menu_menu_ids);
                @endphp

                <div @if ($have_sub_menu) data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-placement="bottom-start" @endif
                    class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">

                    <a class="menu-link py-3"
                        href="@if ($have_sub_menu) # @else {{ url($menu->link) }} @endif">
                        <span class="menu-title">{{ $menu->nama }}</span>

                        @if ($have_sub_menu)
                            <span class="menu-arrow d-lg-none"></span>
                        @endif
                    </a>

                    @if ($have_sub_menu)
                        <div
                            class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                            @foreach ($stmtSubMenu as $subMenu)
                                @if ($menu->id == $subMenu->id_menu)
                                    <div class="menu-item">
                                        <a class="menu-link py-3" href="{{ url($subMenu->link) }}">
                                            <span class="menu-title">{{ $subMenu->nama }}</span>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
