<?php

  require('db.php');
  require_once("../phplibraries/fpdf.php");
class QuotePdf extends FPDF  {
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
            $this->Cell(10,8,"Pos.",1,0,'C',true);
            $this->Cell(20,8,"Part no.",1,0,'C',true);
            $this->Cell(10,8,"Qty.",1,0,'C',true);
            //$this->Cell(20,8,"Unit",1,0,'C',true);
            $this->Cell(60,8,"Description of Goods",1,0,'C',true);
            $this->Cell(30,8,"Unit Price INR",1,0,'C',true);
            $this->Cell(30,8,"Total Price INR",1,1,'C',true);
            $this->setFont("Arial","",9);
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
      $this->LN(35);*/
      $this->Image("../images/quotation_image.png",5,5, $this->getPageWidth()/2,15);
      $this->Ln(15);
    }

    function footer(){
      $this->SetY(-28);
      $this->SetTextColor(38,38,38);
      $this->SetDrawColor(255,0,0);
      $this->SetFont('Arial','',6.5);

      $this->Cell(90,5,'Page '.$this->PageNo()."/{nb}",0,0,'R');
      $this->Cell(90,5,' form ID: FOi-Q-04',0,1,'R');

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
      if(isset($_POST['generateQuot'])){ 
        //echo "<pre>";var_dump($_POST);echo "</pre>";
        if(addQuote($db->getConnection(), $_POST)){
          echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Added')
            window.location.href='../pages/quotation.php';
            </SCRIPT>");
        }else{
          echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Error generating')
            window.location.href='../pages/quotation.php';
            </SCRIPT>");
        }
      }

      else if(isset($_POST['editQuo'])){
        $quoId = $_POST["id"];
        $quot = new Quotation($_POST["id"],$_POST["quotationnumber"],$_POST["eprojectno"],$_POST["customer"],
        $_POST["refno"],$_POST["refdate"],
        $_POST["date"],$_POST["validdate"],
          $_POST["terms"],$_POST["sgst"],$_POST["cgst"],$_POST["igst"],$_POST["packaging"],$_POST["total"],$mb,$date->format('Y-m-d H:i:s'));
          //var_dump($quot);
        if(editQuote($db->getConnection(), $quot)){
          echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Edited')
            window.location.href='../pages/editQuot.php?type=quo&id=$quoId';
            </SCRIPT>");
        }else{
          echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Error Editing')
            window.location.href='../pages/editQuot.php?type=quo&id=$quoId';
            </SCRIPT>");
        }
      }

      else if(isset($_POST['getQuo'])){
        getQuote($db->getConnection(),$_POST["qoId"]);
      }

      else if(isset($_POST['getAllQuo'])){
        getAllQuote($db->getConnection(),$_POST);
      }

      else if(isset($_POST['deleteQuo'])){
        if(deleteQuote($db->getConnection(), $_POST["qId"])){
          echo "Deleted";
        }else{
          echo "Error Generating PO";
        }
      }

      else if(isset($_POST['addQuoPart'])){
         $quoId = $_POST["quoId"];
        if(addQuoteProduct($db->getConnection(), $_POST)){
          echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Part Added')
            window.location.href='../pages/editQuot.php?id=$quoId';
            </SCRIPT>");
        }else{
          echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Error Adding Part')
            window.location.href='../pages/editQuot.php?id=$quoId';
            </SCRIPT>");
        }
      }

      else if(isset($_POST['updateQuoPart'])){
        if(updateQuoteProduct($db->getConnection(), $_POST)){
            $id = $_POST["eQuotId"];
          echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Part Edited')
            window.location.href='../pages/editQuot.php?id=$id';
            </SCRIPT>");
        }else{
          echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Error Editing Part')
            window.location.href='../pages/editQuot.php?id=$quoId';
            </SCRIPT>");
        }
      }

      else if(isset($_POST['getQuoPart'])){
        getQuoPart($db->getConnection(), $_POST["quoPartId"]);
      }
      else if(isset($_POST['deleteQuoPart'])){
        if(deleteQuoPart($db->getConnection(), $_POST["partId"])){
          echo "Deleted";
        }else{
          echo "Err deleting prt";
        }
      }

      else if(isset($_POST["getPreQuoNo"])){
        getPreQuo($db->getConnection());
      }

      else if(isset($_POST["getLastQuote"])){
        getLastQuote($db->getConnection());
      }

      else if(isset($_POST["partsForQuoParticular"])){
        partsForQuoParticular($db->getConnection(),$_POST);
      }

      else if(isset($_POST["customersForQuo"])){
        customersForQuo($db->getConnection(),$_POST);
      }

    }else{
      $db = new DB();      
      if(isset($_GET["id"])){
        /*$quo = getQuotePrint($db->getConnection(), $_GET["id"]);
        $to = getCust($db->getConnection(),$quo[0]['to']);
        $partsNo = getPartsNo($db->getConnection(),$quo[0]['qoparts']);
        
        generatePDF($db->getConnection(),$to, $partsNo, $quo);*/
        generatePDF($db->getConnection(),$_GET);
      }
    }	

    function generatePDF($connection, $params){
      
      //Get Info
      $query="select q.id,q.quo_no,q.projectno,q.refno,q.igst,q.packaging,q.terms,
      date_format(q.refdate, '%d-%m-%Y') as refdate,
      date_format(q.validity, '%d-%m-%Y') as validity,    
      c.cno,c.company_name,c.addressline1,c.addressline2,c.city,c.country,c.contact_person1_name,
      ip.part_number,ip.description, qp.qty, qp.unitprice, qp.discount, qp.tax, qp.partTotAmt      
      from quotation q left join quo_products qp on q.id=qp.quoId
      left join customers c on q.cust_id=c.id
      left join inventory_parts ip on qp.partId=ip.id 
      WHERE q.id=".$params["id"];
      $result = $connection->query($query);
      $data = "";$qparticulars=[];
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){          
          $data = $row;
          $desc = iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']);
          $qparticulars[]=array("part_number"=>$row["part_number"],"description"=>$desc,
            "qty"=>$row["qty"],"unitprice"=>$row["unitprice"],"tax"=>$row["tax"],"discount"=>$row["discount"],
            "partTotAmt"=>$row["partTotAmt"]);
        }
      }

      //generate pdf
      $pdf = new QuotePdf();
      $pdf->setFont("arial","",9);
      $pdf->addPage();
      $pdf->AliasNbPages();
      $st = $pdf->GetY();
      $pdf->setFont("Arial","",8);
      $pdf->Cell(110,5,"To,","",0,'L');
      $pdf->setFont("Arial","",8);    
      $pdf->Cell(80,5,"igm Roboticsystems India Pvt. Ltd.","",1,'L');
      $pdf->setFont("Arial","",8);
      $pdf->Cell(110,5,$data["company_name"],"",1,'L');
      $pdf->Cell(110,5,"Attn.: ".$data["contact_person1_name"],"",0,'L');
      $pdf->setFont("Arial","",8);
      $pdf->Cell(80,5,"Contact:  Sarika Dive","",1,'L');
      $pdf->setFont("Arial","",8);
      $pdf->Cell(110,5,$data["addressline1"].",","",0,'L');
      $pdf->setFont("Arial","",8);
      $pdf->Cell(80,5,"Mobile: +91 7738155709","",1,'L');
      $pdf->setFont("Arial","",8);
      $pdf->Cell(110,5,$data["addressline2"].",","",0,'L');
      $pdf->setFont("Arial","",8);
      $pdf->Cell(80,5,"E-mail: sarika.dive@igm-india.com","",1,'L');
      $pdf->setFont("Arial","",8);
      $pdf->Cell(110,5,$data["city"].",","",1,'L');
      $pdf->setFont("Arial","",8);
      $pdf->Cell(110,5,$data["country"],"",0,'L');
      $pdf->setFont("Arial","",8);
      $date = new DateTime();
      $pdf->Cell(80,5,"Date: ".$date->format('d/M/Y'),"",1,'L');

      $pdf->setFont("Arial","B",8);
      $pdf->SetTextColor(251,49,40);     
      
      $pdf->Cell(25,15,"QUOTATION No.","",0,'L');
      $pdf->Cell(60,15," Q-".$data["quo_no"],"",1,'L');

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38); 

      $pdf->Cell(120,5,"Customer Name:  ".$data["company_name"],"",1,'L');
      $pdf->Cell(120,5,"Customer No.: ".$data["cno"],"",1,'L');      
      $pdf->Cell(120,5,"Your Reference No.: ".$data["refno"]." DTD. ".$data["refdate"],"",1,'L');
      $pdf->Cell(120,5,"Igm Project No.: ".$data["projectno"],"",1,'L');

      $pdf->MultiCell(190,5,"We thank you for your inquiry and we hereby offer to you the following goods and/or services as per our general\nterms and conditions.",0,'L',0);
      
      $pdf->SetTextColor(0,0,0);
      $pdf->SetFont('Arial','B',8);
      $pdf->SetFillColor(251,49,40);
      $pdf->SetDrawColor(255,255,255);
      $pdf->SetTextColor(255,255,255);
      $pdf->Cell(10,8,"Pos.",1,0,'C',true);
      $pdf->Cell(20,8,"Part no.",1,0,'C',true);
      $pdf->Cell(10,8,"Qty.",1,0,'C',true);
      $pdf->Cell(60,8,"Description of Goods",1,0,'C',true);
      $pdf->Cell(30,8,"Unit Price INR",1,0,'C',true);
      $pdf->Cell(30,8,"Total Price INR",1,1,'C',true);      
      $pdf->SetTextColor(0,0,0);
      $pdf->SetDrawColor(0,0,0);
      $amount = 0;
      $i=10;

      $pdf->setFont("Arial","",9);
      $pdf->SetTextColor(0,0,0);
      $pdf->SetFillColor(217,217,217);
      $pdf->SetDrawColor(255,255,255);
      $pdf->SetWidths(array(10,20,10,/*20,*/60,30,30));
      $i=1;      

      $subtotal=0;
      //ip.part_number,ip.description, qp.qty, qp.unitprice, qp.partTotAmt
      foreach ($qparticulars as $key=>$particular) {        
          $up = $particular['unitprice'] - ($particular['unitprice']*($particular['discount']/100));
          $up = $up+($up*($particular['tax']/100));
          $subtotal += $up*$particular['qty'];
          $pdf->Row(array($i,$particular['part_number'],$particular['qty'],$particular['description'],
            number_format($up,2,'.',','),number_format($particular['partTotAmt'],2,'.',',')));          
        //}
        $i+=1;

      }

      $pdf->Cell(160,8,"===================================================================================",1,1,'C',true);
      
      $pdf->Cell(10,8,"",1,0,'C',true);
      $pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(10,8,"",1,0,'C',true);
      //$pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(60,8,"Subtotal IN INR",1,0,'C',true);
      $pdf->Cell(30,8,"",1,0,'C',true);      
      $pdf->Cell(30,8,number_format($subtotal,2,".",","),1,1,'C',true);
      
      $gstAmount = $subtotal*($data['igst']/100);
      
      $pdf->Cell(10,8,"",1,0,'C',true);
      $pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(10,8,"",1,0,'C',true);
      //$pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(60,8,"Total GST in INR",1,0,'C',true);
      $pdf->Cell(30,8,"",1,0,'C',true);      
      $pdf->Cell(30,8,number_format($gstAmount,2,".",","),1,1,'C',true);

      $pdf->Cell(10,8,"",1,0,'C',true);
      $pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(10,8,"",1,0,'C',true);
      //$pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(60,8,"Packaging in INR",1,0,'C',true);
      $pdf->Cell(30,8,"",1,0,'C',true);
      $pdf->Cell(30,8,number_format($data['packaging'],2,".",","),1,1,'C',true);
      
      $pdf->Cell(10,8,"",1,0,'C',true);
      $pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(10,8,"",1,0,'C',true);
      //$pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(60,8,"Total amount in INR",1,0,'C',true);
      $pdf->Cell(30,8,"",1,0,'C',true);
      $pdf->Cell(30,8,number_format($subtotal+$gstAmount+$data['packaging'],2,".",","),1,1,'C',true);      

      $pdf->Cell(160,8,"===================================================================================",1,1,'C',true);
      $y=$pdf->GetY();


      $pdf->Cell(190,10,"",1,1,'C');
      if($y>="235.0125"){
        $pdf->AddPage();
      }

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);       
      $pdf->Cell(35,5,"THE PRICE IS VALID TILL: ",1,0,"L");


      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
      $pdf->Cell(90,5, $data["validity"],1,1,"L");

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(60,5,"TERMS AND CONDITIONS:",1,1,"L");

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
      $pdf->Cell(130,5,$data["terms"],1,1,"L");      
      
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);

            
      $pdf->Cell(190,5,"Thank you",1,1,"L");
      $pdf->Cell(190,5,"With warm regards,",1,1,"L");          
      $pdf->Cell(190,5,"igm Roboticsystems India Pvt. Ltd.",1,1,"L");      
      echo $pdf->Output();
    }

    function generatePDF1($connection,$to, $partsNo, $quo){  
      $pdf = new QuotePdf();
      $pdf->setFont("arial","",9);
      $pdf->addPage();
      $pdf->AliasNbPages();
      //var_dump($quo);
      $st = $pdf->GetY();
      $pdf->setFont("Arial","",8);
      $pdf->Cell(110,5,"To,","",0,'L');
      $pdf->setFont("Arial","",8);    
      $pdf->Cell(80,5,"igm Roboticsystems India Pvt. Ltd.","",1,'L');
      $pdf->setFont("Arial","",8);
      $pdf->Cell(110,5,$to[0]["company"],"",1,'L');
      $pdf->Cell(110,5,"Attn.: ".$to[0]["person1"],"",0,'L');
      $pdf->setFont("Arial","",8);
      $pdf->Cell(80,5,"Contact:  Sarika Dive","",1,'L');
      $pdf->setFont("Arial","",8);
      $pdf->Cell(110,5,$to[0]["addressline1"].",","",0,'L');
      $pdf->setFont("Arial","",8);
      $pdf->Cell(80,5,"Mobile: +91 7738155709","",1,'L');
      $pdf->setFont("Arial","",8);
      $pdf->Cell(110,5,$to[0]["addressline2"].",","",0,'L');
      $pdf->setFont("Arial","",8);
      $pdf->Cell(80,5,"E-mail: sarika.dive@igm-india.com","",1,'L');
      $pdf->setFont("Arial","",8);
      $pdf->Cell(110,5,$to[0]["city"].",","",1,'L');
      $pdf->setFont("Arial","",8);
      $pdf->Cell(110,5,$to[0]["country"],"",0,'L');
      $pdf->setFont("Arial","",8);
      $date = new DateTime();
      $pdf->Cell(80,5,"Date: ".$date->format('d/M/Y'),"",1,'L');

      $pdf->setFont("Arial","B",8);
      $pdf->SetTextColor(251,49,40);     

      $pdf->Cell(25,15,"QUOTATION No.","",0,'L');
      $pdf->Cell(60,15," Q-".$quo[0]["qno"],"",1,'L');

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38); 

      $pdf->Cell(120,5,"Customer Name:  ".$to[0]["company"],"",1,'L');
      $pdf->Cell(120,5,"Customer No.: ".$to[0]["cno"],"",1,'L');
      $d = explode(" ", $quo[0]["refdate"])[0];
      $pdf->Cell(120,5,"Your Reference No.: ".$quo[0]["refno"]." DTD. ".$d,"",1,'L');
      $pdf->Cell(120,5,"Igm Project No.: ".$quo[0]["projectno"],"",1,'L');

      $pdf->MultiCell(190,5,"We thank you for your inquiry and we hereby offer to you the following goods and/or services as per our general\nterms and conditions.",0,'L',0);
      
      $pdf->SetTextColor(0,0,0);
      $pdf->SetFont('Arial','B',8);
      $pdf->SetFillColor(251,49,40);
      $pdf->SetDrawColor(255,255,255);
      $pdf->SetTextColor(255,255,255);
      $pdf->Cell(10,8,"Pos.",1,0,'C',true);
      $pdf->Cell(20,8,"Part no.",1,0,'C',true);
      $pdf->Cell(10,8,"Qty.",1,0,'C',true);
      //$pdf->Cell(20,8,"Unit",1,0,'C',true);
      $pdf->Cell(60,8,"Description of Goods",1,0,'C',true);
      $pdf->Cell(30,8,"Unit Price INR",1,0,'C',true);
      $pdf->Cell(30,8,"Total Price INR",1,1,'C',true);      
      $pdf->SetTextColor(0,0,0);
      $pdf->SetDrawColor(0,0,0);
      $amount = 0;
      $i=10;

      $pdf->setFont("Arial","",9);
      $pdf->SetTextColor(0,0,0);
      $pdf->SetFillColor(217,217,217);
      $pdf->SetDrawColor(255,255,255);
      $pdf->SetWidths(array(10,20,10,/*20,*/60,30,30));
      $countTab = 1;      

      $subtotal=0;

      foreach ($quo[0]['qoparts'] as $key=>$value) {        
          $up = $value['selling_price'] - ($value['selling_price']*($value['discount']/100));
          $up = $up+($up*($value['tax']/100));
          $subtotal += $up*$value['qty'];
		  $partDet = getPartDetById($connection, $value['partId']);
          $pdf->Row(array($countTab,$partDet['partNo'],$value['qty'],/*$value['rate'],*/$partDet['desc'],number_format($up,2,'.',','),number_format($up*$value['qty'],2,'.',',')));          
        //}
        $countTab+=1;

      }

      $pdf->Cell(160,8,"===================================================================================",1,1,'C',true);

      $pdf->Cell(10,8,"",1,0,'C',true);
      $pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(10,8,"",1,0,'C',true);
      //$pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(60,8,"Subtotal IN INR",1,0,'C',true);
      $pdf->Cell(30,8,"",1,0,'C',true);
      $gst = $quo[0]['cgst']+$quo[0]['sgst']+$quo[0]['igst'];
      $gstper = $gst/100;
      $pdf->Cell(30,8,number_format($subtotal,2,".",","),1,1,'C',true);
      
      $gstAmount = $subtotal*(($quo[0]['cgst']+$quo[0]['sgst']+$quo[0]['igst'])/100);
      
      $pdf->Cell(10,8,"",1,0,'C',true);
      $pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(10,8,"",1,0,'C',true);
      //$pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(60,8,"Total GST in INR",1,0,'C',true);
      $pdf->Cell(30,8,"",1,0,'C',true);      
      $pdf->Cell(30,8,number_format($gstAmount,2,".",","),1,1,'C',true);

      $pdf->Cell(10,8,"",1,0,'C',true);
      $pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(10,8,"",1,0,'C',true);
      //$pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(60,8,"Packaging in INR",1,0,'C',true);
      $pdf->Cell(30,8,"",1,0,'C',true);
      $pdf->Cell(30,8,number_format($quo[0]['packaging'],2,".",","),1,1,'C',true);
      
      $pdf->Cell(10,8,"",1,0,'C',true);
      $pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(10,8,"",1,0,'C',true);
      //$pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(60,8,"Total amount in INR",1,0,'C',true);
      $pdf->Cell(30,8,"",1,0,'C',true);
      $pdf->Cell(30,8,number_format($subtotal+$gstAmount+$quo[0]['packaging'],2,".",","),1,1,'C',true);      

      $pdf->Cell(160,8,"===================================================================================",1,1,'C',true);
      $y=$pdf->GetY();


      $pdf->Cell(190,10,"",1,1,'C');
      if($y>="235.0125"){
        $pdf->AddPage();
      }

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);       
      $pdf->Cell(35,5,"THE PRICE IS VALID TILL: ",1,0,"L");


      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
      $pdf->Cell(90,5, date_format(date_create($quo[0]["validdate"]),"d-M-Y"),1,1,"L");

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(60,5,"TERMS AND CONDITIONS:",1,1,"L");

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
      $pdf->Cell(130,5,$quo[0]["terms"],1,1,"L");      
      
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);

            
      $pdf->Cell(190,5,"Thank you",1,1,"L");
      $pdf->Cell(190,5,"With warm regards,",1,1,"L");          
      $pdf->Cell(190,5,"igm Roboticsystems India Pvt. Ltd.",1,1,"L");      
      echo $pdf->Output();
    }

	function getPartDetById($connection, $id){		
		  $query="select * from inventory_parts WHERE id=".$id."";
        $result = $connection->query($query);
        $data = "";
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){          
            $data = array("partNo"=>$row['part_number'],"desc"=>$row['description']);
          }
        }
		return $data;
	 }

   function partsForQuoParticular($connection, $params){    
    $query="SELECT id,part_number,description,unit_price_euro,unit_price_inr, landed_cost FROM inventory_parts
    WHERE part_number LIKE '".$params['term']['term']."%' AND (unit_price_euro!=0 OR unit_price_inr!=0 OR landed_cost!=0)";      
    $result = $connection->query($query);
    //echo $query;
    $data = array();
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){       
        $desc = iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']);
        $data[] = array('id'=>$row['id'],'part_number'=>$row['part_number'],'description'=>$desc,
        "upe"=>$row["unit_price_euro"],"upi"=>$row["unit_price_inr"],"lc"=>$row["landed_cost"]);
      }
    }
    echo json_encode($data);
  }

  function customersForQuo($connection, $params){
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
    
		
	  
    function addQuote($connection, $params){
      //projectno,customer,quotationnumber,date,refno,refdate,validdate,igst,packaging,terms
      $q = "INSERT INTO
      quotation
      (quo_no, projectno, cust_id, refno, refdate, date, validity, terms, cgst, sgst,igst,	packaging, total,
        created_by, created_on, modified_by, modified_on)
      VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,(select NOW()),?,(select NOW()))";
      $stmt = $connection->prepare($q);
      $stmt->bind_param("ssisssssdddddss", $quo_no, $projectno, $cust_id, $refno, $refdate, $date, $validity, $terms,$cgst, $sgst,$igst,$packaging, $total, $cb, $mb);
      $quo_no = $params["quotationnumber"];
      $projectno = $params["projectno"];
      $cust_id = $params["customer"];
      $refno = $params["refno"];
      $refdate = date_format(new DateTime($params["refdate"]),"Y-m-d H:i:s");
      $date = date_format(new DateTime($params["date"]),"Y-m-d H:i:s");
      $validity = date_format(new DateTime($params["validdate"]),"Y-m-d H:i:s");
      $terms = $params["terms"];
      $cgst = $sgst = 0;
      $igst = $params["igst"];
      $packaging = $params["packaging"];
      $total = 0;//$qo->getTotalAmount();
      $cb = $mb = $_COOKIE["usermail"];
      if($stmt->execute()){
        $qId=$connection->insert_id;
        if(addQuoteProducts($connection, $qId, $params)){
          return true;
        }
      }else{
        error_log(date("Y-m-d h:m:s")."ERROR when adding Quo.\nMessage==> ".$stmt->error."\n",3,"../log/php_error.log");
        return false;
      }
    }

    function addQuoteProducts($connection, $qId, $params){      
      $success = false;
      //getId getQuoId getPartId getQty getUnitprice getDiscount getTax getPartTotAmt
      $index = explode(',',$params["ids"]);
      foreach ($index as $value){
        $q = "INSERT INTO quo_products
        (quoId, inward_no, partId, qty, unitprice, landed_cost, selling_price, discount, tax, partTotAmt)
        VALUES
        (?,0,?,?,?,0,0,?,?,?)";

        $stmt = $connection->prepare($q);
        $stmt->bind_param("iiidddd", $quoId, $partId, $qty, $unitprice, $discount, $tax, $partTotAmt);
        $quoId = $qId;
        $partId = $params["partId".$value];
        $qty = $params["quantity".$value];
        $unitprice = $params["unitprice".$value];
        $discount = $params["discount".$value];
        $tax = $params["tax".$value];
        $partTotAmt = $params["amount".$value];
        if($stmt->execute()){
          $success = true;
        }else{
          error_log(date("Y-m-d h:m:s")."ERROR when adding QuoParts.\nMessage==> ".$stmt->error."\n",3,"../log/php_error.log");
          $success = false;

        }
      }
      if($success){
        return true;
      }else{
        return false;
      }
    }

    function addQuoteProduct($connection, $params){
        //var_dump($params);
        
        $q = "INSERT INTO quo_products
        (quoId, inward_no, partId, qty, unitprice, landed_cost, selling_price, discount, tax, partTotAmt)
        VALUES (?,0,?,?,?,0.00,0.00,?,?,?)";
        $stmt = $connection->prepare($q);
        $stmt->bind_param("iiidddd", $quoId, $partId, $qty, $unitprice, $discount, $tax, $partTotAmt);
        $quoId= $params["quoId"];
        $partId= explode("*",$params["part"])[0];
        $qty= $params["qty"];
        $unitprice= $params["rate"];
        $discount= $params["discount"];
        $tax= $params["tax"];
        $partTotAmt= $params["amount"];
        if($stmt->execute()){
          return true;
        }else{
          error_log(date("Y-m-d h:m:s")."ERROR when adding Quo Part.\nMessage==> ".$stmt->error."\n",3,"../log/php_error.log");
          return false;
        }
    }        

    function updateQuoteProduct($connection, $params){      
      $q = "UPDATE quo_products SET qty=?, discount=?, tax=?, partTotAmt=? WHERE id=?";
      $stmt = $connection->prepare($q);
      $stmt->bind_param("idddi", $qty, $discount, $tax, $partTotAmt, $id);
      $qty=$params["eqty"];
      $discount=$params["ediscount"];
      $tax=$params["etax"];
      $partTotAmt=$params["eamount"];
      $id=$params["eid"];
      if($stmt->execute()){
        return true;           
      }else{
        error_log(date("Y-m-d h:m:s")."ERROR when updating QuoParts.\nMessage==> ".$stmt->error."\n",3,"../log/php_error.log");
        return false;
      }
    }

    function updateQuotePrice($connection,$id){
      $q = "UPDATE quotation SET total=? WHERE id=?";
      $stmt = $connection->prepare($q);
      $stmt->bind_param("di", $total, $id);        
      $total = getTotalAmount($connection, $id);
      $id = $id;
      if($stmt->execute()){
        return true;          
      }else{
        return false;
      }

    }

    function getTotalAmount($connection, $id){
      $partTot=0;
      $query="SELECT SUM(partTotAmt) as tot FROM quo_products WHERE quoId=$id";
      $result = $connection->query($query);
      $data = "";
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){          
          $partTot = $row['tot'];
        }
      }

      $gst=0;
      $packaging = 0;
      $query="SELECT *  FROM quotation WHERE id=$id";
      $result = $connection->query($query);
      $data = "";
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){          
          $packaging = $row['packaging'];
          $gst = ($row["cgst"]+$row["sgst"]+$row["igst"])/100;
        }
      }                    
      return ($partTot+($partTot*$gst))+$packaging;
    }

    function getQuoteByNumber($connection, $qono){
      $query="SELECT * FROM quotation WHERE quo_no = '".$qono."'";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = $row['id'];
        }
      }
      return $data[0];
    }

    function getQuoPart($connection, $id){
      $query1="SELECT * FROM quo_products WHERE id=".$id;
      $result1 = $connection->query($query1);
      $data1 = array();
      if($result1->num_rows>0){
        while($row=$result1->fetch_assoc()){
          $data1[] = array("id"=>$row["id"],"quoId"=>$row["quoId"], "partId"=>$row["partId"], "qty"=>$row["qty"],
            "inward_no"=>$row["inward_no"]."/".getInwardNo($connection, $row["inward_no"]),
            "landed_cost"=>$row["landed_cost"],"selling_price"=>$row["selling_price"],
            "rate"=>$row["unitprice"], "discount"=>$row["discount"], "tax"=>$row["tax"], "amount"=>$row["partTotAmt"]);
        }
      }
      echo json_encode($data1);
    }

    function getInwardNo($connection, $inward){
      $q = "SELECT * FROM duty WHERE duty_id = $inward";
      $result = $connection->query($q);
      $data = "";
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data = $row["inward_no"];
        }
      }
      return $data;
    } 

    function getQuote($connection, $id){
      $query="select q.id, q.quo_no, c.company_name as customer,
      DATE_FORMAT(q.date,'%d-%m-%Y') as date,
      DATE_FORMAT(q.validity,'%d-%m-%Y') as validity,
      DATE_FORMAT(q.refdate,'%d-%m-%Y') as refdate,
      q.projectno, q.refno, q.igst, q.packaging, q.total,q.terms,
      ip.part_number, ip.description, qp.id as particularId, qp.quoId, qp.qty, 
      qp.unitprice , qp.discount, qp.tax, qp.partTotAmt
      from quotation q 
      LEFT JOIN quo_products qp on q.id=qp.quoId
      LEFT JOIN inventory_parts ip on qp.partId=ip.id
      LEFT JOIN customers c on q.cust_id=c.id  WHERE q.id=".$id ;
      $result = $connection->query($query);
      $data = "";
      $particularDetails = [];
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data = array("id"=>$row["id"],"qno"=>$row["quo_no"],"projectno"=>$row["projectno"],
          "to"=>$row["customer"],"refno"=>$row["refno"],"refdate"=>$row["refdate"],
          "date"=>$row["date"],"validdate"=>$row["validity"],"terms"=>$row["terms"],
          "igst"=>$row["igst"],"packaging"=>$row["packaging"], "amount"=>$row["total"]);

          $particularDetails[]=array("particularId"=>$row["particularId"],"particularQuotId"=>$row["quoId"],
            "part_number"=>$row["part_number"], "description"=>$row["description"], 
            "unitprice"=>$row["unitprice"], "qty"=>$row["qty"],"discount"=>$row["discount"],
            "tax"=>$row["tax"], "partTotAmt"=>$row["partTotAmt"]);
        }
      }
      echo json_encode(array("quotation"=>$data,"particularDetails"=>$particularDetails));
    }

    function getQuotePrint($connection, $id){
      $query="SELECT * FROM quotation WHERE id = ".$id."";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $query1="SELECT * FROM quo_products WHERE quoId=".$row["id"];
          $result1 = $connection->query($query1);
          $data1 = array();
          if($result1->num_rows>0){
            while($row1=$result1->fetch_assoc()){
              $data1[] = array("id"=>$row1["id"],"quoId"=>$row1["quoId"], "partId"=>$row1["partId"], "qty"=>$row1["qty"],
                "inward_no"=>$row1["inward_no"],"landed_cost"=>$row1["landed_cost"],"selling_price"=>$row1["selling_price"],
                "rate"=>$row1["unitprice"], "discount"=>$row1["discount"], "tax"=>$row1["tax"], "amount"=>$row1["partTotAmt"]);
            }
          }
          //quo_no, cust_id, date, validity, terms, created_by, created_on, modified_by, modified_on,cgst, sgst, total
          $data[] = array("id"=>$row["id"],"qno"=>$row["quo_no"],"projectno"=>$row["projectno"],
          "to"=>$row["cust_id"],"refno"=>$row["refno"],"refdate"=>$row["refdate"],"qoparts"=>$data1,
          "date"=>$row["date"],"validdate"=>$row["validity"],"terms"=>$row["terms"],
          "sgst"=>$row["sgst"],"cgst"=>$row["cgst"],"igst"=>$row["igst"],"packaging"=>$row["packaging"],
          "amount"=>$row["total"],
          "cb"=>$row["created_by"],"co"=>$row["created_on"],"mb"=>$row["modified_by"],"mo"=>$row["modified_on"]);
        }
      }
      return $data;
    }

    function getQuotePrintByNo($connection, $id){
      $query="SELECT * FROM quotation WHERE quo_no = '".$id."'";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $query1="SELECT * FROM quo_products WHERE quoId=".$row["id"];
          $result1 = $connection->query($query1);
          $data1 = array();
          if($result1->num_rows>0){
            while($row1=$result1->fetch_assoc()){
              $data1[] = array("id"=>$row1["id"],"quoId"=>$row1["quoId"], "partId"=>$row1["partId"], "qty"=>$row1["qty"],
                "inward_no"=>$row1["inward_no"],"landed_cost"=>$row1["landed_cost"],"selling_price"=>$row1["selling_price"],
                "rate"=>$row1["unitprice"], "discount"=>$row1["discount"], "tax"=>$row1["tax"], "amount"=>$row1["partTotAmt"]);
            }
          }
          //quo_no, cust_id, date, validity, terms, created_by, created_on, modified_by, modified_on,cgst, sgst, total
          $data[] = array("id"=>$row["id"],"qno"=>$row["quo_no"],"projectno"=>$row["projectno"],
          "to"=>$row["cust_id"],"refno"=>$row["refno"],"refdate"=>$row["refdate"],"qoparts"=>$data1,
          "date"=>$row["date"],"validdate"=>$row["validity"],"terms"=>$row["terms"],
          "sgst"=>$row["sgst"],"cgst"=>$row["cgst"],"igst"=>$row["igst"],"packaging"=>$row["packaging"],
          "amount"=>$row["total"],
          "cb"=>$row["created_by"],"co"=>$row["created_on"],"mb"=>$row["modified_by"],"mo"=>$row["modified_on"]);
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
          $data[] = array('id'=>$row['id'],'cno'=>$row["cno"],'company'=>$row['company_name'],'addressline1' => $row['addressline1'],'addressline2' => $row['addressline2'],'city' => $row['city']
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
            $partsNo[] = array('part' => $row['part_number'],'desc' => $row['description'] );
          }
        }
      }
      return $partsNo;
    }

    function getAllQuote($connection,$params){      
      $query="select q.id, q.quo_no, c.company_name as customer,
      DATE_FORMAT(q.date,'%d-%m-%Y') as quotDate,
      DATE_FORMAT(q.validity,'%d-%m-%Y') as validity,
      TRUNCATE(((q.igst/100)*(sum(qp.partTotAmt)))+sum(qp.partTotAmt)+q.packaging,2) as totAmt
      from 
      quotation q left join quo_products qp on q.id=qp.quoId
      left join customers c on q.cust_id=c.id  group by qp.quoId 
      ";      
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){          
          $data[] = $row;
        }
      }
      $totalRecords=count($data);
      $data=[];
      $query="select q.id, q.quo_no, c.company_name as customer,
      DATE_FORMAT(q.date,'%d-%m-%Y') as quotDate,
      DATE_FORMAT(q.validity,'%d-%m-%Y') as validity,
      TRUNCATE(((q.igst/100)*(sum(qp.partTotAmt)))+sum(qp.partTotAmt)+q.packaging,2) as totAmt
      from 
      quotation q left join quo_products qp on q.id=qp.quoId
      left join customers c on q.cust_id=c.id  group by qp.quoId
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

    function editQuote($connection, Quotation $qo){        
      $q = "UPDATE
      quotation
      SET quo_no=?,projectno=?,cust_id=?, refno=?, refdate=?, date=?,validity=?,terms=?,modified_by=?,
      modified_on=?,cgst=?,igst=?,sgst=?,packaging=?,total=?
      WHERE id=?";

      $stmt = $connection->prepare($q);
      $stmt->bind_param("ssisssssssdddddi", $quo_no, $projectno, $cust_id,$refno, $refdate, $date, $validity, $terms, $mb, $mo,$cgst,$igst, $sgst,$packaging, $total, $id);
      $quo_no = $qo->getQuotationNo();
      $projectno=$qo->getProjectNo();
      $cust_id = $qo->getTo();
      $refno = $qo->getRefno();
      $refdate = $qo->getRefdate();
      $date = $qo->getDated();
      $validity = $qo->getValidityDate();        
      $terms = $qo->getTerms();
      $cgst = $qo->getCgst();
      $igst = $qo->getIgst();
      $sgst = $qo->getSgst();
      $packaging = $qo->getPackaging();
      $total = $qo->getTotalAmount();
      $mb = $qo->getMb();
      $mo = $qo->getMo();
      $id = $qo->getId();
      if($stmt->execute()){
        return true;          
      }else{
        return false;
      }
    }

    function deleteQuote($connection, $id){
    $query="DELETE FROM quotation WHERE id =?";
    $stmt = $connection->prepare($query);
      $stmt->bind_param("i", $id);
      $id = $id;
      if($stmt->execute()){
        deleteQuoParts($connection, $id);
        
      }else{
        return false;
      }
  }
  function deleteQuoPart($connection, $id){
    $query="DELETE FROM quo_products WHERE id = ?";
    $stmt = $connection->prepare($query);
      $stmt->bind_param("i", $id);
      $id = $id;
      if($stmt->execute()){
        return true;
      }else{
        return false;
      }
  }

  function deleteQuoParts($connection, $id){
    $query="DELETE FROM quo_products WHERE quoId = ?";
    $stmt = $connection->prepare($query);
      $stmt->bind_param("i", $id);
      $id = $id;
      if($stmt->execute()){
        return true;          
      }else{
        return false;
      }
  }

  function getPreQuo($connection){
    $query="SELECT MAX(id), quo_no FROM quotation ";
    $result = $connection->query($query);
    $data = array();
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
        $data[] = $row['quo_no'];
      }
    }
    echo $data[0];
  }

  function getLastQuote($connection){    
    $query="SELECT quo_no FROM quotation order by id desc limit 1";
    $result = $connection->query($query);
    $data = "";
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
        $data = $row['quo_no'];
      }
    }      
    echo $data;
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

?>
