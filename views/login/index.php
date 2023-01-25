<?php ob_start(); ?>
     <div class="col-md-10">
          <div class="card mb-4">
               <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Login</h5>
               </div>
               <div class="card-body">
                    <form method="POST" action="/controller/login.php" id="form">
                         <div class="row">
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username" placeholder="Enter username" >
                                   </div>
                              </div>
                         </div>
                         <div class="row">
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" placeholder="Enter password" >
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
