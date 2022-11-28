<button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
    <span class="svg-icon svg-icon-2">
        {!! file_get_contents('metronic/demo2/assets/media/icons/duotune/arrows/arr091.svg') !!}
    </span>
    Export Report
</button>
<div id="kt_datatable_example_export_menu"
    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
    data-kt-menu="true">
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3" data-kt-export="excel">
            Export as Excel
        </a>
    </div>
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3" data-kt-export="csv">
            Export as CSV
        </a>
    </div>
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3" data-kt-export="pdf">
            Export as PDF
        </a>
    </div>
</div>

<div id="kt_datatable_example_buttons" class="d-none"></div>
