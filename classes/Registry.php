<?php
    Class Registry implements ArrayAccess{
        private $vars = array();
        
        function offsetSet($key, $var){
            if (isset($this->vars[$key]) == true) {
                throw new Exception("Unable to set var '" . $key . "'. Already set.");
            }
            $this->vars[$key] = $var;
            return true;
        }
        
        function offsetGet($key){
            if (isset($this->vars[$key]) == false) {
                return null;
            }
            return $this->vars[$key];
        }
        
        function offsetUnset($var){
            unset($this->vars[$key]);
        }
        
        function offsetExists($var){
        }
    }
?>