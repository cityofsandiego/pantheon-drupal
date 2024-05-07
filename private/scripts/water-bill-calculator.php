<!DOCTYPE html>
<html lang="en">
<head>
    <title>Water Bill Calculator | City of San Diego Official
        Website</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,800,700|Merriweather:400,700'
          rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css"
          href="https://www.sandiego.gov/sites/all/themes/sandiego/assets/dist/css/main.min.css">
    <style>

    </style>
</head>
<body class="background-white">
<a name="top"></a>
<div id="outer-wrap">
    <div id="inner-wrap">
        <header class="l-padding-ad header--app">
            <div class="row">
                <div class="three columns l-padding-ts">
                    <a href="https://www.sandiego.gov" class="logo">
                        <img src="https://www.sandiego.gov/sites/all/themes/sandiego/assets/dist/img/logo.png"
                             alt="The City of San Diego" width="205" height="50"
                             class="hide-on-mobile">
                        <img src="https://www.sandiego.gov/sites/all/themes/sandiego/assets/dist/img/logo-mark.png"
                             alt="The City of San Diego" width="163"
                             height="132" class="hide-on-desktop">
                    </a>
                </div>

                <div class="nine columns">
                    <h1 class="text-white heading--trim">Water Bill Calculator</h1>
                    <p class="text-white l-margin-bn">Public Utilities Department</p> <!-- optional -->
                </div>
            </div>
        </header>
        <main>
            <div class="l-padding-am background-white">
                <div class="row">

                    <div>
                        <div class="l-constrained row l-padding-desktop-hm">
                            <p>Disclaimer: Please use this calculator as a guideline. For more information on specific rate approvals, please visit the <a href="https://www.sandiego.gov/public-utilities/customer-service/water-and-sewer-rates">Water and Sewer Rates</a> web page.</p>
                          <?php
                          if (isset($_GET["submit"])) {
                            $submit = $_GET["submit"];

                            if ($submit == "Calculate") {

                              // *** Edit these values below ***

                              $Effective_Date_YYYYMMDD = 20231201;

                              $Water_Meter_Size_5_8_inch = 24.11;
                              $Water_Meter_Size_3_4_inch = 24.11;
                              $Water_Meter_Size_1_inch = 38.98;
                              $Water_Meter_Size_1_1_2_inch = 76.16;
                              $Water_Meter_Size_2_inch = 120.77;
                              $Water_Meter_Size_3_inch = 276.92;
                              $Water_Meter_Size_4_inch = 462.80;
                              $Water_Meter_Size_6_inch = 1072.52;
                              $Water_Meter_Size_8_inch = 1645.05;
                              $Water_Meter_Size_10_inch = 3124.72;
                              $Water_Meter_Size_12_inch = 3942.63;
                              $Water_Meter_Size_16_inch = 5801.51;
                              $Water_Single_Family_Residential_Tier_1 = 6.0900;
                              $Water_Single_Family_Residential_Tier_2 = 6.8900;
                              $Water_Single_Family_Residential_Tier_3 = 8.6700;
                              $Water_Multi_Family_Residential = 7.1500;
                              $Water_Non_Residential = 6.9700; // Commercial
                              $Water_Irrigation = 8.2000;
                              $Water_Temporary_Construction = 7.8600;

                              $Wastewater_Service_Fee = 14.71; // Wastewater Base Fee
                              $Wastewater_Single_Family_Residential = 4.9770;
                              $Wastewater_Multi_Family_Residential = 4.9770;
                              $Wastewater_Commercial_Industrial_Flow = 3.319;
                              $Wastewater_Commercial_Industrial_COD = 0.216;
                              $Wastewater_Commercial_Industrial_TSS = 0.488;
                              $Wastewater_Trucked_Waste_Flow = 3.260;
                              $Wastewater_Trucked_Waste_COD = 0.216;
                              $Wastewater_Trucked_Waste_TSS = 0.488;

                              $Recycled_Water_Meter_Size_5_8_inch = 19.74;
                              $Recycled_Water_Meter_Size_3_4_inch = 19.74;
                              $Recycled_Water_Meter_Size_1_inch = 30.48;
                              $Recycled_Water_Meter_Size_1_1_2_inch = 57.34;
                              $Recycled_Water_Meter_Size_2_inch = 89.55;
                              $Recycled_Water_Meter_Size_3_inch = 191.59;
                              $Recycled_Water_Meter_Size_4_inch = 341.95;
                              $Recycled_Water_Meter_Size_6_inch = 701.76;
                              $Recycled_Water_Meter_Size_8_inch = 1507.29;
                              $Recycled_Water_Meter_Size_10_inch = 2259.12;
                              $Recycled_Water_Meter_Size_12_inch = 2849.84;
                              $Recycled_Water_Meter_Size_16_inch = 4192.40;
                              $Recycled_Water_Fee = 2.30;

                              $Fireline_Size_1_inch = 3.00;
                              $Fireline_Size_1_1_2_inch = 3.00;
                              $Fireline_Size_2_inch = 4.36;
                              $Fireline_Size_3_inch = 9.23;
                              $Fireline_Size_4_inch = 17.62;
                              $Fireline_Size_6_inch = 47.76;
                              $Fireline_Size_8_inch = 99.75;
                              $Fireline_Size_10_inch = 117.95;
                              $Fireline_Size_12_inch = 286.32;
                              $Fireline_Size_16_inch = 608.13;
                              $Fireline_Size_20_inch = 1092.18;

                              // *** Edit these values above ***

                              $Water_Customer = [
                                0,
                                0,
                                $Water_Multi_Family_Residential,
                                $Water_Non_Residential,
                                $Water_Irrigation,
                                $Water_Temporary_Construction
                              ];

                              $Water_Meter = [
                                0,
                                $Water_Meter_Size_5_8_inch,
                                $Water_Meter_Size_3_4_inch,
                                $Water_Meter_Size_1_inch,
                                $Water_Meter_Size_1_1_2_inch,
                                $Water_Meter_Size_2_inch,
                                $Water_Meter_Size_3_inch,
                                $Water_Meter_Size_4_inch,
                                $Water_Meter_Size_6_inch,
                                $Water_Meter_Size_8_inch,
                                $Water_Meter_Size_10_inch,
                                $Water_Meter_Size_12_inch,
                                $Water_Meter_Size_16_inch
                              ];

                              $Recycled_Water_Meter = [
                                0,
                                $Recycled_Water_Meter_Size_5_8_inch,
                                $Recycled_Water_Meter_Size_3_4_inch,
                                $Recycled_Water_Meter_Size_1_inch,
                                $Recycled_Water_Meter_Size_1_1_2_inch,
                                $Recycled_Water_Meter_Size_2_inch,
                                $Recycled_Water_Meter_Size_3_inch,
                                $Recycled_Water_Meter_Size_4_inch,
                                $Recycled_Water_Meter_Size_6_inch,
                                $Recycled_Water_Meter_Size_8_inch,
                                $Recycled_Water_Meter_Size_10_inch,
                                $Recycled_Water_Meter_Size_12_inch,
                                $Recycled_Water_Meter_Size_16_inch
                              ];

                              $Fireline = [
                                0,
                                $Fireline_Size_1_inch,
                                $Fireline_Size_1_1_2_inch,
                                $Fireline_Size_2_inch,
                                $Fireline_Size_3_inch,
                                $Fireline_Size_4_inch,
                                $Fireline_Size_6_inch,
                                $Fireline_Size_8_inch,
                                $Fireline_Size_10_inch,
                                $Fireline_Size_12_inch,
                                $Fireline_Size_16_inch,
                                $Fireline_Size_20_inch
                              ];

                              $showCalculation = FALSE;
                              $sewerservicechargefrombill = "Estimate: ";

                              if (isset($_GET["customertype"])) {
                                $customertype = $_GET["customertype"];
                              }
                              if (isset($_GET["watermetersize"])) {
                                $watermetersize = $_GET["watermetersize"];
                              }
                              if (isset($_GET["waterusage"])) {
                                $waterusage = $_GET["waterusage"];
                              }
                              if (isset($_GET["sewerservicecharge"])) {
                                $sewerservicecharge = $_GET["sewerservicecharge"];
                              }
                              if(is_numeric($sewerservicecharge)) {
                                $sewerservicewinterhcf = $sewerservicecharge;
                                $sewerservicechargefrombill = "From Water Bill: ";
                              } else {
                                $sewerservicewinterhcf = $waterusage;
                              }
                              if ($customertype and $watermetersize) {
                                if ($waterusage) {
                                  $showCalculation = TRUE;
                                }
                              }

                              if (isset($_GET["recycledwatermetersize"])) {
                                $recycledwatermetersize = $_GET["recycledwatermetersize"];
                              }
                              if (isset($_GET["recycledwaterusage"])) {
                                $recycledwaterusage = $_GET["recycledwaterusage"];
                              }
                              if ($recycledwatermetersize and $recycledwaterusage) {
                                $showCalculation = TRUE;
                              }

                              if (isset($_GET["firelinesize"])) {
                                $firelinesize = $_GET["firelinesize"];
                              }
                              if ($firelinesize) {
                                $showCalculation = TRUE;
                              }

                              if ($showCalculation) {
                                echo "<h2>Bill Estimate</h2>";
                                echo "<p>Here is your water bill estimate based on the information you entered:</p>";
                                echo "<table border='1' cellpadding='1' cellspacing='1' style='width:100%;' >\n<tbody>\n";
                                $effectiveDate = DateTime::createFromFormat('Ymd', $Effective_Date_YYYYMMDD);
                                $formattedDate = $effectiveDate->format('F j, Y');
                                echo "  <tr>\n<th colspan='2'>Period</th>\n<th class='commrow'>Rates Effective $formattedDate</th>\n</tr>\n";

                                $totalBill = 0;
                                $rowtotal = 0;
                                // Display Water Fees
                                if ($customertype >= 1 and $customertype <=5) {
                                  echo "	<tr><td><strong>Water Commodity Charge</strong></td>\n";
                                  echo "             <td><strong>Usage</strong></td>\n  <td class ='commrow'>&nbsp;</td> \n</tr>\n";
                                }
                                switch ($customertype) {
                                  case 1:
                                    if ($waterusage > 11) {
                                      $singleFamilyTier1 = $Water_Single_Family_Residential_Tier_1 * 5;
                                      echo "<tr>\n<td class='l-padding-lm'>Single-family Residential Tier 1 (1-5 HCF)</td>\n<td> 5 HCF</td>\n<td class='commrow'>$" . number_format($singleFamilyTier1, 2, '.', '') . "</td></tr>\n";
                                      $singleFamilyTier2 = $Water_Single_Family_Residential_Tier_2 * 6;
                                      echo "<tr>\n<td class='l-padding-lm'>Single-family Residential Tier 2 (6-11 HCF)</td>\n<td> 6 HCF</td>\n<td class='commrow'>$" . number_format($singleFamilyTier2, 2, '.', '') . "</td></tr>\n";
                                      $singleFamilyTier3 = $Water_Single_Family_Residential_Tier_3 * ($waterusage - 11);
                                      echo "<tr>\n<td class='l-padding-lm'>Single-family Residential Tier 3 (12+ HCF)</td>\n<td> " . ($waterusage - 11) . " HCF</td>\n<td class='commrow'>$" . number_format($singleFamilyTier3, 2, '.', '') . "</td></tr>\n";
                                      $rowtotal = $singleFamilyTier1 + $singleFamilyTier2 + $singleFamilyTier3;
                                    }
                                    elseif ($waterusage > 5) {
                                      $singleFamilyTier1 = $Water_Single_Family_Residential_Tier_1 * 5;
                                      echo "<tr>\n<td class='l-padding-lm'>Single-family Residential Tier 1 (0-5 HCF)</td>\n<td> 5 HCF</td>\n<td class='commrow'>$" . number_format($singleFamilyTier1, 2, '.', '') . "</td></tr>\n";
                                      $singleFamilyTier2 = $Water_Single_Family_Residential_Tier_2 * ($waterusage - 5);
                                      echo "<tr>\n<td class='l-padding-lm'>Single-family Residential Tier 2 (5-11 HCF)</td>\n<td> " . ($waterusage - 5) . " HCF</td>\n<td class='commrow'>$" . number_format($singleFamilyTier2, 2, '.', '') . "</td></tr>\n";
                                      $rowtotal = $singleFamilyTier1 + $singleFamilyTier2;
                                    }
                                    else {
                                      $singleFamilyTier1 = $Water_Single_Family_Residential_Tier_1 * $waterusage;
                                      echo "<tr>\n<td class='l-padding-lm'>Single-family Residential Tier 1 (0-5 HCF)</td>\n<td> " . $waterusage . " HCF</td>\n<td class='commrow'>$" . number_format($singleFamilyTier1, 2, '.', '') . "</td></tr>\n";
                                      $rowtotal = $singleFamilyTier1;
                                    }
                                    $totalBill += $rowtotal;
                                    echo "   <tr><td colspan='2' class='l-padding-lm'>Water Monthly Service Fee</td>\n<td class='commrow'>$" . number_format($Water_Meter[$watermetersize], 2, '.', '') . "</td></tr>\n";
                                    $totalBill += $Water_Meter[$watermetersize];
                                    break;
                                  case 2:
                                    $rowtotal = $Water_Multi_Family_Residential * $waterusage;
                                    $totalBill += $rowtotal;
                                    echo "<tr>\n<td class='l-padding-lm'>Multi-family Residential</td>\n<td> " . $waterusage . " HCF</td>\n<td class='commrow'>$" . number_format($rowtotal, 2, '.', '') . "</td></tr>\n";
                                    $totalBill += $Water_Meter[$watermetersize];
                                    echo "   <tr><td colspan='2' class='l-padding-lm'>Water Monthly Service Fee</td>\n<td class='commrow'>$" . number_format($Water_Meter[$watermetersize], 2, '.', '') . "</td></tr>\n";
                                    break;
                                  case 3:
                                    $rowtotal = $Water_Non_Residential * $waterusage;
                                    $totalBill += $rowtotal;
                                    echo "<tr>\n<td class='l-padding-lm'>Non-Residential</td>\n<td> " . $waterusage . " HCF</td>\n<td class='commrow'>$" . number_format($rowtotal, 2, '.', '') . "</td></tr>\n";
                                    $totalBill += $Water_Meter[$watermetersize];
                                    echo "   <tr><td colspan='2' class='l-padding-lm'>Water Monthly Service Fee</td>\n<td class='commrow'>$" . number_format($Water_Meter[$watermetersize], 2, '.', '') . "</td></tr>\n";
                                    break;
                                  case 4:
                                    $rowtotal = $Water_Irrigation * $waterusage;
                                    $totalBill += $rowtotal;
                                    echo "<tr>\n<td class='l-padding-lm'>Irrigation</td>\n<td> " . $waterusage . " HCF</td>\n<td class='commrow'>$" . number_format($rowtotal, 2, '.', '') . "</td></tr>\n";
                                    $totalBill += $Water_Meter[$watermetersize];
                                    echo "   <tr><td colspan='2' class='l-padding-lm'>Water Monthly Service Fee</td>\n<td class='commrow'>$" . number_format($Water_Meter[$watermetersize], 2, '.', '') . "</td></tr>\n";
                                    break;
                                  case 5:
                                    $rowtotal = $Water_Temporary_Construction * $waterusage;
                                    $totalBill += $rowtotal;
                                    echo "<tr>\n<td class='l-padding-lm'>Temporary Construction</td>\n<td> " . $waterusage . " HCF</td>\n<td class='commrow'>$" . number_format($rowtotal, 2, '.', '') . "</td></tr>\n";
                                    $totalBill += $Water_Meter[$watermetersize];
                                    echo "   <tr><td colspan='2' class='l-padding-lm'>Water Monthly Service Fee</td>\n<td class='commrow'>$" . number_format($Water_Meter[$watermetersize], 2, '.', '') . "</td></tr>\n";
                                    break;
                                  default:
                                    break;
                                }

                                //             Display Wastewater Fees
                                if ($customertype >= 1 and $customertype <=2) {
                                  echo "	<tr><td colspan='2'><strong>Sewer Service Charge</strong></td>\n";
                                  echo "           <td class ='commrow'>&nbsp;</td> \n</tr>\n";
                                }
                                switch ($customertype) {
                                  case 1:
                                    $sewerservicechargefrombill = "$" . $Wastewater_Single_Family_Residential . " * " . $sewerservicechargefrombill . $sewerservicewinterhcf . " HCF";
                                    $rowtotal = $Wastewater_Single_Family_Residential * $sewerservicewinterhcf;
                                    $rowtotal = $Wastewater_Single_Family_Residential;
                                    $totalBill += $rowtotal;
                                    echo "<tr>\n<td class='l-padding-lm' colspan='2'>Single-family Residential (monthly amount calculated)</td>\n<td class='commrow'><strong>$" . number_format($totalBill, 2, '.', '') . "</strong></td></tr>\n";
                                    $totalBill += $Wastewater_Service_Fee;
                                    echo "   <tr><td colspan='2' class='l-padding-lm'>Sewer Monthly Service Fee</td>\n<td class='commrow'>$" . number_format($Wastewater_Service_Fee, 2, '.', '') . "</td></tr>\n";
                                    echo "   <tr><td colspan='3'><strong>*</strong> Residential sewer charges are based on the account's water usage (HCF) from the past winter and are not calculated based on current water usage.</td></tr>\n";
                                    break;
                                  case 2:
                                    $sewerservicechargefrombill = "$" . $Wastewater_Multi_Family_Residential . " * " . $sewerservicechargefrombill . $sewerservicewinterhcf . " HCF";
                                    $rowtotal = $Wastewater_Multi_Family_Residential * $sewerservicewinterhcf;
                                    $totalBill += $rowtotal;
                                    echo "<tr>\n<td class='l-padding-lm' colspan='2'>Multi-family Residential (monthly amount calculated)</td>\n<td class='commrow'>$" . number_format($rowtotal, 2, '.', '') . "</td></tr>\n";
                                    $totalBill += $Wastewater_Service_Fee;
                                    echo "   <tr><td colspan='2' class='l-padding-lm'>Sewer Monthly Service Fee</td>\n<td class='commrow'>$" . number_format($Wastewater_Service_Fee, 2, '.', '') . "</td></tr>\n";
                                    echo "   <tr><td colspan='3'><strong>*</strong> Residential sewer charges are based on the account's water usage (HCF) from the past winter and are not calculated based on current water usage.</td></tr>\n";
                                    break;
                                  case 3:
                                    echo "   <tr><td colspan='3'><strong>*</strong> Non-Residential Wastewater customers are charged based on the flow and strength of wastewater, which is dependent on business operations. All factors (flow and strength for non-residential) and base meter fees are expected to decrease for non-residential customers and the class as a whole is expected to result in a 12% decrease in costs from the prior rates in effect. Individual bills will vary due to the unique characteristics  of each customer.</td></tr>\n";
                                    break;
                                  default:
                                    break;
                                }

                                // Display Recycled Water Fees
                                if ($recycledwatermetersize and $recycledwaterusage) {
                                  echo "	<tr><td><strong>Recycled Water Commodity Charge</strong></td>\n";
                                  echo "             <td><strong>Usage</strong></td>\n  <td class ='commrow'>&nbsp;</td> \n</tr>\n";
                                  $rowtotal = $Recycled_Water_Fee * $recycledwaterusage;
                                  $totalBill += $rowtotal;
                                  echo "<tr>\n<td class='l-padding-lm'>Recycled Water</td>\n<td> " . $recycledwaterusage . " HCF</td>\n<td class='commrow'>$" . number_format($rowtotal, 2, '.', '') . "</td></tr>\n";
                                  $totalBill += $Recycled_Water_Meter[$recycledwatermetersize];
                                  echo "   <tr><td colspan='2'><strong>Recycled Water Monthly Service Fee</strong></td>\n<td class='commrow'>$" . number_format($Recycled_Water_Meter[$recycledwatermetersize], 2, '.', '') . "</td></tr>\n";
                                }

                                // Display Fireline Fees
                                if ($firelinesize) {
                                  $totalBill += $Fireline[$firelinesize];
                                  echo "   <tr><td colspan='2'><strong>Fireline Monthly Service Fee</strong></td>\n<td class='commrow'>$" . number_format($Fireline[$firelinesize], 2, '.', '') . "</td></tr>\n";
                                }
                                // display total
                                echo "   <tr><td colspan='2'><strong>Bill Total</strong></td>\n<td class='commrow'><strong>$" . number_format($totalBill, 2, '.', '') . "</strong></td></tr>\n";
                                echo "	</tbody>\n</table>\n";
                                echo "  <ol type='a'><li>Calculations are rounded up to one cent.</li><li>View the <a href='https://www.sandiego.gov/public-utilities/customer-service/water-and-sewer-rates'>Water and Wastewater Rates</a>.</ol>\n";
                                echo "<h2>Calculate Again</h2>";
                              }
                            }
                          }
                          ?>


                            <p>Instructions: Provide the information requested below, then press 'Calculate'. Your Meter Size and Water Usage can be found on your <a href="https://www.sandiego.gov/public-utilities/customer-service/billing/how-to-read-your-bill">water bill</a>. Some accounts have more than one meter. For those accounts with multiple meters, you will need to run the calculator for each meter.</p>

                            <form action="" id="wbc" method="GET">
                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                    <tbody>
                                    <tr>
                                        <td><label for="customertype">Customer Type</label>:</td>
                                        <td colspan="2"><select id="customertype" name="customertype">
                                                <option value="">--select one--</option>
                                                <option value="1">Single Family Dwelling</option>
                                                <option value="2">Multi-family Dwelling</option>
                                                <option value="3">Non-Residential</option>
                                                <option value="4">Irrigation</option></option>
                                                <option value="5">Temporary Construction</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="watermetersize" class="l-padding-lm">Water Meter Size</label>:</td>
                                        <td colspan="2"><select id="watermetersize" name="watermetersize">
                                                <option value="">--select one--</option>
                                                <option value="1">5/8 inch</option>
                                                <option value="2">3/4 inch</option>
                                                <option value="3">1 inch</option>
                                                <option value="4">1 1/2 inch</option>
                                                <option value="5">2 inch</option>
                                                <option value="6">3 inch</option>
                                                <option value="7">4 inch</option>
                                                <option value="8">6 inch</option>
                                                <option value="9">8 inch</option>
                                                <option value="10">10 inch</option>
                                                <option value="11">12 inch</option>
                                                <option value="12">16 inch</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="waterusage" class="l-padding-lm">Monthly Water Usage (HCF)</label>:</td>
                                        <td><input id="waterusage" maxlength="9" name="waterusage" size="6" type="Text"><input id="hiddenfield" style="width:0; border:none;" type="hidden"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="sewerservicecharge" class="l-padding-lm">Sewer Service Charge</label>:</td>
                                        <td><input id="sewerservicecharge" maxlength="9" name="sewerservicecharge" size="6" type="Text" class="sewerservicechargeinput" style="display: none;"> <span class="sewerservicechargeinput" style="display: none;">(Use Bi-Monthly amount from bill)</span> <span class="sewerservicechargeinputdisabled">(Only for residential estimates)</span><input id="hiddenfield" style="width:0; border:none;" type="hidden"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="recycledwatermetersize">Recycled Water Meter Size</label>:</td>
                                        <td colspan="2"><select id="recycledwatermetersize" name="recycledwatermetersize">
                                                <option value="">--NA--</option>
                                                <option value="1">5/8 inch</option>
                                                <option value="2">3/4 inch</option>
                                                <option value="3">1 inch</option>
                                                <option value="4">1 1/2 inch</option>
                                                <option value="5">2 inch</option>
                                                <option value="6">3 inch</option>
                                                <option value="7">4 inch</option>
                                                <option value="8">6 inch</option>
                                                <option value="9">8 inch</option>
                                                <option value="10">10 inch</option>
                                                <option value="11">12 inch</option>
                                                <option value="12">16 inch</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="recycledwaterusage" class="l-padding-lm">Recycled Water Usage (HCF)</label>:</td>
                                        <td><input id="recycledwaterusage" maxlength="9" name="recycledwaterusage" size="6" type="Text"><input id="hiddenfield" style="width:0; border:none;" type="hidden"></td>
                                    </tr>

                                    <tr>
                                        <td><label for="firelinesize">Fireline Size</label>:</td>
                                        <td colspan="2"><select id="firelinesize" name="firelinesize">
                                                <option value="">--NA--</option>
                                                <option class="metersize" value="1">1 inch</option>
                                                <option class="metersize" value="2">1 1/2 inch</option>
                                                <option class="metersize" value="3">2 inch</option>
                                                <option class="metersize" value="4">3 inch</option>
                                                <option class="metersize" value="5">4 inch</option>
                                                <option class="metersize" value="6">6 inch</option>
                                                <option class="metersize" value="7">8 inch</option>
                                                <option class="metersize" value="8">10 inch</option>
                                                <option class="metersize" value="9">12 inch</option>
                                                <option class="metersize" value="10">16 inch</option>
                                                <option class="metersize" value="11">20 inch</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><input name="submit" type="Submit" value="Calculate" class="btn btn--tertiary"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>
                            <p><strong>This calculator provides monthly estimates. Most single-family customers receive a bill every other month so these customers should double the estimate provided by the calculator to reflect an actual bill.</strong></p>
                            <p><strong>Notes:</strong> This calculator only provides estimates. Your actual bill will vary depending on the length of the billing cycle and whether there are rate changes during the billing cycle. Rate changes are pro-rated depending on when they fall in the billing cycle. Monthly estimates by the calculator are based on a 30-day month. Actual billing cycles may slightly vary.</p>
                            <p>This calculator is only for a portion of your City of San Diego utility bill. It does not include storm water portions.</p>
                            <p>If you have any questions or comments, please contact the Public Utilities Department at 619-515-3516 or <a href="mailto:customercare@sandiego.gov">customercare@sandiego.gov</a>.</p>
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                            <script>
                              jQuery('#customertype').change(function(){
                                if(jQuery(this).val() == '1' || jQuery(this).val() == '2'){
                                  jQuery('.sewerservicechargeinput').show();
                                  jQuery('.sewerservicechargeinputdisabled').hide();
                                } else {
                                  jQuery('.sewerservicechargeinput').hide();
                                  jQuery('.sewerservicechargeinputdisabled').show();
                                }
                              });
                            </script>

                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>