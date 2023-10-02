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
    <!-- <script src="https://pulipulichen.github.io/blogger/posts/2016/11/r-text-mining/wordcloud2.js"></script> -->
    <script src="https://d3js.org/d3.v5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3-cloud/1.2.7/d3.layout.cloud.js"></script>


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

            <div  class="col-xl-8 col-lg-8">
            <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Symptoms</h6>
                            </div> 
                            <div id="symptoms-container" class="card-body"></div>
                        </div>
            <div class="col-xl-4 col-lg-4">
            <!-- <canvas id="word-cloud" class="word-cloud" width="400" height="400"></canvas> -->
            <div id="word-cloud-container" style="width: 800px; height: 400px;"></div>
   
        </div>
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
            contentType: "application/json;",
            crossDomain: true,
            headers: {
                'Access-Control-Allow-Origin': '*',
            },
            success: function(response) {
                $('#loader').hide();

                var maxAriaValueMax = Math.max.apply(Math, response.data.map(function(item) {
                    return parseInt(item.clusterCount);
                }));

                response.data.forEach(function(symptomData) {
                    var symptomDiv = `
                                <h4 class="small font-weight-bold">${symptomData.symptom} <span class="float-right">${symptomData.clusterCount}</span></h4>
                                <div class="progress mb-4">
                                    <div class="progress-bar bg-${getColor(symptomData.clusterIndex)}" role="progressbar" style="width: ${symptomData.clusterCount}%" aria-valuenow="${symptomData.clusterCount}" aria-valuemin="0" aria-valuemax="${maxAriaValueMax}"></div>
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
            contentType: "application/json;",
            crossDomain: true,
            headers: {
                'Access-Control-Allow-Origin': '*',
            },
            success: function(response) {
                $('#loader').hide();
                // var data = response.data;
                // var wordCloudData = data.map(function(word) {
                //    return { word: word, freq: Math.random() * 20 + 10 }; 
                // });
                var data = [
                "This is a sentence.",
                "Another example sentence.",
                "Word clouds can handle longer text.",
                ];

                // WordCloud(document.getElementById('word-cloud'), {
                //     list: wordCloudData,
                //     minFontSize: '15px',
                // });
                var layout = d3.layout.cloud()
  .size([800, 400]) // Set the size of the word cloud container
  .words(data.map(function(d) {
    return { text: d, size: Math.random() * 30 + 10 }; // Random size (adjust as needed)
  }))
  .padding(5)
  .rotate(function() { return (Math.random() - 0.5) * 30; }) // Random rotation
  .font("Arial")
  .fontSize(function(d) { return d.size; })
  .on("end", draw);

  function draw(words) {
  d3.select("#word-cloud-container").append("svg")
    .attr("width", layout.size()[0])
    .attr("height", layout.size()[1])
    .append("g")
    .attr("transform", "translate(" + layout.size()[0] / 2 + "," + layout.size()[1] / 2 + ")")
    .selectAll("text")
    .data(words)
    .enter().append("text")
    .style("font-size", function(d) { return d.size + "px"; })
    .style("fill", "blue") // Change text color as needed
    .attr("text-anchor", "middle")
    .attr("transform", function(d) {
      return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
    })
    .text(function(d) { return d.text; });
}

layout.start(); 

            },
            error: function(error) {
                $('#loader').hide();
                console.error('Error fetching data:', error);
            }
        });
    }

    fetchDataAndGenerateDivs();
    fetchDataAndGenerateWordCloud();

});
</script>
</body>
</html>
