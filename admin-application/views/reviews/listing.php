
<section class="section">
    <div class="sectionhead"><h4>Reviews List </h4>


    </div>

    <div class="sectionbody">

        <?php
        $postedVar=  Syspage::getPostedVar();
        $arr_flds = array(
            'order_user_id' => 'User ID',
            'order_date' => 'Order Date',
            'user_name' => 'User Name',
           'user_email' => 'Email Address',
            'review_text' => 'Review',
            'doctor_name' => 'Doctor Name',
            'review_rating' => 'Rating',
			'upsell'=>'Upsell',
					
            'action' => 'Action'
        );


        $tbl = new HtmlElement('table', array('class' => 'table table-responsive', '', 'id' => ''));
        $th = $tbl->appendElement('thead')->appendElement('tr');
        foreach ($arr_flds as $key => $val) {
            $class=($postedVar[$key])?"active":'';
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

                    case 'review_text':
                        $div=$td->appendElement('div', array('class'=>'scrolltext'));
                        $div->appendElement('plaintext', array(), $row['review_text']);
                        break;
                    case 'order_date':
					$td->appendElement('plaintext', array(),displayDate($row['order_date']));
                        break;
                  case 'upsell':
      
					$td->appendElement('plaintext', array(),  Applicationconstants::$arr_yes_no[$row['upsell']]);
                        break;
                    case 'action':



                        $ul = $td->appendElement('ul', array('class' => 'actions'));
                        



                        if ($canEditreviews) {
                            $li = $ul->appendElement('li');
                            $li->appendElement('a', array('href' => 'javascript:void(0);', 'onclick' => 'loadForm(' . $row['review_id'] . ')', 'title' => 'edit'), '<i class="ion-edit icon"></i>', true);
                        }
                      
                            $li = $ul->appendElement('li');
                            $li->appendElement('a', array('href' =>generateUrl('reviews','detail',array($row['review_id'])), 'title' => 'View'), '<i class="ion-eye icon"></i>', true);
                       
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