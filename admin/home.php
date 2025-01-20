<style>
  .info-tooltip,.info-tooltip:focus,.info-tooltip:hover{
    background:unset;
    border:unset;
    padding:unset;
  }


 /* Notification circle */
  .notification {
    position: absolute;
    top: 10px; /* Adjust to position */
    left: 10px; /* Adjust to position */
    cursor: pointer;
  }

  .blink-circle {
    display: inline-block;
    background-color: red;
    color: white;
    width: 20px;
    height: 20px;
    line-height: 20px;
    text-align: center;
    border-radius: 50%;
    animation: blink 1s infinite;
  }

  @keyframes blink {
    0%, 50% {
      opacity: 1;
    }
    100% {
      opacity: 0;
    }
  }

  /* Popup Modal Styles */
  .popup-modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
  }

  .popup-content {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    position: relative;
  }

  .close-btn {
    position: absolute;
    top: -10px;
    right: 5px;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
  }


</style>
<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>
<div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-money-bill-alt"></i></span>


            <div class="info-box-content">
  <span class="info-box-text">Current Overall Budget</span>
  <span class="info-box-number text-right">
    <?php 
      $cur_bul = $conn->query("SELECT sum(balance) as total FROM `categories` where status = 1 ")->fetch_assoc()['total'];
      echo number_format($cur_bul);
    ?>
  </span>

  <!-- Notification for budget exceeding -->
  <?php if ($cur_bul > 100000): ?>
    <div class="notification" onclick="showPopup()">
      <span class="blink-circle">!</span>
    </div>
    <!-- Popup Modal -->
    <div id="popupModal" class="popup-modal" onclick="closePopup(event)">
      <div class="popup-content" onclick="event.stopPropagation()">
        <span class="close-btn" onclick="closePopup(event)"><b>&times;</b></span>
        <p><b>Budget exceeded</b></p>
      </div>
    </div>
  <?php endif; ?>
</div>

              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-calendar-day"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Today's Budget Entries</span>
                <span class="info-box-number text-right">
                  <?php 
                    $today_budget = $conn->query("SELECT sum(amount) as total FROM `running_balance` where category_id in (SELECT id FROM categories where status =1) and date(date_created) = '".(date("Y-m-d"))."' and balance_type = 1 ")->fetch_assoc()['total'];
                     if (is_null($today_budget)) {
        echo "No data found for today's budget.";
    } else {
        echo number_format($today_budget, 2);
    }
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-calendar-day"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Today's Budget Expenses</span>
                <span class="info-box-number text-right">
                <?php 
                    $today_expense = $conn->query("SELECT sum(amount) as total FROM `running_balance` where category_id in (SELECT id FROM categories where status =1) and date(date_created) = '".(date("Y-m-d"))."' and balance_type = 2 ")->fetch_assoc()['total'];
                    if (is_null($today_expense)) {
        echo "No data found for today's expenses.";
    } else {
        echo number_format($today_expense ?? 0, 2);
    }
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
<div class="row">
  <div class="col-lg-12">
    <h4>Current Budget in each Categories</h4>
    <hr>
  </div>
</div>
<div class="col-md-12 d-flex justify-content-center">
  <div class="input-group mb-3 col-md-5">
    <input type="text" class="form-control" id="search" placeholder="Search Category">
    <div class="input-group-append">
      <span class="input-group-text"><i class="fa fa-search"></i></span>
    </div>
  </div>
</div>
<div class="row row-cols-4 row-cols-sm-1 row-cols-md-4 row-cols-lg-4">
  <?php 
  $categories = $conn->query("SELECT * FROM `categories` where status = 1 order by `category` asc ");
    while($row = $categories->fetch_assoc()):
  ?>
  <div class="col p-2 cat-items">
    <div class="callout callout-info">
      <span class="float-right ml-1">
        <button type="button" class="btn btn-secondary info-tooltip" data-toggle="tooltip" data-html="true" title='<?php echo (html_entity_decode($row['description'])) ?>'>
          <span class="fa fa-info-circle text-info"></span>
        </button>
      </span>
      <h5 class="mr-4"><b><?php echo $row['category'] ?></b></h5>
      <div class="d-flex justify-content-end">
        <b><?php echo number_format($row['balance']) ?></b>
      </div>
    </div>
  </div>
  <?php endwhile; ?>
</div>
<div class="col-md-12">
  <h3 class="text-center" id="noData" style="display:none">No Data to display.</h3>
</div>
<script>
  function check_cats(){
    if($('.cat-items:visible').length > 0){
      $('#noData').hide('slow')
    }else{
      $('#noData').show('slow')
    }
  }
  $(function(){
    $('[data-toggle="tooltip"]').tooltip({
      html:true
    })
    check_cats()
    $('#search').on('input',function(){
      var _f = $(this).val().toLowerCase()
      $('.cat-items').each(function(){
        var _c = $(this).text().toLowerCase()
        if(_c.includes(_f) == true)
          $(this).toggle(true);
        else
          $(this).toggle(false);
      })
    check_cats()
    })
  })


// Show popup
  function showPopup() {
    document.getElementById("popupModal").style.display = "flex";
  }

  // Close popup
  function closePopup(event) {
    const popup = document.getElementById("popupModal");
    if (popup) {
      popup.style.display = "none";
    }
  }


</script>
