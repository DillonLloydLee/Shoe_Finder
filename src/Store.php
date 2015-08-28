<?php
    class Store {
        private $name;
        private $id;

        function __construct($name, $id = null) {
            $this->name = $name;
            $this->id = $id;
        }

        function setName($name) {
            $this->name = (string) $name;
        }

        function getName() {
            return $this->name;
        }

        function getId() {
            return $this->id;
        }

        function save() {
            $GLOBALS["DB"]->exec("INSERT INTO stores (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS["DB"]->lastInsertId();
        }

        static function getAll() {
            $raw_all = $GLOBALS["DB"]->query("SELECT * FROM stores;");
            $all = array();
            foreach($raw_all as $store) {
                $name = $store["name"];
                $id = $store["id"];
                $new_store = new Store($name, $id);
                array_push($all, $new_store);
            }
            return $all;
        }

        static function deleteAll() {
            $GLOBALS["DB"]->exec("DELETE FROM stores;");
        }



    }
?>
