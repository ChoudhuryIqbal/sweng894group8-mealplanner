<?php
///////////////////////////////////////////////////////////////////////////////
// MealPlanner                             Penn State - Cohorts 19 & 20 @ 2018
///////////////////////////////////////////////////////////////////////////////
// Meals (listing)
///////////////////////////////////////////////////////////////////////////////
require_once __DIR__.'/../../../vendor/autoload.php';
require_once( $_SERVER['DOCUMENT_ROOT'] . '/../app/views/modules/main.mod.php' );

use Base\Helpers\Session;

// Sub Title
$SUBTITLE = 'Meal Plan';


// Plugins
$PLUGIN_SLIMSCROLL  = TRUE;
$PLUGIN_WAVES       = TRUE;
$PLUGIN_DATATABLES  = TRUE;
$PLUGIN_SIDEBARMENU = TRUE;
$PLUGIN_EXPORT      = TRUE;
?>
<?php require_once( __HEADER__ ); ?>

<body class="mini-sidebar">

  <div class="modal fade" id="confirm-complete-meal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Confirm Meal Completion</h4>
              </div>
              <div class="modal-body">
                  <p>Are you sure you want to complete this meal? Doing so will <strong>update your food stock quantities</strong>. This cannot be undone.</p>
              </div>
              <div class="modal-footer">
                  <form class="" action="/Meals/complete/<?php echo $data['meal']->getId();?>" method="post">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-danger">Complete</button>
                  </form>
              </div>
          </div>
      </div>
  </div>

    <!-- ===== Main-Wrapper ===== -->
    <div id="wrapper">
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>

<?php require_once( __NAVBAR__ ); ?>

<?php require_once( __SIDEBAR__ ); ?>

        <!-- ===== Page-Content ===== -->
        <div class="page-wrapper">

            <!-- ===== Page-Container ===== -->
            <div class="container-fluid">

                <?php $data['session']->renderMessage(); ?>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Meal Plan</h3>
                            <p class="text-muted m-b-30">Export data to Copy, CSV, Excel, PDF & Print</p>
                            <div class="table-responsive">
                                <table id="export-table" class="table table-striped" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Recipe</th>
                                            <th>Date</th>
                                            <th>Scale</th>
                                            <th>Date Added</th>
                                            <th>Complete</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="column-search">
                                            <th><input class="column-search-bar form-control" type="text" placeholder="Search"/></th>
                                            <th><input class="column-search-bar form-control" type="text" placeholder="Search"/></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                            if($data['meals']){
                                                foreach ($data['meals'] as $meal) { ?>
                                                <tr>
                                                    <td><a href="/Meals/edit/<?php echo $meal->getId(); ?>"><?php echo $meal->getRecipe()->getName(); ?></a></td>
                                                    <td><?php echo $meal->getDate(true); ?></td>
                                                    <td><?php echo $meal->getScaleFactor(); ?></td>
                                                    <td><?php echo $meal->getAddedDate(true); ?></td>
                                                    <td>
                                                            <button
                                                                type="button"
                                                                class="btn btn-danger m-t-15"
                                                                data-toggle="modal"
                                                                data-target="#confirm-complete-meal">
                                                                Complete
                                                            </button>
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                            }
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Actions</h3>
                            <a href="/Meals/create/" class="btn btn-success m-t-15">+ Create Meal</a>
                        </div>
                    </div>
                </div>


<?php require_once( __SPANEL__ ); ?>

            </div>
            <!-- ===== Page-Container-End ===== -->

            <footer class="footer t-a-c">
                <?php echo __COPYRITE__; ?>
            </footer>
        </div>
        <!-- ===== Page-Content-End ===== -->

    </div>
    <!-- ===== Main-Wrapper-End ===== -->

<?php require_once( __FOOTER__ ); ?>

</body>
</html>
