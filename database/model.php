<?php
    global $conn;
    include_once __DIR__ . '/db.php';
    $conn->query("SET @@time_zone = '+10:30';");
    class Model {

        private $conn;
        public $table;

        public function __get($varName) {
            if (!isset($varName)) {
                return NULL;
            }
        }

        public function __construct($table) {
            global $conn;
            $this->conn = $conn;
            $this->table = $table;
        }

        public function getConnection() {
            return $this->conn;
        }

        private function affectExecuteRows($stmt) {
            if ($stmt->execute()) {
                if($stmt->affected_rows > 0) {
                    // echo "Query executed successfully, ".$stmt->affected_rows." rows affected.";
                } else {
                    // echo "Query executed successfully, but no rows affected.";
                }
                return $stmt->affected_rows;
            } else {
                // echo "Error: " . $stmt->error;
                return false;
            }
        }

        // $model->runQuery("SELECT * FROM users WHERE status = 'active'");
        public function runQuery($query) {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = array();
            while($row = $result->fetch_assoc()) {
                $rows[] = (object)$row;
            }
            return $rows;
        }    

        // $model->runQueryOne("SELECT * FROM users WHERE status = 'active'");
        public function runQueryOne($query) {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            return (object)$result->fetch_assoc();
        }    

        // $model->create([ 'name' => 'John Doe', 'email' => 'johndoe@example.com', 'mobile' => 30 ]);
        public function create($data) {
            $columns = implode(',', array_keys($data));
            $values = implode(',', str_split(str_repeat('?', count($data))));
            $query = "INSERT INTO " . $this->table . " ($columns) VALUES ($values)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param(str_repeat("s", count($data)), ...array_values($data));
            return $this->affectExecuteRows($stmt);
        }

        // $model->getAll();
        public function getAll($columns = '*') {
            if (is_array($columns)) {
                $columns = implode(', ', $columns);
            }
            $query = "SELECT " . $columns . " FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = array();
            while($row = $result->fetch_assoc()) {
                $rows[] = (object)$row;
            }
            return $rows;
        }    

        // $model->get(1);
        public function get($id, $columns = '*') {
            if (is_array($columns)) {
                $columns = implode(', ', $columns);
            }
            $query = "SELECT " . $columns . " FROM " . $this->table . " WHERE id = ?";
    
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
    
            $result = $stmt->get_result();
            return (object)$result->fetch_assoc();
        }

        /*
            $model->getBy([ 'status' => 'active' ]);
            $model->getBy([ 'status' => 'active', 'age' => '25' ]);
        */
        public function getBy($conditions, $columns = '*') {
            if (is_array($columns)) {
                $columns = implode(', ', $columns);
            }
            $query = "SELECT " . $columns . " FROM " . $this->table . " WHERE ";
            $types = "";
            $params = array();
            foreach($conditions as $key => $value) {
                $query .= $key . " = ? AND ";
                $types .= "s";
                $params[] = $value;
            }
            $query = rtrim($query, " AND ");
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = array();
            while($row = $result->fetch_assoc()) {
                $rows[] = (object)$row;
            }
            return $rows;
        }

        // $model->getByOr([ 'status' => 'active', 'age' => '25' ]);
        public function getByOr($conditions, $columns = '*') {
            if (is_array($columns)) {
                $columns = implode(', ', $columns);
            }
            $query = "SELECT " . $columns . " FROM " . $this->table . " WHERE ";
            $types = "";
            $params = array();
            foreach($conditions as $key => $value) {
                $query .= $key . " = ? OR ";
                $types .= "s";
                $params[] = $value;
            }
            $query = rtrim($query, " OR ");
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = array();
            while($row = $result->fetch_assoc()) {
                $rows[] = (object)$row;
            }
            return $rows;
        }

        /*
            $where = "status = 'active' AND age > 25";
            $model->getByCustom($where);
        */
        public function getByCustom($where, $columns = '*') {
            if (is_array($columns)) {
                $columns = implode(', ', $columns);
            }
            $query = "SELECT " . $columns . " FROM " . $this->table . " WHERE " . $where;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = array();
            while($row = $result->fetch_assoc()) {
                $rows[] = (object)$row;
            }
            return $rows;
        }

        /*
            $data = [ 'name' => 'John Doe', 'email' => 'johndoe@example.com', 'mobile' => 30 ];
            $model->update($data, 1);
        */
        public function update($data, $id) {
            $query = "UPDATE " . $this->table . " SET ";
            $types = "";
            foreach($data as $key => $value) {
                $query .= $key . " = ?, ";
                $types .= "s";
            }
            $query = rtrim($query, ', ');
            $query .= " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $params = array_values($data);
            $params[] = $id;
            $stmt->bind_param($types . "i", ...$params);
            return $this->affectExecuteRows($stmt);
        }

        /*
            $data = [ 'name' => 'John Doe', 'email' => 'johndoe@example.com', 'mobile' => 30 ];
            $conditions = ['status' => 'inactive'];
            $conditions = ['status' => 'inactive', 'age' => 20];
            $model->updateBy($data, $conditions);
        */
        public function updateBy($data, $conditions) {
            $query = "UPDATE " . $this->table . " SET ";
            $types = "";
            $params = array();
            foreach($data as $key => $value) {
                $query .= $key . " = ?, ";
                $types .= "s";
                $params[] = $value;
            }
            $query = rtrim($query, ', ');
            $query .= " WHERE ";
            foreach($conditions as $key => $value) {
                $query .= $key . " = ? AND ";
                $types .= "s";
                $params[] = $value;
            }
            $query = rtrim($query, " AND ");
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param($types, ...$params);
            return $this->affectExecuteRows($stmt);
        }

        /*
            $data = [ 'name' => 'John Doe', 'email' => 'johndoe@example.com', 'mobile' => 30 ];
            $conditions = ['status' => 'inactive', 'age' => 20];
            $model->updateByOr($data, $conditions);
        */
        public function updateByOr($data, $conditions) {
            $query = "UPDATE " . $this->table . " SET ";
            $types = "";
            $params = array();
            foreach($data as $key => $value) {
                $query .= $key . " = ?, ";
                $types .= "s";
                $params[] = $value;
            }
            $query = rtrim($query, ', ');
            $query .= " WHERE ";
            foreach($conditions as $key => $value) {
                $query .= $key . " = ? OR ";
                $types .= "s";
                $params[] = $value;
            }
            $query = rtrim($query, " OR ");
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param($types, ...$params);
            return $this->affectExecuteRows($stmt);
        }

        /*
            $data = [ 'name' => 'John Doe', 'email' => 'johndoe@example.com', 'mobile' => 30 ];
            $where = "id = 5 AND age > 25";
            $model->updateByCustom($data, $where);
        */
        public function updateByCustom($data, $where) {
            $query = "UPDATE " . $this->table . " SET ";
            $types = "";
            $params = array();
            foreach($data as $key => $value) {
                $query .= $key . " = ?, ";
                $types .= "s";
                $params[] = $value;
            }
            $query = rtrim($query, ', ');
            $query .= " WHERE " . $where;
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param($types, ...$params);
            return $this->affectExecuteRows($stmt);
        }    

        // $model->delete(1);
        public function delete($id) {
            $query = "DELETE FROM " . $this->table . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            return $this->affectExecuteRows($stmt);
        }


        // $model->delete(['id' => 5]);
        public function deleteBy($conditions) {
            $query = "DELETE FROM " . $this->table . " WHERE ";
            $types = "";
            $params = array();
            foreach($conditions as $key => $value) {
                $query .= $key . " = ? AND ";
                $types .= "s";
                $params[] = $value;
            }
            $query = rtrim($query, " AND ");
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param($types, ...$params);
            return $this->affectExecuteRows($stmt);
        }

        // $model->delete(['id' => 5, 'age'=> 25]);
        public function deleteByOr($conditions) {
            $query = "DELETE FROM " . $this->table . " WHERE ";
            $types = "";
            $params = array();
            foreach($conditions as $key => $value) {
                $query .= $key . " = ? OR ";
                $types .= "s";
                $params[] = $value;
            }
            $query = rtrim($query, " OR ");
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param($types, ...$params);
            return $this->affectExecuteRows($stmt);
        }

        /*
            $where = "id = 5 AND age > 25";
            $model->delete($where);
        */
        public function deleteByCustom($where) {
            $query = "DELETE FROM " . $this->table . " WHERE " . $where;
            $stmt = $this->conn->prepare($query);
            return $this->affectExecuteRows($stmt);
        }    
    }

    /* $model = new Model('employees');
    print_r($model->getAll());
    $data = [ 'name' => 'Sunil', 'email' => 'sunil@example.com', 'mobile' => 23 ];
    $conditions = ['username' => 'bharat'];
    $model->updateBy($data, $conditions);
    print_r($model->getAll()); */
?>