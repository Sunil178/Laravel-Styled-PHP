<?php ob_start(); ?>
    <div class="w-100"></div>
<?php $customNavbar = ob_get_clean(); ?>

<?php ob_start(); ?>

    <style>
        .extra-deposit-input {
          border-top: 2px solid black;
        }
    </style>

<?php $customStyle = ob_get_clean(); ?>

<?php ob_start(); ?>

     <div class="col-md-10">
          <div class="card mb-4">
               <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"> <?php echo ($target->id ? 'Edit' : 'Create') ?> target</h5>
               </div>
               <div class="card-body">
                    <form method="POST" action="/targets/store" id="form">
                         <input type="hidden" name="target_id" value="<?php echo $target->id ?>">
                         <div class="row">
                              <?php if (checkAuth(true)) { ?>
                                   <div class="mb-3 col-md-4">
                                        <div class="form-group">
                                             <label class="form-label required">Employee</label>
                                             <select name="employee_id" class="form-select select2" required>
                                                  <option value=""> -- select employee -- </option>
                                                  <?php foreach ($employees as $employee) { ?>
                                                       <option <?php echo ($target->employee_id == $employee->id) ? 'selected' : ''; ?> value="<?php echo $employee->id; ?>"><?php echo $employee->name . ' : ' . $employee->username; ?></option>
                                                  <?php } ?>
                                             </select>
                                        </div>
                                   </div>
                              <?php } ?>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label required">Campaign</label>
                                        <select name="campaign_id" class="form-select select2" required>
                                             <option value=""> -- select campaign -- </option>
                                             <?php foreach ($campaigns as $campaign) { ?>
                                                  <option <?php echo ($target->campaign_id == $campaign->id) ? 'selected' : ''; ?> value="<?php echo $campaign->id; ?>"><?php echo $campaign->name; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                              </div>
                         </div>
                         <div class="row">
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Registration State</label>
                                        <select name="reg_state_id" class="form-select">
                                             <option value=""> -- select state -- </option>
                                             <?php foreach ($states as $state) { ?>
                                                  <option <?php echo ($target->reg_state_id == $state->id) ? 'selected' : ''; ?> value="<?php echo $state->id; ?>"><?php echo $state->code . ' : ' . $state->name; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                              </div>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Registration Count</label>
                                        <input type="text" class="form-control" name="reg_count" placeholder="Enter registration count" value="<?php echo $target->reg_count ?>">
                                   </div>
                              </div>
                         </div>
                         <div class="row">
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Deposit State</label>
                                        <select name="dep_state_id" class="form-select">
                                             <option value=""> -- select state -- </option>
                                             <?php foreach ($states as $state) { ?>
                                                  <option <?php echo ($target->dep_state_id == $state->id) ? 'selected' : ''; ?> value="<?php echo $state->id; ?>"><?php echo $state->code . ' : ' . $state->name; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                              </div>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Deposit Count</label>
                                        <input type="text" class="form-control" name="dep_count" placeholder="Enter deposit count" value="<?php echo $target->dep_count ?>">
                                        <?php $total_deposits_count = $target->dep_count ?: 0; ?>
                                   </div>
                              </div>
                         </div>
                         <div class="row mt-5" id="extra-deposits-block">
                              <label class="form-label fs-4 fw-bold">Extra Deposits</label>
                              <?php $extra_deposits_count = is_array($extra_deposits) ? count($extra_deposits) : 0 ; ?>
                              <?php if ($extra_deposits_count > 0) { ?>
                                   <?php foreach ($extra_deposits as $index => $extra_deposit) { ?>
                                        <div class="mb-3 col-md-4 extra-deposit-input">
                                             <div class="form-group">
                                                  <label class="form-label extra-deposit-label">Deposit Count <?php echo ($index + 1) ?></label>
                                                  <input type="text" class="form-control deposit-input" name="extra_deposit_counts[<?php echo $index ?>]" placeholder="Enter deposit <?php echo ($index + 1) ?>" value="<?php echo $extra_deposit->count ?>">

                                                  <label class="form-label day-label">Day <?php echo ($index + 1) ?></label>
                                                  <select name="day_ids[<?php echo $index ?>]" class="form-select select2 day-input">
                                                       <option value=""> -- select day <?php echo ($index + 1) ?> -- </option>
                                                       <?php foreach ($days as $day) { ?>
                                                            <option <?php echo ($extra_deposit->retention_day_id == $day->id) ? 'selected' : ''; ?> value="<?php echo $day->id; ?>"><?php echo $day->name; ?></option>
                                                       <?php } ?>
                                                  </select>

                                                  <input type="hidden" name="extra_deposit_ids[<?php echo $index ?>]" value="<?php echo $extra_deposit->id ?>">
                                                  <?php $total_deposits_count += $extra_deposit->count; ?>
                                             </div>
                                        </div>
                                   <?php } ?>
                              <?php } else { ?>
                                   <div class="mb-3 col-md-4 extra-deposit-input">
                                        <div class="form-group">
                                             <label class="form-label extra-deposit-label">Deposit Count 1</label>
                                             <input type="text" class="form-control deposit-input" name="extra_deposit_counts[0]" placeholder="Enter deposit 1">

                                             <label class="form-label day-label">Day 1</label>
                                             <select name="day_ids[0]" class="form-select select2 day-input">
                                                  <option value=""> -- select day 1 -- </option>
                                                  <?php foreach ($days as $day) { ?>
                                                       <option value="<?php echo $day->id; ?>"><?php echo $day->name; ?></option>
                                                  <?php } ?>
                                             </select>

                                             <input type="hidden" name="extra_deposit_ids[0]" value="0">
                                        </div>
                                   </div>
                              <?php } ?>
                         </div>
                         <button type="submit" class="btn btn-primary">Submit</button>
                         <button type="button" id="add-target-deposits" class="btn btn-info">Add Deposit</button>
                         <div class="mt-3" id="target-deposits-count">
                              <b><label>Total Deposit Count: <?php echo $total_deposits_count ?></label></b>
                         </div>
                    </form>
               </div>
          </div>
     </div>

<?php $customSection = ob_get_clean(); ?>

<?php ob_start(); ?>

     <script>
          var extra_deposits_input = `
<div class="mb-3 col-md-4 extra-deposit-input">
     <div class="form-group">
          <label class="form-label extra-deposit-label">Deposit Count 1</label>
          <input type="text" class="form-control deposit-input" name="extra_deposit_counts[0]" placeholder="Enter deposit 1">

          <label class="form-label day-label">Day 1</label>
          <select name="day_ids[0]" class="form-select select2 day-input">
               <option value=""> -- select day 1 -- </option>
               <?php foreach ($days as $day) { ?>
                    <option value="<?php echo $day->id; ?>"><?php echo $day->name; ?></option>
               <?php } ?>
          </select>

          <input type="hidden" name="extra_deposit_ids[0]" value="0">
     </div>
</div>
`;
          $('#add-target-deposits').on('click', function(event) {
               new_extra_deposits_input = $(extra_deposits_input);
               extra_deposits_count = $('.extra-deposit-input').length + 1;

               new_extra_deposits_input.find( '.extra-deposit-label' ).text('Deposit Count ' + extra_deposits_count);
               new_extra_deposits_input.find( '.day-label' ).text('Day ' + extra_deposits_count);

               new_extra_deposits_input.find( '.deposit-input' ).attr('placeholder', 'Enter deposit ' + extra_deposits_count);
               new_extra_deposits_input.find( '.deposit-input' ).attr('name', `extra_deposit_counts[${extra_deposits_count-1}]`);

               new_extra_deposits_input.find( '.day-input option:first' ).text(` -- select day ${extra_deposits_count} -- `);
               new_extra_deposits_input.find( '.day-input' ).attr('name', `day_ids[${extra_deposits_count-1}]`);

               new_extra_deposits_input.find( 'input[type="hidden"]' ).attr('name', `extra_deposit_ids[${extra_deposits_count-1}]`);
               new_extra_deposits_input.find( 'input[type="hidden"]' ).val(0);
               $('#extra-deposits-block').append(new_extra_deposits_input);
               updateSelect2();
          });

     </script>

<?php
     $customScript = ob_get_clean();
     include_once __DIR__."/../../layout/index.php";
?>
