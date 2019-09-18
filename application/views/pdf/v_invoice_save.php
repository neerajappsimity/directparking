<?php

/*if($details['ware_state_id'] == "6"){
  $invoicePrefix = "PKCHD-";
}else if($details['ware_state_id'] == "32"){
  $invoicePrefix = "PKPUN-";
}*/

$pdfContent='
<style>
.data tr, .data td, .data th{
  border:1px solid black;
}

.noBorder{
  border:none !important;
}

</style>

<table style="width:50%;">
<tr>
<td>
<img src="'.site_url().'assets/img/logo.png" width="125">
</td>
<td>
</td>
</tr>
</table>
<div id="printableArea">

<hr>

<table class="table table-bordered data" style="border:1px solid gray;" cellpadding="5px">
   


   <tr>
     <td width="35%"><b>'.$details['ware_name'].'</b><br>'.$details['ware_address_line_1'].'<br>'.$details['ware_address_line_2'].'<br>'.$details['ware_city'].', '.$details['ware_state'].'</td>
     <td><b>Invoice No.</b>'.$details['invoice_no'].' <br></td>
     <td><b>Dated</b> <br>'.date("d-m-Y",strtotime($details['created_date'])).'</td>
   </tr>

   
   <tr>
     <td rowspan="5"><b>'.$customer['company'].'</b><br>'.$details['bill_address_1'].'<br>'.$details['bill_address_2'].'<br>'.$details['bill_city'].', '.$details['bill_state'].', '.$details['bill_pincode'].'<br>Contact: '.$details['mobile'].'</td>
     <td><b>Buyer\'s Order No.</b> <br> PMK8-'.str_pad($details['id'], 5, '0', STR_PAD_LEFT).'</td>
     <td><b>Dated</b> <br>'.date("d-m-Y",strtotime($details['created_date'])).'</td>
   </tr>

   <tr>
     <td><b>Dispatched Through </b><br></td>
     <td><b>Destination </b><br>'.$details['delivery_address_1'].'
     '.$details['delivery_address_2'].',<br>'.$details['delivery_city'].','.$details['delivery_state'].', '.$details['delivery_pincode'].'</td>
   </tr>

   <tr>
     
     <td><b>Dispatch Document No.</b><br></td>
     <td></td>
   </tr>

   <tr>
    <td colspan="2"><b>Terms of Delivery</b><br></td>
   </tr>
 </table>



<table class="table table-bordered data" style="border:1px solid gray; " cellpadding="5px" width="100%">
   <thead>
     <tr>
      
       <th width="50%"><b>Desciption of Goods</b></th>
       <th width="15%"><b>Quantity</b></th>       
       <th width="15%"><b>Rate</b></th>
      
       <th width="21.65%" style="text-align:right;"><b>Total Amount</b></th>
       
     </tr>
   </thead>
   <tbody>'; 
$tempCommodityId = '';
$tempTaxAmount = 0;
$totalTax = 0;
$i=0;
$totalQty =0;
$totalProduct = 0;
   foreach($itemList as $key=>$row)
   {

    if($tempCommodityId == ''){
        $tempCommodityId = $row['commodity_id'];
    }

    
//<td width="20%" style="text-align:right;">Rs. '.$row['total_amount'].'</td>
    $totalProduct = $totalProduct+($row['quantity']*$row['price_per_unit']);
     $pdfContent.='<tr>
     
       <td width="50%" style="background-color:#c2c2c2;">'.$row['product_name'].' <br> <b>Brand:</b> '.$row['brand_name'].'</td>
       <td width="15%" style="text-align:center !important;">'.$row['quantity'].'</td>
       <td width="15%">Rs. '.round($row['price_per_unit']).'</td>

       <td width="21.65%" style="text-align:right;">Rs. '.($row['quantity']*$row['price_per_unit']).'</td>
     </tr>';

      $totalQty = $totalQty + $row['quantity'];
      $nextKeyItem = $key+1;
      $tempTaxAmount += $row['tax_amount']; 
      if($tempCommodityId != $row['commodity_id'] || !isset($itemList[$nextKeyItem])){
                      //$details['tax_type']
          $pdfContent.=' <tr>
                <td></td>
                <td align="right"> Output VAT('.$row['tax_rate'].'%)</td>
                <td></td>
                <td align="right">'.round($tempTaxAmount,2).'</td>
            </tr>';
            $totalTax = $totalTax + $tempTaxAmount;
            $tempTaxAmount = 0;
      }

      
      $tempCommodityId = $row['commodity_id']; 
    }

    //$pdfContent.='<tr><td colspan="5"></td></tr>';
    /*$pdfContent.='<tr valign="center">
      
       <td><b>Discount</b></td>
       <td></td>
       <td></td>
       <td style="text-align:right;">Rs. '.($details['discount_amount']+$details['coupon_discount']).'</td>
     </tr>';

    $pdfContent.='<tr valign="center">
      
       <td><b>'.$details['tax_type'].'</b></td>
       <td></td>
       <td></td>
       <td style="text-align:right;">Rs. '.$details['tax_amount'].'</td>
     </tr>';*/

     /*$pdfContent.='<tr valign="center">
       <td><b>Total Amount</b></td>
       <td></td>
       <td></td>
       <td></td>
       <td style="text-align:right;">Rs. '.$totalProduct.'</td>
     </tr>';*/

    /*$pdfContent.='<tr valign="center">
       <td><b>Tax Charges</b></td>
       <td></td>
       <td></td>
       <td></td>
       <td style="text-align:right;">Rs. '.round($totalTax,2).'</td>
     </tr>';*/

    $pdfContent.='<tr valign="center">
      
       <td><b>Shipping Charges</b></td>
       <td></td>
       <td></td>
  
       <td style="text-align:right;">Rs. '.$details['shipping_charges'].'</td>
     </tr>';

      //$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
      //ucfirst($f->format($details['net_amount']))

    $numberWords = convertNumberToWord($details['net_amount']);

    $pdfContent.='<tr valign="center">
      
       <td><h4><b>Gross Amount</b></h4></td>
       <td align="right"><b>'.$totalQty.' Qty</b></td>
       <td></td>

       <td style="text-align:right;"><h4><b>Rs. '.$details['net_amount'].'</b></h4></td>
       
     </tr>

     <tr style="border:none !important;">
       <td style="border:none !important;">Amount Chargeable (in words)</td>
       <td style="border:none !important;"></td>
       <td style="border:none !important;"></td>

       <td style="border:none !important;" align="right"></td>
     </tr>

     <tr style="border:none !important;">
       <td style="border:none !important;"><b>Rs. '.ucfirst($numberWords).' Only</b></td>
       <td style="border:none !important;"></td>
       <td style="border:none !important;"></td>

       <td style="border:none !important;"></td>
     </tr>

   </tbody>
 </table>';

  $pdfContent.='<br><br><br><br><b>Remarks :</b><br><br>';


    $pdfContent.='<br><br>
    <table width="90%">
      <tr>
      <td width="25%"><b>Company\'s VAT TIN :</b></td>
      <td width="75%">'.$details['ware_vat'].'</td>
      </tr>
      <tr>
      <td><b>Company\'s CST No. :</b></td>
      <td>'.$details['ware_cst'].'</td>
      </tr>
      <tr>
      <td><b>Buyers\'s TIN :</b></td>
      <td>'.$customer['tin_number'].'</td>
      </tr>
      <tr>
      <td><b>Declaration :</b></td>
      <td>1. Certified that all the particulars shown in the above Tax invoice are true and correct and that my /our registration under Sales Tax act is valid as on the date of this bill.
      <br>2. All goods returned for replacement must be in salable condition with original packing.
      <br>3. 24% p.a interest will be  charged for delayed payment.</td>
      </tr>
      <!--tr>
      <td>Input Tax Credit is available to a taxable person against original Copy Only</td>
      <td></td>
      </tr-->

    </table>

</div>';




function convertNumberToWord($num = false)
{
    $num = str_replace(array(',', ' '), '' , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array('', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven',
        'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
    );
    $list2 = array('', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety', 'Hundred');
    $list3 = array('', 'Thousand', 'Million', 'Billion', 'Trillion', 'Quadrillion', 'Quintillion', 'Sextillion', 'Septillion',
        'Octillion', 'Nonillion', 'Decillion', 'Undecillion', 'Duodecillion', 'Tredecillion', 'Quattuordecillion',
        'Quindecillion', 'Sexdecillion', 'Septendecillion', 'Octodecillion', 'Novemdecillion', 'Vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ( $hundreds == 1 ? '' : '' ) . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return implode(' ', $words);
}


tcpdf();
//$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$obj_pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


$obj_pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$obj_pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$obj_pdf->SetPrintHeader(false); 
$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$obj_pdf->SetFont('helvetica', '', 9);
$obj_pdf->setFontSubsetting(false);

$obj_pdf->SetFont('helvetica', '', 9);
$obj_pdf->AddPage();

$obj_pdf->writeHTML($pdfContent, true, 0, true, 0);
$obj_pdf->lastPage();
$obj_pdf->Output('output.pdf', 'I');

die;

/*$obj_pdf->SetCreator(PDF_CREATOR);
$title = "Invoice";
$obj_pdf->SetPrintHeader(false); 
$obj_pdf->SetTitle($title);
$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title,stripslashes("by Backend Support \\\n www.mrbachat.com"));
$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$obj_pdf->SetDefaultMonospacedFont('helvetica');
$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$obj_pdf->SetFont('helvetica', '', 9);
$obj_pdf->setFontSubsetting(false);

$obj_pdf->AddPage();
ob_start();
    // we can have any view part here like HTML, PHP etc
    //$content = ob_get_contents();
    $content = $pdfContent;
ob_end_clean();
$obj_pdf->writeHTML($content, true, false, true, false, '');
$obj_pdf->Output('output.pdf', 'I');*/
?>

<script>
<?php 
foreach($modelIds as $val){
  ?>

$('#vendor_<?php echo $val;?>').on('shown.bs.modal', function () {
  //$('#myInput').focus()
})
  <?php } ?>
	

</script>