<?php

// if ($hassiteconfig) { // needs this condition or there is error on login page

//     $ADMIN->add('localplugins', new admin_category('powerschool', get_string('pluginname', 'local_powerschool')));

//     $settings = new admin_settingpage('local_powerschool', get_string('pluginname', 'local_powerschool'));
//     $ADMIN->add('powerschool', $settings);

//     $settings->add(new admin_setting_configcheckbox('local_powerschool/enabled',
//         get_string('setting_enable', 'local_powerschool'), get_string('setting_enable_desc', 'local_powerschool'), '1'));

//     $ADMIN->add('local_powerschool_category', new admin_externalpage('local_powerschool_manage', get_string('index', 'local_powerschool'),
//         $CFG->wwwroot . '/local/powerschool/index.php'));
// }

if($hassiteconfig) {
    $ADMIN->add('root',new admin_category('powerschool', 'powerschool'));

    $ADMIN->add('powerschool',new admin_externalpage('index',get_string('reglages', 'local_powerschool')
    ,new moodle_url ('/local/powerschool/index.php')));

    $ADMIN->add('powerschool',new admin_externalpage('index',get_string('gerer', 'local_powerschool')
    ,new moodle_url ('/local/powerschool/index.php')));

    $ADMIN->add('powerschool',new admin_externalpage('inscription',get_string('gestinscription', 'local_powerschool')
    ,new moodle_url ('/local/powerschool/anneescolaire.php'))); 

    $ADMIN->add('powerschool',new admin_externalpage('gestprof',get_string('gerer', 'local_powerschool')
    ,new moodle_url ('/local/powerschool/anneescolaire.php'))); 

    $ADMIN->add('powerschool',new admin_externalpage('anneescolaire',get_string('gerer', 'local_powerschool')
    ,new moodle_url ('/local/powerschool/anneescolaire.php'))); 

}


