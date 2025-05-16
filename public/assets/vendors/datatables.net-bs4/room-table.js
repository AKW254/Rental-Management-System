// assets/js/property-table.js
(() => {
  // Ensure DataTables library is loaded
  if (typeof $.fn.DataTable === 'undefined') {
    console.error('DataTables library is not loaded. Please include the required DataTables JS and CSS files.');
    return;
  }

  $(document).ready(() => {
    const $table = $("#roomTable");
    if (!$table.length) return;

    // Initialize and store globally
    window.roomTable = $table.DataTable({
      ajax: {
      url: "/RMS/functions/list_rooms.php", // returns JSON []
      dataSrc: "",
      },
      rowId: "room_id",
      columns: [
      {
        data: null,
        render: (_, __, ___, meta) => meta.row + 1,
      },
      { 
        data: "room_title",
        render: (data, type, row) => 
        `<a href="/RMS/views/room-details.php?room_id=${row.room_id}" class="text-primary">${data}</a>`,
      },
      { data: "property_name" },
      { data: "room_rent_amount" },
      { data: "room_availability" },
      {
        data: null,
        orderable: false,
        render: (row) => `
        <button class="btn btn-sm btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#editRoomModal-${row.room_id}">
          Edit
        </button>
        <button class="btn btn-sm btn-danger"
            data-bs-toggle="modal"
            data-bs-target="#deleteRoomModal-${row.room_id}">
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
