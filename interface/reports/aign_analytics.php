<?php

/**
 * aign_analytics.php
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    Jacob T Paul <jacob@zhservices.com>
 * @author    Vinish K <vinish@zhservices.com>
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2015 Z&H Consultancy Services Private Limited <sam@zhservices.com>
 * @copyright Copyright (c) 2018 Brady Miller <brady.g.miller@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

require_once("../globals.php");
require_once("$srcdir/patient.inc.php");
require_once "$srcdir/options.inc.php";

use OpenEMR\Core\Header;
use OpenEMR\Menu\PatientMenuRole;
use OpenEMR\OeUI\OemrUI;

$records1 = array();
$records2 = array();
?>
<html>
    <head>
        <?php Header::setupHeader();?>
        <title><?php echo xlt('External Data'); ?></title>
        <script><?php require_once("$include_root/patient_file/erx_patient_portal_js.php"); // jQuery for popups for eRx and patient portal ?></script>
        <?php
        $arrOeUiSettings = array(
            'heading_title' => xl('External Data'),
            'include_patient_name' => true,
            'expandable' => false,
            'action' => "",//conceal, reveal, search, reset, link or back
            'action_title' => "",
            'action_href' => "",//only for actions - reset, link or back
            'show_help_icon' => false,
        );
        $oemr_ui = new OemrUI($arrOeUiSettings);
        ?>
    </head>
    <body>
        <div id="container_div" class="<?php echo $oemr_ui->oeContainer();?> mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    require_once("$include_root/patient_file/summary/dashboard_header.php")
                    ?>
                </div>
            </div>
            <?php
            $list_id = "aign_analytics"; // to indicate nav item is active, count and give correct id
            // Collect the patient menu then build it
            $menuPatient = new PatientMenuRole();
            $menuPatient->displayHorizNavBarMenu();
            ?>
            <div class="row mt-3">
                <div class="col-sm-12 mt-3">
                       
                <p> Analytics Content goes </p>
                            
                </div>
            </div>
        </div><!--end of container div-->
        <?php $oemr_ui->oeBelowContainerDiv();?>
    </body>
</html>
