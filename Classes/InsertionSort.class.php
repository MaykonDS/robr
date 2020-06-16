<?php 

function insertionSort(&$arr, $n) 
{ 

  
    $start = microtime(true);


    for ($i = 1; $i < $n; $i++) 
    { 
        $key = $arr[$i]; 
        $j = $i-1; 
      
        // Move elements of arr[0..i-1], 
        // that are    greater than key, to  
        // one position ahead of their  
        // current position 
        while ($j >= 0 && $arr[$j]['qtd_votos'] > $key['qtd_votos']) 
        { 
            $arr[$j + 1] = $arr[$j]; 
            $j = $j - 1; 
        } 
          
        $arr[$j + 1] = $key; 
    }

   
     $arr['InsertionSort']["tempo"] = 'Tempo de execução '.(number_format((microtime(true) - $start),4)).' segundos';


    return $arr;


} 