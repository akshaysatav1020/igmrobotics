<?php
  require_once "db.php";
  require_once("../phplibraries/fpdf.php");
 class POPdf extends FPDF  {
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

            $this->Cell(5,10,"No.",1,0,'C',1);
            $this->Cell(20,10,"Part No.",1,0,'C',1);
            $this->Cell(8,10,"Qty.",1,0,'C',1);            
            $this->Cell(100,10,"Description of goods",1,0,'C',1);
            $this->Cell(30,10,"Unit Price",1,0,'C',1);
            $this->Cell(30,10,"Total Price",1,1,'C',1);
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
    
  if($_POST!=null){
    $db = new DB();
    if(isset($_POST['generatePO'])){
      //echo "<pre>";var_dump($_POST);echo "</pre>";      
      if(addPO($db->getConnection(), $_POST)){
        echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Generated successfully.')
        window.location.href='../pages/purchaseorder.php';
        </SCRIPT>");
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Something went wrong contact admin!!')
        window.location.href='../pages/purchaseorder.php';
        </SCRIPT>");        
      }
    }

    else if(isset($_POST['editPO'])){
      $poId= $_POST["id"];
      $f = new DateTime($_POST['quotationdate']);
      $quotationDate = $f->format('Y-m-d H:i:s');
      $po = new PurchaseOrder($_POST["id"], $_POST["ponumber"], $_POST["eprojectno"], $_POST["vendor"], $_POST["podate"],$_POST["poValidityDate"],
            $_POST["paymentTerms"],$_POST["deliveryTerms"], $_POST["terms"], $_POST["quotenumber"], $quotationDate,
            $_POST["currency"], $_POST['eurorate'], $_POST['epack'], $_POST['discount'], $_POST['igst'],  $cb, $date->format('Y-m-d H:i:s'));
      if(editPO($db->getConnection(), $po)){
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Edited')
            window.location.href='../pages/editPo.php?id=".$_POST["id"]."';
            </SCRIPT>");
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Error Editing')
            window.location.href='../pages/editPo.php?id=".$_POST["id"]."';
            </SCRIPT>");
      }
    }

    else if(isset($_POST['getPO'])){
      getPO($db->getConnection(),$_POST);
    }

    else if(isset($_POST['getAllPO'])){
      getAllPO($db->getConnection(),$_POST);
    }

    else if(isset($_POST['getAllPoTrack'])){
      getAllPoTrack($db->getConnection(),$_POST);
    }else if(isset($_POST['deletePO'])){
      if(deletePO($db->getConnection(), $_POST)){
        echo "Deleted";
      }else{
        echo "Error Generating PO";
      }
    }

    else if(isset($_POST['addPoPart'])){
      if(addPoProduct($db->getConnection(), $_POST)){
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Part Added')
            window.location.href='../pages/editPo.php?type=po&id=".$_POST["id"]."';
            </SCRIPT>");
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Error Editing Part')
            window.location.href='../pages/editPo.php?type=po&id=".$_POST["id"]."';
            </SCRIPT>");
      }

    }

    else if(isset($_POST['updatePoPart'])){
      if(editPoProduct($db->getConnection(), $_POST)){
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Edited Part')
            window.location.href='../pages/editPo.php?type=po&id=".$_POST["id"]."';
            </SCRIPT>");
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Error Editing Part')
            window.location.href='../pages/editPo.php?type=po&id=".$_POST["id"]."';
            </SCRIPT>");
      }
    }

    else if(isset($_POST['getPoPart'])){
      getPoPart($db->getConnection(), $_POST);
    } 

    else if(isset($_POST['deletePoPart'])){
        if(deletePoPart($db->getConnection(), $_POST)){
          echo "Deleted";
        }else{
          echo "Err deleting prt";
        }
    }

    else if(isset($_POST["getLastPO"])){
      getLastPo($db->getConnection());
    }

    else if(isset($_POST["getPOTrack"])){
        getPOTrack($db->getConnection(),$_POST);
    }

    else if(isset($_POST["updatePOTrack"])){
        updatePOTrack($db->getConnection(),$_POST);
    }

    else if(isset($_POST["addPartToMaster"])){
      if(addPartToMaster($db->getConnection(),$_POST)){
        echo "New part added to master!! Try adding particular.";
      }else{
        echo "Something went wrong contact admin!!";
      }
    }

    else if(isset($_POST["partsForPOParticular"])){
      partsForPOParticular($db->getConnection(),$_POST);
    }

    else if(isset($_POST["vendorsForPO"])){
      vendorsForPO($db->getConnection(),$_POST);
    }

  }else{
    $db = new DB();    
    if(isset($_GET["id"])){
      /*$po = getPOPrint($db->getConnection(), $_GET["id"]);
      generatePDF($po);*/
      generatePDF($db->getConnection(),$_GET);
    }
  }

    

  function generatePDF($connection,$params){
    //get info
    $query="select po.po_no, po.po_date, po.projectno, po.q_date, po.q_no,
    po.currency, po.discount, po.igst, po.package,  
    po.po_validity, po.terms, po.delivery_terms, po.payment_terms,
    v.company_name as company, v.contact_person1_name as person, v.addressline1, v.addressline2,v.city,
    ip.part_number, ip.description, pp.unitprice, pp.qty, pp.partTotAmt
    from purchaseorder po LEFT JOIN po_products pp on po.id=pp.poId
    LEFT JOIN inventory_parts ip on pp.partId=ip.id
    LEFT JOIN vendors v on po.vendor_id=v.id
    WHERE po.id=".$params["id"];
    $result = $connection->query($query);
    $po = array();
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
        $poDetails=array("po_no"=>$row['po_no'],"po_date"=>$row["po_date"],"projectno"=>$row["projectno"],
          "q_date"=>$row["q_date"], "q_no"=>$row["q_no"], "currency"=>$row["currency"],
          "discount"=>$row["discount"], "igst"=>$row["igst"], "package"=>$row["package"],
          "po_validity"=>$row["po_validity"], "terms"=>$row["terms"], "delivery_terms"=>$row["delivery_terms"],
          "payment_terms"=>$row["payment_terms"]
        );
        $vendorDetails = array("company"=>$row['company'],"person"=>$row['person'], 
          "addressline1"=>$row['addressline1'], "addressline2"=>$row['addressline2'], "city"=>$row['city']);
        $desc = iconv(mb_detect_encoding($row['description'], mb_detect_order(), true), "UTF-8//IGNORE", $row['description']);
        $particularDetails[]=array("part_number"=>$row["part_number"], "description"=>$desc, 
          "unitprice"=>$row["unitprice"], "qty"=>$row["qty"],"partTotAmt"=>$row["partTotAmt"]
        );
      }
    }
    $po = array("poDetails"=>$poDetails,"vendorDetails"=>$vendorDetails,"particularDetails"=>$particularDetails);

    //generate pdf
    $pdf = new POPdf();
    $pdf->setFont("Arial","B",8);
    $pdf->SetTextColor(0,0,0);
    $pdf->addPage();

    $pdf->AliasNbPages();    
    $pdf->SetAutoPageBreak(true,25);

    $st = $pdf->GetY();
    $pdf->setFont("Arial","",8);
    $pdf->Cell(110,5,"To,","",0,'L');
    $pdf->setFont("Arial","",8);    
    $pdf->Cell(80,5,"igm Roboticsystems India Pvt. Ltd.","",1,'L');
    $pdf->setFont("Arial","",8);
    $pdf->Cell(110,5,$po["vendorDetails"]["company"],"",1,'L');
    $pdf->Cell(110,5,"Attn.: ".$po["vendorDetails"]["person"],"",0,'L');
    $pdf->setFont("Arial","",8);
    $pdf->Cell(80,5,"Contact:  Sarika Dive","",1,'L');
    $pdf->setFont("Arial","",8);
    $pdf->Cell(110,5,$po["vendorDetails"]["addressline1"].",","",0,'L');
    $pdf->setFont("Arial","",8);
    $pdf->Cell(80,5,"Mobile: +91 7738155709","",1,'L');
    $pdf->setFont("Arial","",8);
    $pdf->Cell(110,5,$po["vendorDetails"]["addressline2"].",","",0,'L');
    $pdf->setFont("Arial","",8);
    $pdf->Cell(80,5,"E-mail: sarika.dive@igm-india.com","",1,'L');
    $pdf->setFont("Arial","",8);
    $pdf->Cell(110,5,$po["vendorDetails"]["city"].",","",1,'L');    
    $pdf->setFont("Arial","",8);
    $date = new DateTime();
    $pdf->Cell(80,5,"Date: ".$date->format('d/M/Y'),"",1,'L');

    $pdf->setFont("Arial","B",8);
    $pdf->SetTextColor(251,49,40);         
    $pdf->Cell(25,15,"Purchase order","",0,'L');
    $pdf->Cell(60,15,"No. P-".$po["poDetails"]['po_no'],"",1,'L');

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38); 
    $pdf->Cell(120,5,"Your reference no.: ".$po["poDetails"]["q_no"]."  DTD. ".$po["poDetails"]['q_date'],"",1,'L');    

    
    $pdf->MultiCell(190,10,"We thank you for your inquiry and we hereby offer to you the following goods and/or services as per our general terms and conditions.",0,'L',0);
    $pdf->LN(5);

    $pdf->setFont("Arial","B",8);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFillColor(251,49,40);
    $pdf->SetDrawColor(255,255,255);

    $pdf->Cell(5,8,"No.",1,0,'C',1);
    $pdf->Cell(20,8,"Part No.",1,0,'C',1);
    $pdf->Cell(8,8,"Qty.",1,0,'C',1);    
    $pdf->Cell(100,8,"Description of goods",1,0,'C',1);
    $currency = ($po["poDetails"]['currency']=="eur")?"EURO":"INR";      
    $pdf->Cell(30,8,"Unit Price(".$currency.")",1,0,'C',1);
    $pdf->Cell(30,8,"Total Price(".$currency.")",1,1,'C',1);    

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFillColor(217,217,217);
    $pdf->SetDrawColor(255,255,255);
    $pdf->SetWidths(array(5,20,8,100,30,30));

    $subtotal = 0;
    $i = 0;
    foreach ($po["particularDetails"] as $key=>$value) {      
      if ($pdf->GetY() == 255.00125||$pdf->GetY() == 250.00125||$pdf->GetY() == 251.00125){
          $pdf->setFont("Arial","B",8);
          $pdf->SetTextColor(255,255,255);
          $pdf->SetFillColor(251,49,40);
          $pdf->SetDrawColor(255,255,255);      
          $pdf->Cell(5,8,"No.",1,0,'C',1);
          $pdf->Cell(20,8,"Part No.",1,0,'C',1);
          $pdf->Cell(8,8,"Qty.",1,0,'C',1);          
          $pdf->Cell(100,8,"Description of goods",1,0,'C',1);          
          $pdf->Cell(30,8,"Unit Price(".$currency.")",1,0,'C',1);
          $pdf->Cell(30,8,"Total Price(".$currency.")",1,1,'C',1);
          
        }
        $amount=$unitprice=$sub=0;
        /*if($currency==="EURO"){
          $unitprice=$value['unitpriceeuro'];
          $sub=$value['partTotAmteuro'];
          $amount = $value['unitpriceeuro']*$value['qty'];
        }else{
          $unitprice=$value['unitpriceinr'];
          $sub=$value['partTotAmtinr'];
          $amount = $value['unitpriceinr']*$value['qty'];
        }*/
        $unitprice=$value['unitprice'];
        $sub=$value['partTotAmt'];
        $amount = $value['unitprice']*$value['qty'];
        $i+=1;
               
        $subtotal+=$value['partTotAmt'];
        $pdf->Row(array($i,($value['part_number']=="")?"Part not found":$value['part_number'],
        $value['qty'],
        ($value['description']=="")?"Desc. not found":$value['description'],
        number_format($unitprice, 2, '.', ','),number_format($sub, 2, '.', ',')));
        
    }

    $pdf->Cell(193,8,"===================================================================================",1,1,'C',true);
    
    $pdf->Cell(5,8,"",1,0,'C',1);
    $pdf->Cell(20,8,"",1,0,'C',1);
    $pdf->Cell(8,8,"",1,0,'C',1);      
    $pdf->Cell(100,8,"Subtotal in ".$currency,1,0,'C',1);
    
    $pdf->Cell(30,8,"",1,0,'C',1);
    $pdf->Cell(30,8,number_format($subtotal, 2, '.', ','),1,1,'C',1);
    

    $pdf->Cell(5,8,"",1,0,'C',1);
    $pdf->Cell(20,8,"",1,0,'C',1);
    $pdf->Cell(8,8,"",1,0,'C',1);    
    if($po["poDetails"]['currency']=="eur"){
      $pdf->Cell(100,8,"Discount(".$po["poDetails"]['discount']."%)",1,0,'C',1);
    }else{
      $pdf->Cell(100,8,"Discount(".$po["poDetails"]['discount']."%)",1,0,'C',1);
    }
    $pdf->Cell(30,8,"",1,0,'C',1);
    $pdf->Cell(30,8,number_format($subtotal*($po["poDetails"]['discount']/100), 2, '.', ','),1,1,'C',1);
    
    $subtotal-=($subtotal*($po["poDetails"]['discount']/100));

    
    $pdf->Cell(5,8,"",1,0,'C',1);
    $pdf->Cell(20,8,"",1,0,'C',1);
    $pdf->Cell(8,8,"",1,0,'C',1);    
    $pdf->Cell(100,8,"Packing & forwarding amount in(".$currency.")",1,0,'C',1);    
    $pdf->Cell(30,8,"",1,0,'C',1);
    $pdf->Cell(30,8,number_format($po["poDetails"]["package"], 2, '.', ','),1,1,'C',1);
    $subtotal+=$po["poDetails"]["package"];
    $igst = 0;
    if($currency!="EURO"){
      $pdf->Cell(5,8,"",1,0,'C',1);
      $pdf->Cell(20,8,"",1,0,'C',1);
      $pdf->Cell(8,8,"",1,0,'C',1);    
      $pdf->Cell(100,8,"IGST(".$po["poDetails"]["igst"]."%)",1,0,'C',1);      
      $pdf->Cell(30,8,"",1,0,'C',1);
      $igst = (($subtotal+$po["poDetails"]["package"])*($po["poDetails"]["igst"]/100));
      $pdf->Cell(30,8,number_format($igst, 2, '.', ','),1,1,'C',1); 
    }

    $pdf->Cell(5,8,"",1,0,'C',1);
    $pdf->Cell(20,8,"",1,0,'C',1);
    $pdf->Cell(8,8,"",1,0,'C',1);    
    $pdf->Cell(100,8,"Total amount in (".$currency.")",1,0,'C',1);
    $total = $subtotal+($subtotal*($po["poDetails"]["igst"]/100));
    $pdf->Cell(30,8,"",1,0,'C',1);
    $pdf->Cell(30,8,number_format(($total), 2, '.', ','),1,1,'C',1);
    $pdf->Cell(193,8,"===================================================================================",1,1,'C',true);
   
    $pdf->Cell(190,10,"",1,1,'C');
    $y=$pdf->GetY();
    if($y>=230.00125){
      $pdf->AddPage();
    }
    

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(30,5,"THE PRICE IS VALID: ",0,0,"L");
    
    
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);

    $pdf->Cell(110,5,$po["poDetails"]['po_validity'],0,1,"L");

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(70,5,"DELIVERY TERMS AS PER INCOTERMS 2010: ",0,0,"L");
    
    
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);

    $pdf->Cell(70,5,$po["poDetails"]['delivery_terms'],0,1,"L");

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(30,5,"PAYMENT TERMS:",0,1,"L");
    
    
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38); 
    $pdf->Cell(110,5,$po["poDetails"]['payment_terms'],0,1,"L");

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(190,5,"TERMS AND CONDITION:",0,1,"L"); 
    
    
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);
    $pdf->Multicell(0,2,$po["poDetails"]["terms"],0,'L',0);

    $pdf->Cell(190,5,"Thank you",0,1,"L");
    $pdf->Cell(190,5,"With warm regards,",0,1,"L");    
    $pdf->Cell(190,5,"igm Roboticsystems India Pvt. Ltd.",0,1,"L");

    echo $pdf->Output();
  }
  
  function generatePDF1($po){    
    $pdf = new POPdf();
    $pdf->setFont("Arial","B",8);
    $pdf->SetTextColor(0,0,0);
    $pdf->addPage();

    $pdf->AliasNbPages();    
    $pdf->SetAutoPageBreak(true,25);

    $st = $pdf->GetY();
    $pdf->setFont("Arial","",8);
    $pdf->Cell(110,5,"To,","",0,'L');
    $pdf->setFont("Arial","",8);    
    $pdf->Cell(80,5,"igm Roboticsystems India Pvt. Ltd.","",1,'L');
    $pdf->setFont("Arial","",8);
    $pdf->Cell(110,5,$po["vendorDetails"]["company"],"",1,'L');
    $pdf->Cell(110,5,"Attn.: ".$po["vendorDetails"]["person"],"",0,'L');
    $pdf->setFont("Arial","",8);
    $pdf->Cell(80,5,"Contact:  Sarika Dive","",1,'L');
    $pdf->setFont("Arial","",8);
    $pdf->Cell(110,5,$po["vendorDetails"]["addressline1"].",","",0,'L');
    $pdf->setFont("Arial","",8);
    $pdf->Cell(80,5,"Mobile: +91 7738155709","",1,'L');
    $pdf->setFont("Arial","",8);
    $pdf->Cell(110,5,$po["vendorDetails"]["addressline2"].",","",0,'L');
    $pdf->setFont("Arial","",8);
    $pdf->Cell(80,5,"E-mail: sarika.dive@igm-india.com","",1,'L');
    $pdf->setFont("Arial","",8);
    $pdf->Cell(110,5,$po["vendorDetails"]["city"].",","",1,'L');    
    $pdf->setFont("Arial","",8);
    $date = new DateTime();
    $pdf->Cell(80,5,"Date: ".$date->format('d/M/Y'),"",1,'L');

    $pdf->setFont("Arial","B",8);
    $pdf->SetTextColor(251,49,40);         
    $pdf->Cell(25,15,"Purchase order","",0,'L');
    $pdf->Cell(60,15,"No. P-".$po["poDetails"]['po_no'],"",1,'L');

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38); 
    $pdf->Cell(120,5,"Your reference no.: ".$po["poDetails"]["q_no"]."  DTD. ".$po["poDetails"]['q_date'],"",1,'L');    

    
    $pdf->MultiCell(190,10,"We thank you for your inquiry and we hereby offer to you the following goods and/or services as per our general terms and conditions.",0,'L',0);
    $pdf->LN(5);

    $pdf->setFont("Arial","B",8);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFillColor(251,49,40);
    $pdf->SetDrawColor(255,255,255);

    $pdf->Cell(5,8,"No.",1,0,'C',1);
    $pdf->Cell(20,8,"Part No.",1,0,'C',1);
    $pdf->Cell(8,8,"Qty.",1,0,'C',1);    
    $pdf->Cell(100,8,"Description of goods",1,0,'C',1);
    $currency = ($po["poDetails"]['currency']=="eur")?"EURO":"INR";      
    $pdf->Cell(30,8,"Unit Price(".$currency.")",1,0,'C',1);
    $pdf->Cell(30,8,"Total Price(".$currency.")",1,1,'C',1);    

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFillColor(217,217,217);
    $pdf->SetDrawColor(255,255,255);
    $pdf->SetWidths(array(5,20,8,100,30,30));

    $subtotal = 0;
    $i = 0;
    foreach ($po["particularDetails"] as $key=>$value) {      
      if ($pdf->GetY() == 255.00125||$pdf->GetY() == 250.00125||$pdf->GetY() == 251.00125){
          $pdf->setFont("Arial","B",8);
          $pdf->SetTextColor(255,255,255);
          $pdf->SetFillColor(251,49,40);
          $pdf->SetDrawColor(255,255,255);      
          $pdf->Cell(5,8,"No.",1,0,'C',1);
          $pdf->Cell(20,8,"Part No.",1,0,'C',1);
          $pdf->Cell(8,8,"Qty.",1,0,'C',1);          
          $pdf->Cell(100,8,"Description of goods",1,0,'C',1);          
          $pdf->Cell(30,8,"Unit Price(".$currency.")",1,0,'C',1);
          $pdf->Cell(30,8,"Total Price(".$currency.")",1,1,'C',1);
          
        }
        $amount=$unitprice=$sub=0;
        /*if($currency==="EURO"){
          $unitprice=$value['unitpriceeuro'];
          $sub=$value['partTotAmteuro'];
          $amount = $value['unitpriceeuro']*$value['qty'];
        }else{
          $unitprice=$value['unitpriceinr'];
          $sub=$value['partTotAmtinr'];
          $amount = $value['unitpriceinr']*$value['qty'];
        }*/
        $unitprice=$value['unitprice'];
        $sub=$value['partTotAmt'];
        $amount = $value['unitprice']*$value['qty'];
        $i+=1;
               
        $subtotal+=$value['partTotAmt'];
        $pdf->Row(array($i,($value['part_number']=="")?"Part not found":$value['part_number'],
        $value['qty'],
        ($value['description']=="")?"Desc. not found":$value['description'],
        number_format($unitprice, 2, '.', ','),number_format($sub, 2, '.', ',')));
        
    }

    $pdf->Cell(193,8,"===================================================================================",1,1,'C',true);
    
    $pdf->Cell(5,8,"",1,0,'C',1);
    $pdf->Cell(20,8,"",1,0,'C',1);
    $pdf->Cell(8,8,"",1,0,'C',1);      
    $pdf->Cell(100,8,"Subtotal in ".$currency,1,0,'C',1);
    
    $pdf->Cell(30,8,"",1,0,'C',1);
    $pdf->Cell(30,8,number_format($subtotal, 2, '.', ','),1,1,'C',1);
    

    $pdf->Cell(5,8,"",1,0,'C',1);
    $pdf->Cell(20,8,"",1,0,'C',1);
    $pdf->Cell(8,8,"",1,0,'C',1);    
    if($po["poDetails"]['currency']=="eur"){
      $pdf->Cell(100,8,"Discount(".$po["poDetails"]['discount']."%)",1,0,'C',1);
    }else{
      $pdf->Cell(100,8,"Discount(".$po["poDetails"]['discount']."%)",1,0,'C',1);
    }
    $pdf->Cell(30,8,"",1,0,'C',1);
    $pdf->Cell(30,8,number_format($subtotal*($po["poDetails"]['discount']/100), 2, '.', ','),1,1,'C',1);
    
    $subtotal-=($subtotal*($po["poDetails"]['discount']/100));

    
    $pdf->Cell(5,8,"",1,0,'C',1);
    $pdf->Cell(20,8,"",1,0,'C',1);
    $pdf->Cell(8,8,"",1,0,'C',1);    
    $pdf->Cell(100,8,"Packing & forwarding amount in(".$currency.")",1,0,'C',1);    
    $pdf->Cell(30,8,"",1,0,'C',1);
    $pdf->Cell(30,8,number_format($po["poDetails"]["package"], 2, '.', ','),1,1,'C',1);
    $subtotal+=$po["poDetails"]["package"];
    $igst = 0;
    if($currency!="EURO"){
      $pdf->Cell(5,8,"",1,0,'C',1);
      $pdf->Cell(20,8,"",1,0,'C',1);
      $pdf->Cell(8,8,"",1,0,'C',1);    
      $pdf->Cell(100,8,"IGST(".$po["poDetails"]["igst"]."%)",1,0,'C',1);      
      $pdf->Cell(30,8,"",1,0,'C',1);
      $igst = (($subtotal+$po["poDetails"]["package"])*($po["poDetails"]["igst"]/100));
      $pdf->Cell(30,8,number_format($igst, 2, '.', ','),1,1,'C',1); 
    }

    $pdf->Cell(5,8,"",1,0,'C',1);
    $pdf->Cell(20,8,"",1,0,'C',1);
    $pdf->Cell(8,8,"",1,0,'C',1);    
    $pdf->Cell(100,8,"Total amount in (".$currency.")",1,0,'C',1);
    $total = $subtotal+($subtotal*($po["poDetails"]["igst"]/100));
    $pdf->Cell(30,8,"",1,0,'C',1);
    $pdf->Cell(30,8,number_format(($total), 2, '.', ','),1,1,'C',1);
    $pdf->Cell(193,8,"===================================================================================",1,1,'C',true);
   
    $pdf->Cell(190,10,"",1,1,'C');
    $y=$pdf->GetY();
    if($y>=230.00125){
      $pdf->AddPage();
    }
    

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(30,5,"THE PRICE IS VALID: ",0,0,"L");
    
    
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);

    $pdf->Cell(110,5,$po["poDetails"]['po_validity'],0,1,"L");

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(70,5,"DELIVERY TERMS AS PER INCOTERMS 2010: ",0,0,"L");
    
    
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);

    $pdf->Cell(70,5,$po["poDetails"]['delivery_terms'],0,1,"L");

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(30,5,"PAYMENT TERMS:",0,1,"L");
    
    
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);	
    $pdf->Cell(110,5,$po["poDetails"]['payment_terms'],0,1,"L");

    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(251,49,40);
    $pdf->Cell(190,5,"TERMS AND CONDITION:",0,1,"L");	
    
    
    $pdf->setFont("Arial","",8);
    $pdf->SetTextColor(38,38,38);
	  $pdf->Multicell(0,2,$po["poDetails"]["terms"],0,'L',0);

    $pdf->Cell(190,5,"Thank you",0,1,"L");
    $pdf->Cell(190,5,"With warm regards,",0,1,"L");    
    $pdf->Cell(190,5,"igm Roboticsystems India Pvt. Ltd.",0,1,"L");

    echo $pdf->Output();
  }

  function partsForPOParticular($connection, $params){    
    $query="SELECT id,part_number,description,unit_price_euro,unit_price_inr FROM inventory_parts
    WHERE part_number LIKE '".$params['term']['term']."%'";      
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

  function vendorsForPO($connection, $params){
    $query="SELECT id,company_name, city  FROM vendors WHERE company_name LIKE '%".$params["term"]["term"]."%'";
    $result = $connection->query($query);
    $data = array();
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){                    
        $data[] = array('id'=>$row['id'],'company'=>$row['company_name']."-".$row['city']);
      }
    }      
    echo json_encode($data);
  }

  function addPO($connection, $params){ 
    //vendor,ponumber,podate,poValidityDate,quotenumber,quotationdate,pack,currency,eurorate,discount,igst,
    //deliveryTerms,paymentTerms,terms     
    $q = "INSERT INTO purchaseorder(po_no, projectno, vendor_id, po_date, po_validity, q_no, q_date, currency, 
    eurorate, package, payment_terms, delivery_terms, discount, igst, terms, 
    created_by, created_on, modified_by, modified_on)
    VALUES
    (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,(select NOW()),?,(select NOW()))";
    $stmt = $connection->prepare($q);
    $stmt->bind_param("ssisssssddssddsss", $po_no, $projectno, $vendor_id, $po_date, $po_validity, $q_no, 
    $q_date, $currency, $eurorate, $package, $payment_terms, $delivery_terms, $discount, $igst, $terms, 
    $cb, $mb);      
    $po_no = $params["ponumber"];
    $projectno = $params["projectno"];
    $vendor_id = $params["vendor"];
    $po_date = $params["podate"];
    $po_validity = $params["poValidityDate"];
    $q_no = $params["quotenumber"];
    $q_date = $params["quotationdate"];
    $currency = $params["currency"];
    $eurorate = $params["eurorate"];
    $package = $params["pack"];
    $payment_terms = $params["paymentTerms"];
    $delivery_terms = $params["deliveryTerms"];
    $discount = $params["discount"];
    $igst = $params["igst"];
    $terms = $params["terms"];
    $cb = $mb = $_COOKIE["usermail"];
    if($stmt->execute()){
      $poId = getPoId($connection, $params["ponumber"]);
      if(addPoProducts($connection, $poId, $params) && addPOTrack($connection, $poId, $params) ){
        return true;
      }
    }else{
	    error_log(date("Y-m-d h:m:s")."ERROR when adding PO.\nMessage==> ".$stmt->error."\n",3,"../log/php_error.log");
      return false;
    }
  }

  function getPoId($connection, $pono){      
    $q = "SELECT id FROM purchaseorder WHERE po_no='".$pono."'";
    $result = $connection->query($q);
    $data=0;
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
        $data = $row["id"];
      }
    }
    return $data;
  }

  function addPartToMaster($connection, $params){      
    $q = "INSERT INTO inventory_parts(part_number,description,unit_price_euro,unit_price_inr,landed_cost,
    location,min,total,country,created_by,created_on,modified_by,modified_on)
    VALUES
    (?,?,?,?,0,?,?,0,?,?,(SELECT NOW()),?,(SELECT NOW()))";
    $stmt = $connection->prepare($q);      
    $stmt->bind_param("ssddsisss", $part_number,$description,$unit_price_euro,$unit_price_inr,$location,
    $min,$country,$cb,$mb);
    $part_number = $params["partnumber"];
    $description = $params["description"];
    $unit_price_euro = $params["europrice"];
    $unit_price_inr = $params["inrprice"];
    $location = $params["location"];
    $min = $params["min"];
    $country = $params["country"];
    $cb = $mb = $_COOKIE["usermail"];
    if($stmt->execute()){
      return true;
    }else{
      error_log(date("Y-m-d h:m:s")." ERROR when adding new part using PO.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
      return false;
    }
  }

    
  function addPoProducts($connection, $poId, $params){      
    $success = false;
    $q = "INSERT INTO po_products (poId, partId, qty, unitprice, partTotAmt)
     VALUES (?,?,?,?,?)";
    $stmt = $connection->prepare($q);
    $stmt->bind_param("isidd", $poId, $partId, $qty, $unitprice, $partTotAmt);
    $poId = $poId;      
    $index = explode(',',$params["ids"]);
    foreach ($index as $value){            
      $partId = $params["partId".$value];
      $qty = $params["quantity".$value];
      $unitprice = $params["up".$value];
      $partTotAmt = $params["st".$value];
      /*$unitpriceeuro = $params["upe".$value];
      $unitpriceinr = $params["upi".$value];
      $partTotAmteuro = $params["ste".$value];
      $partTotAmtinr = $params["sti".$value];*/
      if($stmt->execute()){
        $success = true;
      }else{
        error_log(date("Y-m-d h:m:s")." ERROR when adding PO particular.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
        $success = false;
      }
    }
    if($success){
      return true;
    }else{
      return false;
    }
  }

  function addPOTrack($connection, $poId, $params){      
    $success = false;
    $q = "INSERT INTO po_tracking (po_no,part_no,ordered,received)
    VALUES (?,?,?,0)";
    $stmt = $connection->prepare($q);
    $stmt->bind_param("iii", $poId, $partId, $ordered);
    $poId = $poId;
    $index = explode(',',$params["ids"]);
    foreach ($index as $value){        
      $partId = $params["partId".$value];
      $ordered = $params["quantity".$value];        
      if($stmt->execute()){
        $success = true;
      }else{
        error_log(date("Y-m-d h:m:s")." ERROR when adding PO track.\n Message==> ".$stmt->error."\n", 3, "../log/php_error.log");
        $success = false;
      }
    }
    if($success){
      return true;
    }else{
      return false;
    }
  }

  function editPo($connection, PurchaseOrder $po){
      $q = "UPDATE purchaseorder SET
      po_no=?, projectno=?, vendor_id=?,po_date =?, po_validity=?,  q_no=?, q_date=?, currency=?, eurorate=?, package=?,
      payment_terms=?, delivery_terms = ?, discount=?, igst=?, terms=?, modified_by=?, modified_on=?
      WHERE id= ?";
      $stmt = $connection->prepare($q);
      $stmt->bind_param("ssisssssddssiisssi", $pono, $projectno, $vendor,$po_date,$po_validity, $qno, $qdate,$currency, $eurorate, $package,$paymentTerms,$deliveryTerms,$discount,$igst, $terms, $mb, $mo,$id);
      $pono = $po->getPurchaseOrderNo();
      $projectno = $po->getProjectNo();
      $vendor = $po->getTo();
      $po_date = $po->getPoDate();
      $po_validity = $po->getPoValidity();
      $qno = $po->getQuotationId();
      $qdate = $po->getQuotationDate();
      $currency = $po->getCurrency();
      $eurorate = $po->getEurorate();
      $package = $po->getPackage();        
      $paymentTerms = $po->getPaymentTerms();
      $deliveryTerms = $po->getDeliveryTerms();
      $discount = $po->getDiscount();        
      $igst = $po->getIgst();
      $terms = $po->getTerms();
      $mb = $po->getMb();
      $mo = $po->getMo();
      $id = $po->getId();
      if($stmt->execute()){
        return true;
      }else{
        return false;
      }
  }

  function addPoProduct($connection, $part){
      $q = "INSERT INTO po_products (poId, partId, qty, unitprice, partTotAmt) VALUES (?,?,?,?,?)";
      $stmt = $connection->prepare($q);
      $stmt->bind_param("isidd", $poId, $partId, $qty, $unitprice, $partTotAmt);
      $poId = $part->getPoId();
      $partId = $part->getPartId();
      $qty = $part->getQty();
      $unitprice = $part->getUnitprice();
      $partTotAmt = $part->getPartTotAmt();
      if($stmt->execute()){
        return true;          
      }else{
        return false;
      }
  }

  function editPoProduct($connection, $part){
      $q = "UPDATE po_products SET poId=?, partId=?, qty=?, unitprice=?, partTotAmt=? WHERE id=?";
      $stmt = $connection->prepare($q);
      $stmt->bind_param("isiddi", $poId, $partId, $qty, $unitprice, $partTotAmt,$id);
      $poId = $part->getPoId();
      $partId = $part->getPartId();
      $qty = $part->getQty();
      $unitprice = $part->getUnitprice();
      $partTotAmt = $part->getPartTotAmt();
      $id = $part->getId();
      if($stmt->execute()){
         $q = "UPDATE po_tracking SET ordered=? WHERE po_no=? AND part_no=?";
        $stmt = $connection->prepare($q);
        $stmt->bind_param("iii", $ordered, $po, $part);  
        $ordered = $part->getQty();
        $po = $part->getPoId();
        $part = $part->getPartId();        
        if($stmt->execute()){
          return true;
        }else{
          return false;  
        }          
      }else{
        return false;
      }
  }

  function getPoPart($connection, $params){
    $query="SELECT * FROM po_products WHERE id = ".$params["id"];
    $result = $connection->query($query);
    $data = "";
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
        $data = $row;        
      }
    }
    echo json_encode($data);
  }    

  function getPO($connection, $params){
    $query="select po.id, po.q_no,po.po_no, po.projectno, 
    po.po_date, 
    DATE_FORMAT(po.po_validity, '%d-%m-%Y') as po_validity, 
    po.payment_terms, po.delivery_terms,
    po.discount, po.igst, po.terms, po.q_no, 
    DATE_FORMAT(po.q_date, '%d-%m-%Y') as q_date, 
    po.currency, po.eurorate, po.package,
    v.company_name,    
    ip.part_number, ip.description, pop.id as particularId, pop.partId, pop.qty,  pop.unitprice, pop.partTotAmt
    from purchaseorder po
    LEFT JOIN po_products pop on po.id=pop.poId
    LEFT JOIN inventory_parts ip on pop.partId=ip.id
    LEFT JOIN vendors v on po.vendor_id=v.id
    WHERE po.id= ".$params['id']."";
    $result = $connection->query($query);
    $data = $poDetails = "";$particularDetails=[];
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
        $poDetails=array("po_no"=>$row['po_no'],"po_date"=>$row["po_date"],"projectno"=>$row["projectno"],
          "q_date"=>$row["q_date"], "q_no"=>$row["q_no"], "currency"=>$row["currency"],
          "company_name"=>$row["company_name"],
          "discount"=>$row["discount"], "igst"=>$row["igst"], "package"=>$row["package"],
          "po_validity"=>$row["po_validity"], "terms"=>$row["terms"], "delivery_terms"=>$row["delivery_terms"],
          "payment_terms"=>$row["payment_terms"]);
        $particularDetails[]=array("particularId"=>$row["particularId"],  "part_number"=>$row["part_number"], "description"=>$row["description"], 
          "unitprice"=>$row["unitprice"], "qty"=>$row["qty"], "partTotAmt"=>$row["partTotAmt"]);
      }
    }
    $data = array("poDetails"=>$poDetails,"poParticulars"=>$particularDetails);
    echo json_encode($data);
  }

  function getPOPrint($connection, $id){
    $query="select po.po_no, po.po_date, po.projectno, po.q_date, po.q_no,
    po.currency, po.discount, po.igst, po.package,  
    po.po_validity, po.terms, po.delivery_terms, po.payment_terms,
    v.company_name as company, v.contact_person1_name as person, v.addressline1, v.addressline2,v.city,
    ip.part_number, ip.description, pp.unitprice, pp.qty, pp.partTotAmt
    from purchaseorder po LEFT JOIN po_products pp on po.id=pp.poId
    LEFT JOIN inventory_parts ip on pp.partId=ip.id
    LEFT JOIN vendors v on po.vendor_id=v.id
    WHERE po.id=".$id."";
    $result = $connection->query($query);
    $data = array();
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
        $poDetails=array("po_no"=>$row['po_no'],"po_date"=>$row["po_date"],"projectno"=>$row["projectno"],
          "q_date"=>$row["q_date"], "q_no"=>$row["q_no"], "currency"=>$row["currency"],
          "discount"=>$row["discount"], "igst"=>$row["igst"], "package"=>$row["package"],
          "po_validity"=>$row["po_validity"], "terms"=>$row["terms"], "delivery_terms"=>$row["delivery_terms"],
          "payment_terms"=>$row["payment_terms"]
        );
        $vendorDetails = array("company"=>$row['company'],"person"=>$row['person'], 
          "addressline1"=>$row['addressline1'], "addressline2"=>$row['addressline2'], "city"=>$row['city']);
        $particularDetails[]=array("part_number"=>$row["part_number"], "description"=>$row["description"], 
          "unitprice"=>$row["unitprice"], "partTotAmt"=>$row["partTotAmt"]
        );
      }
    }
    $data = array("poDetails"=>$poDetails,"vendorDetails"=>$vendorDetails,"particularDetails"=>$particularDetails);
    return $data;
  }

  function getPOPrintByNo($connection, $id){
    $query="SELECT * FROM purchaseorder WHERE po_no = '".$id."'";
    $result = $connection->query($query);
    $data = array();
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
        $query1="SELECT * FROM po_products WHERE poId = ".$row["id"]."";
        $result1 = $connection->query($query1);
        $data1 = array();
        if($result1->num_rows>0){
          while($row1=$result1->fetch_assoc()){
            $data1[] = array("id"=>$row1["id"],"poId"=>$row1["poId"], "partId"=>$row1["partId"], "qty"=>$row1["qty"],
             "rate"=>$row1["unitprice"], "amount"=>$row1["partTotAmt"]);
          }
        }
        //po_no, vendor_id, q_no, q_date, terms, created_by, created_on, modified_by, modified_on
        $data[] = array("id"=>$row["id"], "pono"=>$row["po_no"], "projectno"=>$row["projectno"], "to"=>$row["vendor_id"],"po_date"=>$row["po_date"],
        "po_validity"=>$row["po_validity"],"payment_terms"=>$row["payment_terms"],"delivery_terms"=>$row["delivery_terms"],"terms"=>$row["terms"],
        "qid"=>$row["q_no"], "qdate"=>$row["q_date"], "poparts"=>$data1,"eurorate"=>$row['eurorate'], "package"=>$row['package'],
        "cb"=>$row["created_by"],"co"=>$row["created_on"], "mb"=>$row["modified_by"], "mo"=>$row["modified_on"]);
      }
    }
    return $data;
  }

  function updatePOTrack($connection, $params){         
    $query = "UPDATE  po_tracking SET ordered=?, received=? WHERE po_track_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("iii", $ordered, $received, $po_track_id);
    $ordered = $params["ordered"];
    $received = $params["received"];
    $po_track_id = $params["poTrackId"];
    if($stmt->execute()){
       echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('Updated')
          window.location.href='../pages/purchaseorder.php';
          </SCRIPT>");
    }else{
       echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('Error')
          window.location.href='../pages/purchaseorder.php';
          </SCRIPT>");
    }
    
          
  }

  function getPOTrack($connection, $id){
    $data = "";
    $query = "SELECT * FROM po_tracking WHERE po_track_id = $id";
    $result = $connection->query($query);
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){                    
            $data = array('po_track_id' => $row["po_track_id"],
              'po_no'=>getPONo($connection,$row["po_no"]),
              'part_no'=>getPartNo($connection,$row["part_no"]),
              'ordered'=>$row["ordered"],
              'received'=>$row["received"]);
        }
    }
    
    echo json_encode($data);

  }

  function getVendor($connection, $id){
    $query="SELECT * FROM vendors WHERE id=".$id;
    $result = $connection->query($query);
        $data = array();
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
        $data[] = array('id'=>$row['id'],'company'=>$row['company_name'],
        'addressline1' => $row['addressline1'],'addressline2' => $row['addressline2'],'city' => $row['city']
        ,'country' => $row['country'],
        'person1'=>$row['contact_person1_name']);
      }
    }
    return $data;
  }

  function getPONo($connection,$id){
    $po = "";
    $query="SELECT * FROM purchaseorder WHERE id=$id";
    $result = $connection->query($query);
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
        $po = $row["po_no"];
      }
    }      
    return $po;
  }

  function getPartNo($connection, $id){
    $partsNo = "";
    $query="SELECT * FROM inventory_parts WHERE id=$id";
    $result = $connection->query($query);
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
        $partsNo = $row['part_number'];
      }
    }      
    return $partsNo;
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

  function getAllPO($connection,$params){
    $query="select po.id, po.po_no, po.q_no, po.currency, v.company_name as vendor,
    TRUNCATE(((po.igst/100)*(sum(pp.partTotAmt)-(sum(pp.partTotAmt)*(po.discount/100))+po.package))+(sum(pp.partTotAmt)-(sum(pp.partTotAmt)*(po.discount/100))+po.package),2) as totAmt
    from 
    purchaseorder po left join po_products pp on po.id=pp.poId
    left join vendors v on po.vendor_id=v.id  group by pp.poId 
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
    $query="select po.id, po.po_no, po.q_no, po.currency, v.company_name as vendor,
    TRUNCATE(((po.igst/100)*(sum(pp.partTotAmt)-(sum(pp.partTotAmt)*(po.discount/100))+po.package))+(sum(pp.partTotAmt)-(sum(pp.partTotAmt)*(po.discount/100))+po.package),2) as totAmt
    from 
    purchaseorder po left join po_products pp on po.id=pp.poId
    left join vendors v on po.vendor_id=v.id  group by pp.poId 
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

  function getAllPoTrack($connection,$params){
    $data = [];
    $totalRecords = 0;
    $query = "SELECT pt.po_track_id, p.po_no,ip.part_number,ordered,received FROM po_tracking pt LEFT JOIN purchaseorder p on pt.po_no=p.id LEFT JOIN inventory_parts ip ON pt.part_no=ip.id";      
    $result = $connection->query($query);
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){                    
            $data[] = $row;
        }
    }
    $totalRecords=count($data);
    $data = [];
    $query = "SELECT pt.po_track_id, p.po_no,ip.part_number,ordered,received FROM po_tracking pt LEFT JOIN "
    ."purchaseorder p on pt.po_no=p.id LEFT JOIN inventory_parts ip ON pt.part_no=ip.id limit ".$params['start'].","
    .$params['length']."";   
    $result = $connection->query($query);
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){                    
            $data[] = $row;
        }
    }
    $response = array("draw"=>$params['draw'],"iTotalRecords"=>$totalRecords,"iTotalDisplayRecords"=>$totalRecords,"aaData"=>$data);
    echo json_encode($response);
  }

  function getPOByNumber($connection, $pono){
    $query="SELECT * FROM purchaseorder WHERE po_no = '".$pono."'";
    $result = $connection->query($query);
    $data = array();
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
        $data[] = $row['id'];
      }
    }
    return $data[0];
  }

  function deletePO($connection, $id){
    $query="DELETE FROM purchaseorder WHERE id =?";
    $stmt = $connection->prepare($query);
      $stmt->bind_param("i", $id);
      $id = $id;
      if($stmt->execute()){
        deletePoParts($connection, $id);
        // return true;
      }else{
        return false;
      }
  }

  function deletePoPart($connection, $id){
    $query="DELETE FROM po_products WHERE id =?";
    $stmt = $connection->prepare($query);
      $stmt->bind_param("i", $id);
      $id = $id;
      if($stmt->execute()){
        return true;
      }else{
        return false;
      }
  }

  function deletePoParts($connection, $id){
    $query="DELETE FROM po_products WHERE poId = ?";
    $stmt = $connection->prepare($query);
      $stmt->bind_param("i", $id);
      $id = $id;
      if($stmt->execute()){
        return true;          
      }else{
        return false;
      }
  }

  function getLastPo($connection){
    $query="SELECT po_no FROM purchaseorder order by id desc limit 1";
    $result = $connection->query($query);
    $data = "";
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
        $data = $row['po_no'];
      }
    }      
    echo $data;
  }

  function getVendorById($connection, $id){
    $query="SELECT * FROM vendors WHERE id=".$id."";
    $result = $connection->query($query);
    $data = array();
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
        $data[] = array('id' => $row['id'],'company' => $row['company_name'],
        'addressline1' => $row['addressline1'],'addressline2' => $row['addressline2'],'city' => $row['city']
        ,'country' => $row['country']);
      }
    }
    return $data;
  }
    
  function addNewPart($connection, $partNo, $quantity, $description, $unitpriceEur,$unitpriceInr, $cb, $co){
    $q = "INSERT INTO inventory_parts
    (part_number, description, unit_price_euro, unit_price_inr, landed_cost, location, min, total, created_by, created_on, modified_by, modified_on, country)
    VALUES
    (?,?,?,?,?,?,?,?,?,(SELECT NOW()),?,(SELECT NOW()),?)";
    $stmt = $connection->prepare($q);      
    $stmt->bind_param("ssdddsiisss", $partno, $desc, $unitpriceeuro,$unitpriceinr,$landedcost, $location, $min, $total, $cb, $mb, $country);
    $partno = $partNo;
    $desc = $description;
    $unitpriceeuro = $unitpriceEur;
    $unitpriceinr = $unitpriceInr;
    $landedcost = 0;
    $location = "";
    $min = 1;
    $total = 0;
    $cb = $mb = $_COOKIE["usermail"];
    $country = "";
    if($stmt->execute()){
      $query="SELECT id FROM inventory_parts WHERE part_number='".$partNo."'";
      $result = $connection->query($query);        
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          return $row['id'];
        }
      }
    }else{
      return "0";
    }
  }  
?>