
<section class="section">
    <div class="sectionhead"><h4>FAQ category List </h4>


    </div>

    <div class="sectionbody">

        <?php
        $arr_flds = array(
            'listserial' => 'S.N.',
            'faqcat_name' => 'FAQ Categroy Name',
            'faqcat_display_order' => 'FAQ Categroy Display Order',
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

                    case 'faqcat_name':
                        $td->appendElement('plaintext', array(), $row['faqcat_name']);
                        break;
                    case 'faqcat_display_order':
                        $td->appendElement('plaintext', array(), $row['faqcat_display_order']);
                        break;


                    case 'action':
                         $ul = $td->appendElement('ul', array('class' => 'actions'));
                       
                        if ($row['faqcat_active'] == 0) {
                             $li = $ul->appendElement('li');
                            $li->appendElement('a', array('onclick' => 'if(confirm(\'Do you want to Activate this Category?\')) disableCategory(' . $row['faqcat_id'] . ', 1,this);', 'title' => 'Inactive'), '<i class="ion-checkmark icon inactive"></i>', true);
                        } else {
                             $li = $ul->appendElement('li');
                            $li->appendElement('a', array('onclick' => 'if(confirm(\'Do you want to Deactivate this Category?\')) disableCategory(' . $row['faqcat_id'] . ', 0,this);', 'title' => 'Active'), '<i class="ion-checkmark icon active"></i>', true);
                            /* $td->appendElement('a', array('href'=> generateUrl('carlistings', 'change_listing_status' , array($row['carlist_id'], 0) ), 'class'=>'opt-button grant'), 'Enable' ); */
                        }
                        
                        
                        if ($canEditFaqCategory) {
                             $li = $ul->appendElement('li');
                            $li->appendElement('a', array('href' => 'javascript:void(0);', 'onclick' => 'loadForm(' . $row['faqcat_id'] . ')', 'title' => 'Edit'), '<i class="ion-edit icon"></i>', true);
                        }
                        
                        if ($canDeleteFaqCategory) {
                            $li = $ul->appendElement('li');
                          $li->appendElement('a', array('href' => 'javascript:void(0);', 'onclick' => 'if(confirm(\'Are you sure you want to delete this Category?\')) document.location.href=\'' . generateUrl('faqcategory', 'delete_faqcategory', array($row['faqcat_id'])) . '\'', 'title' => 'Delete'), '<i class="ion-android-delete icon"></i>', true);
                        }
                        
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