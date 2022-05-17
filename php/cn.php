<?php
	// $_POST["to"] $_POST["cnno"] $_POST["refno"]
	// $_POST["partno"] $_POST["reason"] $_POST["qty"] $_POST["rate"] $_POST["total"]
	//CreditNote($id,$cnno,$to,$refno,ArrayObject $cnparts,$cb,$co,$mb,$mo)
	//getId getCnno getTo getRefno getCnparts getCb getCo
	//CnParts($id,  $cnId,$partId,$qty,$unitprice,$partTotAmount)
	//getId getCnId getPartId getReason getQty getUnitprice getPartTotAmount
	require('db.php');
	require('data/cnParts.php');
	require('data/creditNoteObject.php');
	require_once "updateServerDBVersion.php";
	require("../phplibraries/fpdf.php");

	class CNdpf extends FPDF  {

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
	      $this->Image("../images/quotation_image.png",5,5, $this->getPageWidth()/2,15);
	      $this->Ln(15);
		}
		
		function footer(){
			$this->SetY(-28);
			$this->SetTextColor(38,38,38);
			$this->SetDrawColor(255,0,0);
			$this->SetFont('Arial','',6.5);
  
			$this->Cell(90,5,'Page '.$this->PageNo()."/{nb}",0,0,'R');
			$this->Cell(90,5,' form ID: FOi-CN-04',0,1,'R');
  
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
		$cn = new CN();
		$date = new DateTime();
		$cb = $mb = isset($_COOKIE["usermail"])?$_COOKIE["usermail"]:"support@metroservisol.com";
		// $date->format('Y-m-d H:i:s')
		if(isset($_POST["add"])){
			$cnParts = new ArrayObject();
			$list =  array();
			$arrayId = explode(",",$_POST["ids"]);

			foreach ($arrayId as $key => $value) {

		        $partID = explode("-",$_POST['partno'.$value]);

		        $a = array("partNo"=>$partID[1],"qty"=>$_POST['qty'.$value],"reason"=>$_POST['reason'.$value],
		        "rate"=>$_POST['rate'.$value],"total"=>$_POST['total'.$value]);

		        array_push($list, $a);

		        $cnParts[$key] = new CnParts(0,$partID[0],$_POST['reason'.$value],
		        	$_POST['qty'.$value],$_POST['rate'.$value],$_POST['total'.$value]);
	      	}
			//$cnPartObject = new CnParts($id,  $cnId,$partId,$qty,$unitprice,$partTotAmount);
			//$_POST["cnno"] = "CN001"; projectno courier dispatchno
			$cnObject = new  CreditNote($_POST["cnno"],$_POST["projectno"],$_POST["to"],$_POST["refno"],
			$_POST["courier"],$_POST["dispatchno"],$_POST["cgst"],$_POST["sgst"],$_POST["igst"], $cnParts,
				$cb,$date->format('Y-m-d H:i:s'),$cb,$date->format('Y-m-d H:i:s'));
			//$cn->addCN($db->getConnection(), $cnObject);
			if($cn->addCN($db->getConnection(), $cnObject)){
				//echo "Added";
				$cnObject = $cn->getCNPrintByNo($db->getConnection(),$_POST["cnno"]);
				$to = $cn->getCust($db->getConnection(),$cnObject[0]['cust']);
				$partsNo = $cn->getPartsNo($db->getConnection(),$cnObject[0]['cnparts']);
				//generatePDF($to, $partsNo, $cnObject);
				echo ("<SCRIPT LANGUAGE='JavaScript'>
	            window.alert('Added')
	            window.location.href='../pages/creditnote.php';
	            </SCRIPT>");
			}else{
				echo "Err adding";
			}
		}else if(isset($_POST["edit"])){
			$cnId = $_POST["eid"];
			$cnObject = new  CreditNote($_POST["eid"],$_POST["eprojectno"],$_POST["eto"],
			$_POST["ecourier"],$_POST["edispatchno"],$_POST["erefno"],$_POST["ecgst"],$_POST["esgst"],$_POST["eigst"],$cb,$date->format('Y-m-d H:i:s'));
			if($cn->editCN($db->getConnection(), $cnObject)){
				echo ("<SCRIPT LANGUAGE='JavaScript'>
		          window.alert('CreditNote Edited')
		          window.location.href='../pages/editCn.php?id=$cnId';
		          </SCRIPT>");
			}else{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
		          window.alert('Err editing\n Try again!')
		          window.location.href='../pages/editCn.php?id=$cnId';
		          </SCRIPT>");
			}
		}else if(isset($_POST["delete"])){
			if($cn->deleteCN($db->getConnection(), $_POST["cnId"])){
				echo "Deleted";
			}else{
				echo "Err deleting";
			}
		}else if(isset($_POST["get"])){
			$cn->getCN($db->getConnection(), $_POST["cnId"]);
		}else if(isset($_POST["getAll"])){
			$cn->getAllCN($db->getConnection());
		}else if(isset($_POST["addCNPart"])){
			$cnId = $_POST["cnId"];
			$cnPartObject = new CnParts($_POST["cnId"],$_POST["partId"],$_POST["reason"],
				$_POST["qty"],$_POST["unitprice"],$_POST["partTotAmount"]);
			if($cn->addCNPart($db->getConnection(), $cnPartObject)){
				echo ("<SCRIPT LANGUAGE='JavaScript'>
		          window.alert('CreditNote Part Added')
		          window.location.href='../pages/editCn.php?id=$cnId';
		          </SCRIPT>");
			}else{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
		          window.alert('Error Adding CreditNote Part')
		          window.location.href='../pages/editCn.php?id=$cnId';
		          </SCRIPT>");
			}
		}else if(isset($_POST["editCNPart"])){
			$cnId = $_POST["ecnId"];
			$cnPartObject = new CnParts($_POST["eid"],  $_POST["ecnId"],$_POST["epartId"],
				$_POST["ereason"],$_POST["eqty"],$_POST["eunitprice"],$_POST["epartTotAmount"]);
			if($cn->editCNPart($db->getConnection(), $cnPartObject)){
				echo ("<SCRIPT LANGUAGE='JavaScript'>
		          window.alert('CreditNote Part Edited')
		          window.location.href='../pages/editCn.php?id=$cnId';
		          </SCRIPT>");
			}else{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
		          window.alert('Error Editing CreditNote Part')
		          window.location.href='../pages/editCn.php?id=$cnId';
		          </SCRIPT>");
			}
		}else if(isset($_POST["deleteCNPart"])){
			if($cn->deleteCNPart($db->getConnection(), $_POST["cnPartId"])){
				echo "Deleted";
			}else{
				echo "Err deleting part";
			}
		}else if(isset($_POST["getCNPart"])){
			$cn->getCNPart($db->getConnection(), $_POST["cnPartId"]);
		}else if(isset($_POST["getAllCNPart"])){
			$cn->getAllCNPart($db->getConnection());
		}else if(isset($_POST["getPreCNNo"])){
	        $cn->getPreCN($db->getConnection());
	    }else if(isset($_POST["getLastCN"])){
	        $cn->getLastCN($db->getConnection());
	    }

	}else{
		$db = new DB();
		$cn = new CN();
		//$cn->
		if(isset($_GET["id"])){
			$cnObject = $cn->getCNPrint($db->getConnection(),$_GET["id"]);
			$to = $cn->getCust($db->getConnection(),$cnObject[0]['cust']);
			$partsNo = $cn->getPartsNo($db->getConnection(),$cnObject[0]['cnparts']);
			generatePDF($to, $partsNo, $cnObject);
		}
	}



	function generatePDF($to, $partsNo, $cn){
		$pdf = new CNdpf();
		$pdf->setFont("arial","",8);
	    $pdf->addPage();
	    $pdf->SetAutoPageBreak(true , 40);
	    $pdf->AliasNbPages();
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
		if(sizeof($to)>0){
			$pdf->Cell(110,5,"Attn.: ".$to[0]["person1"],"",0,'L');
		}else{
			$pdf->Cell(110,5,"Data not present","",0,'L');
		}
		$pdf->setFont("Arial","",8);
		$pdf->Cell(80,5,"Contact:  Sarika Dive","",1,'L');
		$pdf->setFont("Arial","",8);
		if(sizeof($to)>0){
			$pdf->Cell(110,5,$to[0]["addressline1"],"",0,'L');
		}else{
			$pdf->Cell(110,5,"Data not present","",0,'L');
		}
		//$pdf->MultiCell(110,5,$to[0]["address"],0,'L',0);
		$pdf->setFont("Arial","",8);
		$pdf->Cell(80,5,"Mobile: +91 7738155709","",1,'L');
		$pdf->setFont("Arial","",8);
		$pdf->Cell(110,5,"Address line 2","",0,'L');
		$pdf->setFont("Arial","",8);
		$pdf->Cell(80,5,"E-mail: sarika.dive@igm-india.com","",1,'L');
		$pdf->setFont("Arial","",8);
		$pdf->Cell(110,5,"City Postcode","",1,'L');
		$pdf->setFont("Arial","",8);
		$pdf->Cell(110,5,"INDIA","",0,'L');
		$pdf->setFont("Arial","",8);
		$date = new DateTime();
      	$pdf->Cell(80,5,"Date: ".$date->format('d/M/Y'),"",1,'L');

		$pdf->setFont("Arial","B",8);
		$pdf->SetTextColor(251,49,40);     

		$pdf->Cell(30,8,"CREDIT NOTE","",0,'L');
		$pdf->Cell(60,8,"No. CN-".$cn[0]["cnno"],"",1,'L');

		$pdf->setFont("Arial","",8);
		$pdf->SetTextColor(38,38,38); 

		if(sizeof($to)>0){
			$pdf->Cell(120,5,"Customer Name:  ".$to[0]["company"],"",1,'L');
		}else{
			$pdf->Cell(120,5,"Data not present","",1,'L');
		}
		if(sizeof($to)>0){
			$pdf->Cell(120,5,"Customer No.: ".$to[0]["cno"],"",1,'L');
		}else{
			$pdf->Cell(120,5,"Data not present","",1,'L');
		}
		$pdf->Cell(120,5,"Your Reference No.: ".$cn[0]["refno"]." DTD. ","",1,'L');
		$pdf->Cell(120,5,"Igm Project No.: ".$cn[0]["projectno"],"",1,'L');

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

	    $i=1;
	    $amount = 0;
	    $pdf->SetWidths(array(10,20,10,60,30,30));

	    foreach ($cn[0]['cnparts'] as $key => $value) {
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

	        // $pdf->Cell(20,10,$pdf->GetY() ,1,0,'C');
	        
	        /*$pdf->Cell(10,10,$i,1,0,'C',1);
	        $pdf->Cell(20,10,$partsNo[$key],1,0,'C',1);
			$pdf->Cell(20,10,$value['qty'],1,0,'C',1);
			$pdf->Cell(20,10,$value['qty'],1,0,'C',1);
	        $pdf->Cell(60,10,$value['reason'],1,0,'C',1);
	        $pdf->Cell(30,10,number_format($value['unitprice'],2,".",","),1,0,'C',1);
	        $pdf->Cell(30,10,number_format($value['partTotAmount'],2,".",","),1,1,'C',1);*/
			$amount +=$value['partTotAmount'];
			//var_dump($partsNo);
			if(sizeof($partsNo)>0){
				$pdf->Row(array($i,$partsNo[$key],$value['qty']/*,$value['qty']*/,$value['reason'],number_format($value['unitprice'],2,".",","),number_format($value['partTotAmount'],2,".",",")));
			}else{
				$pdf->Row(array($i,"Part data not present",$value['qty']/*,$value['qty']*/,$value['reason'],number_format($value['unitprice'],2,".",","),number_format($value['partTotAmount'],2,".",",")));
			}
			$i+=1;
	    }
	    $pdf->Cell(160,10,"===================================================================================",1,1,'C',true);

		$pdf->Cell(10,8,"",1,0,'C',true);
		$pdf->Cell(20,8,"",1,0,'C',true);
		$pdf->Cell(10,8,"",1,0,'C',true);
		//$pdf->Cell(20,8,"",1,0,'C',true);
		$pdf->Cell(60,8,"Subtotal in INR",1,0,'C',true);
		$pdf->Cell(30,8,"",1,0,'C',true);
		$pdf->Cell(30,8,number_format($amount,2,".",","),1,1,'C',true);
		
		$gst = (($cn[0]["cgst"]+$cn[0]["sgst"]+$cn[0]["igst"])/100)*$amount;

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
		$pdf->Cell(30,8,number_format($amount+$gst,2,".",","),1,1,'C',true);

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
		$pdf->Cell(190,5," Sent by ".$cn[0]["courier"]." courier service",1,1,"L");
		$pdf->setFont("Arial","",8);
		$pdf->SetTextColor(251,49,40);
		$pdf->Cell(5,5,chr(149),1,0,"L");
		$pdf->setFont("Arial","",9);
		$pdf->SetTextColor(38,38,38);
		$pdf->Cell(190,5," Courier dispatch no.".$cn[0]["dispatchno"],1,1,"L");
		
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
	class CN{
		function addCN($connection, $cn){
			//getId getCnno  getTo getRefno   getCnparts getCb getCo
			//var_dump($cn->getCnparts());
			$query = <<<EOD
    		INSERT INTO creditnote
      		(cnno, projectno, cust, refno, courier, dispatchno, cgst,sgst,igst, created_by, created_on, modified_by, modified_on)
      		VALUES
  			(?,?,?,?,?,?,?,?,?,?,?,?,?)
EOD;
			$stmt = $connection->prepare($query);
			$stmt->bind_param("ssisssdddssss", $cnno,$projectno, $cust, $refno, $courier, $dispatchno,$cgst,$sgst,$igst,  $cb, $co, $mb, $mo);
			$cnno = $cn->getCnno();
			$projectno = $cn->getProjectNo();
        	$courier = $cn->getCourier();
			$dispatchno = $cn->getDispatchno();
			$cgst = $cn->getCgst();
			$sgst = $cn->getSgst();
			$igst = $cn->getIgst();
			$cust = $cn->getTo();
			$refno = $cn->getRefno();
			$cb = $cn->getCb();
			$co = $cn->getCo();
			$mb = $cn->getMb();
			$mo = $cn->getMo();

			//var_dump($cn);
			//echo $stmt->execute()."<br/>";
			//echo self::addCNParts($connection,$cn->getCnno(), $cn->getCnparts());
			if($stmt->execute()){
				//echo self::addCNParts($connection,$cn->getCnno(), $cn->getCnparts());
				if(self::addCNParts($connection,$cn->getCnno(), $cn->getCnparts())){
					return true;
					/*$upSDB = new UpdateServerDBVersion();
			        if($upSDB->updateDBVersion()){
					}else{
			        	return false;
					}*/
				}
			}else{
				return false;
			}
		}

		function editCN($connection, $cn){
			$query = <<<EOD
    		UPDATE creditnote
    		SET
      		cust=?,projectno=?, courier=?, dispatchno=?, refno=?, cgst=?,sgst=?,igst=?, modified_by=?, modified_on=?
      		WHERE id=?
EOD;
			$stmt = $connection->prepare($query);
			$stmt->bind_param("issssdddssi", $cust, $projectno, $courier, $dispatchno, $refno, $cgst, $sgst, $igst,  $mb, $mo,$id);
			$cust = $cn->getTo();
			$refno = $cn->getRefno();
			$projectno = $cn->getProjectNo();
      		$courier = $cn->getCourier();
			$dispatchno = $cn->getDispatchno();
			$cgst = $cn->getCgst();
			$sgst = $cn->getSgst();
			$igst = $cn->getIgst();
			$mb = $cn->getMb();
			$mo = $cn->getMo();
			$id = $cn->getId();
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

		function deleteCN($connection, $id){
			$query = <<<EOD
    		DELETE FROM creditnote
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

		function getCN($connection, $id){
			$query="SELECT * FROM creditnote WHERE id=".$id;
			$result = $connection->query($query);
      		$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){

					$query1="SELECT * FROM cn_parts WHERE cnId=".$id;
					$result1 = $connection->query($query1);
		      		$data1 = array();
					if($result1->num_rows>0){
						while($row1=$result1->fetch_assoc()){
							$data1[] = array('id'=>$row1['id'],'cnId'=>$row1['cnId'],'partId'=>$row1['partId'],
					          'unitprice'=>$row1['unitprice'],'reason'=>$row1['reason'],
					          'qty'=>$row1['qty'],'partTotAmount'=>$row1['partTotAmount']);
						}
					}

					$data[] = array('id'=>$row['id'],'cnno'=>$row['cnno'],'refno'=>$row['refno'],
					  'cust'=>$row['cust'],"projectno"=>$row["projectno"],"courier"=>$row["courier"],
					  "dispatchno"=>$row["dispatchno"],
					  "cgst"=>$row["cgst"],"sgst"=>$row["sgst"],"igst"=>$row["igst"],
			          'cnparts'=>$data1,
			          'cb'=>$row['created_by'],'co'=>$row['created_on'],
			          'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
				}
			}
			echo json_encode($data);
		}

		function getCNPrint($connection, $id){
			$query="SELECT * FROM creditnote WHERE id=".$id;
			$result = $connection->query($query);
      		$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){

					$query1="SELECT * FROM cn_parts WHERE cnId=".$id;
					$result1 = $connection->query($query1);
		      		$data1 = array();
					if($result1->num_rows>0){
						while($row1=$result1->fetch_assoc()){
							$data1[] = array('id'=>$row1['id'],'cnId'=>$row1['cnId'],'partId'=>$row1['partId'],
					          'unitprice'=>$row1['unitprice'],'reason'=>$row1['reason'],
					          'qty'=>$row1['qty'],'partTotAmount'=>$row1['partTotAmount']);
						}
					}

					$data[] = array('id'=>$row['id'],'cnno'=>$row['cnno'],'refno'=>$row['refno'],
			          'cust'=>$row['cust'],"projectno"=>$row["projectno"],"courier"=>$row["courier"],
					  "dispatchno"=>$row["dispatchno"],
					  "cgst"=>$row["cgst"],"sgst"=>$row["sgst"],"igst"=>$row["igst"],
			          'cnparts'=>$data1,
			          'cb'=>$row['created_by'],'co'=>$row['created_on'],
			          'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
				}
			}
			return $data;
		}

		function getCNPrintByNo($connection, $id){
			$query="SELECT * FROM creditnote WHERE cnno='".$id."'";
			$result = $connection->query($query);
      		$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){

					$query1="SELECT * FROM cn_parts WHERE cnId=".$row["id"];
					$result1 = $connection->query($query1);
		      		$data1 = array();
					if($result1->num_rows>0){
						while($row1=$result1->fetch_assoc()){
							$data1[] = array('id'=>$row1['id'],'cnId'=>$row1['cnId'],'partId'=>$row1['partId'],
					          'unitprice'=>$row1['unitprice'],'reason'=>$row1['reason'],
					          'qty'=>$row1['qty'],'partTotAmount'=>$row1['partTotAmount']);
						}
					}

					$data[] = array('id'=>$row['id'],'cnno'=>$row['cnno'],'refno'=>$row['refno'],
			          'cust'=>$row['cust'],"projectno"=>$row["projectno"],"courier"=>$row["courier"],
					  "dispatchno"=>$row["dispatchno"],
					  "cgst"=>$row["cgst"],"sgst"=>$row["sgst"],"igst"=>$row["igst"],
			          'cnparts'=>$data1,
			          'cb'=>$row['created_by'],'co'=>$row['created_on'],
			          'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
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
					$data[] = array('id'=>$row['id'],'cno'=>$row["cno"],'company'=>$row['company_name'],'addressline1' => $row['addressline1'],
					'addressline2' => $row['addressline2'],'city' => $row['city']
					,'country' => $row['country'],
				"person1"=>$row["contact_person1_name"]);
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
						$partsNo[] = $row['part_number'];
					}
				}
			}
			return $partsNo;
		}

		function getCNyNo($connection, $cnno){
			$query="SELECT * FROM creditnote WHERE cnno='".$cnno."'";
			$result = $connection->query($query);
      		$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data[] = $row['id'];
				}
			}
			return $data[0];
		}

		function getPreCN($connection){
			$query="SELECT MAX(id), cnno FROM creditnote ";
			$result = $connection->query($query);
			$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
				  $data[] = $row['cnno'];
				}
			}
			echo $data[0];
		}

		function getLastCN($connection){
			$query="SELECT cnno FROM creditnote WHERE id=(SELECT MAX(id) FROM creditnote)";
			$result = $connection->query($query);
			$data = "";
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
				  $data = $row['cnno'];
				}
			}
			echo $data;
		}

		function getAllCN($connection){
			$query="SELECT * FROM creditnote";
			$result = $connection->query($query);
      		$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){

					$query1="SELECT * FROM cn_parts WHERE cnId=".$row["id"];
					$result1 = $connection->query($query1);
		      		$data1 = array();
					if($result1->num_rows>0){
						while($row1=$result1->fetch_assoc()){
							$data1[] = array('id'=>$row1['id'],'cnId'=>$row1['cnId'],'partId'=>$row1['partId'],
					          'unitprice'=>$row1['unitprice'],'reason'=>$row1['reason'],
					          'qty'=>$row1['qty'],'partTotAmount'=>$row1['partTotAmount']);
						}
					}

					$data[] = array('id'=>$row['id'],'cnno'=>$row['cnno'],'refno'=>$row['refno'],
			          'cust'=>$row['cust'],"projectno"=>$row["projectno"],"courier"=>$row["courier"],
					  "dispatchno"=>$row["dispatchno"],
					  "cgst"=>$row["cgst"],"sgst"=>$row["sgst"],"igst"=>$row["igst"],
			          'cnparts'=>$data1,
			          'cb'=>$row['created_by'],'co'=>$row['created_on'],
			          'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
				}
			}
			echo json_encode($data);
		}

		function addCNPart($connection, $cnPart){
			//getId getCnId getPartId getReason getQty getUnitprice getPartTotAmount
			$query = <<<EOD
    		INSERT INTO cn_parts
      		(cnId, partId, reason, qty, unitprice, partTotAmount)
      		VALUES
  			(?,?,?,?,?,?)
EOD;
			$stmt = $connection->prepare($query);
			$stmt->bind_param("iisidd", $cnId, $partId, $reason, $qty, $unitprice, $partTotAmount);
			$cnId = $cnPart->getCnId();
			$partId = $cnPart->getPartId();
			$reason = $cnPart->getReason();
			$qty = $cnPart->getQty();
			$unitprice = $cnPart->getUnitprice();
			$partTotAmount = $cnPart->getPartTotAmount();
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

		function addCNParts($connection,$cnno, $cnParts){
			$success = false;
			$cnId = self::getCNyNo($connection,$cnno);
			foreach ($cnParts as $key => $cnPart) {
				$query = <<<EOD
	    		INSERT INTO cn_parts
	      		(cnId, partId, reason, qty, unitprice, partTotAmount)
	      		VALUES
	  			(?,?,?,?,?,?)
EOD;
				$stmt = $connection->prepare($query);
				$stmt->bind_param("iisidd", $cnId, $partId, $reason, $qty, $unitprice, $partTotAmount);
				$cnId = $cnId;
				$partId = $cnPart->getPartId();
				$reason = $cnPart->getReason();
				$qty = $cnPart->getQty();
				$unitprice = $cnPart->getUnitprice();
				$partTotAmount = $cnPart->getPartTotAmount();
				if($stmt->execute()){
					$success =  true;
				}else{
					$success =  false;
				}
			}
			//echo "$success";
			//var_dump($cnParts);
			if($success){
				return true;
			}else{
				return false;
			}
		}

		function editCNPart($connection, $cn){
			$query = <<<EOD
    		UPDATE cn_parts
    		SET
      		partId=?, reason=?, qty=?, unitprice=?, partTotAmount=?
      		WHERE id=?
EOD;
			$stmt = $connection->prepare($query);
			$stmt->bind_param("isiddi", $partId, $reason, $qty, $unitprice, $partTotAmount,$id);
			$partId = $cn->getPartId();
			$reason = $cn->getReason();			
			$qty = $cn->getQty();
			$unitprice = $cn->getUnitprice();
			$partTotAmount = $cn->getPartTotAmount();
			$id = $cn->getId();
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

		function deleteCNPart($connection, $id){
			$query = <<<EOD
    		DELETE FROM cn_parts
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

		function getCNPart($connection, $id){
			//cnId, partId, reason, qty, unitprice, partTotAmount
			$query="SELECT * FROM cn_parts WHERE id=".$id;
			$result = $connection->query($query);
      		$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data[] = array('id'=>$row['id'],'cnId'=>$row['cnId'],'partId'=>$row['partId'],
			          'unitprice'=>$row['unitprice'],'reason'=>$row['reason'],
			          'qty'=>$row['qty'],'partTotAmount'=>$row['partTotAmount']);
				}
			}
			echo json_encode($data);
		}

		function getAllCNPart($connection){
			$query="SELECT * FROM cn_parts";
			$result = $connection->query($query);
      		$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data[] = array('id'=>$row['id'],'cnId'=>$row['cnId'],'partId'=>$row['partId'],
			          'unitprice'=>$row['unitprice'],'reason'=>$row['reason'],
			          'qty'=>$row['qty'],'partTotAmount'=>$row['partTotAmount']);
				}
			}
			echo json_encode($data);
		}
	}



?>
