<?php
$functions = array(
    'local_annee_delete_annee' => array(         //web service function name
        'classname'   => 'local_annee_external',  //class containing the external function OR namespaced class in classes/external/XXXX.php
        'methodname'  => 'supp_annee',          //external function name
        'classpath'   => 'local/powerschool/externallib.php',  //file containing the class/external function - not required if using namespaced auto-loading classes.
        'description' => 'Deletes a message',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
        'ajax' => true,        // is the service available to 'internal' ajax calls.
        'capabilities' => '', // comma separated list of capabilities used by the function.
    ),
);
