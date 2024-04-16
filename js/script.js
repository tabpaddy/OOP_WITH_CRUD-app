  //function for pagination
  //to perforom dynamic data
  function pagination(totalpages, currentpages){
    var pagelist="";
    if(totalpages>1){
        currentpages=parseInt(currentpages);//tp parse it in interger format
        pagelist+='<ul class="pagination justify-content-center">';
        const prevClass=currentpages==1?"disabled":"";
        pagelist+=`<li class="page-item ${prevClass}"><a class="page-link" href="#" data-page="${currentpages-1}">Previous</a></li>`;
        for (let p = 1; p <= totalpages; p++) {
            const activeClass=currentpages==p?"active":"";
            pagelist+=`<li class="page-item ${activeClass}"><a class="page-link" href="#" data-page="${p}">${p}</a></li>`;
            
        }
        
        const nextClass=currentpages==totalpages?"disabled":"";
        pagelist+=`<li class="page-item ${nextClass}"><a class="page-link" href="#" data-page="${currentpages+1}">Next</a></li>`;
        pagelist+='</ul>';
    }
    $("#pagination").html(pagelist);
  }
  
  //function to get users from database
  function getuserrow(user){
    var userRow="";
    if (user) {
        userRow=`<tr>
        <td scope="row"><img src="include/uploads/${user.photo}" style="width: 70px; height: 70px; object-fit: contain;"></td>
        <td>${user.name}</td>
        <td>${user.email}</td>
        <td>${user.mobilenum}</td>
        <td>
         <a href="#" class="me-3 profile" data-id="${user.id}"><i class="uil uil-eye text-info" title="View Profile" data-bs-target="#userviewmodal" data-bs-toggle="modal"></i></a>
         <a href="#" class="me-3 edituser" data-id="${user.id}"><i class="uil uil-edit-alt text-success" title="Edit" data-bs-target="#usermodal" data-bs-toggle="modal" ></i></a>
         <a href="#" class="me-3 deleteuser" data-id="${user.id}"><i class="uil uil-trash text-danger" title="Delete" ></i></a>
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
    //  success: function(row) {
    //     console.log(row); // Log the response to inspect its structure
        
    //     if (Array.isArray(row) && row.length > 0) {
    //         var usersList = "";
    //         row.forEach(function(user) {
    //             usersList += getuserrow(user);
    //         });
    //         $("#usertable tbody").html(usersList); // Update the table body with generated HTML
    //         let totaluser=row.count;
    //     } else {
    //         console.log("No users found or invalid response format:", row);
    //         // Display a message indicating no users were found
    //         $("#usertable tbody").html("<tr><td colspan='5'>No users found.</td></tr>");
    //     }
    // },
     
    
     success: function(row) {
        console.log(row);
        if (row.users) {
            var usersList="";
            $.each(row.users,function(index, users){
                usersList+=getuserrow(users);
            });
            $("#usertable tbody").html(usersList);
            let totaluser = row.count;
            // console.log(totaluser);
            let totalpages= Math.ceil(parseInt(totaluser)/4);
            const currentpage = $('#currentpage').val();
            pagination(totalpages, currentpage)
        } else {
                    console.log("No users found or invalid response format:", row);
                    // Display a message indicating no users were found
                    $("#usertable tbody").html("<tr><td colspan='5'>No users found.</td></tr>");
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

    //onclick event for pagination
    $(document).on("click", "ul.pagination li a", function(event){
        event.preventDefault();


        const pagenum=$(this).data("page");
        $("#currentpage").val(pagenum);
        getusers();
        $(this).parent().siblings().removeClass("active");
        $(this).parent().addClass("active");
    })


    //onclick event for editing
    $(document).on('click', "a.edituser", function(){
        var uid=$(this).data("id");
        //console.log(uid);
        $.ajax({
            url: "include/ajax.php",
            type: "GET",
            dataType: "json", // Specify expected data type as JSON
            data: {id:uid,action:'editusersdata'},
       
            beforeSend: function() {
                console.log("Wait....Data is loading");
            },
            success: function(row) {
               //console.log(row);
               if(row){
                //values in left side are from the input field and values from the right side are from the database
                $("#username").val(row.name);
                $("#email").val(row.email);
                $("#mobile").val(row.mobilenum);
                $("#file").val(row.photo);
                $("#userId").val(row.id);
               }
       
            },
            error: function(xhr, status, error) {
                console.log("Error occurred:");
                console.log(xhr.responseText); // Log the full response for debugging
                console.log(status + ': ' + error);
            }
           })
    })

    //onclick event foradding user btn
    $(document).on("click", "#adduserbtn", function(){
        $("#addform")[0].reset();
        $("#userId").val("");
    })

    //onclick event for deleting
    $(document).on("click", "a.deleteuser", function(e){
        e.preventDefault();
        var uid=$(this).data("id");
        if(confirm("Are you sure you want to delete this user?")){
            $.ajax({
                url: "include/ajax.php",
                type: "GET",
                dataType: "json", // Specify expected data type as JSON
                data: {id:uid,action:'deleteusersdata'},
           
                beforeSend: function() {
                    console.log("Wait....Data is loading");
                },
                success: function(res) {
                    if(res.delete==1){
                        $(".displaymessage").html("user deleted successfully").fadeIn().delay(1000).fadeOut();
                        getusers();
                        console.log("done");
                    }
                    
                 },
                error: function(xhr, status, error) {
                    console.log("Oops something went wrong!");
                    console.log(xhr.responseText); // Log the full response for debugging
                    console.log(status + ': ' + error);
                }
               })
        }

        
    })

    //onclick event for profile view
    $(document).on("click", "a.profile", function(){
        var uid=$(this).data("id");
        $.ajax({
            url: "include/ajax.php",
            type: "GET",
            dataType: "json", // Specify expected data type as JSON
            data: {id:uid,action:'editusersdata'},
       
            success:function(user){
                if(user){
                    const profile=`<div class="row">
                    <div class="col-sm-6 col-md-4">
                      <img src="include/uploads/${user.photo}" alt="image" class="rounded" style="width: 70px; height: 70px; object-fit: contain;">
                    </div>
                    <div class="col-sm-6 col-md-8">
                      <h4 class="test-primary">${user.name}</h4>
                      <p>
                        <i class="uil uil-at text-dark"></i>${user.email}
                        <br>
                        <i class="uil uil-phone text-dark"></i>${user.mobilenum}
                      </p>
                    </div>
                  </div>`;
                  $("#profile").html(profile);
                }
            },
            error: function(xhr, status, error) {
                console.log("Error occurred:");
                console.log(xhr.responseText); // Log the full response for debugging
                console.log(status + ': ' + error);
            }
        })
    })





















































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