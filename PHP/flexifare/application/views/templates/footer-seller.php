    <div class="footer">
            <div class="pull-right">
                Example <strong>Codeigniter</strong> Free.
            </div>
            <div>
                <strong>Copyright</strong> Example Company &copy; 2017-2019
            </div>
        </div>

        </div>
        </div>

    <!-- Mainly scripts -->
 	<script src="<?php echo base_url(); ?>assets/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/jeditable/jquery.jeditable.js"></script>

    <!-- Data Tables -->
    <script src="<?php echo base_url(); ?>assets/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url(); ?>assets/js/inspinia.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/pace/pace.min.js"></script>

<!----datepicker---->
<script src="<?php echo base_url(); ?>assets/js/plugins/datapicker/moment-with-locales.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/datapicker/bootstrap-datetimepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/cropper/cropper.min.js"></script>
<!----datepicker---->


<!-- Page-Level Scripts -->
<script>
/* Document.ready function start here */
	$(document).ready(function() {
		
		/* Start dataTable*/
            $('.dataTables-example').dataTable({
                responsive: true,
                "dom": 'T<"clear">lfrtip',
                "tableTools": {
                    "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
                }
            });
            /* Init DataTables */
            var oTable = $('#editable').dataTable();

            /* Apply the jEditable handlers to the table */
            oTable.$('td').editable( '../example_ajax.php', {
                "callback": function( sValue, y ) {
                    var aPos = oTable.fnGetPosition( this );
                    oTable.fnUpdate( sValue, aPos[0], aPos[1] );
                },
                "submitdata": function ( value, settings ) {
                    return {
                        "row_id": this.parentNode.getAttribute('id'),
                        "column": oTable.fnGetPosition( this )[2]
                    };
                },
                "width": "90%",
                "height": "100%"
            } );
		/* End dataTable*/	
			
		/* Add More Button Functionality Start*/
			var count_div = $(".input_fields_container > div").length;
			var max_fields_limit      = 10; //set limit for maximum input fields
			var x = count_div; //initialize counter for text box
			$('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
				date_show(); // this is launched on load
				e.preventDefault();
				if(x < max_fields_limit){ //check conditions
				x++; //counter increment
				$('.input_fields_container').append('<div class="form-group col-md-12 date_show" id="data_'+x+'"><div class="input-group date" style="width:25%;display: inline-table;"><span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control jas"  name="plan_date[]"></div><div class="input-group" style="width:25%;display: inline-table;"><input type="text" class="form-control" name="plan_place[]" placeholder="Add Place"></div><div class="input-group" style="width:25%;display: inline-table;"><input type="text" class="form-control" name="plan_website[]"  placeholder="Add Website"></div><a href="#" class="remove_field" style="margin-left:10px;">Remove</a></div>'); //add input field
				}
			});  
			$('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
				e.preventDefault(); $(this).parent('div').remove(); x--;
			})
		/* Add More Button Functionality End*/
		
		/* Account Details Functionality start*/
		 	$('.paypal_details').on('input',function(e){
				$paypal_val = $(this).val();
				if($paypal_val != ''){
					$('.card_details input').prop('required',false);
				}else{
					$('.card_details input').prop('required',true);
				}
			});
		
			$('.card_details input').on('input',function(e){
				$card_details = $(this).val();
				//console.log($card_details);
				$(".card_details :input").each(function(){
				var input = $(this).val(); // This is the jquery object of the input, do what you will
				if(input != ''){
					$(this).prop('required',false);
				}else{
					$(this).prop('required',true);
				}
				});
				
			});
		
			
		/* Account Details Functionality End*/
		
	});
/* Document.ready function end here */

        function fnClickAddRow() {
            $('#editable').dataTable().fnAddData( [
                "Custom row",
                "New row",
                "New row",
                "New row",
                "New row" ] );
        }
		
		function date_show(){
			setTimeout(function(){ 
            	$('.date_show .input-group.date').datetimepicker();
			}, 3);
			
		}
		
		$(function() {
			date_show(); // this is launched on load
		});
</script>

<style>
    body.DTTT_Print {
        background: #fff;
    }
    .DTTT_Print #page-wrapper {
        margin: 0;
        background:#fff;
    }

    button.DTTT_button, div.DTTT_button, a.DTTT_button {
        border: 1px solid #e7eaec;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }
    button.DTTT_button:hover, div.DTTT_button:hover, a.DTTT_button:hover {
        border: 1px solid #d2d2d2;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }

    .dataTables_filter label {
        margin-right: 5px;

    }
</style>
</body>
</html>
