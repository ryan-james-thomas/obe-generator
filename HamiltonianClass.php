<?php

require_once("OutputClass.php");

class Hamiltonian {
    public $nDim;
    public $entries;
    
    public function __construct($nDim=2) {
        $this->nDim = $nDim;
        $this->entries = array_fill(0,$nDim,array_fill(0,$nDim,0));
    }   //end __construct
    
    public function resetEntries() {
        $this->entries = array_fill(0,$this->nDim,array_fill(0,$this->nDim,0));
    }   //end resetEntries
    
    
    public function makeTable() {
        $class="entries";
        $html = "<table id=\"entryTable\" class=\"$class\">\n";
        foreach ($this->entries as $kr=>$row) {
            $html .= "<tr class=\"$class\">\n";
            foreach ($row as $kc=>$col) {
$html .= <<<HERE
<td class="$class">
    <input type="text" id="entry_{$kr}_{$kc}" class="$class" value="$col"/>
</td>
HERE;
            }
            $html .= "</tr>\n";
        }
        $html .= "</table>";
        return $html;
    }
    
    public function readValues($vals) {
        $c = 0;
        for ($n=0;$n<$this->nDim;$n++) {
            for ($m=0;$m<$this->nDim;$m++) {
                $this->entries[$n][$m] = $vals[$c++];
            }
        }
    }   //end readValues
    
    public function makeString($n,$m) {
        $arr = array_fill(0,2*$this->nDim,"");
        for ($j=0;$j<$this->nDim;$j++) {
            $V = $this->entries[$j][$m];
            //print "$V $j $m " . (($V == "0")?"yes":"no") . "\n";
            if ($V != "0") {
                $arr[2*$j] = "$V\\rho_{ $n$j}";
            }
            $V = $this->entries[$n][$j];
            //print "$V $n $j " . (($V == 0)?"yes":"no") . "\n";
            if ($V != "0") {
                $arr[2*$j+1] = "-$V\\rho_{ $j$m}";
            }
        }
        //var_dump($arr);
        foreach ($arr as &$a) {
            $a = preg_replace("#^\-\-#","",$a);
            if (preg_match("#^\-#",$a) === 1) {
                $a = preg_replace("#^\-#","-i",$a);
            } elseif (strlen($a) != 0) {
                $a = "i" . $a;
            }
        }
        //var_dump($this->entries);
        $s = "";
        for ($i=0;$i<sizeof($arr);$i++) {
            $e = $arr[$i];
            if (strlen($e) == 0) {
                continue;
            }
            $eSign = preg_match("#^\-#",$e);
            $eFilt = preg_replace("#^\-#","",$e);
            $s2 = "";
            $flag = false;
            for ($j=$i+1;$j<sizeof($arr);$j++) {
                $f = $arr[$j];
                if (strlen($f) == 0) {
                    continue;
                }
                $fSign = preg_match("#^\-#",$f);
                $fFilt = preg_replace("#^\-#","",$f);
                if ($eFilt != $fFilt) {
                    continue;
                } elseif ($fSign != $eSign) {
                    $arr[$j] = "";
                    $arr[$i] = "";
                    $flag = true;
                    break;
                } elseif ($fSign === 0) {
                    //No negative sign
                    $arr[$i] = "2".$eFilt;
                    $arr[$j] = "";
                    $s2 .= " + 2".$eFilt;
                    $flag = true;
                    break;
                } elseif ($fSign === 1) {
                    //Negative sign
                    $arr[$i] = "-2".$eFilt;
                    $arr[$j] = "";
                    $s2 .= " - 2".$eFilt;
                    $flag = true;
                    break;
                }
            }
            if (!$flag) {
                if ($eSign === 0) {
                    $s2 = " + $eFilt";
                } else {
                    $s2 = " - $eFilt";
                }
                //$s2 = $eFilt;
            }
            $s .= $s2;
        }
        if (strlen($s) == 0) {
            $s = 0;
        }
        return "\\dot{\\rho}_{ $n$m} = $s";
    }   //end makeString
    
    public function makeOBETable() {
        $html = "<table id=\"obeTable\">\n";
        for ($n=0;$n<$this->nDim;$n++) {
            for ($m=$n;$m<$this->nDim;$m++) {
                $s = $this->makeString($n,$m);
                //print $s."\n";
                $html .= "<tr><td>\\($s\\)</td></tr>\n";
            }
        }
        $html .= "</table>\n";
        return $html;
    }   //end makeOBETable
    
}   //end class Hamiltonian


?>