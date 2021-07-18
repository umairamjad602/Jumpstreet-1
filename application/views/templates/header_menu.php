<header class="main-header">
    <!-- Logo -->
    <a href="dashboard" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>ADN</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
        <?php if(in_array('endOfDay', $user_permission)): ?>
            <a href="http://localhost/JumpStreetLatest/orders/end_of_the_day" type="button" onclick="return confirm('Are you sure you want to end <?php $date = $this->db->query("SELECT * from end_system_date ")->result(); echo $date[0]->dat_esystem; ?>?')" class="btn btn-warning pull-right" style="margin: 5px 15px">
                End of Day
            </a>
        <?php endif; ?>

    </nav>

    <div class="alert alert-warning text-center pt-5" id="success-alert" style="display: none; width: 145px; margin: 13% 50%; position: absolute; box-shadow: 5px 5px 20px black;">
        <b>Day Changed</b>
        <i class="fa fa-check"></i>
    </div>

  </header>
  <!-- Left side column. contains the logo and sidebar -->
