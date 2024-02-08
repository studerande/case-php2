<?php
class Image extends Database
{
    public function __construct()
    {
        parent::__construct();
        $this->setup();
    }

    public function setup()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `image` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `url` varchar(255) NOT NULL,
            `page_id` int(11) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `page_id` (`page_id`),
            CONSTRAINT `image_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

    public function create($url, $page_id)
    {
        try {
            $sql = "INSERT INTO `image` (url, page_id) VALUES (:url, :page_id)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':url', $url, PDO::PARAM_STR);
            $stmt->bindParam(':page_id', $page_id, PDO::PARAM_INT);
            $stmt->execute();
    
            return $this->db->lastInsertId();
        } catch (PDOException $err) {
            echo "Felmeddelande: " . $err->getMessage();
        }
    }
}
