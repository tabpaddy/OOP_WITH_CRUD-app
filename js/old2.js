
//function to get users from database
  function getuserrow(user){
    var userRow="";
    if (user) {
        userRow=`<tr>
        <td scope="row"><img src=${user.photo}></td>
        <td>${user.name}</td>
        <td>${user.email}</td>
        <td>${user.mobilenum}</td>
        <td>
         <a href="#" class="me-3 profile"><i class="uil uil-eye text-info" title="View Profile" data-bs-target="#userviewmodal" data-bs-toggle="modal" data-id="${user.id}"></i></a>
         <a href="#" class="me-3 edituser"><i class="uil uil-edit-alt text-success" title="Edit" data-bs-target="#usermodal" data-bs-toggle="modal" data-id="${user.id}"></i></a>
         <a href="#" class="me-3 deleteuser"><i class="uil uil-trash text-danger" title="Delete" data-id="${user.id}"></i></a>
        </td>
      </tr>`;
    }
    return userRow;
  }
  
  //get users function

  function getusers(){
    // AJAX request
    var pageno=$("#currentpage").val();
    $.ajax({
     url: "include/ajax.php",
     type: "GET",
     dataType: "json", // Specify expected data type as JSON
     data: {page:pageno,action:'getallusers'},

     beforeSend: function() {
         console.log("Wait....Data is loading");
     },
     success: function(row) {
        console.log(row);
        if (row.players) {
            var usersList="";
            $.each(row.players,function(index, user){
                usersList+=getuserrow(user);
            });
            $("#usertable tbody").html(usersList);
        }

     },
     error: function(xhr, status, error) {
         console.log("Error occurred:");
         console.log(xhr.responseText); // Log the full response for debugging
         console.log(status + ': ' + error);
     }
    })
 }



 //document loading
$(document).ready(function() {
    // Adding users
    $(document).on("submit", "#addform", function(e) {
        e.preventDefault();

        // AJAX request
        $.ajax({
            url: "include/ajax.php",
            type: "post",
            dataType: "json", // Specify expected data type as JSON
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function() {
                console.log("Wait....Data is loading");
            },
            success: function(response) {
                console.log(response); // Log the response for debugging
        
                // Check if response contains valid data
                if (response && response.id !== undefined) {
                    $("#usermodal").modal("hide"); // Close form modal
                    $("#addform")[0].reset(); // Reset form fields
                    getusers();
        
                    console.log("User added successfully!");
                } else {
                    console.log("Unexpected response format or data missing.");
                }
            },
            error: function(xhr, status, error) {
                console.log("Error occurred:");
                console.log(xhr.responseText); // Log full response for debugging
                console.log(status + ': ' + error);
            }
        });
        
    });


    // //get users function

    // function getusers(){
    //    // AJAX request
    //    var pageno=$("#currentpage").val();
    //    $.ajax({
    //     url: "include/ajax.php",
    //     type: "post",
    //     dataType: "json", // Specify expected data type as JSON
    //     data: {page:pageno,action:'getallusers'},

    //     beforeSend: function() {
    //         console.log("Wait....Data is loading");
    //     },
    //     success: function(row) {
    //        console.log(row);
    //     },
    //     error: function(xhr, status, error) {
    //         console.log("Error occurred:");
    //         console.log(xhr.responseText); // Log the full response for debugging
    //         console.log(status + ': ' + error);
    //     }
    //    })
    // }

    // //calling getusers() function
    getusers();
});






// $(document).ready(function (){
//    // adding users
//    $(document).on("submit","#addform",function(e){
//     e.preventDefault();
//     //ajax
//     $.ajax({
//         url: "include/ajax.php",
//         type: "post",
//         dataType: "json",
//         data: new FormData(this),
//         processData: false,
//         contentType: false,
//         beforeSend: function() {
//             console.log("Wait....Data is loading");
//         },
//         success: function(response) {
//             console.log(response); // Log the response to inspect user data
//             // Example: Access user properties like mobilenum and photo
//             // if (response && response.user) {
//             //     console.log("Mobile Number:", response.user.mobilenum);
//             //     console.log("Photo:", response.user.photo);
               
//             // }

//             if (response) {
//                 $("#usermodal").modal("hide");//to close form modal
//                 $("#addform")[0].reset();//to reset all the values in the form
//             }
//         },
//         error: function(xhr, status, error) {
//             console.log("Error occurred:");
//             console.log(xhr.responseText); // Log full response for debugging
//             console.log(status + ': ' + error);
//         }
//     });
    
//    })
// })