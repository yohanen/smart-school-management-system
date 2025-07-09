<div id="loading_overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.8); z-index: 9999;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <i class="entypo-spin-1" style="font-size: 36px; color: #2c3e50;"></i>
    </div>
</div>

<?php 
    $child_of_parent = $this->db->get_where('student' , array(
        'student_id' => $student_id
    ))->result_array();
    
    if (empty($child_of_parent)): ?>
        <div class="alert alert-danger">
            <i class="entypo-cancel"></i> No student data found.
        </div>
    <?php return; endif;
    
    foreach ($child_of_parent as $row):
?>
<div class="container" style="max-width: 1200px; margin: 30px auto;">
    <div class="card" style="box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 10px;">
        <div class="card-body" style="padding: 30px;">
            <!-- Student Info Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 style="color: #2c3e50; margin: 0;">
                    <i class="entypo-user"></i> 
                    <?php echo $row['name'];?>
                    <small class="text-muted">(Roll: <?php echo $row['roll'];?>)</small>
                </h3>
                <div class="btn-group">
                    <button onclick="exportToExcel()" class="btn btn-success btn-sm">
                        <i class="entypo-download"></i> Export to Excel
                    </button>
                    <button onclick="window.print()" class="btn btn-info btn-sm">
                        <i class="entypo-print"></i> Print Report
                    </button>
                </div>
            </div>

            <!-- Exam Tabs -->
            <div class="tabs-vertical-env">
                <ul class="nav nav-tabs nav-tabs-vertical">
                    <?php 
                        $exams = $this->db->get('exam')->result_array();
                        foreach ($exams as $index => $row2):
                    ?>
                    <li class="<?php echo ($index == 0) ? 'active' : ''; ?>">
                        <a href="#<?php echo $row2['exam_id'];?>" data-toggle="tab" class="d-flex justify-content-between align-items-center">
                            <span>
                                <i class="entypo-graduation-cap"></i> 
                                <?php echo $row2['name'];?>
                            </span>
                            <small class="text-muted">( <?php echo date('d M Y', strtotime($row2['date']));?> )</small>
                        </a>
                    </li>
                    <?php endforeach;?>
                </ul>
                
                <div class="tab-content" style="background: #fff; border-radius: 0 4px 4px 0;">
                <?php 
                    foreach ($exams as $index => $exam):
                        $this->db->where('exam_id', $exam['exam_id']);
                        $this->db->where('student_id', $student_id);
                        $marks = $this->db->get('mark')->result_array();
                        
                        // Calculate statistics
                        $total_subjects = count($marks);
                        $total_marks = 0;
                        $obtained_marks = 0;
                        foreach ($marks as $mark) {
                            $total_marks += $mark['mark_total'];
                            $obtained_marks += $mark['mark_obtained'];
                        }
                        $percentage = $total_marks > 0 ? round(($obtained_marks / $total_marks) * 100, 1) : 0;
                ?>
                    <div class="tab-pane <?php echo ($index == 0) ? 'active' : ''; ?>" id="<?php echo $exam['exam_id'];?>">
                        <!-- Exam Statistics -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="small-box bg-info" style="padding: 15px; border-radius: 5px;">
                                    <h4>Total Subjects</h4>
                                    <h3><?php echo $total_subjects; ?></h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="small-box bg-success" style="padding: 15px; border-radius: 5px;">
                                    <h4>Total Marks</h4>
                                    <h3><?php echo $total_marks; ?></h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="small-box bg-warning" style="padding: 15px; border-radius: 5px;">
                                    <h4>Marks Obtained</h4>
                                    <h3><?php echo $obtained_marks; ?></h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="small-box bg-primary" style="padding: 15px; border-radius: 5px;">
                                    <h4>Percentage</h4>
                                    <h3><?php echo $percentage; ?>%</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Marks Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="marks_table">
                                <thead>
                                    <tr>
                                        <th width="15%"><?php echo ('Class');?></th>
                                        <th><?php echo ('Subject');?></th>
                                        <th width="15%"><?php echo ('Total Mark');?></th>
                                        <th width="15%"><?php echo ('Mark Obtained');?></th>
                                        <th width="15%"><?php echo ('Percentage');?></th>
                                        <th><?php echo ('Comment');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($marks as $mark):
                                    $subject_percentage = $mark['mark_total'] > 0 ? 
                                        round(($mark['mark_obtained'] / $mark['mark_total']) * 100, 1) : 0;
                                    $status_class = '';
                                    if ($subject_percentage >= 75) $status_class = 'success';
                                    elseif ($subject_percentage >= 50) $status_class = 'warning';
                                    else $status_class = 'danger';
                                ?>
                                    <tr class="<?php echo $status_class; ?>">
                                        <td>
                                            <?php echo $this->db->get_where('class', array(
                                                'class_id' => $mark['class_id']
                                            ))->row()->name;?>
                                        </td>
                                        <td>
                                            <?php echo $this->db->get_where('subject', array(
                                                'subject_id' => $mark['subject_id']
                                            ))->row()->name;?>
                                        </td>
                                        <td class="text-center"><?php echo $mark['mark_total'];?></td>
                                        <td class="text-center"><?php echo $mark['mark_obtained'];?></td>
                                        <td class="text-center">
                                            <div class="progress" style="margin-bottom: 0;">
                                                <div class="progress-bar progress-bar-<?php echo $status_class; ?>" 
                                                     style="width: <?php echo $subject_percentage; ?>%">
                                                    <?php echo $subject_percentage; ?>%
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo $mark['comment'];?></td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach;?>
                </div>
            </div>  
        </div>
    </div>
</div>

<!-- Export to Excel Function -->
<script>
// Show loading overlay when exporting
function showLoading() {
    document.getElementById('loading_overlay').style.display = 'block';
}

function hideLoading() {
    document.getElementById('loading_overlay').style.display = 'none';
}

function exportToExcel() {
    showLoading();
    try {
        var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
        tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
        tab_text = tab_text + '<x:Name>Marks Sheet</x:Name>';
        tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
        tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
        
        var table = document.getElementById('marks_table');
        if (!table || table.rows.length < 2) {
            throw new Error('No data to export');
        }
        
        tab_text = tab_text + "<table border='1px'>";
        
        for(var j = 0; j < table.rows.length ; j++) {
            tab_text = tab_text + table.rows[j].innerHTML + "</tr>";
        }
        
        tab_text = tab_text + '</table></body></html>';
        var data_type = 'data:application/vnd.ms-excel';
        
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");
        
        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
            if (window.navigator.msSaveBlob) {
                var blob = new Blob([tab_text], {
                    type: "application/csv;charset=utf-8;"
                });
                navigator.msSaveBlob(blob, 'marks_report.xls');
            }
        } else {
            var downloadLink = document.createElement("a");
            downloadLink.href = data_type + ', ' + encodeURIComponent(tab_text);
            downloadLink.download = 'marks_report.xls';
    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
    tab_text = tab_text + '<x:Name>Marks Sheet</x:Name>';
    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
    
    var table = document.getElementById('marks_table');
    tab_text = tab_text + "<table border='1px'>";
    
    for(var j = 0; j < table.rows.length ; j++) {
        tab_text = tab_text + table.rows[j].innerHTML + "</tr>";
    }
    
    tab_text = tab_text + '</table></body></html>';
    var data_type = 'data:application/vnd.ms-excel';
    
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    
    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        if (window.navigator.msSaveBlob) {
            var blob = new Blob([tab_text], {
                type: "application/csv;charset=utf-8;"
            });
            navigator.msSaveBlob(blob, 'marks_report.xls');
        }
    } else {
        var downloadLink = document.createElement("a");
        downloadLink.href = data_type + ', ' + encodeURIComponent(tab_text);
        downloadLink.download = 'marks_report.xls';
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
}
</script>

<!-- Print Styles -->
<style media="print">
    .btn-group, .nav-tabs-vertical { display: none !important; }
    .tab-content > .tab-pane { display: block !important; opacity: 1 !important; }
    .card { box-shadow: none !important; }
    .progress { border: 1px solid #ddd; }
    .small-box { border: 1px solid #ddd; }
</style>
<?php endforeach;?>