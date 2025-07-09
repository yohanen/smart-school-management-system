<?php 
// Get the child info
$child = $this->db->get_where('student', array('student_id' => $student_id))->row();

if (!$child): ?>
    <div class="alert alert-danger">
        <i class="entypo-cancel"></i> No student data found.
    </div>
    <?php return; endif;
?>

<div id="attendance_loading_overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.8); z-index: 9999;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <i class="entypo-spin-1" style="font-size: 36px; color: #2c3e50;"></i>
    </div>
</div>

<div class="container" style="max-width: 1000px; margin: 30px auto;">
    <div class="card" style="box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 10px;">
        <div class="card-body" style="padding: 30px;">
            <!-- Student Info Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 style="color: #2c3e50; margin: 0;">
                    <i class="entypo-user"></i> 
                    <?php echo $child->name; ?>
                    <small class="text-muted">(Roll: <?php echo $child->roll; ?>)</small>
                </h3>
            </div>

            <!-- Date Selection Form -->
            <form method="post" action="" class="form-inline mb-4">
                <div class="row w-100">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date" class="mb-2">Date</label>
                            <select name="date" id="date" class="form-control w-100">
                                <?php for($i=1;$i<=31;$i++):?>
                                    <option value="<?php echo $i;?>" <?php if(isset($_POST['date']) && $_POST['date']==$i)echo 'selected="selected"';?>><?php echo $i;?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="month" class="mb-2">Month</label>
                            <select name="month" id="month" class="form-control w-100">
                                <?php 
                                $months = array('','January','February','March','April','May','June','July','August','September','October','November','December');
                                for($i=1;$i<=12;$i++):?>
                                    <option value="<?php echo $i;?>" <?php if(isset($_POST['month']) && $_POST['month']==$i)echo 'selected="selected"';?>><?php echo $months[$i];?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="year" class="mb-2">Year</label>
                            <select name="year" id="year" class="form-control w-100">
                                <?php for($i=2030;$i>=2010;$i--):?>
                                    <option value="<?php echo $i;?>" <?php if(isset($_POST['year']) && $_POST['year']==$i)echo 'selected="selected"';?>><?php echo $i;?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="mb-2">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="entypo-search"></i> Show Attendance
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <?php 
            if(isset($_POST['date']) && isset($_POST['month']) && isset($_POST['year'])): 
                $date = $_POST['date'];
                $month = $_POST['month'];
                $year = $_POST['year'];
                $full_date = $year.'-'.$month.'-'.$date;
                $verify_data = array('student_id' => $student_id, 'date' => $full_date);
                $attendance = $this->db->get_where('attendance', $verify_data)->row();
                $status = isset($attendance->status) ? $attendance->status : 0;
            ?>
            <!-- Daily Attendance -->
            <div class="attendance-info mb-4">
                <h4 class="text-center mb-4" style="color: #34495e;">
                    <i class="entypo-calendar"></i> 
                    Attendance on <?php echo $date.'-'.$months[$month].'-'.$year;?>
                </h4>
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th class="text-center">Roll</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center"><?php echo $child->roll;?></td>
                                <td class="text-center"><?php echo $child->name;?></td>
                                <td class="text-center">
                                    <?php if ($status == 1):?>
                                        <span class="badge" style="background: #27ae60; font-size: 14px; padding: 8px 16px;">
                                            <i class="entypo-check"></i> Present
                                        </span>
                                    <?php elseif ($status == 2):?>
                                        <span class="badge" style="background: #c0392b; font-size: 14px; padding: 8px 16px;">
                                            <i class="entypo-cancel"></i> Absent
                                        </span>
                                    <?php else:?>
                                        <span class="badge" style="background: #bdc3c7; font-size: 14px; padding: 8px 16px; color: #333;">
                                            <i class="entypo-minus"></i> Not Marked
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php 
            // Calculate attendance percentage for the month
            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $present_count = 0;
            $absent_count = 0;
            $not_marked_count = 0;
            $summary_rows = array();
            
            for($d=1; $d<=$days_in_month; $d++) {
                $date_str = $year.'-'.$month.'-'.$d;
                $att = $this->db->get_where('attendance', array('student_id' => $student_id, 'date' => $date_str))->row();
                $stat = isset($att->status) ? $att->status : 0;
                
                if ($stat == 1) $present_count++;
                elseif ($stat == 2) $absent_count++;
                else $not_marked_count++;
                
                $summary_rows[] = array('date' => $d.'-'.$months[$month].'-'.$year, 'status' => $stat);
            }
            
            $total_marked = $present_count + $absent_count;
            $percentage = $total_marked > 0 ? round(($present_count/$total_marked)*100, 1) : 0;
            ?>
            
            <!-- Monthly Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="small-box" style="background: #27ae60; color: white; padding: 15px; border-radius: 5px;">
                        <h4>Present Days</h4>
                        <h3><?php echo $present_count; ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box" style="background: #c0392b; color: white; padding: 15px; border-radius: 5px;">
                        <h4>Absent Days</h4>
                        <h3><?php echo $absent_count; ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box" style="background: #bdc3c7; color: #333; padding: 15px; border-radius: 5px;">
                        <h4>Not Marked</h4>
                        <h3><?php echo $not_marked_count; ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box" style="background: #2980b9; color: white; padding: 15px; border-radius: 5px;">
                        <h4>Attendance Rate</h4>
                        <h3><?php echo $percentage; ?>%</h3>
                    </div>
                </div>
            </div>

            <!-- Export Buttons -->
            <div class="text-right mb-4">
                <button onclick="exportTableToCSV('attendance_summary.csv')" class="btn btn-success btn-sm">
                    <i class="entypo-download"></i> Export to Excel
                </button>
                <button onclick="window.print()" class="btn btn-info btn-sm">
                    <i class="entypo-print"></i> Print Report
                </button>
            </div>

            <!-- Monthly Summary -->
            <div class="monthly-summary">
                <h4 class="text-center mb-4" style="color: #2980b9;">
                    <i class="entypo-calendar"></i> 
                    Monthly Attendance Summary (<?php echo $months[$month].' '.$year; ?>)
                </h4>
                
                <div class="table-responsive">
                    <table id="attendance_summary" class="table table-bordered">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th class="text-center">Date</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($summary_rows as $row) {
                                echo '<tr>';
                                echo '<td class="text-center">'.$row['date'].'</td>';
                                echo '<td class="text-center">';
                                if ($row['status'] == 1) {
                                    echo '<span class="badge" style="background: #27ae60; font-size: 12px; padding: 6px 12px;">
                                            <i class="entypo-check"></i> Present
                                          </span>';
                                } elseif ($row['status'] == 2) {
                                    echo '<span class="badge" style="background: #c0392b; font-size: 12px; padding: 6px 12px;">
                                            <i class="entypo-cancel"></i> Absent
                                          </span>';
                                } else {
                                    echo '<span class="badge" style="background: #bdc3c7; font-size: 12px; padding: 6px 12px; color: #333;">
                                            <i class="entypo-minus"></i> Not Marked
                                          </span>';
                                }
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Export to Excel Function -->
<script type="text/javascript">
function showLoading() {
    document.getElementById('attendance_loading_overlay').style.display = 'block';
}

function hideLoading() {
    document.getElementById('attendance_loading_overlay').style.display = 'none';
}

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;
    csvFile = new Blob([csv], {type: "text/csv"});
    downloadLink = document.createElement("a");
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
}

function exportTableToCSV(filename) {
    showLoading();
    try {
        var csv = [];
        var table = document.getElementById('attendance_summary');
        
        if (!table || table.rows.length < 2) {
            throw new Error('No data to export');
        }
        
        var rows = table.querySelectorAll("tr");
        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");
            for (var j = 0; j < cols.length; j++)
                row.push('"' + cols[j].innerText.replace(/"/g, '""') + '"');
            csv.push(row.join(","));
        }
        downloadCSV(csv.join("\n"), filename);
    } catch (error) {
        alert('Error exporting data: ' + error.message);
    } finally {
        hideLoading();
    }
}

// Add form submission handling
document.querySelector('form').addEventListener('submit', function(e) {
    var date = document.getElementById('date').value;
    var month = document.getElementById('month').value;
    var year = document.getElementById('year').value;
    
    if (!date || !month || !year) {
        e.preventDefault();
        alert('Please select all date fields');
        return false;
    }
    showLoading();
});

// Add table row hover effect
document.querySelectorAll('#attendance_summary tbody tr').forEach(row => {
    row.addEventListener('mouseover', function() {
        this.style.backgroundColor = '#f5f5f5';
    });
    row.addEventListener('mouseout', function() {
        this.style.backgroundColor = '';
    });
});
</script>

<!-- Print Styles -->
<style media="print">
    #attendance_loading_overlay { display: none !important; }
    .btn-group, form { display: none !important; }
    .card { box-shadow: none !important; }
    .small-box { border: 1px solid #ddd; }
    @page { size: portrait; margin: 1cm; }
    .attendance-info { page-break-after: always; }
    .monthly-summary { page-break-before: always; }
    @media print {
        .pagebreak { page-break-before: always; }
    }
</style>