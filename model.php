<?php
    class Model {
        public function __get($varName) {
            if (!isset($varName)) {
                return NULL;
            }
        }
        public function all() {
            return get_object_vars($this);
        }
    }
?>