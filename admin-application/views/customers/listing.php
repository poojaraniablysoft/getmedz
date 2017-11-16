
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
                        $td->appendElement('plaintext', array(), $row['name']);
                        break;
                 
                    case 'user_added_on':
                        $td->appendElement('plaintext', array(), displayDate($row['user_added_on']));
                        break;
                    case 'user_active':
                        $td->appendElement('plaintext', array(), Applicationconstants::$arr_status[$row['user_active']]);
                        break;
                    case 'action':

                        $ul = $td->appendElement('ul', array('class' => 'actions'));
                        $li = $ul->appendElement('li');
                        
                        $li->appendElement('a', array('href' =>generateUrl('customers','view',array($row['user_id'])), 'title' => 'View'), '<i class="ion-eye icon"></i>', true);
                        
                        if ($canEdit) {
							if ($row['user_active'] == 0) {
								$li = $ul->appendElement('li');
								$li->appendElement('a', array('onclick' => 'if(confirm(\'Do you want to Activate this User?\')) disable(' . $row['user_id'] . ', 1,this);', 'title' => 'Inactive'), '<i class="ion-checkmark icon inactive"></i>', true);
							} else {
								$li = $ul->appendElement('li');
								$li->appendElement('a', array('onclick' => 'if(confirm(\'Do you want to Deactivate this User?\')) disable(' . $row['user_id'] . ', 0,this);', 'title' => 'Active'), '<i class="ion-checkmark icon active"></i>', true);
								/* $td->appendElement('a', array('href'=> generateUrl('carlistings', 'change_listing_status' , array($row['carlist_id'], 0) ), 'class'=>'opt-button grant'), 'Enable' ); */
							}
                      
                            $li = $ul->appendElement('li');
                            $li->appendElement('a', array('href' => 'javascript:void(0);', 'onclick' => 'loadForm(' . $row['user_id'] . ')', 'title' => 'Edit Profile'), '<i class="ion-edit icon"></i>', true);
                        }


                        if ($canDelete) {
                            $li = $ul->appendElement('li');
                            $li->appendElement('a', array('href' => 'javascript:void(0);', 'onclick' => 'if(confirm(\'Are you sure you want to delete this User?\')) document.location.href=\'' . generateUrl('customers', 'delete_user', array($row['user_id'])) . '\'', 'title' => 'Delete'), '<i class="ion-android-delete icon"></i>', true);
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