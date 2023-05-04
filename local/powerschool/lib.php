<?php
// This file is part of Moodle Course Rollover Plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package     local_powerschool
 * @author      wilfried
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function  local_powerschool_extend_navigation (global_navigation $navigation ){
      

    
        $tabcampus=[
        "Gestion Campus"=>'/local/powerschool/campus.php',
        // "New"=>'/local/powerschool/campus/savecampus.php'
        ];
        
        $tabinsc=[
        "Gestion Inscription"=>'/local/powerschool/inscription.php',
        // "New"=>'/local/powerschool/inscription/saveinscription.php'

        ];
        
        $tabsalle=[
        "Gestion Salle"=>'/local/powerschool/salle.php',
        // "New"=>'/local/powerschool/salle/savesalle.php'
        ];
        
        $tabannee=[
        "Gestion Annee Scolaire"=>'/local/powerschool/anneescolaire.php',
        // "New"=>'/local/powerschool/anneescolaire.php'
        ];
        
        // $tabspecialite=[
        // "Liste"=>'/local/powerschool/specialite/listspecialite.php',
        // "New"=>'/local/powerschool/specialite/savespecialite.php'
        // ];

        $tabcycle=[
            "Gestion Cycle"=>'/local/powerschool/cycle.php',
            // "New"=>'/local/powerschool/cycle/savecycle.php'
        ];
        $tabmat=[
            "Gestion Filiere"=>'/local/powerschool/filiere.php',
            // "New"=>'/local/powerschool/filiere/savefiliere.php'
        ];
        $tabsean=[
            "Gestion Séance"=>'/local/powerschool/seance.php',
            // "New"=>'/local/powerschool/seance/saveseance.php'
        ];
         
        $nodefoo = $navigation->add("powerschool",null, null, null, 'home', null, '');
        $nodefo=$nodefoo->add('Campus');
        foreach($tabcampus as $key=> $pro){
           
                  $nodebar=$nodefo->add($key, new moodle_url($pro),null,null,'Professeur',new pix_icon('i/course', ''));
               $nodebar->forceopen=true;
            
          
        }
    if(isloggedin()){
         $nodefo=$nodefoo->add('Filiere');
        foreach($tabmat as $key=> $pro){
            
            $nodebar=$nodefo->add($key, new moodle_url($pro),null,null,'Seance',new pix_icon('i/course', ''));
            
            $nodebar->forceopen=true;
        }
    
        
         $nodefo=$nodefoo->add('Seance');
        foreach($tabsean as $key=> $pro){
            
            $nodebar=$nodefo->add($key, new moodle_url($pro),null,null,'Matiere',new pix_icon('i/course', ''));
            
            $nodebar->forceopen=true;
        }
    }

    $nodefo=$nodefoo->add('Cycle');
    foreach($tabcycle as $key=> $pro){
        
        $nodebar=$nodefo->add($key, new moodle_url($pro),null,null,'Matiere',new pix_icon('i/course', ''));
        
        $nodebar->forceopen=true;
    }

    $nodefo=$nodefoo->add('Salle');
    foreach($tabsalle as $key=> $pro){
        
        $nodebar=$nodefo->add($key, new moodle_url($pro),null,null,'Matiere',new pix_icon('i/course', ''));
        
        $nodebar->forceopen=true;
    }
    
    // $nodefo=$nodefoo->add('Specialité');
    // foreach($tabspecialite as $key=> $pro){
        
    //     $nodebar=$nodefo->add($key, new moodle_url($pro),null,null,'Matiere',new pix_icon('i/course', ''));
        
    //     $nodebar->forceopen=true;
    // }
    
    $nodefo=$nodefoo->add('Annee');
    foreach($tabannee as $key=> $pro){
        
        $nodebar=$nodefo->add($key, new moodle_url($pro),null,null,'Matiere',new pix_icon('i/course', ''));
        
        $nodebar->forceopen=true;
    }
    $nodefo=$nodefoo->add('Inscription');
    foreach($tabinsc as $key=> $pro){
        
        $nodebar=$nodefo->add($key, new moodle_url($pro),null,null,'Matiere',new pix_icon('i/course', ''));
        
        $nodebar->forceopen=true;
    }

   

}
// function  local_powerschool_extend_navigation_user(global_navigation $na){
    
//     $nodefoo=$na->add("Power Eduque", new moodle_url('/'),
//     null, null, 'home', new pix_icon('i/course', ''));
//     $nodefo=$nodefoo->add('Professeur');
//     $nodebar=$nodefo->add("Nom", new moodle_url('/'),null,null,'Professeur',new pix_icon('i/course', ''));
//     $nodebar->forceopen=true;
    
// }


// function  local_powerschool_extend_settings_navigation ( $settingsnav ,  $context ){ 
//     global $CFG;
//     if (( $context -> contextlevel  ===  50 )  && 
//         has_capability ( 'gradereport/grader:view' ,  $context )){ 
//         $id  =  $context -> instanceid ; 
//         $urltext  =  get_string ( 'power' ,  'powerschool' ); 
//         $url  =  new  moodle_url ( $CFG -> wwwroot  . '/grade/report/grader/index.php' ,  array ( 'id' => $id )); 
//         $coursesettingsnode  =  $settingsnav -> find ( 'courseadmin' ,  null );    // 'courseadmin' est la clé du menu 
//         $node  =  $coursesettingsnode -> create( "power" ,  $url ,  navigation_node :: NODETYPE_LEAF ,  null ,  null ,   new  pix_icon ( 'i/report' ,  'grades' ));
//         $coursesettingsnode -> add_node ( $node ,   'gradebooksetup' );  //'gradebooksetup' est un endroit où vous placez le lien avant 
//     } 
// }

function power_get_user_navigation_options($context, $course = null) {
    global $CFG, $USER;

    $isloggedin = isloggedin();
    $isguestuser = isguestuser();
    $isfrontpage = $context->contextlevel == CONTEXT_SYSTEM;

    if ($isfrontpage) {
        $sitecontext = $context;
    } else {
        $sitecontext = context_system::instance();
    }

    // Sets defaults for all options.
    $options = (object) [
        'matiere' => false,
        'blogs' => false,
        'competencies' => false,
        'grades' => false,
        'notes' => false,
        'participants' => false,
        'search' => false,
        'tags' => false,
    ];

    // $options->blogs = !empty($CFG->enableblogs) &&
    //                     ($CFG->bloglevel == BLOG_GLOBAL_LEVEL ||
    //                     ($CFG->bloglevel == BLOG_SITE_LEVEL and ($isloggedin and !$isguestuser)))
    //                     && has_capability('moodle/blog:view', $sitecontext);

    // $options->notes = !empty($CFG->enablenotes) && has_any_capability(array('moodle/notes:manage', 'moodle/notes:view'), $context);
$options->matiere= !empty($CFG->enableblogs) &&
                        ($CFG->bloglevel == BLOG_GLOBAL_LEVEL ||
                        ($CFG->bloglevel == BLOG_SITE_LEVEL and ($isloggedin and !$isguestuser)))
                        && has_capability('moodle/blog:view', $sitecontext);
    // Frontpage settings?
    if ($isfrontpage) {
        // We are on the front page, so make sure we use the proper capability (site:viewparticipants).
        $options->matiere = course_can_view_participants($sitecontext);
        $options->badges = !empty($CFG->enablebadges) && has_capability('moodle/badges:viewbadges', $sitecontext);
        $options->tags = !empty($CFG->usetags) && $isloggedin;
        $options->search = !empty($CFG->enableglobalsearch) && has_capability('moodle/search:query', $sitecontext);
    } else {
        // We are in a course, so make sure we use the proper capability (course:viewparticipants).
        $options->matiere = course_can_view_participants($context);

        // Only display badges if they are enabled and the current user can manage them or if they can view them and have,
        // at least, one available badge.
        // if (!empty($CFG->enablebadges) && !empty($CFG->badges_allowcoursebadges)) {
        //     $canmanage = has_any_capability([
        //             'moodle/badges:createbadge',
        //             'moodle/badges:awardbadge',
        //             'moodle/badges:configurecriteria',
        //             'moodle/badges:configuremessages',
        //             'moodle/badges:configuredetails',
        //             'moodle/badges:deletebadge',
        //         ],
        //         $context
        //     );
        //     $totalbadges = [];
        //     $canview = false;
        //     if (!$canmanage) {
        //         // This only needs to be calculated if the user can't manage badges (to improve performance).
        //         $canview = has_capability('moodle/badges:viewbadges', $context);
        //         if ($canview) {
        //             require_once($CFG->dirroot.'/lib/badgeslib.php');
        //             if (is_null($course)) {
        //                 $totalbadges = count(badges_get_badges(BADGE_TYPE_SITE, 0, '', '', 0, 0, $USER->id));
        //             } else {
        //                 $totalbadges = count(badges_get_badges(BADGE_TYPE_COURSE, $course->id, '', '', 0, 0, $USER->id));
        //             }
        //         }
        //     }

        //     $options->badges = ($canmanage || ($canview && $totalbadges > 0));
        // }
        // Add view grade report is permitted.
        // $grades = false;

        // if (has_capability('moodle/grade:viewall', $context)) {
        //     $grades = true;
        // } else if (!empty($course->showgrades)) {
        //     $reports = core_component::get_plugin_list('gradereport');
        //     if (is_array($reports) && count($reports) > 0) {  // Get all installed reports.
        //         arsort($reports);   // User is last, we want to test it first.
        //         foreach ($reports as $plugin => $plugindir) {
        //             if (has_capability('gradereport/'.$plugin.':view', $context)) {
        //                 // Stop when the first visible plugin is found.
        //                 $grades = true;
        //                 break;
        //             }
        //         }
        //     }
        // }
        // $options->grades = $grades;
    }

    // if (\core_competency\api::is_enabled()) {
    //     $capabilities = array('moodle/competency:coursecompetencyview', 'moodle/competency:coursecompetencymanage');
    //     $options->competencies = has_any_capability($capabilities, $context);
    // }
    return $options;
}




function groups_get_power_group($course, $update=false, $allowedgroups=null) {
    global $USER, $SESSION;

    if (!$groupmode = $course->groupmode) {
        // NOGROUPS used
        return false;
    }

    $context = context_course::instance($course->id);
    if (has_capability('moodle/site:accessallgroups', $context)) {
        $groupmode = 'aag';
    }

    if (!is_array($allowedgroups)) {
        if ($groupmode == VISIBLEGROUPS or $groupmode === 'aag') {
            $allowedgroups = groups_get_all_groups($course->id, 0, $course->defaultgroupingid);
        } else {
            $allowedgroups = groups_get_all_groups($course->id, $USER->id, $course->defaultgroupingid);
        }
    }

    _group_verify_activegroup($course->id, $groupmode, $course->defaultgroupingid, $allowedgroups);

    // set new active group if requested
    $changegroup = optional_param('group', -1, PARAM_INT);
    if ($update and $changegroup != -1) {

        if ($changegroup == 0) {
            // do not allow changing to all groups without accessallgroups capability
            if ($groupmode == VISIBLEGROUPS or $groupmode === 'aag') {
                $SESSION->activegroup[$course->id][$groupmode][$course->defaultgroupingid] = 0;
            }

        } else {
            if ($allowedgroups and array_key_exists($changegroup, $allowedgroups)) {
                $SESSION->activegroup[$course->id][$groupmode][$course->defaultgroupingid] = $changegroup;
            }
        }
    }

    return $SESSION->activegroup[$course->id][$groupmode][$course->defaultgroupingid];
}