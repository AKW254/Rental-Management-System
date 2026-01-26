// assets/js/property-table.js
(() => {
  // Ensure DataTables library is loaded
  if (typeof $.fn.DataTable === "undefined") {
    console.error(
      "DataTables library is not loaded. Please include the required DataTables JS and CSS files."
    );
    return;
  }

  $(document).ready(() => {
    const $table = $("#notificationTable");
    if (!$table.length) return;

    // Initialize and store globally
    window.notificationTable = $table.DataTable({
      ajax: {
        url: "/Rental-Management-System/functions/list_notifications.php", // returns JSON []
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
        
        {
          data: null,
          orderable: false
        },
      ],
      responsive: true,
      pageLength: 10,
      order: [[1, "asc"]],
    });
  });
})();
