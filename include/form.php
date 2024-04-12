<div class="modal fade" id="usermodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Adding or Updating User</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addform" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <!-- name -->
                <div class="form-group my-2">
                    <label>Name:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-dark"><i class="uil uil-user text-light"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter your username" autocomplete="off" required="required" id="username" name="username">
                    </div>
                </div>
                <!-- email -->
                <div class="form-group my-2">
                    <label>Email:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-dark"><i class="uil uil-at text-light"></i></span>
                        </div>
                        <input type="email" class="form-control" placeholder="Enter your email" autocomplete="off" required="required" id="email" name="email">
                    </div>
                </div>
                <!-- phone -->
                <div class="form-group my-2">
                    <label>Mobile number:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-dark"><i class="uil uil-phone text-light"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter your mobile number" autocomplete="off" required="required" id="mobile" name="mobile" maxlength="11" minlength="11">
                    </div>
                </div>
                <!-- photo -->
                <div class="form-group my-2">
                    <label class="custom-file-label" for="file">Choose file</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-dark"><i class="uil uil-image text-light"></i></span>
                        </div>
                        <input type="file" class="custom-file-input form-control" name="file" id="file">
                    </div>
                </div>
            </div>
        
        
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-dark">Submit</button>
            <!-- 2ninput fields first for adding and next for updating, deleting or viewing profile -->
            <input type="hidden" name="action" value="adduser">
            <input type="hidden" name="userId" id="userId">
        </div>
        </form>
        </div>
    </div>
    </div>