<?php
$action = $_REQUEST['action'];

if (!empty($action)) {
    require_once '../partials/user.php';
    $obj = new User();

    // Adding user action
    if ($action == 'adduser' && !empty($_POST)) {
        $name = $_POST['username'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $photo = $_FILES['file'];

        // Optional: Check if userId is provided (for update scenario)
        $playerid = (!empty($_POST['userId'])) ? $_POST['userId'] : "";

        $imagename = "";
        if (!empty($photo['name'])) {
            $imagename = $obj->uploadPhoto($photo);
        }

        // Prepare user data for insertion
        // $playerData = [
        //     'name' => $name,
        //     'email' => $email,
        //     'mobilenum' => $mobile,
        //     'photo' => $imagename, // This should be the uploaded image filename
        // ];
        $playerData = [
            'name' => $name,
            'email' => $email,
            'mobilenum' => $mobile
        ];
    
        if (!empty($imagename)) {
            $playerData['photo'] = $imagename; // Include photo field only if imagename is not empty and This should be the uploaded image filename
        }

        if($playerid){
            $obj->update($playerData, $playerid);
        }else{
            // Add user to database and get the inserted ID
            $playerid = $obj->add($playerData);
            // var_dump($playerid); // Check the type and value of $playerid
        }

   

        if (!empty($playerid)) {
            // Fetch the inserted user record by ID
            $player = $obj->getRow('id', $playerid);
            // print_r($player); // Output the fetched user record for debugging
            // Send the user data as JSON response
            if (!empty($player)) {
                header('Content-Type: application/json');
                echo json_encode($player);
                exit(); // Exit script after sending JSON response
            } else {
                echo json_encode(['error' => 'User not found']); // Handle case where user record is not found
                exit();
            }
        } else {
            echo json_encode(['error' => 'Failed to perform user operation']); // Handle case where user addition fails
            exit();
        }
    }

    //getcountof function and get allusers action

    if($action == 'getallusers'){
        $page=(!empty($_GET['page']))?$_GET['page']:1;
        $limit=4;
        //page=2
        //limit=4
        //start=1*4=4.....4,5,6,7

        $start=($page-1)*$limit;
        //call getrows function
        $users = $obj->getRows($start, $limit);
        if (!empty($users)) {
            $userlist = $users;
        }else {
            $userlist=[];
        }
        $total = $obj->getCount();
        $useArr=['count'=>$total, 'users'=>$userlist];
        echo json_encode($useArr);
        exit();
    }
}


//action to perform editing
if($action == "editusersdata"){
    $playerid = (!empty($_GET['id'])) ? $_GET['id'] : "";
    if(!empty($playerid)){
         // Fetch the inserted user record by ID
         $user = $obj->getRow('id', $playerid);
         // print_r($player); // Output the fetched user record for debugging
         // Send the user data as JSON response
         if (!empty($user)) {
             header('Content-Type: application/json');
             echo json_encode($user);
             exit(); // Exit script after sending JSON response
         } else {
             echo json_encode(['error' => 'User not found']); // Handle case where user record is not found
             exit();
         }
     } 
}

//action to perfrom deleting
if($action=='deleteusersdata'){
    $userid = (!empty($_GET['id'])) ? $_GET['id'] : "";
    if(!empty($userid)){
        $isdeleted=$obj->deleteRow($userid);
        if($isdeleted){
            $displaymessage = ['delete'=>1];
        }else{
            $displaymessage = ['delete'=>0];
        }
        echo json_encode($displaymessage);
        exit();
    }
}


//search data
if($action == 'searchuser'){
    $queryStarting = !empty($_GET['searchQuery']) ? trim($_GET['searchQuery']) : '';
    $results = $obj->searchuser($queryStarting);
    echo json_encode($results);
    exit();
}




