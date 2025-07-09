<!-- Footer -->
<footer class="main">
    <div class="footer-content">
        <div class="footer-left">
            <div class="footer-logo">
                <i class="entypo-graduation-cap"></i>
                <span>Smart School</span>
            </div>
            <p class="footer-description">Comprehensive School Management System</p>
        </div>
        
        <div class="footer-center">
            <div class="footer-copyright">
                &copy; <?php echo date('Y')?> Smart School Management System
            </div>
            <div class="footer-version">
                Version 1.0.0
            </div>
        </div>
        
        <div class="footer-right">
            <div class="footer-developers">
                <strong>Developed by</strong>
                <div class="developer-names">
                    Yohanen Dinagde, Sakshi
                </div>
            </div>
            <div class="footer-framework">
                <i class="entypo-code"></i>
                <span>Built with CodeIgniter</span>
            </div>
        </div>
    </div>
</footer>

<style>
.main {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.05);
    padding: 20px 0;
    margin-top: 30px;
}

.footer-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.footer-left {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.footer-logo {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
}

.footer-logo i {
    font-size: 24px;
    color: var(--primary-color);
    margin-right: 10px;
}

.footer-logo span {
    font-size: 18px;
    font-weight: 600;
    color: var(--dark-color);
}

.footer-description {
    font-size: 14px;
    color: #636e72;
    margin: 0;
}

.footer-center {
    text-align: center;
}

.footer-copyright {
    font-size: 14px;
    color: var(--dark-color);
    margin-bottom: 5px;
}

.footer-version {
    font-size: 12px;
    color: #636e72;
}

.footer-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.footer-developers {
    margin-bottom: 8px;
}

.footer-developers strong {
    font-size: 14px;
    color: var(--dark-color);
}

.developer-names {
    font-size: 13px;
    color: #636e72;
}

.footer-framework {
    display: flex;
    align-items: center;
    font-size: 13px;
    color: #636e72;
}

.footer-framework i {
    margin-right: 8px;
    color: var(--primary-color);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .footer-content {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }
    
    .footer-left,
    .footer-right {
        align-items: center;
    }
    
    .footer-center {
        order: 3;
    }
}

/* Animation */
@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.main {
    animation: slideUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}
</style>
