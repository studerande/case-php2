<?php class Image extends Database
{
    public function __construct()
    {
        parent::__construct();
        $this->setup();
    }

    public function setup($pdo)
    {
        $sqlImages = "CREATE TABLE IF NOT EXISTS images (
            id INT AUTO_INCREMENT PRIMARY KEY,
            url VARCHAR(255) NOT NULL,
            page_id INT,
            FOREIGN KEY (page_id) REFERENCES pages(id)
        )";
    
        $pdo->exec($sqlImages);  
    }
}