
<section class="section">
    <div class="sectionhead"><h4>Customer List </h4>


    </div>

    <div class="sectionbody">

        <?php
        $arr_flds = array(
            'user_id' => 'User ID',
            'user_email' => 'Email',
            'user_name' => 'Customer Name',
            'user_added_on' => 'Reg. Date',
            'action' => 'Action'
        );


        $tbl = new HtmlElement('table', array('class' => 'table table-bordered', '', 'id' => ''));
        $th = $tbl->appendElement('thead')->appendElement('tr');
        foreach ($arr_flds as $key => $val) {

            $th->appendElement('th', array(), $val);
        }


        foreach ($arr_listing as $sn => $row) {
            $tr = $tbl->appendElement('tr');

            foreach ($arr_flds as $key => $val) {

                $td = $tr->appendElement('td', array('style' => ''));
                switch ($key) {
                    case 'user_id':
                        $td->appendElement('plaintext', array(), "#" . $row['user_id']);
                        break;
                    case 'user_name':
                        $td->appendElement('plaintext', array(), $row['user_name']);
                        break;
                    case 'user_email':
                        $td->appendElement('plaintext', array(), $row['user_email']);
                        break;
                    case 'user_added_on':
                        $td->appendElement('plaintext', array(), displayDate($row['user_added_on']));
                        break;

                    case 'action':

                        $ul = $td->appendElement('ul', array('class' => 'actions'));
                        $li = $ul->appendElement('li');

                        $li->appendElement('a', array('href' => generateUrl('doctor', 'viewcustomer', array($row['user_id'])), 'title' => 'View'), '<i class="ion-eye icon"></i>', true);


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
<?php include getViewsPath() . 'pagination.php'; ?>
</section>