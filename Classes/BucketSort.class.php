<?php


function BucketSort(&$array)
{
    $min = $array[0];
    $max = $array[0];
    $arrayLength = count($array);
    for ($i = 1; $i < $arrayLength; $i++) {
        if ($array[$i] > $max)
            $max = $array[$i];
        if ($array[$i] < $min)
            $min = $array[$i];
    }
    $bucket = array();
    $bucketLength = $max - $min + 1;
    for ($i = 0; $i < $bucketLength; $i++) {
        $bucket[$i] = array();
    }
    for ($i = 0; $i < $arrayLength; $i++) {
        array_push($bucket[$array[$i] - $min], $array[$i]);
    }
    $k = 0;
    for ($i = 0; $i < $bucketLength; $i++) {
        $bucketCount = count($bucket[$i]);
        if ($bucketCount > 0) {
            for ($j = 0; $j < $bucketCount; $j++) {
                $array[$k] = $bucket[$i][$j];
                $k++;
            }
        }
    }
}
