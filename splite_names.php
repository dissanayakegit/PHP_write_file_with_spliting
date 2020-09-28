<?php

$file = fopen("test.txt", "r");

$file_with_fl = fopen("fileWithFL.txt", "w+");
$file_without_fl = fopen("fileWithoutFL.txt", "w+");

$file_with_fl2 = fopen("fileWithFL2.txt", "w+");


while ($a = fgetcsv($file)) {
    if (FALSE == strpos($a[2], '(') && FALSE == strpos($a[2], '/')) {
        fputcsv($file_without_fl, $a);
    } elseif (FALSE == strpos($a[2], '/')) {
        preg_match('#\((.*?)\)#', $a[2], $match);
        $x = trim(preg_replace("/\([^)]+\)/","",$a[2]));
        $a[2] = $x;        
        fputcsv($file_with_fl2, $a);

        $a[2] = $match[1];
        fputcsv($file_with_fl2, $a);
    } else {
        $cities = preg_split('/[\(\/]/', $a[2]);
        foreach ($cities as $city) {
            $city = trim(preg_replace('/\)/', '', $city)); // Remove trailing ')'
            // echo "$city\n";
            $a[2] = $city;
            fputcsv($file_with_fl, $a);
        }
    }
}


