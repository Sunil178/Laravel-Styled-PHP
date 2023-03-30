<?php ob_start(); ?>
    <div class="w-100"></div>
<?php $customNavbar = ob_get_clean(); ?>

<?php ob_start(); ?>
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
                         </div>
                         <div class="row mt-4">
                              <label class="form-label required">Any one emulator or name is required</label>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Emulator</label>
                                        <select name="lead_id" class="form-select select2">
                                             <option value=""> -- select lead emulator -- </option>
                                             <?php foreach ($leads as $lead) { ?>
                                                  <option <?php echo ($gameplay->lead_id == $lead->id) ? 'selected' : ''; ?> value="<?php echo $lead->id; ?>"><?php echo $lead->emulator; ?></option>
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
                         </div>
                         <div class="row" id="rake-block">
                              <?php $total_rake = 0; ?>
                              <?php $rake_count = is_array($gameplay_rakes) ? count($gameplay_rakes) : 0 ; ?>
                              <?php if ($rake_count > 0) { ?>
                                   <?php foreach ($gameplay_rakes as $index => $gameplay_rake) { ?>
                                        <div class="mb-3 col-md-2 rake-input">
                                             <div class="form-group">
                                                  <label class="form-label">Rake <?php echo ($index + 1) ?></label>
                                                  <input type="number" step="any" class="form-control" name="rakes[<?php echo $index ?>]" placeholder="Enter rake <?php echo ($index + 1) ?>" value="<?php echo $gameplay_rake->rake ?>">
                                                  <input type="hidden" name="rake_ids[<?php echo $index ?>]" value="<?php echo $gameplay_rake->id ?>">
                                             </div>
                                        </div>
                                        <?php $total_rake += $gameplay_rake->rake; ?>
                                   <?php } ?>
                              <?php } else { ?>
                                   <div class="mb-3 col-md-2 rake-input">
                                        <div class="form-group">
                                             <label class="form-label">Rake 1</label>
                                             <input type="number" step="any" class="form-control" name="rakes[0]" placeholder="Enter rake 1">
                                             <input type="hidden" name="rake_ids[0]" value="0">
                                        </div>
                                   </div>
                              <?php } ?>
                         </div>
                         <button type="submit" class="btn btn-primary">Submit</button>
                         <button type="button" id="add-rake" class="btn btn-info">Add Rake</button>
                         <br>
                         <br>
                         <b><label>Rake Count: <?php echo $rake_count ?></label></b>
                         <b><label>Total Rake: <?php echo $total_rake ?></label></b>
                    </form>
               </div>
          </div>
     </div>
<?php $customSection = ob_get_clean(); ?>

<?php ob_start(); ?>

     <script>
          var rake_input = `
<div class="mb-3 col-md-2 rake-input">
     <div class="form-group">
          <label class="form-label">Rake 1</label>
          <input type="number" step="any" class="form-control" name="rakes[0]" placeholder="Enter rake 1">
          <input type="hidden" name="rake_ids[0]" value="0">
     </div>
</div>
`;
          $('#add-rake').on('click', function(event) {
               new_rake_input = $(rake_input);
               rake_count = $('.rake-input').length + 1;
               new_rake_input.find( 'label' ).text('Rake ' + rake_count);
               new_rake_input.find( 'input[type="number"]' ).attr('placeholder', 'Enter rake ' + rake_count);
               new_rake_input.find( 'input[type="number"]' ).attr('name', `rakes[${rake_count-1}]`);
               new_rake_input.find( 'input[type="hidden"]' ).attr('name', `rake_ids[${rake_count-1}]`);
               new_rake_input.find( 'input[type="hidden"]' ).val(0);
               $('#rake-block').append(new_rake_input);
          });
     </script>

<?php
     $customScript = ob_get_clean();
     include_once __DIR__."/../../layout/index.php";
?>


