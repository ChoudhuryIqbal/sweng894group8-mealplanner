<?php
///////////////////////////////////////////////////////////////////////////////
// MealPlanner                             Penn State - Cohorts 19 & 20 @ 2018
///////////////////////////////////////////////////////////////////////////////
// Grocery List
///////////////////////////////////////////////////////////////////////////////
require_once __DIR__.'/../../../vendor/autoload.php';
require_once( $_SERVER['DOCUMENT_ROOT'] . '/../app/views/modules/main.mod.php' );

use Base\Helpers\Session;

// Sub Title
$SUBTITLE = 'GroceryListItem List';


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
                    <div class="col-sm-12 col-md-8">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Grocery List</h3>
                            <p class="text-muted m-b-30">Export data to Copy, CSV, Excel, PDF & Print</p>
                            <div class="table-responsive">
                                <table id="export-table" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Actions</th>
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
                                            if($data['groceryListItems']){
                                                foreach ($data['groceryListItems'] as $groceryListItem) {
                                                  $foodItem = $groceryListItem->getFoodItem();
                                                  if((($groceryListItem->getAmount()/0.75) > $foodItem->getStock()) || !$data['showLow']){
                                                    ?>
                                                    <tr>
                                                        <td><a href="/GroceryListItems/edit/<?php echo $groceryListItem->getId(); ?>"><?php echo $foodItem->getName(); ?></a></td>
                                                        <td><?php echo $groceryListItem->getAmount().' '.$foodItem->getUnit()->getAbbreviation();?></td>
                                                        <td><a href="/GroceryListItems/purchase/<?php echo $groceryListItem->getId()?>"
                                                                class="btn btn-success btn-xs m-t-15" >
                                                                Purchase
                                                            </a>
                                                            <a href="/GroceryListItems/edit/<?php echo $groceryListItem->getId()?>"
                                                                class="btn btn-default btn-xs m-t-15" >
                                                                Edit
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                  }
                                                }
                                            }
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Options</h3>
                            <?php if($data['foodItemCount'] > 0){ ?>
                                <a href="/GroceryListItems/create" class="btn btn-success m-t-15">+ Add item to grocery list</a>
                            <?php }
                            else{
                                echo '<div class="alert alert-warning">Please <a href="/FoodItems/create">create a food item</a> to be able to add it to the grocery list.</div>';
                            }
                            if(!$data['showLow']){ ?>
                                <a href="/GroceryListItems/index/showLow" class="btn btn-success m-t-15">Only show low stock items</a>
                            <?php }
                            else{ ?>
                              <a href="/GroceryListItems/index/" class="btn btn-success m-t-15">Show all grocery items</a>
                              <?php
                            }?>
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
