<?php defined('SYSTEM_INIT') or die('Invalid Usage');
?>





        <?php
        $arr_flds = array(
            'listserial' => 'S.N.',
            'testimonial_name'=>'Testimonial Name',
            'testimonial_status' => 'Status',
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

                    case 'testimonial_name':
                        $td->appendElement('plaintext', array(), $row['testimonial_name']);
                        break;
                 
                    case 'testimonial_status':
                        $td->appendElement('plaintext', array(), Applicationconstants::$arr_status[$row['testimonial_status']]);
                        break;
                    case 'action':

                        $ul = $td->appendElement('ul', array('class' => 'actions'));
                        $li = $ul->appendElement('li');
                        
                      
                        
							if ($row['testimonial_status'] == 0) {
								$li = $ul->appendElement('li');
								$li->appendElement('a', array('onclick' => 'if(confirm(\'Do you want to Activate this Testimonial?\')) disable(' . $row['testimonial_id'] . ', 1,this);', 'title' => 'Inactive'), '<i class="ion-checkmark icon inactive"></i>', true);
							} else {
								$li = $ul->appendElement('li');
								$li->appendElement('a', array('onclick' => 'if(confirm(\'Do you want to Deactivate this Testimonial?\')) disable(' . $row['testimonial_id'] . ', 0,this);', 'title' => 'Active'), '<i class="ion-checkmark icon active"></i>', true);
								/* $td->appendElement('a', array('href'=> generateUrl('carlistings', 'change_listing_status' , array($row['carlist_id'], 0) ), 'class'=>'opt-button grant'), 'Enable' ); */
							}
                      
                            $li = $ul->appendElement('li');
                            $li->appendElement('a', array('href' => generateUrl('testimonials', 'form',array($row['testimonial_id'])), 'title' => 'Edit Profile'), '<i class="ion-edit icon"></i>', true);
                       
                            $li = $ul->appendElement('li');
                            $li->appendElement('a', array('href' => 'javascript:void(0);', 'onclick' => 'ConfirmDelete(' . $row['testimonial_id'] . ', $(this));', 'title' => 'Delete'), '<i class="ion-android-delete icon"></i>', true);
                     
                        
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


