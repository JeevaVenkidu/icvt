<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmailModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
    }

    
    public function checkIdExists($id)
    {
    $query = $this->db->get_where('affiliation', ['id' => $id]);
    return $query->num_rows() > 0; 
    }
    public function getEmail($id) {
        $this->db->select('email'); 
        $this->db->where('id', $id);
        $query = $this->db->get('affiliation');
        if ($query->num_rows() > 0) {
            return $query->row()->email;
        } else {
            return false;
        }
    }
    public function EmailMessage(){
        
        $ci = &get_instance(); // Get CodeIgniter instance
        $ci->load->helper('url'); // Load URL helper
        $logo_url = base_url('assets/images/icvt_logo.png'); 

    
        $message = '
        <html>
        <head>
            <title>Document Verification in Process</title>
        </head>
        <body>
            <h3>Welcome to ICVTE - Document Verification in Process</h3>
            <p>Hi,</p>
            <p>We are happy to welcome you to ICVTE and appreciate your submission of documents as part of the registration process.</p>
            <p>Our team is currently reviewing the documents you submitted to ensure that all details are accurate and complete. 
            This verification process usually takes 4 to 5 working days, and we will inform you as soon as the review is finished.</p>
            <p>If you have any questions or need further assistance, please contact us at <a href="mailto:info@icvte.com">info@icvte.com</a> or +91 97898 32552. We are here to help!</p>
            <p>Thank you for your patience and cooperation.</p>
            <p>Warm regards,</p>
            <p><strong>ICVTE Team</strong></p>
            <img src="'.$logo_url.'" alt="ICVTE Logo" width="100">
        </body>
        </html>';
    
        return $message;
    }


    public function checkApprovedStatus($id)
    {
        $this->db->where('id', $id);
        $this->db->where('status', 'approved');
        $query = $this->db->get('affiliation'); // Replace with your actual table name

        if ($query->num_rows() > 0) {
            return true; // Record exists with 'approved' status
        } else {
            return false; // No matching record found
        }
    }
    public function EmailMessageApprovedStatus(){
        
        $ci = &get_instance(); // Get CodeIgniter instance
        $ci->load->helper('url'); // Load URL helper
        $logo_url = base_url('assets/images/icvt_logo.png'); 
        $user_name='Jeeva';
        $password='Jeeva@1';

    
        $message ="
        <html>
        <head>
            <title>Document Verification Completed</title>
        </head>
        <body style='font-family: Arial, sans-serif; color: #333; line-height: 1.6;'>
            <table width='600' align='center' cellspacing='0' cellpadding='10' border='0' style='border: 1px solid #ddd; border-radius: 5px; background: #fff;'>
                <tr style='background: #0073aa; color: #fff;'>
                    <td style='padding: 15px; font-size: 18px; text-align: center;'>
                        <strong>Document Verification Completed - Your User ID & Password</strong>
                    </td>
                </tr>
                <tr>
                    <td style='padding: 20px;'>
                        <p>Greetings,</p>
                        <p>We are pleased to inform you that your document verification has been successfully completed! You can now access your account using the credentials provided below:</p>
                        <p><strong>User ID:</strong> {$user_name}<br>
                        <strong>Password:</strong> {$password}</p>

                        <p>Please follow these steps to log in:</p>
                        <ol>
                            <li>Visit <a href='https://www.icvte.com' target='_blank'>www.icvte.com</a>.</li>
                            <li>Click 'Institute Login' on the right top corner.</li>
                            <li>Enter your User ID and Password.</li>
                        </ol>

                        <p>If you encounter any issues or need assistance, feel free to reach out to us at <a href='mailto:info@icvte.com'>info@icvte.com</a> or call us at +91 97898 32552. We are here to help!</p>

                        <p>Welcome aboard, and we look forward to working with you.</p>

                        <p>Warm regards,</p>
                        <p><img src='" . $logo_url . "' alt='ICVTE Logo' width='100'></p>
                    </td>
                </tr>
            </table>
        </body>
        </html>";
        return $message;
    }

    
    


    
}
?>