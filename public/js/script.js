$(function () {
  // $.ajaxSetup({
  //   headers: {
  //     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
  //   },
  // });

  $(".kt_default_datatable").DataTable({
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, "All"],
    ],
  });

  $(".kt_fixed_columns").DataTable({
    fixedColumns: {
      left: 3,
    },
  });

  $(".kt_scroll_vertical").DataTable({
    scrollY: 760,
  });

  $(".kt_datatable_responsive").DataTable({
    responsive: true,
    lengthChange: true,
    autoWidth: false,
    order: [],
  });

  $(".kt_datatable_responsive_with_actions").DataTable({
    responsive: true,
    lengthChange: true,
    autoWidth: false,
    order: [],
    columnDefs: [
      {
        orderable: false,
        targets: -1,
      },
    ],
  });

  let dynamicSearchTable = $(".kt_datatable_dynamic_search").DataTable();

  $("[data-kt-filter='search']").on("keyup", function () {
    dynamicSearchTable.search(this.value).draw();
  });
});

// single datePicker
$("#kt_default_daterangepicker").daterangepicker({
  singleDatePicker: true,
  showDropdowns: true,
  locale: {
    format: "DD MMM YYYY",
    monthNames: [
      "Januari",
      "Februari",
      "Maret",
      "April",
      "Mei",
      "Juni",
      "Juli",
      "Agustus",
      "September",
      "Oktober",
      "November",
      "Desember",
    ],
  },
});

// $(document).on({
//   ajaxStart: function () {
//     $("body").addClass("loading");
//   },
//   ajaxStop: function () {
//     $("body").removeClass("loading");
//   },
// });

function show_alert_dialog(status, message) {
  if (!(typeof message === "string" || message instanceof String))
    message = message.responseText;

  message = message.replace(/(\r\n|\n|\r)/g, " ");

  if (status == "00")
    Swal.fire({
      title: "Berhasil",
      html: message,
      icon: "success",
    });
  else if (status == "000")
    Swal.fire({
      title: "Info",
      html: message,
      icon: "info",
    });
  else
    Swal.fire({
      title: "Proses Gagal",
      html: message,
      icon: "warning",
    });
}

function start_loading() {
  $("#loading-dialog").modal("show");
}

function stop_loading() {
  $("#loading-dialog").modal("hide");
}
