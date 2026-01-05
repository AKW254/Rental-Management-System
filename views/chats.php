<?php
//Start session
session_start();
require_once('../config/config.php');
include('../config/checklogin.php');
check_login()
//Check if user is logged in

?>
<!DOCTYPE html>
<html lang="en">

<?php include('../partials/head.php') ?>

<body class="sidebar-icon-only sidebar-fixed">

    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        <?php include('../partials/sidebar.php') ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <?php include('../partials/navbar.php') ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Chats </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Chats</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="email-wrapper wrapper">
                                <div class="row align-items-stretch">
                                    <div class="mail-sidebar d-none d-lg-block col-4 pt-3 bg-dark">
                                        <div class="menu-bar">
                                            <ul class="menu-items">
                                                <li class="compose mb-3"><button class="btn btn-primary btn-block">Compose</button></li>
                                                <li class="active"><a href="#"><i class="mdi mdi-email-outline"></i> Inbox</a><span class="badge badge-pill badge-success">8</span></li>
                                                <li><a href="#"><i class="mdi mdi-share"></i> Sent</a></li>

                                            </ul>
                                            <div class="wrapper">
                                                <div class="online-status d-flex justify-content-between align-items-center">
                                                    <p class="chat">Chats</p> <span class="status offline online"></span>
                                                </div>
                                            </div>
                                            <ul class="profile-list">
                                                <li class="profile-list-item"> <a href="#"> <span class="pro-pic"><img src="../../../assets/images/faces/face1.jpg" alt=""></span>
                                                        <div class="user">
                                                            <p class="u-name">David</p>
                                                            <p class="u-designation">Python Developer</p>
                                                        </div>
                                                    </a></li>
                                                <li class="profile-list-item"> <a href="#"> <span class="pro-pic"><img src="../../../assets/images/faces/face2.jpg" alt=""></span>
                                                        <div class="user">
                                                            <p class="u-name">Stella Johnson</p>
                                                            <p class="u-designation">SEO Expert</p>
                                                        </div>
                                                    </a></li>
                                                <li class="profile-list-item"> <a href="#"> <span class="pro-pic"><img src="../../../assets/images/faces/face20.jpg" alt=""></span>
                                                        <div class="user">
                                                            <p class="u-name">Catherine</p>
                                                            <p class="u-designation">IOS Developer</p>
                                                        </div>
                                                    </a></li>
                                                <li class="profile-list-item"> <a href="#"> <span class="pro-pic"><img src="../../../assets/images/faces/face12.jpg" alt=""></span>
                                                        <div class="user">
                                                            <p class="u-name">John Doe</p>
                                                            <p class="u-designation">Business Analyst</p>
                                                        </div>
                                                    </a></li>
                                                <li class="profile-list-item"> <a href="#"> <span class="pro-pic"><img src="../../../assets/images/faces/face25.jpg" alt=""></span>
                                                        <div class="user">
                                                            <p class="u-name">Daniel Russell</p>
                                                            <p class="u-designation">Tester</p>
                                                        </div>
                                                    </a></li>
                                                <li class="profile-list-item"> <a href="#"> <span class="pro-pic"><img src="../../../assets/images/faces/face10.jpg" alt=""></span>
                                                        <div class="user">
                                                            <p class="u-name">Sarah Graves</p>
                                                            <p class="u-designation">Admin</p>
                                                        </div>
                                                    </a></li>
                                                <li class="profile-list-item"> <a href="#"> <span class="pro-pic"><img src="../../../assets/images/faces/face23.jpg" alt=""></span>
                                                        <div class="user">
                                                            <p class="u-name">Sophia Lara</p>
                                                            <p class="u-designation">UI/UX</p>
                                                        </div>
                                                    </a></li>
                                                <li class="profile-list-item"> <a href="#"> <span class="pro-pic"><img src="../../../assets/images/faces/face11.jpg" alt=""></span>
                                                        <div class="user">
                                                            <p class="u-name">Catherine Myers</p>
                                                            <p class="u-designation">Business Analyst</p>
                                                        </div>
                                                    </a></li>
                                                <li class="profile-list-item"> <a href="#"> <span class="pro-pic"><img src="../../../assets/images/faces/face9.jpg" alt=""></span>
                                                        <div class="user">
                                                            <p class="u-name">Tim</p>
                                                            <p class="u-designation">PHP Developer</p>
                                                        </div>
                                                    </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mail-list-container col-8 pt-4 pb-2 border-right bg-dark">
                                        <div class="border-bottom pb-4 mb-3 px-3">
                                            <div class="form-group">
                                                <input class="form-control w-100" type="search" placeholder="Search mail" id="Mail-rearch">
                                            </div>
                                        </div>
                                        <div class="mail-list">
                                            <div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input"> <i class="input-helper"></i></label></div>
                                            <div class="content">
                                                <p class="sender-name">David Moore</p>
                                                <p class="message_text">Hi Emily, Please be informed that the new project presentation is due Monday.</p>
                                            </div>
                                            <div class="details">
                                                <i class="mdi mdi-star-outline"></i>
                                            </div>
                                        </div>
                                        <div class="mail-list new_mail">
                                            <div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input" checked=""> <i class="input-helper"></i></label></div>
                                            <div class="content">
                                                <p class="sender-name">Microsoft Account Password Change</p>
                                                <p class="message_text">Change the password for your Microsoft Account using the security code 35525 </p>
                                            </div>
                                            <div class="details">
                                                <i class="mdi mdi-star favorite"></i>
                                            </div>
                                        </div>
                                        <div class="mail-list">
                                            <div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input"> <i class="input-helper"></i></label></div>
                                            <div class="content">
                                                <p class="sender-name">Sophia Lara</p>
                                                <p class="message_text">Hello, last date for registering for the annual music event is closing in </p>
                                            </div>
                                            <div class="details">
                                                <i class="mdi mdi-star-outline"></i>
                                            </div>
                                        </div>
                                        <div class="mail-list">
                                            <div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input"> <i class="input-helper"></i></label></div>
                                            <div class="content">
                                                <p class="sender-name">Stella Davidson</p>
                                                <p class="message_text">Hey there, can you send me this year’s holiday calendar?</p>
                                            </div>
                                            <div class="details">
                                                <i class="mdi mdi-star favorite"></i>
                                            </div>
                                        </div>
                                        <div class="mail-list">
                                            <div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input"> <i class="input-helper"></i></label></div>
                                            <div class="content">
                                                <p class="sender-name">David Moore</p>
                                                <p class="message_text">FYI</p>
                                            </div>
                                            <div class="details">
                                                <i class="mdi mdi-star favorite"></i>
                                            </div>
                                        </div>
                                        <div class="mail-list">
                                            <div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input"> <i class="input-helper"></i></label></div>
                                            <div class="content">
                                                <p class="sender-name">Daniel Russel</p>
                                                <p class="message_text">Hi, Please find this week’s update..</p>
                                            </div>
                                            <div class="details">
                                                <i class="mdi mdi-star-outline"></i>
                                            </div>
                                        </div>
                                        <div class="mail-list">
                                            <div class="form-check"><label class="form-check-label"> <input type="checkbox" class="form-check-input"> <i class="input-helper"></i></label></div>
                                            <div class="content">
                                                <p class="sender-name">Sarah Graves</p>
                                                <p class="message_text">Hey, can you send me this year’s holiday calendar ?</p>
                                            </div>
                                            <div class="details">
                                                <i class="mdi mdi-star-outline"></i>
                                            </div>
                                        </div>
                                        <div class="mail-list">
                                            <div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input"> <i class="input-helper"></i></label></div>
                                            <div class="content">
                                                <p class="sender-name">Bruno King</p>
                                                <p class="message_text">Hi, Please find this week’s monitoring report in the attachment.</p>
                                            </div>
                                            <div class="details">
                                                <i class="mdi mdi-star-outline"></i>
                                            </div>
                                        </div>
                                        <div class="mail-list">
                                            <div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input"> <i class="input-helper"></i></label></div>
                                            <div class="content">
                                                <p class="sender-name">Me, Mark</p>
                                                <p class="message_text">Hi, Testing is complete. The system is ready to go live.</p>
                                            </div>
                                            <div class="details">
                                                <i class="mdi mdi-star-outline"></i>
                                            </div>
                                        </div>
                                        <div class="mail-list">
                                            <div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input"> <i class="input-helper"></i></label></div>
                                            <div class="content">
                                                <p class="sender-name">Catherine Myers</p>
                                                <p class="message_text">Template Market: Limited Period Offer!!! 50% Discount on all Templates.</p>
                                            </div>
                                            <div class="details">
                                                <i class="mdi mdi-star favorite"></i>
                                            </div>
                                        </div>
                                        <div class="mail-list">
                                            <div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input"> <i class="input-helper"></i></label></div>
                                            <div class="content">
                                                <p class="sender-name">Daniel Russell</p>
                                                <p class="message_text">Hi Emily, Please approve my leaves for 10 days from 10th May to 20th May. </p>
                                            </div>
                                            <div class="details">
                                                <i class="mdi mdi-star-outline"></i>
                                            </div>
                                        </div>
                                        <div class="mail-list">
                                            <div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input"> <i class="input-helper"></i></label></div>
                                            <div class="content">
                                                <p class="sender-name">Sarah Graves</p>
                                                <p class="message_text">Hello there, Make the most of the limited period offer. Grab your favorites </p>
                                            </div>
                                            <div class="details">
                                                <i class="mdi mdi-star-outline"></i>
                                            </div>
                                        </div>
                                        <div class="mail-list">
                                            <div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input"> <i class="input-helper"></i></label></div>
                                            <div class="content">
                                                <p class="sender-name">John Doe</p>
                                                <p class="message_text">This is the first reminder to complete the online cybersecurity course</p>
                                            </div>
                                            <div class="details">
                                                <i class="mdi mdi-star-outline"></i>
                                            </div>
                                        </div>
                                        <div class="mail-list">
                                            <div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input"> <i class="input-helper"></i></label></div>
                                            <div class="content">
                                                <p class="sender-name">Bruno</p>
                                                <p class="message_text">Dear Employee, As per the regulations all employees are required to complete </p>
                                            </div>
                                            <div class="details">
                                                <i class="mdi mdi-star-outline"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="mail-view d-none d-md-block col-md-9 col-lg-7 bg-dark">
                                        <div class="row">
                                            <div class="col-md-12 mb-4 mt-4">
                                                <div class="btn-toolbar">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary"><i class="mdi mdi-reply text-primary"></i> Reply</button>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary"><i class="mdi mdi-reply-all text-primary"></i>Reply All</button>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary"><i class="mdi mdi-share text-primary"></i>Forward</button>
                                                    </div>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary"><i class="mdi mdi-attachment text-primary"></i>Attach</button>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary"><i class="mdi mdi-delete text-primary"></i>Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="message-body">
                                            <div class="sender-details">
                                                <img class="img-sm rounded-circle me-3" src="../../../assets/images/faces/face11.jpg" alt="">
                                                <div class="details">
                                                    <p class="msg-subject"> Weekly Update - Week 19 (May 8, 2017 - May 14, 2017) </p>
                                                    <p class="sender-email"> Sarah Graves <a href="#">itsmesarah268@gmail.com</a> &nbsp;<i class="mdi mdi-account-multiple-plus"></i>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="message-content">
                                                <p>Hi Emily,</p>
                                                <p>This week has been a great week and the team is right on schedule with the set deadline. The team has made great progress and achievements this week. At the current rate we will be able to deliver the product right on time and meet the quality that is expected of us. Attached are the seminar report held this week by our team and the final product design that needs your approval at the earliest.</p>
                                                <p>For the coming week the highest priority is given to the development for <a href="http://www.bootstrapdash.com/" target="_blank">http://www.bootstrapdash.com/</a> once the design is approved and necessary improvements are made.</p>
                                                <p><br><br>Regards,<br>Sarah Graves</p>
                                            </div>
                                            <div class="attachments-sections">
                                                <ul>
                                                    <li>
                                                        <div class="thumb"><i class="mdi mdi-file-pdf"></i></div>
                                                        <div class="details">
                                                            <p class="file-name">Seminar Reports.pdf</p>
                                                            <div class="buttons">
                                                                <p class="file-size">678Kb</p>
                                                                <a href="#" class="view">View</a>
                                                                <a href="#" class="download">Download</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="thumb"><i class="mdi mdi-file-image"></i></div>
                                                        <div class="details">
                                                            <p class="file-name">Product Design.jpg</p>
                                                            <div class="buttons">
                                                                <p class="file-size">1.96Mb</p>
                                                                <a href="#" class="view">View</a>
                                                                <a href="#" class="download">Download</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- main-panel ends -->
        <!-- container-scroller -->
        <?php include('../functions/custom_alerts.php'); ?>
        <!--Add User Script -->
        <script>
            //create user
            const form = document.getElementById('addUserForm');
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                try {
                    const response = await fetch('../functions/create_user.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        showToast('success', result.message);
                    } else {
                        showToast('error', result.error || 'An error occurred.');
                    }
                } catch (error) {
                    console.error('Fetch error:', error);
                    showToast('error', 'A network error occurred.');
                }
            });
        </script>
        <!--Change User Role Script -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Attach to every Change Role form
                document.querySelectorAll("form[id^='changeRoleUserForm-']").forEach(form => {
                    form.addEventListener('submit', async function(e) {
                        e.preventDefault();
                        const formData = new FormData(this);
                        const userId = formData.get('user_id');
                        const select = this.querySelector('select[name="role_id"]');
                        const newRole = select.options[select.selectedIndex].text;

                        try {
                            const res = await fetch('../functions/change_role.php', {
                                method: 'POST',
                                body: formData
                            });
                            const json = await res.json();

                            if (json.success) {
                                // 1) Update the role cell in the corresponding row
                                const row = document.querySelector(`tr[data-user-id="${userId}"]`);
                                if (row) {
                                    row.querySelector('.role-cell').innerText = newRole;
                                }

                                // 2) Close the Bootstrap modal
                                const modalEl = this.closest('.modal');
                                bootstrap.Modal.getInstance(modalEl).hide();

                                // 3) Show a toast or alert
                                showToast('success', json.message);
                            } else {
                                showToast('error', json.error || 'Failed to update role');
                            }
                        } catch (err) {
                            console.error(err);
                            showToast('error', 'Network error');
                        }
                    });
                });
            });
        </script>
        <!--Edit User Script -->
        <script>
            //Edit user
            const editForm = document.querySelectorAll('form[id^="editUserForm-"]');
            editForm.forEach(form => {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const userId = formData.get('user_id');
                    const userName = formData.get('user_name');
                    const userEmail = formData.get('user_email');
                    const userPhone = formData.get('user_phone');
                    try {
                        const response = await fetch('../functions/edit_user.php', {
                            method: 'POST',
                            body: formData
                        });

                        const result = await response.json();

                        if (result.success) {
                            // Update the user details in the table
                            const row = document.querySelector(`tr[data-user-id="${userId}"]`);
                            if (row) {
                                row.querySelector('td:nth-child(2)').innerText = userName;
                                row.querySelector('td:nth-child(3)').innerText = userEmail;
                                row.querySelector('td:nth-child(4)').innerText = userPhone;
                            }
                            // Close the modal
                            const modalEl = this.closest('.modal');
                            bootstrap.Modal.getInstance(modalEl).hide();
                            showToast('success', result.message);
                        } else {
                            showToast('error', result.error || 'An error occurred.');
                        }
                    } catch (error) {
                        console.error('Fetch error:', error);
                        showToast('error', 'A network error occurred.');
                    }
                });
            });
        </script>
        <!--Delete User Script -->
        <script>
            const deleteForms = document.querySelectorAll('form[id^="deleteUserForm-"]');
            deleteForms.forEach(form => {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const userId = formData.get('user_id');

                    try {
                        const response = await fetch('../functions/delete_user.php', {
                            method: 'POST',
                            body: formData
                        });

                        const result = await response.json();

                        if (result.success) {
                            // Check if the deleted user is the current user
                            if (userId === '<?php echo $_SESSION['user_id']; ?>') {
                                // Redirect to login page
                                window.location.href = 'logout.php';
                            } else {
                                // Remove the user row from the table
                                const row = document.querySelector(`tr[data-user-id="${userId}"]`);
                                if (row) {
                                    row.remove();
                                }
                                // Close the modal
                                const modalEl = this.closest('.modal');
                                bootstrap.Modal.getInstance(modalEl).hide();
                                showToast('success', result.message);
                            }
                        } else {
                            showToast('error', result.error || 'An error occurred.');
                        }
                    } catch (error) {
                        console.error('Fetch error:', error);
                        showToast('error', 'A network error occurred.');
                    }
                });
            });
        </script>

        <script src="../public/assets/vendors/modal/modal-demo.js"></script>
        <script src="../public/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
        <script src="../public/assets/vendors/datatables.net-bs4/query.dataTables.js"></script>
        <script src="../public/assets/vendors/datatables.net-bs4/data-table.js"></script>

        <?php include('../partials/scripts.php') ?>


</body>



</html>