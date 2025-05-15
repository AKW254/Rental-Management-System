// assets/js/property-table.js
(() => {
  // Ensure DataTables library is loaded
  if (typeof $.fn.DataTable === 'undefined') {
    console.error('DataTables library is not loaded. Please include the required DataTables JS and CSS files.');
    return;
  }

  $(document).ready(() => {
    const $table = $("#propertyTable");
    if (!$table.length) return;

    // Initialize and store globally
    window.propertyTable = $table.DataTable({
      ajax: {
        url: "/RMS/functions/list_properties.php", // returns JSON []
        dataSrc: "",
      },
      rowId: "property_id",
      columns: [
        {
          data: null,
          render: (_, __, ___, meta) => meta.row + 1,
        },
        { data: "property_name" },
        { data: "property_location" },
        { data: "property_description" },
        { data: "manager_name" },
        {
          data: null,
          orderable: false,
          render: (row) => `
            <button class="btn btn-sm btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#editPropertyModal-${row.property_id}">
              Edit
            </button>
            <button class="btn btn-sm btn-danger"
                    data-bs-toggle="modal"
                    data-bs-target="#deletePropertyModal-${row.property_id}">
              Delete
            </button>`,
        },
      ],
      responsive: true,
      pageLength: 10,
      order: [[1, "asc"]],
    });
  });
})();
