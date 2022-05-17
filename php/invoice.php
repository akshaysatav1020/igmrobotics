<?php
  require('db.php');
  require('invoicetemplate.php');
  class InvoicePdf extends FPDF  {
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
            $this->Cell(20,10,"Part no.",1,0,'C',true);
            $this->Cell(10,8,"Qty.",1,0,'C',true);          
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
      $this->Image("../images/quotation_image.png",5,5, $this->getPageWidth()/2,15);
      $this->Ln(15);
    }

    function footer(){
      $this->SetY(-28);
      $this->SetTextColor(38,38,38);
      $this->SetDrawColor(255,0,0);
      $this->SetFont('Arial','',6.5);

      $this->Cell(90,5,'Page '.$this->PageNo()."/{nb}",0,0,'R');
      $this->Cell(90,5,' form ID: FOi-CI-04',0,1,'R');

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
      $this->Cell(25,5,"GST:27AABCI7257D1ZM","L",1,'L');      
    }
    
  }


  if($_POST!=null){
    $db = new DB();
    
    if(isset($_POST['generateInvoice'])){
      //echo "<pre>";var_dump($_POST);echo "</pre>";
      /*$to = $_POST['to'];
      $invoiceNo = $_POST['invoicenumber'];
      $projectno = $_POST["projectno"];
      $courier = $_POST["courier"];
      $dispatchno = $_POST["dispatchno"];        
      $f = new DateTime($_POST['date']);
      $date = $f->format('Y-m-d H:i:s');
      $transport = $_POST['transport'];
      $vehicle = $_POST['vehiclenumber'];
      $freight = $_POST['freight'];
      $f = new DateTime($_POST['shipmentdate']);
      $shipment_date = $f->format('Y-m-d H:i:s');
      $terms = $_POST['terms'];
      $co = $mo = $date1->format('Y-m-d H:i:s');
      $refno = $_POST["refquono"];
      $refdate = $_POST["refdate"];
      $igst = $_POST["igst"];
      $cgst = "0.00";
      $sgst = "0.00";
      $packaging = $_POST["packaging"]; 
      $total = 0;
      $list = array();
      $invParts = new ArrayObject();
      $arrayId = explode(",",$_POST["ids"]);
      foreach ($arrayId as $key => $value) {
        $partID = explode("-",$_POST['partno'.$value]);
        $a = array("partNo"=>$partID[1],"qty"=>$_POST['quantity'.$value],"desc"=>$_POST['description'.$value],
        "unitprice"=>$_POST['rate'.$value],"amount"=>$_POST['amount'.$value]);
        array_push($list, $a);
        $invParts[$key] = new InvParts(0,0,$partID[0],$_POST['quantity'.$value],
          $_POST['rate'.$value],
          "0.00","0.00",$_POST['discountslab'.$value],
          $_POST['tax'.$value],$_POST['amount'.$value]);

        $total += $_POST['amount'.$value];
      }
      $total+= $total*(($cgst+$sgst+$igst)/100);

      $total+=$packaging;

      $invObj = new Invoice($invoiceNo,$projectno,$to,$date,$shipment_date,$transport,$vehicle,$freight,
      $courier, $dispatchno, $terms,0,$cb,$co,$mb,$mo,
      $refno, $refdate, $igst, $cgst, $sgst, $packaging, $total,
      $invParts);        
      
      if(addInvoice($db->getConnection(), $invObj)){
        $inv = getInvoicePrintByNo($db->getConnection(), $invoiceNo);
        $to = getCust($db->getConnection(),$inv[0]['to']);
        $partsNo = getPartsNo($db->getConnection(),$inv[0]['parts']);
        echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Added')
        window.location.href='../pages/invoice.php';
        </SCRIPT>");
      }else{
        echo "Error";
      }*/
      if(addInvoice($db->getConnection(), $_POST)){
        echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Added')
        window.location.href='../pages/invoice.php';
        </SCRIPT>");
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Error generating po')
        window.location.href='../pages/invoice.php';
        </SCRIPT>");
      }
    }

    else if(isset($_POST['editInv'])){
      $invId = $_POST['id'];
      $invObj = new Invoice($_POST['id'], $_POST['invoicenumber'],$_POST["eprojectno"],$_POST['to'],$_POST['date'],
      $_POST['shipmentdate'],$_POST['transport'],$_POST['vehiclenumber'],$_POST['freight'],
      $_POST["ecourier"],$_POST["edispatchno"],$_POST['terms'],
      $cb,$date1->format('Y-m-d H:i:s'));
      //print_r($invObj);
      if(editInvoice($db->getConnection(), $invObj)){
         echo ("<SCRIPT LANGUAGE='JavaScript'>
           window.alert('Edited')
           window.location.href='../pages/editInv.php?type=inv&id=$invId';
           </SCRIPT>");
      }else{
         echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('Error Editing')
          window.location.href='../pages/editInv.php?type=inv&id=$invId';
           </SCRIPT>");
      }
    }

    else if(isset($_POST['getInvoice'])){
      getInvoice($db->getConnection(),$_POST);
    }

    else if(isset($_POST['getAllInvoice'])){
      getAllInvoice($db->getConnection(),$_POST);
    }

    else if(isset($_POST['deleteInv'])){
      if(deleteInvoice($db->getConnection(), $_POST["invId"])){
        echo "Deleted";
      }else{
        echo "Error Deleting Invoice";
      }
    }

    else if(isset($_POST['cancelInv'])){
      if(cancelInvoice($db->getConnection(), $_POST["invId"], $_POST['status'])){
        echo "Cancelled";
      }else{
        echo "Error Cancelleing PO";
      }
    }

    else if(isset($_POST['addInvPart'])){              
      //var_dump($part);
      $invId = $_POST["invId"];
      if(addInvoiceProduct($db->getConnection(), $_POST)){
        echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('Part Added')
          window.location.href='../pages/editInv.php?type=inv&id=$invId';
          </SCRIPT>");
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('Error Adding Part')
          window.location.href='../pages/editInv.php?type=inv&id=$invId';
          </SCRIPT>");
      }
    }

    else if(isset($_POST['updateInvPart'])){
      $invId = $_POST['einvId'];
      // echo "UpdateInv";
      $part = new InvParts($_POST["eid"],$_POST["einvId"],0,$_POST["epart"],$_POST["eqty"],
        $_POST["erate"],$_POST["eLandedCost"],$_POST["eSellingCost"],
        $_POST["epartdiscount"],$_POST["etax"],$_POST["eamount"]);
      if(updateInvoiceProduct($db->getConnection(), $part)){
        echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('Edited')
          window.location.href='../pages/editInv.php?type=inv&id=$invId';
          </SCRIPT>");
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('Error EditingPart')
          window.location.href='../pages/editInv.php?type=inv&id=$invId';
          </SCRIPT>");
      }
    }

    else if(isset($_POST['getInvPart'])){
      getInvoiceProduct($db->getConnection(), $_POST["invPartId"]);
    }

    else if(isset($_POST['deleteInvPart'])){
      if(deleteInvPart($db->getConnection(), $_POST["partId"])){
        echo "Deleted";
      }else{
        echo "Err deleting prt";
      }
    }

    else if(isset($_POST["getLastInv"])){
      getLastInv($db->getConnection());
    }

    else if(isset($_POST["customersForInv"])){
      customersForInv($db->getConnection(),$_POST);
    }

    else if(isset($_POST["quoForInv"])){
      quoForInv($db->getConnection(),$_POST);
    }

    else if(isset($_POST["partsForInvParticular"])){
      partsForInvParticular($db->getConnection(),$_POST);
    }

  }else{
    $db = new DB();
    if(isset($_GET["id"])){
      /*$inv = getInvoicePrint($db->getConnection(), $_GET["id"]);
      $to = getCust($db->getConnection(),$inv[0]['to']);
      $partsNo = getPartsNo($db->getConnection(),$inv[0]['parts']);
      $copy = $_GET["copy"]=="Original" || $_GET["copy"]=="original"?$_GET["copy"]:$_GET["copy"]." Copy";
      generatePDF($to, $partsNo, $inv, $copy);*/
      generatePDF($db->getConnection(),$_GET);
    }
  }

    
    function generatePDF($connection, $params){
      $copy = $params["copy"]=="Original" || $params["copy"]=="original"?$params["copy"]:$params["copy"]." Copy";

      //Get Info
    $query="select inv.id,inv.projectno, inv.inv_no, inv.refno, inv.courier, inv.dispatchno, inv.terms,
     inv.igst, inv.packaging,
      date_format(inv.refdate, '%d-%m-%Y') as refdate,      
      c.cno,c.company_name,c.addressline1,c.addressline2,c.city,c.country,c.contact_person1_name,
      ip.part_number,ip.description, invp.qty, invp.unitprice, invp.partTotAmount      
      from invoice inv left join invoice_products invp on inv.id=invp.invId
      left join customers c on inv.cust_id=c.id
      left join inventory_parts ip on invp.partId=ip.id 
      WHERE inv.id=".$params["id"];
      $result = $connection->query($query);
      $data = "";$invparticulars=[];
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){          
          $data = $row;
          $desc = iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']);
          $invparticulars[]=array("part_number"=>$row["part_number"],"description"=>$desc,
            "qty"=>$row["qty"],"unitprice"=>$row["unitprice"],"partTotAmount"=>$row["partTotAmount"]);
        }
      }


      //generate pdf

      $pdf = new InvoicePdf();
      $pdf->setFont("Arial","",9);
      $pdf->AliasNbPages();
      $pdf->addPage();
      $pdf->SetAutoPageBreak(true,25);
      
      $pdf->AliasNbPages();
      $st = $pdf->GetY();
      $pdf->setFont("Arial","",9);
      $pdf->text(121, 20, $copy);
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
      $pdf->Cell(110,5,$data["country"].".","",0,'L');


      $pdf->setFont("Arial","",8);
      $date = new DateTime();
      $pdf->Cell(80,5,"Date: ".$date->format('d/M/Y'),"",1,'L');

      $pdf->setFont("Arial","B",8);
      $pdf->SetTextColor(251,49,40);     
      //var_dump($inv);
      $pdf->Cell(15,15,"INVOICE","",0,'L');
      $pdf->Cell(60,15,"No. PI-".$data["inv_no"],"",1,'L');

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38); 

      $pdf->Cell(120,5,"Customer Name:  ".$data["company_name"],"",1,'L');
      $pdf->Cell(120,5,"Customer No.: ".$data["cno"],"",1,'L');
      if(sizeof(explode("_",$data["refno"]))>1){
        $pdf->Cell(120,5,"Your Reference No.: ".explode("_",$data["refno"])[1]." DTD. ".$data["refdate"],"",1,'L');
      }else{
        $pdf->Cell(120,5,"Your Reference No.: Not Defined DTD. ".$data["refdate"],"",1,'L');
      }
      $pdf->Cell(120,5,"Igm Project No.: ".$data["projectno"],"",1,'L');

      $pdf->Cell(120,15,"We hereby invoice to you the following goods and/or services as per our general terms and conditions.","",1,'L');

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
      $subtotal = 0;
      
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(0,0,0);
      $pdf->SetFillColor(217,217,217);
      $pdf->SetDrawColor(255,255,255);
      $i=1;

      $pdf->SetWidths(array(10,20,10,60,30,30));
      foreach ($invparticulars as $key=>$particulars) {
        $subtotal += $particulars['partTotAmount'];
        $pdf->Row(array($i,$particulars['part_number'],$particulars['qty'],$particulars['description'],
          number_format($particulars['unitprice'],2,".",","),number_format($particulars['partTotAmount'],2,".",",")));      
        $i+=1;  
      }      

      $pdf->Cell(160,8,"===================================================================================",1,1,'C',true);

      $pdf->Cell(10,8,"",1,0,'C',true);
      $pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(10,8,"",1,0,'C',true);
      //$pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(60,8,"Subtotal in INR",1,0,'C',true);
      $pdf->Cell(30,8,"",1,0,'C',true);
      $pdf->Cell(30,8,number_format($subtotal,2,".",","),1,1,'C',true);
      
      $gst = ($data["igst"]/100)*$subtotal;
      
      $pdf->Cell(10,8,"",1,0,'C',true);
      $pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(10,8,"",1,0,'C',true);
      //$pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(60,8,"Total GST in INR",1,0,'C',true);
      $pdf->Cell(30,8,"",1,0,'C',true);
      $pdf->Cell(30,8,number_format($gst,2,".",","),1,1,'C',true);
 
      $pdf->Cell(10,8,"",1,0,'C',true);
      $pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(10,8,"",1,0,'C',true);
      //$pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(60,8,"Packaging in INR",1,0,'C',true);
      $pdf->Cell(30,8,"",1,0,'C',true);
      $pdf->Cell(30,8,number_format($data["packaging"],2,".",","),1,1,'C',true);
      
      $pdf->Cell(10,8,"",1,0,'C',true);
      $pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(10,8,"",1,0,'C',true);
      //$pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(60,8,"Total amount in INR",1,0,'C',true);
      $pdf->Cell(30,8,"",1,0,'C',true);
      $pdf->Cell(30,8,number_format($subtotal+$gst+$data["packaging"],2,".",","),1,1,'C',true);

      $pdf->Cell(160,8,"===================================================================================",1,1,'C',true);
      $pdf->Cell(190,10,"",1,1,'C');
      $y=$pdf->GetY();
      if($y>=246.00125){
        $pdf->AddPage();
      }

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(190,5,"THE PRICE IS VALID:",1,1,"L");

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),1,0,"L");
      $pdf->setFont("Arial","",9);
      $pdf->SetTextColor(38,38,38);
      $pdf->Cell(190,5,"  CIF / DAP / DDP",1,1,"L");

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(190,5,"DELIVERY TERMS AS PER INCOTERMS 2010:",1,1,"L");
      
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),1,0,"L");
      $pdf->setFont("Arial","",9);
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
      $pdf->Cell(190,5," Sent by ".$data["courier"]." courier service",1,1,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),1,0,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
      $pdf->Cell(190,5," Courier dispatch no. ".$data["dispatchno"],1,1,"L");

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(190,5,"PAYMENT TERMS:",1,1,"L");
      
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),1,0,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
      $pdf->Cell(190,5," 100% advance payment",1,1,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),1,0,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
      $pdf->Cell(190,5," 100% payment at 30/60 days net",1,1,"L"); 

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(190,5,"NOTE ON RECEIPT OF THE GOODS",1,1,"L");

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),1,0,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
      $pdf->MultiCell(190,5," The receiver of the goods in this consignment has to check the package for damages immediately after receipt of\n the goods.",1,"L",0);
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),1,0,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
      
      $pdf->MultiCell(190,5," Any claims on transportation damages must be reported to igm Roboticsystems India Pvt. Ltd. per e-mail \nwithin 54h after receipt of the goods.",1,"L",0);
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(190,5,"OUR BANK DETAILS:",1,1,"L");
      
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),1,0,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
      $pdf->Cell(190,5," YES BANK, SWIFT YESBINBBXXX, IFSC YESB0000412",1,1,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),1,0,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
      $pdf->Cell(190,5," INR A/C No: 0412637000651, EEFC A/C No: 041282300000123 ",1,1,"L");    
      
      
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(190,5,"TERMS AND CONDITION:",0,1,"L");
      
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),0,0,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
     
      $pdf->Cell(190,5,$data["terms"],0,1,"L");


      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);

            
      $pdf->Cell(190,5,"Thank you",1,1,"L");
      $pdf->Cell(190,5,"With warm regards,",1,1,"L");    
      $pdf->Cell(190,5,"igm Roboticsystems India Pvt. Ltd.",1,1,"L");

      echo $pdf->Output();
    }

    function generatePDF1($to, $partsNo, $inv, $copy){      
      $pdf = new InvoicePdf();
      $pdf->setFont("Arial","",9);
      $pdf->AliasNbPages();
      $pdf->addPage();
      $pdf->SetAutoPageBreak(true,25);
      

      $pdf->AliasNbPages();
      $st = $pdf->GetY();
      $pdf->setFont("Arial","",9);
      $pdf->text(121, 20, $copy);
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
      $pdf->Cell(110,5,$to[0]["country"].".","",0,'L');
      $pdf->setFont("Arial","",8);
      $date = new DateTime();
      $pdf->Cell(80,5,"Date: ".$date->format('d/M/Y'),"",1,'L');

      $pdf->setFont("Arial","B",8);
      $pdf->SetTextColor(251,49,40);     
      //var_dump($inv);
      $pdf->Cell(15,15,"INVOICE","",0,'L');
      $pdf->Cell(60,15,"No. PI-".$inv[0]["invno"],"",1,'L');

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38); 

      $pdf->Cell(120,5,"Customer Name:  ".$to[0]["company"],"",1,'L');
      $pdf->Cell(120,5,"Customer No.: ".$to[0]["cno"],"",1,'L');
      if(sizeof(explode("_",$inv[0]["refno"]))>1){
        $pdf->Cell(120,5,"Your Reference No.: ".explode("_",$inv[0]["refno"])[1]." DTD. ".$inv[0]["refdate"],"",1,'L');
      }else{
        $pdf->Cell(120,5,"Your Reference No.: Not Defined DTD. ".$inv[0]["refdate"],"",1,'L');
      }
      $pdf->Cell(120,5,"Igm Project No.: ".$inv[0]["projectno"],"",1,'L');

      $pdf->Cell(120,15,"We hereby invoice to you the following goods and/or services as per our general terms and conditions.","",1,'L');

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
      $subtotal = 0;
      $i=10;

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(0,0,0);
      $pdf->SetFillColor(217,217,217);
      $pdf->SetDrawColor(255,255,255);
      $countTab = 1;     
      $i=1;

      $pdf->SetWidths(array(10,20,10,/*20,*/60,30,30));
      
      foreach ($inv[0]['parts'] as $key=>$value) {
        $subtotal += $value['amount'];
        $pdf->Row(array($i,$partsNo[$key]['part'],number_format($value['qty']),/*number_format($value['unitprice'],2,".",","),*/$partsNo[$key]['desc'],number_format($value['amount'],2,".",","),number_format($value['amount'],2,".",",")));      
        $i+=1;  
      }      

      $pdf->Cell(160,8,"===================================================================================",1,1,'C',true);

      $pdf->Cell(10,8,"",1,0,'C',true);
      $pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(10,8,"",1,0,'C',true);
      //$pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(60,8,"Subtotal in INR",1,0,'C',true);
      $pdf->Cell(30,8,"",1,0,'C',true);
      $pdf->Cell(30,8,number_format($subtotal,2,".",","),1,1,'C',true);
      
      $gst = (($inv[0]["cgst"]+$inv[0]["sgst"]+$inv[0]["igst"])/100)*$subtotal;
      
      $pdf->Cell(10,8,"",1,0,'C',true);
      $pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(10,8,"",1,0,'C',true);
      //$pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(60,8,"Total GST in INR",1,0,'C',true);
      $pdf->Cell(30,8,"",1,0,'C',true);
      $pdf->Cell(30,8,number_format($gst,2,".",","),1,1,'C',true);

      $pdf->Cell(10,8,"",1,0,'C',true);
      $pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(10,8,"",1,0,'C',true);
      //$pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(60,8,"Packaging in INR",1,0,'C',true);
      $pdf->Cell(30,8,"",1,0,'C',true);
      $pdf->Cell(30,8,number_format($inv[0]["packaging"],2,".",","),1,1,'C',true);
      
      $pdf->Cell(10,8,"",1,0,'C',true);
      $pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(10,8,"",1,0,'C',true);
      //$pdf->Cell(20,8,"",1,0,'C',true);
      $pdf->Cell(60,8,"Total amount in INR",1,0,'C',true);
      $pdf->Cell(30,8,"",1,0,'C',true);
      $pdf->Cell(30,8,number_format($subtotal+$gst+$inv[0]["packaging"],2,".",","),1,1,'C',true);

      $pdf->Cell(160,8,"===================================================================================",1,1,'C',true);
      $pdf->Cell(190,10,"",1,1,'C');
      $y=$pdf->GetY();
      if($y>=246.00125){
        $pdf->AddPage();
      }

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(190,5,"THE PRICE IS VALID:",1,1,"L");

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),1,0,"L");
      $pdf->setFont("Arial","",9);
      $pdf->SetTextColor(38,38,38);
      $pdf->Cell(190,5,"  CIF / DAP / DDP",1,1,"L");

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(190,5,"DELIVERY TERMS AS PER INCOTERMS 2010:",1,1,"L");
      
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),1,0,"L");
      $pdf->setFont("Arial","",9);
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
      $pdf->Cell(190,5," Sent by ".$inv[0]["courier"]." courier service",1,1,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),1,0,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
      $pdf->Cell(190,5," Courier dispatch no. ".$inv[0]["dispatchno"],1,1,"L");

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(190,5,"PAYMENT TERMS:",1,1,"L");
      
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),1,0,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
      $pdf->Cell(190,5," 100% advance payment",1,1,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),1,0,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
      $pdf->Cell(190,5," 100% payment at 30/60 days net",1,1,"L"); 

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(190,5,"NOTE ON RECEIPT OF THE GOODS",1,1,"L");

      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),1,0,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
      $pdf->MultiCell(190,5," The receiver of the goods in this consignment has to check the package for damages immediately after receipt of\n the goods.",1,"L",0);
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),1,0,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
      
      $pdf->MultiCell(190,5," Any claims on transportation damages must be reported to igm Roboticsystems India Pvt. Ltd. per e-mail \nwithin 54h after receipt of the goods.",1,"L",0);
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(190,5,"OUR BANK DETAILS:",1,1,"L");
      
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),1,0,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
      $pdf->Cell(190,5," YES BANK, SWIFT YESBINBBXXX, IFSC YESB0000412",1,1,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),1,0,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);
      $pdf->Cell(190,5," INR A/C No: 0412637000651, EEFC A/C No: 041282300000123 ",1,1,"L");    
      
      
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(190,5,"TERMS AND CONDITION:",0,1,"L");
      
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(251,49,40);
      $pdf->Cell(5,5,chr(149),0,0,"L");
      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);

      $pdf->Cell(190,5,$inv[0]["terms"],0,1,"L");


      $pdf->setFont("Arial","",8);
      $pdf->SetTextColor(38,38,38);

            
      $pdf->Cell(190,5,"Thank you",1,1,"L");
      $pdf->Cell(190,5,"With warm regards,",1,1,"L");    
      $pdf->Cell(190,5,"igm Roboticsystems India Pvt. Ltd.",1,1,"L");

      echo $pdf->Output();
    }


      function customersForInv($connection, $params){
        $query="SELECT id,company_name, city  FROM customers WHERE company_name LIKE '%".$params['term']['term']."%'";
        $result = $connection->query($query);
        $data = array();
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){                    
            $data[] = array('id'=>$row['id'],'company'=>$row['company_name']."-".$row['city']);
          }
        }      
        echo json_encode($data);
      }

      function quoForInv($connection,$params){
        $query="SELECT id, quo_no FROM quotation WHERE quo_no LIKE '%".$params['term']['term']."%'";
        $result = $connection->query($query);
        $data = array();
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){                    
            $data[] = array('id'=>$row['id'],'quo_no'=>$row['quo_no']);
          }
        }      
        echo json_encode($data);
      }

      function partsForInvParticular($connection,$params){
        $query="SELECT id,part_number,description,unit_price_euro,unit_price_inr FROM inventory_parts
        WHERE part_number LIKE '".$params['term']['term']."%' AND (unit_price_euro!=0 OR unit_price_inr!=0)";      
        $result = $connection->query($query);
        //echo $query;
        $data = array();
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){       
            $desc = iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']);
            $data[] = array('id'=>$row['id'],'part_number'=>$row['part_number'],'description'=>$desc,
            "upe"=>$row["unit_price_euro"],"upi"=>$row["unit_price_inr"]);
          }
        }
        echo json_encode($data);
      }

      function addInvoice($connection, $params){
        //projectno,to,invoicenumber,date,refquono,refdate,shipmentdate,transport,courier,vehiclenumber,
        //dispatchno,freight,igst,packaging,terms                
        $q = "INSERT INTO invoice
        (inv_no, projectno, cust_id, date, shipment_date, transport, vehicle, freight, courier, dispatchno,
         terms, cancelled,refno, refdate, cgst, sgst, igst, packaging, total,created_by, created_on, modified_by,
          modified_on)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,0,?,?,0,0,?,?,?,?,(SELECT NOW()),?,(SELECT NOW()))";
        $stmt = $connection->prepare($q);
        $stmt->bind_param("ssissssisssssdddss", $inv_no, $projectno, $cust_id, $date, $shipment_date, $transport,
         $vehicle, $freight, $courier, $dispatchno, $terms, $refno, $refdate, $igst, $packaging, $total, $cb, $mb);
        $inv_no = $params["invoicenumber"];
        $projectno = $params["projectno"];
        $cust_id = $params["to"];
        $date = $params["date"];
        $shipment_date = $params["shipmentdate"];
        $transport = $params["transport"];
        $vehicle = $params["vehiclenumber"];
        $freight = $params["freight"];
        $courier = $params["courier"];
        $dispatchno = $params["dispatchno"];
        $terms = $params["terms"];
        $refno = $params["refquono"];
        $refdate = $params["refdate"];
        $igst = $params["igst"];
        $packaging = $params["packaging"];
        $total = 0;
        $cb = $mb = $_COOKIE["usermail"];
        if($stmt->execute()){
          $invId=$connection->insert_id;
          if(addInvoiceProducts($connection, $invId, $params)){
              return true;
          }
        }else{
          error_log(date("Y-m-d h:m:s")." ERROR when adding Invoice.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
          return false;
        }
      }

      function addInvoiceProducts($connection, $invId, $params){
        $success = false;
        $index = explode(',',$params["ids"]);
        foreach ($index as $value){
          $q = "INSERT INTO
          invoice_products
          (invId,inward_no, partId, qty,unitprice,landed_cost, selling_price,discount,tax, partTotAmount)
          VALUES
          (?,0,?,?,?,0,0,?,?,?)";

          $stmt = $connection->prepare($q);
          $stmt->bind_param("iiidddd", $invId, $partId, $qty, $rate,$discount,$tax, $partTotAmount);
          $invId = $invId;
          $partId = $params["partId".$value];
          $qty = $params["quantity".$value];
          $rate = $params["rate".$value];
          $discount = $params["discount".$value];
          $tax = $params["tax".$value];
          $partTotAmount = $params["amount".$value];
          if($stmt->execute()){
            $success = true;
          }else{
            error_log(date("Y-m-d h:m:s")." ERROR when adding Invoice Parts.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
            $success = false;
          }
        }
        if($success){
          return true;
        }else{
          return false;
        }
      }

      function addInvoiceProduct($connection, $param){          
          $q = "INSERT INTO
          invoice_products
          (invId,inward_no, partId, qty,discount, unitprice, landed_cost, selling_price, tax, partTotAmount)
          VALUES
          (?,?,?,?,?,?,?,?,?,?)";

          $stmt = $connection->prepare($q);
          $stmt->bind_param("iiiidddddd", $invId,$inward_no, $partId, $qty,$partdiscount, $rate,
            $landed_cost, $selling_price,$tax, $partTotAmount);
          $invId = $param["invId"];
          $inward_no=0;
          $partId = $param["part"];
          $qty = $param["qty"];
          $partdiscount = $param["partdiscount"];
          $tax = $param["tax"];
          $rate = $param["rate"];
          $landed_cost = $param["landedcost"];
          $selling_price = $param["sellingcost"];
          $partTotAmount = $param["amount"];
          if($stmt->execute()){
            if(updateInvoicePrice($connection, $part->getInvId())){
              return true;
            }
          }else{
            error_log(date("Y-m-d h:m:s")." ERROR when adding Invoice Part.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
            return false;
          }
      }

      function updateInvoiceProduct($connection, $part){ 
          $q = "SELECT * FROM invoice_products WHERE id =". $part->getId();
          echo $q;
          $result = $connection->query($q);
          $previousQty = "";
          if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
              $previousQty = $row["qty"];
            }
          }
          $q ="UPDATE
          invoice_products SET
          invId=?, inward_no=?,partId=?, qty=?,discount=?, unitprice=?,landed_cost=?, selling_price=?,tax=?, partTotAmount=?
          WHERE id = ?";

          $stmt = $connection->prepare($q);
          $stmt->bind_param("iiiiddddddi", $invId,$inward_no, $partId, $qty,$partdiscount, $rate,
          $landed_cost, $selling_price, $tax, $partTotAmount,$id);
          $invId = $part->getInvId();
          $inward_no = 0;
          $partId = $part->getPartId();
          $qty = $part->getQty();
          $partdiscount = $part->getDiscount();
          $rate = $part->getUnitprice();
          $landed_cost = $part->getLandedcost();
          $selling_price = $part->getSellingprice();
          $tax = $part->getTax();
          $partTotAmount = $part->getPartTotAmount();
          $id = $part->getId();
          if($stmt->execute()){
            if(updateInvoicePrice($connection, $part->getInvId())){              
              return true;
            }
          }else{
            return false;
          }
      }

      function updateInvoicePrice($connection,$id){
        $q = "UPDATE invoice SET total=? WHERE id=?";
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
        $query="SELECT SUM(partTotAmount) as tot FROM invoice_products WHERE invId=".$id;
        $result = $connection->query($query);
        $data = "";
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){          
            $partTot = $row['tot'];
          }
        }

        $gst=0;
        $packaging = 0;
        $query="SELECT *  FROM invoice WHERE id=$id";
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

      function getInvoiceProduct($connection, $id){
        $q = "SELECT * FROM invoice_products WHERE id =".$id;
        $result = $connection->query($q);
        $data = array();
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){
            $data[] = array("id"=>$row["id"],"invId"=>$row["invId"],"partId"=>$row["partId"],
              "inward_no"=> $row["inward_no"]."/".getInwardNo($connection, $row["inward_no"]),
              "qty"=>$row["qty"],"discount"=>$row["discount"],
              "landed_cost"=>$row["landed_cost"],"selling_price"=>$row["selling_price"],
              "unitprice"=>$row["unitprice"],"tax"=>$row["tax"],"amount"=>$row["partTotAmount"]);
          }
        }
        echo json_encode($data);

      }

      function getInwardNo($connection, $inward){
        $q = "SELECT * FROM duty WHERE duty_id =". $inward;
        $result = $connection->query($q);
        $data = "";
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){
            $data = $row["inward_no"];
          }
        }
        return $data;
      }      
      

      function updateStockQuantity($connection, $parts){
        $success = false;
        foreach ($parts as $key => $value){
          $q = "UPDATE inventory_parts SET total = total-? WHERE id=?";
          $stmt = $connection->prepare($q);
          $stmt->bind_param("ii", $qty,$id);          
          $qty = $value->getQty();
          $id = $value->getPartId();
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

      function getInvoiceByNumber($connection, $invno){
        $query="SELECT * FROM invoice WHERE inv_no = '".$invno."'";
        $result = $connection->query($query);
        $data = array();
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){
            $data[] = $row['id'];
          }
        }
        return $data[0];
      }

      function getInvoice($connection, $params){
        //id,projectno,customer,invoicenumber,date,refno,refdate,shipmentdate,transport,
        //courier,vehiclenumber,dispatchno,freight,igst,packaging,terms
        //Part No, Part Id,Description,Unit,Quantity,Discount,Tax,Amount,Action

        $query="SELECT i.id,i.projectno,i.inv_no,
                DATE_FORMAT(i.date, '%d-%m-%Y') as invDate,i.refno,
                DATE_FORMAT(i.refdate, '%d-%m-%Y') as refdate,
                DATE_FORMAT(i.shipment_date, '%d-%m-%Y') as shipment_date,
                i.transport,i.courier,i.vehicle,i.dispatchno,
                i.freight,i.igst,i.packaging,i.terms,
                c.company_name as customer,
                invp.id as particularId,invp.invId,invp.partId,invp.qty,invp.discount,
                invp.unitprice,invp.tax,invp.partTotAmount,
                ip.part_number, ip.description
                FROM invoice i LEFT JOIN invoice_products invp on i.id=invp.invId
                LEFT JOIN customers c  on i.cust_id=c.id
                LEFT JOIN inventory_parts ip  on invp.partId=ip.id
                WHERE i.id =".$params['id'];
        $result = $connection->query($query);
        $invoiceDetails="";
        $particularDetails=[];
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){
            $invoiceDetails=array("id"=>$row["id"],"projectno"=>$row["projectno"],"inv_no"=>$row["inv_no"],
            "invDate"=>$row["invDate"],"refno"=>$row["refno"],"refdate"=>$row["refdate"],
            "shipment_date"=>$row["shipment_date"],"transport"=>$row["transport"],"courier"=>$row["courier"],
            "vehicle"=>$row["vehicle"],"dispatchno"=>$row["dispatchno"],"freight"=>$row["freight"],
            "igst"=>$row["igst"],"packaging"=>$row["packaging"],"terms"=>$row["terms"],"customer"=>$row["customer"]);
            
            $desc = iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']);
            $particularDetails[]=array("particularId"=>$row["particularId"], "partId"=>$row["partId"],
            "qty"=>$row["qty"], "discount"=>$row["discount"], "unitprice"=>$row["unitprice"],
            "tax"=>$row["tax"], "partTotAmount"=>$row["partTotAmount"],
            "part_number"=>$row["part_number"], "description"=>$desc);
          }
        }
        $data = array("invoiceDetails"=>$invoiceDetails,"particularDetails"=>$particularDetails);
        echo json_encode($data);
      }

      function getInvoicePrint($connection, $id){
        $query="SELECT * FROM invoice WHERE id =".$id."";
        $result = $connection->query($query);
        $data = array();
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){
            $query1="SELECT * FROM invoice_products WHERE invId = ".$row["id"];
            $result1 = $connection->query($query1);
            $data1 = array();
            if($result1->num_rows>0){
              while($row1=$result1->fetch_assoc()){
                //id, invId, partId, qty, rate, partTotAmount
                $data1[] = array("id"=>$row1["id"],"invId"=>$row1["invId"],
                  "inward_no"=>$row1["inward_no"],
                  "partId"=>$row1["partId"],
                "qty"=>$row1["qty"],"discount"=>$row1["discount"],
                "unitprice"=>$row1["unitprice"],
                "landed_cost"=>$row1["landed_cost"],"selling_price"=>$row1["selling_price"],                
                "tax"=>$row1["tax"],"amount"=>$row1["partTotAmount"]);
              }
            }
            //inv_no, cust_id, date, shipment_date, transport, vehicle, freight, terms,created_by, created_on, modified_by, modified_on
            $data[] = array("id"=>$row["id"],"invno"=>$row["inv_no"],"projectno"=>$row["projectno"],"to"=>$row["cust_id"],"date"=>$row["date"],"shipdate"=>$row["shipment_date"],
            "mode"=>$row["transport"],"vehicle"=>$row["vehicle"],"freight"=>$row["freight"],
            "courier"=>$row["courier"],"dispatchno"=>$row["dispatchno"],
            "terms"=>$row["terms"],"cb"=>$row["created_by"],"co"=>$row["created_on"],
            "mb"=>$row["modified_by"],"mo"=>$row["modified_on"],"parts"=>$data1,"cancelled"=>$row['cancelled'],
            "refno" => $row['refno'], "refdate" => $row['refdate'], "cgst" => $row['cgst'], 
            "sgst" => $row['sgst'], "igst" => $row['igst'], "packaging" => $row['packaging'], 
            "total" => $row['total']);
          }
        }
        return $data;
      }

      function getInvoicePrintByNo($connection, $id){
        $query="SELECT * FROM invoice WHERE inv_no ='".$id."'";
        $result = $connection->query($query);
        $data = array();
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){
            $query1="SELECT * FROM invoice_products WHERE invId = ".$row["id"];
            $result1 = $connection->query($query1);
            $data1 = array();
            if($result1->num_rows>0){
              while($row1=$result1->fetch_assoc()){
                //id, invId, partId, qty, rate, partTotAmount
                $data1[] = array("id"=>$row1["id"],"invId"=>$row1["invId"],
                  "inward_no"=>$row1["inward_no"],
                  "partId"=>$row1["partId"],
                "qty"=>$row1["qty"],"discount"=>$row1["discount"],
                "unitprice"=>$row1["unitprice"],
                "landed_cost"=>$row1["landed_cost"],"selling_price"=>$row1["selling_price"],
                "tax"=>$row1["tax"],"amount"=>$row1["partTotAmount"]);
              }
            }
            //inv_no, cust_id, date, shipment_date, transport, vehicle, freight, terms,created_by, created_on, modified_by, modified_on
            $data[] = array("id"=>$row["id"],"invno"=>$row["inv_no"],"projectno"=>$row["projectno"],"to"=>$row["cust_id"],"date"=>$row["date"],"shipdate"=>$row["shipment_date"],
            "mode"=>$row["transport"],"vehicle"=>$row["vehicle"],"freight"=>$row["freight"],
            "courier"=>$row["courier"],"dispatchno"=>$row["dispatchno"],"terms"=>$row["terms"],"cb"=>$row["created_by"],"co"=>$row["created_on"],
            "mb"=>$row["modified_by"],"mo"=>$row["modified_on"],"parts"=>$data1,"cancelled"=>$row['cancelled'],
            "refno" => $row['refno'], "refdate" => $row['refdate'], "cgst" => $row['cgst'], 
            "sgst" => $row['sgst'], "igst" => $row['igst'], "packaging" => $row['packaging'], 
            "total" => $row['total']);
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
          ,'country' => $row['country']
            ,'person1'=>$row['contact_person1_name']);
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
      function getAllInvoice($connection,$params){
        $query="select i.id, i.inv_no, c.company_name as customer,
        DATE_FORMAT(i.date,'%d-%m-%Y') as invDate,
        DATE_FORMAT(i.shipment_date,'%d-%m-%Y') as shipment_date,
        TRUNCATE(((i.igst/100)*(sum(ip.partTotAmount)))+sum(ip.partTotAmount)+i.packaging,2) as totAmt
        from 
        invoice i left join invoice_products ip on i.id=ip.invId
        left join customers c on i.cust_id=c.id  group by ip.invId 
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
        $query="select i.id, i.inv_no,i.freight, i.cancelled, c.company_name as customer,
        DATE_FORMAT(i.date,'%d-%m-%Y') as invDate,
        DATE_FORMAT(i.shipment_date,'%d-%m-%Y') as shipment_date,
        TRUNCATE(((i.igst/100)*(sum(ip.partTotAmount)))+sum(ip.partTotAmount)+i.packaging,2) as totAmt
        from 
        invoice i left join invoice_products ip on i.id=ip.invId
        left join customers c on i.cust_id=c.id  group by ip.invId
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

        /*$query="SELECT * FROM invoice";
        $result = $connection->query($query);
        $data = array();
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){
            $query1="SELECT * FROM invoice_products WHERE invId = ".$row["id"];
            $result1 = $connection->query($query1);
            $data1 = array();
            if($result1->num_rows>0){
              while($row1=$result1->fetch_assoc()){
                //id, invId, partId, qty, rate, partTotAmount
                $data1[] = array("id"=>$row1["id"],"invId"=>$row1["invId"],
                  "inward_no"=>$row1["inward_no"],"partId"=>$row1["partId"],
                "qty"=>$row1["qty"],"discount"=>$row1["discount"],
                "unitprice"=>$row1["unitprice"],
                "landed_cost"=>$row1["landed_cost"],"selling_price"=>$row1["selling_price"],"tax"=>$row1["tax"],"amount"=>$row1["partTotAmount"]);
              }
            }
            
            $data[] = array("id"=>$row["id"],"invno"=>$row["inv_no"],"projectno"=>$row["projectno"],"to"=>$row["cust_id"],"date"=>$row["date"],"shipdate"=>$row["shipment_date"],
            "mode"=>$row["transport"],"vehicle"=>$row["vehicle"],"freight"=>$row["freight"],
            "courier"=>$row["courier"],"dispatchno"=>$row["dispatchno"],"terms"=>$row["terms"],"cb"=>$row["created_by"],"co"=>$row["created_on"],
            "mb"=>$row["modified_by"],"mo"=>$row["modified_on"],"parts"=>$data1,"cancelled"=>$row['cancelled'],
            "refno" => $row['refno'], "refdate" => $row['refdate'], "cgst" => $row['cgst'], 
            "sgst" => $row['sgst'], "igst" => $row['igst'], "packaging" => $row['packaging'], 
            "total" => $row['total']);
          }
        }

        echo json_encode($data);*/
      }

      function editInvoice($connection, Invoice $inv){       
        $q = "UPDATE
        invoice SET
        inv_no=?,projectno=?,cust_id=?,date=?,shipment_date=?,
        transport=?,vehicle=?,freight=?,courier=?,dispatchno=?,terms=?,
        refno = ?, refdate = ?, cgst = ?, sgst = ?, igst = ?, packaging = ?, total = ?,
        modified_by=?,modified_on=?
        WHERE id=?";
        $stmt = $connection->prepare($q);
        $stmt->bind_param("ssissssisssssdddddssi", $inv_no, $projectno, $cust_id,$date,$shipment_date, $transport,$vehicle,$freight,
        $courier, $dispatchno, $terms, 
        $refno, $refdate, $cgst, $sgst, $igst,$packaging, $total,
        $mb, $mo,$id);
        $inv_no = $inv->getInvoiceNo();
        $projectno = $inv->getProjectNo();
        $courier = $inv->getCourier();
        $dispatchno = $inv->getDispatchno();
        $cust_id = $inv->getTo();
        $date = $inv->getDate();
        $shipment_date = $inv->getShipmentDate();
        $transport = $inv->getTransport();
        $vehicle = $inv->getVehicle();
        if($inv->getFreight()=="no"){
          $freight = 0;
        }else{
          $freight = 1;
        }
        $terms = $inv->getTerms();
        $refno = $inv->getRefno();
        $refdate = $inv->getRefdate();
        $cgst = $inv->getCgst();
        $sgst = $inv->getSgst();
        $igst = $inv->getIgst();
        $packaging = $inv->getPackaging();
        $total = $inv->getTotal();
        $mb = $inv->getMb();
        $mo = $inv->getMo();
        $id = $inv->getId();
        if($stmt->execute()){
          return true;
        }else{
          return false;
        }
      }

      function cancelInvoice($connection, $id, $status){
        $q = "UPDATE invoice SET cancelled=? WHERE id=?";
        $stmt = $connection->prepare($q);
        $stmt->bind_param("ii", $cancelled,$id);
        $cancelled = $status;
        $id = $id;
        if($stmt->execute()){
          return true;
        }else{
          return false;
        }
      }

      function deleteInvoice($connection, $id){
      $query="DELETE FROM invoice WHERE id = ?";
      $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $id);
        $id = $id;
        if($stmt->execute()){
          deleteInvParts($connection, $id);          
        }else{
          return false;
        }
    }

    function deleteInvPart($connection, $id){
      $query="DELETE FROM invoice_products WHERE id = ?";
      $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $id);
        $id = $id;
        if($stmt->execute()){
          return true;
        }else{
          return false;
        }
    }

    function deleteInvParts($connection, $id){
      $query="DELETE FROM invoice_products WHERE invId = ?";
      $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $id);
        $id = $id;
        if($stmt->execute()){
          return true;
        }else{
          return false;
        }
    }

    function getLastInv($connection){
      $query="SELECT inv_no FROM invoice order by id DESC LIMIT 1";
      $result = $connection->query($query);
      $data = "";
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data = $row['inv_no'];
        }
      }
      echo $data;
    }

    function getCustomerById($connection, $id){
      $query="SELECT * FROM customers WHERE id=".$id;
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
