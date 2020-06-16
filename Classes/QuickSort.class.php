<?php 
function quickSort($array,$ini,$fim) {

	        $trocas = 0;
        $comparacoes = 0;
        $i = $ini; 
        $j = $fim;
        $pivoArr = $array[($ini + ($fim)) / 2]; //escolha arbitrária do pivô

        while ($i < $j) { //até i e j se cruzarem
            while ($array[$i]['qtd_votos'] < $pivoArr['qtd_votos']) { //percorre a partir do início
                $i++;
            }
            while ($array[$j]['qtd_votos'] > $pivoArr['qtd_votos']) { //percorre a partir do fim
                $j--;
            }
            $comparacoes++;
            
            if ($i <= $j) {

                $valArr = $array[$i];
                $array[$i] = $array[$j];
                $array[$j] = $valArr;
                $i++;
                $trocas++;
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
    }