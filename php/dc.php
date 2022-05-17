<?php
  require('db.php');
  require_once("../phplibraries/fpdf.php");

class PO extends FPDF  {

    private $dc = null;

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
            $this->setFont("Arial","B",8);
            $this->SetTextColor(255,255,255);
            $this->SetFillColor(251,49,40);
            $this->SetDrawColor(255,255,255);
            $this->Cell(5,8,"No.",1,0,'C');
            $this->Cell(20,8,"Part No.",1,0,'C');
            $this->Cell(8,8,"Qty.",1,0,'C');
            //$this->Cell(20,8,"Unit Price",1,0,'C');
            $this->Cell(110,8,"Description of goods",1,0,'C');
            $this->Cell(40,8,"Serial Nos.",1,0,'C',true);
            $this->Cell(10,8,"Amount",1,1,'C',true);

            $this->setFont("Arial","",9);
            $this->SetTextColor(0,0,0);
            $this->SetFillColor(217,217,217);
            $this->SetDrawColor(255,255,255);
        }
    }

    function NbLines($w,$txt){        
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
      $this->Image("../images/quotation_image.png",5,5, $this->getPageWidth()/2,15);
      $this->Ln(15);
    }

    function footer(){
      $this->SetY(-28);
      $this->SetTextColor(38,38,38);
      $this->SetDrawColor(255,0,0);
      $this->SetFont('Arial','',6.5);

      $this->Cell(90,5,'Page '.$this->PageNo()."/{nb}",0,0,'R');
      $this->Cell(90,5,' form ID: FOi-DC-04',0,1,'R');

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

  if($_POST!=null){
        
    $db = new DB();
    if(isset($_POST['generateDC'])){
      //echo "<pre>";var_dump($_POST);echo "</pre>";
      if(addDC($db->getConnection(), $_POST)){
        echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('Added')
          window.location.href='../pages/challan.php';
          </SCRIPT>");        
      }else{
          echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('Error Adding Challan')
          window.location.href='../pages/challan.php';
          </SCRIPT>");
      }
    }

    else if(isset($_POST['updateDC'])){
      $chId = $_POST["id"];
      $dcObj = new DeliveryChallan($_POST['id'],$_POST['to'],$_POST['challannumber'],$_POST["eprojectno"],$_POST['issuedate'],$_POST['referencenumber'],
      $_POST['refdate'],$_POST['returnable'],$_POST['mode'],$_POST['lr'],$_POST['vehicle'],
      $_POST["ecourier"],$_POST["edispatchno"],$_POST['freight'],$_POST['shipdate'],
      $_POST['terms'],$cb,$date->format('Y-m-d H:i:s'));
      if(editDC($db->getConnection(), $dcObj)){
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Edited')
            window.location.href='../pages/editChallan.php?type=challan&id=$chId';
            </SCRIPT>");
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Error Editing')
            window.location.href='../pages/editChallan.php?type=challan&id=$chId';
            </SCRIPT>");
      }
    }

    else if(isset($_POST['getDC'])){
      getDC($db->getConnection(),$_POST["dcId"]);
    }

    else if(isset($_POST['getAllDC'])){
      getAllDC($db->getConnection(),$_POST);
    }

    else if(isset($_POST['deleteDC'])){
      if(deleteDC($db->getConnection(), $_POST["dcId"])){
        echo "Deleted";
      }else{
        echo "Error Deleting DC";
      }
    }

    else if(isset($_POST['getDCPart'])){
      getDCPart($db->getConnection(), $_POST['dcPartId']);
    }

    else if(isset($_POST['addDCPart'])){      
      
      $id = explode("-", $_POST["challanId"])[0];      
      if(addDCPart($db->getConnection(), $_POST)){        
        echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('Part Added')
         window.location.href='../pages/editChallan.php?type=challan&id=$id';
          </SCRIPT>");
                
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Error Adding part')
            window.location.href='../pages/editChallan.php?type=challan&id=$id';
            </SCRIPT>");
      }
    }

    else if(isset($_POST['updateDCPart'])){
      $chId = $_POST["echallanId"];
      $part = new ChallanParts($_POST["eid"],  $_POST["echallanId"],"0",$_POST["epart"],$_POST["eqty"],
        "0.00","0.00","0.00",
        "0.00","0.00",$_POST['eserialno']);
      if(updateDCPart($db->getConnection(), $part)){
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Part Edited')
            window.location.href='../pages/editChallan.php?type=challan&id=$chId';
            </SCRIPT>");
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Error Editing Part')
            window.location.href='../pages/editChallan.php?type=challan&id=$chId';
            </SCRIPT>");
      }
    } 

    else if(isset($_POST['deleteDCPart'])){
      if(deleteDCPart($db->getConnection(), $_POST["partId"])){
        echo "Deleted";
      }else{
        echo "Error Deleting Part";
      }
    }

    else if(isset($_POST["getPreDCNo"])){
      getPreDC($db->getConnection());
    }

    else if(isset($_POST["getDCSerial"])){
      getDCSerial($db->getConnection(),$_POST["id"]);
    }

    else if(isset($_POST["getLastDC"])){
      getLastDC($db->getConnection());
    }

    else if(isset($_POST["getDCForStatus"])){
      getDCForStatus($db->getConnection(),$_POST);
    }

    else if(isset($_POST["updateDCClosing"])){
     if(updateDCClosing($db->getConnection(),$_POST)){
      echo ("<SCRIPT LANGUAGE='JavaScript'>
      window.alert('Updated');
      window.location.href='../pages/challan.php';
      </SCRIPT>");
     }else {
      echo ("<SCRIPT LANGUAGE='JavaScript'>
      window.alert('Some Error Occured while updating..');
      window.location.href='../pages/challan.php';
      </SCRIPT>");
     }
    }

    else if(isset($_POST["getSerialByInward"])){
      getSerialByInward($db->getConnection(),$_POST["inwardno"],$_POST["partno"]);
    }

    else if(isset($_POST["getAllSerial"])){
      getAllSerial($db->getConnection(),$_POST["partno"]);
    }

    else if(isset($_POST["getParticularDC"])){
        getParticularDC($db->getConnection(),$_POST);
    }
    else if(isset($_POST["getCustomerForDC"])){
      getCustomerForDC($db->getConnection(),$_POST);
    }


  }else{
    $db = new DB();
    if(isset($_GET["id"])){
      /*$dc = getDCPrint($db->getConnection(),$_GET['id']);
      $to = getCust($db->getConnection(),$dc[0]['to']);
      $partsNo = getPartsNo($db->getConnection(),$dc[0]['chParts']);
      $copy = $_GET["copy"]=="Original" || $_GET["copy"]=="original"?$_GET["copy"]:$_GET["copy"]." Copy";
      generatePDF($to, $partsNo, $dc,$copy);*/
      generatePDF($db->getConnection(),$_GET);
    }
  }
  
  

  function generatePDF($connection,$params){
    $copy = $params["copy"]=="Original" || $params["copy"]=="original"?$params["copy"]:$params["copy"]." Copy";
    $challanType="";
    $query="select dc.id, dc.projectno, dc.challan_no,  dc.ref_no, dc.challanType, 
      date_format(dc.ref_date, '%d-%m-%Y') as ref_date,
      date_format(dc.date, '%d-%m-%Y') as date, dc.closing_status,dc.transport,dc.vehicle,
      dc.courier,dc.dispatchno,dc.terms,      
      c.cno,c.company_name,c.addressline1,c.addressline2,c.city,c.country,c.contact_person1_name,
      ip.part_number,ip.description,dcp.serials,dcp.qty,dcp.unitprice,dcp.partTotAmount
      from deliverychallan dc left join dc_products dcp on dc.id=dcp.dcId
      left join customers c on dc.cust_id=c.id
      left join inventory_parts ip on dcp.partId=ip.id 
      WHERE dc.id=".$params["id"];
      $result = $connection->query($query);
      $data = "";$dcparticulars=[];
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){          
          $challanType = $row["challanType"];
          
        }
      }
     //Get Info
     if($challanType=="nontraceable"){
        $query="select dc.id, dc.projectno, dc.challan_no,  dc.ref_no, dc.challanType, 
          date_format(dc.ref_date, '%d-%m-%Y') as ref_date,
          date_format(dc.date, '%d-%m-%Y') as date, dc.closing_status,dc.transport,dc.vehicle,
          dc.courier,dc.dispatchno,dc.terms,      
          c.cno,c.company_name,c.addressline1,c.addressline2,c.city,c.country,c.contact_person1_name,
          dcp.id as particularId, dcp.dcId, dcp.part_no, dcp.description, dcp.unitprice, dcp.qty, dcp.serial, dcp.amount
          from deliverychallan dc left join nontraceabledcparts dcp on dc.id=dcp.dcId
          left join customers c on dc.cust_id=c.id
          WHERE dc.id=".$params["id"];
          $result = $connection->query($query);
          $data = "";$dcparticulars=[];
          if($result->num_rows>0){
            while($row=$result->fetch_assoc()){          
              $data = $row;
              $desc = iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']);
              $dcparticulars[]=array("part_number"=>$row["part_no"],"description"=>$desc,
                "serials"=>$row["serial"],"qty"=>$row["qty"],"unitprice"=>$row["unitprice"],
                "partTotAmount"=>$row["amount"]);
            }
          }
     }else{
        $query="select dc.id, dc.projectno, dc.challan_no,  dc.ref_no, dc.challanType, 
      date_format(dc.ref_date, '%d-%m-%Y') as ref_date,
      date_format(dc.date, '%d-%m-%Y') as date, dc.closing_status,dc.transport,dc.vehicle,
      dc.courier,dc.dispatchno,dc.terms,      
      c.cno,c.company_name,c.addressline1,c.addressline2,c.city,c.country,c.contact_person1_name,
      ip.part_number,ip.description,dcp.serials,dcp.qty,dcp.unitprice,dcp.partTotAmount
      from deliverychallan dc left join dc_products dcp on dc.id=dcp.dcId
      left join customers c on dc.cust_id=c.id
      left join inventory_parts ip on dcp.partId=ip.id 
      WHERE dc.id=".$params["id"];
      $result = $connection->query($query);
      $data = "";$dcparticulars=[];
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){          
          $data = $row;
          $desc = iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']);
          $dcparticulars[]=array("part_number"=>$row["part_number"],"description"=>$desc,
            "serials"=>$row["serials"],"qty"=>$row["qty"],"unitprice"=>$row["unitprice"],
            "partTotAmount"=>$row["partTotAmount"]);
        }
      }     
     }
      
    
    
      
    //PDF Creation
    $pdf = new PO();    
    $pdf->setFont("Arial","B",9);
    $pdf->SetTextColor(0,0,0);
    $pdf->addPage();    
    $pdf->text(126, 20, $copy);

    $pdf->AliasNbPages();
    
    $pdf->SetAutoPageBreak(true,25);
            
    $st = $pdf->GetY();
    $pdf->setFont("Arial","",8);
    $pdf->Cell(140,5,"To,","",0,'L');
    $pdf->setFont("Arial","",8);    
    $pdf->Cell(50,5,"igm Roboticsystems India Pvt. Ltd.","",1,'L');
    $pdf->setFont("Arial","",8);

    if($data["company_name"]!=""){
      $pdf->Cell(140,5,$data["company_name"],"",1,'L');
    }else{
      $pdf->Cell(140,5,"Data not present","",1,'L');
    }
    if($data["contact_person1_name"]!=""){
      $pdf->Cell(140,5,"Attn.: ".$data["contact_person1_name"],"",0,'L');
    }else{
      $pdf->Cell(140,5,"Data not present","",0,'L');
    }
    $pdf->setFont("Arial","",8);
    $pdf->Cell(50,5,"Contact:  Sarika Dive","",1,'L');
    $pdf->setFont("Arial","",8);
    if($data["addressline1"]!=""){
      $pdf->Cell(140,5,$data["addressline1"].",","",0,'L');
    }else{
      $pdf->Cell(140,5,"Data not present".",","",0,'L');
    }
    $pdf->setFont("Arial","",8);
    $pdf->Cell(50,5,"Mobile: +91 7738155709","",1,'L');
    $pdf->setFont("Arial","",8);
    if($data["addressline2"]!=""){
      $pdf->Cell(140,5,$data["addressline2"].",","",0,'L');
    }else{
      $pdf->Cell(140,5,"Data not present".",","",0,'L');
    }
    $pdf->setFont("Arial","",8);
    $pdf->Cell(50,5,"E-mail: sarika.dive@igm-india.com","",1,'L');
    $pdf->setFont("Arial","",8);
    if($data["city"]!=""){
      $pdf->Cell(140,5,$data["city"].",","",1,'L');
    }else{
      $pdf->Cell(140,5,"Data not present","",1,'L');
    }
    $pdf->setFont("Arial","",8);
    if($data["country"]!=""){
      $pdf->Cell(140,5,$data["country"].".","",0,'L');
    }else{
      $pdf->Cell(140,5,"Data not present","",0,'L');
    }
    $pdf->setFont("Arial","",8);
    $date=new DateTime();
    $pdf->Cell(50,5,"Date: ".$date->format("d/M/Y"),"",1,'L');

    $pdf->setFont("Arial","B",8);
    $pdf->SetTextColor(251,49,40);     

    
    $pdf->Cell(30,8,"DELIVERY CHALLAN","",0,'L');
    $pdf->Cell(60,8,"No. DC-".$data["challan_no"],"",1,'L');

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38); 
    
    
    if($data["company_name"]!=""){
      $pdf->Cell(120,5,"Customer Name:  ".$data["company_name"],"",1,'L');
      $pdf->Cell(120,5,"Customer No.: ".$data["cno"],"",1,'L');
    }else{
      $pdf->Cell(120,5,"Data not present","",1,'L');
      $pdf->Cell(120,5,"Data not present","",1,'L');
    }
    $pdf->Cell(120,5,"Your Reference No.: ".$data["ref_no"]."  DTD. ".$data["ref_date"],"",1,'L');
    $pdf->Cell(120,5,"Igm Project No.: ".$data["projectno"],"",1,'L');

    $pdf->Cell(120,8,"We hereby sent the following goods to you as per our general terms and conditions","",1,'L');

    $pdf->setFont("Arial","B",8);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFillColor(251,49,40);
    $pdf->SetDrawColor(255,255,255);
    $pdf->Cell(5,8,"No.",1,0,'C',true);
    $pdf->Cell(20,8,"Part no.",1,0,'C',true);
    $pdf->Cell(8,8,"Qty.",1,0,'C',true);
    $pdf->Cell(90,8,"Description of goods",1,0,'C',true);
    $pdf->Cell(40,8,"Serial Nos.",1,0,'C',true);
    $pdf->Cell(30,8,"Amount",1,1,'C',true);

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFillColor(217,217,217);
    $pdf->SetDrawColor(255,255,255);
    $challanTotal = 0;   
    $pdf->SetWidths(array(5,20,8,90,40,30));
    $i=1;
    //$dcparticulars[]
    //ip.part_number,ip.description,dcp.serials,dcp.qty,dcp.unitprice,dcp.partTotAmount
    if (sizeof($dcparticulars)>0) {
      foreach ($dcparticulars as $key=>$particular){
        if ($pdf->GetY() == 255.00125||$pdf->GetY() == 250.00125){
          $pdf->Cell(5,8,"No.",1,0,'C');
          $pdf->Cell(20,8,"Part No.",1,0,'C');
          $pdf->Cell(8,8,"Qty.",1,0,'C');
          $pdf->Cell(90,8,"Description of goods",1,0,'C');
          $pdf->Cell(40,8,"Serial Nos.",1,0,'C',true);
          $pdf->Cell(30,8,"",1,1,'C',true);
        }
        //var_dump($value);
        /*if(sizeof(explode("-", explode(",", $dcparticulars['serials'])))>0){
          $pdf->Row(array($i,$particular['part_number'],$particular['qty'],$particular['description'],
            $particular['serials'],$particular['partTotAmount']));
        }else{
          if(explode("-", explode(",", $value['serials'])[0])[1]==""){
            $pdf->Row(array($i,$particular['part_number'],$particular['qty'],$particular['description'],
              "Consumable Parts",$particular['partTotAmount']));      
          }else{
            $pdf->Row(array($i,$particular['part_number'],$particular['qty'],$particular['description'],
              $particular['serials'],$particular['partTotAmount']));
          }
        }*/
        $pdf->Row(array($i,$particular['part_number'],$particular['qty'],$particular['description'],
              $particular['serials'],$particular['partTotAmount']));
        $challanTotal += $particular['partTotAmount'];
        $i+=1;
      }
    }    

    $pdf->Cell(193,8,"===================================================================================",1,1,'C',true);

    $pdf->setFont("Arial","B",8);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFillColor(217,217,217);
    $pdf->SetDrawColor(255,255,255);
    $pdf->Cell(5,8,"",1,0,'C',true);
    $pdf->Cell(20,8,"",1,0,'C',true);
    $pdf->Cell(8,8,"",1,0,'C',true);
    $pdf->Cell(90,8,"",1,0,'C',true);
    //$pdf->Cell(80,8,"",1,0,'C',true);
    $pdf->Cell(40,8,"Total Amount",1,0,'C',true);
    $pdf->Cell(30,8,number_format($challanTotal,2,".",","),1,1,'C',true);

    $pdf->Cell(190,5,"",1,1,"L");
    $y=$pdf->GetY();
    if($y>=246.00125){
      $pdf->AddPage();
    }
    
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(190,5,"DELIVERY TERMS AS PER INCOTERMS 2010:",1,1,"L");
    
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(5,5,chr(149),1,0,"L");
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);

    $pdf->Cell(190,5,"  CIF / DAP / DDP / EXW Place",1,1,"L");

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(190,5,"DISPATCH DETAILS:",1,1,"L");

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(5,5,chr(149),1,0,"L");
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);
    $pdf->Cell(190,5," Mode of transport: ".$data["transport"],1,1,"L");
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(5,5,chr(149),1,0,"L");
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);
    $pdf->Cell(190,5," Sent by ".$data["courier"]." courier service",1,1,"L");
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(5,5,chr(149),1,0,"L");
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);
    $pdf->Cell(190,5," Courier dispatch no. ".$data["dispatchno"],1,1,"L");

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(190,5,"TERMS AND CONDITION:",0,1,"L");
    
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(5,5,chr(149),0,0,"L");
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);

    
    if($data["challanType"]=="returnable"||$data["challanType"]=="nonreturnable"){
      $pdf->Cell(190,5,"On ".$data["challanType"]." Basis.\n".$data["terms"],0,1,"L");
    }else{
      $pdf->Cell(190,5,$data["terms"],0,1,"L");
    }

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(190,5,"NOTE ON RECEIPT OF THE GOODS",1,1,"L");
    
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(5,5,chr(149),1,0,"L");
    $pdf->setFont("Arial","",9);
    $pdf->SetTextColor(38,38,38);    
    $pdf->MultiCell(190,5," The receiver of the goods in this consignment has to check the package for damages immediately after receipt of \nthe goods.",1,"L",0);
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(5,5,chr(149),1,0,"L");
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);
    $pdf->MultiCell(190,5," Any claims on transportation damages must be reported to igm Roboticsystems India Pvt. Ltd. per e-mail within \n24h after receipt of the goods.",1,"L",0);

    
    
    $pdf->Cell(190,5,"Thank you",1,1,"L");
    $pdf->Cell(190,5,"With warm regards,",1,1,"L");    
    $pdf->Cell(190,5,"igm Roboticsystems India Pvt. Ltd.",1,1,"L");
    
    echo $pdf->Output();
      
  }

  function generatePDF1($to, $partsNo, $dc, $copy){    
    $pdf = new PO();    
    $pdf->setFont("Arial","B",9);
    $pdf->SetTextColor(0,0,0);
    $pdf->addPage();    
    $pdf->text(126, 20, $copy);

    $pdf->AliasNbPages();
    
    $pdf->SetAutoPageBreak(true,25);
            
    $st = $pdf->GetY();
    $pdf->setFont("Arial","",8);
    $pdf->Cell(110,5,"To,","",0,'L');
    $pdf->setFont("Arial","",8);    
    $pdf->Cell(80,5,"igm Roboticsystems India Pvt. Ltd.","",1,'L');
    $pdf->setFont("Arial","",8);

    if(sizeof($to)>0){
      $pdf->Cell(110,5,$to[0]["company"],"",1,'L');
    }else{
      $pdf->Cell(110,5,"Data not present","",1,'L');
    }
    if(sizeof($to)>0){
      $pdf->Cell(110,5,"Attn.: ".$to[0]["person1"],"",0,'L');
    }else{
      $pdf->Cell(110,5,"Data not present","",0,'L');
    }
    $pdf->setFont("Arial","",8);
    $pdf->Cell(80,5,"Contact:  Sarika Dive","",1,'L');
    $pdf->setFont("Arial","",8);
    if(sizeof($to)>0){
      $pdf->Cell(110,5,$to[0]["addressline1"].",","",0,'L');
    }else{
      $pdf->Cell(110,5,"Data not present".",","",0,'L');
    }
    $pdf->setFont("Arial","",8);
    $pdf->Cell(80,5,"Mobile: +91 7738155709","",1,'L');
    $pdf->setFont("Arial","",8);
    if(sizeof($to)>0){
      $pdf->Cell(110,5,$to[0]["addressline2"].",","",0,'L');
    }else{
      $pdf->Cell(110,5,"Data not present".",","",0,'L');
    }
    $pdf->setFont("Arial","",8);
    $pdf->Cell(80,5,"E-mail: sarika.dive@igm-india.com","",1,'L');
    $pdf->setFont("Arial","",8);
    if(sizeof($to)>0){
      $pdf->Cell(110,5,$to[0]["city"].",","",1,'L');
    }else{
      $pdf->Cell(110,5,"Data not present","",1,'L');
    }
    $pdf->setFont("Arial","",8);
    if(sizeof($to)>0){
      $pdf->Cell(110,5,$to[0]["country"].".","",0,'L');
    }else{
      $pdf->Cell(110,5,"Data not present","",0,'L');
    }
    $pdf->setFont("Arial","",8);
    $date=new DateTime();
    $pdf->Cell(80,5,"Date: ".$date->format("d/M/Y"),"",1,'L');

    $pdf->setFont("Arial","B",8);
    $pdf->SetTextColor(251,49,40);     

    $pdf->Cell(40,8,"DELIVERY CHALLAN","",0,'L');
    $pdf->Cell(60,8,"No. DC-".$dc[0]["chno"],"",1,'L');

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38); 
    
    
    $refDate = new DateTime($dc[0]["refdate"]);
    $refDateFormated = $refDate->format('d/M/Y');
    if(sizeof($to)>0){
      $pdf->Cell(120,5,"Customer Name:  ".$to[0]["company"],"",1,'L');
      $pdf->Cell(120,5,"Customer No.: ".$to[0]["cno"],"",1,'L');
    }else{
      $pdf->Cell(120,5,"Data not present","",1,'L');
      $pdf->Cell(120,5,"Data not present","",1,'L');
    }
    $pdf->Cell(120,5,"Your Reference No.: ".$dc[0]["refno"]."  DTD. ".$refDateFormated,"",1,'L');
    $pdf->Cell(120,5,"Igm Project No.: ".$dc[0]["projectno"],"",1,'L');

    $pdf->Cell(120,8,"We hereby sent the following goods to you as per our general terms and conditions","",1,'L');

    $pdf->setFont("Arial","B",8);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFillColor(251,49,40);
    $pdf->SetDrawColor(255,255,255);
    $pdf->Cell(5,8,"No.",1,0,'C',true);
    $pdf->Cell(20,8,"Part no.",1,0,'C',true);
    $pdf->Cell(8,8,"Qty.",1,0,'C',true);
    //$pdf->Cell(20,8,"Unit Price",1,0,'C',true);
    $pdf->Cell(110,8,"Description of goods",1,0,'C',true);
    $pdf->Cell(40,8,"Serial Nos.",1,0,'C',true);
    $pdf->Cell(10,8,"Amount",1,1,'C',true);

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFillColor(217,217,217);
    $pdf->SetDrawColor(255,255,255);
    $countTab = 1; 
    $challanTotal = 0;   
    $pdf->SetWidths(array(5,20,8,110,40,10));
    $i=1;
    if (sizeof($dc[0]['chParts'])>0) {
      foreach ($dc[0]['chParts'] as $key=>$value){
        if ($pdf->GetY() == 255.00125||$pdf->GetY() == 250.00125){
          $pdf->Cell(5,8,"No.",1,0,'C');
          $pdf->Cell(20,8,"Part No.",1,0,'C');
          $pdf->Cell(8,8,"Qty.",1,0,'C');
          //$pdf->Cell(20,8,"Unit Price",1,0,'C');
          $pdf->Cell(110,8,"Description of goods",1,0,'C');
          $pdf->Cell(40,8,"Serial Nos.",1,0,'C',true);
          $pdf->Cell(10,8,"",1,1,'C',true);
        }
        //var_dump($value);
        if(sizeof(explode("-", explode(",", $value['serials'])[0]))>0){
          $pdf->Row(array($i,$partsNo[$key]['part'],$value['qty'],$partsNo[$key]['desc'],$value['serials'],$value['partTotAmount']));
        }else{
          if(explode("-", explode(",", $value['serials'])[0])[1]==""){
            $pdf->Row(array($i,$partsNo[$key]['part'],$value['qty'],$partsNo[$key]['desc'],"Consumable Parts",$value['partTotAmount']));      
          }else{
            $pdf->Row(array($i,$partsNo[$key]['part'],$value['qty'],$partsNo[$key]['desc'],$value['serials'],$value['partTotAmount']));
          }
        }
        $challanTotal += $value['partTotAmount'];//($value['partTotAmount']*$value['qty']);
        $i+=1;
      }
    }    

    $pdf->Cell(193,8,"===================================================================================",1,1,'C',true);

    $pdf->setFont("Arial","B",8);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFillColor(217,217,217);
    $pdf->SetDrawColor(255,255,255);
    $pdf->Cell(5,8,"",1,0,'C',true);
    $pdf->Cell(20,8,"",1,0,'C',true);
    $pdf->Cell(8,8,"",1,0,'C',true);
    $pdf->Cell(110,8,"",1,0,'C',true);
    //$pdf->Cell(80,8,"",1,0,'C',true);
    $pdf->Cell(40,8,"Total Amount",1,0,'C',true);
    $pdf->Cell(10,8,number_format($challanTotal,2,".",","),1,1,'C',true);

    $pdf->Cell(190,5,"",1,1,"L");
    $y=$pdf->GetY();
    if($y>=246.00125){
      $pdf->AddPage();
    }
    
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(190,5,"DELIVERY TERMS AS PER INCOTERMS 2010:",1,1,"L");
    
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(5,5,chr(149),1,0,"L");
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);

    $pdf->Cell(190,5,"  CIF / DAP / DDP / EXW Place",1,1,"L");

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(190,5,"DISPATCH DETAILS:",1,1,"L");
    
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(5,5,chr(149),1,0,"L");
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);
    $pdf->Cell(190,5," Mode of transport: ".$dc[0]["mode"],1,1,"L");
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(5,5,chr(149),1,0,"L");
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);
    $pdf->Cell(190,5," Sent by ".$dc[0]["courier"]." courier service",1,1,"L");
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(5,5,chr(149),1,0,"L");
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);
    $pdf->Cell(190,5," Courier dispatch no. ".$dc[0]["dispatchno"],1,1,"L");

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(190,5,"TERMS AND CONDITION:",0,1,"L");
    
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(5,5,chr(149),0,0,"L");
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);

    $returnable = "Non Returnable";
    if($dc[0]["returnable"]==1){
      $returnable = "Returnable";
    }
    $pdf->Cell(190,5,"On ".$returnable." Basis.\n".$dc[0]["terms"],0,1,"L");

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(190,5,"NOTE ON RECEIPT OF THE GOODS",1,1,"L");
    
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(5,5,chr(149),1,0,"L");
    $pdf->setFont("Arial","",9);
    $pdf->SetTextColor(38,38,38);    
    $pdf->MultiCell(190,5," The receiver of the goods in this consignment has to check the package for damages immediately after receipt of \nthe goods.",1,"L",0);
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(5,5,chr(149),1,0,"L");
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);
    $pdf->MultiCell(190,5," Any claims on transportation damages must be reported to igm Roboticsystems India Pvt. Ltd. per e-mail within \n24h after receipt of the goods.",1,"L",0);

    
    
    $pdf->Cell(190,5,"Thank you",1,1,"L");
    $pdf->Cell(190,5,"With warm regards,",1,1,"L");    
    $pdf->Cell(190,5,"igm Roboticsystems India Pvt. Ltd.",1,1,"L");
    
    echo $pdf->Output();
  }

    function getCustomerForDC($connection, $params){
      $query="SELECT id,company_name, city  FROM customers WHERE company_name LIKE '%".$params["term"]["term"]."%'";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){                    
          $data[] = array('id'=>$row['id'],'company'=>$row['company_name']."-".$row['city']);
        }
      }      
      echo json_encode($data);
    }
    
    function getParticularDC($connection,$params){
		$data=[];
		$challanType = $params["challanType"];
        $query ="";
        if($challanType=="returnable"){
          $query = "SELECT i.part_id, i.part_number, ip.description, COUNT(i.id) as available, 
          ip.unit_price_inr, ip.location,ip.country  
          FROM
          inventory i LEFT JOIN inventory_parts ip on i.part_id=ip.id 
          WHERE ip.part_number LIKE '".$params['term']['term']."%' AND ip.location!='HPR-1' AND i.used=0 group by i.part_id";
        }else{
          $query = "SELECT i.part_id, i.part_number, ip.description, COUNT(i.id) as available, 
          ip.unit_price_inr, ip.location,ip.country  
          FROM
          inventory i LEFT JOIN inventory_parts ip on i.part_id=ip.id 
          WHERE ip.part_number LIKE '".$params['term']['term']."%' AND ip.location='HPR-1' AND  i.used=0 group by i.part_id";
        }
        $result = mysqli_query($connection,$query);
        if($result->num_rows>0){          
          while($row = $result->fetch_assoc()){
            $desc = iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']);
				$data[] = array('id'=>$row['part_id'],'partnumber'=>$row['part_number'],'description'=>$desc,'country'=>$row['country'],'available'=>$row['available'],
				'location'=>$row['location']);
          }
        }
		echo json_encode($data);
	}

    function addDC($connection, $params){ 
      $q = "INSERT INTO
      deliverychallan
      (projectno, cust_id, challan_no, date, closing_status, invoice, challanType, returnable, ref_no, ref_date, shipment_date, transport,
        vehicle, courier, dispatchno, lr_no, freight, terms, created_by, created_on, modified_by, modified_on)
      VALUES (?,?,?,?,0,0,?,?,?,?,?,?,?,?,?,?,?,?,?,(SELECT NOW()),?,(SELECT NOW()))";
      $stmt = $connection->prepare($q);
      $stmt->bind_param("sisssissssssssisss", $projectno, $cust_id, $challan_no, $date, $challanType, $returnable, $ref_no, $ref_date, $shipment_date, $transport, $vehicle,
            $courier, $dispatchno, $lr_no, $freight, $terms, $cb, $mb);
      $projectno = $params["projectno"];
      $cust_id = $params["customer"];
      $challan_no = $params["challannumber"];
      $date = date_format(new DateTime($params["issuedate"]),"Y-m-d H:i:s");
      $challanType = $params["challanType"];
      $returnable = ($params["challanType"]=="returnable")?1:0;
      $ref_no = $params["referencenumber"];
      $ref_date = date_format(new DateTime($params["refdate"]),"Y-m-d H:i:s");
      $shipment_date = date_format(new DateTime($params["shipdate"]),"Y-m-d H:i:s");
      $transport = $params["mode"];
      $vehicle = $params["vehicle"];
      $courier = $params["courier"];
      $dispatchno = $params["dispatchno"];
      $lr_no = $params["lr"];
      $freight = $params["freight"];
      $terms = $params["terms"];
      $cb = $mb = $_COOKIE["usermail"];      
      if($stmt->execute()){
        $dcId=$connection->insert_id;
        if(addDCProducts($connection, $dcId, $params) && updateStocks($connection, $dcId, $params)){
          return  true;
        }
      }else{
        error_log(date("Y-m-d h:m:s")." ERROR when adding DC.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
        return false;
      }
    }

    function addDCProducts($connection, $dcId, $params){
        $success = false;
        $index = explode(',',$params["ids"]);
        if($params["challanType"]=="nontraceable"){
            foreach ($index as $value){
                $q = "INSERT INTO nontraceabledcparts
                (dcId, part_no, description, unitprice, qty, serial, amount)
                VALUES (?,?,?,?,?,?,?)";
                $stmt = $connection->prepare($q);
                $stmt->bind_param("issdisd", $dcId, $part_no, $description, $unitprice, $qty, $serial, $amount);
                $dcId = $dcId;
                $part_no = $params["partno".$value];
                $description = $params["description".$value];
                $unitprice = $params["unitprice".$value];
                $qty = $params["quantity".$value];
                $serial = $params["serial".$value];
                $amount = $params["amount".$value];
                if($stmt->execute()){
                  $success = true;
                }else{
                  error_log(date("Y-m-d h:m:s")." ERROR when adding nontraceable DC Parts.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
                  $success = false;
                } 
            }
        }else{
            foreach ($index as $value){
                $q = "INSERT INTO dc_products
                (dcId, inward_no, partId, serials, qty, part_dis, unitprice, landed_cost, selling_price, partTotAmount)
                VALUES (?,0,?,?,?,0,?,0,0,?)";
                $stmt = $connection->prepare($q);
                $stmt->bind_param("iisidd", $dcId, $partId, $serials, $qty, $unitprice, $partTotAmount);
                $dcId = $dcId;
                $partId = $params["partId".$value];
                $serials = $params["serial".$value];
                $qty = $params["quantity".$value];
                $unitprice = $params["unitprice".$value];
                $partTotAmount = $params["amount".$value];
                if($stmt->execute()){
                  $success = true;
                }else{
                  error_log(date("Y-m-d h:m:s")." ERROR when adding DC Parts.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
                  $success = false;
                }
            }
        }
        if($success){
            return true;
        }else{
            return false;
        }
    }

    function updateStocks($connection, $dcId, $params){
        $success=false;
        
        $returnable = ($params["challanType"]=="returnable")? 1:0;
        $challanNo = $params["challannumber"];
        $challanDate = $params["issuedate"];
        
        $particulars = explode(",",$params["ids"]);
        
        foreach($particulars as $particular){
            if($params["quantity".$particular]>1){
                $pNo = explode("*", $params["partno".$particular])[1];
                if($params["serial".$particular]!=""){
                    $serials = explode(",",$params["serial".$particular]);
                    $qtyInd=0;
                    while($qtyInd < $params["quantity".$particular]){
                        $q = "UPDATE inventory SET serial_number=?, used=1, ch_no=?, ch_date=?, returnable=?, modified_by=?, modified_on=(SELECT NOW()) 
                            WHERE part_id=? AND part_number=? AND used=0 LIMIT 1";
                        $stmt = $connection->prepare($q);
                        $stmt->bind_param("sssisis", $serial_number, $ch_no, $ch_date, $returnable, $mb, $part_id, $part_number);
                        $serial_number = $serials[$qtyInd];
                        $ch_no = $challanNo;
                        $ch_date = $challanDate;
                        $returnable = $returnable;
                        $mb = $_COOKIE["usermail"];
                        $part_id = $params["partId".$particular];
                        $part_number = $pNo;         
                        if($stmt->execute()){          
                            $success = true;          
                        }else{
                            error_log(date("Y-m-d h:m:s")." ERROR when updating stock.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
                            $success =  false;
                        }
                        $qtyInd+=1;
                    }
                }else{
                   $qtyInd=0;
                    while($qtyInd < $params["quantity".$particular]){
                        $q = "UPDATE inventory SET serial_number=?, used=1, ch_no=?, ch_date=?, returnable=?, modified_by=?, modified_on=(SELECT NOW()) 
                            WHERE part_id=? AND part_number=? AND used=0 LIMIT 1";
                        $stmt = $connection->prepare($q);
                        $stmt->bind_param("sssisis", $serial_number, $ch_no, $ch_date, $returnable, $mb, $part_id, $part_number);
                        $serial_number = "";
                        $ch_no = $challanNo;
                        $ch_date = $challanDate;
                        $returnable = $returnable;
                        $mb = $_COOKIE["usermail"];
                        $part_id = $params["partId".$particular];
                        $part_number = $params["partno".$particular];         
                        if($stmt->execute()){          
                            $success = true;          
                        }else{
                            error_log(date("Y-m-d h:m:s")." ERROR when updating stock.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
                            $success =  false;
                        }
                        $qtyInd+=1;
                    } 
                } 
            }else{
                $pNo = explode("*", $params["partno".$particular])[1];
                $q = "UPDATE inventory SET serial_number=?, used=1 , ch_no=?, ch_date=?, returnable=?, modified_by=?, modified_on=(SELECT NOW()) 
                    WHERE part_id=? AND part_number=? AND used=0 LIMIT 1";
                $stmt = $connection->prepare($q);
                $stmt->bind_param("sssisis", $serial_number, $ch_no, $ch_date, $returnable, $mb, $part_id, $part_number);
                $serial_number = $params["serial".$particular];
                $ch_no = $challanNo;
                $ch_date = $challanDate;
                $returnable = $returnable;
                $mb = $_COOKIE["usermail"];
                $part_id = $params["partId".$particular];
                $part_number = $pNo;         
                if($stmt->execute()){          
                    $success = true;          
                }else{
                    error_log(date("Y-m-d h:m:s")." ERROR when updating stock.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
                    $success =  false;
                }
                
            }
        }
        
      if($success){
        return true;
      }else{
        error_log(date("Y-m-d h:m:s")." ERROR when updating stock.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
        return false;
      }      
    }

    function updateWithSerialNo($connection, $dcId,$serial, $id,$returnable){
      if($returnable=="returnable"){
        $r=1;
      }else{
        $r=0;
      }
      $q = "UPDATE inventory SET ch_no=?, used=1 , serial_number=? , returnable=$r  WHERE id=?";
      $stmt = $connection->prepare($q);
      $stmt->bind_param("isi", $dcId,$serial, $id);
      $dcId=$dcId;
      $serial = $serial;
      $id = $id;         
      if($stmt->execute()){          
        return true;          
      }else{
        error_log(date("Y-m-d h:m:s")." ERROR when updating stock.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
        return false;
      }
    }

    function updateWithoutSerialNo($connection, $dcId,$id,$returnable){
      if($returnable=="returnable"){
        $r=1;
      }else{
        $r=0;
      }
      $q = "UPDATE inventory SET ch_no=?,used=1, returnable=$r  WHERE id=?";
      $stmt = $connection->prepare($q);
      $stmt->bind_param("ii", $id); 
      $dcId=$dcId;     
      $id = $id;         
      if($stmt->execute()){          
        return true;          
      }else{
        error_log(date("Y-m-d h:m:s")." ERROR when updating stock.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
        return false;
      }
    }

    

    function getDCForStatus($connection,$param){
      $query="SELECT dcp.*, ip.part_number FROM dc_products dcp LEFT JOIN 
      inventory_parts ip on dcp.partId =ip.id WHERE dcp.dcId =".$param["id"];
      $result = $connection->query($query);
      $data = array();
      $count=0;
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[]=array('challanId'=>$row["dcId"],'partId'=>$row["partId"],'partNo' =>$row["part_number"],"serials"=>$row["serials"], "qty"=>$row["qty"]);
          $count+=1;
        }
      }
      echo json_encode(array("particularCount"=>$count,"info"=>$data));
    }

    function updateDCClosing($connection, $params){
        $q = "UPDATE deliverychallan SET closing_status=1 WHERE id=?";
        $stmt = $connection->prepare($q);
        $stmt->bind_param("i", $dcId);
        $dcId = $params["statusChId"];
        if($stmt->execute()){
            if(updateInventoryStock($connection, $params)){
                return true;
            }else{
                error_log(date("Y-m-d h:m:s")." ERROR updating Inventory Stock.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
                return false;
            }
        }else{
            error_log(date("Y-m-d h:m:s")." ERROR closing DC.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
            return false;
        }
    }

    function updateInventoryStock($connection, $params){
      $i = 0;
      $success=false;
      while($i<$params["count"]){
          if($params["statusChPartQty".$i]>1){
            $qty=0;
            while($qty<$params["statusChPartQty".$i]){
                if($params["statusChSerialNoOld".$i]!=""){
                    $serials = explode(",",$params["statusChSerialNoNew".$count]);
                    $q = "UPDATE inventory SET serial_number=?, used=0, returnable=0, modified_by=?, modified_on=(SELECT NOW()) WHERE part_id=? AND part_number=? LIMIT 1";
                    $stmt = $connection->prepare($q);
                    $stmt->bind_param("ssis", $serial, $mb, $partId, $partNo);
                    $serial = $serials[$qty];
                    $mb = $_COOKIE["usermail"];
                    $partId = $params["statusChPartId".$count];
                    $partNo = $params["statusChPartNo".$count];
                    if($stmt->execute()){
                        $success=true;        
                    }else{
                        $success=false;
                    }    
                }else{
                    $q = "UPDATE inventory SET used=0, returnable=0, modified_by=?, modified_on=(SELECT NOW()) WHERE part_id=? AND part_number=? LIMIT 1";
                    $stmt = $connection->prepare($q);
                    $stmt->bind_param("sis",  $mb, $partId, $partNo);
                    $mb = $_COOKIE["usermail"];
                    $partId = $params["statusChPartId".$count];
                    $partNo = $params["statusChPartNo".$count];
                    if($stmt->execute()){
                        $success= true;        
                    }else{
                        $success=false;
                    }
                }
                $qty+=1;
            }
          }else{
            $q = "UPDATE inventory SET serial_number=?, used=0, returnable=0, modified_by=?, modified_on=(SELECT NOW()) WHERE part_id=? AND part_number=? LIMIT 1";
            $stmt = $connection->prepare($q);
            $stmt->bind_param("sis", $serial, $mb, $partId, $partNo);
            $serial = $params["statusChSerialNoNew".$count];
            $mb = $_COOKIE["usermail"];
            $partId = $params["statusChPartId".$count];
            $partNo = $params["statusChPartNo".$count];
            if($stmt->execute()){
                $success= true;        
            }else{
                $success=false;
            }
          }
        $i+=1;
      }
      if($success){
        return true;  
      }else{
          return false;
      }
      
    }

    function updateChallanDetails($connection, $challanId){
      $q = "UPDATE deliverychallan SET closing_status=? WHERE id=?";
      $stmt = $connection->prepare($q);
      $stmt->bind_param("ii", $status, $challanId);
      $status=1;
      $challanId = $challanId;
      if($stmt->execute()){
        return true;        
      }else{
        echo $stmt->error;
        return false;
      }
    }

    function updateWarehouse($connection, $serialArray){      
      foreach ($serialArray as $key => $value) {
       $result = mysqli_query($connection,"SELECT * FROM inventory WHERE serial_number = '".$value."';");
        if($result->num_rows>0){          
          while($row = $result->fetch_assoc()){
            $result1 = mysqli_query($connection,"UPDATE inventory_parts SET total = IF(total>0, total-1, 0) WHERE part_number='".$row['part_number']."';");
            if($result1){           
              
            }
          }
        }
      }
    }   

    

    function updateConsumableInventory($connection, $chNo, $qty, $partno, $returnable){
      $result = mysqli_query($connection,"SELECT id FROM inventory WHERE part_number = '".$partno."' AND used=0 LIMIT ".$qty." ");
      if($result->num_rows>0){          
        while($row = $result->fetch_assoc()){          
          $q = <<<EOD
          UPDATE inventory SET ch_no=?,used=?,returnable=? WHERE id=?
EOD;
          $stmt = $connection->prepare($q);
          $stmt->bind_param("siis", $chNo, $used, $return, $row['id']);
          $chNo = $chNo;
          $used = 1;
          $partno = $partno;
          if($returnable == "no"){
            $return=0;
          }else{
            $return=1;
          }
          if($stmt->execute()){          
            $success = true;          
          }else{
            $success = false;
          }
        }
      }

      $result1 = mysqli_query($connection,"UPDATE inventory_parts SET total = IF(total>0 OR total-".$qty.">0, total-".$qty.", 0)  WHERE part_number='".$partno."';");
      if($result1){                   
        if($success){
          return true;
        }else{
          return false;
        }
      }       
    }

    function updateInventory($connection, $chNo, $serialArray,$returnable){
      $success = false;
      
      foreach ($serialArray as $key => $value) {
        
        $q = "UPDATE inventory SET ch_no=?,used=?,returnable=? WHERE id=?";
        $stmt = $connection->prepare($q);
        $stmt->bind_param("siii", $chNo, $used, $return, $id);
        $chNo = $chNo;
        $used = 1;
        $id = $value;
        if($returnable == "no"){
          $return=0;
        }else{
          $return=1;
        }
        if($stmt->execute()){          
          $success = true;          
        }else{
          $success = false;
        }
      }
      if($success){
        return true;
      }else{
        return false;
      }
    }    

    function getDCPart($connection, $dcPartId){
      $query="SELECT * FROM dc_products WHERE id = ".$dcPartId."";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = array("id"=>$row["id"],"dc"=>$row["dcId"], "inward_no"=>$row["inward_no"],"part"=>$row["partId"], "qty"=>$row["qty"],
            "part_dis"=>$row["part_dis"], "rate"=>$row["unitprice"], "amount"=>$row["partTotAmount"],"serials"=>$row["serials"]);
        }
      }
      echo json_encode($data);
    }

    function getPartNo($connection,$id){
      $query="SELECT part_number FROM inventory_parts WHERE id = ".$id."";
      $result = $connection->query($query);
      $data = "";
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data =$row["part_number"];
        }
      }
      return $data;
    } 


    function addDCPart($connection, $param){          
      $success = false;      
        $q = "INSERT
        INTO dc_products
        (dcId, inward_no, partId, serials, qty, part_dis, unitprice, landed_cost, selling_price, partTotAmount)
        VALUES
        (?,0,?,?,?,0,0,0,0,?)";
        $stmt = $connection->prepare($q);
        $stmt->bind_param("iisid", $dcId, $partId, $serials, $qty, $partTotAmount);
        $dcId = explode("-", $param['challanId'])[0];        
        $partId = explode("~", $param['part'])[0];
        $serials = $param['serial'];
        $qty = $param['qty'];                                
        $partTotAmount = $param['amount'];
        if($stmt->execute()){
          $success = true;          
        }else{
          $success = false;
        }

       
        $ids=[];
        $q = "SELECT * FROM inventory WHERE part_number='".explode("~", $param['part'])[1]."' AND used=0";
        $result = $connection->query($q);        
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){
            $ids[]=$row["id"];
          }
        }
        if($param["qty"]>1){
          $serials = explode(",", $param['serial']);
          $q = "UPDATE inventory set used=1, serial_number=?,ch_no=?, returnable=? WHERE id=?";
          $stmt = $connection->prepare($q);
          for($i=0;$i<$param["qty"];$i++){
            $serial = $serials[$i];
            $chno = explode("-", $param['challanId'])[1];
            $returnable = $_POST['returnableStatusNewPart'];
            $id = $ids[$i];  
            $stmt->bind_param("ssii", $serial, $chno, $returnable, $id);
            
            if($stmt->execute()){
              $success = true;          
            }else{
              $success = false;
            }  
          }
        }else{
          $q = "UPDATE inventory set used=1, serial_number=?,ch_no=?, returnable=? WHERE id=?";
          $stmt = $connection->prepare($q);
          $stmt->bind_param("ssii", $serial, $chno, $returnable, $id);
          $serial = $param['serial'];
          $chno = explode("-", $param['challanId'])[1];
          $returnable = $_POST['returnableStatusNewPart'];
          $id = $ids[0];
          if($stmt->execute()){
            $success = true;          
          }else{
            $success = false;
          }
        }
        return success;
    }

    function updateDCPart($connection, $part){
      $success = false;
      $serialNo="";
      if($part->getSerials()!=""){
        foreach ($part->getSerials() as  $serial) {
          $serialNo .= $serial.",";
          $q = "UPDATE inventory SET used=1 WHERE serial_number = ?";
          $stmt = $connection->prepare($q);
          $stmt->bind_param("s", $serial);
          $serial = $serial;      
          if($stmt->execute()){
            $success =  true;          
          }else{
            $success =  false;
          }                
        }
      }

      $q = "UPDATE dc_products SET
      serials=?, qty=?, part_dis=?, unitprice=?, landed_cost=?, selling_price=?, partTotAmount=?
      WHERE id = ?";
      $stmt = $connection->prepare($q);
      $stmt->bind_param("sidddddi", $serials, $qty, $partdiscount, $unitprice, $landedcost, $sellingcost, $partTotAmount,$id);      
      $serials = $serialNo;
      $qty = $part->getQty();
      $partdiscount = $part->getPartDis();
      $unitprice = $part->getUnitprice();
      $landedcost = $part->getLandedcost();
      $sellingcost = $part->getSellingprice();
      $partTotAmount = $part->getPartTotAmount();
      $id = $part->getId();
      if($stmt->execute()){
        $success =  true;          
      }else{
        $success =  false;
      }

      if($success){
        return true;
      }else{
          return false;
      }
    }

    

    function markAsUsed($connection, $returnable, $parts){
      $success=false;
      if($returnable=="no"){
        $r = 0;
      }else{
        $r = 1;
      }
       foreach ($parts as $key => $value){        
        $serials = $value->getSerials();        
        foreach ( $serials as $serial) {
          $q = "UPDATE inventory SET used=1, returnable=$r WHERE  id=?";
          $stmt = $connection->prepare($q);
          $stmt->bind_param("i", explode("-", $serial)[0]);          
          $serial=$serial;
          if($stmt->execute()){
            $success = true;
          }else{
            echo $stmt->error;
            $success = false;
          }
        }
      }
      if($success){
        return true;
      }else{
        return false;
      }
    }

    function updateStockQuantity($connection, $parts){
      $success=false;
      foreach ($parts as $key => $value){        
          $q = "UPDATE inventory_parts SET total=(total-?) WHERE  id=?";
          $stmt = $connection->prepare($q);
          $stmt->bind_param("ii", $qty,$id);          
          $qty=$value->getQty();
          $id = $value->getPartId();
          if($stmt->execute()){
            $success = true;
          }else{
            echo $stmt->error;
            $success = false;
          }        
      }
      if($success){
        return true;
      }else{
        return false;
      }
    }

    function getDCByNumber($connection, $chno){
      $query="SELECT * FROM deliverychallan WHERE challan_no = '".$chno."'";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = $row['id'];
        }
      }
      return $data[0];
    }

    function getDC($connection, $id){
      $query="SELECT * FROM deliverychallan WHERE id = ".$id."";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
           $query1="SELECT * FROM dc_products WHERE dcId =".$id;
           $result1 = $connection->query($query1);
           $challanParts = new ArrayObject();
           $ind=0;
           $data1 = array();
           if($result1->num_rows>0){
             while($row1=$result1->fetch_assoc()){
               $data1[] = array("dcId"=>$row1["dcId"], "partId"=>$row1["partId"],
                "inward_no"=>$row1["inward_no"],
                "qty"=>$row1["qty"],"unitprice"=>$row1["unitprice"],
                "landed_cost"=>$row1["landed_cost"],"selling_price"=>$row1["selling_price"],
                "part_dis"=>$row1["part_dis"],
                 "partTotAmount"=>$row1["partTotAmount"],"id"=>$row1["id"],"serials"=>$row1["serials"]);
             }
           }
           $data[] = array("to"=>$row["cust_id"], "chno"=>$row["challan_no"], "date"=>$row["date"],
            "refno"=>$row["ref_no"], "refdate"=>$row["ref_date"], "lrno"=>$row["lr_no"],
            "projectno"=>$row["projectno"],"courier"=>$row["courier"],
					  "dispatchno"=>$row["dispatchno"],
            "shipdate"=>$row["shipment_date"], "mode"=>$row["transport"], "vehno"=>$row["vehicle"],
            "freight"=>$row["freight"], "returnable"=>$row["returnable"], "terms"=>$row["terms"],
            "cb"=>$row["created_by"], "co"=>$row["created_on"], "mb"=>$row["modified_by"],
            "mo"=>$row["modified_on"],"id"=>$row["id"],"chParts"=>$data1);
        }
      }
      echo json_encode($data);
    }

    function getDCPrint($connection, $id){
      $query="SELECT * FROM deliverychallan WHERE id = ".$id."";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
           $query1="SELECT * FROM dc_products WHERE dcId =".$id;
           $result1 = $connection->query($query1);
           $challanParts = new ArrayObject();
           $ind=0;
           $data1 = array();
           if($result1->num_rows>0){
             while($row1=$result1->fetch_assoc()){
               $data1[] = array("dcId"=>$row1["dcId"], "partId"=>$row1["partId"],
                "inward_no"=>$row1["inward_no"],
                "qty"=>$row1["qty"],"unitprice"=>$row1["unitprice"],
                "landed_cost"=>$row1["landed_cost"],"selling_price"=>$row1["selling_price"],
                "serials"=>$row1["serials"],
                "part_dis"=>$row1["part_dis"], "partTotAmount"=>$row1["partTotAmount"],"id"=>$row1["id"]);
             }
           }
           $data[] = array("to"=>$row["cust_id"], "chno"=>$row["challan_no"], "date"=>$row["date"],
            "refno"=>$row["ref_no"], "refdate"=>$row["ref_date"], "lrno"=>$row["lr_no"],
            "projectno"=>$row["projectno"],"courier"=>$row["courier"],
					  "dispatchno"=>$row["dispatchno"],
            "shipdate"=>$row["shipment_date"], "mode"=>$row["transport"], "vehno"=>$row["vehicle"],
            "freight"=>$row["freight"], "returnable"=>$row["returnable"], "terms"=>$row["terms"],
            "cb"=>$row["created_by"], "co"=>$row["created_on"], "mb"=>$row["modified_by"],
            "mo"=>$row["modified_on"],"id"=>$row["id"],"chParts"=>$data1);
        }
      }
      return $data;
    }

    

    function getDCPrintByNo($connection, $id){
      $query="SELECT * FROM deliverychallan WHERE challan_no = '".$id."'";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
           $query1="SELECT * FROM dc_products WHERE dcId =".$row["id"];
           $result1 = $connection->query($query1);
           $challanParts = new ArrayObject();
           $ind=0;
           $data1 = array();
           if($result1->num_rows>0){
             while($row1=$result1->fetch_assoc()){
               $data1[] = array("dcId"=>$row1["dcId"], "partId"=>$row1["partId"], 
                "inward_no"=>$row1["inward_no"],
                "qty"=>$row1["qty"],"unitprice"=>$row1["unitprice"],
                "landed_cost"=>$row1["landed_cost"],"selling_price"=>$row1["selling_price"],
                "serials"=>$row1["serials"],
                "part_dis"=>$row1["part_dis"], "partTotAmount"=>$row1["partTotAmount"],"id"=>$row1["id"]);
             }
           }
           $data[] = array("to"=>$row["cust_id"], "chno"=>$row["challan_no"], "date"=>$row["date"],
            "refno"=>$row["ref_no"], "refdate"=>$row["ref_date"], "lrno"=>$row["lr_no"],
            "projectno"=>$row["projectno"],"courier"=>$row["courier"],
					  "dispatchno"=>$row["dispatchno"],
            "shipdate"=>$row["shipment_date"], "mode"=>$row["transport"], "vehno"=>$row["vehicle"],
            "freight"=>$row["freight"], "returnable"=>$row["returnable"], "terms"=>$row["terms"],
            "cb"=>$row["created_by"], "co"=>$row["created_on"], "mb"=>$row["modified_by"],
            "mo"=>$row["modified_on"],"id"=>$row["id"],"chParts"=>$data1);
        }
      }
      return $data;
    }

    function getCust($connection, $id){
      $query="SELECT * FROM customers WHERE id=".$id;
      $result = $connection->query($query);
          $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = array('id'=>$row['id'],'cno'=>$row["cno"],'company'=>$row['company_name'],
          'addressline1' => $row['addressline1'],'addressline2' => $row['addressline2'],'city' => $row['city']
          ,'country' => $row['country'],
          'person1'=>$row['contact_person1_name']);
        }
      }
      return $data;
    }

    function getPartsNo($connection, $partsIds){
      $partsNo = array();
      foreach ($partsIds as $key => $value) {
        $query="SELECT * FROM inventory_parts WHERE id=".$value['partId'];
        $result = $connection->query($query);
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){
            $partsNo[] =  array('part' => $row['part_number'], 'desc' => $row['description']);
          }
        }
      }
      return $partsNo;
    }

    
    
    function getAllDC($connection, $params){
      $query="select dc.id, dc.challan_no,  dc.ref_no, dc.challanType, 
      date_format(dc.ref_date, '%d-%m-%Y') as ref_date,
      date_format(dc.date, '%d-%m-%Y') as date, dc.closing_status,
      c.company_name,sum(dcp.partTotAmount) as totalAmt
      from deliverychallan dc left join dc_products dcp on dc.id=dcp.dcId
      left join customers c on dc.cust_id=c.id group by dc.id";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){          
          $data[] = $row;
        }
      }
      $totalRecords=count($data);
      $data = array();
      $query="select dc.id, dc.challan_no,  dc.ref_no,  
      date_format(dc.ref_date, '%d-%m-%Y') as ref_date,dc.challanType,
      date_format(dc.date, '%d-%m-%Y') as date, dc.closing_status,
      c.company_name,sum(dcp.partTotAmount) as totalAmt
      from deliverychallan dc left join dc_products dcp on dc.id=dcp.dcId
      left join customers c on dc.cust_id=c.id group by dc.id
      limit ".$params['start'].", ".$params["length"] ;
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){          
          $data[] = $row;
        }
      }
      $response = array("draw"=>$params["draw"],"iTotalRecords"=>$totalRecords,"iTotalDisplayRecords"=>$totalRecords,"aaData"=>$data);
      echo json_encode($response);
      
    }

    function editDC($connection, DeliveryChallan $dc){
      $q = "UPDATE deliverychallan SET cust_id=?, challan_no=?,invoice=?,projectno=?, date=?, 
      ref_no=?, ref_date=?, lr_no=?, shipment_date=?, transport=?, vehicle=?, courier=?, dispatchno=?,
      freight=?, returnable=?, terms=?, modified_by=?, modified_on=?
      WHERE id=?";
      $stmt = $connection->prepare($q);
      $stmt->bind_param("isissssssssssiisssi", $cust_id, $challan_no,$invoice,$projectno, $date, $ref_no, $ref_date, $lr_no, $shipment_date, $transport,
      $vehicle, $courier, $dispatchno, $freight, $returnable, $terms, $mb, $mo,$id);
      $cust_id = $dc->getTo();
      $challan_no = $dc->getDeliveryChallanNo();
      $invoice = $dc->getInvoice();
      $date = $dc->getIsDate();
      $projectno = $dc->getProjectNo();
      $courier = $dc->getCourier();
      $dispatchno = $dc->getDispatchno();
      $ref_no = $dc->getRefno();
      $ref_date = $dc->getRefDate();
      $lr_no = $dc->getLrno();
      $shipment_date = $dc->getShipDate();
      $transport = $dc->getTransport();
      $vehicle = $dc->getVehicleNo();
      if($dc->getFreight()=="no"){
        $freight = 0;
      }else{
        $freight = 1;
      }
      if($dc->getReturnable()=="no"){
        $returnable = 0;
      }else{
        $returnable = 1;
      }
      $terms = $dc->getTerms();
      $mb = $dc->getMb();
      $mo = $dc->getMo();
      $id = $dc->getId();
      if($stmt->execute()){
        return true;        
      }else{
        return false;
      }
    }

    function deleteDC($connection, $id){
      $query="select challan_no from deliverychallan WHERE id=".$id;
      $result = $connection->query($query);
      $chNo="";
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){          
          $chNo = $row["challan_no"];
        }
      }  
      $query="DELETE FROM deliverychallan WHERE id = ?";
      $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $id);
        $id = $id;
        if($stmt->execute()){
          if(deleteDCParts($connection, $id) && updateAfterDelete($connection, $chNo)){
            return true;
          }
        }else{
            error_log(date("Y-m-d h:m:s")." ERROR deleting DC.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
            return false;
        }
    }

    function deleteDCPart($connection, $id){
      $query="DELETE FROM dc_products WHERE id = ?";
      $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $id);
        $id = $id;
        if($stmt->execute()){
          return true;
        }else{
          return false;
        }
    }

    function deleteDCParts($connection, $id){
      $query="DELETE FROM dc_products WHERE dcId = ?";
      $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $id);
        $id = $id;
        if($stmt->execute()){
          return true;
        }else{
            error_log(date("Y-m-d h:m:s")." ERROR deleting DC part.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
            return false;
        }
    }
    
    function updateAfterDelete($connection, $chNo){
        $query="UPDATE inventory SET serial_number='', used=0, ch_no='' ch_date='', returnable=0 WHERE ch_no=?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $chNo);
        $chNo = $chNo;
        if($stmt->execute()){
          return true;
        }else{
            error_log(date("Y-m-d h:m:s")." ERROR updating stock after dc delete.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
            return false;
        }
    }

    function getPreDC($connection){
      $query="SELECT MAX(id), challan_no FROM deliverychallan ";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = $row['challan_no'];
        }
      }
      echo $data[0];
    }

    function getCustomerById($connection, $id){
      $query="SELECT * FROM customers WHERE id=".$id."";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = array('id' => $row['id'],'cno'=>$row["cno"],'company' => $row['company_name'],
          'addressline1' => $row['addressline1'],'addressline2' => $row['addressline2'],'city' => $row['city']
          ,'country' => $row['country']);
        }
      }
      return $data;
    }

    function getDCSerial($connection,$ch){
      $query="SELECT * FROM inventory WHERE ch_no =".$ch."";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = array('id' => $row['id'],'part'=>$row["part_number"],'company' => $row['serial_number']);
        }
      }
      echo json_encode($data);
    }

    function getLastDC($connection){
      $query="select challan_no+1 as challan_no from deliverychallan order by id desc limit 1;";
      $result = $connection->query($query);
      $data = "";
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data = intval($row["challan_no"]);
        }
      }
      echo json_encode($data);
    }

    function getSerialByInward($connection,$inwardno,$partno){
      $query="SELECT * FROM inventory WHERE inward_no=$inwardno AND part_number='$partno' AND used=0";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = $row;;
        }
      }
      echo json_encode($data);
    }

    function getAllSerial($connection,$partno){      
      $query="SELECT * FROM inventory WHERE part_number='$partno' AND used=0";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = $row;;
        }
      }
      echo json_encode($data);
    }
?>
