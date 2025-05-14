 <!--Change Role User Modal -->
 <div class="modal fade" id="changeRoleUserModal-<?php echo $row['user_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-md" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="addUserModalLabel">Change User Role</h5>
                 <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form id="changeRoleUserForm-<?php echo $row['user_id'] ?>" method="POST">
                     <div class="row">

                         <div class="col-12 ">
                             <label for="message-text" class="col-form-label">Select User Role:</label>
                             <select name="role_id" id="role_id" class="form-control p_input">

                                 <?php
                                    $sql = "SELECT role_id, role_type FROM roles";
                                    $result = $mysqli->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($role = $result->fetch_assoc()) {
                                            echo "<option value='" . $role['role_id'] . "'>" . $role['role_type'] . "</option>";
                                        }
                                    }
                                    ?>
                             </select>
                             <input type="hidden" name="user_id" value="<?php echo $row['user_id'] ?>" id="user_id">
                         </div>

                         <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                             <button type="submit" class="btn btn-primary">Save changes</button>
                         </div>
                     </div>
                 </form>
                 <!-- Script to get the role type from the selected role -->

             </div>

         </div>
     </div>
 </div>
 <!--Edit User details -->
 <div class="modal fade" id="editUserModal-<?php echo $row['user_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                 <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form id="addUserForm" method="POST">
                     <div class="row">
                         <div class="col-sm-12 col-md-6 col-xl-6">
                             <label for="recipient-name" class="col-form-label">Full Name:</label>
                             <input type="text" class="form-control" value="<?php echo $row['user_name'] ?>" id="UserName" name="user_name" required>
                         </div>
                         <div class="col-sm-12 col-md-6 col-xl-6">
                             <label for="message-text" class="col-form-label">Email:</label>
                             <input type="email" class="form-control" value="<?php echo $row['user_email'] ?>" id="UserEmail" name="user_email" required>
                         </div>
                         <div class="col-sm-12 col-md-6 col-xl-6">
                             <label for="recipient-name" class="col-form-label">Phone No:</label>
                             <input type="text" class="form-control" value="<?php echo $row['user_phone'] ?>" id="UserPhone" name="user_phone" required>
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
 <div class="modal fade" id="deleteUserModal-<?php echo $row['user_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                 <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form id="deleteUserForm" method="POST">
                     <div class="row">
                         <div class="col-sm-12 col-md-6 col-xl-6">
                             <label for="recipient-name" class="col-form-label">Are you sure you want to delete this user?</label>
                             <input type="hidden" name="user_id" value="<?php echo $row['user_id'] ?>" id="user_id">
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