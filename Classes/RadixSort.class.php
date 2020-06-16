<?php

function radixSort($arr, $n)  
{       $A = [];
	    $k = ((String) max($arr));
		$k = strlen($k);
		for($i = 0 ; $i <$n; $i++){
			$numero = $arr[$i];
			while(strlen($numero) < $k){
              $numero = "0".$numero;
			}
			$arr[$i] = $numero;
		}

	    for($i = ($k - 1) ; $i>=0; $i--){
           for($j = 0;$j < $n;$j++){
           	$A[$j] = substr((String) $arr[$j],$i,1);
            }
           $A = countingSort($A, $n, max($A));
                      $B =[];
           for($j = 0; $j < count($A); $j++){
             for($k = 0; $k < count($A); $k++){
             	if(($arr[$k] != null) && ($A[$j] ==  substr((String) $arr[$k],$i,1))){
                 $B[$j] = $arr[$k];
                 $arr[$k] = null; 
             	 break;
             	}
              }
           }

         $arr = $B;
	    }
       
     return $arr; 
} 