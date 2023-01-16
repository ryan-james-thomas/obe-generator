<?php

class outClass {
    public $id;
    public $type;
    public $data;
    
    public function __construct($id="",$data="",$type="html") {
        $this->id = $id;
        $this->data = $data;
        $this->type = $type;
    }
}   //end outClass

class jsOutArray {
    protected $entries;
    protected $numEntries;
    
    public function __construct($id="",$val="",$type="html") {
        $this->entries = array();
        $this->numEntries = 0;
        if ($id !== "") {
            $this->entries[] = new outClass($id,$val,$type);
            $this->numEntries = 1;
        }
    }   //end __construct
    
    public function getEntries() {
        return $this->entries;
    }   //end getEntries
    
    public function addOutput($id="",$val="",$type="html") {
        $this->entries[] = new outClass($id,$val,$type);
        $this->numEntries = sizeof($this->entries);
    }   //end addOutput
    
    public function addOutClass($out) {
        if (is_a($out,"outClass") === true) {
            $this->entries[] = $out;
        }
        $this->numEntries = sizeof($this->entries);
    }   //end addOutClass
    
    public function printToJSON() {
        print json_encode($this->entries);
    }   //end printToJSON
}   //end jsOutArray

?>