<?php

function selectionSort(&$arr, $n)  
{


	$start = microtime(true);

    for($i = 0; $i < $n ; $i++) 
    { 
        $low = $i; 
        for($j = $i + 1; $j < $n ; $j++) 
        { 
            if ($arr[$j]['qtd_votos'] < $arr[$low]['qtd_votos']) 
            { 
                $low = $j; 
            } 
        } 
          
        
        if ($arr[$i]['qtd_votos'] > $arr[$low]['qtd_votos']) 
        { 
            $tmp = $arr[$i]; 
            $arr[$i] = $arr[$low]; 
            $arr[$low] = $tmp; 
        } 
    } 


    
    
     $arr['SelectionSort']["tempo"] = 'Tempo de execução '.(number_format((microtime(true) - $start),4)).' segundos';

    return $arr;
} 