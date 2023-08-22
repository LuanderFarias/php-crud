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

        // Update
        public function update($postValues) {
            $id = $postValues['id'];
            $model = $postValues['model'];
            $brand = $postValues['brand'];
            $licenseplate = $postValues['licenseplate'];
            $color = $postValues['color'];
            $year = $postValues['year'];

            if (empty($id) || empty($model) || empty($brand) || empty($licenseplate) || empty($color) || empty($year)) {
                return false;
            }

            $query = "UPDATE " . $this->table_name . " SET model = ?, brand = ?, licenseplate = ?, color = ?, year = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $model);
            $stmt->bindParam(2, $brand);
            $stmt->bindParam(3, $licenseplate);
            $stmt->bindParam(4, $color);
            $stmt->bindParam(5, $year);
            $stmt->bindParam(6, $id);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

        //delete
        public function delete($id) {
            $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $id);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

        // ReadOne
        public function readOne($id) {
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }