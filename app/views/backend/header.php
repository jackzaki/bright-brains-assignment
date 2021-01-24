<div class="row" style="margin-left:0px; margin-right:0px;">
	<!-- <div class="col-md-12 col-sm-12 clearfix" style="text-align:center;">
		<h2 style="font-weight:200; margin:0px;"><?php echo $system_name;?></h2>
    </div> -->
	<!-- Raw Links -->

	<div class="col-md-12 col-sm-12 clearfix " style="background-color:#86BC65; font-weight:bold; box-shadow: 0px 10px 30px 0px rgba(82,63,105,0.08); border-radius: 5px;">
		<!-- <ul class="list-inline links-list pull-left" style="margin-top:9px;">
			<!- <li>
				<div class="input-group minimal" style="width: 300px;margin-left: 10px;">
					<span class="input-group-addon"><i class="entypo-search"></i></span>
					<input type="text" class="form-control" placeholder="Search student">
				</div>
				
			</li> ->
			<li>
				<a style="color: white; font-weight:bolder;" href="#>" target="_blank">
					<i class="entypo-paper-plane"></i> MoneyExpressMX Panel
				</a>
			</li>
		</ul>
        -->

		
		<!-- Profile Info -->
		<ul class="user-info pull-right pull-none-xsm" style="margin-top: 6px;margin-bottom: 6px;">
			<li class="profile-info dropdown pull-right"><!-- add class "pull-right" if you want to place this from right -->
				
				<a style="color: white; width:44px;" href="#" class="dropdown-toggle" data-toggle="dropdown">
					
					<img src="<?php echo $this->crud_model->get_image_url($this->session->userdata('profile_image')); ?>" alt="" class="img-circle" width="44">

					<?php
						$name = explode(" ",$this->session->userdata('user_name'));
						echo "Hi, ".$name['0'];
					?>

				</a>
				
				<!-- <ul class="dropdown-menu" >
					
					<li class="caret"></li>
					<li >
						<a href="<?php //echo site_url($account_type . '/manage_profile');?>">
							<i class="flaticon-rotate"></i>
							<?php //echo get_phrase('edit_profile');?>
						</a>
					</li>
					
					<li>
						<a href="<?php //echo site_url($account_type . '/manage_profile');?>">
							<i class="flaticon-lock"></i>
							<?php //echo get_phrase('change_password');?>
						</a>
					</li>
					
					<li>
						<a href="<?php //echo site_url('login/logout');?>">
							<i class="flaticon-paper-plane-1"></i>
							<?php //echo get_phrase('log_out');?>
						</a>
					</li>
					
				</ul> -->
			</li>
		
		</ul>
	</div>

</div>

<hr style="margin-top:0px;" />

<script type="text/javascript">
	function get_session_changer()
	{
		$.ajax({
            url: '<?php echo site_url('admin/get_session_changer');?>',
            success: function(response)
            {
                jQuery('#session_static').html(response);
            }
        });
	}
</script>
