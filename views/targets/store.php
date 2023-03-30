<?php ob_start(); ?>
    <div class="w-100"></div>
<?php $customNavbar = ob_get_clean(); ?>

<?php ob_start(); ?>

    <style>
        .target-deposit-input {
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
                                             <select name="employee_id" class="form-select" required>
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
                                        <select name="campaign_id" class="form-select" required>
                                             <option value=""> -- select campaign -- </option>
                                             <?php foreach ($campaigns as $campaign) { ?>
                                                  <option <?php echo ($target->campaign_id == $campaign->id) ? 'selected' : ''; ?> value="<?php echo $campaign->id; ?>"><?php echo $campaign->name; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                              </div>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label required">Type</label>
                                        <select name="type" class="form-select" required>
                                             <option value=""> -- select type -- </option>
                                             <option <?php echo (((string)$target->type) == 0) ? 'selected' : ''; ?> value="0">Registration</option>
                                             <option <?php echo (((string)$target->type) == 1) ? 'selected' : ''; ?> value="1">Deposit</option>
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
                                                  <option <?php echo ($target->state_id == $state->id) ? 'selected' : ''; ?> value="<?php echo $state->id; ?>"><?php echo $state->code . ' : ' . $state->name; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                              </div>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label required">Emulator Name</label>
                                        <input type="text" class="form-control" name="emulator_name" placeholder="Enter emulator name" value="<?php echo $target->emulator ?>" required>
                                   </div>
                              </div>
                         </div>
                         <div class="row mt-5" id="target-deposits-block">
                              <?php $deposits_count = is_array($target_deposits) ? count($target_deposits) : 0 ; ?>
                              <?php if ($deposits_count > 0) { ?>
                                   <?php foreach ($target_deposits as $index => $target_deposit) { ?>
                                        <div class="mb-3 col-md-4 target-deposit-input">
                                             <div class="form-group">
                                                  <label class="form-label deposit-label">Deposit <?php echo ($index + 1) ?></label>
                                                  <input type="text" class="form-control deposit-input" name="target_deposit_amounts[<?php echo $index ?>]" placeholder="Enter deposit <?php echo ($index + 1) ?>" value="<?php echo $target_deposit->amount ?>">

                                                  <label class="form-label payment-method-label">Payment Method <?php echo ($index + 1) ?></label>
                                                  <select name="payment_method_ids[<?php echo $index ?>]" class="form-select select2 payment-method-input">
                                                       <option value=""> -- select payment method <?php echo ($index + 1) ?> -- </option>
                                                       <?php foreach ($payment_methods as $payment_method) { ?>
                                                            <option <?php echo ($target_deposit->payment_method_id == $payment_method->id) ? 'selected' : ''; ?> value="<?php echo $payment_method->id; ?>"><?php echo $payment_method->type . ' : ' . $payment_method->name . ' : ' . $payment_method->identity; ?></option>
                                                       <?php } ?>
                                                  </select>

                                                  <input type="hidden" name="target_deposit_ids[<?php echo $index ?>]" value="<?php echo $target_deposit->id ?>">
                                             </div>
                                        </div>
                                   <?php } ?>
                              <?php } else { ?>
                                   <div class="mb-3 col-md-4 target-deposit-input">
                                        <div class="form-group">
                                             <label class="form-label deposit-label">Deposit 1</label>
                                             <input type="text" class="form-control deposit-input" name="target_deposit_amounts[0]" placeholder="Enter deposit 1">

                                             <label class="form-label payment-method-label">Payment Method 1</label>
                                             <select name="payment_method_ids[0]" class="form-select select2 payment-method-input">
                                                  <option value=""> -- select payment method 1 -- </option>
                                                  <?php foreach ($payment_methods as $payment_method) { ?>
                                                       <option value="<?php echo $payment_method->id; ?>"><?php echo $payment_method->type . ' : ' . $payment_method->name . ' : ' . $payment_method->identity; ?></option>
                                                  <?php } ?>
                                             </select>

                                             <input type="hidden" name="target_deposit_ids[0]" value="0">
                                        </div>
                                   </div>
                              <?php } ?>
                         </div>
                         <button type="submit" class="btn btn-primary">Submit</button>
                         <button type="button" id="add-target-deposits" class="btn btn-info">Add Deposit</button>
                         <div class="mt-3" id="target-deposits-count">
                              <b><label>Deposit Count: <?php echo $deposits_count ?></label></b>
                         </div>
                    </form>
               </div>
          </div>
     </div>

<?php $customSection = ob_get_clean(); ?>

<?php ob_start(); ?>

     <script>
          var target_deposits_input = `
<div class="mb-3 col-md-4 target-deposit-input">
     <div class="form-group">
          <label class="form-label deposit-label">Deposit 1</label>
          <input type="text" class="form-control deposit-input" name="target_deposit_amounts[0]" placeholder="Enter deposit 1">

          <label class="form-label payment-method-label">Payment Method 1</label>
          <select name="payment_method_ids[0]" class="form-select select2 payment-method-input">
               <option value=""> -- select payment method 1 -- </option>
               <?php foreach ($payment_methods as $payment_method) { ?>
                    <option value="<?php echo $payment_method->id; ?>"><?php echo $payment_method->type . ' : ' . $payment_method->name . ' : ' . $payment_method->identity; ?></option>
               <?php } ?>
          </select>

          <input type="hidden" name="target_deposit_ids[0]" value="0">
     </div>
</div>
`;
          $('#add-target-deposits').on('click', function(event) {
               new_target_deposits_input = $(target_deposits_input);
               target_deposits_count = $('.target-deposit-input').length + 1;

               new_target_deposits_input.find( '.deposit-label' ).text('Deposit ' + target_deposits_count);
               new_target_deposits_input.find( '.payment-method-label' ).text('Payment Method ' + target_deposits_count);

               new_target_deposits_input.find( '.deposit-input' ).attr('placeholder', 'Enter deposit ' + target_deposits_count);
               new_target_deposits_input.find( '.deposit-input' ).attr('name', `target_deposit_amounts[${target_deposits_count-1}]`);

               new_target_deposits_input.find( '.payment-method-input option:first' ).text(` -- select payment method ${target_deposits_count} -- `);
               new_target_deposits_input.find( '.payment-method-input' ).attr('name', `payment_method_ids[${target_deposits_count-1}]`);

               new_target_deposits_input.find( 'input[type="hidden"]' ).attr('name', `target_deposit_ids[${target_deposits_count-1}]`);
               new_target_deposits_input.find( 'input[type="hidden"]' ).val(0);
               $('#target-deposits-block').append(new_target_deposits_input);
               updateSelect2();
          });

          <?php if ($target->type == 1) {?>
               $('.target-deposit-input').show();
               $('#add-target-deposits').show();
               $('#target-deposits-count').show();
          <?php } else if ($target->type === 0) { ?>
               $('#add-target-deposits').hide();
               $('.target-deposit-input').hide();
               $('#target-deposits-count').hide();
          <?php } else { ?>
               $('#add-target-deposits').hide();
               $('.target-deposit-input').hide();
               $('#target-deposits-count').hide();
          <?php } ?>

          $('select[name="type"]').on('change', function (event) {
               value = $(this).val();
               if (value == 1) {
                    $('.target-deposit-input').show();
                    $('#add-target-deposits').show();
                    $('#target-deposits-count').show();
               }
               else if (value === '0') {
                    $('#add-target-deposits').hide();
                    $('.target-deposit-input').hide();
                    $('#target-deposits-count').hide();
               }
               else {
                    $('#add-target-deposits').hide();
                    $('.target-deposit-input').hide();
                    $('#target-deposits-count').hide();
               }
          });
     </script>

<?php
     $customScript = ob_get_clean();
     include_once __DIR__."/../../layout/index.php";
?>
