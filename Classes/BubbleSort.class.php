<?php
$trocas;

function bubbleSort($array)
{

  $start = microtime(true);

  for ($i = 0; $i < count($array); $i++) {
    for ($j = 0; $j < count($array) - 1; $j++) {
      if ($array[$j]['qtd_votos'] > $array[$j + 1]['qtd_votos']) {
        $aux = $array[$j];
        $array[$j] = $array[$j + 1];
        $array[$j + 1] = $aux;
      }
    }
  }


  $array['BubbleSort']["tempo"] = 'Tempo de execução ' . (number_format((microtime(true) - $start), 4)) . ' segundos';



  return $array;
}
