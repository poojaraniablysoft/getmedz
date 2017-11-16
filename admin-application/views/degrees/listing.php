
<section class="section">
    <div class="sectionhead"><h4>Degrees List </h4>


    </div>

    <div class="sectionbody">

        <?php
        $postedVar=  Syspage::getPostedVar();
        $arr_flds = array(
            'listserial' => 'S.N.',
            'degree_name' => 'Degree Name',
            'degree_active' => 'Status',
            'action' => 'Action'
        );


        $tbl = new HtmlElement('table', array('class' => 'table table-responsive', '', 'id' => ''));
        $th = $tbl->appendElement('thead')->appendElement('tr');
        foreach ($arr_flds as $key => $val) {
          //  $class=($postedVar[$key])?"active":'';
            $th->appendElement('th', array(),$val,true);
        }


        foreach ($arr_listing as $sn => $row) {
            $tr = $tbl->appendElement('tr');

            foreach ($arr_flds as $key => $val) {

                $td = $tr->appendElement('td', array('style' => ''));
                switch ($key) {
                    case 'listserial':
                        $td->appendElement('plaintext', array(), $sn + $start_record);
                        break;

                    case 'degree_name':
                        $td->appendElement('plaintext', array(), $row['degree_name']);
                        break;
                    case 'degree_active':
    $td->appendElement('plaintext', array(),Applicationconstants::$arr_status[$row['degree_active']]);
                        break;

                    case 'action':



                        $ul = $td->appendElement('ul', array('class' => 'actions'));
                        $li = $ul->appendElement('li');
                        if ($row['degree_active'] == 0) {
                            $li->appendElement('a', array('onclick' => 'if(confirm(\'Do you want to Activate this degree?\')) disabledegree(' . $row['degree_id'] . ', 1,this);', 'title' => 'Inactive'), '<i class="ion-checkmark icon inactive"></i>', true);
                        } else {
                            $li->appendElement('a', array('onclick' => 'if(confirm(\'Do you want to Deactivate this degree?\')) disabledegree(' . $row['degree_id'] . ', 0,this);', 'title' => 'Active'), '<i class="ion-checkmark icon active"></i>', true);
                            /* $td->appendElement('a', array('href'=> generateUrl('carlistings', 'change_listing_status' , array($row['carlist_id'], 0) ), 'class'=>'opt-button grant'), 'Enable' ); */
                        }



                        if ($canEditdegree) {
                            $li = $ul->appendElement('li');
                            $li->appendElement('a', array('href' => 'javascript:void(0);', 'onclick' => 'loadForm(' . $row['degree_id'] . ')', 'title' => 'edit'), '<i class="ion-edit icon"></i>', true);
                        }
                        if ($canDeletedegree) {
                            $li = $ul->appendElement('li');
                            $li->appendElement('a', array('href' => 'javascript:void(0);', 'onclick' => 'if(confirm(\'Are you sure you want to delete this degree?\')) document.location.href=\'' . generateUrl('degrees', 'delete_degree', array($row['degree_id'])) . '\'', 'title' => 'Delete'), '<i class="ion-android-delete icon"></i>', true);
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