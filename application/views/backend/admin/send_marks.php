<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-plus-circled"></i>
                    <?php echo ('Send Marks Report'); ?>
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?admin/send_marks' , array('class' => 'form-horizontal form-groups-bordered validate'));?>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo ('Exam');?></label>
                    <div class="col-sm-5">
                        <select name="exam_id" class="form-control">
                            <option value=""><?php echo ('Select Exam');?></option>
                            <?php 
                            $exams = $this->db->get('exam')->result_array();
                            foreach($exams as $row):
                            ?>
                                <option value="<?php echo $row['exam_id'];?>">
                                    <?php echo $row['name'];?>
                                </option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo ('Class');?></label>
                    <div class="col-sm-5">
                        <select name="class_id" class="form-control" onchange="select_section(this.value)">
                            <option value=""><?php echo ('Select Class');?></option>
                            <?php 
                            $classes = $this->db->get('class')->result_array();
                            foreach($classes as $row):
                            ?>
                                <option value="<?php echo $row['class_id'];?>">
                                    Class <?php echo $row['name'];?>
                                </option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo ('Section');?></label>
                    <div class="col-sm-5">
                        <select name="section_id" class="form-control" id="section_selector_holder">
                            <option value=""><?php echo ('Select Class First');?></option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo ('Student');?></label>
                    <div class="col-sm-5">
                        <select name="student_id" class="form-control" id="student_selector_holder">
                            <option value=""><?php echo ('Select Section First');?></option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo ('Generate and Send Report');?></button>
                    </div>
                </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div> 

<?php if (!empty($pdf_file_url) && !empty($parent_phone)): ?>
<div class="row">
    <div class="col-md-12 text-center" style="margin-top: 30px;">
        <div class="alert alert-success">
            <strong>Report generated!</strong> <a href="<?php echo $pdf_file_url; ?>" target="_blank">Download PDF</a>
        </div>
        <?php 
            $wa_message = urlencode("Hello, here is the marks report for $student_name: $pdf_file_url");
            $wa_url = "https://wa.me/" . preg_replace('/[^0-9]/', '', $parent_phone) . "?text=$wa_message";
        ?>
        <a href="<?php echo $wa_url; ?>" target="_blank" class="btn btn-success btn-lg">
            <i class="fa fa-whatsapp"></i> Send to WhatsApp
        </a>
    </div>
</div>
<?php endif; ?>

<script type="text/javascript">
function select_section(class_id) {
    $.ajax({
        url: baseurl + 'index.php?admin/get_sections/' + class_id,
        success: function(response) {
            jQuery('#section_selector_holder').html(response);
            jQuery('#student_selector_holder').html('<option value="">Select Section First</option>');
        }
    });
}

$('#section_selector_holder').change(function() {
    var class_id = $('select[name=class_id]').val();
    var section_id = $(this).val();
    if (class_id && section_id) {
        $.ajax({
            url: baseurl + 'index.php?admin/get_students/' + class_id + '/' + section_id,
            success: function(response) {
                jQuery('#student_selector_holder').html(response);
            }
        });
    }
});
</script> 