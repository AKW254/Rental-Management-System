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

<body class="sidebar-icon-only sidebar-fixed chat-page">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Sora:wght@500;600;700&display=swap');

        :root {
            --chat-bg: #0b1220;
            --chat-surface: #0f172a;
            --chat-surface-2: #141d33;
            --chat-surface-3: #0c1425;
            --chat-border: rgba(148, 163, 184, 0.18);
            --chat-text: #e5e7eb;
            --chat-muted: #94a3b8;
            --chat-accent: #22d3ee;
            --chat-accent-2: #f59e0b;
            --chat-shadow: 0 24px 48px rgba(2, 6, 23, 0.45);
        }

        body.chat-page {
            background: radial-gradient(1200px 600px at 10% -20%, rgba(34, 211, 238, 0.18), transparent 60%),
                radial-gradient(900px 500px at 90% 0%, rgba(245, 158, 11, 0.18), transparent 60%),
                linear-gradient(180deg, #0b1220 0%, #0f172a 35%, #0b1220 100%);
            color: var(--chat-text);
            font-family: 'DM Sans', sans-serif;
        }

        body.chat-page .page-title {
            font-family: 'Sora', sans-serif;
            letter-spacing: 0.3px;
        }

        body.chat-page .breadcrumb {
            color: var(--chat-muted);
        }

        body.chat-page .breadcrumb a {
            color: var(--chat-accent);
        }

        .chat-shell {
            display: grid;
            grid-template-columns: minmax(260px, 340px) 1fr;
            gap: 20px;
            padding: 18px;
            border-radius: 24px;
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid var(--chat-border);
            box-shadow: var(--chat-shadow);
            backdrop-filter: blur(10px);
        }

        .chat-list-panel,
        .chat-view-panel {
            min-height: 600px;
        }

        .chat-list-panel {
            background: var(--chat-surface);
            border-radius: 18px;
            border: 1px solid var(--chat-border);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-search {
            border-bottom: 1px solid var(--chat-border);
            background: rgba(10, 15, 30, 0.85);
            padding: 16px;
        }

        .chat-search .form-control {
            background: #0b1220;
            border: 1px solid rgba(148, 163, 184, 0.25);
            color: var(--chat-text);
            border-radius: 12px;
            height: 44px;
        }

        .chat-search .form-control::placeholder {
            color: var(--chat-muted);
        }

        .chat-search .btn {
            border-radius: 12px;
            padding: 10px 16px;
            font-weight: 600;
        }

        .chat-shell .btn-primary {
            background: var(--chat-accent);
            border-color: var(--chat-accent);
            color: #0b1220;
        }

        .chat-shell .btn-primary:hover {
            background: #38bdf8;
            border-color: #38bdf8;
            color: #0b1220;
        }

        #mailList {
            flex: 1;
            overflow-y: auto;
            padding: 8px;
        }

        #mailList::-webkit-scrollbar {
            width: 6px;
        }

        #mailList::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.3);
            border-radius: 999px;
        }

        .chat-list-item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding: 12px 14px;
            border-radius: 14px;
            margin: 6px;
            background: rgba(15, 23, 42, 0.65);
            border: 1px solid transparent;
            cursor: pointer;
            transition: transform 0.2s ease, background 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .chat-list-item:hover {
            background: rgba(34, 211, 238, 0.08);
            border-color: rgba(34, 211, 238, 0.35);
            transform: translateY(-1px);
        }

        .chat-list-item.is-active {
            background: rgba(34, 211, 238, 0.12);
            border-color: rgba(34, 211, 238, 0.5);
            box-shadow: 0 12px 24px rgba(14, 165, 233, 0.18);
        }

        .chat-list-avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #0b1220;
            background: linear-gradient(135deg, var(--chat-accent), #38bdf8);
            flex-shrink: 0;
        }

        .chat-list-item.is-me .chat-list-avatar {
            background: linear-gradient(135deg, var(--chat-accent-2), #f97316);
        }

        .chat-list-body {
            flex: 1;
            min-width: 0;
        }

        .chat-list-top {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            align-items: center;
            font-size: 0.85rem;
            color: var(--chat-muted);
        }

        .sender-name {
            color: var(--chat-text);
            font-weight: 600;
            font-size: 0.95rem;
        }

        .message_text {
            margin-top: 4px;
            color: var(--chat-muted);
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .chat-no-results {
            padding: 16px;
            color: var(--chat-muted);
        }

        .chat-view-panel {
            background: var(--chat-surface-2);
            border-radius: 18px;
            border: 1px solid var(--chat-border);
            padding: 18px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .chat-empty-state {
            flex: 1;
            border: 1px dashed var(--chat-border);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--chat-muted);
            padding: 24px;
        }

        .mail-view {
            display: flex;
            flex-direction: column;
            gap: 16px;
            height: 100%;
        }

        .chat-pane-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .chat-pane-title {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .chat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--chat-muted);
        }

        .chat-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            color: var(--chat-muted);
        }

        #view-sender {
            font-family: 'Sora', sans-serif;
            font-size: 1.2rem;
            color: var(--chat-text);
        }

        #view-time {
            font-size: 0.85rem;
            color: var(--chat-muted);
        }

        .chat-actions .btn {
            border-radius: 10px;
        }

        .chat-shell .btn-outline-secondary {
            border-color: var(--chat-border);
            color: var(--chat-text);
        }

        .chat-shell .btn-outline-secondary:hover {
            background: rgba(148, 163, 184, 0.16);
        }

        .message-body {
            background: var(--chat-surface-3);
            border-radius: 16px;
            padding: 18px;
            border: 1px solid var(--chat-border);
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .message-bubble {
            background: linear-gradient(135deg, rgba(34, 211, 238, 0.18), rgba(14, 165, 233, 0.08));
            border: 1px solid rgba(34, 211, 238, 0.25);
            color: var(--chat-text);
            border-radius: 16px;
            padding: 16px;
            line-height: 1.6;
            white-space: pre-wrap;
            min-height: 120px;
        }

        .reply-section textarea {
            background: #0b1220;
            color: var(--chat-text);
            border: 1px solid var(--chat-border);
            border-radius: 12px;
        }

        .reply-section textarea::placeholder {
            color: var(--chat-muted);
        }

        @media (max-width: 992px) {
            .chat-shell {
                grid-template-columns: 1fr;
                padding: 14px;
            }

            .chat-view-panel {
                display: none;
            }

            .chat-shell.chat-open .chat-view-panel {
                display: flex;
            }

            .chat-shell.chat-open .chat-list-panel {
                display: none;
            }
        }
    </style>

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
                            <div class="chat-shell">
                                <div class="chat-list-panel mail-list-container">
                                    <div class="chat-search sticky-top d-flex gap-2 align-items-center" style="top:0;">
                                        <input class="form-control flex-grow-1" type="search" placeholder="Search messages" id="mail-search">
                                        <div class="compose"><button class="btn btn-primary w-100" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Compose</button></div>
                                    </div>
                                    <div id="mailList"></div>
                                    <!-- NO RESULTS MESSAGE -->
                                    <div class="chat-no-results" id="no-results" style="display:none;">
                                        No messages found for your search. Please try again with different keywords.
                                    </div>
                                </div>
                                <div class="chat-view-panel">
                                    <div class="chat-empty-state" id="chat-empty">
                                        Select a message to preview the conversation.
                                    </div>
                                    <!--Message view-->
                                    <div class="mail-view d-none" id="mail-view">
                                        <div class="chat-pane-header">
                                            <div class="chat-pane-title">
                                                <span class="chat-label">Conversation</span>
                                                <div class="chat-meta">
                                                    <span id="view-sender"></span>
                                                    <span>&bull;</span>
                                                    <span id="view-time"></span>
                                                </div>
                                            </div>
                                            <div class="btn-toolbar chat-actions">
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
                                        <div class="message-body">
                                            <div class="message-bubble" id="view-content"></div>

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
                                        const mails = document.querySelectorAll('.chat-list-item');
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

            const chatShell = document.querySelector('.chat-shell');
            const mailView = document.getElementById('mail-view');
            const viewSender = document.getElementById('view-sender');
            const viewTime = document.getElementById('view-time');
            const viewContent = document.getElementById('view-content');
            const mailListContainer = document.getElementById('mailList');
            const backBtn = document.getElementById('back-to-list');
            const chatEmpty = document.getElementById('chat-empty');

            // OPEN MESSAGE
            mailListContainer.addEventListener('click', (e) => {

                const mail = e.target.closest('.chat-list-item');
                if (!mail) return;

                viewSender.textContent = mail.dataset.senderName || 'Unknown';
                viewTime.textContent = mail.dataset.chatTime || '';
                viewContent.textContent = mail.dataset.message || '';
                viewContent.dataset.chatId = mail.dataset.chatId;
                viewContent.dataset.chatCode = mail.dataset.chatCode;


                mailView.classList.remove('d-none');
                chatEmpty.classList.add('d-none');
                chatShell.classList.add('chat-open');

                document.querySelectorAll('.chat-list-item.is-active')
                    .forEach(item => item.classList.remove('is-active'));
                mail.classList.add('is-active');
            });

            // BACK TO LIST
            backBtn.addEventListener('click', () => {
                mailView.classList.add('d-none');
                chatEmpty.classList.remove('d-none');
                chatShell.classList.remove('chat-open');
            });

            // REPLY TOGGLE
            document.querySelector('.mdi-reply').closest('button')
                .addEventListener('click', () => {
                    document.querySelector('.reply-section')
                        .classList.toggle('d-none');
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
