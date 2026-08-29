<?php
session_start(); require 'config.php'; verify_csrf();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('apply.php');

function upload_file(string $field, string $dir, array $allowed, int $maxBytes): ?string {
    if (empty($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) return null;
    $f = $_FILES[$field];
    if ($f['error'] !== UPLOAD_ERR_OK || $f['size'] > $maxBytes) throw new RuntimeException('One uploaded file is invalid or too large.');
    $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed, true)) throw new RuntimeException('Unsupported file type.');
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
    $valid = ['jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png','webp'=>'image/webp','pdf'=>'application/pdf'];
    if (($valid[$ext] ?? '') !== $mime) throw new RuntimeException('File content does not match its extension.');
    $name = bin2hex(random_bytes(16)) . '.' . $ext;
    $path = $dir . '/' . $name;
    if (!move_uploaded_file($f['tmp_name'], $path)) throw new RuntimeException('Could not save uploaded file.');
    return $path;
}
try {
    $passport = upload_file('passport','uploads/passports',['jpg','jpeg','png','webp'],5*1024*1024);
    $document = upload_file('document','uploads/documents',['pdf','jpg','jpeg','png'],10*1024*1024);
    $applicationNo = 'MIS-' . date('Y') . '-' . strtoupper(bin2hex(random_bytes(3)));
    $data = [
      $applicationNo, trim($_POST['full_name']??''), $_POST['dob']?:null, trim($_POST['gender']??''), trim($_POST['nationality']??''),
      trim($_POST['state_of_origin']??''), trim($_POST['lga']??''), trim($_POST['address']??''), $passport,
      trim($_POST['parent_name']??''), trim($_POST['parent_phone']??''), trim($_POST['parent_email']??''), trim($_POST['parent_address']??''),
      trim($_POST['applying_section']??''), trim($_POST['class_applied']??''), trim($_POST['previous_school']??''), trim($_POST['previous_class']??''),
      trim($_POST['quran_level']??''), trim($_POST['arabic_level']??''), trim($_POST['additional_info']??''), $document
    ];
    if ($data[1]==='' || $data[9]==='' || $data[10]==='' || $data[13]==='' || $data[14]==='') throw new RuntimeException('Please complete all required fields.');
    $sql="INSERT INTO applications(application_no,full_name,dob,gender,nationality,state_of_origin,lga,address,passport_path,parent_name,parent_phone,parent_email,parent_address,applying_section,class_applied,previous_school,previous_class,quran_level,arabic_level,additional_info,document_path) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    db()->prepare($sql)->execute($data);
    ?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Application Submitted</title><link rel="stylesheet" href="assets/css/style.css"></head><body class="center"><div class="success-card"><img src="assets/images/school-logo.png" class="success-logo"><div class="success-icon">✓</div><h1>Application Submitted Successfully</h1><p>Your application has been received by Me’Raj International School Maiduguri.</p><div class="application-no"><?=e($applicationNo)?></div><p><strong>Please keep your Application Number for future reference.</strong></p><a class="btn" href="index.php">Return to Website</a></div></body></html><?php
} catch (Throwable $ex) {
    http_response_code(400);
    echo '<!doctype html><html><head><meta name="viewport" content="width=device-width,initial-scale=1"><link rel="stylesheet" href="assets/css/style.css"></head><body class="center"><div class="card"><h2>Application could not be submitted</h2><p>'.e($ex->getMessage()).'</p><a class="btn" href="apply.php">Go Back</a></div></body></html>';
}