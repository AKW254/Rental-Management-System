document.addEventListener("DOMContentLoaded", function () {
  const roleSelect = document.querySelector('select[name="role_id"]');
  const roleTypeInput = document.getElementById("role_type");

  if (roleSelect && roleTypeInput) {
    roleSelect.addEventListener("change", function () {
      const selectedOption = this.options[this.selectedIndex];
      const roleType = selectedOption.getAttribute("data-role-type") || "";
      roleTypeInput.value = roleType;
    });
  }
});
