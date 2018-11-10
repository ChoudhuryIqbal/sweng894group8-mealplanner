<?php
///////////////////////////////////////////////////////////////////////////////
// MealPlanner                             Penn State - Cohorts 19 & 20 @ 2018
///////////////////////////////////////////////////////////////////////////////
// Food (listing)
///////////////////////////////////////////////////////////////////////////////
require_once __DIR__.'/../../../vendor/autoload.php';
require_once( $_SERVER['DOCUMENT_ROOT'] . '/../app/views/modules/main.mod.php' );

use Base\Helpers\Session;

// Sub Title
$SUBTITLE = 'Household';


// Plugins
$PLUGIN_SLIMSCROLL  = TRUE;
$PLUGIN_WAVES       = TRUE;
$PLUGIN_DATATABLES  = TRUE;
$PLUGIN_SIDEBARMENU = TRUE;
$PLUGIN_EXPORT      = TRUE;

// echo "<pre>".print_r($data)."</pre>";

?>
<?php require_once( __HEADER__ ); ?>

<body class="mini-sidebar">
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
                    <div class="col-sm-4">
                        <div class="white-box">
                          <h3 class="box-title m-b-0">Household</h3>
                          <div class="table-responsive">
                                <table class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Invite Code</th>
                                            <th style="text-align:center;">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if($data['households']){
                                                foreach ($data['households'] as $hh) { ?>
                                                <tr>
                                                    <td><a href="/Household/detail/<?php echo $hh['id']; ?>"><?php echo $hh['name']; ?></a></td>
                                                    <td><?php echo $hh['code']; ?></td>
                                                    <td style="text-align:center;">
                                                      <input type="radio"
                                                             name="selectedHH"
                                                             value="<?php echo $hh['id']; ?>"
                                                             <?php if($data['currHH']->getId() == $hh['id']) echo 'checked ="checked"';  ?>
                                                             onchange="window.location.href='/Household/select/<?php echo $hh['id']; ?>'"
                                                      />
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                            }
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <br>
                            <a href="/Household/index">+ Add Household</a>
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
