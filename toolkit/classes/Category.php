<?php
class Category extends DbConnect {
          // define properties
		  protected $db;
		  
          protected $categoryId;
          protected $categoryType;
          
          public function createCategory($categoryType) {
			  		// this is for if not exist testing
					//$result = $this->db->query("SELECT * FROM category");
					//$row = $result->fetch_assoc();
			  
                    $result = $this->db->prepare("INSERT INTO category (categoryType) VALUES (?)");
                    $result->bind_param('s',$categoryType);
                    $result->execute();
          } // end createCategory
          
          public function readCategory() {
                    $result = $this->db->query("SELECT * FROM category");
                    while ($row = $result->fetch_assoc()) {
                              echo $row['categoryType'];
                    } // end while
          } // end readCategory
          
          public function updateCategory() {
                    $result = $this->db->query("UPDATE category SET categoryType = '$this->categoryType' WHERE categoryId = '$this->categoryId'");
          } // end updateCategory
          
          public function deleteCategory() {
                    $result = $this->db->query("DELETE FROM category WHERE categoryId = '$this->categoryId'") or die();
          } // end deleteCategory
          
          public static function getCategoryId($categoryId) {
                    return $categoryId;
          } // end getCategoryId
          
} // end Category class