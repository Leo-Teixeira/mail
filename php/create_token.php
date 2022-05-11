<?php
    /*
        emannuelbarteaux@mail.com
        Emannuel@1234
    */
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    $data = json_decode(file_get_contents("../json/data.json"), true);

    /* Create tokens */
    $tokens = array();
    while(count($tokens) < count($data))
    {
        do
            $token = rand(0, 999999);
        while(in_array($token, $tokens));
        array_push($tokens, $token);
    }

    /* Assign tokens */
    foreach($data as $key => $value)
    {
        $data[$key] = array_pop($tokens);
    }

    var_dump($data);

    /* Save ad json */
    file_put_contents("../json/final.json", json_encode($data));
?>