<?php

/**
 * aign_analytics.php
 *
 * Sponsored by David Eschelbacher, MD
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    Rod Roark <rod@sunsetsystems.com>
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @author    Jerry Padgett <sjpadgett@gmail.com>
 * @copyright Copyright (c) 2012-2016 Rod Roark <rod@sunsetsystems.com>
 * @copyright Copyright (c) 2018 Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2019 Jerry Padgett <sjpadgett@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

require_once(dirname(__FILE__) . "/../../globals.php");
require_once "$srcdir/user.inc.php";
require_once "$srcdir/options.inc.php";

use OpenEMR\Common\Acl\AclMain;
use OpenEMR\Common\Csrf\CsrfUtils;
use OpenEMR\Core\Header;
use OpenEMR\OeUI\OemrUI;

// Generate some code based on the list of columns.
//

$loading = "<div class='spinner-border' role='status'><span class='sr-only'>" . xlt("Loading") . "...</span></div>";
?>
<!DOCTYPE html>
<html>
<head>
    <?php Header::setupHeader(['datatables', 'datatables-colreorder', 'datatables-dt', 'datatables-bs']); ?>
    <title><?php echo xlt("Analytics"); ?></title>
    <link rel="stylesheet" href="<?php echo $webroot; ?>/public/themes/aign_style.css?v=<?php echo $v_js_includes; ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wordcloud2.js/1.0.1/wordcloud2.min.js"></script>
    

<?php
    $arrOeUiSettings = array(
    'heading_title' => xl('Analytics'),
    'include_patient_name' => false,
    'expandable' => true,
    'action' => "search",//conceal, reveal, search, reset, link or back
    'action_title' => "",//only for action link, leave empty for conceal, reveal, search
    'action_href' => "",//only for actions - reset, link or back
    'show_help_icon' => false,
    'help_file_name' => ""
    );
    $oemr_ui = new OemrUI($arrOeUiSettings);
    ?>
    <!-- <script src="Chart.min.js"></script> -->
    <!-- <script src="chart-pie.js"></script> -->
    <style>
        #loader {
            display: none;
        }
        #word-cloud {
            width: 400px;
            height: 400px;
        }
    </style>
</head>
<body>
    <div id="container_div" class="<?php echo attr($oemr_ui->oeContainer()); ?> mt-3">
         <div class="container-fluid w-100">
            <?php echo $oemr_ui->pageHeading() . "\r\n"; ?>

            <div class="row">

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Patients (Monthly)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">4</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Total Patients (Annual)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">15</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Reports Pending
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pending Requests</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comment-dots fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>

            <div class="row">

            <div id="symptoms-container" class="col-xl-8 col-lg-8"> </div>
            <div id="word-cloud" class="col-xl-4 col-lg-4"></div>
            <div id="loader">Loading...</div>


            
           
    </div> <!--End of Container div-->
    <?php $oemr_ui->oeBelowContainerDiv();?>

<script>
$(document).ready(function() {
    function getColor(clusterIndex) {
        var colors = ['danger', 'warning', 'success', 'info', 'primary'];
        return colors[clusterIndex];
    }

    function fetchDataAndGenerateDivs() {
        $('#loader').show();
        $.ajax({
            url: 'http://3.236.189.236:5000/analytics/clusters',
            type: 'GET',
            dataType: 'json',
            data:{},
            success: function(response) {
                $('#loader').hide();

                var maxAriaValueMax = Math.max.apply(Math, response.data.map(function(item) {
                    return parseInt(item.clusterCount);
                }));

                response.data.forEach(function(symptomData) {
                    var symptomDiv = `
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">${symptomData.symptom}</h6>
                            </div>
                            <div class="card-body">
                                <h4 class="small font-weight-bold">${symptomData.symptom} <span class="float-right">${symptomData.clusterCount}</span></h4>
                                <div class="progress mb-4">
                                    <div class="progress-bar bg-${getColor(symptomData.clusterIndex)}" role="progressbar" style="width: ${symptomData.clusterCount}%" aria-valuenow="${symptomData.clusterCount}" aria-valuemin="0" aria-valuemax="${maxAriaValueMax}"></div>
                                </div>
                            </div>
                        </div>
                    `;

                    $('#symptoms-container').append(symptomDiv);
                });
            },
            error: function(error) {
                console.error('Error fetching data:', error);
                $('#loader').hide();
            }
        });
    }

    function fetchDataAndGenerateWordCloud() {
        $('#loader').show();
        $.ajax({
            url: 'http://3.236.189.236:5000/analytics/isolation',
            type: 'GET',
            dataType: 'json',
            data:{},
            success: function(response) {
                $('#loader').hide();
                var data = response.data;
                WordCloud(document.getElementById('word-cloud'), {
                    list: data,
                    gridSize: 8,
                    weightFactor: 5,
                    fontFamily: 'Arial, sans-serif',
                    color: 'random-dark',
                    backgroundColor: '#fff'
                });
            },
            error: function(error) {
                $('#loader').hide();
                console.error('Error fetching data:', error);
            }
        });
    }

    fetchDataAndGenerateWordCloud();
    fetchDataAndGenerateDivs();
});
</script>
</body>
</html>
