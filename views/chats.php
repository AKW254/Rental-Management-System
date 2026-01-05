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
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="email-wrapper wrapper">
                                <div class="row align-items-stretch">
                                    <div class="mail-sidebar col-4 pt-3 bg-dark">
                                        <div class="menu-bar">
                                            <ul class="menu-items">
                                                <li class="compose mb-3"><button class="btn btn-primary btn-block" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Compose</button></li>
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
                                    <div class="mail-list-container col-sm-8 col-lg-8 col-md-8 pt-4 pb-2 border-right bg-dark">
                                        <div class="border-bottom pb-4 mb-3 px-3">
                                            <div class="border-bottom pb-3 mb-3 px-3 sticky-top bg-dark">
                                                <input class="form-control w-100" type="search" placeholder="Search mail" id="mail-search">
                                            </div>
                                        </div>
                                        <div class="mail-list">

                                            <div class="content">
                                                <p class="sender-name">David Moore</p>
                                                <p class="message_text">Hi Emily, Please be informed that the new project presentation is due Monday.</p>
                                            </div>

                                        </div>
                                        <div class="mail-list">

                                            <div class="content">
                                                <p class="sender-name">Microsoft Account Password Change</p>
                                                <p class="message_text">Change the password for your Microsoft Account using the security code 35525 </p>
                                            </div>

                                        </div>
                                        <div class="mail-list">

                                            <div class="content">
                                                <p class="sender-name">Sophia Lara</p>
                                                <p class="message_text">Hello, last date for registering for the annual music event is closing in </p>
                                            </div>

                                        </div>
                                        <div class="mail-list">

                                            <div class="content">
                                                <p class="sender-name">Stella Davidson</p>
                                                <p class="message_text">Hey there, can you send me this year’s holiday calendar?</p>
                                            </div>

                                        </div>
                                        <div class="mail-list">

                                            <div class="content">
                                                <p class="sender-name">David Moore</p>
                                                <p class="message_text">FYI</p>
                                            </div>

                                        </div>
                                        <div class="mail-list">

                                            <div class="content">
                                                <p class="sender-name">Daniel Russel</p>
                                                <p class="message_text">Hi, Please find this week’s update..</p>
                                            </div>

                                        </div>
                                        <div class="mail-list">

                                            <div class="content">
                                                <p class="sender-name">Sarah Graves</p>
                                                <p class="message_text">Hey, can you send me this year’s holiday calendar ?</p>
                                            </div>

                                        </div>
                                        <div class="mail-list">

                                            <div class="content">
                                                <p class="sender-name">Bruno King</p>
                                                <p class="message_text">Hi, Please find this week’s monitoring report in the attachment.</p>
                                            </div>

                                        </div>
                                        <div class="mail-list">

                                            <div class="content">
                                                <p class="sender-name">Me, Mark</p>
                                                <p class="message_text">Hi, Testing is complete. The system is ready to go live.</p>
                                            </div>

                                        </div>
                                        <div class="mail-list">

                                            <div class="content">
                                                <p class="sender-name">Catherine Myers</p>
                                                <p class="message_text">Template Market: Limited Period Offer!!! 50% Discount on all Templates.</p>
                                            </div>

                                        </div>
                                        <div class="mail-list">

                                            <div class="content">
                                                <p class="sender-name">Daniel Russell</p>
                                                <p class="message_text">Hi Emily, Please approve my leaves for 10 days from 10th May to 20th May. </p>
                                            </div>

                                        </div>
                                        <div class="mail-list">

                                            <div class="content">
                                                <p class="sender-name">Sarah Graves</p>
                                                <p class="message_text">Hello there, Make the most of the limited period offer. Grab your favorites </p>
                                            </div>

                                        </div>
                                        <div class="mail-list">

                                            <div class="content">
                                                <p class="sender-name">John Doe</p>
                                                <p class="message_text">This is the first reminder to complete the online cybersecurity course</p>
                                            </div>

                                        </div>
                                        <div class="mail-list">

                                            <div class="content">
                                                <p class="sender-name">Bruno</p>
                                                <p class="message_text">Dear Employee, As per the regulations all employees are required to complete </p>
                                            </div>

                                        </div>
                                        <!-- NO RESULTS MESSAGE -->
                                        <div class="mail-list col-8" id="no-results"
                                            class="content"
                                            style=" display:none;">
                                            <div class="message_text">
                                                No messages found for your search.Please try again with different keywords.
                                            </div>
                                        </div>

                                    </div>
                                    <!--Message view-->
                                    <div class="mail-view d-none d-md-block col-md-8 col-lg-8 pt-4 pb-2 border-right bg-dark" id="mail-view">
                                        <div class="row">
                                            <div class="col-sm-8 col-lg-8 col-md-8 mb-4 mt-4">
                                                <div class="btn-toolbar">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary"><i class="mdi mdi-reply text-primary"></i> Reply</button>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary"><i class="mdi mdi-delete text-primary"></i>Delete</button>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary"><i class="mdi mdi-printer text-primary"></i>Print</button>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="back-to-list"><i class="mdi mdi-arrow-left text-primary"></i>Back</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="message-body">
                                            <div class="sender-details">
                                                <img class="img-sm rounded-circle me-3" src="../../../assets/images/faces/face11.jpg" alt="No profile image">
                                                <div class="details">

                                                    <p class="sender-email">From: <span id="view-sender"></span></p>
                                                </div>
                                            </div>
                                            <div class="message-content" id="view-content">


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
                                            <!--Reply section-->
                                            <div class="reply-section d-none d-block">
                                                <h5 class="mb-3">Reply</h5>
                                                <form>
                                                    <div class="form-group">
                                                        <textarea class="form-control" id="reply-message" rows="4" placeholder="Type your message here..."></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-2">Send Reply</button>
                                                </form>
                                            </div>
                                        </div>
                                        <!--Compose Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Compose Message</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="form-group">
                                                                <label for="exampleInputUsername2" class="col-form-label">To:</label>
                                                                <div class="col-12">
                                                                    <input type="text" class="form-control col-12" id="exampleInputUsername2" placeholder="Username">
                                                                </div>
                                                            </div>
                                                            </hr>
                                                            <div class="form-group">
                                                                <label for="exampleTextarea1">Message</label>
                                                                <textarea class="form-control" id="exampleTextarea1" rows="4"></textarea>
                                                            </div>
                                                            <div class="btn-group">
                                                                <label class="btn btn-sm btn-outline-secondary me-2">
                                                                    <i class="mdi mdi-attachment text-primary">Attachment</i>
                                                                    <input type="file" name="img[]" hidden>
                                                                </label>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success">Send</button>
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', () => {
                                                function debounce(fn, delay = 300) {
                                                    let timeout;
                                                    return function(...args) {
                                                        clearTimeout(timeout);
                                                        timeout = setTimeout(() => fn.apply(this, args), delay);
                                                    };
                                                }

                                                function filterMails() {
                                                    const input = document.getElementById('mail-search');
                                                    const filter = input.value.toLowerCase();
                                                    const mails = document.querySelectorAll('.mail-list');
                                                    const noResults = document.getElementById('no-results');


                                                    let visibleCount = 0;

                                                    mails.forEach(mail => {
                                                        const sender = mail.querySelector('.sender-name')?.textContent.toLowerCase() || '';
                                                        const message = mail.querySelector('.message_text')?.textContent.toLowerCase() || '';

                                                        if (sender.includes(filter) || message.includes(filter)) {
                                                            mail.style.display = '';
                                                            visibleCount++;
                                                        } else {
                                                            mail.style.display = 'none';
                                                        }
                                                    });

                                                    noResults.style.display = visibleCount === 0 ? 'block' : 'none';

                                                }

                                                document
                                                    .getElementById('mail-search')
                                                    .addEventListener('keyup', debounce(filterMails, 300));
                                            });
                                        </script>

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

            <!--Open conversation Script -->
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const mails = document.querySelectorAll('.mail-list');
                    const mailView = document.getElementById('mail-view');

                    const viewSender = document.getElementById('view-sender');
                    const viewContent = document.getElementById('view-content');
                    const mailListContainer = document.querySelector('.mail-list-container');

                    mails.forEach(mail => {
                        mail.addEventListener('click', () => {
                            const sender = mail.querySelector('.sender-name').textContent;
                            const message = mail.querySelector('.message_text').textContent;

                            // Populate the mail view

                            viewSender.textContent = sender;
                            viewContent.textContent = message;

                            // Show the mail view panel
                            mailView.classList.remove('d-none');
                            // Optionally, you can hide the mail list panel if needed
                            // mailListContainer.classList.add('d-none');
                            // Hide the whole mail list
                            mailListContainer.classList.add('d-none');
                        });
                    });
                });
            </script>
            <!--Back to mail list script-->
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const backToListButton = document.getElementById('back-to-list');
                    const mailView = document.getElementById('mail-view');
                    const mailListContainer = document.querySelector('.mail-list-container');

                    backToListButton.addEventListener('click', () => {
                        // Hide the mail view panel
                        mailView.classList.add('d-none');
                        // Show the mail list panel
                        mailListContainer.classList.remove('d-none');
                    });
                });
            </script>
            <!--Print conversation Script-->
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const printButton = document.querySelector('.btn-outline-secondary i.mdi-printer').parentElement;
                    const viewContent = document.querySelector('.message-body');

                    printButton.addEventListener('click', () => {
                        const printWindow = window.open('', '', 'height=600,width=800');
                        //Print div contents into the new window 
                        printWindow.document.write('<html><head><title>Print Message</title>');
                        printWindow.document.write('</head><body >');
                        printWindow.document.write(viewContent.innerHTML);
                        printWindow.document.write('</body></html>');
                        printWindow.document.close();
                        printWindow.print();
                    });
                });
            </script>
            <!--Show reply section Script-->
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const replyButton = document.querySelector('.btn-outline-secondary i.mdi-reply').parentElement;
                    const replySection = document.querySelector('.reply-section');

                    replyButton.addEventListener('click', () => {
                        replySection.classList.toggle('d-none');
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