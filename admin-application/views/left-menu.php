<!--left panel start here-->
<span class="leftoverlay"></span>
<aside class="leftside">

    <div class="sidebar_inner">
        <div class="profilewrap">
            <div class="profilecover">

                <span class="profileinfo">
				
				Welcome Admin</span>
            </div>    


        </div> 
		
		 <ul class="leftmenu">
            <li class= "<?php if (($controller=="home") ):?>active <?php endif; ?> "><a href="<?php echo generateUrl('', ''); ?>">Dashboard</a></li>
			<li class="haschild <?php if (($controller=="doctors") || ($controller=="customers") || ($controller=="reviews") ):?>active <?php endif; ?> "><a href="javascript:void(0);">Users Management</a> 
				<ul>
					<li ><a href="<?php echo generateUrl('doctors', ''); ?>"  class="<?php if (($controller=="doctors") ):?>active <?php endif; ?>">Manage Doctors</a> </li> 
					<li ><a href="<?php echo generateUrl('customers', ''); ?>"  class="<?php if (($controller=="customers") ):?>active <?php endif; ?>">Manage Customers</a> </li> 
					<li ><a href="<?php echo generateUrl('reviews', ''); ?>"  class="<?php if (($controller=="reviews") ):?>active <?php endif; ?>">Reviews Management</a> </li> 
				</ul>
			</li>
			<li class="haschild <?php if (($controller=="cms")  || ($controller=="banners") || ($controller=="testimonials" || ($controller=="navigations" )|| ($controller=="labels") )|| ($controller=="faqcategory")|| ($controller=="faqs")|| ($controller=="socialmedia") || ($controller=="blocks") || ($controller=="medicalcategory") || ($controller=="countries") || ($controller=="degrees") || ($controller=="subscriptions")):?>active <?php endif; ?>"><a href="javascript:void(0);">Cms Management</a> 
				<ul>
					<li ><a href="<?php echo generateUrl('cms', ''); ?>" class="<?php if (($controller=="cms") ):?>active <?php endif; ?>">Cms page Management</a> </li>
					<li ><a href="<?php echo generateUrl('blocks', ''); ?>"  class="<?php if (($controller=="blocks") ):?>active <?php endif; ?>">Block Management</a> </li>
					<li><a href="<?php echo generateUrl('banners'); ?>"  class="<?php if (($controller=="banners") ):?>active <?php endif; ?>">Banner Management</a></li>
					<li><a href="<?php echo generateUrl('navigations'); ?>"  class="<?php if (($controller=="navigations") ):?>active <?php endif; ?>">Navigation Management</a></li>
					<li ><a href="<?php echo generateUrl('medicalcategory', ''); ?>"  class="<?php if (($controller=="medicalcategory") ):?>active <?php endif; ?>">Manage Medical Categories</a> </li>
					<li ><a href="<?php echo generateUrl('degrees', ''); ?>"  class="<?php if (($controller=="degrees") ):?>active <?php endif; ?>">Manage Degrees</a> </li>
					<li ><a href="<?php echo generateUrl('countries', ''); ?>"  class="<?php if (($controller=="countries") ):?>active <?php endif; ?>">Manage Countries</a> </li>
					<li><a href="<?php echo generateUrl('labels'); ?>"  class="<?php if (($controller=="labels") ):?>active <?php endif; ?>">Labels Management</a></li>
					<li><a href="<?php echo generateUrl('faqcategory'); ?>"  class="<?php if (($controller=="faqcategory") ):?>active <?php endif; ?>">FAQ Category Management</a></li>
					<li><a href="<?php echo generateUrl('faqs'); ?>"  class="<?php if (($controller=="faqs") ):?>active <?php endif; ?>">FAQs Management</a></li>					
					<li><a href="<?php echo generateUrl('socialmedia'); ?>"  class="<?php if (($controller=="socialmedia") ):?>active <?php endif; ?>">Social Platforms Management</a></li>
					<li ><a href="<?php echo generateUrl('subscriptions', ''); ?>"  class="<?php if (($controller=="subscriptions") ):?>active <?php endif; ?>">Subscription Management</a> </li>
					<li><a href="<?php echo generateUrl('testimonials'); ?>"  class="<?php if (($controller=="testimonials") ):?>active <?php endif; ?>">Testimonials Management</a></li>
					<li><a href="<?php echo generateUrl('emailtemplates'); ?>"  class="<?php if (($controller=="emailtemplates") ):?>active <?php endif; ?>">Email Templates Management</a></li>
					
				</ul>
			</li>
            <li class="haschild <?php if (($controller=="reports")  ):?>active <?php endif; ?>" ><a href="javascript:void(0);">Reports</a>
				<ul><li><a href="<?php echo generateUrl('reports', 'doctor_stats'); ?>" class="<?php if (($action=="doctor_stats") ):?>active <?php endif; ?>" >Doctor Reports</a></li>
				<li><a href="<?php echo generateUrl('reports', 'customer_stats'); ?>" class="<?php if (($action=="customer_stats") ):?>active <?php endif; ?>">Customer Reports</a></li></ul>
			</a> </li>
           
            <li class="haschild <?php if (($controller=="configurations") ):?>active <?php endif; ?>"><a href="javascript:void(0);">Settings</a> 
				<ul>
					<li ><a href="<?php echo generateUrl('configurations', ''); ?>" class="<?php if (($controller=="configurations") ):?>active <?php endif; ?>">System Settings</a> </li>
				
					
				</ul>
			</li>
			<li class="haschild <?php if (($controller=="blogcategories"||$controller=="blogposts"||$controller=="blogcontributions"||$controller=="blogcomments")):?>active<?php endif; ?>"><a href="javascript:void(0)">Blog</a>

				<ul>

					<li><a href="<?php echo generateUrl('blogcategories', ''); ?>" class="<?php if (($controller=="blogcategories") ):?>active <?php endif; ?>">Categories</a></li>

					<li><a href="<?php echo generateUrl('blogposts', ''); ?>" class="<?php if (($controller=="blogposts") ):?>active <?php endif; ?>">Posts</a></li>

					<li><a href="<?php echo generateUrl('blogcontributions', ''); ?>" class="<?php if (($controller=="blogcontributions") ):?>active <?php endif; ?>">Contributions</a></li>

					<li><a href="<?php echo generateUrl('blogcomments', ''); ?>" class="<?php if (($controller=="blogcomments") ):?>active <?php endif; ?>">Comments</a></li>

				</ul>

			</li>
			
			<!--li class="<?php //if (($controller=="Search")  ):?>active <?php //endif; ?>"><a href="<?php //echo generateUrl('Search', ''); ?>"  class="<?php //if (($controller=="Search") ):?>active <?php //endif; ?>">Search</a> </li-->
            <li class="<?php if (($controller=="questions")  ):?>active <?php endif; ?>"><a href="<?php echo generateUrl('questions', ''); ?>"  class="<?php if (($controller=="questions") ):?>active <?php endif; ?>">Questions Management</a> </li>
			<li class="<?php if (($controller=="transactions")  ):?>active <?php endif; ?>"><a href="<?php echo generateUrl('transactions', ''); ?>"  class="<?php if (($controller=="transactions") ):?>active <?php endif; ?>">Transaction Management</a> </li>
           
		   <li class="<?php if (($controller=="admin")  ):?>active <?php endif; ?>"><a href="<?php echo generateUrl('admin', 'changepassword'); ?>"  class="<?php if (($controller=="admin") ):?>active <?php endif; ?>">Change Password</a></li>
            <li ><a href="<?php echo generateUrl('admin', 'logout'); ?>">Logout</a></li>			
        </ul>


    </div>       


</aside>
<!--left panel end here-->

