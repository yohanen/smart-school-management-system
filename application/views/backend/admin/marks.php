<!-- Bootstrap 4 CSS and DataTables CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
<style>
  .table-success { background-color: #d4edda !important; }
  .table-warning { background-color: #fff3cd !important; }
  .table-danger  { background-color: #f8d7da !important; }
  .progress { height: 20px; }
  .sticky-header th { position: sticky; top: 0; background: #fff; z-index: 2; }
</style>

<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo ('View Marks');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------>
        
	
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane  <?php if(!isset($edit_data) && !isset($personal_profile) && !isset($academic_result) )echo 'active';?>" id="list">
				<center>
                <?php echo form_open(base_url() . 'index.php?admin/marks');?>
                <table border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
                	<tr>
                        <td><?php echo ('Select Exam');?></td>
                        <td><?php echo ('Select Class');?></td>
                        <td><?php echo ('Select section');?></td>
                        <td><?php echo ('Select Subject');?></td>
                        <td>&nbsp;</td>
                	</tr>
                	<tr>
                        <td>
                        	<select name="exam_id" class="form-control"  style="float:left;">
                                <option value=""><?php echo ('Select an exam');?></option>
                                <?php 
                                $exams = $this->db->get('exam')->result_array();
                                foreach($exams as $row):
                                ?>
                                    <option value="<?php echo $row['exam_id'];?>"
                                        <?php if($exam_id == $row['exam_id'])echo 'selected';?>>
                                            <?php echo ('Class');?> <?php echo $row['name'];?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </td>
                        <td>
                        	<select name="class_id" class="form-control"  onchange="show_subjects(this.value)"  style="float:left;">
                                <option value=""><?php echo ('Select a class');?></option>
                                <?php 
                                $classes = $this->db->get('class')->result_array();
                                foreach($classes as $row):
                                ?>
                                    <option value="<?php echo $row['class_id'];?>"
                                        <?php if($class_id == $row['class_id'])echo 'selected';?>>
                                            Class <?php echo $row['name'];?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </td>
                        <td>
                            <select name="section_id" class="form-control" id="section_selector_holder">
                                <option value="">Select Class First</option>
                                <?php 
                                if($class_id != ''):
                                $sections = $this->db->get_where('section' , array('class_id' => $class_id))->result_array();
                                foreach($sections as $row):
                                ?>
                                    <option value="<?php echo $row['section_id'];?>" <?php if($section_id == $row['section_id'])echo 'selected';?>>
                                        <?php echo $row['name'];?>
                                    </option>
                                <?php endforeach; endif; ?>
                            </select>
                        </td>
                        <td>
                            <select name="subject_id" class="form-control" id="subject_selector_holder">
                                <option value="">Select Class First</option>
                                <?php 
                                if($class_id != ''):
                                $subjects = $this->db->get_where('subject' , array('class_id' => $class_id))->result_array();
                                foreach($subjects as $row):
                                ?>
                                    <option value="<?php echo $row['subject_id'];?>" <?php if($subject_id == $row['subject_id'])echo 'selected';?>>
                                        <?php echo $row['name'];?>
                                    </option>
                                <?php endforeach; endif; ?>
                            </select>
                        </td>
                        <td>
                        	<input type="hidden" name="operation" value="selection" />
                    		<input type="submit" value="<?php echo ('View Marks');?>" class="btn btn-info" />
                        </td>
                	</tr>
                </table>
                </form>
                </center>
                
                <br /><br />
                
                <?php if($exam_id >0 && $class_id >0 && $section_id > 0 && $subject_id > 0):?>
                    <div class="card mt-4">
                        <div class="card-header">
                            <strong>Exam Marks</strong>
                        </div>
                        <div class="card-body">
                            <table id="marksTable" class="table table-striped table-bordered sticky-header">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Student</th>
                                        <th>Mark Obtained (out of 100)</th>
                                        <th>Progress</th>
                                        <th>Comment</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $students = $this->db->get_where('student', array('class_id'=>$class_id, 'section_id'=>$section_id))->result_array();
                                    foreach($students as $student):
                                        $verify_data = array(
                                            'exam_id' => $exam_id,
                                            'class_id' => $class_id,
                                            'subject_id' => $subject_id,
                                            'student_id' => $student['student_id'],
                                            'section_id' => $section_id
                                        );
                                        $query = $this->db->get_where('mark', $verify_data);
                                        if($query->num_rows() > 0) {
                                            $mark = $query->row();
                                    ?>
                                    <tr class="<?= $mark->mark_obtained >= 75 ? 'table-success' : ($mark->mark_obtained >= 50 ? 'table-warning' : 'table-danger') ?>">
                                        <td><?php echo $student['name'];?></td>
                                        <td><?php echo $mark->mark_obtained;?></td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: <?php echo $mark->mark_obtained;?>%;" aria-valuenow="<?php echo $mark->mark_obtained;?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td><?php echo $mark->comment;?></td>
                                        <td>
                                            <button class="btn btn-sm btn-link edit-marks-btn"
                                                    data-student="<?php echo $student['student_id'];?>"
                                                    data-score="<?php echo $mark->mark_obtained;?>"
                                                    data-comment="<?php echo $mark->comment;?>">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php } else { ?>
                                    <tr>
                                        <td><?php echo $student['name'];?></td>
                                        <td style="text-align:center;">Not marked</td>
                                        <td style="text-align:center;">Not marked</td>
                                        <td style="text-align:center;">Not marked</td>
                                        <td style="text-align:center;">Not marked</td>
                                    </tr>
                                    <?php } endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif;?>
            </div>
            <!----TABLE LISTING ENDS-->
            
		</div>
	</div>
</div>

<!-- Edit Marks Modal -->
<div class="modal fade" id="editMarksModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="editMarksForm" method="post" action="<?php echo base_url('index.php?admin/update_marks');?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Marks</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="student_id" id="marksStudentId">
                    <div class="form-group">
                        <label>Mark Obtained</label>
                        <input type="number" name="mark_obtained" id="marksScore" class="form-control" min="0" max="100">
                    </div>
                    <div class="form-group">
                        <label>Comment</label>
                        <input type="text" name="comment" id="marksComment" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JS includes for DataTables, Bootstrap, and export buttons -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(function() {
    $('#marksTable').DataTable({
        dom: 'Bfrtip',
        buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print' ],
        paging: true,
        searching: true,
        info: false
    });
    $('.edit-marks-btn').on('click', function() {
        $('#marksStudentId').val($(this).data('student'));
        $('#marksScore').val($(this).data('score'));
        $('#marksComment').val($(this).data('comment'));
        $('#editMarksModal').modal('show');
    });
});
</script>

<script type="text/javascript">
  function show_subjects(class_id)
  {
      for(i=0;i<=100;i++)
      {

          try
          {
              document.getElementById('subject_id_'+i).style.display = 'none' ;
	  		  document.getElementById('subject_id_'+i).setAttribute("name" , "temp");
          }
          catch(err){}
      }
      document.getElementById('subject_id_'+class_id).style.display = 'block' ;
	  document.getElementById('subject_id_'+class_id).setAttribute("name" , "subject_id");
  }

$(document).ready(function() {
    $("select[name='class_id']").change(function() {
        var class_id = $(this).val();
        $.ajax({
            url: '<?php echo base_url();?>index.php?admin/get_sections/' + class_id,
            success: function(response) {
                jQuery('#section_selector_holder').html(response);
            }
        });
        $.ajax({
            url: '<?php echo base_url();?>index.php?teacher/get_class_subject/' + class_id,
            success: function(response) {
                jQuery('#subject_selector_holder').html(response);
            }
        });
    });
});

</script> 