// assets/js/rental_agreement_table.js
(() => {
  // Ensure DataTables library is loaded
  if (typeof $.fn.DataTable === "undefined") {
    console.error(
      "DataTables library is not loaded. Please include the required DataTables JS and CSS files."
    );
    return;
  }

  $(document).ready(() => {
    const $table = $("#rentalAgreementTable");
    if (!$table.length) return;

    // Initialize and store globally
    window.rentalAgreementTable = $table.DataTable({
      ajax: {
        url: "/Rental-Management-System/functions/list_rental_agreements.php",
        dataSrc: "",
      },
      rowId: "agreementId",
      columns: [
        {
          data: null,
          render: (_, __, ___, meta) => meta.row + 1,
        },
        { data: "roomTitle" },
        { data: "propertyName" },
        { data: "tenantName" },
        { data: "landlordName" },
        { data: "agreementStartDate" },
        { data: "agreementEndDate" },
        { data: "agreementStatus" },
        {
          data: null,
          orderable: false,
          render: (row) => `
        <button class="btn btn-sm btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#editAgreementModal-${row.agreementId}">
          Edit
        </button>
       
        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#ChangeStatusModal-${row.agreementId}">Change Status</button> 
        `,
        },
      ],
      responsive: true,
      pageLength: 10,
      order: [[1, "asc"]],
    });
  });
})();
