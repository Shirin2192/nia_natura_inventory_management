<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
function generatePassword() {
    $length = 8;
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = substr(str_shuffle($chars), 0, $length);
    $pass = encrypt($password);
    return $pass;
}

function generateOTP() {
    return mt_rand(1000,9999);
}

function generateid() {
    return mt_rand(1000,9999);
}

function decy_ency($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'nia_natura_inventory_management key';
    $secret_iv = 'nia_natura_inventory_management iv';
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function validateToken(){
    $CI = get_instance();
    if (array_key_exists('HTTP_AUTHORIZATION', $_SERVER) && !empty($_SERVER['HTTP_AUTHORIZATION'])) {
        $decodedToken = AUTHORIZATION::validateToken($_SERVER['HTTP_AUTHORIZATION']);
        if ($decodedToken != false) {
           return true;
        } else {
            return false;
        }
    }
    return false;
}

    function clean($string) {
        $string = preg_replace('/\s/', '', $string); // Removes all whitespaces.
        $result= preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        return $result;
    }
    function get_date($format='')
    {
        
        $timezone_identifier = date_default_timezone_get();
        date_default_timezone_set($timezone_identifier);
         if (empty($format)) {
            $format = 'Y-m-d H:i:s';
        }
        $date = date($format);
        return $date;
    }


    function random_strings() 
    { 
        $CI = get_instance();
        $randTemp = mt_rand(100000, 999999);
        $isUnique = true;
        do {
            $result = $CI->db->get_where('tbl_organization', array('access_code' => $randTemp));
            if ($result->num_rows() > 0) {
                $isUnique = false;
            } else {
                $isUnique = true;
            }
        } while ($isUnique == false);
        return $randTemp;
    }
    function token_get(){
        $tokenData = array();
        $tokenData['id'] = mt_rand(10000,99999); //TODO: Replace with data for token
        $output['token'] = AUTHORIZATION::generateToken($tokenData);
        return $output['token'];
    }
    function has_permission($module_name, $action) {
        $CI =& get_instance();
        $CI->load->model('Admin_model');
        return $CI->Admin_model->check_permission($module_name, $action);
    }
   

    // Based on the screenshot showing the actual file location
require_once(FCPATH . 'vendor/phpmailer/phpmailer/PHPMailer.php');
require_once(FCPATH . 'vendor/phpmailer/phpmailer/Exception.php');
require_once(FCPATH . 'vendor/phpmailer/phpmailer/SMTP.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
/**
 * Send inventory email using PHPMailer
 * 
 * @param string $to_email Recipient email address
 * @param string $subject Email subject
 * @param string $message Email body message (HTML)
 * @param string $from_name Sender name
 * @return bool True if email was sent successfully, false otherwise
 */
function send_inventory_email($to_email, $subject, $message, $from_name = 'Nia Natura Inventory System') {
    $CI =& get_instance();
    
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'eternal.herosite.pro';  // Your SMTP host
        $mail->SMTPAuth   = true;
        $mail->Username   = 'connect@sda.in.net';    // Your SMTP username
        $mail->Password   = 'c_bo*bm#)4g*';          // Your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        // Sender and recipient
        $mail->setFrom('connect@sda.in.net', $from_name);  // Sender email and name
        $mail->addAddress($to_email);  // Recipient email
        // Content settings
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;
        // Send the email
        $mail->send();
        return true;  // Return true if email is sent successfully
    } catch (Exception $e) {
        // Log error if email fails to send
        log_message('error', "Mailer Error: " . $mail->ErrorInfo);
        return false;  // Return false if an error occurs
    }
}