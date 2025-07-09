<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-plus-circled"></i>
                    <?php echo ('Send Attendance Report'); ?>
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?admin/send_attendance' , array('class' => 'form-horizontal form-groups-bordered validate'));?>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo ('Date');?></label>
                    <div class="col-sm-5">
                        <div class="date-and-time">
                            <input type="text" name="timestamp" class="form-control datepicker" data-format="dd/mm/yyyy">
                        </div>
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
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo ('Generate and Send Report');?></button>
                    </div>
                </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div> 