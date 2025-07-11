<?php
class Games {
    public $db;
    public function __construct() {
        $this->db = dbConn(); 
    }
    public function searchgames($query) {
        $sql = "SELECT p.*, c.name AS category_name 
                FROM games p
                JOIN categories c ON p.category_id = c.id
                WHERE p.name LIKE :query OR c.name LIKE :query";
        $stmt = $this->db->prepare($sql); // ✅ Corrected here
        $stmt->execute(['query' => '%' . $query . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Create a new product
    public function createGames($name, $image, $description,$link, $category_id,$meta_text) {
        $data = [
            'name' => $name,
            'image' => $image,
            'description' => $description,
            'game_link' => $link, 
            'category_id' => $category_id,
            'meta_text' => $meta_text
        ];
        return dbInsert('games', $data);
    }

    // Get related games by category, excluding the current one
public function getRelatedGames($gameId, $categoryId, $limit = 4) {
    $query = "SELECT * FROM games 
              WHERE id != :id AND category_id = :category_id 
              ORDER BY RAND() 
              LIMIT :limit";
    try {
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $gameId, PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error fetching related games: " . $e->getMessage());
    }
}

    // Get all games
    public function getgames() {
        $query = "SELECT p.*, c.name AS category_name 
                  FROM games p
                  JOIN categories c ON p.category_id = c.id 
                  ORDER BY p.created_at DESC";

        try {
            $stmt = $this->db->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error fetching games: " . $e->getMessage());
        }
    }

    // Get a single product by ID
    public function getGameById($id) {
        $query = "SELECT p.*, c.name AS category_name 
                  FROM games p
                  JOIN categories c ON p.category_id = c.id 
                  WHERE p.id = :id 
                  LIMIT 1";
    
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error fetching product by ID: " . $e->getMessage());
        }
    }
    

    // Update a product
    public function updateGame($id, $name, $image, $description, $game_link, $category_id, $meta_text) {
        if (!$this->getGameById($id)) {
            return false; 
        }
        $data = [
            'name' => $name,
            'image' => $image,
            'description' => $description,
            'game_link' => $game_link,
            'category_id' => $category_id,
            'meta_text' => $meta_text
        ];
        return dbUpdate('games', $data, "id=" . $this->db->quote($id));
    }
    

    // Delete a product
    public function deleteGame($id) {
        return dbDelete('games', "id=" . $this->db->quote($id));
    }

    // Get popular games (latest games for now - can be enhanced with view counts later)
    public function getPopularGames($limit = 6) {
        $query = "SELECT p.*, c.name AS category_name 
                  FROM games p
                  JOIN categories c ON p.category_id = c.id 
                  ORDER BY p.created_at DESC
                  LIMIT :limit";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error fetching popular games: " . $e->getMessage());
        }
    }
    
}
?>
