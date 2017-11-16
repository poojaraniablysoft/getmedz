

<!--main panel start here-->
<div class="page">

	 <?php echo html_entity_decode($breadcrumb); ?>
    <div class="fixed_container">
        <div class="row">



            <div class="col-sm-12">  



              
                <section class="section">
                    <div class="sectionhead"><h4>Customer  Report</h4>
<!--                        <a class="themebtn btn-default waves-effect" href="<?php echo generateUrl('reports', 'customer_stats', array('CSV')) ?>">Generate Csv</a>-->

                    </div>

                    <div class="sectionbody">

                        <?php
                        $arr_flds = array_flip($headers);


                        $tbl = new HtmlElement('table', array('class' => 'table table-responsive', '', 'id' => ''));
                        $th = $tbl->appendElement('thead')->appendElement('tr');
                        foreach ($arr_flds as $key => $val) {

                            $th->appendElement('th', array(), $val);
                        }


                        foreach ($data as $sn => $row) {
                            $tr = $tbl->appendElement('tr');

                            foreach ($arr_flds as $key => $val) {

                                $td = $tr->appendElement('td', array('style' => ''));
                                switch ($key) {
                                    case 'date':

                                        $td->appendElement('plaintext', array(), displayDate($row[$key]));
                                        break;

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
        </div>
    </div>  

    <!--main panel end here-->
</div>
<!--body end here-->