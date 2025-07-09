<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'third_party/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
    public function __construct()
    {
        parent::__construct();
    }

    // Function to generate PDF
    public function generate($html, $filename = '')
    {
        // Set default filename if not provided
        if (empty($filename)) {
            $filename = 'report_'.date('Y-m-d_H-i-s').'.pdf';
        }

        // Set PDF properties
        $this->SetCreator('School Management System');
        $this->SetAuthor('School Management System');
        $this->SetTitle('Student Report');

        // Remove default header/footer
        $this->setPrintHeader(false);
        $this->setPrintFooter(false);

        // Set margins
        $this->SetMargins(15, 15, 15);
        
        // Add a page
        $this->AddPage();
        
        // Set font
        $this->SetFont('helvetica', '', 10);
        
        // Write HTML content
        $this->writeHTML($html, true, false, true, false, '');
        
        // Output PDF
        if($filename == 'I') {
            // Display in browser
            $this->Output($filename, 'I');
            return '';
        } else {
            // Save to file
            $this->Output($filename, 'F');
            return $filename;
        }
    }
}