
<?php
// @var $frm Form
echo $frm->getFormHtml();?>
<script>
$('.filefield :input').change(function(){			
	$(this).prev('.filename').html(this.value);
});
</script>