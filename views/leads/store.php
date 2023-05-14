<?php ob_start(); ?>
    <div class="w-100"></div>
<?php $customNavbar = ob_get_clean(); ?>

<?php ob_start(); ?>

    <style>
        .lead-deposit-input {
          border-top: 2px solid black;
        }
    </style>

<?php $customStyle = ob_get_clean(); ?>

<?php ob_start(); ?>

     <div class="col-md-10">
          <div class="card mb-4">
               <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"> <?php echo (@$lead->id ? 'Edit' : 'Create') ?> Lead</h5>
               </div>
               <div class="card-body">
                    <form method="POST" action="/leads/store" id="form">
                         <input type="hidden" name="lead_id" value="<?php echo @$lead->id ?>">
                         <div class="row">
                              <?php if (checkAuth(true)) { ?>
                                   <div class="mb-3 col-md-4">
                                        <div class="form-group">
                                             <label class="form-label required">Employee</label>
                                             <select name="employee_id" class="form-select" required>
                                                  <option value=""> -- select employee -- </option>
                                                  <?php foreach ($employees as $employee) { ?>
                                                       <option <?php echo (@$lead->employee_id == $employee->id) ? 'selected' : ''; ?> value="<?php echo $employee->id; ?>"><?php echo $employee->name . ' : ' . $employee->username; ?></option>
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
                                                  <option <?php echo (@$lead->campaign_id == $campaign->id) ? 'selected' : ''; ?> value="<?php echo $campaign->id; ?>"><?php echo $campaign->name; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                              </div>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label required">Type</label>
                                        <select name="type" class="form-select" required>
                                             <option value="" disabled selected hidden> -- select type -- </option>
                                             <option <?php echo (((string)@$lead->type) == 0) ? 'selected' : ''; ?> value="0">Registration</option>
                                             <option <?php echo (((string)@$lead->type) == 1) ? 'selected' : ''; ?> value="1">Deposit</option>
                                             <option <?php echo (((string)@$lead->type) == 2) ? 'selected' : ''; ?> value="2">Retention Deposit</option>
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
                                                  <option <?php echo (@$lead->state_id == $state->id) ? 'selected' : ''; ?> value="<?php echo $state->id; ?>"><?php echo $state->code . ' : ' . $state->name; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                              </div>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label required">Emulator Name</label>
                                        <input id="emulator_name_text" type="text" class="form-control" name="emulator_name" placeholder="Enter emulator name" value="<?php echo @$lead->emulator ?>" required>
                                        <textarea id="emulator_name_textarea" class="form-control" name="emulator_name" placeholder="Enter emulator names" required><?php echo @$lead->emulator ?></textarea>
                                        <select id="emulator_name_select" name="emulator_lead_id" class="form-select" select-options="fetchEmulators">
                                             <option value=""> -- select lead emulator -- </option>
                                             <?php if (isset($lead->id)) { ?>
                                                  <option selected value="<?php echo @$lead->id; ?>"><?php echo @$lead->emulator; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                              </div>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label required">Tracked</label>
                                        <select name="tracked" class="form-select" required>
                                             <option value="" disabled selected hidden> -- tracked or not? -- </option>
                                             <option <?php echo !@$lead->tracked ? 'selected' : ''; ?> value="0">Yes</option>
                                             <option <?php echo @$lead->tracked ? 'selected' : ''; ?> value="1">No</option>
                                        </select>
                                   </div>
                              </div>
                         </div>
                         <div class="row" id="retention_day_section">
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label required">Retention Day</label>
                                        <select id="retention_day_id" name="retention_day_id" class="form-select" required>
                                             <option value=""> -- select retention day -- </option>
                                             <?php foreach ($retention_days as $retention_day) { ?>
                                                  <option <?php echo (@$lead->retention_day_id == $retention_day->id) ? 'selected' : ''; ?> value="<?php echo $retention_day->id; ?>"><?php echo $retention_day->name; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                              </div>
                         </div>
                         <div class="row mt-5" id="lead-deposits-block">
                              <?php $deposits_count = is_array($lead_deposits) ? count($lead_deposits) : 0 ; ?>
                              <?php if ($deposits_count > 0) { ?>
                                   <?php foreach ($lead_deposits as $index => $lead_deposit) { ?>
                                        <div class="mb-3 col-md-4 lead-deposit-input">
                                             <div class="form-group">
                                                  <label class="form-label deposit-label">Deposit <?php echo ($index + 1) ?></label>
                                                  <input type="text" class="form-control deposit-input" name="lead_deposit_amounts[<?php echo $index ?>]" placeholder="Enter deposit <?php echo ($index + 1) ?>" value="<?php echo $lead_deposit->amount ?>">

                                                  <label class="form-label payment-method-label">Payment Method <?php echo ($index + 1) ?></label>
                                                  <select name="payment_method_ids[<?php echo $index ?>]" class="form-select select2 payment-method-input">
                                                       <option value=""> -- select payment method <?php echo ($index + 1) ?> -- </option>
                                                       <?php foreach ($payment_methods as $payment_method) { ?>
                                                            <option <?php echo ($lead_deposit->payment_method_id == $payment_method->id) ? 'selected' : ''; ?> value="<?php echo $payment_method->id; ?>"><?php echo $payment_method->type . ' : ' . $payment_method->name . ' : ' . $payment_method->identity; ?></option>
                                                       <?php } ?>
                                                  </select>

                                                  <input type="hidden" name="lead_deposit_ids[<?php echo $index ?>]" value="<?php echo $lead_deposit->id ?>">
                                             </div>
                                        </div>
                                   <?php } ?>
                              <?php } else { ?>
                                   <div class="mb-3 col-md-4 lead-deposit-input">
                                        <div class="form-group">
                                             <label class="form-label deposit-label">Deposit 1</label>
                                             <input type="text" class="form-control deposit-input" name="lead_deposit_amounts[0]" placeholder="Enter deposit 1">

                                             <label class="form-label payment-method-label">Payment Method 1</label>
                                             <select name="payment_method_ids[0]" class="form-select select2 payment-method-input">
                                                  <option value=""> -- select payment method 1 -- </option>
                                                  <?php foreach ($payment_methods as $payment_method) { ?>
                                                       <option value="<?php echo $payment_method->id; ?>"><?php echo $payment_method->type . ' : ' . $payment_method->name . ' : ' . $payment_method->identity; ?></option>
                                                  <?php } ?>
                                             </select>

                                             <input type="hidden" name="lead_deposit_ids[0]" value="0">
                                        </div>
                                   </div>
                              <?php } ?>
                         </div>
                         <button type="submit" class="btn btn-primary">Submit</button>
                         <button type="button" id="add-lead-deposits" class="btn btn-info">Add Deposit</button>
                         <div class="mt-3" id="lead-deposits-count">
                              <b><label>Deposit Count: <?php echo $deposits_count ?></label></b>
                         </div>
                    </form>
               </div>
          </div>
     </div>

<?php $customSection = ob_get_clean(); ?>

<?php ob_start(); ?>

     <script src="/assets/custom-js/emulators.js"></script>

     <script>
          var lead_deposits_input = `
<div class="mb-3 col-md-4 lead-deposit-input">
     <div class="form-group">
          <label class="form-label deposit-label">Deposit 1</label>
          <input type="text" class="form-control deposit-input" name="lead_deposit_amounts[0]" placeholder="Enter deposit 1">

          <label class="form-label payment-method-label">Payment Method 1</label>
          <select name="payment_method_ids[0]" class="form-select select2 payment-method-input">
               <option value=""> -- select payment method 1 -- </option>
               <?php foreach ($payment_methods as $payment_method) { ?>
                    <option value="<?php echo $payment_method->id; ?>"><?php echo $payment_method->type . ' : ' . $payment_method->name . ' : ' . $payment_method->identity; ?></option>
               <?php } ?>
          </select>

          <input type="hidden" name="lead_deposit_ids[0]" value="0">
     </div>
</div>
`;
          $('#add-lead-deposits').on('click', function(event) {
               new_lead_deposits_input = $(lead_deposits_input);
               lead_deposits_count = $('.lead-deposit-input').length + 1;

               new_lead_deposits_input.find( '.deposit-label' ).text('Deposit ' + lead_deposits_count);
               new_lead_deposits_input.find( '.payment-method-label' ).text('Payment Method ' + lead_deposits_count);

               new_lead_deposits_input.find( '.deposit-input' ).attr('placeholder', 'Enter deposit ' + lead_deposits_count);
               new_lead_deposits_input.find( '.deposit-input' ).attr('name', `lead_deposit_amounts[${lead_deposits_count-1}]`);

               new_lead_deposits_input.find( '.payment-method-input option:first' ).text(` -- select payment method ${lead_deposits_count} -- `);
               new_lead_deposits_input.find( '.payment-method-input' ).attr('name', `payment_method_ids[${lead_deposits_count-1}]`);

               new_lead_deposits_input.find( 'input[type="hidden"]' ).attr('name', `lead_deposit_ids[${lead_deposits_count-1}]`);
               new_lead_deposits_input.find( 'input[type="hidden"]' ).val(0);
               $('#lead-deposits-block').append(new_lead_deposits_input);
               updateSelect2();
          });

          <?php if (@$lead->type == 1) {?>

               $('#emulator_name_textarea').hide();
               $("#emulator_name_textarea").prop('disabled', true);

               $('#emulator_name_select').hide();
               $("#emulator_name_select").prop('disabled', true);

               $('#retention_day_section').hide();
               $('#retention_day_id').hide();
               $("#retention_day_id").prop('disabled', true);

               $('#emulator_name_text').show();
          <?php } else if (@$lead->type == 2) { ?>

               $('#emulator_name_text').hide();
               $("#emulator_name_text").prop('disabled', true);

               $('#emulator_name_textarea').hide();
               $("#emulator_name_textarea").prop('disabled', true);

               $('#emulator_name_select').addClass('select2');
          <?php } else { ?>

               $('#add-lead-deposits, .lead-deposit-input, #lead-deposits-count').hide();

               $('#emulator_name_text').hide();
               $("#emulator_name_text").prop('disabled', true);

               $('#emulator_name_select').hide();
               $("#emulator_name_select").prop('disabled', true);

               $('#retention_day_section').hide();
               $('#retention_day_id').hide();
               $("#retention_day_id").prop('disabled', true);

               $('#emulator_name_textarea').show();
          <?php } ?>

          $('select[name="type"]').on('change', function (event) {
               value = $(this).val();
               if (value == 1) {
                    $('#add-lead-deposits, .lead-deposit-input, #lead-deposits-count').show();

                    $('#emulator_name_textarea').hide();
                    $("#emulator_name_textarea").prop('disabled', true);

                    $("#emulator_name_select").val('').change();
                    $('#emulator_name_select').removeClass('select2');
                    $('#emulator_name_select').hide();
                    $('#emulator_name_select').next('.select2-container').hide();
                    $("#emulator_name_select").prop('disabled', true);

                    $('#retention_day_section').hide();
                    $('#retention_day_id').hide();
                    $("#retention_day_id").prop('disabled', true);

                    $('#emulator_name_text').show();
                    $("#emulator_name_text").prop('disabled', false);

               }
               else if (value == 2) {
                    $('#add-lead-deposits, .lead-deposit-input, #lead-deposits-count').show();

                    $('#emulator_name_textarea').hide();
                    $("#emulator_name_textarea").prop('disabled', true);
                    $('#emulator_name_text').hide();
                    $("#emulator_name_text").prop('disabled', true);

                    $('#emulator_name_select').addClass('select2');
                    $('#emulator_name_select').show();
                    $("#emulator_name_select").prop('disabled', false);

                    $('#retention_day_section').show();
                    $('#retention_day_id').show();
                    $("#retention_day_id").prop('disabled', false);

                    updateSelect2();
               }
               else {
                    $('#add-lead-deposits, .lead-deposit-input, #lead-deposits-count').hide();

                    $('#emulator_name_text').hide();

                    $("#emulator_name_select").val('').change();
                    $('#emulator_name_select').removeClass('select2');
                    $('#emulator_name_select').hide();
                    $('#emulator_name_select').next('.select2-container').hide();
                    $("#emulator_name_select").prop('disabled', true);

                    $('#emulator_name_textarea').show();
                    $("#emulator_name_textarea").prop('disabled', false);
                    $('#emulator_name_textarea').val($('#emulator_name_text').val());

                    $('#retention_day_section').hide();
                    $('#retention_day_id').hide();
                    $("#retention_day_id").prop('disabled', true);

                    $("#emulator_name_text").prop('disabled', true);
               }
          });
     </script>

<?php
     $customScript = ob_get_clean();
     include_once __DIR__."/../../layout/index.php";
?>
