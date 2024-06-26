<?php
require_once "config.php";

class User extends database{
    protected $tablename="user";

    // Function to add a user
    
    
    // function to add users
    public function add($data){
        if (!empty($data)) {//to check data is not empty
            $fields = $placeholder = [];
            foreach ($data as $field => $value) {
                $fields[]=$field;
                $placeholder[]=":{$field}";
            }
        }
        // $sql="INSERT INTO {$this->tablename} (name, email, mobilenum) VALUES (:username, :email, :mobilenumber)";
        $sql = "INSERT INTO {$this->tablename} (". implode(',',$fields). ") VALUES (". implode(',',$placeholder). ")";
        $stmt = $this->conn->prepare($sql);
        try{
            $this->conn->beginTransaction();
            $stmt->execute($data);
            $lastInsertedId=$this->conn->lastInsertId();
            $this->conn->commit();//just saying this changes are done by me
            return $lastInsertedId;

        }catch(PDOException $e){
            echo "Error:".$e->getMessage();
            $this->conn->rollBack();
        }
    }


    //function to get rows

    public function getRows($start=0, $limit=4){
        $sql = "SELECT * FROM {$this->tablename} ORDER BY id DESC LIMIT {$start},{$limit}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        if ($stmt -> rowCount()>0) {//it means i have data inside the database so i'm going to fetch all the data in the db using  fetchAll(PDO:: FETCH_ASSOC) 
            $results = $stmt->fetchAll(PDO:: FETCH_ASSOC);//to get all associative value and using fetchAll method to access all the data nd display in the website
        }else {
            $results=[];
        }
        return $results;
    }

// Function to retrieve a single user by a specific field



    // function to get single rows
    //this is using for updating, viewing, deleting because we are getting a single user
    public function getRow($field, $value) {
        // Prepare the SQL statement with a named placeholder for the field value
        $sql = "SELECT * FROM {$this->tablename} WHERE {$field} = :value";
        
        // Prepare the statement
        $stmt = $this->conn->prepare($sql);
        
        // Bind the parameter value to the named placeholder
        $stmt->bindParam(':value', $value);
        
        // Execute the statement
        $stmt->execute();
        
        // Check if any rows were returned
        if ($stmt->rowCount() > 0) {
            // Fetch the result as an associative array
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            // If no rows were found, return an empty array
            $result = [];
        }
        
        // Return the result
        return $result;
    }
    
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
    //to count how many data is inside the database 

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
            $fileSize = $file['size'];
            $fileType = $file['type'];
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


    // function to update
    // public function update($data, $id){
    //     //dunamic data
    //     if(!empty($data)){
    //         $fields="";
    //         $x=1;
    //         $fieldsCount=count($data);
    //         foreach ($data as $field => $value) {
    //             # code...
    //             $fields.="{$field}=:{$field}";
    //             if($x<$fieldsCount){
    //                 $fields.=",";                
    //             }
    //             $x++;// to update
    //         }
    //     }
    //     //staiic
    //     $sql= "UPDATE {$this->tablename} SET {$fields} where id = :id";
    //     $stmt = $this->conn->prepare($sql);
    //     try{
    //         $this->conn->beginTransaction();
    //         $data['id']=$id;
    //         $stmt->execute($data);
    //         $this->conn->commit();//just saying this changes are done by me
            
    //     }catch(PDOException $e){
    //         echo "Error:".$e->getMessage();
    //         $this->conn->rollBack();
    //     }
    // }
    public function update($data, $id){
        if(!empty($data) && is_array($data)) {
            $fields = "";
            $x = 1;
            $fieldsCount = count($data); // Use count() instead of Count()
            
            foreach ($data as $field => $value) {
                $fields .= "{$field}=:{$field}";
                if($x < $fieldsCount) {
                    $fields .= ",";                
                }
                $x++;
            }
    
            $sql = "UPDATE {$this->tablename} SET {$fields} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            
            try {
                $this->conn->beginTransaction();
                $data['id'] = $id;
                $stmt->execute($data);
                $this->conn->commit(); // Commit changes
                
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
                $this->conn->rollBack(); // Rollback changes on error
            }
        } else {
            echo "Error: Invalid data format provided.";
        }
    }
    

    //function to delete
    public function deleteRow($id){
        $sql = "DELETE FROM {$this->tablename} WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        try {
            $stmt->execute([':id' => $id]); // Corrected to $stmt->execute([':id' => $id]);
            if ($stmt->rowCount() > 0) {
                return true; // Return true if deletion was successful
            } 
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Output the error message
            return false; // Return false on exception (error occurred)
        }
    }


    //function to search user

    public function searchuser($searchText, $start = 0, $limit = 4){
        $sql = "SELECT * FROM {$this->tablename} WHERE name LIKE :searchText ORDER BY id DESC LIMIT {$start}, {$limit}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':searchText' => "{$searchText}%"]); // Correct parameter binding
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    

}
?>
