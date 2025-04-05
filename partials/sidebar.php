 <nav class="sidebar sidebar-offcanvas" id="sidebar">
     <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
         <a class="navbar-brand" href="/">RMS</a>
     </div>
     <ul class="nav">
         <li class="nav-item profile">
             <div class="profile-desc">
                 <div class="profile-pic">
                     <div class="count-indicator">
                         <img class="img-xs rounded-circle " src="../public/images/dummy profile.jpg" alt="">
                         <span class="count bg-success"></span>
                     </div>
                     <div class="profile-name">
                         <h5 class="mb-0 font-weight-normal"><?php echo $_SESSION['user_name']; ?></h5>
                         <span><?php echo $_SESSION['role_name']; ?></span>
                     </div>
                 </div>
                 <a href="#" id="profile-dropdown" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                 <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                     <a href="user_profile" class="dropdown-item preview-item">
                         <div class="preview-thumbnail">
                             <div class="preview-icon bg-dark rounded-circle">
                                 <i class="mdi mdi-cog text-primary"></i>
                             </div>
                         </div>
                         <div class="preview-item-content">
                             <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                         </div>
                     </a>
                     <div class="dropdown-divider"></div>
                     <a href="user_password_change" class="dropdown-item preview-item">
                         <div class="preview-thumbnail">
                             <div class="preview-icon bg-dark rounded-circle">
                                 <i class="mdi mdi-onepassword  text-info"></i>
                             </div>
                         </div>
                         <div class="preview-item-content">
                             <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                         </div>
                     </a>


                 </div>
             </div>
         </li>
         <li class="nav-item nav-category">
             <span class="nav-link">Navigation</span>
         </li>
         <li class="nav-item menu-items">
             <a class="nav-link" href="dashboard">
                 <span class="menu-icon">
                     <i class="mdi mdi-speedometer"></i>
                 </span>
                 <span class="menu-title">Dashboard</span>
             </a>
         </li>
         <li class="nav-item menu-items">
             <a class="nav-link" href="users">
                 <span class="menu-icon">
                    <i class="mdi mdi-account-group"></i>
                 </span>
                 <span class="menu-title">Users</span>
             </a>
         </li>
         <li class="nav-item menu-items">
             <a class="nav-link" data-bs-toggle="collapse" href="properties" aria-expanded="false" aria-controls="page-layouts">
                 <span class="menu-icon">
                    <i class="mdi mdi-home"></i>
                 </span>
                 <span class="menu-title">Properities</span>
                
             </a>
             <div class="collapse" id="properties">
                 <ul class="nav flex-column sub-menu">
                     <li class="nav-item"> <a class="nav-link" href="properties">All Properties</a></li>
                     <li class="nav-item"> <a class="nav-link" href="rooms">All Rooms</a></li>
                 </ul>
             </div>
         </li>
         <li class="nav-item menu-items">
             <a class="nav-link" data-bs-toggle="collapse" href="maintenances" aria-expanded="false" aria-controls="sidebar-layouts">
                 <span class="menu-icon">
                    <i class="mdi mdi-wrench"></i>
                 </span>
                 <span class="menu-title">Maintenance</span>

             </a>

         </li>
         <li class="nav-item menu-items">
             <a class="nav-link" data-bs-toggle="collapse" href="rental_agreements" aria-expanded="false" aria-controls="ui-basic">
                 <span class="menu-icon">
                     <i class="mdi mdi-file-document"></i>
                 </span>
                 <span class="menu-title">Rental Agreements</span>

             </a>

         </li>
         <li class="nav-item menu-items">
             <a class="nav-link" data-bs-toggle="collapse" href="payments" aria-expanded="false" aria-controls="ui-advanced">
                 <span class="menu-icon">
                     <i class="mdi mdi-wallet"></i>
                 </span>
                 <span class="menu-title">Payments</span>

             </a>

         </li>
         <li class="nav-item menu-items">
             <a class="nav-link" data-bs-toggle="collapse" href="invoices" aria-expanded="false" aria-controls="form-elements">
                 <span class="menu-icon">
                    <i class="mdi mdi-file-document"></i>
                 </span>
                 <span class="menu-title">Invoices</span>

             </a>

         </li>
         <li class="nav-item menu-items">
             <a class="nav-link" data-bs-toggle="collapse" href="chats" aria-expanded="false" aria-controls="tables">
                 <span class="menu-icon">
                    <i class="mdi mdi-chat"></i>
                 </span>
                 <span class="menu-title">Chats</span>
             </a>
         </li>
         <li class="nav-item menu-items">
             <a class="nav-link" data-bs-toggle="collapse" href="notifications" aria-expanded="false" aria-controls="editors">
                 <span class="menu-icon">
                     <i class="mdi mdi-bell"></i>
                 </span>
                 <span class="menu-title">Notifications</span>
             </a>
         </li>

     </ul>
 </nav>