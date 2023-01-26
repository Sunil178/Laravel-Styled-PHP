<?php ob_start(); ?>

<?php
     include_once __DIR__."/../../database/model.php";
     $model = new Model('employees');
     $employees = $model->getAll();
?>

     <div class="col-md-10">
          <div class="card mb-4">
               <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"> <?php echo ($gameplay->id ? 'Edit' : 'Create') ?> Gameplay</h5>
               </div>
               <div class="card-body">
                    <form method="POST" action="/gameplays/store" id="form">
                         <input type="hidden" name="gameplay_id" value="<?php echo $gameplay->id ?>">
                         <div class="row">
                              <?php if (checkAuth(true)) { ?>
                                   <div class="mb-3 col-md-4">
                                        <div class="form-group">
                                             <label class="form-label required">Employee</label>
                                             <select name="employee_id" class="form-select" required>
                                                  <option value=""> -- select employee -- </option>
                                                  <?php foreach ($employees as $employee) { ?>
                                                       <option <?php echo ($gameplay->employee_id == $employee->id) ? 'selected' : ''; ?> value="<?php echo $employee->id; ?>"><?php echo $employee->name . ' : ' . $employee->username; ?></option>
                                                  <?php } ?>
                                             </select>
                                        </div>
                                   </div>
                              <?php } ?>
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
                         <div class="row" id="rake-block">
                              <div class="mb-3 col-md-2 rake-input">
                                   <div class="form-group">
                                        <label class="form-label">Rake 1</label>
                                        <input type="number" step="any" class="form-control" name="rakes[0]" placeholder="Enter rake 1">
                                        <input type="hidden" name="rake_ids[0]" value="0">
                                   </div>
                              </div>
                         </div>
                         <button type="submit" class="btn btn-primary">Submit</button>
                         <button type="button" id="add-rake" class="btn btn-info">Add Rake</button>
                    </form>
               </div>
          </div>
     </div>
<?php $customSection = ob_get_clean(); ?>

<?php ob_start(); ?>

     <script>
          var rake_input = $('#rake-block').first().html();
          $('#add-rake').on('click', function(event) {
               new_rake_input = $(rake_input);
               rake_count = $('.rake-input').length + 1;
               new_rake_input.find( 'label' ).text('Rake ' + rake_count);
               new_rake_input.find( 'input[type="number"]' ).attr('placeholder', 'Enter rake ' + rake_count);
               new_rake_input.find( 'input[type="number"]' ).attr('name', `rakes[${rake_count-1}]`);
               new_rake_input.find( 'input[type="hidden"]' ).attr('name', `rake_ids[${rake_count-1}]`);
               $('#rake-block').append(new_rake_input);
          });
     </script>

<?php $customScript = ob_get_clean(); ?>

<?php include_once __DIR__."/../../layout/index.php"; ?>

