	 <div class="sectionhead"><h4>Reply Query</h4></div>
												<div class="sectionbody space">
												<div id="msg_info">
												   <?php echo Message::getHtml();?>
												   </div>
											<?php echo $replyFrm->getFormTag(); ?>
													<div class="row">
														<div class="col-sm-12">
															<div class="field_control">
																
																<div class="field_cover">
																<?php echo $replyFrm->getFieldHtml('reply_text'); ?>

																</div>
															</div>
														</div>



													</div>


													<div class="row">


														<div class="wrapfield fupload">


															<div class="progress" id="file_progress" style="display:none">
																<div style="width: 0%" role="progressbar" class="progress-bar" ><span class="countvalue">0%</span></div>
															</div>

														</div>
														<div class ="formwrapcenter uploadedFiles style='display:none'"> <ul class="uploaded_files"><?php foreach($files as $file){
															echo  '<li><input checked=checked onclick="remove_file(this);" type="checkbox" name="uploaded_files[]" value="' . $file['file_id']. '">' .$file['file_display_name']. '</li>';
															}?></ul></div>


													</div>
													<div class="row">
														<div class="col-sm-12">

									<?php echo $replyFrm->getFieldHtml('btn_reply'); ?>
													<?php echo $replyFrm->getFieldHtml('add_attachment'); ?><span style="width:0%;" class="layer pbar"></span>
														</div>
													</div>
									<?php echo $replyFrm->getFieldHtml('reply_id'); ?>
									<?php echo $replyFrm->getFieldHtml('reply_orquestion_id'); ?>
									<?php echo $replyFrm->getFieldHtml('uploaded_files_id'); ?>
													</form>



												<?php echo $replyFrm->getExternalJs(); ?>
												</div>
									<?php echo $upFrm->getFormHtml(); ?>
									</div>
									
									
<script language="javascript" type="text/javascript">
    $('textarea').tinymce({
        // Location of TinyMCE script
        script_url: '<?php echo CONF_WEBROOT_URL . 'tinymce-lnk/jscripts/tiny_mce/tiny_mce.js' ?>',
        mode: "textareas",
        theme: "advanced",
        theme_advanced_buttons1: "mybutton,bold,italic,underline",
        theme_advanced_buttons2: "",
        theme_advanced_buttons3: "",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        plugins: 'inlinepopups',
        valid_elements: "b,em,strong,em,br,p"

    });

</script>