<div class="row">
	<div class="col-md-8">
    	<div class="row">
            <!-- CALENDAR-->
            <div class="col-md-12 col-xs-12">    
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fa fa-calendar"></i>
                            <?php echo ('Event Schedule');?>
                        </div>
                    </div>
                    <div class="panel-body" style="padding:0px;">
                        <div class="calendar-env">
                            <div class="calendar-body">
                                <div id="notice_calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
	<div class="col-md-4">
		<div class="row">
            <div class="col-md-12">
            
                <div class="tile-stats tile-red">
                    <div class="icon"><i class="fa fa-users"></i></div>
                    <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('student'); ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                    
                    <h3><?php echo ('Student');?></h3>
                   <p>Total students</p>
                   <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-12">
            
                <div class="tile-stats tile-green">
                    <div class="icon"><i class="fa fa-chalkboard-teacher"></i></div>
                    <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('teacher'); ?>" data-postfix="" data-duration="800" data-delay="0">0</div>
                    
                    <h3><?php echo ('Teacher');?></h3>
                   <p>Total teachers</p>
                   <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-12">
            
                <div class="tile-stats tile-aqua">
                    <div class="icon"><i class="fa fa-book"></i></div>
                    <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('parent'); ?>" data-postfix="" data-duration="500" data-delay="0">0</div>
                    
                    <h3><?php echo ('Parent');?></h3>
                   <p>Total parents</p>
                   <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-12">
            
                <div class="tile-stats tile-blue">
                    <div class="icon"><i class="fa fa-calendar-check"></i></div>
                    <?php 
							$check	=	array(	'date' => date('Y-m-d') , 'status' => '1' );
							$query = $this->db->get_where('attendance' , $check);
							$present_today		=	$query->num_rows();
						?>
                    <div class="num" data-start="0" data-end="<?php echo $present_today; ?>" data-postfix="" data-duration="500" data-delay="0">0</div>
                    
                    <h3><?php echo ('Attendance');?></h3>
                   <p>Total present student today</p>
                   <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
                
            </div>
    	</div>
    </div>
	
</div>



    <script>
  $(document).ready(function() {
	  
	  var calendar = $('#notice_calendar');
				
				$('#notice_calendar').fullCalendar({
					header: {
						left: 'title',
						right: 'today prev,next'
					},
					
					//defaultView: 'basicWeek',
					
					editable: false,
					firstDay: 1,
					height: 530,
					droppable: false,
					
					events: [
						<?php 
						$notices	=	$this->db->get('noticeboard')->result_array();
						foreach($notices as $row):
						?>
						{
							title: "<?php echo $row['notice_title'];?>",
							start: new Date(<?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?>),
							end:	new Date(<?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?>),
							backgroundColor: 'var(--primary-color)',
							borderColor: 'var(--secondary-color)',
							textColor: '#ffffff'
						},
						<?php 
						endforeach
						?>
						
					]
				});
	});
  </script>

  

<style>
:root {
    --primary-color: #4a6cf7;
    --secondary-color: #6c5ce7;
    --success-color: #00b894;
    --info-color: #0984e3;
    --warning-color: #fdcb6e;
    --danger-color: #d63031;
    --dark-color: #2d3436;
    --light-color: #f8f9fa;
}
.tile-stats {
    position: relative;
    display: block;
    margin-bottom: 20px;
    border-radius: 12px;
    padding: 25px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}
.tile-stats:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    border-color: rgba(255, 255, 255, 0.3);
}
.tile-stats::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    opacity: 0;
    transition: opacity 0.4s ease;
}
.tile-stats:hover::before {
    opacity: 1;
}
.tile-stats .icon {
    position: absolute;
    right: 20px;
    top: 20px;
    font-size: 45px;
    opacity: 0.1;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
}
.tile-stats:hover .icon {
    transform: scale(1.1) rotate(5deg);
    opacity: 0.2;
}
.tile-stats .num {
    font-size: 38px;
    font-weight: 600;
    margin-bottom: 15px;
    color: var(--dark-color);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.tile-stats:hover .num {
    transform: scale(1.05);
    color: var(--primary-color);
}
.tile-stats h3 {
    font-size: 16px;
    margin: 0;
    padding: 0;
    color: #636e72;
    font-weight: 500;
    letter-spacing: 0.5px;
}
.progress {
    height: 6px;
    margin-top: 15px;
    background-color: rgba(0, 0, 0, 0.05);
    border-radius: 3px;
    overflow: hidden;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
}
.progress-bar {
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 0 10px rgba(74, 108, 247, 0.3);
}
.panel {
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    margin-top: 30px;
    overflow: hidden;
}
.panel-heading {
    border-radius: 12px 12px 0 0 !important;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    padding: 20px;
    border: none;
    box-shadow: 0 4px 15px rgba(74, 108, 247, 0.2);
}
.panel-title {
    font-size: 18px;
    font-weight: 600;
    letter-spacing: 0.5px;
}
.panel-title i {
    margin-right: 12px;
    font-size: 20px;
}
#notice_calendar {
    padding: 25px;
    background: transparent;
}
.fc-event {
    border-radius: 8px;
    padding: 8px;
    margin: 3px 0;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    border: none;
    box-shadow: 0 4px 15px rgba(74, 108, 247, 0.2);
    transition: all 0.3s ease;
}
.fc-event:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(74, 108, 247, 0.3);
}
.fc-button {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    border: none;
    text-shadow: none;
    box-shadow: 0 4px 15px rgba(74, 108, 247, 0.2);
    border-radius: 8px;
    padding: 8px 16px;
    transition: all 0.3s ease;
}
.fc-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(74, 108, 247, 0.3);
}
.fc-today {
    background: rgba(74, 108, 247, 0.1) !important;
    border-radius: 8px;
}
.fc-day-header {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 10px;
    font-weight: 600;
    color: var(--dark-color);
}
@media (max-width: 768px) {
    .tile-stats {
        margin-bottom: 15px;
        padding: 20px;
    }
    .tile-stats .num {
        font-size: 32px;
    }
    .tile-stats .icon {
        font-size: 35px;
    }
    .panel-heading {
        padding: 15px;
    }
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.tile-stats {
    animation: fadeIn 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}
.tile-stats:nth-child(2) { animation-delay: 0.1s; }
.tile-stats:nth-child(3) { animation-delay: 0.2s; }
.tile-stats:nth-child(4) { animation-delay: 0.3s; }
.tile-stats:nth-child(5) { animation-delay: 0.4s; }
.tile-stats:nth-child(6) { animation-delay: 0.5s; }
.tile-stats:nth-child(7) { animation-delay: 0.6s; }
.tile-stats:nth-child(8) { animation-delay: 0.7s; }
.tile-stats:nth-child(9) { animation-delay: 0.8s; }
</style>

  
