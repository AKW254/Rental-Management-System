 <nav class="navbar p-0 fixed-top d-flex flex-row">
     <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
         <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
             <span class="mdi mdi-menu"></span>
         </button>

         <ul class="navbar-nav navbar-nav-right">

             <li class="nav-item dropdown border-left">
                 <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                     <i class="mdi mdi-email"></i>
                     <span class="count bg-success"></span>
                 </a>
                 <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                     <h6 class="p-3 mb-0">Messages</h6>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item preview-item">
                         <div class="preview-thumbnail">
                             <img src="https://demo.bootstrapdash.com/corona-new/themes/assets/images/faces/face4.jpg" alt="image" class="rounded-circle profile-pic">
                         </div>
                         <div class="preview-item-content">
                             <p class="preview-subject ellipsis mb-1">Mark send you a message</p>
                             <p class="text-muted mb-0"> 1 Minutes ago </p>
                         </div>
                     </a>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item preview-item">
                         <div class="preview-thumbnail">
                             <img src="https://demo.bootstrapdash.com/corona-new/themes/assets/images/faces/face2.jpg" alt="image" class="rounded-circle profile-pic">
                         </div>
                         <div class="preview-item-content">
                             <p class="preview-subject ellipsis mb-1">Cregh send you a message</p>
                             <p class="text-muted mb-0"> 15 Minutes ago </p>
                         </div>
                     </a>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item preview-item">
                         <div class="preview-thumbnail">
                             <img src="https://demo.bootstrapdash.com/corona-new/themes/assets/images/faces/face3.jpg" alt="image" class="rounded-circle profile-pic">
                         </div>
                         <div class="preview-item-content">
                             <p class="preview-subject ellipsis mb-1">Profile picture updated</p>
                             <p class="text-muted mb-0"> 18 Minutes ago </p>
                         </div>
                     </a>
                     <div class="dropdown-divider"></div>
                     <p class="p-3 mb-0 text-center">4 new messages</p>
                 </div>
             </li>
             <li class="nav-item dropdown border-left">
                 <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                     <i class="mdi mdi-bell"></i>
                     <span class="count bg-danger"></span>
                 </a>
                 <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                     <h6 class="p-3 mb-0">Notifications</h6>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item preview-item">
                         <div class="preview-thumbnail">
                             <div class="preview-icon bg-dark rounded-circle">
                                 <i class="mdi mdi-calendar text-success"></i>
                             </div>
                         </div>
                         <div class="preview-item-content">
                             <p class="preview-subject mb-1">Event today</p>
                             <p class="text-muted ellipsis mb-0"> Just a reminder that you have an event today </p>
                         </div>
                     </a>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item preview-item">
                         <div class="preview-thumbnail">
                             <div class="preview-icon bg-dark rounded-circle">
                                 <i class="mdi mdi-cog text-danger"></i>
                             </div>
                         </div>
                         <div class="preview-item-content">
                             <p class="preview-subject mb-1">Settings</p>
                             <p class="text-muted ellipsis mb-0"> Update dashboard </p>
                         </div>
                     </a>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item preview-item">
                         <div class="preview-thumbnail">
                             <div class="preview-icon bg-dark rounded-circle">
                                 <i class="mdi mdi-link-variant text-warning"></i>
                             </div>
                         </div>
                         <div class="preview-item-content">
                             <p class="preview-subject mb-1">Launch Admin</p>
                             <p class="text-muted ellipsis mb-0"> New admin wow! </p>
                         </div>
                     </a>
                     <div class="dropdown-divider"></div>
                     <p class="p-3 mb-0 text-center">See all notifications</p>
                 </div>
             </li>
             <li class="nav-item dropdown">
                 <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
                     <div class="navbar-profile">
                         <img class="img-xs rounded-circle" src="../public/images/dummy profile.jpg" alt="">
                         <p class="mb-0 d-none d-sm-block navbar-profile-name dynamictext" data-type="user_name"><?php echo $_SESSION['user_name']; ?></p>
                         <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                     </div>
                 </a>
                 <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                     <h6 class="p-3 mb-0">Profile</h6>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item preview-item" href="user_profile">
                         <div class="preview-thumbnail">
                             <div class="preview-icon bg-dark rounded-circle">
                                 <i class="mdi mdi-cog text-success"></i>
                             </div>
                         </div>
                         <div class="preview-item-content">
                             <p class="preview-subject mb-1">Account Settings</p>
                         </div>
                     </a>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item preview-item" href="user_password_change">
                         <div class="preview-thumbnail">
                             <div class="preview-icon bg-dark rounded-circle">
                                 <i class="mdi mdi-onepassword text-info"></i>
                             </div>
                         </div>
                         <div class="preview-item-content">
                             <p class="preview-subject mb-1">Change Password</p>
                         </div>
                     </a>
                     <a class="dropdown-item preview-item" href="logout">
                         <div class="preview-thumbnail">
                             <div class="preview-icon bg-dark rounded-circle">
                                 <i class="mdi mdi-logout text-danger"></i>
                             </div>
                         </div>
                         <div class="preview-item-content">
                             <p class="preview-subject mb-1">Log out</p>
                         </div>
                     </a>

                 </div>
             </li>
         </ul>
         <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
             <span class="mdi mdi-format-line-spacing"></span>
         </button>
     </div>
 </nav>