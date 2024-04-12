### PHP CRUD Application using OOP

This project is a simple CRUD application implemented in PHP, showcasing object-oriented programming concepts for managing a collection of items.

#### Features

- **Create:** Add new items to the collection.
- **Read:** View existing items in the collection.
- **Update:** Modify details of an item.
- **Delete:** Remove an item from the collection.

#### Requirements

- PHP 7.x or higher
- MySQL (for database storage, optional)

#### Getting Started

1. **Clone the repository:**

   ```bash
   git clone https://github.com/yourusername/php-crud-app.git
   ```

2. **Navigate to the project directory:**

   ```bash
   cd php-crud-app
   ```

3. **Start the PHP built-in web server:**

   ```bash
   php -S localhost:8000
   ```

4. **Open your web browser and navigate to `http://localhost:8000` to access the application.**

#### Database Configuration (Optional)

If you want to use a database for storing items, follow these steps:

1. **Create a MySQL database:**

   ```sql
   CREATE DATABASE userdata;
   ```

2. **Create a class named `User` extend form the database:**

   ```sql
  <?php
    require_once "config.php";
    
    class User extends database{
        protected $tablename="user";
    
     
        
    
    }
    ?>
   ```

3. **Update the database configuration in `config.php`:**

   ```php
   <?php
   class database{


    private $dbserver = "localhost";
    private $dbuser = "root";
    private $dbpassword = "";
    private $dbname = "userdata";

    protected $conn;

    //constructor
    public function __construct(){
        try{
            $dsn = "mysql:host={$this->dbserver}; dbname={$this->dbname}; charset-utf8";
            $options = array(PDO::ATTR_PERSISTENT);
            $this->conn = new PDO($dsn, $this->dbuser, $this->dbpassword, $options);
        }catch(PDOException $e){
            echo "connection Error".$e->getMessage();
        }
      

    }

}
   ```

#### Usage

The application consists of the following files:

- **`index.php`:** Displays a list of items with options to add, edit, and delete.
- **`Item.php`:** Defines the `Item` class representing an item with properties and methods.
- **`Database.php`:** Implements database operations (CRUD) using PDO.
- **`config.php`:** Contains database configuration settings.

To use the application:

1. Visit `http://localhost:8000` in your web browser.
2. Use the interface to perform CRUD operations on items.

#### Structure

The application follows an object-oriented structure:


- **`config.php`:** Contains methods for interacting with the database, including CRUD operations (Create, Read, Update, Delete).
- **`index.php`:** Implements the user interface and logic to display items, handle form submissions, and interact with the `Database` class.

#### Contributing

Contributions are welcome! Feel free to submit issues and pull requests.

#### License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---
