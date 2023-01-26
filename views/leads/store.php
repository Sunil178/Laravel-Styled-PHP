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
                                        <label class="form-label">Count</label>
                                        <input type="number" class="form-control" name="count" placeholder="Enter count" value="<?php echo $lead->count ?>">
                                   </div>
                              </div>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Date</label>
                                        <input type="date" class="form-control" name="date" placeholder="Enter date" value="<?php echo $lead->date ?>">
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
    include_once __DIR__."/../../layout/index.php";
?>
