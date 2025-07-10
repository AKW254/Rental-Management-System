<?php
$res = $mysqli->query("SELECT rm.room_id, rm.room_title, pm.property_name, u.user_name AS tenant_name, u2.user_name AS landlord_name, ra.agreement_id, ra.agreement_start_date, ra.agreement_end_date, ra.agreement_status FROM rental_agreements ra
INNER JOIN rooms rm ON ra.room_id=rm.room_id
INNER JOIN properties pm ON rm.property_id=pm.property_id
INNER JOIN users u ON ra.tenant_id=u.user_id
INNER JOIN users u2 ON pm.property_manager_id=u2.user_id ORDER BY ra.agreement_created_at DESC");
while ($r = $res->fetch_assoc()) {
    $row = [
        'room_id' => $r['room_id'],
        'room_title' => $r['room_title'],
        'property_name' => $r['property_name'],
        'tenant_name' => $r['tenant_name'],
        'landlord_name' => $r['landlord_name'],
        'agreement_id' => $r['agreement_id'],
        'agreement_start_date' => $r['agreement_start_date'],
        'agreement_end_date' => $r['agreement_end_date'],
        'agreement_status' => $r['agreement_status']

    ];
?>
    <!--Edit property details -->
    <div class="modal fade" id="editAgreementModal-<?php echo $row['agreement_id']; ?>" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Agreement</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editAgreementForm-<?php echo $row['agreement_id'] ?>">
                        <div class="row">
                            <input type="hidden" name="action" value="edit_agreemet">
                            <div class="col-sm-12 col-md-12 col-xl-12">
                                <label for="property-name" class="col-form-label">Room No:</label>
                                <select class="form-control" id="room_id" name="room_id" required>
                                    <option selected>Change Room</option>
                                    <?php
                                    // Fetch all rooms for the dropdown
                                    $roomsRes = $mysqli->query("SELECT rs.room_id,rs.room_title FROM rooms AS rs 
                                    INNER JOIN rental_agreements AS ra ON rs.room_id = ra.room_id 
                                    WHERE rs.room_id != " . $row['room_id'] . " ORDER BY rs.room_title ASC");
                                    while ($room = $roomsRes->fetch_assoc()) {
                                        if ($room['room_id'] !== $row['room_id']) {
                                            echo '<option value="' . htmlspecialchars($room['room_id']) . '">' . htmlspecialchars($room['room_title']) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>

                                <input type="hidden" name="agreement_id" value="<?php echo $row['agreement_id'] ?>" id="agreement_id-<?php echo $row['agreement_id']; ?>">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="edit_agreement" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Delete User details -->
    <div class="modal fade" id="ChangeStatusModal-<?php echo $row['agreement_id']; ?>" tabindex="-1" aria-labelledby="deleteRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ChangeModalLabel">Change Rental Agreement Status</h5><br>

                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="ChangeStatusrentalAgreementForm-<?php echo $row['agreement_id'] ?>" method="POST">
                        <div class="row">
                            <input type="hidden" name="action" value="change_agreement_status">
                            <input type="hidden" name="agreement_id" value="<?php echo $row['agreement_id'] ?>" id="agreement_id-<?php echo $row['agreement_id']; ?>">
                            <div class="col-sm-12 col-md-12 col-xl-12">
                                <?php if ($row['agreement_status'] === 'Active'): ?>
                                    <label for="agreement_status_<?php echo $row['agreement_id']; ?>">Change Status:</label>
                                    <select class="form-control" id="agreement_status_<?php echo $row['agreement_id']; ?>" name="agreement_status" required>
                                        <option value="Active" selected>Active</option>
                                        <option value="Terminated">Terminated</option>
                                    </select>
                                <?php elseif ($row['agreement_status'] === 'Pending'): ?>
                                    <label for="agreement_status_<?php echo $row['agreement_id']; ?>">Change Status:</label>
                                    <select class="form-control" id="agreement_status_<?php echo $row['agreement_id']; ?>" name="agreement_status" required>
                                        <option value="Active">Active</option>
                                        <option value="Terminated">Terminated</option>
                                    </select>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="change_status" class="btn btn-danger">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>