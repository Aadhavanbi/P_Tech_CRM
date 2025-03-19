<?php

namespace App\Helpers;
use Psr\Log\LoggerInterface;

use App\Controllers\BaseController;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use App\Models\VisaRequestModel;
use App\Models\NotesModel;


class MailHelper
{

    protected static $logger;

    public static function initLogger() {
        if (self::$logger === null) {
            self::$logger = \Config\Services::logger();
        }
    }
   
    public static function send_email($visa_request_id) 
    {    
        self::initLogger();

        $VisaRequestModel = new VisaRequestModel();
        $NotesModel = new NotesModel();

       

        $data['visaData'] = $VisaRequestModel->getVisaRequestList(session()->get('logged_in_staff_branch_id'), md5($visa_request_id));
   
        $data['visaNotesData'] = $NotesModel-> getVisaRequestNotes(md5($visa_request_id));

        $fileName = $data['visaNotesData'][0]['file']; // Assuming it contains only the file name, not the full path
        $data['attach']=false;

        if (!empty($fileName)) {
            $filePath = WRITEPATH . 'uploads/' . $fileName;

            // return $filePath;
            if (!file_exists($filePath)) {
                self::$logger->error('File not found: ' . $filePath);
                return json_encode([
                    'status' => 'failed',
                    'code' => 404,
                    'message' => 'File not found: ' . $filePath
                ]);
            }
    
            $fileContent = file_get_contents($filePath);
            if ($fileContent === false) {
                self::$logger->error('Failed to read file: ' . $filePath);
                return json_encode([
                    'status' => 'failed',
                    'code' => 500,
                    'message' => 'Failed to read file: ' . $filePath
                ]);
            } else {
                self::$logger->info('File content length: ' . strlen($fileContent));
            }
    
            // $mimeType = mime_content_type($filePath);
            $data['attach']=true;
        }


        $emaill = $data['visaData']->client_email;
        // $attchment = $data['visaNotesData'];
        $subject = 'United Visa Servises - Notification';
        $html =  view('mail_template', $data);

        try {
            
            $email = \Config\Services::email();
            $email->setMailType('html');
            $email->setFrom('bbone@venbait.in', 'UVS');

            $email->setTo($emaill);

            $email->setSubject($subject);
            $email->setMessage($html);

            // Attach the file to the email

            if (!empty($fileName)) {
                $email->attach($filePath);
            }

            if ($email->send()) {
                self::$logger->info('Email sent successfully to: ' . $emaill);
                return json_encode(['status' => 'success','code' => 200, 'message'=>'Email Sent Successfully...','data' => $emaill,],200);
            } else {
                self::$logger->error('Email sending failed to: ' . $emaill);
                return json_encode(['status' => 'failed','code' => 404,'message'=>'Email Sent Failed...','data' => $emaill  ],404);
            }
            
        } catch (\Exception $e) {
            self::$logger->error('Exception caught: ' . $e->getMessage());
            return json_encode([
                'status' => 'failed',
                'code' => 500,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);        }  
    }


    public static function send_otp_email($email_id,$otp) 
    {    
        self::initLogger();

        $subject = 'UVS Reset Password - OTP';
        $message =  "Hai ,

                    We have received a request for account recovery associated with your account. To ensure the security of your account, we are sending you a one-time password (OTP) for verification purposes. Please use the following OTP to proceed with the account recovery process:
        
                    OTP: ".$otp;
        try {
            $email = \Config\Services::email();
            $email->setMailType('html');
            $email->setFrom('bbone@venbait.in', 'UVS');
            $email->setTo($email_id);
            $email->setSubject($subject);
            $email->setMessage($message);

            if ($email->send()) {
                self::$logger->info('OTP email sent successfully to: ' . $email_id);
                return json_encode(['status' => 'success','code' => 200, 'message'=>'Email Sent Successfully...','data' => $email_id,],200);
            } else {
                self::$logger->error('OTP email sending failed to: ' . $email_id);
                return json_encode(['status' => 'failed','code' => 404,'message'=>'Email Sent Failed...','data' => $email_id  ],404);
            }
            
        } catch (\Exception $e) {
            self::$logger->error('Exception caught: ' . $e->getMessage());
            return json_encode(['status' => 'failed','code' => 500,'data' => $email_id],500);
        }  
    }


    public static function send_contact_mail($tomail,$subject,$html)
    {    
        self::initLogger();

       
        try {
            $email = \Config\Services::email();
            $email->setMailType('html');
            $email->setFrom('bbone@venbait.in', 'UVS');
            $email->setTo($tomail);
            $email->setSubject($subject);
            $email->setMessage($html);

            if ($email->send()) {
                self::$logger->info('OTP email sent successfully to: ' . $tomail);
                return json_encode(['status' => 'success','code' => 200, 'message'=>'Email Sent Successfully...','data' => $tomail,],200);
            } else {
                self::$logger->error('OTP email sending failed to: ' . $tomail);
                return json_encode(['status' => 'failed','code' => 404,'message'=>'Email Sent Failed...','data' => $tomail  ],404);
            }
            
        } catch (\Exception $e) {
            self::$logger->error('Exception caught: ' . $e->getMessage());
            return json_encode(['status' => 'failed','code' => 500,'data' => $tomail],500);
        }  
    }


   


}
?>