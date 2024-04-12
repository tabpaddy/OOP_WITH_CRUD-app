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


    //get users function

    function getusers(){
       // AJAX request
       var pageno=$("#currentpage").val();
       $.ajax({
        url: "include/ajax.php",
        type: "post",
        dataType: "json", // Specify expected data type as JSON
        data: {page:pageno,action:'getallusers'},

        beforeSend: function() {
            console.log("Wait....Data is loading");
        },
        success: function(row) {
           console.log(row);
        },
        error: function(xhr, status, error) {
            console.log("Error occurred:");
            console.log(xhr.responseText); // Log the full response for debugging
            console.log(status + ': ' + error);
        }
       })
    }

    //calling getusers() function
    console.log(getusers());
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