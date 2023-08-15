<?php
    include_once('connection/Connection.php');

    $db = new Database();

    class Crud {
        private $conn;
        private $table_name = "cars";

        public function __construct($db) {
            $this->conn = $db;
        }

        // Create
        public function create($postValues) {
            $model = $postValues['model'];
            $brand = $postValues['brand'];
            $licenseplate = $postValues['licenseplate'];
            $color = $postValues['color'];
            $year = $postValues['year'];

            $query = "INSERT INTO " . $this->table_name . " (model, brand, licenseplate, color, year) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $model);
            $stmt->bindParam(2, $brand);
            $stmt->bindParam(3, $licenseplate);
            $stmt->bindParam(4, $color);
            $stmt->bindParam(5, $year);

            $rows = $this->Read();
            if($stmt->execute()) {
                print "<script>alert('Register complete')</script>";
                print "<script>location.href='?action=read';</script>";
            } else {
                return false;
            }
        }

        // Read
        public function Read() {
            $query = "SELECT * FROM " . $this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }
    }