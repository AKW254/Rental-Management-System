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

<body class="sidebar-icon-only sidebar-fixed" style="background-color: black;">

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
                        <div class="container">
                            <div class="email-wrapper wrapper">
                                <div class="mail-list-container  pt-0 pb-2 border-right bg-dark">
                                    <div class="sticky-top bg-dark border-bottom px-3 py-3 d-flex gap-2" style="top:0;">
                                        <input class="form-control flex-grow-1" type="search" placeholder="Search message" id="mail-search">
                                        <div class="compose mb-3"><button class="btn btn-primary w-100" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Compose</button></div>
                                    </div>
                                    <div id="mailList"></div>
                                    <!-- NO RESULTS MESSAGE -->
                                    <div class="mail-list" id="no-results" style="display:none;">
                                        <div class="col-10 mail-list d-flex flex-column">
                                            No messages found for your search.Please try again with different keywords.
                                        </div>
                                    </div>
                                    <!--Message view-->
                                    <div class="mail-view d-none  pt-4 pb-2 border-right bg-dark" id="mail-view">
                                        <div class="row">
                                            <div class="col-sm-8 col-lg-8 col-md-8 mb-4 mt-4">
                                                <div class="btn-toolbar">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary"><i class="mdi mdi-reply text-primary"></i> Reply</button>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="delete-message">
                                                            <i class="mdi mdi-delete text-primary"></i> Delete
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary"><i class="mdi mdi-printer text-primary"></i>Print</button>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="back-to-list"><i class="mdi mdi-arrow-left text-primary"></i>Back</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="message-body">
                                            <div class="sender-details">
                                                <div class="details">

                                                    <p class="sender-email">From: <span id="view-sender"></span></p>
                                                </div>
                                            </div>
                                            <div class="message-content" id="view-content">
                                            </div>

                                            <!--Reply section-->
                                            <div class="reply-section d-none">
                                                <h5 class="mb-3">Reply</h5>
                                                <form id="replyForm" method="Post">
                                                    <div class="form-group">
                                                        <input type="hidden" name="chat_code" id="chat-code" />
                                                        <textarea class="form-control" id="reply-message" rows="4" placeholder="Type your message here..."></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-2">Send Reply</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
                                        <form id="composeForm" method="Post">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="username" class="col-form-label">To:</label>
                                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                                                </div>

                                                <div class="form-group">
                                                    <label for="message">Message</label>
                                                    <textarea class="form-control" id="message" name="message" rows="4"></textarea>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" id="sendBtn" class="btn btn-success">Send</button>
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>

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
        <!-- main-panel ends -->
    </div>
    <!-- container-scroller -->
    </div>


    <?php include('../functions/custom_alerts.php'); ?>

    <!--Open conversation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const mailView = document.getElementById('mail-view');
            const viewSender = document.getElementById('view-sender');
            const viewContent = document.getElementById('view-content');
            const mailListContainer = document.getElementById('mailList');
            const backBtn = document.getElementById('back-to-list');

            // OPEN MESSAGE
            mailListContainer.addEventListener('click', (e) => {

                const mail = e.target.closest('.mail-list');
                if (!mail) return;

                viewSender.textContent = mail.dataset.senderName;
                viewContent.textContent = mail.dataset.message;
                viewContent.dataset.chatId = mail.dataset.chatId;
                viewContent.dataset.chatCode = mail.dataset.chatCode;


                mailView.classList.remove('d-none');
                mailListContainer.classList.add('d-none');
            });

            // BACK TO LIST
            backBtn.addEventListener('click', () => {
                mailView.classList.add('d-none');
                mailListContainer.classList.remove('d-none');
            });

            // REPLY TOGGLE
            document.querySelector('.mdi-reply').closest('button')
                .addEventListener('click', () => {
                    document.querySelector('.reply-section')
                        .classList.toggle('d-none');
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
    <!--Compose message Post Backend -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const composeButton = document.getElementById('sendBtn');
            const form = document.getElementById('composeForm'); // <-- get form reference

            composeButton.addEventListener('click', () => {
                // Get variables from the form
                const to = document.getElementById('username').value;
                const message = document.getElementById('message').value;

                // Optional: simple validation
                if (!to || !message) {
                    showToast('error', 'Please fill in both fields.');
                    return;
                }

                // Post to backend php file using fetch API
                fetch('../functions/compose_message.php', {
                        method: 'POST',
                        body: new FormData(form) // <-- now form is defined
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('success', data.message);
                            // Close the modal
                            const modal = document.getElementById('exampleModal');
                            const modalInstance = bootstrap.Modal.getInstance(modal);
                            modalInstance.hide();
                            form.reset(); // optional: reset form after send
                        } else {
                            showToast('error', data.message || data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while sending the message.');
                    });
            });
        });
    </script>
    <!-- Reload Chats after message is sent -->
    <script>
        function loadMessages() {
            fetch('../functions/chats.php').then(response => response.text()).then(html => {
                document.getElementById('mailList').innerHTML = html;
            }).catch(error => {
                console.error('Error loading messages:', error);
            });
        }
        // Initial load
        loadMessages();

        // Optional: auto-refresh every 10 seconds
        let refreshInterval = setInterval(loadMessages, 10000);

        // When opening mail
        clearInterval(refreshInterval);
    </script>
    <!-- Reply to message Script-->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const replyForm = document.getElementById('replyForm');
            if (!replyForm) return;

            const replyMessageInput = document.getElementById('reply-message');


            replyForm.addEventListener('submit', (e) => {
                e.preventDefault();

                const replyMessage = replyMessageInput.value.trim();
                const chatCode = document.getElementById('view-content').dataset.chatCode;

                if (!replyMessage) {
                    showToast('error', 'Please enter a message to reply.');
                    return;
                }

                fetch('../functions/reply_message.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            chat_code: chatCode,
                            message: replyMessage
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showToast('success', data.message);
                            replyMessageInput.value = '';
                            document.getElementById('back-to-list').click();
                            loadMessages();

                        } else {
                            showToast('error', data.message || 'Reply failed');
                        }
                    })
                    .catch(() => {
                        showToast('error', 'Network error');
                    });
            });
        });
    </script>
    <!--Delete message Script-->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const deleteButton = document.querySelector('.btn-outline-secondary i.mdi-delete').parentElement;
            const viewContent = document.getElementById('view-content');

            deleteButton.addEventListener('click', () => {
                const chatId = viewContent.dataset.chatId;

                if (!chatId) {
                    showToast('error', 'No message selected to delete.');
                    return;
                }

                if (!confirm('Are you sure you want to delete this message?')) {
                    return;
                }

                fetch('../functions/delete_message.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            chat_id: chatId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showToast('success', data.message);
                            // Optionally, refresh the message list or navigate back
                            document.getElementById('back-to-list').click();
                            loadMessages();
                        } else {
                            showToast('error', data.message || 'Delete failed');
                        }
                    })
                    .catch(() => {
                        showToast('error', 'Network error');
                    });
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