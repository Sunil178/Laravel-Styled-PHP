<?php ob_start(); ?>
     <div class="col-md-10">
          <div class="card mb-4">
               <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"> <?php echo ($employee->id ? 'Edit' : 'Create') ?> Employee</h5>
               </div>
               <div class="card-body">
                    <form method="POST" action="../controller/employee.php" id="form">
                    <input type="hidden" name="employee_id" value="<?php echo $employee->id ?>">
                         <div class="row">
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username" placeholder="Enter username" value="<?php echo $employee->username ?>">
                                   </div>
                              </div>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter name" value="<?php echo $employee->name ?>">
                                   </div>
                              </div>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Mobile</label>
                                        <input type="text" class="form-control" name="mobile" placeholder="Enter mobile" value="<?php echo $employee->mobile ?>">
                                   </div>
                              </div>
                         </div>
                         <div class="row">
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Enter email" value="<?php echo $employee->email ?>">
                                   </div>
                              </div>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" placeholder="Enter password" value="<?php echo $employee->password ?>">
                                   </div>
                              </div>
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Confirm Password</label>
                                        <input type="text" class="form-control" name="confirm_password" placeholder="Enter confirm password">
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
