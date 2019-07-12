<?php

    require 'fpdf/fpdf.php';
    include_once 'config/connection.php';
    
    session_start();

    if($_SESSION['userType'] != 'counselor' && $_SESSION['userType'] != 'admin')
        header("Location: index.php");

    $database = new Connection();
    $db = $database->openConnection();
    
    if(isset($_GET['c_id']) && isset($_GET['stud_num']))
    {
        $cId = $_GET['c_id'];
        $studNum = $_GET['stud_num'];
        
        $sql = 'SELECT `term`, `counseling_date`, `counseling_concern`, `action_plan`, `counseling_status`, 
        `user_id`, `cdate_encoded`, `studstatus_id` FROM `counseling_tb` WHERE `counseling_id` = ' . $cId;
        
        $cReport = $db->query($sql);
        $cReport->setFetchMode(PDO::FETCH_ASSOC);
        $row = $cReport->fetch();

        $users='SELECT `user_username` from `user_tb` where `user_id` = '. $row['user_id'];
        $user = $db->query($users);
        $user->setFetchMode(PDO::FETCH_ASSOC);
        $user = $user->fetch();
        
        $stmt = "SELECT `ay_id`, `grade_id`, `section_id` FROM studstatus_tb WHERE '" .$studNum."' = `stud_number`";
        $stmtExec = $db->query($stmt);
        $stmtExec->setFetchMode(PDO::FETCH_ASSOC);
        $row2 = $stmtExec->fetch();
        $ayId = $row2['ay_id'];
        $gradeId = $row2['grade_id'];
        $sectionId = $row2['section_id'];

        $sql2 = 'SELECT `stud_lname`, `stud_fname`, `birthdate`, `gender`, `nationality` FROM `student_tb` WHERE `stud_number` = "' .$studNum.'"';
    
        $students = $db->query($sql2);
        $students->setFetchMode(PDO::FETCH_ASSOC);
        $student = $students->fetch();
       
        $stmt2 = "SELECT `ay_name` FROM `ay_tb` WHERE `ay_id` = ". $ayId;
        $stmtExec2 = $db->query($stmt2);
        $stmtExec2->setFetchMode(PDO::FETCH_ASSOC);
        $row3 = $stmtExec2->fetch();
        $ayName = $row3['ay_name'];


        $stmt4 = "SELECT `grade_level` FROM grade_tb WHERE '" .$gradeId."' = `grade_id`";
        $stmtExec4 = $db->query($stmt4);
        $stmtExec4->setFetchMode(PDO::FETCH_ASSOC);
        $row4 = $stmtExec4->fetch();
        $gradeLvl = $row4['grade_level'];
        
        $stmt5 = "SELECT `section` FROM section_tb WHERE '" .$sectionId."' = `section_id`";
        $stmtExec5 = $db->query($stmt5);
        $stmtExec5->setFetchMode(PDO::FETCH_ASSOC);
        $row5 = $stmtExec5->fetch();
        $section = $row5['section'];
        
    }
    

    class myPDF extends FPDF{

        function __construct($studNum, $studLname,$studFname,$gradeLvl,$section,$bDate, $gender, $nationality, $ayName, $term, $cDate, $cConcern, $actionPlan, $status, $cDateEncode, $encodeBy) {
            parent::__construct();
            $this->studNum = $studNum;
            $this->studName = $studLname . ' '. $studFname;
            $this->gradeLvl = $gradeLvl;
            $this->section = $section;
            $this->bDate = $bDate;
            $this->gender = $gender;
            $this->nationality = $nationality;

            $this->ayName = $ayName;
            $this->term = $term;
            $this->cDate = $cDate;
            $this->cConcern = $cConcern;
            $this->actionPlan = $actionPlan;
            $this->status = $status;
            $this->cDateEncode = $cDateEncode;
            $this->encodeBy = $encodeBy;
        }

        private function MultiAlignCell($w,$h,$text,$border=0,$ln=0,$align='L',$fill=false)
        {
            $x = $this->GetX() + $w;
            $y = $this->GetY();
        
            $this->MultiCell($w,$h,$text,$border,$align,$fill);
        
            if( $ln==0 )
            {
                $this->SetXY($x,$y);
            }
        }
         
        function header(){
            $this->SetFont('Arial');
            $this->Cell(70,30,'COUNSELING REPORT',0,0,'C');
            $this->Ln();
            $this->Image("fpdf/logo.png",50,35);
            $this->Cell(330,20,'SOUTHVILLE INTERNATIONAL SCHOOL AND COLLEGES',0,0,'C');
            $this->Ln();
            $this->Cell(330,0,'Luxembourg St. corner Tropical Ave., B.F. Homes International',0,0,'C');
            $this->Ln();
            $this->Cell(330,10,'Las Pinas City, Philippines 1740 ',0,0,'C');
            $this->Ln();
            $this->Cell(330,0,'Tel. No. (632) 825-6374; (632) 820-8702 to 03 ',0,0,'C');
            $this->Ln();
            $this->Cell(330,10,'E-mail: pr@southville.edu.ph',0,0,'C');
            $this->Ln(25);
            $this->Cell(80,10,'STUDENT NUMBER: '.$this->studNum,0,0,0);
            $this->Cell(90,10,'NAME: '. $this->studName,0,0,0);
            $this->Ln();
            $this->Cell(80,10,'GRADE Level: '.$this->gradeLvl,0,0,0);
            $this->Cell(69,10,'Section: '.$this->section,0,0,0);
            $this->Ln();
            $this->Cell(58,10,'Birthdate: '.$this->bDate,0,0,0);
            $this->Cell(114,10,'Gender: '.$this->gender,0,0,0);
            $this->Ln();
            $this->Cell(61,10,'Nationality: '.$this->nationality,0,0,0);
            $this->Ln(15);
        }

        function headerTable(){
            $this->SetFont('Times');
            $this->MultiAlignCell(35,10,'ACADEMIC YEAR',1,0,'C');
            $this->MultiAlignCell(35,10,'ACADEMIC TERM',1,0,'C');
            $this->MultiAlignCell(35,10,'COUNSELING DATE',1,0,'C');
            $this->MultiAlignCell(35,10,'COUNSELING CONCERN',1,0,'C');
            $this->MultiAlignCell(35,20,'ACTION PLAN',1,0,'C');
            $this->MultiAlignCell(35,20,'STATUS',1,0,'C');
            $this->MultiAlignCell(35,20,'DATE ENCODED',1,0,'C');
            $this->MultiAlignCell(35,20,'ENCODED BY',1,0,'C');
            $this->Ln();
            $this->MultiAlignCell(35,20,$this->ayName,1,0,'C');
            $this->MultiAlignCell(35,20,$this->term,1,0,'C');
            $this->MultiAlignCell(35,20,$this->cDate,1,0,'C');
            $this->MultiAlignCell(35,20,$this->cConcern,1,0,'C');
            $this->MultiAlignCell(35,20,$this->actionPlan,1,0,'C');
            $this->MultiAlignCell(35,20,$this->status,1,0,'C');
            $this->MultiAlignCell(35,10,$this->cDateEncode,1,0,'C');
            $this->MultiAlignCell(35,20,$this->encodeBy,1,0,'C');
            $this->Ln();
        }      
    }

    $pdf = new myPDF($studNum, $student['stud_lname'], $student['stud_fname'], $gradeLvl, $section, $student['birthdate'], 
        $student['gender'], $student['nationality'], $ayName, $row['term'], $row['counseling_date'], $row['counseling_concern'],
        $row['action_plan'],$row['counseling_status'], $row['cdate_encoded'], $user['user_username']);
    $pdf->AliasNbPages();
    $pdf->AddPage('L','A4',0);
    $pdf->headerTable();
    $pdf->Output();

?>