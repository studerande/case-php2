<?php

class User extends Database
{
    public function __construct()
    {
        parent::__construct();
        $this->setup();
    }
    

    /**
     * setup
     *
     * @return void
     */
    public function setup()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `user` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(20) NOT NULL,
            `password` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

    
    /**
     * get_username
     *
     * @param  string $username
     * @return mixed
     */
    public function get_username($username)
    {
        $sql = "SELECT `username` FROM  `user` WHERE `username` = :username";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetch();

        } catch (PDOException $err) {
            echo "An error: " . $err->getMessage();
        }
    }


    /**
     * register
     *
     * @param  string $username max 20 chars
     * @param  string $password 
     * @return mixed
     */
    public function register($username, $password)
    {

        // username exists?
        $row = $this->get_username($username);
        if ($row) {
            return "Användaren är redan registrerad";
        }


        $password_hash = password_hash($password, PASSWORD_DEFAULT);        
        $sql = "INSERT INTO `user` (`username`, `password`) VALUES (:username, :password)";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password_hash, PDO::PARAM_STR);
            $stmt->execute();

            return $this->db->lastInsertId();
        } catch (PDOException $err) {
            echo "Felmeddelande: " . $err->getMessage();
        }
    }
    
    /**
     * login
     *
     * @param  string $username
     * @param  string $password
     * @return mixed
     */
    public function login($username, $password)
    {
        try {
            $sql = "SELECT * FROM `user` WHERE `username` = :username";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                if (password_verify($password, $row['password'])) {
                    // Set user ID in session
                    $_SESSION['user_id'] = $row['id'];
                    
                    return array('id' => $row['id'], 'username' => $row['username']);
                }
            } 
            
            return false;
            
        } catch (PDOException $err) {
            echo "Felmeddelande: " . $err->getMessage();
        }
    }
    

}
?>