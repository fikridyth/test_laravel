"use strict";

// Class definition
var KTDatatablesExample = (function () {
  // Shared variables
  var table;
  var datatable;

  // Private functions
  var initDatatable = function () {
    // Init datatable --- more info on datatables: https://datatables.net/manual/
    datatable = $(table).DataTable({
      info: false,
      order: [],
      pageLength: 10,
    });
  };

  // Hook export buttons
  var exportButtons = () => {
    const documentTitle = "Document Bansos";
    var buttons = new $.fn.dataTable.Buttons(table, {
      buttons: [
        {
          extend: "excelHtml5",
          title: documentTitle,
          // exportOptions: {
          //   columns: [0, 1, 2, 4, 5]
          // },
        },
        {
          extend: "csvHtml5",
          title: documentTitle,
          // exportOptions: {
          //   columns: [0, 1, 2, 4, 5]
          // },
        },
        {
          extend: "pdfHtml5",
          title: documentTitle,
          // exportOptions: {
          //   columns: [0, 1, 2, 4, 5]
          // },
        },
      ],
    })
      .container()
      .appendTo($("#kt_datatable_example_buttons"));

    // Hook dropdown menu click event to datatable export buttons
    const exportButtons = document.querySelectorAll(
      "#kt_datatable_example_export_menu [data-kt-export]"
    );
    exportButtons.forEach((exportButton) => {
      exportButton.addEventListener("click", (e) => {
        e.preventDefault();

        // Get clicked export value
        const exportValue = e.target.getAttribute("data-kt-export");
        const target = document.querySelector(
          ".dt-buttons .buttons-" + exportValue
        );

        // Trigger click event on hidden datatable export buttons
        target.click();
      });
    });
  };

  // Public methods
  return {
    init: function () {
      table = document.querySelector("#kt_datatable_example");

      if (!table) {
        return;
      }

      initDatatable();
      exportButtons();
    },
  };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
  KTDatatablesExample.init();
});
