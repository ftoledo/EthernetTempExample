<?php
require 'flight/Flight.php';

Flight::route('/', function(){
    Flight::render('index');
});


Flight::route('/api/@key/temp/@temp', function($key, $temp){

    /* check key access or forbidden */
    if ($key != '123456') {
        Flight::redirect("/noaccess", 403);
    }

    // Open file for append
    $f = fopen("data.csv","a+");

    if ($f === FALSE) {
	die ("Error al abrir el archivo");
    }


    $data = array(
        date('Y-m-d H:i:s'),
        $temp,
    );

    // wirte csv data to file
    if(fputcsv($f, $data, ';','"') !== FALSE) {

        print ("OK");
        fclose($f);
    }
    else {
	die ("Error writing the data file");
    }

});


Flight::route('/stats', function(){
    Flight::render('stats');
});

Flight::route('/noaccess', function(){

    print ("Access denied - Invalid key");

});

Flight::start();
?>
