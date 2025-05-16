<?php
$res = $mysqli->query("SELECT p.property_id, p.property_name, p.property_location, p.property_description, p.property_manager_id, u.user_name AS manager_name FROM properties p INNER JOIN users u ON p.property_manager_id = u.user_id");
while ($r = $res->fetch_assoc()) {
$row = ['property_id' => $r['property_id'], 'property_name' => $r['property_name'], 'property_location' => $r['property_location'], 'property_description' => $r['property_description'], 'property_manager_id' => $r['property_manager_id'], 'manager_name' => $r['manager_name']];
?>
<!--Edit property details -->
<div class="modal fade" id="editPropertyModal-<?php echo $row['property_id']; ?>" tabindex="-1" aria-labelledby="editPropertyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPropertyModalLabel">Edit Property</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editpropertyForm-<?php echo $row['property_id'] ?>">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-xl-6">
                            <label for="property-name" class="col-form-label">Property Name:</label>
                            <input type="text" class="form-control" id="PropertyName" name="property_name" value="<?php echo $row['property_name'] ?>" required>
                            <input type="hidden" name="property_id" value="<?php echo $row['property_id'] ?>" id="property_id-<?php echo $row['property_id']; ?>">
                        </div>
                        <div class="col-sm-12 col-md-6 col-xl-6">
                            <label for="property-location" class="col-form-label">Property Location:</label>
                            <input type="text" class="form-control" id="PropertyLocation" name="property_location" value="<?php echo $row['property_location'] ?>" required>
                        </div>
                        <div class="col-sm-12 col-md-6 col-xl-6">
                            <label for="property-price" class="col-form-label">Property Description:</label>
                            <textarea type="text" class="form-control" id="property_description" name="property_description" required><?php echo $row['property_description'] ?></textarea>
                        </div>
                        <div class="col-sm-12 col-md-6 col-xl-6">
                            <label for="property-type" class="col-form-label">Property Manager:</label>
                            <select name="property_manager_id" id="property_manager_id" class="form-control p_input">
                                <option selected value="<?php echo $row['property_manager_id'] ?>"><?php echo $row['manager_name'] ?></option>
                                <?php
                                $sql = "SELECT us.user_id, us.user_name FROM roles AS rs
                                                                         INNER JOIN users AS us ON us.role_id = rs.role_id 
                                                                         WHERE rs.role_id = '2'";
                                $result = $mysqli->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($managerRow = $result->fetch_assoc()) {
                                        echo "<option value='" . $managerRow['user_id'] . "' data-property-manager-name='" . $managerRow['user_name'] . "'>" . $managerRow['user_name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                            <input type="hidden" name="property_manager_name" id="property_manager_name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
<!--Delete User details -->
<div class="modal fade" id="deletePropertyModal-<?php echo $row['property_id']; ?>" tabindex="-1" aria-labelledby="deletePropertyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePropertyModalLabel">Delete <?php echo $row['property_name'] ?> managed by <?php echo $row['manager_name'] ?> ?</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="deletePropertyForm-<?php echo $row['property_id'] ?>" method="POST">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-xl-6">
                            <label for="recipient-name" class="col-form-label">
                                <p>Are you sure you want to delete this property? This process cannot be undone.</p>
                            </label>
                            <input type="hidden" name="property_id" value="<?php echo $row['property_id'] ?>" id="property_id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
}
?>