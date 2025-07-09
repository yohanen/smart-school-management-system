<!-- Bootstrap 4 CSS and DataTables CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<style>
  .table-success { background-color: #d4edda !important; }
  .table-warning { background-color: #fff3cd !important; }
  .table-danger  { background-color: #f8d7da !important; }
  .progress { height: 20px; }
  .present-badge { background: #28a745; color: #fff; padding: 5px 10px; border-radius: 15px; }
  .absent-badge { background: #dc3545; color: #fff; padding: 5px 10px; border-radius: 15px; }
  .not-marked-badge { background: #6c757d; color: #fff; padding: 5px 10px; border-radius: 15px; }
  .sticky-header th { position: sticky; top: 0; background: #fff; z-index: 2; }
  .subject-header { 
    background: linear-gradient(45deg, #3498db, #2ecc71);
    color: white;
    padding: 10px;
    font-weight: bold;
    text-align: center;
    border-radius: 5px;
    transition: all 0.3s ease;
  }
  .subject-header:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }
  .stats-card {
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    padding: 15px;
    transition: transform 0.3s ease;
  }
  .stats-card:hover {
    transform: translateY(-5px);
  }
  .quick-filter-btn {
    margin: 5px;
    border-radius: 20px;
    padding: 5px 15px;
  }
  .search-box {
    border-radius: 20px;
    padding: 10px 20px;
    border: 1px solid #ddd;
    margin-bottom: 20px;
  }

  /* Print-specific styles */
  @media print {
    .no-print {
        display: none !important;
    }
    .print-only {
        display: block !important;
    }
    .panel {
        border: none !important;
        box-shadow: none !important;
    }
    .stats-card {
        page-break-inside: avoid;
        border: 1px solid #ddd;
    }
    .table {
        border-collapse: collapse !important;
    }
    .table td, .table th {
        background-color: #fff !important;
        border: 1px solid #ddd !important;
    }
    .subject-header {
        background: none !important;
        color: #000 !important;
        border: 1px solid #ddd !important;
    }
    .label-success {
        color: #28a745 !important;
        border: 1px solid #28a745 !important;
        background: none !important;
    }
    .label-danger {
        color: #dc3545 !important;
        border: 1px solid #dc3545 !important;
        background: none !important;
    }
    .label-default {
        color: #6c757d !important;
        border: 1px solid #6c757d !important;
        background: none !important;
    }
    @page {
        size: landscape;
        margin: 1cm;
    }
    .print-header {
        text-align: center;
        margin-bottom: 20px;
    }
  }

  .print-btn {
    background: #007bff;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 15px;
  }

  .print-btn:hover {
    background: #0056b3;
    transform: translateY(-2px);
  }

  .print-only {
    display: none;
  }
</style>

<!-- Statistics Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stats-card bg-info text-white">
            <h5><i class="fas fa-users"></i> Total Students</h5>
            <h3 id="totalStudents"><?php echo isset($students) ? count($students) : '0'; ?></h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card bg-success text-white">
            <h5><i class="fas fa-check"></i> Present Today</h5>
            <h3 id="presentCount">
                <?php 
                if(isset($attendance_data)) {
                    $present_count = 0;
                    foreach($attendance_data as $student_attendance) {
                        foreach($student_attendance as $subject_attendance) {
                            if($subject_attendance['status'] == 1) {
                                $present_count++;
                            }
                        }
                    }
                    echo $present_count;
                } else {
                    echo '0';
                }
                ?>
            </h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card bg-danger text-white">
            <h5><i class="fas fa-times"></i> Absent Today</h5>
            <h3 id="absentCount">
                <?php 
                if(isset($attendance_data)) {
                    $absent_count = 0;
                    foreach($attendance_data as $student_attendance) {
                        foreach($student_attendance as $subject_attendance) {
                            if($subject_attendance['status'] == 2) {
                                $absent_count++;
                            }
                        }
                    }
                    echo $absent_count;
                } else {
                    echo '0';
                }
                ?>
            </h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card bg-warning text-white">
            <h5><i class="fas fa-percentage"></i> Attendance Rate</h5>
            <h3 id="attendanceRate">
                <?php 
                if(isset($attendance_data)) {
                    $total_entries = 0;
                    $present_entries = 0;
                    foreach($attendance_data as $student_attendance) {
                        foreach($student_attendance as $subject_attendance) {
                            $total_entries++;
                            if($subject_attendance['status'] == 1) {
                                $present_entries++;
                            }
                        }
                    }
                    echo $total_entries > 0 ? round(($present_entries / $total_entries) * 100) : '0';
                } else {
                    echo '0';
                }
                ?>%
            </h3>
        </div>
    </div>
</div>

<!-- Quick Filters and Search -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="btn-group">
            <button class="btn btn-outline-primary quick-filter-btn" onclick="filterDate('today')">Today</button>
            <button class="btn btn-outline-primary quick-filter-btn" onclick="filterDate('week')">This Week</button>
            <button class="btn btn-outline-primary quick-filter-btn" onclick="filterDate('month')">This Month</button>
        </div>
    </div>
    <div class="col-md-6">
        <input type="text" class="form-control search-box" id="studentSearch" placeholder="Search by name, roll number...">
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-plus-circled"></i>
                    <?php echo ('View Attendance'); ?>
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?admin/manage_attendance', array('class' => 'form-horizontal form-groups-bordered validate')); ?>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo ('Date'); ?></label>
                    <div class="col-sm-5">
                        <div class="row">
                            <div class="col-xs-4">
                                <select name="day" class="form-control">
                                    <option value="">Day</option>
                                    <?php for($i=1; $i<=31; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php if(isset($day) && $day==$i) echo 'selected="selected"'; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <select name="month" class="form-control">
                                    <option value="">Month</option>
                                    <?php 
                                    $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                                    for($i=1; $i<=12; $i++): 
                                    ?>
                                        <option value="<?php echo $i; ?>" <?php if(isset($month) && $month==$i) echo 'selected="selected"'; ?>><?php echo $months[$i-1]; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <select name="year" class="form-control">
                                    <option value="">Year</option>
                                    <?php for($i=2020; $i<=2030; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php if(isset($year) && $year==$i) echo 'selected="selected"'; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo ('Class'); ?></label>
                    <div class="col-sm-5">
                        <select name="class_id" class="form-control" onchange="get_sections(this.value)">
                            <option value=""><?php echo ('Select Class'); ?></option>
                            <?php 
                            $classes = $this->db->get('class')->result_array();
                            foreach($classes as $row): 
                            ?>
                                <option value="<?php echo $row['class_id']; ?>" <?php if(isset($class_id) && $class_id==$row['class_id']) echo 'selected="selected"'; ?>>
                                    <?php echo $row['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo ('Section'); ?></label>
                    <div class="col-sm-5">
                        <select name="section_id" class="form-control" id="section_selector_holder">
                            <option value=""><?php echo ('Select Class First'); ?></option>
                            <?php 
                            if(isset($class_id) && $class_id != ''): 
                                $sections = $this->db->get_where('section', array('class_id' => $class_id))->result_array();
                                foreach($sections as $row): 
                            ?>
                                <option value="<?php echo $row['section_id']; ?>" <?php if(isset($section_id) && $section_id==$row['section_id']) echo 'selected="selected"'; ?>>
                                    <?php echo $row['name']; ?>
                                </option>
                            <?php 
                                endforeach;
                            endif; 
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo ('View Attendance'); ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<!-- Add print button after the statistics cards -->
<div class="row mb-4">
    <div class="col-md-12 text-right">
        <button class="print-btn no-print" onclick="printAttendance()">
            <i class="fas fa-print"></i> Print Attendance Report
        </button>
    </div>
</div>

<!-- Add print header (hidden by default) -->
<div class="print-only print-header">
    <h2>Attendance Report</h2>
    <p>Date: <?php echo isset($day) && isset($month) && isset($year) ? date('d F Y', strtotime($year.'-'.$month.'-'.$day)) : date('d F Y'); ?></p>
    <?php if(isset($class_id) && isset($section_id)): ?>
    <p>Class: <?php echo $this->db->get_where('class', array('class_id' => $class_id))->row()->name; ?> - 
       Section: <?php echo $this->db->get_where('section', array('section_id' => $section_id))->row()->name; ?></p>
    <?php endif; ?>
</div>

<?php if(isset($students) && isset($subjects) && !empty($students) && !empty($subjects)): ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-users"></i>
                    <?php echo ('Attendance for ' . date('d M Y', strtotime($year.'-'.$month.'-'.$day))); ?>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered" id="attendanceTable">
                    <thead>
                        <tr>
                            <th><?php echo ('Roll'); ?></th>
                            <th><?php echo ('Name'); ?></th>
                            <?php foreach($subjects as $subject): ?>
                                <th class="subject-header"><?php echo $subject['name']; ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($students as $student): ?>
                        <tr>
                            <td><?php echo $student['roll']; ?></td>
                            <td><?php echo $student['name']; ?></td>
                            <?php foreach($subjects as $subject): ?>
                                <td>
                                    <?php 
                                    $attendance = isset($attendance_data[$student['student_id']][$subject['subject_id']]) 
                                        ? $attendance_data[$student['student_id']][$subject['subject_id']] 
                                        : null;
                                    
                                    if($attendance): 
                                        $status = $attendance['status'];
                                        $class = $status == 1 ? 'success' : ($status == 2 ? 'danger' : 'default');
                                        $text = $status == 1 ? 'Present' : ($status == 2 ? 'Absent' : 'Not Marked');
                                    ?>
                                        <span class="label label-<?php echo $class; ?>"><?php echo $text; ?></span>
                                    <?php else: ?>
                                        <span class="label label-default">Not Marked</span>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script type="text/javascript">
    function get_sections(class_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?admin/get_sections/' + class_id,
            success: function(response) {
                $('#section_selector_holder').html(response);
            }
        });
    }
</script>

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
    // Initialize DataTable with enhanced features
    var table = $('#attendanceTable').DataTable({
        dom: '<"row"<"col-sm-6"B><"col-sm-6"f>>rtip',
        buttons: [
            {
                extend: 'collection',
                text: '<i class="fas fa-download"></i> Export',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            }
        ],
        paging: true,
        searching: true,
        info: true,
        responsive: true,
        initComplete: function() {
            updateStatistics();
        }
    });

    // Real-time search
    $('#studentSearch').on('keyup', function() {
        table.search(this.value).draw();
        updateStatistics();
    });

    // Update statistics based on visible rows
    function updateStatistics() {
        var visibleRows = table.rows({search: 'applied'}).nodes();
        var totalStudents = visibleRows.length;
        var presentCount = 0;
        var absentCount = 0;

        $(visibleRows).each(function() {
            var row = $(this);
            var presentInRow = row.find('.label-success').length;
            var absentInRow = row.find('.label-danger').length;
            
            if (presentInRow > 0) presentCount += presentInRow;
            if (absentInRow > 0) absentCount += absentInRow;
        });

        var totalEntries = presentCount + absentCount;
        var attendanceRate = totalEntries > 0 ? Math.round((presentCount / totalEntries) * 100) : 0;

        // Update the statistics cards
        $('#totalStudents').text(totalStudents);
        $('#presentCount').text(presentCount);
        $('#absentCount').text(absentCount);
        $('#attendanceRate').text(attendanceRate + '%');
    }

    // Add event listener for DataTables search and sort
    table.on('search.dt draw.dt', function() {
        updateStatistics();
    });

    // Date filter functions
    window.filterDate = function(period) {
        var today = new Date();
        var day = today.getDate();
        var month = today.getMonth() + 1;
        var year = today.getFullYear();

        switch(period) {
            case 'today':
                $('[name="day"]').val(day);
                $('[name="month"]').val(month);
                $('[name="year"]').val(year);
                break;
            case 'week':
                // Set to current week
                break;
            case 'month':
                $('[name="month"]').val(month);
                $('[name="year"]').val(year);
                break;
        }
        // Trigger form submission
        $('form').submit();
    }

    // Add hover effects to subject headers
    $('.subject-header').hover(
        function() { $(this).css('opacity', '0.9'); },
        function() { $(this).css('opacity', '1'); }
    );

    // Add print function
    window.printAttendance = function() {
        // Update print header with current filter values
        var selectedDate = $('[name="day"]').val() + ' ' + 
                          $('[name="month"] option:selected').text() + ' ' + 
                          $('[name="year"]').val();
        var selectedClass = $('[name="class_id"] option:selected').text();
        var selectedSection = $('[name="section_id"] option:selected').text();
        
        // Store current document title
        var originalTitle = document.title;
        
        // Set print-specific title
        document.title = 'Attendance Report - ' + selectedDate;
        
        // Print the document
        window.print();
        
        // Restore original title
        document.title = originalTitle;
    }

    // Add print event listener to handle table expansion
    window.addEventListener('beforeprint', function() {
        // Temporarily remove DataTables pagination
        if($.fn.DataTable.isDataTable('#attendanceTable')) {
            $('#attendanceTable').DataTable().destroy();
        }
    });

    window.addEventListener('afterprint', function() {
        // Reinitialize DataTables after printing
        if(!$.fn.DataTable.isDataTable('#attendanceTable')) {
            initializeDataTable();
        }
    });

    // Function to initialize DataTable
    function initializeDataTable() {
        var table = $('#attendanceTable').DataTable({
            dom: '<"row"<"col-sm-6"B><"col-sm-6"f>>rtip',
            buttons: [
                {
                    extend: 'collection',
                    text: '<i class="fas fa-download"></i> Export',
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            ],
            paging: true,
            searching: true,
            info: true,
            responsive: true,
            initComplete: function() {
                updateStatistics();
            }
        });
    }
});
</script>