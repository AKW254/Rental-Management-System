<!--Edit property details -->
<div class="modal fade" id="editPropertyModal-<?php echo $row['property_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editPropertyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit Property</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editpropertyForm-<?php echo $row['property_id'] ?>" method="POST">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-xl-6">
                            <label for="property-name" class="col-form-label">Property Name:</label>
                            <input type="text" class="form-control" value="<?php echo $row['property_name'] ?>" id="PropertyName" name="property_name" required>
                            <input type="hidden" name="property_id" value="<?php echo $row['property_id'] ?>" id="property_id">
                        </div>
                        <div class="col-sm-12 col-md-6 col-xl-6">
                            <label for="property-location" class="col-form-label">PropertyLocation:</label>
                            <input type="text" class="form-control" value="<?php echo $row['property_location'] ?>" id="PropertyLocation" name="property_location" required>
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
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['user_id'] . "' data-property-manager-name='" . $row['user_name'] . "'>" . $row['user_name'] . "</option>";
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
<div class="modal fade" id="deletePropertyModal-<?php echo $row['property_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deletePropertyModalLabel" aria-hidden="true">
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
                            <label for="recipient-name" class="col-form-label">Are you sure you want to delete this property?.This process cannot be undone</label>
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