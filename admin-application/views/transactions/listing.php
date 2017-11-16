
<section class="section">
    <div class="sectionhead"><h4>Transaction List </h4>


    </div>

    <div class="sectionbody">

        <?php
        $arr_flds = array(
            'listserial' => 'S.N.',
            'user_first_name' => 'User Name',
            'order_id' => 'Order Id#',
            'tran_time' => 'Transaction Date',
            'tran_completed' => 'Transaction Status',
            'action' => 'Action'
        );


        $tbl = new HtmlElement('table', array('class' => 'table table-responsive', '', 'id' => ''));
        $th = $tbl->appendElement('thead')->appendElement('tr');
        foreach ($arr_flds as $key => $val) {

            $th->appendElement('th', array(), $val);
        }


        foreach ($arr_listing as $sn => $row) {
            $tr = $tbl->appendElement('tr');

            foreach ($arr_flds as $key => $val) {

                $td = $tr->appendElement('td', array('style' => ''));
                switch ($key) {
                    case 'listserial':
                        $td->appendElement('plaintext', array(), $sn + $start_record);
                        break;

                    case 'tran_time':
                        $td->appendElement('plaintext', array(), displayDate($row['tran_time']));
                        break;

                    case 'tran_completed':
                        $td->appendElement('plaintext', array(), Applicationconstants::$arr_status[$row['tran_completed']]);
                        break;

                    case 'action':



                        $ul = $td->appendElement('ul', array('class' => 'actions'));
                        $li = $ul->appendElement('li');

                        $li->appendElement('a', array('onclick' => "edit({$row['tran_id']});", 'title' => 'Active'), '<i class="ion-edit icon "></i>', true);





                    default:
                        $td->appendElement('plaintext', array(), $row[$key]);
                        break;
                }
            }
        }

        if (count($arr_listing) == 0)
            $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($arr_flds), 'class' => 'records_txt'), 'No records found');
        echo $tbl->getHtml();
        ?>

    </div>
<?php include getViewsPath() . 'backend-pagination.php'; ?>
</section>