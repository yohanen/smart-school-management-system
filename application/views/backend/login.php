<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	$system_name	=	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
	$system_title	=	$this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;
	?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Neon Admin Panel" />
	<meta name="author" content="" />
	
	<title><?php echo ('Login');?> | <?php echo $system_title;?></title>
	

	<link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/neon-core.css">
	<link rel="stylesheet" href="assets/css/neon-theme.css">
	<link rel="stylesheet" href="assets/css/neon-forms.css">
	<link rel="stylesheet" href="assets/css/custom.css">

	<!-- Modern Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">

	<script src="assets/js/jquery-1.11.0.min.js"></script>

	<!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link rel="shortcut icon" href="assets/images/favicon.png">
	
	<!-- Add FontAwesome for WhatsApp icon support -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	
	<style>
		body.login-page {
			margin: 0;
			padding: 0;
			font-family: 'Poppins', Arial, sans-serif;
			background: url('assets/images/school-bg.jpg') no-repeat center center fixed;
			background-size: cover;
			min-height: 100vh;
			box-sizing: border-box;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.login-container {
			background: #fff;
			box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
			border-radius: 12px;
			max-width: 400px;
			width: 100%;
			margin: 40px auto;
			padding: 36px 28px 28px 28px;
			box-sizing: border-box;
			display: flex;
			flex-direction: column;
			align-items: center;
		}
		.login-header .logo img {
			display: block;
			margin: 0 auto 18px auto;
			max-width: 220px;
			max-height: 80px;
			border-radius: 8px;
			box-shadow: none;
		}
		.login-header h2 {
			display: none;
		}
		.login-content .form-group {
			margin-bottom: 18px;
		}
		.input-group.input-icon {
			position: relative;
			width: 100%;
		}
		.input-group.input-icon .input-group-addon {
			position: absolute;
			top: 0;
			bottom: 0;
			left: 12px;
			display: flex;
			align-items: center;
			background: transparent;
			border: none;
			color: #2196f3 !important;
			font-size: 1.2em;
			pointer-events: none;
			height: 100%;
			z-index: 2;
		}
		.input-group.input-icon input.form-control,
		.input-group.input-icon select.form-control {
			padding-left: 40px !important;
			height: 44px;
			border-radius: 6px;
			border: 1.5px solid #d1d5db;
			background: #f8fafc;
			font-size: 1em;
			box-shadow: none;
			transition: border 0.2s;
		}
		.input-group.input-icon input.form-control:focus,
		.input-group.input-icon select.form-control:focus {
			border: 1.5px solid #2196f3;
			background: #fff;
			outline: none;
		}
		.input-group.input-icon select.form-control {
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
			padding-right: 30px;
			background: #f8fafc;
			color: #222;
		}
		.input-group.input-icon select.form-control option {
			background: #fff;
			color: #222;
		}
		.input-group.input-icon select.form-control option:checked,
		.input-group.input-icon select.form-control option:hover,
		.input-group.input-icon select.form-control option:focus {
			background: #2196f3 !important;
			color: #fff !important;
		}
		.input-group.input-icon:after {
			content: '\25BC';
			position: absolute;
			right: 16px;
			top: 50%;
			transform: translateY(-50%);
			color: #888;
			font-size: 1em;
			pointer-events: none;
			z-index: 2;
			display: none;
		}
		.input-group.input-icon select.form-control + .toggle-password {
			display: none;
		}
		.input-group.input-icon select.form-control ~ .toggle-password {
			display: none;
		}
		.input-group.input-icon select.form-control ~ .input-group-addon {
			display: flex;
		}
		.input-group.input-icon select.form-control:after {
			display: block;
		}
		.toggle-password {
			position: absolute;
			right: 14px;
			top: 50%;
			transform: translateY(-50%);
			cursor: pointer;
			color: #2196f3 !important;
			font-size: 1.2em;
			z-index: 3;
		}
		.btn-login {
			background: #2196f3;
			color: #fff;
			font-weight: 700;
			border-radius: 6px;
			padding: 12px 0;
			font-size: 1.1em;
			box-shadow: 0 2px 8px rgba(33,150,243,0.10);
			border: none;
			letter-spacing: 1px;
			transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
			width: 100%;
		}
		.btn-login:hover {
			background: #1976d2;
			transform: translateY(-2px) scale(1.02);
			box-shadow: 0 4px 16px rgba(33,150,243,0.18);
		}
		.captcha-box {
			display: flex;
			align-items: center;
			background: #f0f4f8;
			border-radius: 6px;
			padding: 6px 12px;
			margin-bottom: 18px;
			font-family: 'Poppins', Arial, sans-serif;
			font-size: 1.2em;
			letter-spacing: 2px;
			user-select: none;
		}
		.captcha-img {
			height: 36px;
			margin-right: 12px;
		}
		.captcha-refresh {
			color: #2196f3;
			font-size: 1.4em;
			margin-right: 10px;
			cursor: pointer;
		}
		.login-bottom-links {
			margin-top: 18px;
			text-align: left;
			width: 100%;
		}
		.login-bottom-links .link {
			color: #222;
			font-weight: 500;
			text-decoration: none;
			font-size: 1em;
			margin-right: 18px;
			transition: color 0.2s;
		}
		.login-bottom-links .link:hover {
			color: #2196f3;
		}
		@media (max-width: 600px) {
			body.login-page {
				padding: 8px 0;
			}
			.login-container {
				margin: 0 auto;
				padding: 10px 2px 8px 2px;
				min-height: 0;
			}
			.login-header .logo img {
				max-width: 90vw;
			}
		}
		.captcha-text {
			font-weight: bold;
			font-size: 1.2em;
			color: #1976d2;
			margin-right: 12px;
			background: #fff;
			padding: 4px 12px;
			border-radius: 4px;
			box-shadow: 0 1px 4px rgba(33,150,243,0.08);
			letter-spacing: 3px;
			font-family: 'Poppins', Arial, sans-serif;
		}
		.top-right-links {
			position: fixed;
			top: 24px;
			right: 36px;
			z-index: 1000;
			background: rgba(255,255,255,0.85);
			border-radius: 8px;
			box-shadow: 0 2px 8px rgba(0,0,0,0.08);
			padding: 8px 18px;
			display: flex;
			gap: 16px;
			align-items: center;
		}
		.top-right-links .trl-link {
			color: #1976d2;
			font-weight: 500;
			text-decoration: none;
			font-size: 1em;
			margin: 0 4px;
			transition: color 0.2s;
			display: flex;
			align-items: center;
		}
		.top-right-links .trl-link:hover {
			color: #2196f3;
			text-decoration: underline;
		}
		.top-right-links .entypo-facebook,
		.top-right-links .entypo-twitter,
		.top-right-links .entypo-linkedin {
			font-size: 1.2em;
			margin-left: 2px;
		}
		.top-right-links .entypo-instagram,
		.top-right-links .entypo-whatsapp {
			font-size: 1.2em;
			margin-left: 2px;
		}
		@media (max-width: 600px) {
			.top-right-links {
				top: 8px;
				right: 8px;
				padding: 6px 8px;
				gap: 8px;
				font-size: 0.95em;
			}
		}
		.custom-modal {
			display: none;
			position: fixed;
			z-index: 2000;
			left: 0;
			top: 0;
			width: 100vw;
			height: 100vh;
			overflow: auto;
			background: rgba(0,0,0,0.35);
			justify-content: center;
			align-items: center;
		}
		.custom-modal.show {
			display: flex !important;
		}
		.custom-modal-content {
			background: #fff;
			padding: 0 0 24px 0;
			border-radius: 10px;
			max-width: 520px;
			width: 90vw;
			box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
			position: relative;
			font-family: 'Poppins', Arial, sans-serif;
			color: #222;
			animation: fadeInModal 0.3s;
			max-height: 90vh;
			overflow-y: auto;
		}
		.custom-modal-header {
			background: #1976d2;
			color: #fff;
			border-radius: 10px 10px 0 0;
			padding: 24px 28px 12px 28px;
			position: relative;
			text-align: center;
		}
		.custom-modal-header h2 {
			margin: 12px 0 0 0;
			font-size: 1.5em;
			font-weight: 600;
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 10px;
		}
		.custom-modal-header .entypo-info,
		.custom-modal-header .entypo-mail {
			font-size: 1.2em;
		}
		.modal-logo {
			max-width: 80px;
			max-height: 80px;
			margin: 0 auto 8px auto;
			display: block;
			border-radius: 8px;
			background: #fff;
			box-shadow: 0 2px 8px rgba(33,150,243,0.10);
		}
		.custom-modal-close {
			position: absolute;
			top: 12px;
			right: 18px;
			font-size: 2em;
			color: #fff;
			cursor: pointer;
			font-weight: bold;
			transition: color 0.2s;
			z-index: 10;
		}
		.custom-modal-close:hover {
			color: #ffeb3b;
		}
		.custom-modal-body {
			padding: 18px 28px 0 28px;
			color: #222;
			background: #fff;
			border-radius: 0 0 10px 10px;
		}
		.custom-modal-body b {
			color: #1976d2;
		}
		.custom-modal-body i {
			color: #1976d2;
			margin-right: 4px;
		}
		@media (max-width: 600px) {
			.custom-modal-header, .custom-modal-body {
				padding-left: 6vw;
				padding-right: 6vw;
			}
			.modal-logo {
				max-width: 60px;
				max-height: 60px;
			}
		}
		@keyframes fadeInModal {
			from { opacity: 0; transform: translateY(-30px); }
			to { opacity: 1; transform: translateY(0); }
		}
		@media (max-width: 600px) {
			.custom-modal-content {
				padding: 16px 6vw 12px 6vw;
				max-width: 98vw;
				font-size: 0.98em;
			}
		}
		.modal-divider {
			border: none;
			border-top: 1.5px solid #e3e8ee;
			margin: 16px 0 14px 0;
		}
		.modal-list {
			list-style: disc inside;
			margin: 0 0 0 10px;
			padding: 0 0 0 10px;
			color: #222;
		}
		.modal-list li {
			margin-bottom: 7px;
			line-height: 1.6;
		}
		.contact-list li {
			margin-bottom: 10px;
			font-size: 1.08em;
		}
		.contact-list a {
			color: #1976d2;
			text-decoration: none;
		}
		.contact-list a:hover {
			text-decoration: underline;
		}
		.contact-form .form-group {
			margin-bottom: 12px;
		}
		.contact-form .form-control {
			width: 100%;
			border-radius: 6px;
			border: 1.5px solid #d1d5db;
			background: #f8fafc;
			font-size: 1em;
			padding: 10px 12px;
			box-shadow: none;
			transition: border 0.2s;
			resize: none;
		}
		.contact-form .form-control:focus {
			border: 1.5px solid #1976d2;
			background: #fff;
			outline: none;
		}
		.top-right-links .fa-whatsapp {
			color: #25D366;
			font-size: 1.2em;
			margin-left: 2px;
		}
		.login-form .login-content .form-group .input-group.input-icon .input-group-addon i {
			color: #2196f3 !important;
		}
	</style>
	
</head>
<body class="page-body login-page login-form-fall" data-url="http://neon.dev">

<!-- Top Right Links Bar -->
<div class="top-right-links">
    <a href="#" class="trl-link" onclick="openModal('aboutModal');return false;">About Us</a>
    <a href="#" class="trl-link" onclick="openModal('contactModal');return false;">Contact</a>
    <a href="https://www.facebook.com/yohanan.dinagde" target="_blank" class="trl-link" title="Facebook"><i class="entypo-facebook"></i></a>
    <a href="https://x.com/YDinagde44028?t=gVt7UGK0P9-kZ6ExTEmwvw&s=09" target="_blank" class="trl-link" title="Twitter"><i class="entypo-twitter"></i></a>
    <a href="https://linkedin.com" target="_blank" class="trl-link" title="LinkedIn"><i class="entypo-linkedin"></i></a>
    <a href="https://www.instagram.com/yohanen_d/" target="_blank" class="trl-link" title="Instagram"><i class="entypo-instagram"></i></a>
    <a href="https://wa.me/917409283325" target="_blank" class="trl-link" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
</div>

<!-- About Us Modal -->
<div id="aboutModal" class="custom-modal">
  <div class="custom-modal-content">
    <div class="custom-modal-header">
      <img src="uploads/logo.png" alt="YDU Tech Logo" class="modal-logo">
      <span class="custom-modal-close" onclick="closeModal('aboutModal')">&times;</span>
      <h2><i class="entypo-info"></i> About Us</h2>
    </div>
    <div class="custom-modal-body">
      <p><b>Welcome to <span style="color:#1976d2">Yohanen Dinagde University of Technology (YDU Tech)</span></b>—a dynamic hub for innovation, research, and academic excellence.</p>
      <hr class="modal-divider">
      <ul class="modal-list">
        <li><b>Vision:</b> Shape the future through cutting-edge technology and transformative education.</li>
        <li><b>Mission:</b> Develop skilled professionals, forward-thinking leaders, and groundbreaking solutions for global challenges.</li>
      </ul>
      <hr class="modal-divider">
      <p><b>What We Offer:</b></p>
      <ul class="modal-list">
        <li>Wide range of programs in <b>engineering, computer science, artificial intelligence, business technology</b>, and more.</li>
        <li>Strong emphasis on <b>practical learning, research, and industry collaboration</b>.</li>
        <li>State-of-the-art <b>laboratories, research centers, and collaborative workspaces</b>.</li>
      </ul>
      <hr class="modal-divider">
      <p><b>Our Faculty:</b> Renowned scholars, researchers, and industry experts dedicated to nurturing the next generation of innovators.</p>
      <hr class="modal-divider">
      <p><b>Who Should Join?</b></p>
      <ul class="modal-list">
        <li>Students aspiring to build a groundbreaking career</li>
        <li>Researchers pushing the boundaries of knowledge</li>
        <li>Industry partners looking for collaboration</li>
      </ul>
      <hr class="modal-divider">
      <p style="font-weight:600; color:#1976d2;">Join us on this journey of innovation, excellence, and transformation.<br>Welcome to YDU Tech—where the future begins!</p>
    </div>
  </div>
</div>

<!-- Contact Modal -->
<div id="contactModal" class="custom-modal">
  <div class="custom-modal-content">
    <div class="custom-modal-header">
      <img src="uploads/logo.png" alt="YDU Tech Logo" class="modal-logo">
      <span class="custom-modal-close" onclick="closeModal('contactModal')">&times;</span>
      <h2><i class="entypo-mail"></i> Contact Us</h2>
    </div>
    <div class="custom-modal-body" id="contact-modal-body">
      <p><b>We would love to hear from you!</b> Whether you have questions about admissions, programs, partnerships, or anything else, our team is ready to assist you.</p>
      <hr class="modal-divider">
      <ul class="modal-list contact-list">
        <li><b><i class="entypo-location"></i> Address:</b> 4 Kilo, Addis Ababa, Ethiopia</li>
        <li><b><i class="entypo-phone"></i> Phone:</b> <a href="tel:+917409283325">+91 74092 83325 (International)</a>, <a href="tel:+251956845678">+251 95684 5678 (Ethiopia)</a></li>
        <li><b><i class="entypo-mail"></i> Email:</b> <a href="mailto:yohanendinagde2@gmail.com">yohanendinagde2@gmail.com</a></li>
      </ul>
      <hr class="modal-divider">
      <form id="contactForm" class="contact-form" onsubmit="return submitContactForm(event)">
        <div class="form-group">
          <input type="text" class="form-control" name="name" placeholder="Your Name" required />
        </div>
        <div class="form-group">
          <input type="email" class="form-control" name="email" placeholder="Your Email" required />
        </div>
        <div class="form-group">
          <textarea class="form-control" name="message" placeholder="Your Message" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-login" style="width:100%;margin-top:8px;">Send Message</button>
      </form>
      <div id="contactThankYou" style="display:none; text-align:center; color:#1976d2; font-weight:600; margin-top:18px;">Thank you for contacting us! We have received your message.</div>
      <hr class="modal-divider">
      <p style="font-weight:600; color:#1976d2;">Stay connected with Yohanen Dinagde University of Technology—where innovation and opportunity meet.</p>
    </div>
  </div>
</div>

<!-- This is needed when you send requests via Ajax -->
<script type="text/javascript">
var baseurl = '<?php echo base_url();?>';
</script>

<div class="login-container">
	
	<div class="login-header login-caret">
		<div class="login-content" style="width:100%; text-align:center;">
			<A href="<?php echo base_url(); ?>" class="logo">
				<img src="uploads/logo.png" alt="Logo" />
			</A>
		</div>
	</div>
	
	<div class="login-progressbar">
		<div></div>
	</div>
	
	<div class="login-form">
		
		<div class="login-content">
			
			<div class="form-login-error">
				<h3>Invalid login</h3>
				<p>Please enter correct email and password!</p>
			</div>
			
			<form method="post" role="form" id="form_login">
				
				<div class="form-group">
					<div class="input-group input-icon">
						<div class="input-group-addon">
							<i class="entypo-users"></i>
						</div>
						<select class="form-control" name="user_type" id="user_type" required>
							<option value="">Select User Type</option>
							<option value="admin">Admin</option>
							<option value="teacher">Teacher</option>
							<option value="parent">Parent</option>
							<option value="student">Student</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<div class="input-group input-icon">
						<div class="input-group-addon">
							<i class="entypo-user"></i>
						</div>
						<input type="text" class="form-control" name="email" id="email" placeholder="User ID" autocomplete="off" data-mask="email" />
					</div>
				</div>
				
				<div class="form-group">
					<div class="input-group input-icon">
						<div class="input-group-addon">
							<i class="entypo-key"></i>
						</div>
						<input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" style="padding-right:40px;" />
						<span class="toggle-password" onclick="togglePassword()">
							<i id="eye-icon" class="entypo-eye"></i>
						</span>
					</div>
				</div>
				
				<div class="form-group captcha-box">
					<span class="captcha-refresh" title="Refresh Captcha" onclick="generateCaptcha()">
						<i class="entypo-arrows-ccw"></i>
					</span>
					<span id="captcha-text" class="captcha-text"></span>
				</div>
				
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Enter Captcha" />
				</div>
				
				<div class="form-group">
					<button type="submit" class="btn btn-success btn-block btn-login">
						LOGIN
					</button>
				</div>
				
			</form>
			
			<div class="login-bottom-links">
				<a href="#" class="link">Forgot password ?</a>
				<a href="#" class="link">Forgot ID ?</a>
			</div>
			
		</div>
		
	</div>
	
</div>

	<!-- Bottom Scripts -->
	<script src="assets/js/gsap/main-gsap.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
	<script src="assets/js/jquery.validate.min.js"></script>
	<script src="assets/js/neon-login.js"></script>
	<script src="assets/js/neon-custom.js"></script>
	<script src="assets/js/neon-demo.js"></script>

	<script>
		// Show/Hide Password Toggle
		function togglePassword() {
			var pwd = document.getElementById('password');
			var eye = document.getElementById('eye-icon');
			if (pwd.type === 'password') {
				pwd.type = 'text';
				eye.className = 'entypo-eye-blocked';
			} else {
				pwd.type = 'password';
				eye.className = 'entypo-eye';
			}
		}

		// Captcha Generator
		function generateCaptcha() {
			var chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
			var captcha = '';
			for (var i = 0; i < 5; i++) {
				captcha += chars.charAt(Math.floor(Math.random() * chars.length));
			}
			document.getElementById('captcha-text').textContent = captcha;
		}

		// Generate captcha on page load
		document.addEventListener('DOMContentLoaded', function() {
			generateCaptcha();
		});

		function openModal(id) {
			document.getElementById(id).style.display = 'flex';
		}
		function closeModal(id) {
			document.getElementById(id).style.display = 'none';
		}
		// Close modal when clicking outside content
		window.onclick = function(event) {
			var about = document.getElementById('aboutModal');
			var contact = document.getElementById('contactModal');
			if (event.target === about) about.style.display = 'none';
			if (event.target === contact) contact.style.display = 'none';
		}

		function submitContactForm(event) {
			event.preventDefault();
			document.getElementById('contactForm').style.display = 'none';
			document.getElementById('contactThankYou').style.display = 'block';
			return false;
		}
	</script>

</body>
</html>