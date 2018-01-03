<?php

function checkLoginType() {

    $CI = & get_instance();
    $CI->load->model('general_model');
    $currentModule = $CI->uri->segment('1');

    /* PAGE PERMISSION */
    $displayData = $CI->general_model->checkType($CI->session->userdata['ADMINTYPE'], $currentModule);
    if (!empty($displayData)) {
        // CHECK USER HAS PERMISSION TO VIEW CURRENT MODULE
        if ($displayData['eSelect'] == 'Yes' && $displayData['vModuleName'] == $currentModule) {

            $currentModuleType = $CI->uri->segment('2');
            $currentModuleID = $CI->uri->segment('3');
            $currentValue = $CI->uri->segment('4');

            // CHECK USER HAS PERMISSION TO ADD CURRENT MODULE
            if($currentModuleType == 'add' && !isset($currentModuleID)) {
                
                if($displayData['eInsert'] == 'Yes') {
                    return $displayData;
                } else {
                    redirect($currentModule);
                }
            // CHECK USER HAS PERMISSION TO UPDATE CURRENT MODULE
            } else if($currentModuleType == 'add' && isset($currentModuleID)) {

                if($displayData['eUpdate'] == 'Yes') {
                    return $displayData;
                } else {
                    redirect($currentModule);
                }
            } else {
                return $displayData;
            }
            // echo "<pre>"; print_r($displayData); exit;
        }  else if ($displayData['eSelect'] == 'No' && $displayData['eUpdate'] == 'Yes' && $displayData['vModuleName'] == $currentModule) {

            /* ONLY EDIT RECORD PERMISSION FOR SUB ADMIN */
            $currentModuleType = $CI->uri->segment('2');
            $currentModuleID = $CI->uri->segment('3');
            $currentValue = $CI->uri->segment('4');

            if ($displayData['eUpdate'] == 'Yes' && !empty($currentModuleType) && !empty($currentModuleID) && !empty($currentValue) ) {
                //  NEW FOR DISPLAY FORM ONLY                
                return $displayData;
            } else {
                return 0;
            }
                
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}

?>