<?php
//include connection file
include_once("libs/connection.php");
include_once('libs/fpdf.php');
$data_entry_id=$_GET['data_entry_id'];
$user_id=$_GET['user_id'];

class PDF extends FPDF

{
// Page header
    function Header()
    {

       //$this->Image('logo.png',10,-1,70);

        $this->SetY(20);

        $this->SetFont('Arial', '', 12);
        // Title
        $this->Cell(0, 0, $this->PageNo(), 0, 0, 'C');
        $this->Ln(1);
        $this->Cell(0, 8, 'CONFIDENTIAL', 0, 0, 'C');
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-25);
        // Arial italic 8
        $this->SetFont('Arial', '', 12);
        // Page number
        $this->Cell(0, 10, $this->PageNo(), 0, 0, 'C');
        $this->Ln(0);
        $this->Cell(0, 20, 'CONFIDENTIAL', 0, 0, 'C');
    }

    function FancyTable($header, $nid_info_children)

    {

        // Colors, line width and bold font
        $this->SetFillColor(128, 128, 128);
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0);
        $this->SetFont('Arial', 'B');
        // Table Header

        for ($i = 0; $i < count($header); $i++) {
            $this->Cell(37, 7, $header[$i], 1, 0, 'C', true);
        }
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('Arial');
        // Data

        foreach ($nid_info_children as $row) {
            $this->Ln();
            $this->Cell(12, 0, '   ');

            foreach ($row as $column) {
                $this->Cell(37, 8, $column, 1, 0, 'C');
            }
        }
    }
}

$db = new dbObj();
$connString =  $db->getConnstring();

$personnel_Info = mysqli_query($connString, "SELECT * FROM personnel_info WHERE user_id=$user_id&&data_entry_id='$data_entry_id'") or die("database error:". mysqli_error($connString));
$personnel_Info = mysqli_fetch_assoc($personnel_Info);

$nid_info_children = mysqli_query($connString, "SELECT nid_ser_no_children,name_as_nid_children,nid_no_children FROM nid_info_children WHERE user_id=$user_id&&data_entry_id='$data_entry_id'") or die("database error:". mysqli_error($connString));

$contact_details_self = mysqli_query($connString, "SELECT self_contact_ser_no,self_contact_mobile_no,self_contact_imei_no,self_contact_email_address FROM contact_details_self WHERE user_id=$user_id&&data_entry_id='$data_entry_id'") or die("database error:". mysqli_error($connString));
$contact_details_spouse = mysqli_query($connString, "SELECT spouse_contact_ser_no,spouse_contact_mobile_no,spouse_contact_imei_no,spouse_contact_email_address FROM contact_details_spouse WHERE user_id=$user_id&&data_entry_id='$data_entry_id'") or die("database error:". mysqli_error($connString));

$contact_details_children = mysqli_query($connString, "SELECT children_contact_ser_no,children_contact_mobile_no,children_contact_imei_no,children_contact_email_address FROM contact_details_children WHERE user_id=$user_id&&data_entry_id='$data_entry_id'") or die("database error:". mysqli_error($connString));
$social_media_table_self = mysqli_query($connString, "SELECT self_social_media_ser_no,self_social_media_email_address,self_social_media_platform,self_social_media_link,self_social_media_mobile_no FROM social_media_table_self WHERE user_id=$user_id&&data_entry_id='$data_entry_id'") or die("database error:". mysqli_error($connString));

$social_media_table_spouse = mysqli_query($connString, "SELECT spouse_social_media_ser_no,spouse_social_media_email_address,spouse_social_media_platform,spouse_social_media_link,spouse_social_media_mobile_no FROM social_media_table_spouse WHERE user_id=$user_id&&data_entry_id='$data_entry_id'") or die("database error:". mysqli_error($connString));

$social_media_table_children = mysqli_query($connString, "SELECT children_social_media_ser_no,children_social_media_email_address,children_social_media_platform,children_social_media_link,children_social_media_mobile_no FROM social_media_table_children WHERE user_id=$user_id&&data_entry_id='$data_entry_id'") or die("database error:". mysqli_error($connString));

$per_mobile_num = mysqli_query($connString, "SELECT ser_no_mobile,personal_mob_num,present_status,submit_date FROM per_mobile_num WHERE user_id=$user_id&&data_entry_id='$data_entry_id'") or die("database error:". mysqli_error($connString));

$pdf = new PDF('P','mm','A4');
//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B'.'U',16);
$pdf->SetMargins(10,0,20);
$pdf->Ln(0);
$pdf->Cell(0,25,'PERSONAL INFORMATION',0,0,'C');
$pdf->Ln(25);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(25,0,'1.    Name:','','');
$pdf->SetFont('Arial','',12);
$pdf->Cell(50,0,$personnel_Info['full_name']);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(25,0,'2.    Rank:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(20,0,$personnel_Info['rank']);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(25,0,'3.    BD No:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(20,0,$personnel_Info['bd_no']);
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,0,'4.    Branch/Trade:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(35,0,$personnel_Info['br_trade']);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(25,0,'5.    Unit:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(20,0,$personnel_Info['unit']);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(35,0,'6.    Date Of birth:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(20,0,$personnel_Info['date_of_birth']);
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(35,0,'7.    Passport No:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,0,$personnel_Info['passport_no']);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,0,'8.    Marital status:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(30,0,$personnel_Info['mar_status']);
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(60,0,'9.  Number of child - Male:');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(5,0,$personnel_Info['child_male']);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(25,0,'    Female:');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,0,$personnel_Info['child_female']);

$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(120,0,'10.    Personal Mobile Number:');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(9,0,'');
$pdf->Cell(120,0,'a.   Existing Mobile Number:');

$pdf->SetFont('Arial','B',12);
$pdf->Ln(5);
$pdf->SetFillColor(240,240,240);
$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(20	,5,'Ser No',1,0,'C','true');
$pdf->Cell(40	,5,'Mobile No',1,0,'C','true');
$pdf->Cell(40	,5,'Present Status',1,0,'C','true');
$pdf->Cell(40	,5,'Submit Date',1,1,'C','true');
$sl = 1;
while($item = mysqli_fetch_assoc($per_mobile_num)){
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(20	,5,$sl,1,0,'C');
    $pdf->Cell(40	,5,$item['personal_mob_num'],1,0,'C');
    $pdf->Cell(40	,5,$item['present_status'],1,0,'C');
    $pdf->Cell(40	,5,date('d M Y', strtotime($item['submit_date'])),1,1,'C');
    $sl++;
}
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,0,'11.    National Id Information:');
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(9,0,'');
$pdf->Cell(50,0,'a.     Self Name as NID:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(50,0,$personnel_Info['self_nid_name']);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,0,'   Self NID No:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(32,0,$personnel_Info['self_nid_no']);
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(9,0,'');
$pdf->Cell(55,0,'b.    Spouse Name as NID:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(45,0,$personnel_Info['spouse_nid_name']);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,0,'   Spouse NID No:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(32,0,$personnel_Info['spouse_nid_no']);
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(9,0,'');
$pdf->Cell(120,0,'c.   Children National Id Information:');


$pdf->SetFont('Arial','B',12);
$pdf->Ln(5);
$pdf->SetFillColor(240,240,240);
$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(20	,5,'Ser',1,0,'C','true');
$pdf->Cell(80	,5,'Name As NID',1,0,'C','true');
$pdf->Cell(80,5,'NID No',1,1,'C','true');//end of line
$sl = 1;
while($item = mysqli_fetch_assoc($nid_info_children)){
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(20	,5,$sl,1,0,'C');
    $pdf->Cell(80	,5,$item['name_as_nid_children'],1,0,'C');
    $pdf->Cell(80,5,$item['nid_no_children'],1,1,'C');
    $sl++;//end of line
}

$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(120,0,'12.    Contact Details:');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(9,0,'');
$pdf->Cell(120,0,'a.   Self Contact Details:');

$pdf->SetFont('Arial','B',12);
$pdf->Ln(5);
$pdf->SetFillColor(240,240,240);
$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(20	,5,'Ser No',1,0,'C','true');
$pdf->Cell(40	,5,'Mobile No',1,0,'C','true');
$pdf->Cell(60    ,5,'IMEI NO',1,0,'C','true');//end of line
$pdf->Cell(60	,5,'Email Address',1,1,'C','true');
$sl = 1;
while($item = mysqli_fetch_assoc($contact_details_self)){
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(20	,5,$sl,1,0,'C');
    $pdf->Cell(40	,5,$item['self_contact_mobile_no'],1,0,'C');
    $pdf->Cell(60    ,5,$item['self_contact_imei_no'],1,0,'C');
    $pdf->Cell(60	,5,$item['self_contact_email_address'],1,1,'C');
    $sl++;
}
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(9,0,'');
$pdf->Cell(120,0,'b.   Spouse Contact Details:');

$pdf->SetFont('Arial','B',12);
$pdf->Ln(5);
$pdf->SetFillColor(240,240,240);
$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(20	,5,'Ser No',1,0,'C','true');
$pdf->Cell(40	,5,'Mobile No',1,0,'C','true');
$pdf->Cell(60    ,5,'IMEI NO',1,0,'C','true');//end of line
$pdf->Cell(60	,5,'Email Address',1,1,'C','true');
$sl = 1;
while($item = mysqli_fetch_assoc($contact_details_spouse)){
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(20	,5,$sl,1,0,'C');
    $pdf->Cell(40	,5,$item['spouse_contact_mobile_no'],1,0,'C');
    $pdf->Cell(60    ,5,$item['spouse_contact_imei_no'],1,0,'C');
    $pdf->Cell(60	,5,$item['spouse_contact_email_address'],1,1,'C');
    $sl++;
}
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(9,0,'');
$pdf->Cell(120,0,'c.   Children Contact Details:');

$pdf->SetFont('Arial','B',12);
$pdf->Ln(5);
$pdf->SetFillColor(240,240,240);
$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(20	,5,'Ser No',1,0,'C','true');
$pdf->Cell(40	,5,'Mobile No',1,0,'C','true');
$pdf->Cell(60    ,5,'IMEI NO',1,0,'C','true');//end of line
$pdf->Cell(60	,5,'Email Address',1,1,'C','true');
$sl = 1;
while($item = mysqli_fetch_assoc($contact_details_children)){
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(20	,5,$sl,1,0,'C');
    $pdf->Cell(40	,5,$item['children_contact_mobile_no'],1,0,'C');
    $pdf->Cell(60    ,5,$item['children_contact_imei_no'],1,0,'C');
    $pdf->Cell(60	,5,$item['children_contact_email_address'],1,1,'C');
    $sl++;
}
$pdf->AddPage();
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(120,0,'13.    Social Media Details:');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(9,0,'');
$pdf->Cell(120,0,'a.   Self Social Media Details:');

$pdf->SetFont('Arial','B',12);
$pdf->Ln(5);
$pdf->SetFillColor(240,240,240);
$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(15	,5,'Ser No',1,0,'C','true');
$pdf->Cell(40	,5,'Email Address',1,0,'C','true');
$pdf->Cell(50    ,5,'Social Media Platform',1,0,'C','true');//end of line
$pdf->Cell(40	,5,'Link',1,0,'C','true');
$pdf->Cell(40	,5,'Mobile No',1,1,'C','true');
$sl = 1;
while($item = mysqli_fetch_assoc($social_media_table_self)){
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(15	,5,$sl,1,0,'C');
    $pdf->Cell(40	,5,$item['self_social_media_email_address'],1,0,'C');
    $pdf->Cell(50    ,5,$item['self_social_media_platform'],1,0,'C');
    $pdf->Cell(40	,5,$item['self_social_media_link'],1,0,'C');
    $pdf->Cell(40	,5,$item['self_social_media_mobile_no'],1,1,'C');
    $sl++;
}
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(9,0,'');
$pdf->Cell(120,0,'b.   Spouse Social Media Details:');

$pdf->SetFont('Arial','B',12);
$pdf->Ln(5);
$pdf->SetFillColor(240,240,240);
$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(15	,5,'Ser No',1,0,'C','true');
$pdf->Cell(40	,5,'Email Address',1,0,'C','true');
$pdf->Cell(50    ,5,'Social Media Platform',1,0,'C','true');//end of line
$pdf->Cell(40	,5,'Link',1,0,'C','true');
$pdf->Cell(40	,5,'Mobile No',1,1,'C','true');
$sl = 1;
while($item = mysqli_fetch_assoc($social_media_table_spouse)){
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(15	,5,$sl,1,0,'C');
    $pdf->Cell(40	,5,$item['spouse_social_media_email_address'],1,0,'C');
    $pdf->Cell(50    ,5,$item['spouse_social_media_platform'],1,0,'C');
    $pdf->Cell(40	,5,$item['spouse_social_media_link'],1,0,'C');
    $pdf->Cell(40	,5,$item['spouse_social_media_mobile_no'],1,1,'C');
    $sl++;
}
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(9,15,'');
$pdf->Cell(120,0,'c.   Children Social Media Details:');

$pdf->SetFont('Arial','B',12);
$pdf->Ln(5);
$pdf->SetFillColor(240,240,240);
$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(15	,5,'Ser No',1,0,'C','true');
$pdf->Cell(45	,5,'Email Address',1,0,'C','true');
$pdf->Cell(50    ,5,'Social Media Platform',1,0,'C','true');//end of line
$pdf->Cell(45	,5,'Link',1,0,'C','true');
$pdf->Cell(30	,5,'Mobile No',1,1,'C','true');
$sl = 1;
while($item = mysqli_fetch_assoc($social_media_table_children)){
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(15	,5,$sl,1,0,'C');
    $pdf->Cell(45	,5,$item['children_social_media_email_address'],1,0,'C');
    $pdf->Cell(50    ,5,$item['children_social_media_platform'],1,0,'C');
    $pdf->Cell(45	,5,$item['children_social_media_link'],1,0,'C');
    $pdf->Cell(30	,5,$item['children_social_media_mobile_no'],1,1,'C');
    $sl++;
}
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(48,0,'14.    Present Address:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(20,0,$personnel_Info['present_address']);
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(52,0,'15.    Permanent Address:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(20,0,$personnel_Info['permanent_address']);
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(48,0,'16.    Vehicle Information:');
$pdf->Ln(8);
$pdf->Cell(9,0,'');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,0,'     Vehicle Name:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(35,0,$personnel_Info['vehicle_name']);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(38,0,'   Registration No:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(35,0,$personnel_Info['reg_no']);
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,0,'17.    Bank Information:');
$pdf->Ln(8);
$pdf->Cell(9,0,'');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,0,'a.   Self Bank Information:');
$pdf->Ln(8);
$pdf->Cell(9,0,'');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,0,'     Bank Name:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(15,0,$personnel_Info['self_bank_name']);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(30,0,'   Branch:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(18,0,$personnel_Info['self_branch']);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,0,'   Bank Account Number:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(32,0,$personnel_Info['self_bank_account_num']);
$pdf->Ln(8);
$pdf->Cell(9,0,'');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,0,'b.   Spouse Bank Information:');
$pdf->Ln(8);
$pdf->Cell(9,0,'');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(35,0,'     Bank Name:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(20,0,$personnel_Info['spouse_bank_name']);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(30,0,'   Branch:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(25,0,$personnel_Info['spouse_branch']);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,0,'   Bank Account Number:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(32,0,$personnel_Info['spouse_bank_account_num']);
$pdf->Ln(8);
$pdf->Cell(9,0,'');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,0,'a.   Children Bank Information:');
$pdf->Ln(8);
$pdf->Cell(9,0,'');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,0,'     Bank Name:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(20,0,$personnel_Info['children_bank_name']);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(25,0,'   Branch:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(25,0,$personnel_Info['children_branch']);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,0,'   Bank Account Number:');
$pdf->SetFont('Arial','',12);
$pdf->Cell(25,0,$personnel_Info['children_bank_account_num']);
$pdf->Ln(93);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,0,'   Submit Date:');
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,0,$personnel_Info['submit_date']);



$pdf->Output('',$personnel_Info['bd_no'].'form'.'.pdf');
?>

