<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-target="#list, #list2" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo get_phrase('product_list');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------>
        
	
		<div class="tab-content">
            <div class="tab-pane box active" id="list2" style="padding: 5px">
                <div class="box-content">
                    <?php echo form_open(base_url() . 'superadmin/products' , array('class' => 'form-horizontal form-groups-bordered validate',  'enctype' => 'multipart/form-data','target'=>'_top'));?>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">From Date</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control todate" name="fromdate" data-validate="required" data-message-required="<?php echo get_phrase('from_date_required');?>" value="<?php echo $fromtodates['date1']; ?>"  required>
                        </div>

                        <label class="col-sm-1 control-label">To Date</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control fromdate" name="todate" data-validate="required" data-message-required="<?php echo get_phrase('to_date_required');?>" value="<?php echo $fromtodates['date2']; ?>"  required>
                        </div>

                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-info">Filter</button>
                        </div>

                    </div>
                    </form>
                </div>
            </div>
            <hr>
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
                <a class="btn btn-primary" href="#" name="activeInactive" id="activeInactive">
                    <?php echo get_phrase('select_to_update');?>
                </a>   
          
                <br><br>

                <table class="table table-bordered table-striped table-condensed table-hover datatable" id="table_export1" role="grid" aria-describedby="" style="width: 955px;">

                    <thead class=”thead-light”>
                        <tr role="row">
                            <th><input type="checkbox" name="resident_checkAll" id="resident_checkAll" ></th>
                            <th><div><?php echo get_phrase('creation_date');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th><div><?php echo get_phrase('user');?></div></th>
                            <th><div><?php echo get_phrase('price');?></div></th>
                            <th><div><?php echo get_phrase('color');?></div></th>
                            <th><div><?php echo get_phrase('status');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1; foreach($productData['Body']['data'] as $row):
                                ?>
                        <tr>
                            <td><input type="checkbox" name="resident_list[]" value="<?php echo $row['id']; ?>"></td>
                            <td><?php echo $row['creationdate']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['user_id']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['color']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                    <tfoot>
                        <tr role="row">
                            <th><input type="checkbox" name="resident_checkAll" id="resident_checkAll" ></th>
                            <th><div><?php echo get_phrase('creation_date');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th><div><?php echo get_phrase('user');?></div></th>
                            <th><div><?php echo get_phrase('price');?></div></th>
                            <th><div><?php echo get_phrase('color');?></div></th>
                            <th><div><?php echo get_phrase('status');?></div></th>
                    </tfoot>
                        
                     
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
		</div>
	</div>
</div>


<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

    jQuery(document).ready(function($)
    {
            $('#table_export1 tfoot th').each( function (i) {
                if(i>=2 && i<=9) {
                    var title = $('#example thead th').eq( $(this).index() ).text();
                    $(this).html( '<input  class="form-control" type="text" placeholder="Search '+title+'" data-index="'+i+'" />' );

                    $( 'input', this ).on( 'keyup change', function () {
                        if ( datatable.column(i).search() !== this.value ) {
                            datatable
                                .column(i)
                                .search( this.value )
                                .draw();
                        }
                    } );
                }
            } );

        var datatable = $("#table_export1").DataTable({
            searching: true,
            "sPaginationType": "bootstrap",
            "scrollX": true,
            // "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
            // "lengthMenu": [[25, 50, -1], [25, 50, "All"]],
            // "oTableTools": {
            //     "sSwfPath": '<?php //echo base_url()."assets/js/datatables/copy_csv_xls_pdf.swf"; ?>',
            //     "aButtons": [
                    
            //         {
            //             "sExtends": "xls",
            //             "mColumns": [1,2,3,4,5,6]
            //         },
            //         {
            //             "sExtends": "pdf",
            //             "mColumns": [1,2,3,4,5,6]
            //         },
            //         {
            //             "sExtends": "print",
            //             "fnSetText"    : "Press 'esc' to return",
            //             "fnClick": function (nButton, oConfig) {
            //                 datatable.fnSetColumnVis(0, false);
            //                 //datatable.fnSetColumnVis(5, false);
                            
            //                 this.fnPrint( true, oConfig );
                            
            //                 window.print();
                            
            //                 $(window).keyup(function(e) {
            //                       if (e.which == 27) {
            //                           datatable.fnSetColumnVis(0, true);
            //                       }
            //                 });
            //             },
                        
            //         },
            //     ]
            // },
            
        });
        
        // 
        var table = $('#table_export1').DataTable();
        
        $('#table_export1 tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );
     
        $('#button').click( function () {
            table.row('.selected').remove().draw( false );
        } );
        // 

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

    
        // Active Inactive
        $("#activeInactive").click(function(){
            // var status = this.value;
            var sel = $('input[type=checkbox]:checked').map(function(_, el) {
                        return $(el).val();
                     }).get();
            if ($("input:checkbox:checked").length > 0)
            {
                // alert(sel);
                activeInactive_modal('<?php echo base_url();?>superadmin/products/active_inactive/'+"?ids="+sel);
                return true;
            }
            else
            {
                alert('Please select atleast one row.');
                return false;
            }

            
        });



    });
    
    // check all
    $("#resident_checkAll").click(function () {
       $('input:checkbox').not(this).prop('checked', this.checked);
    });

</script>