<?php session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home | <?php include('../dist/includes/title.php');?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../plugins/select2/select2.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
	<script src="../dist/js/jquery.min.js"></script>
 </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="hold-transition skin-yellow layout-top-nav" onload="myFunction()">
    <div class="wrapper">
      <?php include('../dist/includes/header.php');?>
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="container">
          <!-- Content Header (Page header) -->
        

          <!-- Main content -->
          <section class="content">
            <div class="row">
	      <div class="col-md-8">
              <div class="box box-warning">
              					<a href="#examroom" data-target="#examroom" data-toggle="modal" class="dropdown-toggle pull-right">
						
                      <button class="btn btn-primary">Hall</button>				
                    </a>
					<a href="#examclass" data-target="#examclass" data-toggle="modal" class="dropdown-toggle pull-right">
                     
                      <button class="btn btn-success">Level</button>				
                    </a>
                   <a href="#examt" data-target="#examt" data-toggle="modal" class="dropdown-toggle pull-right">
                     
                      <button class="btn btn-warning">Lecturer</button>				
                    </a>
                    <span style="font-size:18px;font-weight:bolder" class="pull-right">Print Exam Timetable &nbsp;</span><br><br>
               <form method="post" id="reg-form">
                <div class="box-body">
				<div class="row">
					<div class="col-md-12">
							<table class="table table-bordered table-striped" style="margin-right:-10px">
							<thead>
							  <tr>
								<th>Time</th>
								<th>First Day</th>
								<th>Second Day</th>
								<th>Third Day</th>
								
							  </tr>
							</thead>
							
		<?php
				include('../dist/includes/dbcon.php');
				$sched_id=$_REQUEST['id'];
				$query1=mysqli_query($con,"select * from exam_sched where sched_id='$sched_id'")or die(mysqli_error($con));
						$row1=mysqli_fetch_array($query1);	
							$time_id=$row1['time_id'];	
							$day=$row1['day'];	
							//$day=$row1['day'];	

				$query=mysqli_query($con,"select * from time where days='fst' order by time_start")or die(mysqli_error());
				
				while($row=mysqli_fetch_array($query)){
						$id=$row['time_id'];
						$start=date("h:i a",strtotime($row['time_start']));
						$end=date("h:i a",strtotime($row['time_end']));

					
		?>
							  <tr >
								<td><?php echo $start."-".$end;?></td>
								<td><input type="checkbox" name="f[]" value="<?php echo $id;?>" style="width: 20px; height: 20px;"
								<?php if(($id==$time_id) and ($day=='first')) echo "checked"; ?>>
								</td>
								<td><input type="checkbox" name="s[]" value="<?php echo $id;?>" style="width: 20px; height: 20px;"
								<?php if(($id==$time_id) and ($day=='second')) echo "checked"; ?>></td>
								<td><input type="checkbox" name="t[]" value="<?php echo $id;?>" style="width: 20px; height: 20px;"
								<?php if(($id==$time_id) and ($day=='third')) echo "checked"; ?>></td>
								
							  </tr>
							
		<?php }?>					  
		</table>    
		</div><!--col end -->
		       
        </div><!--row end-->        
					
			
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col (right) -->
            
            <div class="col-md-4">
              <div class="box box-warning">
               <?php
               	$query=mysqli_query($con,"select * from exam_sched natural join member where sched_id='$sched_id'")or die(mysqli_error());
						$row=mysqli_fetch_array($query);
				?>
                <div class="box-body">
                  <!-- Date range -->
                  <div id="form">
					<input type="hidden" name="id" value="<?php echo $sched_id;?>">
				  <div class="row">
					 <div class="col-md-12">
						  <div class="form-group">
							<label for="date">Lecturer</label>
							
								<select class="form-control select2" name="teacher" required>
									<option value="<?php echo $row['member_id'];?>"><?php echo $row['member_last'].", ".$row['member_first'];?></option>
								  <?php 
									$query2=mysqli_query($con,"select * from member order by member_last")or die(mysqli_error($con));
									  while($row2=mysqli_fetch_array($query2)){
								  ?>
										<option value="<?php echo $row2['member_id'];?>"><?php echo $row2['member_last'].", ".$row2['member_first'];?></option>
								  <?php }
									
								  ?>
								</select>
							
						  </div><!-- /.form group -->
						  <div class="form-group">
							<label for="date">Course</label>
							
								<select class="form-control select2" name="subject" required>
									<option><?php echo $row['subject_code'];?></option>
								  <?php 
									$query2=mysqli_query($con,"select * from subject order by subject_code")or die(mysqli_error($con));
									 while($row2=mysqli_fetch_array($query2)){
								  ?>
										<option><?php echo $row2['subject_code'];?></option>
								  <?php }
									
								  ?>
								</select>
							
						  </div><!-- /.form group -->
						  <div class="form-group">
							<label for="date">Course, Yr & Section</label>
							<select class="form-control select2" name="cys" required>
								<option><?php echo $row['cys'];?></option>
								  <?php 
									$query2=mysqli_query($con,"select * from cys order by cys")or die(mysqli_error($con));
									 while($row2=mysqli_fetch_array($query2)){
								  ?>
										<option><?php echo $row2['cys'];?></option>
								  <?php }
									
								  ?>
								</select>	
						  </div><!-- /.form group -->
						  <div class="form-group">
							<label for="date">Hall</label>
							<select class="form-control select2" name="room" required>
									<option><?php echo $row['room'];?></option>
								  <?php 

									$query2=mysqli_query($con,"select * from room order by room")or die(mysqli_error($con));
									  while($row2=mysqli_fetch_array($query2)){
								  ?>
										<option><?php echo $row2['room'];?></option>
								  <?php }
									
								  ?>
								</select>	
						  </div><!-- /.form group -->
						  <div class="form-group">
							<label for="date">Remarks</label><br>
								<textarea name="remarks" cols="40" placeholder="enclose remarks with parenthesis()"><?php echo $row['remarks'];?></textarea>
								
						  </div><!-- /.form group -->
					</div>
					
					

				</div>	
               
                  
                  <div class="form-group">
                    
                      <button class="btn btn-lg btn-primary" id="daterange-btn" name="save" type="submit">
                        Save
                      </button>
					  <button class="btn btn-lg" id="daterange-btn" type="reset">
                       Cancel
                      </button>
					  
					  
                   </div>
                  </div><!-- /.form group --><hr>
				</form>	<button class="uncheck btn btn-lg btn-success">Uncheck All</button>
                      
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col (right) -->
			 <div class="result well" id="form">
					  </div>
			
          </div><!-- /.row -->
	  
            
          </section><!-- /.content -->
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      <?php include('../dist/includes/footer.php');?>
    </div><!-- ./wrapper -->
	
	<script type="text/javascript">
	
		$(document).on('submit', '#reg-form', function()
		 {  
		  $.post('submit_exam_update.php', $(this).serialize(), function(data)
		  {
		   $(".result").html(data);  
			
		  });
		  
		  return false;
		  
		
		})
</script>
<script>
$(".uncheck").click(function () {
			$('input:checkbox').removeAttr('checked');
});
</script>
	
	<script type="text/javascript" src="autosum.js"></script>
    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="../dist/js/jquery.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../plugins/select2/select2.full.min.js"></script>
    <!-- SlimScroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
    
    <script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>
     <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },
              startDate: moment().subtract(29, 'days'),
              endDate: moment()
            },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        );

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        });

        //Colorpicker
        $(".my-colorpicker1").colorpicker();
        //color picker with addon
        $(".my-colorpicker2").colorpicker();

        //Timepicker
        $(".timepicker").timepicker({
          showInputs: false
        });
      });
    </script>
  </body>
</html>
<div id="examt" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
	  <div class="modal-content" style="height:auto">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Search Faculty Exam Schedule</h4>
              </div>
              <div class="modal-body">
			  <form class="form-horizontal" method="post" action="faculty_exam.php" target="_blank">
                
				<div class="form-group">
					<label class="control-label col-lg-3" for="name">Faculty</label>
					<div class="col-lg-9">
					<select class="select2" name="faculty" style="width:90%!important" required>
								  <?php 
								  include('../dist/includes/dbcon.php');
									$query2=mysqli_query($con,"select * from member order by member_last")or die(mysqli_error($con));
									  while($row=mysqli_fetch_array($query2)){
								  ?>
										<option value="<?php echo $row['member_id'];?>"><?php echo $row['member_last'].", ".$row['member_first'];?></option>
								  <?php }
									
								  ?>
								</select>
					</div>
				</div> 
				
				
              </div><hr>
              <div class="modal-footer">
				<button type="submit" name="search" class="btn btn-primary">Display Schedule</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
			  </form>
            </div>
			
        </div><!--end of modal-dialog-->
 </div>
 <!--end of modal--> 
 
 <div id="examclass" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
	  <div class="modal-content" style="height:auto">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Search Class Exam Timetable</h4>
              </div>
              <div class="modal-body">
			  <form class="form-horizontal" method="post" action="class_exam.php" target="_blank">
                
				<div class="form-group">
					<label class="control-label col-lg-3" for="name">Level</label>
					<div class="col-lg-9">
					<select class="select2" name="class" style="width:90%!important" required>
								  <?php 
								  include('../dist/includes/dbcon.php');
									$query2=mysqli_query($con,"select * from cys order by cys")or die(mysqli_error($con));
									  while($row=mysqli_fetch_array($query2)){
								  ?>
										<option><?php echo $row['cys'];?></option>
								  <?php }
									
								  ?>
								</select>
					</div>
				</div> 
				
				
              </div><hr>
              <div class="modal-footer">
				<button type="submit" name="search" class="btn btn-primary">Display Schedule</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
			  </form>
            </div>
			
        </div><!--end of modal-dialog-->
 </div>
 <!--end of modal--> 
 <div id="examroom" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
	  <div class="modal-content" style="height:auto">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Search Level Exam Schedule</h4>
              </div>
              <div class="modal-body">
			  <form class="form-horizontal" method="post" action="room_exam.php" target="_blank">
                
				<div class="form-group">
					<label class="control-label col-lg-3" for="name">Hall</label>
					<div class="col-lg-9">
					<select class="select2" name="room" style="width:90%!important" required>
								  <?php 
								  include('../dist/includes/dbcon.php');
									$query2=mysqli_query($con,"select * from room order by room")or die(mysqli_error($con));
									  while($row=mysqli_fetch_array($query2)){
								  ?>
										<option><?php echo $row['room'];?></option>
								  <?php }
									
								  ?>
								</select>
					</div>
				</div> 
				
				
              </div>
			  
			  <hr>
              <div class="modal-footer">
				<button type="submit" name="search" class="btn btn-primary">Display Schedule</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
			  </form>
            </div>
			
        </div><!--end of modal-dialog-->
 </div>
 <!--end of modal--> 