 <?php
    //Administrator
    //if (($_SESSION['role_id']) == 1) {
    ?>
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
                             <h5 class="mb-0 font-weight-normal dynamictext" data-type="user_name"><?php echo $_SESSION['user_name']; ?></h5>
                             <span><?php echo $_SESSION['role_type']; ?></span>
                         </div>
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
                 <a class="nav-link" data-bs-toggle="collapse" href="#properties" aria-expanded="false" aria-controls="properties">
                     <span class="menu-icon">
                         <i class="mdi mdi-home"></i>
                     </span>
                     <span class="menu-title">Assets</span>

                 </a>
                 <div class="collapse" id="properties">
                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item"> <a class="nav-link" href="properties">Properties</a></li>
                         <li class="nav-item"> <a class="nav-link" href="rooms">Rooms</a></li>
                     </ul>
                 </div>
             </li>
             <li class="nav-item menu-items">
                 <a class="nav-link" href="maintenances">
                     <span class="menu-icon">
                         <i class="mdi mdi-account-group"></i>
                     </span>
                     <span class="menu-title">Maintenance</span>
                 </a>
             </li>
             <li class="nav-item menu-items">
                 <a class="nav-link" href="rental_agreements">
                     <span class="menu-icon">
                         <i class="mdi mdi-file-document"></i>
                     </span>
                     <span class="menu-title">Rental Agreements</span>

                 </a>

             </li>
             <li class="nav-item menu-items">
                 <a class="nav-link" data-bs-toggle="collapse" href="payments" aria-expanded="false" aria-controls="payments">
                     <span class="menu-icon">
                         <i class="mdi mdi-wallet"></i>
                     </span>
                     <span class="menu-title">Payments</span>

                 </a>

             </li>
             <li class="nav-item menu-items">
                 <a class="nav-link" data-bs-toggle="collapse" href="invoices" aria-expanded="false" aria-controls="invoices">
                     <span class="menu-icon">
                         <i class="mdi mdi-file-document"></i>
                     </span>
                     <span class="menu-title">Invoices</span>

                 </a>

             </li>
             <li class="nav-item menu-items">
                 <a class="nav-link" data-bs-toggle="collapse" href="chats" aria-expanded="false" aria-controls="chats">
                     <span class="menu-icon">
                         <i class="mdi mdi-chat"></i>
                     </span>
                     <span class="menu-title">Chats</span>
                 </a>
             </li>
             <li class="nav-item menu-items">
                 <a class="nav-link" data-bs-toggle="collapse" href="notifications" aria-expanded="false" aria-controls="notifications">
                     <span class="menu-icon">
                         <i class="mdi mdi-bell"></i>
                     </span>
                     <span class="menu-title">Notifications</span>
                 </a>
             </li>

         </ul>
     </nav>

 <?php //}
    //Landlord
   // elseif (($_SESSION['role_id']) == 2) {
   // }
    //Tenant
   // elseif (($_SESSION['role_id']) == 3) {
        # code...
  //  } ?>