<?php

class Language extends Database
{
    function __construct()
    {
        parent::__construct();
        $this->setup();
    }
    

    private function setup()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `languages` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `language` varchar(25) NOT NULL,
            `language_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1:computer, 2:spoken, 3:other',
            `user_id` int(11) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `user_id` (`user_id`),
            CONSTRAINT `languages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
          ) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }


    /**
     * get_all
     *
     * @param  string $order_by  column "language" or "language_type"
     * @param  string $order "ASC" or "DESC" (DESC default)
     * @return array
     */
    public function get_all($order_by, $order)
    {
        // order_by - known column name
        $columns = array("language", "language_type");
        if (in_array($order_by, $columns)) {
            $sql_order_by = "ORDER BY languages.$order_by";
        } else {
            $sql_order_by = "ORDER BY languages.language";
        }

        $orders = array("ASC", "DESC");
        if (in_array($order, $orders)) {
            $sql_order = " " . $order;
        } else {
            $sql_order = "";
        }

        // ternary operator - if-else oneliner...
        $order = $order === "DESC" ? " DESC" : " ASC";


        $sql = "SELECT languages.*, user.username FROM languages INNER JOIN user ON languages.user_id = user.user_id ";
        $sql .= $sql_order_by;
        $sql .= $order;

        // print_r($sql);

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function add_one($language, $language_type, $user_id)
    {
        // use placeholders: ?
        $sql = "INSERT INTO languages (language, language_type, user_id) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$language, $language_type, $user_id]);

        // MySQL returns an id - last insterted Id...
        return $this->db->lastInsertId();
    }

    public function delete_one($id)
    {
        // use placeholder ?
        $sql = "DELETE FROM `languages` WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        // return number of affected rows
        return $stmt->rowCount();
    }




}






?>