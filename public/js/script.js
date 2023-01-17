const rupiahIndonesia = Intl.NumberFormat("id-ID");

$(function () {
  $(".numeric").numeric({});
  $(".positive-numeric").numeric({
    negative: false,
  }); // do not allow negative values

  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });

  $(".kt_default_datatable").DataTable({
    responsive: true,
    paging: false,
    info: false,
    lengthChange: false,
    autoWidth: false,
    order: [],
  });

  $(".kt_datatable_responsive").DataTable({
    responsive: true,
    lengthChange: true,
    autoWidth: false,
    order: [],
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
    format: "YYYY-MM-DD",
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

function show_alert_dialog(status, message) {
  if (!(typeof message === "string" || message instanceof String)) {
    message = message.responseText;
  }

  message = message.replace(/(\r\n|\n|\r)/g, " ");

  if (status == "00") {
    Swal.fire({
      title: "Berhasil",
      html: message,
      icon: "success",
    });
  } else if (status == "000") {
    Swal.fire({
      title: "Info",
      html: message,
      icon: "info",
    });
  } else {
    Swal.fire({
      title: "Proses Gagal",
      html: message,
      icon: "warning",
    });
  }
}
