<?php

    class Car 
    {
        public $id;
        public $brand;
        public $model;
        public $price;
        private $created_on;
        private $dbconn;

        function __construct($dbconn)
        {
            $this->dbconn = $dbconn;
        }
 
        public function getRecordById($id)
        {
            $sql = "SELECT * FROM hendry_cartrack.car WHERE id = :id";

            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            $record = $stmt->fetch(); 

            return $record;
        }

        public function list($params)
        {
            $errMessage = [];
            $code = 0;
            $cars = [];

            try { 
                $sql = "SELECT * FROM hendry_cartrack.car";
                
                $conditions = [];
                $bindparams = [];

                if ( ! empty ( $params['keyword'] ) ) {
                    $conditions[] = "(brand LIKE :keyword OR model LIKE :keyword)";
                    $bindparams[':keyword'] = '%'.$params['keyword'].'%';
                }

                if ( ! empty ( $params['price'] ) ) {
                    $conditions[] = "price > :price";
                    $bindparams[':price'] = $params['price'];
                }

                if ( ! empty ( $conditions ) ) {
                    $sql .= " WHERE " . implode (" AND ", $conditions);                                        
                }

                $stmt = $this->dbconn->prepare($sql);
                foreach ( $bindparams as $field => $value ) {
                    $stmt->bindValue($field, $value);
                }
                $stmt->execute();
                
                $records = $stmt->fetchAll();
                foreach ( $records as $record ) {
                    $car = new Car($this->dbconn);
                    list ($car->id, $car->brand, $car->model, $car->price) = [$record['id'], $record['brand'], $record['model'], $record['price']];
                    $cars[] = $car;
                }

            } catch (Exception $e) {
                $code = 1;
                $errMessage[] = "Unable to retrieve list of cars" . ", reason: " . $e->getMessage();
            }

            return [
                'code' => $code,
                'message' => $errMessage,
                'cars' => $cars,
            ];
        }

        public function get($id)
        {
            $errMessage = [];
            $code = 0;

            try { 
                $sql = "SELECT * FROM hendry_cartrack.car WHERE id = :id";

                $stmt = $this->dbconn->prepare($sql);
                $stmt->bindValue(':id', $id);
                $stmt->execute();
                
                $record = $stmt->fetch();
                if ( ! empty ( $record ) ) {
                    list ($this->id, $this->brand, $this->model, $this->price) = [$record['id'], $record['brand'], $record['model'], $record['price']];
                }

            } catch (Exception $e) {
                $code = 1;
                $errMessage[] = "Unable to retrieve car by id " . $id; // . ", reason: " . $e->getMessage();
            }

            return [
                'code' => $code,
                'message' => $errMessage,
                'car' => $this,
            ];
        }

        public function upsert($params)
        {
            $errMessage = [];
            $code = 0;

            if ( empty ( $params['brand'] ) ) $errMessage[] = "Please provide car brand name";
            
            if ( empty ( $params['model'] ) ) $errMessage[] = "Please provide car model name";

            if ( empty ( $params['price'] ) || ! is_numeric ($params['price']) ) $errMessage[] = "Please provide car price in numeric";

            if ( ! empty ( $errMessage ) ) {
                $code = 1;            
            }
            // UPDATE by id
            else if ( ! empty ( $params['id'] ) ) {  
                try {              
                    $sql = "UPDATE hendry_cartrack.car 
                            SET brand = :brand,
                                model = :model,
                                price = :price
                            WHERE id = :id
                            ";
                    
                    $stmt = $this->dbconn->prepare($sql);

                    $stmt->bindValue(':brand', $params['brand']);
                    $stmt->bindValue(':model', $params['model']);
                    $stmt->bindValue(':price', $params['price']);
                    $stmt->bindValue(':id', $params['id']);

                    if ( $stmt->execute() ) {
                        list ($this->id, $this->brand, $this->model, $this->price) = [$params['id'], $params['brand'], $params['model'], $params['price']];
                    }
                } catch (Exception $e) {
                    $code = 1;
                    $errMessage[] = "Unable to update car by id " . $params['id']; // . ", reason: " . $e->getMessage();
                }
            } else {
                try { 
                    // prepare statement for upsert
                    $sql = "INSERT INTO hendry_cartrack.car 
                                (brand, model, price, created_on) 
                            VALUES(:brand, :model, :price, NOW()) 
                            ON CONFLICT DO NOTHING
                            RETURNING ID";

                    $stmt = $this->dbconn->prepare($sql);
    
                    // pass values to the statement
                    $stmt->bindValue(':brand', $params['brand']);
                    $stmt->bindValue(':model', $params['model']);
                    $stmt->bindValue(':price', $params['price']);
            
                    // execute the insert statement
                    $stmt->execute();
                    $record = $stmt->fetch();
                    if ( ! empty ($record) ) {
                        list ($this->id, $this->brand, $this->model, $this->price) = [$record['id'], $params['brand'], $params['model'], $params['price']];
                    }
                    else {
                        throw new Exception('No insert');
                    }
                } catch (Exception $e) {
                    $code = 1;
                    $errMessage[] = "Unable to add new car"; // . ", reason: " . $e->getMessage();
                }
            }

            return [
                'code' => $code,
                'message' => $errMessage,
                'car' => $this
            ];
        }

        public function delete($id)
        {
            $errMessage = [];
            $code = 0;

            try { 
                $sql = "DELETE FROM hendry_cartrack.car WHERE id = :id";

                $stmt = $this->dbconn->prepare($sql);
                $stmt->bindValue(':id', $id);
                if ( ! $stmt->execute() ) {
                    throw new Exception('No delete');
                }

            } catch (Exception $e) {
                $code = 1;
                $errMessage[] = "Unable to delete car by id " . $id; // . ", reason: " . $e->getMessage();
            }

            return [
                'code' => $code,
                'message' => $errMessage
            ];
        }
    }
