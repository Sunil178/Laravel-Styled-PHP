<div class="col-md-10">
     <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
               <h5 class="mb-0"> <?php (@$gameplay ? 'Edit' : 'Create') ?> Gameplay</h5>
          </div>
          <div class="card-body">
               <form method="POST" action="" id="form">
                    <div class="row">
                         <input type="hidden" name="question_id" value="<?php @$gameplay->id ?>">
                         <div class="mb-3 col-md-6">
                         <label class="form-label required" for="basic-default-board">Board</label>
                         <select name="board_id" id="board_id" class="form-select">
                              <option value=""> -- select board -- </option>
                         </select>
                         </div>
                         <div class="mb-3 col-md-6">
                         <label class="form-label required" for="basic-default-standard">Standard</label>
                         <select name="standard_id" id="standard_id" class="form-select">
                              <option value="">select standard</option>
                         </select>
                         </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn btn-secondary" type="reset">Cancel</button>
               </form>
          </div>
     </div>
</div>