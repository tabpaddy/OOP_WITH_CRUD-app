<?php
require_once "config.php";

class User extends database{
    protected $tablename="user";

    // Function to add a user
    public function add($data) {
        if (!empty($data)) {
            // Extract and sanitize user data
            $name = isset($data['name']) ? $data['name'] : '';
            $email = isset($data['email']) ? $data['email'] : '';
            $mobile = isset($data['mobile']) ? $data['mobile'] : ''; // Handle empty mobile number
            $photo = isset($data['file']) ? $data['file'] : null;
    
            // Upload photo and get the image name
            $imagename = '';
            if (!empty($photo['name'])) {
                $imagename = $this->uploadPhoto($photo);
            }
    
            // Prepare SQL query to insert user data
            $sql = "INSERT INTO {$this->tablename} (name, email, mobilenum, photo) VALUES (:name, :email, :mobile, :photo)";
            $stmt = $this->conn->prepare($sql);
    
            // Bind parameters and execute the query
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':mobile', $mobile);
            $stmt->bindParam(':photo', $imagename);
    
            try {
                $this->conn->beginTransaction();
                $stmt->execute();
                $lastInsertedId = $this->conn->lastInsertId();
                $this->conn->commit();
    
                // Retrieve the inserted user record
                $user = $this->getRow('id', $lastInsertedId);
    
                return $user; // Return the user data
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                $this->conn->rollBack();
            }
        }
        return null;
    }
    
    
    // function to add users
    // public function add($data){
    //     if (!empty($data)) {
    //         $fields = $placeholder = [];
    //         foreach ($data as $field => $value) {
    //             $fields[]=$field;
    //             $placeholder[]=":{$field}";
    //         }
    //     }
    //     // $sql="INSERT INTO {$this->tablename} (name, email, mobilenum) VALUES (:username, :email, :mobilenumber)";
    //     $sql = "INSERT INTO {$this->tablename} (". implode(',',$fields). ") VALUES (". implode(',',$placeholder). ")";
    //     $stmt = $this->conn->prepare($sql);
    //     try{
    //         $this->conn->beginTransaction();
    //         $stmt->execute($data);
    //         $lastInsertedId=$this->conn->lastInsertId();
    //         $this->conn->commit();
    //         return $lastInsertedId;

    //     }catch(PDOException $e){
    //         echo "Error:".$e->getMessage();
    //         $this->conn->rollBack();
    //     }
    // }


    //function to get rows

    public function getRows($start=0, $limit=4){
        $sql = "SELECT * FROM {$this->tablename} ORDER BY DESC LIMIT {$start},{$limit}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        if ($stmt -> rowCount()>0) {
            $results = $stmt->fetchAll(PDO:: FETCH_ASSOC);
        }else {
            $results=[];
        }
        return $results;
    }

// Function to retrieve a single user by a specific field
public function getRow($field, $value) {
    $sql = "SELECT * FROM {$this->tablename} WHERE {$field} = :value";
    $stmt = $this->conn->prepare($sql);

    // Bind parameter using the correct type based on the value
    if (is_int($value)) {
        $stmt->bindParam(':value', $value, PDO::PARAM_INT);
    } else {
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);
    }

    $stmt->execute();

    // Fetch the database record as an associative array
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Debugging: Output variables for inspection
    var_dump($field, $value, $result);

    return $result; // Return the fetched record
}


    //function to get single rows
    // public function getRow($field, $value){
    //     $sql = "SELECT * FROM {$this->tablename} WHERE {$field}=:{$field}";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->execute();
    //     if ($stmt -> rowCount()>0) {
    //         $result = $stmt->fetch(PDO:: FETCH_ASSOC);
    //     }else {
    //         $result=[];
    //     }
    //     return $result;
    // }



    //function to count number of rows

    public function getCount(){
        $sql = "SELECT count(*) as pcount FROM {$this->tablename}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
            $result = $stmt->fetch(PDO:: FETCH_ASSOC);
        return $result["pcount"];
    }


    //function to upload photo
    public function uploadPhoto($file) {
        if (!empty($file['name'])) {
            $fileName = $file['name'];
            $fileTempPath = $file['tmp_name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadDir = 'uploads/';
    
            // Check if file extension is allowed
            $allowedExtensions = ["png", "jpg", "jpeg"];
            if (in_array($fileExtension, $allowedExtensions)) {
                $destFilePath = $uploadDir . $newFileName;
                if (move_uploaded_file($fileTempPath, $destFilePath)) {
                    return $newFileName; // Return uploaded file name
                }
            }
        }
        return ''; // Return empty string if upload fails or no file provided
    }
    
    // public function uploadPhoto($file){
    //     if (!empty($file)) {
    //         $fileTempPath = $file['tmp_name'];
    //         $fileName=$file['name'];
    //         $fileType=$file['type'];
    //         $fileNameCmps = explode('.',$fileName);
    //         $fileExtension = strtolower(end($fileNameCmps));
    //         $newFileName = md5(time().$fileName). '.'.$fileExtension;
    //         $allowedExtn = ["png","jpg","jpeg"];

    //         if (in_array($fileExtension, $allowedExtn)) {
    //             $uploadFileDir = getcwd()."/uploads/";
    //             $destFilePath = $uploadFileDir .$newFileName;
    //             if (move_uploaded_file($fileTempPath, $destFilePath)) {
    //                 return $newFileName;
    //             }
    //         }
    //     }
    // }























    
    //function to update



    //function to delete



    //functionfor search
}

// require_once "config.php";

// class User extends Database {
//     protected $tablename = "user";

//     // Function to add a user
//     public function add($data) {
//         if (!empty($data)) {
//             // Extract and sanitize user data
//             $name = isset($data['name']) ? $data['name'] : '';
//             $email = isset($data['email']) ? $data['email'] : '';
//             $mobile = isset($data['mobile']) ? $data['mobile'] : '';
//             $photo = isset($data['file']) ? $data['file'] : null;

//             // Upload photo and get the image name
//             $imageName = '';
//             if (!empty($photo['name'])) {
//                 $imageName = $this->uploadPhoto($photo);
//             }

//             // Prepare SQL query to insert user data
//             $sql = "INSERT INTO {$this->tablename} (name, email, mobilenum, photo) VALUES (:name, :email, :mobile, :photo)";
//             $stmt = $this->conn->prepare($sql);

//             // Bind parameters and execute the query
//             $stmt->bindParam(':name', $name);
//             $stmt->bindParam(':email', $email);
//             $stmt->bindParam(':mobile', $mobile);
//             $stmt->bindParam(':photo', $imageName);

//             try {
//                 $this->conn->beginTransaction();
//                 $stmt->execute();
//                 $lastInsertedId = $this->conn->lastInsertId();
//                 $this->conn->commit();

//                 // Retrieve the inserted user record
//                 $user = $this->getRow('id', $lastInsertedId);

//                 return $user; // Return the user data
//             } catch (PDOException $e) {
//                 echo "Error: " . $e->getMessage();
//                 $this->conn->rollBack();
//             }
//         }
//         return null;
//     }

//     // Function to retrieve a single user by a specific field
//     public function getRow($field, $value) {
//         $sql = "SELECT * FROM {$this->tablename} WHERE {$field} = :value";
//         $stmt = $this->conn->prepare($sql);

//         // Bind parameter using the correct type based on the value
//         $stmt->bindValue(':value', $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);

//         $stmt->execute();


//         // Fetch the database record as an associative array
//         $result = $stmt->fetch(PDO::FETCH_ASSOC);

//         return $result; // Return the fetched record
//     }

//     // Function to get rows with pagination
//     public function getRows($start = 0, $limit = 4) {
//         $sql = "SELECT * FROM {$this->tablename} ORDER BY id DESC LIMIT {$start}, {$limit}";
//         $stmt = $this->conn->prepare($sql);
//         $stmt->execute();
        
//         $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//         return $results;
//     }

//     // Function to count number of rows
//     public function getCount() {
//         $sql = "SELECT COUNT(*) AS pcount FROM {$this->tablename}";
//         $stmt = $this->conn->prepare($sql);
//         $stmt->execute();
        
//         $result = $stmt->fetch(PDO::FETCH_ASSOC);

//         return $result["pcount"];
//     }

//     // Function to upload photo
//     public function uploadPhoto($file) {
//         if (!empty($file['name'])) {
//             $fileName = $file['name'];
//             $fileTempPath = $file['tmp_name'];
//             $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
//             $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
//             $uploadDir = 'uploads/';

//             // Check if file extension is allowed
//             $allowedExtensions = ["png", "jpg", "jpeg"];
//             if (in_array($fileExtension, $allowedExtensions)) {
//                 $destFilePath = $uploadDir . $newFileName;
//                 if (move_uploaded_file($fileTempPath, $destFilePath)) {
//                     return $newFileName; // Return uploaded file name
//                 }
//             }
//         }
//         return ''; // Return empty string if upload fails or no file provided
//     }
// }

?>