<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-target="#list, #list2"  data-toggle="tab"><i class="entypo-menu"></i>
					<?php echo get_phrase('deposit_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_deposit');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------>


		<div class="tab-content">

            <div class="tab-pane box active" id="list2" style="padding: 5px">
                <div class="box-content">
                    <?php echo form_open(base_url() . 'admin/deposit' , array('class' => 'form-horizontal form-groups-bordered validate',  'enctype' => 'multipart/form-data','target'=>'_top'));?>
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

            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">

                <table class="table table-bordered table-striped table-condensed table-hover datatable" id="table_export1" role="grid" aria-describedby="teachers_info" style="width: 955px;">

                    <thead class=”thead-light”>
                        <tr role="row">
                            <th><div><?php echo get_phrase('receipt');?></div></th>
                            <th><div><?php echo get_phrase('creation_date');?></div></th>
                            <th><div><?php echo get_phrase('transaction_date');?></div></th>
                            <th><div><?php echo get_phrase('bank_name');?></div></th>
                            <th><div><?php echo get_phrase('currency');?></div>
                            <th><div><?php echo get_phrase('deposit_amount');?></div></th>
                            <th><div><?php echo get_phrase('charge');?></div></th>
                            <th><div><?php echo get_phrase('amount');?></div></th>
                            <th><div><?php echo get_phrase('notes');?></div></th>
                            <th><div><?php echo get_phrase('status');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1; foreach($depositData['Body']['data'] as $row):
                                ?>
                        <tr>
                            <td><img src="<?php echo $this->crud_model->get_image_url($row['picture']);?>" class="img-circle" width="70" /></td>
                            <td><?php echo $row['creationdate']; ?></td>
                            <td><?php echo $row['transection_date']; ?></td>
                            <td ><?php echo $row['bank_name']; ?></td>
                            <td><?php echo $row['currency']; ?></td>
                            <td><?php echo $row['deposit_amount']; ?></td>
                            <td><?php echo $row['charge']; ?></td>
                            <td><?php echo $row['amount']; ?></td>
                            <td><?php echo $row['notes']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                    <tfoot>
                        <tr role="row">
                        <th><div><?php echo get_phrase('receipt');?></div></th>
                            <th><div><?php echo get_phrase('creation_date');?></div></th>
                            <th><div><?php echo get_phrase('transaction_date');?></div></th>
                            <th id="bank_name"><div><?php echo get_phrase('bank_name');?></div></th>
                            <th><div><?php echo get_phrase('currency');?></div>
                            <th><div><?php echo get_phrase('deposit_amount');?></div></th>
                            <th><div><?php echo get_phrase('charge');?></div></th>
                            <th><div><?php echo get_phrase('amount');?></div></th>
                            <th><div><?php echo get_phrase('notes');?></div></th>
                            <th><div><?php echo get_phrase('status');?></div></th>
                        </tr>
                    </tfoot>
                        
                     
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                	<?php echo form_open(base_url() . 'admin/deposit/create' , array('class' => 'form-horizontal form-groups-bordered validate', 'id'=>'depositForm' , 'enctype' => 'multipart/form-data','target'=>'_top'));?>
                            
                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('receipt');?></label>

                                <div class="col-sm-5">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
                                            <img src="https://placehold.it/200x200" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                        <div>
                                            <span class="btn btn-white btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input data-validate="required" data-message-required="<?php echo get_phrase('required');?>" type="file" name="file" accept="image/*">
                                            </span>
                                            <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('bank_name');?></label>

                                <div class="col-sm-5">

                                    <select onchange="getval(this);" class="form-control" name="bank_name" data-validate="required" data-message-required="<?php echo get_phrase('bank_required');?>" autofocus required>
                                    <?php
                                    foreach($banks['Body']['data'] as $row):
                                    ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['bank_name']; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- <div class="form-group">
                                <label class="col-sm-3 control-label"><?php //echo get_phrase('bank_name');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="bank_name" data-validate="required" data-message-required="<?php echo get_phrase('bank_name_required');?>" value="" autofocus required>
                                </div>
                            </div> -->

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('currency');?></label>
                                <div class="col-sm-5">
                                     <input type="text" class="form-control" id="currency" name="currency"  value="USD" readonly  required>

<!--                                    <select name="currency" class="form-control selectboxit" data-validate="required" data-message-required="--><?php //echo get_phrase('currency_required');?><!--" value="" autofocus required >-->
<!--                                        <option value="USD">USD</option>-->
<!--                                        <option value="EURO">EURO</option>-->
<!--                                    </select>-->

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('amount');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="amount" data-validate="required" data-message-required="<?php echo get_phrase('amount_required');?>" value="" autofocus required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control datepicker" name="date" data-validate="required" data-message-required="<?php echo get_phrase('date_required');?>" value="" autofocus required>
                                    <!-- <input type="text" name="timestamp" class="form-control datepicker" data-format="D, dd MM yyyy" placeholder="Select Date" required=""> -->

                                </div>
                            </div>


                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-info"><?php echo get_phrase('add_transection');?></button>
                                <br><br>
                                <p>Deposit charge : <br>
                                5% of the amount or maximum of 75 USD <br>
                                5% of the amount or maximum of 75 EURO
                                </p>
                            </div>
						</div>
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS-->
            
		</div>
	</div>
</div>


<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">
    function getval(sel)
    {
        var cur = 'USD';
        if(sel.value == 'b1236b9872260f72a9c87426d65c5ead') cur='USD';
        else if(sel.value == '4ffc4c45b22665b020b0e0be557e38a5') cur = 'EURO';
        // $('#currency').prop('value', cur);
        $('#currency').val(cur);
    }

    jQuery(document).ready(function($)
    {
        // $("#depositForm").on("submit", function (e) {
        //     e.preventDefault();//stop submit event
        //     var self = $(this);//this form
        //     $("#currency").val("deneme");//change input
        //     $("#depositForm").off("submit");//need form submit event off.
        //     self.unbind('submit');
        //     self.submit();//submit form
        // });

       // $('#currency').prop('value', 'EURO');
        $('#currency').val('EURO');
            $('#table_export1 tfoot th').each( function (i) {
                if(i>=2 && i<=7) {
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

            // orderCellsTop: true, //new2
            // fixedHeader: true //new2
            

            //"pagingType": "full_numbers",


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

    

    });
    

</script>