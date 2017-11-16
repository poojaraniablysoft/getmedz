
<section class="section">
    <div class="sectionhead"><h4>Countries List </h4></div>

    <div class="sectionbody">

        <?php
        $arr_flds = array(
            'listserial' => 'S.N.',
            'country_name' => 'Country Name',
            'action' => 'Action',
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

                    case 'country_name':
                        $td->appendElement('plaintext', array(), $row['country_name']);
                        break;


                    case 'action':
                         $ul = $td->appendElement('ul', array('class' => 'actions'));
                         $li = $ul->appendElement('li');
                        $li->appendElement('a', array('href' => 'javascript:void(0);', 'onclick' => 'loadForm(' . $row['country_id'] . ')', 'title' => 'Edit Profile'), '<i class="ion-edit icon"></i>', true);
                       $li = $ul->appendElement('li');
                        $li->appendElement('a', array('href' =>  generateUrl('states'), 'title' => 'Add States','class' =>'add_state'), '<i class="ion-plus-circled icon"></i>', true);
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