<?php
$res = $mysqli->query("SELECT rm.room_id,rm.room_title,rm.room_rent_amount,rm.room_availability, rm.property_id,py.property_name AS property_name 
FROM rooms AS rm INNER JOIN properties AS py ON rm.property_id = py.property_id ");
while ($r = $res->fetch_assoc()) {
    $row = ['room_id' => $r['room_id'], 'room_title' => $r['room_title'], 'room_rent_amount' => $r['room_rent_amount'], 'room_availability' => $r['room_availability'], 'property_name' => $r['property_name'], 'property_id' => $r['property_id']];
?>
    <!--Edit property details -->
    <div class="modal fade" id="editRoomModal-<?php echo $row['room_id']; ?>" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoomModalLabel">Edit Room</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editroomForm-<?php echo $row['room_id'] ?>">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <label for="property-name" class="col-form-label">Room No:</label>
                                <input type="text" class="form-control" id="RoomTitle" name="room_title" value="<?php echo $row['property_name'] ?>" required>
                                <input type="hidden" name="room_id" value="<?php echo $row['room_id'] ?>" id="room_id-<?php echo $row['room_id']; ?>">
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <label for="message-text" class="col-form-label">Room Image:</label>
                                <input type="file" class="form-control" id="room_image" name="room_image" required>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <label for="recipient-name" class="col-form-label">Room Rent:</label>
                                <input class="form-control" id="room_rent_amount" name="room_rent_amount" value="<?php echo $row['room_rent_amount'] ?>" required>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <label for="message-text" class="col-form-label">Select Property:</label>
                                <select name="property_id" id="property_id" class="form-control p_input">
                                    <option value="<?php echo $row['property_id'] ?>"><?php echo $row['property_name'] ?></option>
                                    <?php
                                    $sql = "SELECT property_name,property_id FROM properties";
                                    $result = $mysqli->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['property_id'] . "'>" . $row['property_name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="edit_room" class="btn btn-primary">Save changes</button>
                            </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <!--Delete User details -->
    <div class="modal fade" id="deleteRoomModal-<?php echo $row['room_id']; ?>" tabindex="-1" aria-labelledby="deleteRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRoomModalLabel">Delete Room No.<?php echo $row['room_title'] ?> from <?php echo $row['property_name'] ?> Property ?</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="deleteRoomForm-<?php echo $row['room_id'] ?>" method="POST">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <label for="recipient-name" class="col-form-label">
                                    <p>Are you sure you want to delete this room? This process cannot be undone.</p>
                                </label>
                                <input type="hidden" name="room_id" value="<?php echo $row['room_id'] ?>" id="room_id">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="delete_room" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>