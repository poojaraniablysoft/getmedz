<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.1.0/js/dataTables.fixedColumns.min.js"></script>

<!--main panel start here-->
<div class="page">
    <?php echo html_entity_decode($breadcrumb); ?>
    <div class="fixed_container">
        <div class="row">



            <div class="col-sm-12">  


                <!--main panel end here-->
                <div class="sectionbody space">


                 
                    <div class="tabs_nav_container responsive boxbased">

                        <ul class="tabs_nav">
                            <li><a href="javascript:void(0)" rel="tabs_01"  id="tab_a_1" class="active">Search</a></li>


                        </ul>

                        <div class="tabs_panel_wrap">

                            <span rel="tabs_01" class="togglehead active">Search</span>
                            <div class="tabs_panel" id="tabs_01" >
                                <?php echo $rangeForm->getFormHtml(); ?>
                            </div>



                        </div>      

                    </div>
                    <?php
                    //  printR($dateRange);
                    foreach ($dateRange as $key => $value) {
                        echo $value->format("Y-m-d") . "<br>";
                    }
                    ?>
                </div> 

                <section class="section">
                    <div class="sectionhead"><h4>Doctor  Report</h4>
<!--                        <a class="themebtn btn-default waves-effect" href="<?php echo generateUrl('reports', 'customer_stats', array('CSV')) ?>">Generate Csv</a>-->

                    </div>

                    <div class="sectionbody">
                        <div class="tablewrap">
                            <?php
                            $arr_flds = array_flip($headers);


                            $tbl = new HtmlElement('table', array('class' => 'table table-responsive table-responsive nofixed dr_tbl', 'id' => 'doc_stats'));
                            $th = $tbl->appendElement('thead')->appendElement('tr');
                            foreach ($arr_flds as $key => $val) {
                                if ($key == 'Doctor Name') {
                                    $dix = $th->appendElement('th', array('class' => 'tb'));
                                    $div = $dix->appendElement('div', array('class' => 'report_div'));
                                    $div->appendElement('span', array('class' => 'd_date'), 'Date');
                                    $div->appendElement('span', array('class' => 'd_name'), $val);
                                } else {
                                    $th->appendElement('th', array(), $val);
                                }
                            }

                         
                            foreach ($data as $sn => $row) {
                                $tr = $tbl->appendElement('tr');

                                foreach ($arr_flds as $key => $val) {

                                    $td = $tr->appendElement('td', array('style' => '', 'width' => '50px'));
                                    switch ($key) {


                                        default:
                                            $td->appendElement('plaintext', array(), $row[$key]);
                                            break;
                                    }
                                }
                            }

                            if (count($data) == 0)
                                $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds), 'class' => 'records_txt'), 'No records found');
                            echo $tbl->getHtml();
                            ?>

                        </div>
                    </div>

                </section>


            </div>

        </div>

    </div>          
    <script language="javascript" >$(document).ready(function () {

            var table = $('#doc_stats').DataTable({
                "bPaginate": false,
                "bFilter": false,
                "bInfo": false,
                scrollX: true,
                scrollCollapse: true,
                paging: false,
                fixedColumns: {
                    leftColumns: 1,
                }
            });
        });</script>