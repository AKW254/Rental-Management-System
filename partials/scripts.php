 <!-- container-scroller -->
 <!-- plugins:js -->
 <script src="../public/assets/vendors/js/vendor.bundle.base.js"></script>
 <!-- endinject -->
 <!-- Plugin js for this page -->
 <script src="../public/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
 <script src="../public/assets/vendors/js/jquery.cookie.js" type="text/javascript"></script>
 <!-- End plugin js for this page -->
 <!-- inject:js -->
 <script src="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/scripts/verify.min.js"></script>
 <script src="../public/assets/vendors/js/off-canvas.js"></script>
 <script src="../public/assets/vendors/js/hoverable-collapse.js"></script>
 <script src="../public/assets/vendors/js/misc.js"></script>
 <script src="../public/assets/vendors/js/settings.js"></script>

 <!-- endinject -->
 <script src="../public/assets/vendors/js/dashboard.js"></script>

 <!-- Load Alerts -->
 <script src="../public/assets/vendors/toastr/toastr.min.js"></script>
 <!-- Init  Alerts -->
 <?php if (isset($success)) { ?>
     <!-- Pop Success Alert -->
     <script>
         toastr.success("<?php echo $success; ?>", "", {
             positionClass: "toast-top-center",
             timeOut: 4e3,
             onclick: null,
             showDuration: "200",
             hideDuration: "1000",
             extendedTimeOut: "1000",
             showEasing: "swing",
             hideEasing: "linear",
             showMethod: "fadeIn",
             hideMethod: "fadeOut",
         })
     </script>

 <?php }
    if (isset($err)) { ?>
     <script>
         toastr.error("<?php echo $err; ?>", "", {
             positionClass: "toast-top-center",
             timeOut: 5e3,
             onclick: null,
             showDuration: "300",
             hideDuration: "1000",
             extendedTimeOut: "1000",
             showEasing: "swing",
             hideEasing: "linear",
             showMethod: "fadeIn",
             hideMethod: "fadeOut",
         })
     </script>
 <?php }
    if (isset($info)) { ?>
     <script>
         toastr.warning("<?php echo $info; ?>", "", {
             positionClass: "toast-top-center",
             timeOut: 5e3,
             onclick: null,
             showDuration: "300",
             hideDuration: "1000",
             extendedTimeOut: "1000",
             showEasing: "swing",
             hideEasing: "linear",
             showMethod: "fadeIn",
             hideMethod: "fadeOut",
         })
     </script>
 <?php }
    ?>
 <script>
     /* Stop Double Resubmission */
     if (window.history.replaceState) {
         window.history.replaceState(null, null, window.location.href);
     }
 </script>

 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/material-design-icons@3.0.1/index.min.js"></script>
 <!--Leaflets Maps -->
 <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>