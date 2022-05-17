<?php
	// $_POST["to"] $_POST["dnno"] $_POST["refno"]
	// $_POST["partno"] $_POST["reason"] $_POST["qty"] $_POST["rate"] $_POST["total"]
	// * DebitNote($id,$dnno,$to,$refno,ArrayObject $dnparts,$cb,$co,$mb,$mo)
 	// * getId getDnno getTo getRefno getDnparts getCb getCo
	// * DnParts($id,  $dnId,$partId,$qty,$unitprice,$partTotAmount)
	// * getId getDnId getPartId getReason getQty getUnitprice getPartTotAmount

	require('db.php');
	require('data/dnParts.php');
	require('data/debitNoteObject.php');
	require("../phplibraries/fpdf.php");
	require_once "updateServerDBVersion.php";

	class DNpdf extends FPDF  {

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
            $this->SetDrawColor(255,255,255);$this->Cell(10,10,"Pos.",1,0,'C',true);
			$this->Cell(20,8,"Part no.",1,0,'C',true);
			$this->Cell(10,8,"Qty.",1,0,'C',true);
			//$this->Cell(20,8,"Unit",1,0,'C',true);
			$this->Cell(60,8,"Description of Goods",1,0,'C',true);
			$this->Cell(30,8,"Unit Price INR",1,0,'C',true);
			$this->Cell(30,8,"Total Price INR",1,1,'C',true);

            $this->setFont("Arial","",8);
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
	      $this->Cell(90,5,' form ID: FOi-DN-04',0,1,'R');

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
		$dn = new DN();
		$date = new DateTime();
		$cb = $mb = isset($_COOKIE["usermail"])?$_COOKIE["usermail"]:"support@metroservisol.com";
		// $date->format('Y-m-d H:i:s')
		if(isset($_POST["add"])){
			$dnParts = new ArrayObject();
			$list = array();
			$arrayId = explode(",",$_POST["ids"]);
			foreach ($arrayId as $key => $value) {

		        $partID = explode("-",$_POST['partno'.$value]);

		        $a = array("partNo"=>$partID[1],"qty"=>$_POST['qty'.$value],"reason"=>$_POST['reason'.$value],
		        "rate"=>$_POST['rate'.$value],"total"=>$_POST['total'.$value]);

		        array_push($list, $a);

		        $dnParts[$key] = new DnParts(0,$partID[0],$_POST['reason'.$value],
		        	$_POST['qty'.$value],$_POST['rate'.$value],$_POST['total'.$value]);
	      	}
			// $dnPartObject = new DnParts($dnId,$partId,$qty,$unitprice,$partTotAmount);
			//$_POST["dnno"] = "DN001"; projectno courier dispatchno
			$dnObject = new DebitNote($_POST["dnno"],$_POST["projectno"],$_POST["to"],$_POST["refno"],
			$_POST["courier"],$_POST["dispatchno"],$_POST["cgst"],$_POST["sgst"],$_POST["igst"],
			$dnParts,"agsatav@gmail.com",
				$date->format('Y-m-d H:i:s'),$cb,$date->format('Y-m-d H:i:s'));
			if($dn->addDN($db->getConnection(), $dnObject)){
				$dnObject = $dn->getDNPrintByNo($db->getConnection(), $_POST["dnno"]);
				$to = $dn->getVendor($db->getConnection(), $dnObject[0]['vend']);
				$partsNo =$dn->getPartsNo($db->getConnection(),$dnObject[0]['dnparts']);
				//generatePDF($to,$partsNo, $dnObject);
				echo ("<SCRIPT LANGUAGE='JavaScript'>
	            window.alert('Added')
	            window.location.href='../pages/debitnote.php';
	            </SCRIPT>");
			}else{
				echo "Err adding";
			}
		}else if(isset($_POST["edit"])){
			$dnId = $_POST["eid"];
			$dnObject = new DebitNote($_POST["eid"],$_POST["eprojectno"],$_POST["eto"],
			$_POST["ecourier"],$_POST["edispatchno"],$_POST["erefno"],$_POST["ecgst"],$_POST["esgst"],$_POST["eigst"],
			"support@metroservisol.com", $date->format('Y-m-d H:i:s'));
			// $dn->editDN($db->getConnection(), $dnObject);
			if($dn->editDN($db->getConnection(), $dnObject)){
				echo ("<SCRIPT LANGUAGE='JavaScript'>
		          window.alert('Edited')
		          window.location.href='../pages/editDn.php?id=$dnId';
		          </SCRIPT>");
			}else{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
		          window.alert('Error editing')
		          window.location.href='../pages/editDn.php?id=$dnId';
		          </SCRIPT>");
			}
		}else if(isset($_POST["delete"])){
			if($dn->deleteDN($db->getConnection(), $_POST["dnId"])){
				echo "Deleted";
			}else{
				echo "Err deleting";
			}
		}else if(isset($_POST["get"])){
			$dn->getDN($db->getConnection(), $_POST["dnId"]);
		}elseif(isset($_POST["getAll"])){
			$dn->getAllDN($db->getConnection());
		}else if(isset($_POST["addDNPart"])){
			$dnId = $_POST["dnId"];
			$dnPartObject = new DnParts($_POST["dnId"],$_POST["partId"],$_POST["reason"],$_POST["qty"],$_POST["unitprice"],$_POST["partTotAmount"]);
			if($dn->addDNPart($db->getConnection(), $dnPartObject)){
				echo ("<SCRIPT LANGUAGE='JavaScript'>
		          window.alert('DebitNote Part Added')
		          window.location.href='../pages/editDn.php?id=$dnId';
		          </SCRIPT>");
			}else{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
		          window.alert('Error adding part')
		          window.location.href='../pages/editDn.php?id=$dnId';
		          </SCRIPT>");
			}
		}else if(isset($_POST["editDNPart"])){
			$dnId = $_POST["ednId"];
			$dnPartObject = new DnParts($_POST["eid"],$_POST["ednId"],$_POST["epartId"],$_POST["ereason"],
				$_POST["eqty"],$_POST["eunitprice"],$_POST["epartTotAmount"]);
			// $dn->editDNPart($db->getConnection(), $dnPartObject);
			if($dn->editDNPart($db->getConnection(), $dnPartObject)){
				echo ("<SCRIPT LANGUAGE='JavaScript'>
		          window.alert('DebitNote Part Edited')
		          window.location.href='../pages/editDn.php?id=$dnId';
		          </SCRIPT>");
			}else{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
		          window.alert('Error Editing Debit Note Part ')
		          window.location.href='../pages/editDn.php?id=$dnId';
		          </SCRIPT>");
			}
		}else if(isset($_POST["deleteDNPart"])){
			if($dn->deleteDNPart($db->getConnection(), $_POST["dnPartId"])){
				echo "Deleted";
			}else{
				echo "Err deleting part";
			}
		}else if(isset($_POST["getDNPart"])){
			$dn->getDNPart($db->getConnection(), $_POST["dnPartId"]);
		}else if(isset($_POST["getAllDNPart"])){
			$dn->getAllDNPart($db->getConnection());
		}else if(isset($_POST["getPreDNNo"])){
	        $dn->getPreDN($db->getConnection());
	    }else if(isset($_POST["getLastDN"])){
	        $dn->getLastDN($db->getConnection());
	    }
	}else{
		$db = new DB();
		$dn = new DN();
		if(isset($_GET["id"])){
			$dnObject = $dn->getDNPrint($db->getConnection(), $_GET["id"]);			
			$to = $dn->getVendor($db->getConnection(), $dnObject[0]['vend']);			
			$partsNo =$dn->getPartsNo($db->getConnection(),$dnObject[0]['dnparts']);
			//print_r($partsNo);
			generatePDF($to,$partsNo, $dnObject);
		}
	}

	function generatePDF($to,$partsNo, $dn){
				
		//Array ( [0] => Array ( [id] => 2 [company] => igm Roboticsystersysteme AG 
		//[address] => Strasse 2a,Objekt M8,IZ NOE-Sued 2355 Wiener Neudorf Austria ) )
		
		// ( [0] => Array ( [id] => 1 [dnno] => DN001 [vend] => 2 [refno] => 898989898 
		//[dnparts] => Array ( [0] => Array ( [id] => 1 [partno] => 1 [reason] => gghghghggg 
		//[qty] => 1 [unitprice] => 90000.00 [partTotAmount] => 90000.00 ) ) 
		//[mb] => support@metroservisol.com [mo] => 2018-07-03 11:33:22 ) )

		//Array ( [0] => Demo123456 )

		// [{"id":"1","dnno":"DN001","vend":"1","refno":"PO454545",
		// "dnparts":[{"id":"1","partno":"19","reason":"dsfdsfds","qty":"21","unitprice":"21.00",
		// "partTotAmount":"242.00"},{"id":"2","partno":"17","reason":"dsdsfdsf","qty":"12","unitprice":"1.00","partTotAmount":"12.00"}
		// ],"mb":"agsatav@gmail.com","mo":"2017-12-29 11:30:36"}]

		//var_dump($to);

		$pdf = new DNpdf();
		$pdf->setFont("arial","",8);
	    $pdf->addPage();
	    $pdf->SetAutoPageBreak(true , 40);


	    $pdf->AliasNbPages();
		$st = $pdf->GetY();
		$pdf->setFont("Arial","",8);
		$pdf->Cell(110,5,"To,","",0,'L');
		$pdf->setFont("Arial","",8);    
		$pdf->Cell(80,5,"igm Roboticsystems India Pvt. Ltd.","",1,'L');
		$pdf->setFont("Arial","",8);
		//$to[0]["company"]["address"]
		if(sizeof($to)>0){
			$pdf->Cell(110,5,$to[0]["company"],"",1,'L');
		}else{
			$pdf->Cell(110,5,"Data not present","",1,'L');
		}
		$pdf->Cell(110,5,"Attn.: ".$to[0]["person1"],"",0,'L');
		$pdf->setFont("Arial","",8);
		$pdf->Cell(80,5,"Contact:  Sarika Dive","",1,'L');
		$pdf->setFont("Arial","",8);
		if(sizeof($to)>0){
			$pdf->Cell(110,5,$to[0]["addressline1"].",","",0,'L');		
		}else{
			$pdf->Cell(110,5,"Data not present","",0,'L');		
		}
		$pdf->setFont("Arial","",8);
		$pdf->Cell(80,5,"Mobile: +91 7738155709","",1,'L');
		$pdf->setFont("Arial","",8);
		if(sizeof($to)>0){
			$pdf->Cell(110,5,$to[0]["addressline2"].",","",0,'L');
		}else{
			$pdf->Cell(110,5,"Data not present","",0,'L');
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
		$date = new DateTime();
      	$pdf->Cell(80,5,"Date: ".$date->format('d/M/Y'),"",1,'L');

		$pdf->setFont("Arial","B",8);
		$pdf->SetTextColor(251,49,40);     

		$pdf->Cell(30,8,"DEBIT NOTE","",0,'L');
		$pdf->Cell(60,8,"No. DN-".$dn[0]["dnno"],"",1,'L');

		$pdf->setFont("Arial","",8);
		$pdf->SetTextColor(38,38,38); 

		if(sizeof($to)>0){
			$pdf->Cell(120,5,"Customer Name:  ".$to[0]["company"],"",1,'L');
			$pdf->Cell(120,5,"Customer No.: ".$to[0]["vno"],"",1,'L');
		}else{
			$pdf->Cell(120,5,"Data not present","",1,'L');
			$pdf->Cell(120,5,"Data not present","",1,'L');
		}
		$pdf->Cell(120,5,"Your Reference No.: ".$dn[0]["refno"]." DTD.","",1,'L');
		$pdf->Cell(120,5,"Igm Project No.: ".$dn[0]["projectno"],"",1,'L');

		$pdf->Cell(120,8,"We hereby invoice to you the following goods and/or services as per our general terms and conditions.","",1,'L');

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

		$pdf->setFont("Arial","",8);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFillColor(217,217,217);
		$pdf->SetDrawColor(255,255,255);
		$countTab = 1;

		// for ($i=0; $i < 5; $i++) { 
		// $pdf->Cell(10,10,$countTab,1,0,'C',true);
		// $pdf->Cell(20,10,"",1,0,'C',true);
		// $pdf->Cell(20,10,"",1,0,'C',true);
		// $pdf->Cell(20,10,"pcs.",1,0,'C',true);
		// $pdf->Cell(60,10,"",1,0,'C',true);
		// $pdf->Cell(30,10,"",1,0,'C',true);
		// $pdf->Cell(30,10,"",1,1,'C',true); 
		// $countTab+=1;
		// }
		$total=0;
		$amount = 0;
		$i=1;
		$pdf->SetWidths(array(10,20,10,60,30,30));
		//print_r($dn[0]['dnparts']);
	    foreach ($dn[0]['dnparts'] as $key => $value) {
			//print_r($value);
	      // quantity partno description unitprice amount
	      if ($pdf->GetY() == 255.00125||$pdf->GetY() == 250.00125||$pdf->GetY() == 251.00125){
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
			}					
	        $amount +=$value['partTotAmount'];
	        // $pdf->Cell(20,10,$pdf->GetY() ,1,0,'C');
	        
	        /*$pdf->Cell(10,10,$countTab,1,0,'C',true);
	        $pdf->Cell(20,10,$partsNo[$key],1,0,'C',true);
			$pdf->Cell(20,10,$value['qty'],1,0,'C',true);
			$pdf->Cell(20,10,$value['qty'],1,0,'C',true);
	        $pdf->Cell(60,10,$value['reason'],1,0,'C',true);
	        $pdf->Cell(30,10,number_format($value['unitprice'],2,".",","),1,0,'C',true);
	        $pdf->Cell(30,10,number_format($value['partTotAmount'],2,".",","),1,1,'C',true);*/
			$total+=$amount;
			if(sizeof($partsNo)>0){
				$pdf->Row(array($countTab,$partsNo[$key],$value['qty']/*,$value['qty']*/,$value['reason'],number_format($value['unitprice'],2,".",","),number_format($value['partTotAmount'],2,".",","))); 
			}else{
				$pdf->Row(array($countTab,"Part data not present",$value['qty']/*,$value['qty']*/,$value['reason'],number_format($value['unitprice'],2,".",","),number_format($value['partTotAmount'],2,".",","))); 
			}
			$countTab+=1;
	    }

		$pdf->Cell(160,8,"===================================================================================",1,1,'C',true);

		$pdf->Cell(10,8,"",1,0,'C',true);
		$pdf->Cell(20,8,"",1,0,'C',true);
		$pdf->Cell(10,8,"",1,0,'C',true);
		//$pdf->Cell(20,8,"",1,0,'C',true);
		$pdf->Cell(60,8,"Subtotal in INR",1,0,'C',true);
		$pdf->Cell(30,8,"",1,0,'C',true);
		$pdf->Cell(30,8,number_format($total,2,".",","),1,1,'C',true);

		$gst = (($dn[0]["cgst"]+$dn[0]["sgst"]+$dn[0]["igst"])/100)*$total;
		
		$pdf->Cell(10,8,"",1,0,'C',true);
		$pdf->Cell(20,8,"",1,0,'C',true);
		$pdf->Cell(10,8,"",1,0,'C',true);
		//$pdf->Cell(20,8,"",1,0,'C',true);
		$pdf->Cell(60,8,"GST in INR",1,0,'C',true);
		$pdf->Cell(30,8,"",1,0,'C',true);
		$pdf->Cell(30,8,number_format($gst,2,".",","),1,1,'C',true);
				

		$pdf->Cell(10,8,"",1,0,'C',true);
		$pdf->Cell(20,8,"",1,0,'C',true);
		$pdf->Cell(10,8,"",1,0,'C',true);
		//$pdf->Cell(20,8,"",1,0,'C',true);
		$pdf->Cell(60,8,"Total amount in INR",1,0,'C',true);
		$pdf->Cell(30,8,"",1,0,'C',true);
		$pdf->Cell(30,8,number_format($total+$gst,2,".",","),1,1,'C',true);

		$pdf->Cell(160,8,"===================================================================================",1,1,'C',true);

		$pdf->Cell(190,8,"",1,1,'C');
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
		$pdf->setFont("Arial","",8);
		$pdf->SetTextColor(38,38,38);

		$pdf->Cell(190,5,"  CIF / DAP / DDP",1,1,"L");

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
		$pdf->Cell(190,5," Sent by ".$dn[0]["courier"]." courier service",1,1,"L");
		$pdf->setFont("Arial","",8);
		$pdf->SetTextColor(251,49,40);
		$pdf->Cell(5,5,chr(149),1,0,"L");
		$pdf->setFont("Arial","",8);
		$pdf->SetTextColor(38,38,38);
		$pdf->Cell(190,5," Courier dispatch no.".$dn[0]["dispatchno"],1,1,"L");

		$pdf->setFont("Arial","",8);
		$pdf->SetTextColor(251,49,40);
		$pdf->Cell(190,5,"PAYMENT TERMS:",1,1,"L");

		$pdf->setFont("Arial","",8);
		$pdf->SetTextColor(251,49,40);
		$pdf->Cell(5,5,chr(149),1,0,"L");
		$pdf->setFont("Arial","",8);
		$pdf->SetTextColor(38,38,38);

		$pdf->Cell(190,5," 30/60 DAYS NET",1,1,"L");		

		
		$pdf->setFont("Arial","",8);
		$pdf->SetTextColor(251,49,40);
		$pdf->Cell(190,5,"OUR BANK DETAILS:",1,1,"L");

		
		$pdf->setFont("Arial","",8);
		$pdf->SetTextColor(251,49,40);
		$pdf->Cell(5,5,chr(149),1,0,"L");
		$pdf->setFont("Arial","",8);
		$pdf->SetTextColor(38,38,38);
		$pdf->Cell(180,5," YES BANK, SWIFT YESBINBBXXX, IFSC YESB0000412",1,1,"L");
		$pdf->setFont("Arial","",8);
		$pdf->SetTextColor(251,49,40);
		$pdf->Cell(5,5,chr(149),1,0,"L");
		$pdf->setFont("Arial","",8);
		$pdf->SetTextColor(38,38,38);
		$pdf->Cell(190,5," INR A/C No: 0412637000651, EEFC A/C No: 041282300000123 ",1,1,"L");    

		$pdf->setFont("Arial","",8);
		$pdf->SetTextColor(38,38,38);

		    
		$pdf->Cell(190,5,"Thank you",1,1,"L");
		$pdf->Cell(190,5,"With warm regards,",1,1,"L");    
		$pdf->Cell(190,5,"igm Roboticsystems India Pvt. Ltd.",1,1,"L");
	    
		echo $pdf->Output();
	}


	/**
	*
	*/
	class DN{
		function addDN($connection, $dn){
			//var_dump($dn);
			$query = <<<EOD
    		INSERT INTO debitnote
      		(dnno, projectno, vend, refno, courier, dispatchno, cgst,sgst,igst, created_by, created_on, modified_by, modified_on)
      		VALUES
  			(?,?,?,?,?,?,?,?,?,?,?,?,?)
EOD;
			$stmt = $connection->prepare($query);
			$stmt->bind_param("ssisssdddssss", $dnno,$projectno, $vend, $refno,$courier, $dispatchno, $cgst,$sgst,$igst, $cb, $co, $mb, $mo);
			$dnno = $dn->getDnno();
			$projectno = $dn->getProjectNo();
        	$courier = $dn->getCourier();
        	$dispatchno = $dn->getDispatchno();
			$vend = $dn->getTo();
			$refno = $dn->getRefno();
			$cgst = $dn->getCgst();
			$sgst = $dn->getSgst();
			$igst = $dn->getIgst();
			$cb = $dn->getCb();
			$co = $dn->getCo();
			$mb = $dn->getMb();
			$mo = $dn->getMo();
			$dnParts = $dn->getDnparts();
			if($stmt->execute()){
				if(self::addDNParts($connection,$dn->getDnno(), $dn->getDnParts())){
				return true;
					
				}
			}else{
				return false;
			}
		}

		function editDN($connection, $dn){
			// print_r($dn);
			$query = <<<EOD
    		UPDATE debitnote
    		SET
      		vend=?,projectno=?, courier=?, dispatchno=?, refno=?,cgst=?,sgst=?,igst=?, modified_by=?, modified_on=?
  			WHERE id=?

EOD;
			$stmt = $connection->prepare($query);
			$stmt->bind_param("issssdddssi", $vend, $projectno, $courier, $dispatchno, $refno,$cgst, $sgst, $igst,  $mb, $mo,$id);
			$vend = $dn->getTo();
			$refno = $dn->getRefno();
			$projectno = $dn->getProjectNo();
        	$courier = $dn->getCourier();
			$dispatchno = $dn->getDispatchno();
			$cgst = $dn->getCgst();
			$sgst = $dn->getSgst();
			$igst = $dn->getIgst();
			$mb = $dn->getMb();
			$mo = $dn->getMo();
			$id = $dn->getId();
			if($stmt->execute()){
				return true;
				/*$upSDB = new UpdateServerDBVersion();
		        if($upSDB->updateDBVersion()){
				}else{
		        	return false;
				}*/
			}else{
				return false;
			}
		}

		function deleteDN($connection, $id){
			$query = <<<EOD
    		DELETE FROM debitnote
  			WHERE id=?
EOD;
			$stmt = $connection->prepare($query);
			$stmt->bind_param("i", $id);
			$id = $id;
			if($stmt->execute()){
				return true;
				/*$upSDB = new UpdateServerDBVersion();
		        if($upSDB->updateDBVersion()){
				}else{
		        	return false;
				}*/
			}else{
				return false;
			}
		}

		function getDN($connection, $id){
			//dnno, vend, refno, created_by, created_on, modified_by, modified_on
			$query="SELECT * FROM debitnote WHERE id=".$id;
			$result = $connection->query($query);
      		$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$query1="SELECT * FROM dn_parts WHERE dnId=".$id;
					$result1 = $connection->query($query1);
		      		$data1 = array();
					if($result1->num_rows>0){
						while($row1=$result1->fetch_assoc()){
							$data1[] = array('id'=>$row1['id'],'partno'=>$row1['partId'],'reason'=>$row1['reason'],
					          'qty'=>$row1['qty'],'unitprice'=>$row1['unitprice'],
					          'partTotAmount'=>$row1['partTotAmount']);
						}
					}
					$data[] = array('id'=>$row['id'],'dnno'=>$row['dnno'],'vend'=>$row['vend'],
					  'refno'=>$row['refno'],'dnparts'=>$data1,
					  "projectno"=>$row["projectno"],"courier"=>$row["courier"],
					  "dispatchno"=>$row["dispatchno"],
					  "cgst"=>$row["cgst"],"sgst"=>$row["sgst"],"igst"=>$row["igst"],
			          'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
				}
			}
			echo json_encode($data);
		}

		function getDNPrint($connection, $id){
			//dnno, vend, refno, created_by, created_on, modified_by, modified_on
			$query="SELECT * FROM debitnote WHERE id=".$id;
			$result = $connection->query($query);
      		$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$query1="SELECT * FROM dn_parts WHERE dnId=".$id;
					$result1 = $connection->query($query1);
		      		$data1 = array();
					if($result1->num_rows>0){
						while($row1=$result1->fetch_assoc()){
							$data1[] = array('id'=>$row1['id'],'partno'=>$row1['partId'],'reason'=>$row1['reason'],
					          'qty'=>$row1['qty'],'unitprice'=>$row1['unitprice'],
					          'partTotAmount'=>$row1['partTotAmount']);
						}
					}
					$data[] = array('id'=>$row['id'],'dnno'=>$row['dnno'],'vend'=>$row['vend'],
					  'refno'=>$row['refno'],'dnparts'=>$data1,
					  "projectno"=>$row["projectno"],"courier"=>$row["courier"],
					  "dispatchno"=>$row["dispatchno"],
					  "cgst"=>$row["cgst"],"sgst"=>$row["sgst"],"igst"=>$row["igst"],
			          'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
				}
			}
			return $data;
		}

		function getDNPrintByNo($connection, $no){
			//dnno, vend, refno, created_by, created_on, modified_by, modified_on
			$query="SELECT * FROM debitnote WHERE dnno='".$no."'";
			$result = $connection->query($query);
      		$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$query1="SELECT * FROM dn_parts WHERE dnId=".$row['id'];
					$result1 = $connection->query($query1);
		      		$data1 = array();
					if($result1->num_rows>0){
						while($row1=$result1->fetch_assoc()){
							$data1[] = array('id'=>$row1['id'],'partno'=>$row1['partId'],'reason'=>$row1['reason'],
					          'qty'=>$row1['qty'],'unitprice'=>$row1['unitprice'],
					          'partTotAmount'=>$row1['partTotAmount']);
						}
					}
					$data[] = array('id'=>$row['id'],'dnno'=>$row['dnno'],'vend'=>$row['vend'],
					  'refno'=>$row['refno'],'dnparts'=>$data1,
					  "projectno"=>$row["projectno"],"courier"=>$row["courier"],
					  "dispatchno"=>$row["dispatchno"],
					  "cgst"=>$row["cgst"],"sgst"=>$row["sgst"],"igst"=>$row["igst"],
			          'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
				}
			}
			return $data;
		}

		function getVendor($connection, $id){
			$query="SELECT * FROM vendors WHERE id=".$id;
			$result = $connection->query($query);
      		$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data[] = array('id'=>$row['id'],"vno"=>$row["vno"],'company'=>$row['company_name'],
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
				$query="SELECT * FROM inventory_parts WHERE id=".$value['partno'];
				$result = $connection->query($query);
				if($result->num_rows>0){
					while($row=$result->fetch_assoc()){
						$partsNo[] = $row['part_number'];
					}
				}
			}
			return $partsNo;
		}

		function getDNyNo($connection, $dnno){
			$query="SELECT * FROM debitnote WHERE dnno='".$dnno."'";
			$result = $connection->query($query);
      		$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data[] = $row['id'];;
				}
			}
			return $data[0];
		}

		function getPreDN($connection){
			$query="SELECT MAX(id), dnno FROM debitnote ";
			$result = $connection->query($query);
			$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
				  $data[] = $row['dnno'];
				}
			}
			echo $data[0];
		}

		function getLastDN($connection){
			$query="SELECT dnno FROM debitnote WHERE id=(SELECT MAX(id) FROM debitnote)";
			$result = $connection->query($query);
			$data = "";
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
				  $data = $row['dnno'];
				}
			}
			echo $data;
		}

		function getAllDN($connection){
			$query="SELECT * FROM debitnote";
			$result = $connection->query($query);
      		$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$query1="SELECT * FROM dn_parts WHERE dnId=".$row["id"];
					$result1 = $connection->query($query1);
		      		$data1 = array();
					if($result1->num_rows>0){
						while($row1=$result1->fetch_assoc()){
							$data1[] = array('id'=>$row1['id'],'dnId'=>$row1['dnId'],'partno'=>$row1['partId'],
								'reason'=>$row1['reason'],
					          'qty'=>$row1['qty'],'unitprice'=>$row1['unitprice'],
					          'partTotAmount'=>$row1['partTotAmount']);
						}
					}
					$data[] = array('id'=>$row['id'],'dnno'=>$row['dnno'],'vend'=>$row['vend'],
					  'refno'=>$row['refno'],'dnparts'=>$data1,
					  "projectno"=>$row["projectno"],"courier"=>$row["courier"],
					  "dispatchno"=>$row["dispatchno"],
					  "cgst"=>$row["cgst"],"sgst"=>$row["sgst"],"igst"=>$row["igst"],
			          'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
				}
			}
			echo json_encode($data);
		}

		function addDNPart($connection, $dnPart){
			//getId getDnId getPartId getReason getQty getUnitprice getPartTotAmount
			$query = <<<EOD
    		INSERT INTO dn_parts
      		(dnId, partId, reason, qty, unitprice, partTotAmount)
      		VALUES
  			(?,?,?,?,?,?)
EOD;
			$stmt = $connection->prepare($query);
			$stmt->bind_param("iisidd", $dnId, $partId, $reason, $qty, $unitprice, $partTotAmount);
			$dnId = $dnPart->getDnId();
			$partId = $dnPart->getPartId();
			$reason = $dnPart->getReason();
			$qty = $dnPart->getQty();
			$unitprice = $dnPart->getUnitprice();
			$partTotAmount = $dnPart->getPartTotAmount();
			if($stmt->execute()){
				return true;
				/*$upSDB = new UpdateServerDBVersion();
		        if($upSDB->updateDBVersion()){
				}else{
		        	return false;
				}*/
			}else{
				return false;
			}
		}

		function addDNParts($connection, $dnNo, $dnParts){
			$success = false;
			$dnId = self::getDNyNo($connection, $dnNo);
			foreach ($dnParts as $key => $dnPart) {
				$query = <<<EOD
	    		INSERT INTO dn_parts
	      		(dnId, partId, reason, qty, unitprice, partTotAmount)
	      		VALUES
	  			(?,?,?,?,?,?)
EOD;
				$stmt = $connection->prepare($query);
				$stmt->bind_param("iisidd", $dnId, $partId, $reason, $qty, $unitprice, $partTotAmount);
				$dnId = $dnId;
				$partId = $dnPart->getPartId();
				$reason = $dnPart->getReason();
				$qty = $dnPart->getQty();
				$unitprice = $dnPart->getUnitprice();
				$partTotAmount = $dnPart->getPartTotAmount();
				if($stmt->execute()){					
					$success =  true;
				}else{
					$success =  false;
				}
			}
			// echo $success."<br/>";
			// var_dump($dnParts);
			if($success){
				return true;
				/*$upSDB = new UpdateServerDBVersion();
		        if($upSDB->updateDBVersion()){
				}else{
		        	return false;
				}*/				
			}else{
				return false;
			}
		}

		function editDNPart($connection, $dn){
			//print_r($dn);
			$query = <<<EOD
    		UPDATE dn_parts
    		SET
      		partId=?, reason=?, qty=?, unitprice=?, partTotAmount=?
  			WHERE id=?

EOD;
			$stmt = $connection->prepare($query);
			$stmt->bind_param("isiddi", $partId, $reason, $qty, $unitprice, $partTotAmount, $id);
			$partId = $dn->getPartId();
			$reason = $dn->getReason();
			$qty = $dn->getQty();
			$unitprice = $dn->getUnitprice();
			$partTotAmount = $dn->getPartTotAmount();
			$id = $dn->getId();
			if($stmt->execute()){
				return true;
				/*$upSDB = new UpdateServerDBVersion();
		        if($upSDB->updateDBVersion()){
				}else{
		        	return false;
				}*/
			}else{
				return false;
			}
		}

		function deleteDNPart($connection, $id){
			$query = <<<EOD
    		DELETE FROM dn_parts
  			WHERE id=?
EOD;
			$stmt = $connection->prepare($query);
			$stmt->bind_param("i", $id);
			$id = $id;
			if($stmt->execute()){
				return true;
				/*$upSDB = new UpdateServerDBVersion();
		        if($upSDB->updateDBVersion()){
				}else{
		        	return false;
				}*/
			}else{
				return false;
			}
		}

		function getDNPart($connection, $id){
			//partId reason qty unitprice partTotAmount
			$query="SELECT * FROM dn_parts WHERE id=".$id;
			$result = $connection->query($query);
      		$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data[] = array('id'=>$row['id'],'dnId'=>$row['dnId'],'partno'=>$row['partId'],'reason'=>$row['reason'],
			          'qty'=>$row['qty'],'unitprice'=>$row['unitprice'],
			          'partTotAmount'=>$row['partTotAmount']);
				}
			}
			echo json_encode($data);
		}

		function getAllDNPart($connection){
			$query="SELECT * FROM dn_parts ";
			$result = $connection->query($query);
      		$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data[] = array('id'=>$row['id'],'dnId'=>$row['dnId'],'partno'=>$row['partId'],'reason'=>$row['reason'],
			          'qty'=>$row['qty'],'unitprice'=>$row['unitprice'],
			          'partTotAmount'=>$row['partTotAmount']);
				}
			}
			echo json_encode($data);
		}
	}
?>
