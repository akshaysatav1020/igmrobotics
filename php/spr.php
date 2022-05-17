<?php

/*
* getSprId(), getSprNo(), getDeliveryTo(),getRequestBy(), getRequestDate(), getShipmentBy(), getCustomer(),
* getMachine(), getIgmOrderNo(), getIgmMachineNo(), getRemarks(), getRefEmail(), getCreatedBy(), getModifiedBy(),
* getCreatedOn(), getModifiedOn()
* SPR Part
* getSprPartId() getSpr() getQuantity() getPartNo() getSerialNo() getDescription() getRemarks()
* getUsedFrom()
*/
ini_set("display_errors",0);
require('db.php');
require('invoicetemplate.php');
require('data/sprObject.php');
require('data/sprPart.php');
require('data/sprTrack.php');
require_once "updateServerDBVersion.php";
class SPRPdf extends FPDF  {

    var $widths;
    var $aligns;

    function SetWidths($w){
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a){
        //Set the array of column alignments
        $this->aligns=$a;
    }

    function Row($data){
    //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++){
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x,$y,$w,$h,"DF");
            //Print the text
            $this->MultiCell($w,5,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h){
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger){

            $this->AddPage($this->CurOrientation);
            $this->setFont("Arial","B",9);
            $this->SetTextColor(255,255,255);
            $this->SetFillColor(251,49,40);
            $this->SetDrawColor(255,255,255);
            $this->Cell(10,8,"Qty.",1,0,'C',1);
            $this->Cell(20,8,"Part No.",1,0,'C',1);
			$this->Cell(20,8,"Serial No.",1,0,'C',1);
            $this->Cell(80,8,"Desc. of requested goods by igm India / customer",1,0,'C',1);
            $this->Cell(60,10,"Remarks",1,1,'C',1);
            $this->setFont("Arial","B",9);
            $this->SetTextColor(0,0,0);
            $this->SetFillColor(217,217,217);
            $this->SetDrawColor(255,255,255);
        }
    }

    function NbLines($w,$txt){
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
    
    function header(){
      /*$this->Image("../images/quotation_image.png",15,20, $this->getPageWidth()/2,15);      
      $this->Ln(30);*/
      $this->Image("../images/quotation_image.png",5,5, $this->getPageWidth()/2,15);
      $this->Ln(15);
    }
    
    function footer(){
      $this->SetY(-28);
      $this->SetTextColor(38,38,38);
      $this->SetDrawColor(255,0,0);
      $this->SetFont('Arial','',6.5);

      $this->Cell(90,5,'Page '.$this->PageNo()."/{nb}",0,0,'R');
      $this->Cell(90,5,' form ID: FOi-PO-04',0,1,'R');

      $this->Cell(45,5,"igm Roboticsystems India Pvt. Ltd.","L",0,'L');
      $this->Cell(35,5,"T: +91 20 2712 7678","L",0,'L');      
      $this->Cell(20,5,"General enquires:","L",0,'L');
      $this->SetFont('Arial','U',6.5);
      $this->SetTextColor(0,0,255);
      $this->Cell(23,5,"office@igm-india.com","",0,'L');
      $this->SetFont('Arial','',6.5);
      $this->SetTextColor(38,38,38);
      $this->SetFont('Arial','',6.5);
      $this->Cell(2,5,", ","",0,'L');
      $this->SetFont('Arial','U',6.5);
      $this->SetTextColor(0,0,255);
      $this->Cell(30,5,"sales@igm-india.com","",0,'L');
      $this->SetFont('Arial','',6.5);
      $this->SetTextColor(38,38,38);
      $this->Cell(25,5,"Corporate Identity No.","L",1,'L');

      $this->Cell(45,5,"Plot X-17, MIDC Bhosari","L",0,'L');
      $this->Cell(35,5,"F: +91 20 2712 7679","L",0,'L');      
      $this->Cell(40,5,"Service  enquires: +91 77 7402 2227","L",0,'L');
            //$this->Cell(40,5,"Service  enquires: +91 94 2300 4446","L",0,'L');
      $this->SetFont('Arial','U',6.5);
      $this->SetTextColor(0,0,255);
      $this->Cell(35,5,"service@igm-india.com","",0,'L');
      $this->SetFont('Arial','',6.5);
      $this->SetTextColor(38,38,38);
      $this->Cell(25,5,"U36900PN2007PTC158998","L",1,'L');

      $this->Cell(45,5,"Pune 411026, India","L",0,'L');
      $this->Cell(35,5,"www.igm-india.com","L",0,'L');
      $this->Cell(75,5,"A 100% daughter company of  igm Robotersysteme AG, Austria","L",0,'L');
      $this->Cell(25,5,"GST:    27AABCI7257D1ZM","L",1,'L');      
    }
  }

  function generatePDF($data){
    //var_dump($data);
    /*
    array(2) { ["sprDetails"]=> array(15) { ["spr_id"]=> string(1) "6" ["spr_no"]=> string(12) "SPR-20190211" ["delivery_to"]=> string(1) "1" ["request_by"]=> string(1) "1" ["request_date"]=> string(10) "2019-02-20" ["shipment_by"]=> string(7) "TNT/DHL" ["customer"]=> string(2) "24" ["machine"]=> string(1) "1" ["igm_order_no"]=> string(4) "1212" ["remarks"]=> string(5) "czxzz" ["ref_email"]=> string(3) "332" ["created_by"]=> string(24) "mani.prabu@igm-india.com" ["modified_by"]=> string(24) "mani.prabu@igm-india.com" ["created_on"]=> string(19) "2019-02-11 21:20:36" ["modified_on"]=> string(19) "2019-02-12 15:20:53" } ["sprParts"]=> array(2) { [0]=> array(8) { ["spr_part_id"]=> string(1) "4" ["spr"]=> string(1) "6" ["quantity"]=> string(1) "1" ["part_no"]=> string(4) "4101" ["serial_no"]=> string(6) "qwqwqw" ["description"]=> string(24) "Hose Package 600A,/ 2,4M" ["remarks"]=> string(6) "asasas" ["used_from"]=> string(15) "Customers stock" } [1]=> array(8) { ["spr_part_id"]=> string(1) "5" ["spr"]=> string(1) "6" ["quantity"]=> string(1) "1" ["part_no"]=> string(4) "4088" ["serial_no"]=> string(2) "aa" ["description"]=> string(10) "TWIN Torch" ["remarks"]=> string(2) "aa" ["used_from"]=> string(15) "Customers stock" } } } 
    */
    $db = new DB();
    $pdf = new SPRPdf();
    $pdf->setFont("Arial","B",12);
    $pdf->SetTextColor(0,0,0);
    $pdf->addPage();

    $pdf->AliasNbPages();
    //$pdf->SetLeftMargin(15);
    $pdf->SetAutoPageBreak(true,25);

    $st = $pdf->GetY();
    $pdf->Cell(110,5,"SPARE PART REQUEST","",1,'L');
    $pdf->Line(10,30,200,30);
    $pdf->setFont("Arial","B",8);
    $pdf->Cell(110,5,"SPR No.: ".$data["sprDetails"]["spr_no"],"",0,'L');
    $pdf->setFont("Arial","",8);    
    $pdf->Cell(80,5,"Request By: igm INDIA Office","",1,'L');
    $pdf->setFont("Arial","",8);
    $pdf->Cell(110,5,"Deliver To: igm Roboticsystems India Pvt. Ltd.","",0,'L');
    $pdf->Cell(110,5,"Request Date: ".(new DateTime($data["sprDetails"]["request_date"]))->format("d.m.Y"),"",1,'L');
    $pdf->setFont("Arial","",8);
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(110,5,"X17, General Block, Bhosari MIDC, Pimpri Chinchwad, Pune 411026.
India",0,'L',0);
    $addressHt = $pdf->GetMultiCellHeight(110,5,"D. Address: X17, General Block, Bhosari MIDC, , Phillips road, Pimpri Chinchwad, Pune 411026.
India",0,'L',0);
    $pdf->setFont("Arial","B",8);
    $pdf->SetXY($x+110,$y);
    $pdf->Cell(20,5,"Shipment by: ","",0,'L');
    
    $pdf->SetFont('ZapfDingbats','', 14);
    $t="r";
    if($data["sprDetails"]["shipment_by"]=="TNT/DHL"){
        $t="4";
    }
  	$pdf->Cell(6,6, $t, 0, 0,"C");
  	$pdf->setFont("Arial","B",8);
  	$pdf->Cell(20,5,"TNT/DHL","",0,'L');
  	$pdf->SetFont('ZapfDingbats','', 14);
    $f="r";
    if($data["sprDetails"]["shipment_by"]=="Freight"){
        $f="4";
    }
  	$pdf->Cell(6,6, $f, 0, 0,"C");
  	$pdf->setFont("Arial","B",8);
  	$pdf->Cell(20,5,"Frieght","",0,'L');
    $pdf->Line(10,55,200,55);
    $pdf->SetXY($x,$addressHt+45);
    $customer = "";    
    $query="SELECT * FROM customers WHERE id=".$data["sprDetails"]["customer"];
        $result = $db->getConnection()->query($query);
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $customer = $row['company_name'];
            }
    }
    $machineLocation="Not Defined";
    $query="SELECT * FROM machine WHERE machine_no='".$data["sprDetails"]["machine"]."'";
        $result = $db->getConnection()->query($query);
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $machineLocation = $row['location'];
            }
    }
    $pdf->setFont("Arial","",8);
    $pdf->Cell(15,5,"Customer:","",0,'L');
    $pdf->setFont("Arial","B",8);
    $pdf->Cell(95,5,$customer." ".$machineLocation,"",0,'L');
    $pdf->setFont("Arial","B",8);
    $pdf->Cell(80,5,"igm orderno.: ".$data["sprDetails"]["igm_order_no"],"",1,'L');
    $pdf->setFont("Arial","",8);
    $machineName="";$machineNo="";
    /*$query="SELECT * FROM machine WHERE machine_id=".$data["sprDetails"]["machine"];
        $result = $db->getConnection()->query($query);
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $machineName = $row["machine_name"];
                $machineNo = $row["machine_no"];
            }
    }*/
    $pdf->Cell(110,5,"M/C name: ".$data["sprDetails"]["machine_name"],"",0,'L');
    $pdf->setFont("Arial","B",8);
    $pdf->Cell(80,5,"igm machine no.: ".$data["sprDetails"]["machine"],"",1,'L');

    $pdf->setFont("Arial","B",10);
    $pdf->SetTextColor(0,0,0);     
    $pdf->LN(5);
    $na1 = $na2 = $na3 = $na4 = $na5 = $na6 = "r";
    $pdf->Cell(60,10,"Accountable Reason",1,0,'L');
    $pdf->Cell(130,10,"Non accountable Reason(warranty) ",1,1,'L');
    $pdf->SetFont('ZapfDingbats','', 14);
    $pdf->Cell(10,10,"r","LB",0,'L');
    $pdf->setFont("Arial","B",10);
    $pdf->Cell(50,10,"Accountable Reason","RB",0,'L');
    $pdf->SetFont('ZapfDingbats','', 14);
    /*foreach (explode(", ", $data["sprDetails"]["non_accountable_reason"]) as $key => $value) {
        if($value=="For set in operation / programming"){
            $na1="4";
        }elseif ($value=="For short/wrong supply replacement") {
            $na2="4";            
        }elseif ($value=="For demonstration/others") {
            $na3="4";            
        }elseif ($value=="For warranty") {
            $na4="4";            
        }elseif ($value=="As good will") {
            $na5="4";            
        }elseif ($value=="To transfer to consignment stock K14") {
            $na6="4";            
        }
    }*/
    switch ($data["sprDetails"]["non_accountable_reason"]) {
        case "For set in operation / programming":
            $na1="4";
            break;
        case "For short/wrong supply replacement":
            $na2="4";
            break;
        case "For demonstration/others":
            $na3="4";
            break;
        case "For warranty":
            $na4="4";
            break;
        case "As good will":
            $na5="4";
            break;
        case "To transfer to consignment stock K14":
            $na6="4";
            break;
    }
    $pdf->Cell(10,10,$na1,"B",0,'L');
    $pdf->setFont("Arial","B",10);
    $pdf->Cell(80,10,"for set in operation / programming","B",0,'L');
    $pdf->Cell(40,10,"By mail of service dpt. ","BR",1,'L');
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $h = $pdf->GetMultiCellHeight(60,8,$data["sprDetails"]["remarks"],0,"L",0);
    //echo $h;
    // remarks lenght to be 58 characters
    if(strlen($data["sprDetails"]["remarks"])<58){
        //echo strlen($data["sprDetails"]["remarks"]."\t");
        while ( (58-intval(strlen($data["sprDetails"]["remarks"]))) > 0) {
            $data["sprDetails"]["remarks"].="\t";
        }        
    }
    if(strlen($data["sprDetails"]["ref_email"])<28){
        //echo strlen($data["sprDetails"]["remarks"]."\t");
        while ( (28-intval(strlen($data["sprDetails"]["ref_email"]))) > 0) {
            $data["sprDetails"]["ref_email"].="\t";
        }        
    }

    $pdf->MultiCell(60,8,"Remarks:\n".$data["sprDetails"]["remarks"],"LB","L",0);
    
    $h=24;
    $pdf->SetXY($x+60,$y);
    $pdf->SetFont('ZapfDingbats','', 14);
    $pdf->Cell(10,$h/3,$na2,"LB",0,'L');
    $pdf->setFont("Arial","B",10);
    $pdf->Cell(80,$h/3,"for short/wrong supply replacement","B",0,'L');
    $pdf->Cell(40,$h/3,"By mail of service dpt. ","BR",1,'L');
    $pdf->SetXY($x+60,$y+($h/3));
    $pdf->SetFont('ZapfDingbats','', 14);
    $pdf->Cell(10,$h/3,$na3,"LB",0,'L');
    $pdf->setFont("Arial","B",10);
    $pdf->Cell(80,$h/3,"for demonstration/others","B",0,'L');
    $pdf->Cell(40,$h/3,"By mail of sales dpt. ","BR",1,'L');
    $y=$pdf->GetY();
    $pdf->SetXY($x+60,$y);
    $pdf->SetFont('ZapfDingbats','', 14);
    $pdf->Cell(10,$h/3,$na4,"LB",0,'L');
    $pdf->setFont("Arial","B",10);
    $pdf->Cell(80,$h/3,"for warranty","B",0,'L');
    $pdf->Cell(40,$h/3,"By mail of sales dpt. ","BR",1,'L');
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $href=$pdf->GetMultiCellHeight(60,8,"Ref. Email: ".$data["sprDetails"]["ref_email"],0,"L",0);
    //echo $href;
    // ref mail lenght to be 28 characters
    
    $pdf->MultiCell(60,8,"Ref. Email:\n".$data["sprDetails"]["ref_email"],"LB","L",0);        
    $h = $pdf->GetMultiCellHeight(60,8,"Remarks: "."Remarks  : Wire Feeder is not working checked and found the both cards are burnt.",0,"L",0);
    $pdf->SetXY($x+60,$y);
    $pdf->SetFont('ZapfDingbats','', 14);
    $pdf->Cell(10,$h/3,$na5,"LB",0,'L');
    $pdf->setFont("Arial","B",10);
    $pdf->Cell(80,$h/3,"as good will","B",0,'L');
    $pdf->Cell(40,$h/3,"By mail of sales dpt. ","BR",1,'L');
    $pdf->SetXY($x+60,$y+($h/3));
    $pdf->SetFont('ZapfDingbats','', 14);
    $pdf->Cell(10,$h/3,$na6,"LB",0,'L');
    $pdf->setFont("Arial","B",10);
    $pdf->Cell(80,$h/3,"to transfer to consignment stock K14","B",0,'L');
    $pdf->Cell(40,$h/3,"By mail of sales dpt. ","BR",1,'L');

    /*if($h!=24){
        if($h>=intval(8) || $h>=intval(2*8)){
            //$pdf->MultiCell(60,8,"Remarks:\n0123456789012345678901234567890123456789012345678901234567","LB","L",0);
            $pdf->MultiCell(60,8,"Remarks:\n".$data["sprDetails"]["remarks"],"LB","L",0);
        }else{
            $pdf->MultiCell(60,24,"Remarks: ".$data["sprDetails"]["remarks"],"LB","L",0);
        }
        $h=24;
        $pdf->SetXY($x+60,$y);
        $pdf->SetFont('ZapfDingbats','', 14);
        $pdf->Cell(10,$h/3,$na2,"LB",0,'L');
        $pdf->setFont("Arial","B",10);
        $pdf->Cell(80,$h/3,"for short/wrong supply replacement","B",0,'L');
        $pdf->Cell(40,$h/3,"By mail of service dpt. ","BR",1,'L');
        $pdf->SetXY($x+60,$y+($h/3));
        $pdf->SetFont('ZapfDingbats','', 14);
        $pdf->Cell(10,$h/3,$na3,"LB",0,'L');
        $pdf->setFont("Arial","B",10);
        $pdf->Cell(80,$h/3,"for demonstration/others","B",0,'L');
        $pdf->Cell(40,$h/3,"By mail of sales dpt. ","BR",1,'L');
        $y=$pdf->GetY();
        $pdf->SetXY($x+60,$y);
        $pdf->SetFont('ZapfDingbats','', 14);
        $pdf->Cell(10,$h/3,$na4,"LB",0,'L');
        $pdf->setFont("Arial","B",10);
        $pdf->Cell(80,$h/3,"for warranty","B",0,'L');
        $pdf->Cell(40,$h/3,"By mail of sales dpt. ","BR",1,'L');
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $href=$pdf->GetMultiCellHeight(60,8,"Ref. Email: ".$data["sprDetails"]["ref_email"],0,"L",0);
        //echo $href;
        // ref mail lenght to be 28 characters
        if($href<=8){
            $pdf->MultiCell(60,8,"Ref. Email:\n".$data["sprDetails"]["ref_email"],"LB","L",0);
        }else{
            $pdf->MultiCell(60,8,"Ref. Email  : ".$data["sprDetails"]["ref_email"],"LB","L",0);
        }
        $h = $pdf->GetMultiCellHeight(60,8,"Remarks: "."Remarks  : Wire Feeder is not working checked and found the both cards are burnt.",0,"L",0);
        $pdf->SetXY($x+60,$y);
        $pdf->SetFont('ZapfDingbats','', 14);
        $pdf->Cell(10,$h/3,$na5,"LB",0,'L');
        $pdf->setFont("Arial","B",10);
        $pdf->Cell(80,$h/3,"as good will","B",0,'L');
        $pdf->Cell(40,$h/3,"By mail of sales dpt. ","BR",1,'L');
        $pdf->SetXY($x+60,$y+($h/3));
        $pdf->SetFont('ZapfDingbats','', 14);
        $pdf->Cell(10,$h/3,$na6,"LB",0,'L');
        $pdf->setFont("Arial","B",10);
        $pdf->Cell(80,$h/3,"to transfer to consignment stock K14","B",0,'L');
        $pdf->Cell(40,$h/3,"By mail of sales dpt. ","BR",1,'L');
    }else{
        $pdf->MultiCell(60,8,"Remarks: ".$data["sprDetails"]["remarks"],"LB","L",0);
        $pdf->SetXY($x+60,$y);
        $pdf->SetFont('ZapfDingbats','', 14);
        $pdf->Cell(10,$h/3,$na2,"LB",0,'L');
        $pdf->setFont("Arial","B",10);
        $pdf->Cell(80,$h/3,"for short/wrong supply replacement","B",0,'L');
        $pdf->Cell(40,$h/3,"By mail of service dpt. ","BR",1,'L');
        $pdf->SetXY($x+60,$y+($h/3));
        $pdf->SetFont('ZapfDingbats','', 14);
        $pdf->Cell(10,$h/3,$na3,"LB",0,'L');
        $pdf->setFont("Arial","B",10);
        $pdf->Cell(80,$h/3,"for demonstration/others","B",0,'L');
        $pdf->Cell(40,$h/3,"By mail of sales dpt. ","BR",1,'L');
        $y=$pdf->GetY();
        $pdf->SetXY($x+60,$y);
        $pdf->SetFont('ZapfDingbats','', 14);
        $pdf->Cell(10,$h/3,$na4,"LB",0,'L');
        $pdf->setFont("Arial","B",10);
        $pdf->Cell(80,$h/3,"for warranty","B",0,'L');
        $pdf->Cell(40,$h/3,"By mail of sales dpt. ","BR",1,'L');
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $href=$pdf->GetMultiCellHeight(60,8,$data["sprDetails"]["ref_email"],0,"L",0);
        if($href>8){
            $pdf->MultiCell(60,8,"Ref. Email  : ".$data["sprDetails"]["ref_email"],"LB","L",0);
        }else{
            $pdf->MultiCell(60,16,"Ref. Email  : ".$data["sprDetails"]["ref_email"],"LB","L",0);
        }
        //$pdf->MultiCell(60,8,"Ref. Email  : ".$data["sprDetails"]["ref_email"],"LB","L",0);
        $h = $pdf->GetMultiCellHeight(60,8,"Remarks: "."Remarks  : Wire Feeder is not working checked and found the both cards are burnt.",0,"L",0);
        $pdf->SetXY($x+60,$y);
        $pdf->SetFont('ZapfDingbats','', 14);
        $pdf->Cell(10,$h/3,$na5,"LB",0,'L');
        $pdf->setFont("Arial","B",10);
        $pdf->Cell(80,$h/3,"as good will","B",0,'L');
        $pdf->Cell(40,$h/3,"By mail of sales dpt. ","BR",1,'L');
        $pdf->SetXY($x+60,$y+($h/3));
        $pdf->SetFont('ZapfDingbats','', 14);
        $pdf->Cell(10,$h/3,$na6,"LB",0,'L');
        $pdf->setFont("Arial","B",10);
        $pdf->Cell(80,$h/3,"to transfer to consignment stock K14","B",0,'L');
        $pdf->Cell(40,$h/3,"By mail of sales dpt. ","BR",1,'L');
    }*/

    /*$pdf->MultiCell(60,24,"Remarks: ".$data["sprDetails"]["remarks"],"LB","L",0);

    $pdf->SetXY($x+60,$y);
    $pdf->SetFont('ZapfDingbats','', 14);
    $pdf->Cell(10,$h/3,$na2,"LB",0,'L');
    $pdf->setFont("Arial","B",10);
    $pdf->Cell(80,$h/3,"for short/wrong supply replacement","B",0,'L');
    $pdf->Cell(40,$h/3,"By mail of service dpt. ","BR",1,'L');
    $pdf->SetXY($x+60,$y+($h/3));
    $pdf->SetFont('ZapfDingbats','', 14);
    $pdf->Cell(10,$h/3,$na3,"LB",0,'L');
    $pdf->setFont("Arial","B",10);
    $pdf->Cell(80,$h/3,"for demonstration/others","B",0,'L');
    $pdf->Cell(40,$h/3,"By mail of service dpt. ","BR",1,'L');
    $y=$pdf->GetY();
    $pdf->SetXY($x+60,$y);
    $pdf->SetFont('ZapfDingbats','', 14);
    $pdf->Cell(10,$h/3,$na4,"LB",0,'L');
    $pdf->setFont("Arial","B",10);
    $pdf->Cell(80,$h/3,"for warranty","B",0,'L');
    $pdf->Cell(40,$h/3,"By mail of service dpt. ","BR",1,'L');
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(60,16,"Ref. Email  : ".$data["sprDetails"]["ref_email"],"LB","L",0);
    $h = $pdf->GetMultiCellHeight(60,8,"Remarks: "."Remarks  : Wire Feeder is not working checked and found the both cards are burnt.",0,"L",0);
    $pdf->SetXY($x+60,$y);
    $pdf->SetFont('ZapfDingbats','', 14);
    $pdf->Cell(10,$h/3,$na5,"LB",0,'L');
    $pdf->setFont("Arial","B",10);
    $pdf->Cell(80,$h/3,"as good will","B",0,'L');
    $pdf->Cell(40,$h/3,"By mail of service dpt. ","BR",1,'L');
    $pdf->SetXY($x+60,$y+($h/3));
    $pdf->SetFont('ZapfDingbats','', 14);
    $pdf->Cell(10,$h/3,$na6,"LB",0,'L');
    $pdf->setFont("Arial","B",10);
    $pdf->Cell(80,$h/3,"to transfer to consignment stock K14","B",0,'L');
    $pdf->Cell(40,$h/3,"By mail of service dpt. ","BR",1,'L');*/
    $pdf->Ln(8);
    $pdf->setFont("Arial","B",9);
    $pdf->MultiCell(180, 5, "Error: ".$data["sprDetails"]["error"], '', 'L',0);
    $pdf->setFont("Arial","B",9);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFillColor(251,49,40);
    $pdf->SetDrawColor(255,255,255);

    $pdf->Cell(10,8,"Qty.",1,0,'C',1);
    $pdf->Cell(20,8,"Part No.",1,0,'C',1);
	$pdf->Cell(20,8,"Serial No.",1,0,'C',1);
    $pdf->Cell(80,8,"Desc. of requested goods by igm India / customer",1,0,'C',1);
    $pdf->Cell(60,8,"Remarks",1,1,'C',1);

    $pdf->setFont("Arial","B",9);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFillColor(217,217,217);
    $pdf->SetDrawColor(255,255,255);

    $partsNo = array();
    
    foreach ($data["sprParts"] as $key => $sprPart) {
        $query="SELECT * FROM inventory_parts WHERE id=".$sprPart["part_no"];
        $result = $db->getConnection()->query($query);
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $partsNo[] = $row['part_number'];
            }
        }
    }
            
    $subtotal = 0;
    $i = 0;
    $parts = array(array('quantity' => 2,
    'partno'=>'60E177',
    'description'=>'OPT/i Twin SR63B mit SC2 (4,040,086) Serial No : NAfdjhfjsfgjdgdsjfsjdhgfgsdjgfjdgfjgdsjgfjgsdfgsdjfjhdsgfjsdjfgsdjgfjgfjdgjfg',
    'remarks'=>'Card used from Boom #3 302118, now boom system is under break down'));
    $pdf->SetWidths(array(10,20,20,80,60));
    
    foreach ($data["sprParts"] as $key => $sprPart) {
        if ($pdf->GetY() == 2630||$pdf->GetY() == 2635.00125){
            $pdf->setFont("Arial","B",9);
            $pdf->SetTextColor(255,255,255);
            $pdf->SetFillColor(251,49,40);
            $pdf->SetDrawColor(255,255,255);
            $pdf->Cell(10,8,"Qty.",1,0,'C',1);
            $pdf->Cell(20,8,"Part No.",1,0,'C',1);
            $pdf->Cell(20,8,"Serial No.",1,0,'C',1);
			$pdf->Cell(80,8,"Desc. of requested goods by igm India / customer",1,0,'C',1);
			$pdf->Cell(60,8,"Remarks",1,1,'C',1);
        }else{
            //quantity part_no serial_no description remarks
        $pdf->setFont("Arial","B",9);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFillColor(217,217,217);
        $pdf->SetDrawColor(255,255,255);
        $pdf->Row(array($sprPart["quantity"],$partsNo[$key],$sprPart["serial_no"],$sprPart["description"],$sprPart["remarks"]));
        }
    }
    
    $pdf->Cell(190,10,"",1,1,'C');      
    $y=$pdf->GetY();
    if($y>=206){
        $pdf->AddPage();
    }
    
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);    

    $pdf->Cell(190,5,"Thank you",0,1,"L");
    $pdf->Cell(190,5,"With warm regards,",0,1,"L");    
    $pdf->Cell(190,5,"igm Roboticsystems India Pvt. Ltd.",0,1,"L");

    echo $pdf->Output();
  }

  if($_POST!=null){
    $db = new DB();
    $spr = new SPR();
    if(isset($_POST["addSPR"])){
        /*
        *spr details
        *sprno customer deliveryTo machino reqby reqdate ordreno refEmail shpimentBy terms
        *sprpart details
        *quantity partno description remark newpserial newpartuse
        */
        //print_r($_POST);
        $sprParts = new ArrayObject();
        foreach (explode(",", $_POST["ids"]) as $id) {
            //echo $_POST["quantity".$id];
            $partNo = explode("-", $_POST["partno".$id]);
           $sprParts[] = new SPRParts(0,$_POST["quantity".$id],$partNo[0],$_POST["serialNo".$id],$_POST["description".$id],$_POST["remark".$id],$_POST["usedFrom".$id]); 
        }
        $sprObject = new SPRObject($_POST["sprno"],$_POST["sprdate"],"1","igm India Office",$_POST["reqdate"],$_POST["shpimentBy"],
            explode("-", $_POST["customer"])[0],$_POST["machino"],$_POST["machiname"],$_POST["ordreno"],$_POST["nonAccountableReason"],$_POST["remark"],$_POST["error"],$_POST["refEmail"],$_COOKIE["usermail"],$_COOKIE["usermail"], $sprParts);
        //echo "<pre>";var_dump($sprObject); echo "</pre>";
        if($spr->addSPR($db->getConnection(),$sprObject)){
            //echo "Added";
            echo ("<SCRIPT LANGUAGE='JavaScript'>
                  window.alert('SPR Generated!!!')
                  window.location.href='../pages/spr.php';
                  </SCRIPT>");          
        }else{
            //echo "Err";
            echo ("<SCRIPT LANGUAGE='JavaScript'>
                  window.alert('Error Generating SPR!!!')
                  window.location.href='../pages/spr.php';
                  </SCRIPT>");
        }
    }else if(isset($_POST["editSpr"])){
        /*
        *id customer sprno date reqby reqdate validdate ordreno machino machiname terms
        *sprId sprno customer deliveryTo machino reqby reqdate ordreno refEmail shpimentBy terms
        */
        //echo "<pre>";echo implode(", ",$_POST["nonAccountableReason"]);echo "</pre>";
        $sprObject = new SPRObject($_POST["sprId"], $_POST["sprno"],$_POST["sprdate"],"1","igm India Office",$_POST["reqdate"],$_POST["shpimentBy"],$_POST["customer"],$_POST["machino"],$_POST["machiname"],$_POST["ordreno"],$_POST["nonAccountableReason"],$_POST["remark"],$_POST["error"],$_POST["refEmail"],$_COOKIE["usermail"],$_COOKIE["usermail"]);
        if($spr->updateSPR($db->getConnection(),$sprObject)){
            // echo "Updated";
            echo ("<SCRIPT LANGUAGE='JavaScript'>
                  window.alert('SPR Updated!!!')
                  window.location.href='../pages/editSpr.php?id=$_POST[sprId]';
                  </SCRIPT>");            
        }else{
            //echo "Err Updated";
            echo ("<SCRIPT LANGUAGE='JavaScript'>
                  window.alert('Error Updating SPR!!!')
                  window.location.href='../pages/editSpr.php?id=$_POST[sprId]';
                  </SCRIPT>");
        }
    }else if(isset($_POST["deleteSPR"])){
        if($spr->deleteSPR($db->getConnection(),$_POST["sprId"])){
            echo ("<SCRIPT LANGUAGE='JavaScript'>
                  window.alert('SPR Deleted!!!')
                  window.location.href='../pages/spr.php';
                  </SCRIPT>");            
        }else{
            echo ("<SCRIPT LANGUAGE='JavaScript'>
                  window.alert('Error Deleting SPR!!!')
                  window.location.href='../pages/spr.php';
                  </SCRIPT>");
        }        
    }else if(isset($_POST["getSPR"])){
        $spr->getSPR($db->getConnection(),$_POST["sprId"]);
    }else if(isset($_POST["getAllSPR"])){
        $spr->getAllSPR($db->getConnection());
    }else if(isset($_POST["addSPRPart"])){
        /*
        *sprId quantity part description remark newSer newPartUsed addSPRPart
        *$spr,$quantity,$part_no,$serial_no,$description,$remarks,$used_from
        */
        $sprPart = new SPRParts($_POST["sprId"],$_POST["quantity"],$_POST["part"],$_POST["newSer"],$_POST["description"],$_POST["remark"],$_POST['newPartUsed']);
        if($spr->addSPRPart($db->getConnection(),$sprPart)){
            echo ("<SCRIPT LANGUAGE='JavaScript'>
                  window.alert('SPR Part Added!!!')
                  window.location.href='../pages/editSpr.php?id=$_POST[sprId]';
                  </SCRIPT>");            
        }else{
            echo ("<SCRIPT LANGUAGE='JavaScript'>
                  window.alert('Error Updating SPR!!!')
                  window.location.href='../pages/editSpr.php?id=$_POST[sprId]';
                  </SCRIPT>");
        }
    }else if(isset($_POST["updateSPRPart"])){
        /*
        *eId eSprId eQuantity eUsedFrom ePart eDescription eRemark eSerialNo eNewPartUsed updateSPRPart
        *$spr_part_id, $spr,$quantity,$part_no,$serial_no,$description,$remarks,$used_from
        */
        
        $sprPart = new SPRParts($_POST["eId"],$_POST["eSprId"],$_POST["eQuantity"],$_POST["ePart"],$_POST["eSerialNo"],$_POST["eDescription"],$_POST["eRemark"],$_POST["eUsedFrom"]);
        if($spr->updateSPRPart($db->getConnection(),$sprPart)){
            echo ("<SCRIPT LANGUAGE='JavaScript'>
                  window.alert('SPR Part Updated!!!')
                  window.location.href='../pages/editSpr.php?id=$_POST[eSprId]';
                  </SCRIPT>");            
        }else{
            echo ("<SCRIPT LANGUAGE='JavaScript'>
                  window.alert('Error Updating SPR!!!')
                  window.location.href='../pages/editSpr.php?id=$_POST[eSprId]';
                  </SCRIPT>");
        }
    }else if(isset($_POST["deleteSPRPart"])){

    }else if(isset($_POST["getSPRPart"])){
        $spr->getSPRPart($db->getConnection(),$_POST["sprPartId"]);
    }else if(isset($_POST["updateSPRTrack"])){
        if($spr->updateSPRTrack($db->getConnection(),$_POST["sprTrackId"], $_POST["sprNo"], $_POST["partNo"], $_POST["requested"], $_POST["received"], $_POST["faulty"], $_POST["serialNo"])){
            echo ("<SCRIPT LANGUAGE='JavaScript'>
                  window.alert('Updated!!!')
                  window.location.href='../pages/spr.php';
                  </SCRIPT>");            
        }else{
            echo ("<SCRIPT LANGUAGE='JavaScript'>
                  window.alert('Error Updating!!!')
                  window.location.href='../pages/spr.php';
                  </SCRIPT>");
        }
    }else if(isset($_POST["getAllSPRTrack"])){
        $spr->getAllSPRTrack($db->getConnection());
    }else if(isset($_POST["getSPRTrack"])){
        $spr->getSPRTrack($db->getConnection(),$_POST["id"]);
    }else if(isset($_POST["deleteSPRTrack"])){
        if($spr->deleteSPRTrack($db->getConnection(), $_POST["id"])){
            echo "Deleted";
        }else{
            echo "Error Deleting";
        }
    }
  }else{
    $db = new DB();
    $spr = new SPR();
  	generatePDF($spr->getSPRPDF($db->getConnection(),$_GET["id"]));
  }

  /**
   * 
   */
  class SPR{
        function addSPR($connection,$sprObject){
            $success = false;
            $query = <<<EOF
            INSERT INTO spr
            (spr_no, spr_date, delivery_to, request_by, request_date, shipment_by, customer, machine,machine_name,
            igm_order_no, non_accountable_reason, remarks,error, ref_email, created_by, modified_by, created_on, modified_on)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,(SELECT NOW()),(SELECT NOW()))
EOF;
            $stmt = $connection->prepare($query);
            $stmt->bind_param("ssisssisssssssss",$sprno,$sprdate,$deliveryTo,$requestBy,$requestDate,$shipmentBy,$customer,$machine,$machineName,$igmOrderNo,$nonAccountableReason,$remarks,$error,$refEmail,$cb,$mb);
            $sprno = $sprObject->getSprNo();
            $spD = new DateTime($sprObject->getSprDate());
            $sprdate = $spD->format('Y-m-d H:i:s');
            $deliveryTo = $sprObject->getDeliveryTo();
            $requestBy = $sprObject->getRequestBy();
            $requestDate = $sprObject->getRequestDate();
            $shipmentBy = $sprObject->getShipmentBy();
            //$shipmentDate = $sprObject->getShipmentDate();
            $customer = $sprObject->getCustomer();
            $machine = $sprObject->getMachine();
            $machineName = $sprObject->getMachineName();
            $igmOrderNo = $sprObject->getIgmOrderNo();
            $nonAccountableReason = $sprObject->getNonAccountableReason();
            $remarks = $sprObject->getRemarks();
            $error = $sprObject->getError();
            $refEmail = $sprObject->getRefEmail();
            $cb = $sprObject->getCreatedBy();
            $mb = $sprObject->getModifiedBy();
            if($stmt->execute()){
                $sprId=0;
                $query = "select spr_id as id from spr ORDER BY spr_id desc LIMIT 1";
                $result = $connection->query($query);
                if($result->num_rows>0){
                    while ($row=$result->fetch_assoc()) {
                        $sprId=$row["id"];
                    }
                }
                foreach ($sprObject->getSprParts() as $sprPart) {
                    $sprPart->setSpr($sprId);
                    if(self::addSPRPart($connection,$sprPart)){
                        $success=true;
                    }else{
                        $success=false;
                    }
                }                

            }else{
                
                echo $stmt->error;
                error_log($stmt->error);
            }
            if($success){
                // $upSDB = new UpdateServerDBVersion();
                // if($upSDB->updateDBVersion()){
                //     $success = true;
                // }else{
                //    $success = false; 
                // }
            }
            return $success;
        }
        function updateSPR($connection,$sprObject){
            //echo "<pre>";var_dump($sprObject);echo "</pre>";
            $success = false;
            $query = <<<EOF
            UPDATE spr SET spr_no=?,spr_date=?,delivery_to=?,request_by=?,request_date=?,shipment_by=?,customer=?,
            machine=?,machine_name=?,igm_order_no=?,non_accountable_reason=?,remarks=?,error=?,ref_email=?,modified_by=?,modified_on=(SELECT NOW()) 
            WHERE spr_id=?
EOF;
            $stmt = $connection->prepare($query);
            $stmt->bind_param("ssisssissssssssi",$sprno,$sprdate, $deliveryTo,$requestBy,$requestDate,$shipmentBy,$customer,$machine,$machineName,$igmOrderNo,$nonAccountableReason,$remarks,$error,$refEmail,$mb,$sprId);
            $sprno = $sprObject->getSprNo();
            $spD = new DateTime($sprObject->getSprDate());
            $sprdate = $spD->format('Y-m-d H:i:s');
            $deliveryTo = $sprObject->getDeliveryTo();
            $requestBy = $sprObject->getRequestBy();
            $requestDate = $sprObject->getRequestDate();
            $shipmentBy = $sprObject->getShipmentBy();
            //$shipmentDate = $sprObject->getShipmentDate();
            $customer = $sprObject->getCustomer();
            $machine = $sprObject->getMachine();
            $machineName = $sprObject->getMachineName();
            $igmOrderNo = $sprObject->getIgmOrderNo();
            $nonAccountableReason = $sprObject->getNonAccountableReason();
            $remarks = $sprObject->getRemarks();
            $error = $sprObject->getError();
            $refEmail = $sprObject->getRefEmail();            
            $mb = $sprObject->getModifiedBy();
            $sprId=$sprObject->getSprId();

            if($stmt->execute()){
                $success=true;
                // $upSDB = new UpdateServerDBVersion();
                // if($upSDB->updateDBVersion()){
                //     $success = true;
                // }else{
                //    $success = false; 
                // }
            }else{
                echo $stmt->error;
            }
            return $success;
        }
        function deleteSPR($connection,$sprId){
            $success = false;
            $query = <<<EOF
            DELETE FROM spr WHERE spr_id=?
EOF;
            $stmt = $connection->prepare($query);
            $stmt->bind_param("i",$sprId);
            $sprId = $sprId;
            if($stmt->execute()){
                $success = true;
                /*$upSDB = new UpdateServerDBVersion();
                if($upSDB->updateDBVersion()){
                }else{
                   $success = false; 
                }*/
            }else{
                $stmt->error;
            }
            return $success;
        }
        function getSPR($connection,$sprId){
            $data = array();
            $query = <<<EOF
            SELECT * FROM spr WHERE spr_id=$sprId
EOF;
            $result = $connection->query($query);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){

                    $data = array("sprDetails"=>$row,"sprParts"=>self::getAllSPRParts($connection, $row["spr_id"]));

                }
            }
            echo json_encode($data);
        }

        function getSPRPDF($connection,$sprId){
            $data = array();
            $query = <<<EOF
            SELECT * FROM spr WHERE spr_id=$sprId
EOF;
            $result = $connection->query($query);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){

                    $data = array("sprDetails"=>$row,"sprParts"=>self::getAllSPRParts($connection, $row["spr_id"]));

                }
            }
            return $data;
        }
        function getAllSPR($connection){
            $data = array();
            $query = <<<EOF
            SELECT * FROM spr
EOF;
            $result = $connection->query($query);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    $data[] = array('sprDetails' => $row, 'customerDetails'=>self::getCustomer($connection,$row["customer"]));
                }
            }
            echo json_encode($data);
        }

        /*SPR Parts*/
        function addSPRPart($connection,$sprPartObject){
            $success = false;
            $query = <<<EOF
            INSERT INTO spr_parts(spr, quantity, part_no, serial_no, description, remarks, used_from)
            VALUES
            (?,?,?,?,?,?,?)
EOF;
            $stmt = $connection->prepare($query);
            $stmt->bind_param("iiissss",$spr,$quantity,$partNo,$serialNo,$description,$remarks,$usedFrom);
            $spr = $sprPartObject->getSpr();
            $quantity = $sprPartObject->getQuantity();
            $partNo = $sprPartObject->getPartNo();
            $serialNo = $sprPartObject->getSerialNo();
            $description = $sprPartObject->getDescription();
            $remarks = $sprPartObject->getRemarks();
            $usedFrom = $sprPartObject->getUsedFrom();
            if($stmt->execute()){
                if(self::insertSPRTrack($connection, $sprPartObject->getSpr(), 
                    $sprPartObject->getPartNo(), $sprPartObject->getQuantity(), $sprPartObject->getSerialNo())){
                    $success = true;
                }

                /*$upSDB = new UpdateServerDBVersion();
                if($upSDB->updateDBVersion()){
                    $success = true;
                }else{
                   $success = false; 
                }*/
            }else{
               echo $stmt->error(); 
            }
            return $success;
        }
        function updateSPRPart($connection,$sprPartObject){
            $success = false;
            $query = <<<EOF
            UPDATE spr_parts SET 
            spr=?,quantity=?,part_no=?,serial_no=?,description=?,remarks=?,used_from=? 
            WHERE spr_part_id = ?
EOF;
            $stmt = $connection->prepare($query);
            $stmt->bind_param("iiissssi",$spr,$quantity,$partNo,$serialNo,$description,$remarks,$usedFrom,$sparePartId);
            $spr = $sprPartObject->getSpr();
            $quantity = $sprPartObject->getQuantity();
            $partNo = $sprPartObject->getPartNo();
            $serialNo = $sprPartObject->getSerialNo();
            $description = $sprPartObject->getDescription();
            $remarks = $sprPartObject->getRemarks();
            $usedFrom = $sprPartObject->getUsedFrom();
            $sparePartId = $sprPartObject->getSprPartId();
            if($stmt->execute()){
                if(self::updateSPRTrackWithPart($connection,$sprPartObject->getSprPartId(), 
                    $sprPartObject->getSpr(), $sprPartObject->getPartNo(), $sprPartObject->getQuantity(), $sprPartObject->getSerialNo())){

                    $success = true;
                }
                /*$upSDB = new UpdateServerDBVersion();
                if($upSDB->updateDBVersion()){
                }else{
                   $success = false; 
                }*/
            }
            return $success;
        }

        function updateSPRTrackWithPart($connection, $sprTrackId, $sprNo, $partNo, $requested, $serialNo){
            $success = false;
            $query = <<<EOF
            UPDATE spr_tracking 
            SET
            spr_no=?,part_no=?,requested=?, serial_no=? 
            WHERE spr_track_id=?
EOF;
            $stmt = $connection->prepare($query);
            $stmt->bind_param("iiisi", $sprNo, $partNo, $requested, $serialNo, $sprTrackId);
            $sprNo = $sprNo;
            $partNo = $partNo;
            $requested = $requested;
            $serialNo = $serialNo; 
            $sprTrackId = $sprTrackId;
            if($stmt->execute()){
                $success = true;
                /*$upSDB = new UpdateServerDBVersion();
                if($upSDB->updateDBVersion()){
                    $success = true;
                }else{
                   $success = false; 
                }*/
            }else{
               echo $stmt->error(); 
            }
            return $success;
        }

        function deleteSPRPart($connection,$sprPartId){
            $success = false;
            $query = <<<EOF
            DELETE FROM spr_parts WHERE spr_part_id = ?
EOF;
            $stmt = $connection->prepare($query);
            $stmt->bind_param("i",$sprPartId);
            $sprPartId = $sprPartId;
            if($stmt->execute()){
                if(self::deleteSPRTrack($connection, $sprPartId)){
                   $success = true; 
                }
               /* $upSDB = new UpdateServerDBVersion();
                if($upSDB->updateDBVersion()){
                }else{
                   $success = false; 
                }*/
            }
            return $success;
        }
        function getSPRPart($connection,$sprPartId){
            $data = array();
            $query = <<<EOF
            SELECT * FROM spr_parts 
            WHERE spr_part_id = $sprPartId
EOF;
            $result = $connection->query($query);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    $data = $row;
                }
            }
            echo json_encode($data);
        }
        function getAllSPRParts($connection, $sprId){
            $data = array();
            $query = <<<EOF
            SELECT * FROM spr_parts 
            WHERE spr = $sprId

EOF;
            $result = $connection->query($query);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    $data[] = $row;
                }
            }
            
            return $data;//echo json_encode($data);
        }

        function insertSPRTrack($connection, $sprNo, $partNo, $requested, $serialNo){
            $success = false;
            $query = <<<EOF
            INSERT INTO spr_tracking
            (spr_no, part_no, requested, received, faulty, serial_no)
            VALUES
            (?,?,?,?,?,?)
EOF;
            $stmt = $connection->prepare($query);
            $stmt->bind_param("iiiiis", $sprNo, $partNo, $requested, $received, $faulty, $serialNo);
            $sprNo = $sprNo;
            $partNo = $partNo;
            $requested = $requested;
            $received = 0;
            $faulty = 0;
            $serialNo = $serialNo;
            if($stmt->execute()){
                $success = true;
                /*$upSDB = new UpdateServerDBVersion();
                if($upSDB->updateDBVersion()){
                    $success = true;
                }else{
                   $success = false; 
                }*/
            }else{
               echo $stmt->error(); 
            }
            return $success;
        }

        function updateSPRTrack($connection, $sprTrackId, $sprNo, $partNo, $requested, $received, $faulty, $serialNo){
            $success = false;
            $query = <<<EOF
            UPDATE spr_tracking 
            SET
            spr_no=?,part_no=?,requested=?,received=?,faulty=?, serial_no=? 
            WHERE spr_track_id=?
EOF;
            $stmt = $connection->prepare($query);
            $stmt->bind_param("iiiiisi", $sprNo, $partNo, $requested, $received, $faulty, $serialNo, $sprTrackId);
            $sprNo = $sprNo;
            $partNo = $partNo;
            $requested = $requested;
            $received = $received;
            $faulty = $faulty;
            $serialNo = $serialNo; 
            $sprTrackId = $sprTrackId;
            if($stmt->execute()){
                $success = true;
                /*$upSDB = new UpdateServerDBVersion();
                if($upSDB->updateDBVersion()){
                    $success = true;
                }else{
                   $success = false; 
                }*/
            }else{
               echo $stmt->error(); 
            }
            return $success;
        }

        function getAllSPRTrack($connection){
            $data = array();
            $query = <<<EOF
            SELECT * FROM spr_tracking

EOF;
            $result = $connection->query($query);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    $data[] = array('spr_track_id' => $row["spr_track_id"], 'spr_no'=>self::getSPRForTrack($connection,$row["spr_no"]),
                        'part_no' => self::getPart($connection, $row["part_no"]),'requested' => $row["requested"], 'received'=>$row["received"],
                        'faulty' => $row["faulty"], 'serial_no'=>$row["serial_no"] );
                }
            }
            
            echo json_encode($data);

        }     

        function getSPRTrack($connection, $id){
            $data = "";
            $query = <<<EOF
            SELECT * FROM spr_tracking WHERE spr_track_id = $id

EOF;
            $result = $connection->query($query);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){                    
                    $data = $row;
                }
            }
            
            echo json_encode($data);

        }    

        function deleteSPRTrack($connection, $id){
            $success = false;            
            $query = <<<EOF
            DELETE FROM spr_tracking WHERE spr_track_id = ?
EOF;
            $stmt = $connection->prepare($query);
            $stmt->bind_param("i",$id);
            $id = $id;
            if($stmt->execute()){
                $success = true;                 
            }
            return $success;

        }

        function getSPRForTrack($connection, $id){
          $data = "";
            $query = <<<EOF
            SELECT * FROM spr WHERE spr_id=$id
EOF;
            $result = $connection->query($query);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    $data = $row["spr_no"];
                }
            }
            return $data;
        }

        function getPart($connection, $id){
          $query="SELECT * FROM inventory_parts WHERE id=".$id;
          $result = $connection->query($query);
          $data = "";
          if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
              $data = $row["part_number"];
            }
          }
          return $data;
        }

        function getCustomer($connection,$id){
            $query="SELECT * FROM customers WHERE id = ".$id."";
                $result = $connection->query($query);
                $data = "";
                if($result->num_rows>0){
                    while($row=$result->fetch_assoc()){
              $data = array('id'=>$row['id'],'cno'=>$row['cno'],'company'=>$row['company_name'],
              'addressline1'=>$row['addressline1'],'addressline2'=>$row['addressline2'],
              'city'=>$row['city'],'country'=>$row['country'],
              'person1'=>$row['contact_person1_name'],'no1'=>$row['contact_person1_number'],
              'email1'=>$row['contact_person1_email'],'person2'=>$row['contact_person2_name'],
              'no2'=>$row['contact_person2_number'], 'email2'=>$row['contact_person2_email'],
              'discount1'=>$row['discount1'], 'discount2'=>$row['discount2'],'discount3'=>$row['discount3'],
              'cb'=>$row['created_by'],'co'=>$row['created_on'],
              'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
                    }
                }
            return $data;
        }

  }
?>