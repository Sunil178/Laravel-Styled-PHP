<?php ob_start(); ?>

<?php
     include_once __DIR__."/../../database/model.php";
     $model = new Model('employees');
     $employees = $model->getAll();
     $model = new Model('campaigns');
     $campaigns = $model->getAll();
     $model = new Model('states');
     $states = $model->getAll();
?>

     <div class="col-md-10">
          <div class="card mb-4">
               <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"> <?php echo ($lead->id ? 'Edit' : 'Create') ?> Lead</h5>
               </div>
               <div class="card-body">
                    <form method="POST" action="/leads/store" id="form">
                         <input type="hidden" name="lead_id" value="<?php echo $lead->id ?>">
                         <div class="row">
                              <?php if (checkAuth(true)) { ?>
                                   <div class="mb-3 col-md-4">
                                        <div class="form-group">
                                             <label class="form-label required">Employee</label>
                                             <select name="employee_id" class="form-select" required>
                                                  <option value=""> -- select employee -- </option>
                                                  <?php foreach ($employees as $employee) { ?>
                                                       <option <?php echo ($lead->employee_id == $employee->id) ? 'selected' : ''; ?> value="<?php echo $employee->id; ?>"><?php echo $employee->name . ' : ' . $employee->username; ?></option>
                                                  <?php } ?>
                                             </select>
                                        </div>
                                   </div>
                              <?php } ?>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label required">Campaign</label>
                                        <select name="campaign_id" class="form-select" required>
                                             <option value=""> -- select campaign -- </option>
                                             <?php foreach ($campaigns as $campaign) { ?>
                                                  <option <?php echo ($lead->campaign_id == $campaign->id) ? 'selected' : ''; ?> value="<?php echo $campaign->id; ?>"><?php echo $campaign->name; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                              </div>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label required">Type</label>
                                        <select name="type" class="form-select" required>
                                             <option value=""> -- select type -- </option>
                                             <option <?php echo (((string)$lead->type) == 0) ? 'selected' : ''; ?> value="0">Registration</option>
                                             <option <?php echo (((string)$lead->type) == 1) ? 'selected' : ''; ?> value="1">Deposit</option>
                                        </select>
                                   </div>
                              </div>
                         </div>
                         <div class="row">
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label required">State</label>
                                        <select name="state_id" class="form-select" required>
                                             <option value=""> -- select state -- </option>
                                             <?php foreach ($states as $state) { ?>
                                                  <option <?php echo ($lead->state_id == $state->id) ? 'selected' : ''; ?> value="<?php echo $state->id; ?>"><?php echo $state->code . ' : ' . $state->name; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                              </div>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Date</label>
                                        <input type="date" class="form-control" name="date" placeholder="Enter date" value="<?php echo $lead->date ?>">
                                   </div>
                              </div>
                         </div>
                         <div class="row" id="emulator-block">
                              <div class="mb-3 col-md-4 emulator-count-input">
                                   <div class="form-group">
                                        <label class="form-label">Count</label>
                                        <input type="number" class="form-control" name="count" placeholder="Enter count" value="<?php echo $lead->count ?>">
                                   </div>
                              </div>
                              <?php $emulator_count = is_array($lead_emulators) ? count($lead_emulators) : 0 ; ?>
                              <?php if ($emulator_count > 0) { ?>
                                   <?php foreach ($lead_emulators as $index => $emulator) { ?>
                                        <div class="mb-3 col-md-2 emulator-input">
                                             <div class="form-group">
                                                  <label class="form-label">Emulator <?php echo ($index + 1) ?></label>
                                                  <input type="text" class="form-control" name="emulators[<?php echo $index ?>]" placeholder="Enter emulator <?php echo ($index + 1) ?>" value="<?php echo $emulator->name ?>">
                                                  <input type="hidden" name="emulator_ids[<?php echo $index ?>]" value="<?php echo $emulator->id ?>">
                                             </div>
                                        </div>
                                   <?php } ?>
                              <?php } else { ?>
                                   <div class="mb-3 col-md-2 emulator-input">
                                        <div class="form-group">
                                             <label class="form-label">Emulator 1</label>
                                             <input type="text" class="form-control" name="emulators[0]" placeholder="Enter emulator 1">
                                             <input type="hidden" name="emulator_ids[0]" value="0">
                                        </div>
                                   </div>
                              <?php } ?>
                         </div>
                         <button type="submit" class="btn btn-primary">Submit</button>
                         <button type="button" id="add-emulator" class="btn btn-info">Add Emulator</button>
                         <div class="mt-3" id="emulator-name-count">
                              <b><label>Emulator Count: <?php echo $emulator_count ?></label></b>
                         </div>
                    </form>
               </div>
          </div>
     </div>

<?php $customSection = ob_get_clean(); ?>

<?php ob_start(); ?>

     <script>
          var emulator_input = `
<div class="mb-3 col-md-2 emulator-input">
     <div class="form-group">
          <label class="form-label">Emulator 1</label>
          <input type="text" class="form-control" name="emulators[0]" placeholder="Enter emulator 1">
          <input type="hidden" name="emulator_ids[0]" value="0">
     </div>
</div>
`;
          $('#add-emulator').on('click', function(event) {
               new_emulator_input = $(emulator_input);
               emulator_count = $('.emulator-input').length + 1;
               new_emulator_input.find( 'label' ).text('Emulator ' + emulator_count);
               new_emulator_input.find( 'input[type="text"]' ).attr('placeholder', 'Enter emulator ' + emulator_count);
               new_emulator_input.find( 'input[type="text"]' ).attr('name', `emulators[${emulator_count-1}]`);
               new_emulator_input.find( 'input[type="hidden"]' ).attr('name', `emulator_ids[${emulator_count-1}]`);
               new_emulator_input.find( 'input[type="hidden"]' ).val(0);
               $('#emulator-block').append(new_emulator_input);
          });

          <?php if ($lead->type == 1) {?>
               $('.emulator-count-input').hide();
               $('.emulator-input').show();
               $('#add-emulator').show();
               $('#emulator-name-count').show();
          <?php } else if ($lead->type === 0) { ?>
               $('#add-emulator').hide();
               $('.emulator-input').hide();
               $('#emulator-name-count').hide();
               $('.emulator-count-input').show();
          <?php } else { ?>
               $('#add-emulator').hide();
               $('.emulator-input').hide();
               $('.emulator-count-input').hide();
               $('#emulator-name-count').hide();
          <?php } ?>

          $('select[name="type"]').on('change', function (event) {
               value = $(this).val();
               if (value == 1) {
                    $('.emulator-count-input').hide();
                    $('.emulator-input').show();
                    $('#add-emulator').show();
                    $('#emulator-name-count').show();
               }
               else if (value === '0') {
                    $('#add-emulator').hide();
                    $('.emulator-input').hide();
                    $('#emulator-name-count').hide();
                    $('.emulator-count-input').show();
               }
               else {
                    $('#add-emulator').hide();
                    $('.emulator-input').hide();
                    $('.emulator-count-input').hide();
                    $('#emulator-name-count').hide();
               }
          });
     </script>

<?php
     $customScript = ob_get_clean();
     include_once __DIR__."/../../layout/index.php";
?>
