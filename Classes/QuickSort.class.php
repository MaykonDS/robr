<?php 
/*function quickSort($array,$ini,$fim) {

	        $trocas = 0;
        $comparacoes = 0;
        $i = $ini; 
        $j = $fim;
        $pivoArr = $array[($ini + ($fim)) / 2]['qtd_votos']; //escolha arbitrária do pivô
       
        
        while ($i < $j) { //até i e j se cruzarem
            while ($array[$i]['qtd_votos'] < $pivoArr) { //percorre a partir do início
              
                
                $i++;
            }
            while ($array[$j]['qtd_votos'] > $pivoArr) { //percorre a partir do fim
               
                $j--;
            }
            
            
            if ($i <= $j) {

                $valArr = $array[$i];
                $array[$i] = $array[$j];
                $array[$j] = $valArr;
                $i++;
                $j--;


            }
            echo $i."  ".$j."  ". $ini."  ".$fim."<br>";
            for($k = 0; $k < count($array); $k++){
            echo " " .$array[$k]['qtd_votos'] . " <br> ";

        }
        echo " <br> ";
        }
        
       $trocas = 0 ;
        
        if ($ini < $j) {
            echo $ini."  ".$j."<br>";
             quickSort($array,$ini, $j);
        }

        if ($i < $fim) {
             echo $i."  ".$j."<br>";
             quickSort($array, $i, $fim);
        }

    

        
     return $array;
    }

function quickSort($array,$ini,$fim) {

            $trocas = 0;
        $comparacoes = 0;
        $i = $ini; 
        $j = $fim;
        $pivoArr = $array[($ini + ($fim)) / 2]; //escolha arbitrária do pivô
       
        
        while ($i < $j) { //até i e j se cruzarem
            while ($array[$i] < $pivoArr) { //percorre a partir do início
              
                
                $i++;
            }
            while ($array[$j] > $pivoArr) { //percorre a partir do fim
               
                $j--;
            }
            
            
            if ($i <= $j) {

                $valArr = $array[$i];
                $array[$i] = $array[$j];
                $array[$j] = $valArr;
                $i++;
                $j--;


            }
            
        }
        
       $trocas = 0 ;
        
        if ($ini < $j) {
            
             quickSort($array,$ini, $j);
        }

        if ($i < $fim) {
             
             quickSort($array, $i, $fim);
        }

    

        
     return $array;
    }*/


    function quicksort($array)
    {
        if (@count($array) == 0)
            return array();
 
        $pivot_element = $array[0];
        $left_element = $right_element = array();
 
        for ($i = 1; $i < count($array); $i++) {
            if ($array[$i] <$pivot_element)
                $left_element[] = $array[$i];
            else
                $right_element[] = $array[$i];
        }
 
        return array_merge(quicksort($left_element), array($pivot_element), quicksort($right_element));
    }
 
    @$sorted_numbers = quicksort($unsorted_numbers);
 
    print_r($sorted_numbers);

