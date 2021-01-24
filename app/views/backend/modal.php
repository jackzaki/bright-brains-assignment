    <script type="text/javascript">
	function showAjaxModal(url)
	{
		// SHOWING AJAX PRELOADER IMAGE
		jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="<?php echo base_url(); ?>assets/images/preloader.gif"/></div>');
		
		// LOADING THE AJAX MODAL
		jQuery('#modal_ajax').modal('show', {backdrop: 'true'});
		
		// SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            // async: true,
			success: function(response)
			{
                jQuery('#modal_ajax .modal-body').html(response);
			}
		});
	}
	</script>
    
    <!-- (Ajax Modal)-->
    <div class="modal fade" id="modal_ajax">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo $system_name;?></h4>
                </div>
                
                <div class="modal-body" style="height:500px; overflow:auto;">
                
                    
                    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    <script type="text/javascript">
	function confirm_modal(delete_url)
	{
		jQuery('#modal-4').modal('show', {backdrop: 'static'});
		document.getElementById('delete_link').setAttribute('href' , delete_url);
	}
	</script>
    
    <!-- (Confirm Modal)-->
    <div class="modal fade" id="modal-4">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top:100px;">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
                </div>
                
                
                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="delete_link"><?php echo get_phrase('delete');?></a>
                    <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('cancel');?></button>
                </div>
            </div>
        </div>
    </div>
    <!-- ----------------------------------------------------- -->
    <!-- Approved Model -->
    <script type="text/javascript">
	function approve_modal(approve_url)
	{
		jQuery('#modal-approve').modal('show', {backdrop: 'static'});
		document.getElementById('approve_link').setAttribute('href' , approve_url);
	}
	</script>
    
    <div class="modal fade" id="modal-approve">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top:100px;">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to approve this resident ?</h4>
                </div>
                
                
                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="approve_link"><?php echo get_phrase('approve');?></a>
                    <!-- <button type="button" class="btn btn-info" data-dismiss="modal"><?php //echo get_phrase('cancel');?></button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- --------------------------------------------- -->

    <!-- Archive Model -->
    <script type="text/javascript">
    function archive_modal(archive_url)
    {
        jQuery('#modal-archive').modal('show', {backdrop: 'static'});
        document.getElementById('archive_link').setAttribute('href' , archive_url);
    }
    </script>
    
    <!-- (Archive Modal)-->
    <div class="modal fade" id="modal-archive">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top:100px;">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to archive this information ?</h4>
                </div>
                
                
                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="archive_link"><?php echo get_phrase('archive');?></a>
                    <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('cancel');?></button>
                </div>
            </div>
        </div>
    </div>

        <!-- ------------------------------------------- -->
    <!-- remove archive Model -->
    <script type="text/javascript">
    function removearchive_modal(archive_url)
    {
        jQuery('#modal-removearchive').modal('show', {backdrop: 'static'});
        document.getElementById('removearchive_link').setAttribute('href' , archive_url);
    }
    </script>
    
    <!-- (Normal Modal)-->
    <div class="modal fade" id="modal-removearchive">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top:100px;">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to remove archive this Apartment ?</h4>
                </div>
                
                
                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="removearchive_link"><?php echo get_phrase('remove_archive');?></a>
                    <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('cancel');?></button>
                </div>
            </div>
        </div>
    </div>

    <!-- ----------------------------------------------------- -->
    <!-- Active Inactive Model -->
    <script type="text/javascript">
    function activeInactive_modal(activeInactive_url)
    {
        jQuery('#modal-activeInactive').modal('show', {backdrop: 'static'});
        document.getElementById('active_link').setAttribute('href' , activeInactive_url+"&status=Active");
        document.getElementById('inactive_link').setAttribute('href' , activeInactive_url+"&status=Inactive");

        // document.getElementById('archive_link').setAttribute('href' , activeInactive_url+"&status=archive");
        // document.getElementById('unarchive_link').setAttribute('href' , activeInactive_url+"&status=unarchive");
    }
    </script>
    
    <!-- (Archive Modal)-->
    <div class="modal fade" id="modal-activeInactive">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top:100px;">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to update this information ?</h4>
                </div>
                
                
                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-success" id="active_link"><?php echo get_phrase('active');?></a>
                    <a href="#" class="btn btn-danger" id="inactive_link"><?php echo get_phrase('inactive');?></a>

                    <!-- <a href="#" class="btn btn-success" id="archive_link"><?php //echo get_phrase('archive');?></a>
                    <a href="#" class="btn btn-danger" id="unarchive_link"><?php //echo get_phrase('unarchive');?></a> -->

                    <!-- <button type="button" class="btn btn-info" data-dismiss="modal"><?php //echo get_phrase('cancel');?></button> -->
                </div>
            </div>
        </div>
    </div>

