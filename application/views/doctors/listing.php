 <div class="span-md-8 span-sm-12 span-xs-12">
            <div class="template__main">
              <div class="span-row">
                <aside class="span-md-6 span-sm-6 span-xs-12">
                  <h5 class="block-title"><?php echo getlabel(L_All_Doctors)?><span>(<?php echo $total_records; ?>)</span></h5>
                </aside>
                <aside class="span-md-6 span-sm-6 span-xs-12">
                  <div class="sort form fl--right">
                    <div class="select_wrap">
                      <select name="sort_by" id="sort_by" onchange="select_sort_by(this.value)">
                        <option value=""><?php echo getlabel(L_Sort_By)?></option>
                        <option value="asc" <?php if($sort_by == "asc" ) { ?> selected <?php } ?>><?php echo getlabel(L_Experience_Ascending)?></option>
                        <option value="desc" <?php if($sort_by == "desc" ) { ?> selected <?php } ?>><?php echo getlabel(L_Experience_Descending)?></option>
                      </select>
                    </div>
                  </div>
                </aside>
              </div>
              <div class="listing__items" >
                <div class="span-row">
				<?php if(!empty($arr_listing)) {  foreach($arr_listing as $doctor_data) { ?>
                  <div class="span-md-4 span-sm-4 span-xs-6">
                    <div class="item">
                      <div class="item__head"><a href="<?php echo generateUrl('doctors','detail',array($doctor_data['doctor_id']));?>"> <img class="item__pic " src="<?php echo generateUrl('image','getDoctorProfilePic',array($doctor_data['doctor_id'],305,305)) ?>" alt=""> </a> </div>
                      <div class="item__body">
                        <div class="item__summary"> <span class="item_category"><span class="item_categoryIcon"> <a class="item_category__link" href="javascript:void(0);"><img src="<?php echo generateUrl('image', 'medical_category', array($doctor_data['category_id'], 50, 50) ) ?>" alt=""></a> </span></span><span class="item__title"><a href="<?php echo generateUrl('doctors','detail',array($doctor_data['doctor_id']));?>"><?php echo doctorDisplayName($doctor_data['doctor_first_name'],$doctor_data['doctor_last_name']); ?> </a></span> <span class="item__subtitle"><?php echo $doctor_data['category_name'] ?> </span>
                          <div class="item__description">
                            <p><?php echo subStringByWords(html_entity_decode($doctor_data['doctor_summary']), 35);?></p>
                            <a class="button button--fill button--primary" href="<?php echo generateUrl('doctors','detail',array($doctor_data['doctor_id']));?>" ><?php echo getLabel('L_Read_More')?></a></div>
                        </div>
                      </div>
                    </div>
                  </div>
				<?php } }else {?>
				<div class="no-items"> <?php echo getLabel(M_No_Doctor_Available)?> </div>
				<?php } ?>
				
                
                </div>
              </div>
            </div>
            <div class="pagination_wrap">
              <?php include getViewsPath() . 'pagination.php'; ?>
            </div>
          </div>