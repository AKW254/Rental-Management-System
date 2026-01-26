(() => {
  if (typeof $.fn.DataTable === "undefined") {
    console.error("DataTables library is not loaded.");
    return;
  }

  $(document).ready(() => {
    const $table = $("#notificationTable");
    if (!$table.length) return;

    window.notificationTable = $table.DataTable({
      ajax: {
        url: "/Rental-Management-System/functions/list_notifications.php",
        dataSrc: "",
      },
      rowId: "notification_id",
      columns: [
        {
          data: null,
          render: (_, __, ___, meta) => meta.row + 1,
        },
        { data: "user_name" },
        { data: "notification_type" },
        { data: "notification_message" },
        { data: "sent_at" },
        { data: "notification_status" },
      ],
      responsive: true,
      pageLength: 10,
      order: [[4, "desc"]],
    });
  });
})();
