
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 0.1.0
    </div>
    <strong>Copyright &copy; 2020 - <?php echo date('Y'); ?>.</strong> All rights
    reserved Simplatech Solutions (03402800963).
  </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

  <script>
      $(document).ready(function() {
          $('#endOfDay').on('click',function () {

              var last_date = '<?= date("d-m-yy",$this->db->query("SELECT date_time FROM `orders` ORDER by id DESC LIMIT 1")->row_array()["date_time"]); ?>';

              if(confirm(`Are you sure you want to end ${last_date} this day?`)){
                  $.ajax({
                      url: '/orders/endOfDay',
                      type: 'POST',
                      dataType: 'json',
                      success:function(response) {

                          if(response.success === true) {
                              $("#success-alert").show();
                              setTimeout(function() { $("#success-alert").hide(); }, 1000);
                          }
                      }
                  });
              }
          });
      });
  </script>
</body>
</html>
