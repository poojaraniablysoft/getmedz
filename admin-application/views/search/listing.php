
<section class="section">
    <div class="sectionhead"><h4>Customer List </h4>


    </div>

    <div class="sectionbody">

        <?php
        $arr_flds = array(
            'listserial' => 'S.N.',
            'user_added_on' => 'Reg.Date',
            'user_email' => 'Email',
            'name' => 'User Name',
            'user_active' => 'Status',
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

                    case 'name':
                        $td->appendElement('plaintext', array(), $row[$key]);
                        break;

                    case 'user_added_on':
                        $td->appendElement('plaintext', array(), displayDate($row[$key]));
                        break;
                    case 'user_active':
                        $td->appendElement('plaintext', array(), Applicationconstants::$arr_status[$row[$key]]);
                        break;
                    case 'action':

                        $ul = $td->appendElement('ul', array('class' => 'actions'));
                        $li = $ul->appendElement('li');

                        $li->appendElement('a', array('href' => generateUrl('customers', 'view', array($row['user_id'])), 'title' => 'View'), '<i class="ion-eye icon"></i>', true);

                        break;
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