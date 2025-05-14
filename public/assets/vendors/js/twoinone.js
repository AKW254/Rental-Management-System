document.addEventListener("DOMContentLoaded", function () {
  // Role functionality
  const roleSelect = document.querySelector('select[name="role_id"]');
  const roleTypeInput = document.getElementById("role_type");

  if (roleSelect && roleTypeInput) {
    roleSelect.addEventListener("change", function () {
      const selectedOption = this.options[this.selectedIndex];
      const roleType = selectedOption.getAttribute("data-role-type") || "";
      roleTypeInput.value = roleType;
    });
  }

  // Property functionality
  const propertyManagerIdSelect = document.querySelector(
    'select[name="property_manager_id"]'
  );
  const propertyManagerNameInput = document.getElementById(
    "property_manager_name"
  );

  if (propertyManagerIdSelect && propertyManagerNameInput) {
    propertyManagerIdSelect.addEventListener("change", function () {
      const selectedOption = this.options[this.selectedIndex];
      const propertyManagerName =
        selectedOption.getAttribute("data-property-manager-name") || "";
      propertyManagerNameInput.value = propertyManagerName;
    });
  }
});
