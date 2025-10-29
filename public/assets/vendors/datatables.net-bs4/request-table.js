// assets/js/property-table.js
(() => {
  // Ensure DataTables library is loaded
  if (typeof $.fn.DataTable === 'undefined') {
    console.error('DataTables library is not loaded. Please include the required DataTables JS and CSS files.');
    return;
  }

  $(document).ready(() => {
    const $table = $("#requestTable");
    if (!$table.length) return;

    // Initialize and store globally
    window.requestTable = $table.DataTable({
      ajax: {
        url: "/Rental-Management-System/functions/list_requests.php",
        dataSrc: "",
      },
      rowId: "maintenance_request_id",
      columns: [
        {
          data: null,
          render: (_, __, ___, meta) => meta.row + 1,
        },
        { data: "room_title" },
        { data: "requested_by" },
        { data: "requested_to" },
        { data: "maintenance_request_description" },
        { data: "maintenance_request_submitted_at" },
        { data: "maintenance_request_status" },
        {
          data: null,
          orderable: false,
          render: (row) => `
        <button class="btn btn-sm btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#editRequestModal-${row.maintenance_request_id}">
          Edit
        </button>
        <button class="btn btn-sm btn-danger"
            data-bs-toggle="modal"
            data-bs-target="#deleteRequestModal-${row.maintenance_request_id}">
          Delete
        </button>
        `,
        },
      ],
      responsive: true,
      pageLength: 10,
      order: [[1, "asc"]],
    });
  });
})();
