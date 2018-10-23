<?php
///////////////////////////////////////////////////////////////////////////////
// MealPlanner                             Penn State - Cohorts 19 & 20 @ 2018
///////////////////////////////////////////////////////////////////////////////
// View/Edit Food
///////////////////////////////////////////////////////////////////////////////
require_once __DIR__.'/../../../vendor/autoload.php';
require_once( $_SERVER['DOCUMENT_ROOT'] . '/../app/views/modules/main.mod.php' );

use Base\Helpers\Session;

// Plugins
$PLUGIN_SLIMSCROLL  = TRUE;
$PLUGIN_WAVES       = TRUE;
$PLUGIN_SIDEBARMENU = TRUE;


// Sub Title
$SUBTITLE = "Edit Recipe {$data['recipe']->getName()}";

?>
<?php require_once( __HEADER__ ); ?>

<body class="mini-sidebar">
    <!-- Confirm deletion modal -->
    <div class="modal fade" id="confirm-delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Recipe Deletion</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this recipe? Doing so will <strong>remove it from all of your meal plans</strong>. This cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <form class="" action="/Recipes/delete/<?php echo $data['recipe']->getId();?>" method="post">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
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
                <?php (new Session())->renderMessage(); ?>

                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0"><?php echo $data['recipe']->getName(); ?></h3>
<?php if (isset($Errors)) { ?>
                            <p class="text-danger m-b-30 font-13">
<?php     foreach($Errors as $error) { ?>
                            <?php echo $error; ?><br/>
<?php     } ?>
                            </p>
<?php } ?>

                            <p class="text-muted m-b-30 font-13"> <?php echo $SUBTITLE; ?>
                            <a href="/REcipes/">&laquo; Return to recipe</a>
                            </p>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <form method="post" action="/Recipes/update/<?php echo $data['recipe']->getId(); ?>">
                                        <input type="hidden" name="recipeid" value="<?php echo $data['recipe']->getId(); ?>">
                                        <div class="form-group">
                                            <label for="inputName">Name</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-font"></i></div>
                                                <input type="text" class="form-control" id="inputName" placeholder="Name of Recipe" name="name" value="<?php echo $data['recipe']->getName(); ?>"> </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputName">Description</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-font"></i></div>
                                                <input type="text" class="form-control" id="inputDescription" placeholder="Description" name="description" value="<?php echo $data['recipe']->getDescription(); ?>"> </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputUnitsInContainer">Servings</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-font"></i></div>
                                                <input type="number" step="0.01" min="1" class="form-control" id="inputServings" placeholder="1" name="servings" value="<?php echo $data['recipe']->getServings(); ?>">
                                            </div>
                                            <p class="help-block"></p>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputSource">Source</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-font"></i></div>
                                                <input type="text" class="form-control" id="inputSource" placeholder="" name="source" value="<?php echo (new Session())->getOldInput('source'); ?>">
                                            </div>
                                            <p class="help-block"></p>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputName">Notes</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-font"></i></div>
                                                <input type="text" class="form-control" id="inputNotes" placeholder="Notes" name="notes" value="<?php echo $data['recipe']->getNotes(); ?>"> </div>
                                        </div>

                                        <hr>
                                            <label for="ingredientsWrapper">Ingredients</label>
                                            <div id="ingredientsWrapper">

                                            <div class="form-group ingredientFormGroup">


                                          <!--  for(i=0;i<$data['ingredients'].length;i++)
                                            {-->
                                              <div class="col-sm-3">
                                                        <input class="form-control" type="number" step="0.05" min="0" placeholder="" name="quantity[]" value="<?php echo $data['ingredients'][0]->getQuantity()->getValue(); ?>">
                                              </div>

                                              <div class="col-sm-4">
                                                    <select class="form-control" name="unit_id[]">
                                                        <option value="0"><?php echo $data['ingredients'][0]->getUnit()->getName();?></option>
                                                        <?php
                                                            foreach($data['units'] as $unit){
                                                                echo '<option ';

                                                                if((new Session())->getOldInput('unit_id') == $unit['id']){
                                                                    echo 'selected="selected" ';
                                                                }

                                                                echo 'value="'.$unit['id'].'">'.$unit['name'].' � '.$unit['abbreviation'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                              </div>

                                              <div class="col-sm-4">
                                                <select class="form-control" name="foodid[]">
                                                    <option value="0"><?php echo $data['ingredients'][0]->getFood()->getName();?></option>
                                                    <?php
                                                        foreach($data['fooditems'] as $fooditem){
                                                            echo '<option ';

                                                            if((new Session())->getOldInput('foodid') == $fooditem->getId()){
                                                                echo 'selected="selected" ';
                                                            }

                                                            echo 'value="'.$fooditem->getId().'">'.$fooditem->getName().'</option>';
                                                        }
                                                    ?>
                                                </select>
                                              </div> <!-- div class col-xs-5 -->

                                              <div class="col-sm-1">
                                                <button class="btn-sm btn-danger btn removeIngredientBtn"><i class="fa fa-times"></i>
                                                </button>
                                              </div>

                                          <!--  }-->

                                            </div> <!-- end ingredientFormGroup -->
                                          </div> <!-- end ingredientsWrapper -->

                                          <br><br><br>
                                          <button id="addIngredientBtn" class="btn btn-success pull-right">Add Ingredient</button>

                                          <br><br>
                                          <hr>
                                          <br><br>

                                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Options</h3>

                            <!-- Button trigger modal -->
                            <button
                                type="button"
                                class="btn btn-danger m-t-15"
                                data-toggle="modal"
                                data-target="#confirm-delete-modal">
                                Remove Recipe                            </button>
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

<script>
  $(document).ready(function() {
      let ingredientHTML =
      `<div class="form-group ingredientFormGroup">

        <div class="col-sm-3">
                  <input class="form-control" type="number" step="0.05" min="0" placeholder="" name="quantity[]" value="<?php echo (new Session())->getOldInput('quantity'); ?>">
        </div>

        <div class="col-sm-4">
              <select class="form-control" name="unit_id[]">
                  <option value="0">Select a unit</option>
                  <?php
                      foreach($data['units'] as $unit){
                          echo '<option ';

                          if((new Session())->getOldInput('unit_id') == $unit['id']){
                              echo 'selected="selected" ';
                          }

                          echo 'value="'.$unit['id'].'">'.$unit['name'].' � '.$unit['abbreviation'].'</option>';
                      }
                  ?>
              </select>
        </div>

        <div class="col-sm-4">
          <select class="form-control" name="foodid[]">
              <option value="0">Select a food item</option>
              <?php
                  foreach($data['fooditems'] as $fooditem){
                      echo '<option ';

                      if((new Session())->getOldInput('foodid') == $fooditem->getId()){
                          echo 'selected="selected" ';
                      }

                      echo 'value="'.$fooditem->getId().'">'.$fooditem->getName().'</option>';
                  }
              ?>
          </select>
        </div>

        <div class="col-sm-1">
          <button class="btn-sm btn-danger btn removeIngredientBtn"><i class="fa fa-times"></i>
          </button>
        </div>

    </div>`; //end ingredientFormGroup -->
      /*
                `<div class="form-group ingredientFormGroup">
                    <div class="col-xs-3">
                       <input class="form-control" type="number" step="0.01" min="0.01">
                    </div>
                    <div class="col-xs-3">
                       <select class="form-control" name="ingredientUnits[]" id="">
                          <option value="1">Unit 1</option>
                          <option value="2">Unit 2</option>
                          <option value="1">Unit 3</option>
                        </select>
                    </div>
                    <div class="col-xs-5">
                       <select class="form-control" name="ingredientNames[]" id="">
                          <option value="1">Food item 1</option>
                          <option value="2">Food item 2</option>
                          <option value="1">Food item 3</option>
                       </select>
                    </div>
                     <div class="col-xs-1">
                         <buttton class="btn-sm btn-danger btn removeIngredientBtn">
                             <span class="glyphicon glyphicon-remove"></span>
                         </buttton>

                     </div>
                 </div>`;
                 */
      $("#addIngredientBtn").on("click", function(e) {
          e.preventDefault();
          $('#ingredientsWrapper').append(ingredientHTML);
      });

      $(document).on("click", ".removeIngredientBtn", function(e) {
          e.preventDefault();
          $(this).closest(".ingredientFormGroup").remove();
      });
  });

</script>


</body>
</html>
