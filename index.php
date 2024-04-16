<?php
require_once "partials/config.php";

?>

    <?php include "include/header.php"?>
    <h1 class="bg-dark text-light text-center py-2">PHP ADVANCE CRUD</h1>
    <!-- form modal -->
    <?php include "include/form.php"?>

    <div class="container">
        <!-- display deleted? message -->
        <div class="displaymessage text-color-danger"></div>
        <!-- input search -->
        <div class="row my-3">
            <div class="col-10">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-dark"><i class="uil uil-search text-light"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Search user...">
                </div>
            </div>
            <div class="col-2">
                <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#usermodal" id="adduserbtn">Add new user</button>
            </div>
        </div>

            <!-- table -->
    <?php include "include/table.php"?>

            <!-- profile -->
    <?php include "include/profile.php"?>

    <!-- pagination -->
    <nav aria-label="Page navigation example" id="pagination">
      <!-- <ul class="pagination justify-content-center">
        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#" >Next</a></li>
      </ul> -->
    </nav>

    <input type="hidden" value="1" name="currentpage" id="currentpage">



    </div>










    






    <!-- jquery cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" referrerpolicy="no-referrer"></script>

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

    <!-- js file -->
    <script src="js/script.js"></script>
  </body>
</html>