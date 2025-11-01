<?php
$res = $mysqli->query("SELECT rs.room_title, t.user_name AS requested_by, l.user_name AS requested_to, mr.maintenance_request_description, mr.maintenance_request_submitted_at, mr.maintenance_request_status, mr.maintenance_request_id, rs.room_id, rs.room_rent_amount, rs.property_id, p.property_name FROM maintenance_requests AS mr INNER JOIN rental_agreements AS ra ON mr.agreement_id = ra.agreement_id INNER JOIN rooms AS rs ON ra.room_id = rs.room_id INNER JOIN users AS t ON ra.tenant_id = t.user_id INNER JOIN users AS l ON mr.assigned_to = l.user_id INNER JOIN properties AS p ON rs.property_id = p.property_id;");
while ($r = $res->fetch_assoc()) {
    $row = [
        'maintenance_request_id'          => (int)   $r['maintenance_request_id'],
        'room_title'        => (string)$r['room_title'],
        'requested_by'    => (string)$r['requested_by'],
        'requested_to' => (string)$r['requested_to'],
        'maintenance_request_description'         => (string)$r['maintenance_request_description'],
        'maintenance_request_submitted_at'         => (string)$r['maintenance_request_submitted_at'],
        'maintenance_request_status'         => (string)$r['maintenance_request_status'],
    ];
?>
    <!--Edit property details -->
    <div class="modal fade" id="editRequestModal-<?php echo $row['maintenance_request_id']; ?>" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Maintenance Request</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editrequestForm-<?php echo $row['maintenance_request_id'] ?>">
                        <div class="row">
                            <input type="hidden" name="action" value="edit_maintenance_request">
                            <input type="hidden" name="maintenance_request_id" value="<?php echo $row['maintenance_request_id'] ?>" id="maintenance_request_id">
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <label for="recipient-name" class="col-form-label">Requested By:</label>
                                <input type="text" class="form-control" id="requested_by" name="requested_by" value="<?php echo $row['requested_by'] ?>" readonly>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <label for="recipient-name" class="col-form-label">Requested To:</label>
                                <input type="text" class="form-control" id="requested_to" name="requested_to" value="<?php echo $row['requested_to'] ?>" readonly>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <label for="recipient-name" class="col-form-label">Room No:</label>
                                <input type="text" class="form-control" id="room_title" name="room_title" value="<?php echo $row['room_title'] ?>" readonly>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <label for="recipient-name" class="col-form-label">Room Description:</label>
                                <textarea class="form-control" id="maintenance_request_description" name="maintenance_request_description" required><?php echo $row['maintenance_request_description'] ?></textarea>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <label for="recipient-name" class="col-form-label">Maintenance Status:</label>
                                <select name="maintenance_request_status" id="maintenance_request_status" class="form-control p_input">
                                    <option value="<?php echo $row['maintenance_request_status'] ?>"><?php echo $row['maintenance_request_status'] ?></option>

                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="edit_maintenance_request" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Delete User details -->
    <div class="modal fade" id="deleteRequestModal-<?php echo $row['maintenance_request_id']; ?>" tabindex="-1" aria-labelledby="deleteRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRequestModalLabel">Delete Room No. <?php echo $row['room_title'] ?>'s maintenance request on <?php echo date('d M Y', strtotime($row['maintenance_request_submitted_at'])) ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="deleteRequestForm-<?php echo $row['maintenance_request_id'] ?>" method="POST">
                        <div class="row">
                            <div class="col-12">
                                <label for="recipient-name" class="col-form-label">
                                    <p>This process cannot be undone. Are you sure you want to delete this room?</p>
                                </label>
                                <input type="hidden" name="action" value="delete_request">
                                <input type="hidden" name="maintenance_request_id" value="<?php echo $row['maintenance_request_id'] ?>" id="maintenance_request_id">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="delete_request" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>