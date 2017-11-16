
<section class="section">
    <div class="sectionhead"><h4>Medical Category List </h4>


    </div>
    <div class="sectionbody">

        <?php
        $arr_flds = array(
            'listserial' => 'S.N.',
            'category_name' => 'Medical Category Name',
            'category_active' => 'Status',
            'action' => 'Action'
        );


        $tbl = new HtmlElement('table', array('class' => 'table table-responsive', '', 'id' => ''));
        $th = $tbl->appendElement('thead')->appendElement('tr');
        foreach ($arr_flds as $key => $val) {
            if ($key == 'action') {
                $th->appendElement('th', array(), $val);
            } else if ($key == 'listserial') {
                $th->appendElement('th', array(), $val);
            } else if ($key == 'catgeory_name') {
                $th->appendElement('th', array(), $val);
            } else if ($key == 'category_active') {
                $th->appendElement('th', array(), $val);
            } else {
                $th->appendElement('th', array(), $val);
            }
        }


        foreach ($arr_listing as $sn => $row) {
            $tr = $tbl->appendElement('tr', array('id' => $row['category_id']));

            foreach ($arr_flds as $key => $val) {

                $td = $tr->appendElement('td', array('style' => ''));
                switch ($key) {
                    case 'listserial':
                        $td->appendElement('plaintext', array(), $sn + $start_record);
                        break;

                    case 'category_name':
                        $td->appendElement('plaintext', array(), $row['category_name']);
                        break;
                    case 'category_active':
    $td->appendElement('plaintext', array(),Applicationconstants::$arr_status[$row['category_active']]);
                        break;

                    case 'action':
                        $ul = $td->appendElement('ul', array('class' => 'actions'));
                        if ($row['category_active'] == 0) {
                            $li = $ul->appendElement('li');
                            $li->appendElement('a', array('onclick' => 'if(confirm(\'Do you want to Activate this catgeory?\')) disableCategory(' . $row['category_id'] . ', 1,this);', 'title' => 'Inactive'), '<i class="ion-checkmark icon inactive"></i>', true);
                        } else {
                            $li = $ul->appendElement('li');
                            $li->appendElement('a', array('onclick' => 'if(confirm(\'Do you want to Deactivate this category?\')) disableCategory(' . $row['category_id'] . ', 0,this);', 'title' => 'Active'), '<i class="ion-checkmark icon active"></i>', true);
                        }

                        if ($canEdit) {

                            $li = $ul->appendElement('li');
                            $li->appendElement('a', array('href' => 'javascript:void(0);', 'onclick' => 'loadForm(' . $row['category_id'] . ')', 'title' => 'Edit Profile'), '<i class="ion-edit icon"></i>', true);
                        }
                        if ($canDelete) {
                            $li = $ul->appendElement('li');
                            $li->appendElement('a', array('href' => 'javascript:void(0);', 'onclick' => 'if(confirm(\'Are you sure you want to delete this Medical Category?\')) document.location.href=\'' . generateUrl('medicalcategory', 'delete_medicalCategory', array($row['category_id'])) . '\'', 'title' => 'Delete'), '<i class="ion-android-delete icon"></i>', true);
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