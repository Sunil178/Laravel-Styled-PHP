<?php ob_start(); ?>

<?php
     include_once __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."database".DIRECTORY_SEPARATOR."model.php";
     $model = new Model('employees');
     $employees = $model->getAll();
?>

     <div class="col-md-10">
          <div class="card mb-4">
               <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"> <?php echo ($gameplay->id ? 'Edit' : 'Create') ?> Gameplay</h5>
               </div>
               <div class="card-body">
                    <form method="POST" action="../controller/gameplay.php" id="form">
                         <input type="hidden" name="gameplay_id" value="<?php echo $gameplay->id ?>">
                         <div class="row">
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label required">Employee</label>
                                        <select name="employee_id" class="form-select" required>
                                             <option value=""> -- select board -- </option>
                                             <?php foreach ($employees as $employee) { ?>
                                                  <option <?php echo ($gameplay->employee_id == $employee->id) ? 'selected' : ''; ?> value="<?php echo $employee->id; ?>"><?php echo $employee->name . ' : ' . $employee->username ; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                              </div>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Emulator Name</label>
                                        <input type="text" class="form-control" name="emulator_name" placeholder="Enter emulator name" value="<?php echo $gameplay->emulator_name ?>">
                                   </div>
                              </div>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Date</label>
                                        <input type="date" class="form-control" name="date" placeholder="Enter date" value="<?php echo $gameplay->date ?>">
                                   </div>
                              </div>
                         </div>
                         <div class="row">
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Rake</label>
                                        <input type="number" step="any" class="form-control" name="rake" placeholder="Enter rake" value="<?php echo $gameplay->rake ?>">
                                   </div>
                              </div>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Count</label>
                                        <input type="number" step="any" class="form-control" name="count" placeholder="Enter count" value="<?php echo $gameplay->count ?>">
                                   </div>
                              </div>
                         </div>
                         <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
               </div>
          </div>
     </div>
<?php
    $customSection = ob_get_clean();
    include_once __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."layout".DIRECTORY_SEPARATOR."index.php";
?>
