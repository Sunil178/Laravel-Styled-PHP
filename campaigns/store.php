<?php ob_start(); ?>
     <div class="col-md-10">
          <div class="card mb-4">
               <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"> <?php echo ($campaign->id ? 'Edit' : 'Create') ?> Campaign</h5>
               </div>
               <div class="card-body">
                    <form method="POST" action="../controller/campaign.php" id="form">
                         <input type="hidden" name="campaign_id" value="<?php echo $campaign->id ?>">
                         <div class="row">
                              <div class="mb-3 col-md-4">
                                   <div class="form-group">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter name" value="<?php echo $campaign->name ?>">
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
