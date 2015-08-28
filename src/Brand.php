<?php
    class Brand {
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
            $GLOBALS["DB"]->exec("INSERT INTO brands (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS["DB"]->lastInsertId();
        }

        static function getAll() {
            $raw_all = $GLOBALS["DB"]->query("SELECT * FROM brands;");
            $all = array();
            foreach($raw_all as $brand) {
                $name = $brand["name"];
                $id = $brand["id"];
                $new_brand = new Brand($name, $id);
                array_push($all, $new_brand);
            }
            return $all;
        }

        static function deleteAll() {
            $GLOBALS["DB"]->exec("DELETE FROM brands;");
        }



    }
?>