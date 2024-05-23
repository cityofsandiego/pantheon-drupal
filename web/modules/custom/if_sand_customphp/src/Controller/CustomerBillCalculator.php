<?php

namespace Drupal\if_sand_customphp\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Elected Offices and Departments.
 */
class CustomerBillCalculator extends ControllerBase {

  /**
   * Inline PHP from D7 site.
   *
   * I changed the echo statement to a large $output string that is returned
   * as a JSON response so the page no longer needs to reload.
   *
   * I also changed $_GET to use \Drupal::request()->request->get() instead.
   *
   */
  public function response() {

    // *** Edit these values below ***

    $Date_YYYYMM = 202301;

    $Water_Meter_Size_5_8_inch = 27.77;
    $Water_Meter_Size_3_4_inch = 27.77;
    $Water_Meter_Size_1_inch = 36.77;
    $Water_Meter_Size_1_1_2_inch = 57.37;
    $Water_Meter_Size_2_inch = 83.11;
    $Water_Meter_Size_3_inch = 143.59;
    $Water_Meter_Size_4_inch = 229.83;
    $Water_Meter_Size_6_inch = 443.47;
    $Water_Meter_Size_8_inch = 700.86;
    $Water_Meter_Size_10_inch = 1002.01;
    $Water_Meter_Size_12_inch = 1859.13;
    $Water_Meter_Size_16_inch = 3232.34;
    $Water_Single_Family_Residential_Tier_1 = 5.5500;
    $Water_Single_Family_Residential_Tier_2 = 6.2170;
    $Water_Single_Family_Residential_Tier_3 = 8.8810;
    $Water_Single_Family_Residential_Tier_4 = 12.4880;
    $Water_Multi_Family_Residential = 6.7170;
    $Water_Non_Residential = 6.5540; // Commercial
    $Water_Irrigation = 7.4470;
    $Water_Temporary_Construction = 7.5730;

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

    $Fireline_Size_1_inch = 4.13;
    $Fireline_Size_1_1_2_inch = 4.13;
    $Fireline_Size_2_inch = 6.40;
    $Fireline_Size_3_inch = 24.77;
    $Fireline_Size_4_inch = 31.67;
    $Fireline_Size_6_inch = 46.78;
    $Fireline_Size_8_inch = 66.07;
    $Fireline_Size_10_inch = 85.35;
    $Fireline_Size_12_inch = 101.85;
    $Fireline_Size_16_inch = 165.16;
    $Fireline_Size_20_inch = 205.64;

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

    if (\Drupal::request()->request->get('customertype') !== NULL) {
      $customertype = \Drupal::request()->request->get('customertype');
    }
    if (\Drupal::request()->request->get('watermetersize') !== NULL) {
      $watermetersize = \Drupal::request()->request->get('watermetersize');
    }
    if (\Drupal::request()->request->get('waterusage') !== NULL) {
      $waterusage = \Drupal::request()->request->get('waterusage');
    }
    if (\Drupal::request()->request->get('sewerservicecharge') !== NULL) {
      $sewerservicecharge = \Drupal::request()->request->get('sewerservicecharge');
    }
    if (is_numeric($sewerservicecharge)) {
      $sewerservicewinterhcf = $sewerservicecharge;
      $sewerservicechargefrombill = "From Water Bill: ";
    }
    else {
      $sewerservicewinterhcf = $waterusage;
    }
    if ($customertype and $watermetersize) {
      if ($waterusage) {
        $showCalculation = TRUE;
      }
    }

    if (\Drupal::request()->request->get('recycledwatermetersize') !== NULL) {
      $recycledwatermetersize = \Drupal::request()->request->get('recycledwatermetersize');
    }
    if (\Drupal::request()->request->get('recycledwaterusage') !== NULL) {
      $recycledwaterusage = \Drupal::request()->request->get('recycledwaterusage');
    }
    if ($recycledwatermetersize and $recycledwaterusage) {
      $showCalculation = TRUE;
    }

    if (\Drupal::request()->request->get('firelinesize') !== NULL) {
      $firelinesize = \Drupal::request()->request->get('firelinesize');
    }
    if ($firelinesize) {
      $showCalculation = TRUE;
    }

    $output = '';

    if ($showCalculation) {
      $output .= "<h2>Bill Estimate</h2>";
      $output .= "<p>Here is your water bill estimate based on the information you entered:</p>";
      $output .= "<table border='1' cellpadding='1' cellspacing='1' style='width:100%;' >\n<tbody>\n";
      $output .= "	<tr>\n<th colspan='2'>Period</td>\n<th class='commrow'>Rates Effective January 1, 2022</td>\n</tr>\n";

      $totalBill = 0;
      $rowtotal = 0;
      // Display Water Fees
      if ($customertype >= 1 and $customertype <= 5) {
        $output .= "	<tr><td><strong>Water Commodity Charge</strong></td>\n";
        $output .= "             <td><strong>Usage</strong></td>\n  <td class ='commrow'>&nbsp;</td> \n</tr>\n";
      }
      switch ($customertype) {
        case 1:
          if ($waterusage > 18) {
            $singleFamilyTier1 = $Water_Single_Family_Residential_Tier_1 * 4;
            $output .= "<tr>\n<td class='l-padding-lm'>Single-family Residential Tier 1 (0-4 HCF)</td>\n<td> 4 HCF</td>\n<td class='commrow'>$" . round($singleFamilyTier1, 2) . "</td></tr>\n";
            $singleFamilyTier2 = $Water_Single_Family_Residential_Tier_2 * 8;
            $output .= "<tr>\n<td class='l-padding-lm'>Single-family Residential Tier 2 (4-12 HCF)</td>\n<td> 8 HCF</td>\n<td class='commrow'>$" . round($singleFamilyTier2, 2) . "</td></tr>\n";
            $singleFamilyTier3 = $Water_Single_Family_Residential_Tier_3 * 6;
            $output .= "<tr>\n<td class='l-padding-lm'>Single-family Residential Tier 3 (12-18 HCF)</td>\n<td> 6 HCF</td>\n<td class='commrow'>$" . round($singleFamilyTier3, 2) . "</td></tr>\n";
            $singleFamilyTier4 = $Water_Single_Family_Residential_Tier_4 * ($waterusage - 18);
            $output .= "<tr>\n<td class='l-padding-lm'>Single-family Residential Tier 4 (18+ HCF)</td>\n<td>" . ($waterusage - 18) . " HCF</td>\n<td class='commrow'>$" . round($singleFamilyTier4, 2) . "</td></tr>\n";
            $rowtotal = $singleFamilyTier1 + $singleFamilyTier2 + $singleFamilyTier3 + $singleFamilyTier4;
          }
          elseif ($waterusage > 12) {
            $singleFamilyTier1 = $Water_Single_Family_Residential_Tier_1 * 4;
            $output .= "<tr>\n<td class='l-padding-lm'>Single-family Residential Tier 1 (0-4 HCF)</td>\n<td> 4 HCF</td>\n<td class='commrow'>$" . round($singleFamilyTier1, 2) . "</td></tr>\n";
            $singleFamilyTier2 = $Water_Single_Family_Residential_Tier_2 * 8;
            $output .= "<tr>\n<td class='l-padding-lm'>Single-family Residential Tier 2 (4-12 HCF)</td>\n<td> 8 HCF</td>\n<td class='commrow'>$" . round($singleFamilyTier2, 2) . "</td></tr>\n";
            $singleFamilyTier3 = $Water_Single_Family_Residential_Tier_3 * ($waterusage - 12);
            $output .= "<tr>\n<td class='l-padding-lm'>Single-family Residential Tier 3 (12-18 HCF)</td>\n<td> " . ($waterusage - 12) . " HCF</td>\n<td class='commrow'>$" . round($singleFamilyTier3, 2) . "</td></tr>\n";
            $rowtotal = $singleFamilyTier1 + $singleFamilyTier2 + $singleFamilyTier3;
          }
          elseif ($waterusage > 4) {
            $singleFamilyTier1 = $Water_Single_Family_Residential_Tier_1 * 4;
            $output .= "<tr>\n<td class='l-padding-lm'>Single-family Residential Tier 1 (0-4 HCF)</td>\n<td> 4 HCF</td>\n<td class='commrow'>$" . round($singleFamilyTier1, 2) . "</td></tr>\n";
            $singleFamilyTier2 = $Water_Single_Family_Residential_Tier_2 * ($waterusage - 4);
            $output .= "<tr>\n<td class='l-padding-lm'>Single-family Residential Tier 2 (4-12 HCF)</td>\n<td> " . ($waterusage - 4) . " HCF</td>\n<td class='commrow'>$" . round($singleFamilyTier2, 2) . "</td></tr>\n";
            $rowtotal = $singleFamilyTier1 + $singleFamilyTier2;
          }
          else {
            $singleFamilyTier1 = $Water_Single_Family_Residential_Tier_1 * $waterusage;
            $output .= "<tr>\n<td class='l-padding-lm'>Single-family Residential Tier 1 (0-4 HCF)</td>\n<td> " . $waterusage . " HCF</td>\n<td class='commrow'>$" . round($singleFamilyTier1, 2) . "</td></tr>\n";
            $rowtotal = $singleFamilyTier1;
          }
          $totalBill += $rowtotal;
          $output .= "   <tr><td colspan='2' class='l-padding-lm'>Water Monthly Service Fee</td>\n<td class='commrow'>$" . round($Water_Meter[$watermetersize], 2) . "</td></tr>\n";
          $totalBill += $Water_Meter[$watermetersize];
          break;
        case 2:
          $rowtotal = $Water_Multi_Family_Residential * $waterusage;
          $totalBill += $rowtotal;
          $output .= "<tr>\n<td class='l-padding-lm'>Multi-family Residential</td>\n<td> " . $waterusage . " HCF</td>\n<td class='commrow'>$" . round($rowtotal, 2) . "</td></tr>\n";
          $totalBill += $Water_Meter[$watermetersize];
          $output .= "   <tr><td colspan='2' class='l-padding-lm'>Water Monthly Service Fee</td>\n<td class='commrow'>$" . round($Water_Meter[$watermetersize], 2) . "</td></tr>\n";
          break;
        case 3:
          $rowtotal = $Water_Non_Residential * $waterusage;
          $totalBill += $rowtotal;
          $output .= "<tr>\n<td class='l-padding-lm'>Non-Residential</td>\n<td> " . $waterusage . " HCF</td>\n<td class='commrow'>$" . round($rowtotal, 2) . "</td></tr>\n";
          $totalBill += $Water_Meter[$watermetersize];
          $output .= "   <tr><td colspan='2' class='l-padding-lm'>Water Monthly Service Fee</td>\n<td class='commrow'>$" . round($Water_Meter[$watermetersize], 2) . "</td></tr>\n";
          break;
        case 4:
          $rowtotal = $Water_Irrigation * $waterusage;
          $totalBill += $rowtotal;
          $output .= "<tr>\n<td class='l-padding-lm'>Irrigation</td>\n<td> " . $waterusage . " HCF</td>\n<td class='commrow'>$" . round($rowtotal, 2) . "</td></tr>\n";
          $totalBill += $Water_Meter[$watermetersize];
          $output .= "   <tr><td colspan='2' class='l-padding-lm'>Water Monthly Service Fee</td>\n<td class='commrow'>$" . round($Water_Meter[$watermetersize], 2) . "</td></tr>\n";
          break;
        case 5:
          $rowtotal = $Water_Temporary_Construction * $waterusage;
          $totalBill += $rowtotal;
          $output .= "<tr>\n<td class='l-padding-lm'>Temporary Construction</td>\n<td> " . $waterusage . " HCF</td>\n<td class='commrow'>$" . round($rowtotal, 2) . "</td></tr>\n";
          $totalBill += $Water_Meter[$watermetersize];
          $output .= "   <tr><td colspan='2' class='l-padding-lm'>Water Monthly Service Fee</td>\n<td class='commrow'>$" . round($Water_Meter[$watermetersize], 2) . "</td></tr>\n";
          break;
        default:
          break;
      }

      // Display Wastewater Fees
      if ($customertype >= 1 and $customertype <= 2) {
        $output .= "	<tr><td colspan='2'><strong>Sewer Service Charge</strong></td>\n";
        $output .= "           <td class ='commrow'>&nbsp;</td> \n</tr>\n";
      }
      switch ($customertype) {
        case 1:
          $sewerservicechargefrombill = "$" . $Wastewater_Single_Family_Residential . " * " . $sewerservicechargefrombill . $sewerservicewinterhcf . " HCF";
          $rowtotal = $Wastewater_Single_Family_Residential * $sewerservicewinterhcf;
          $totalBill += $rowtotal;
          $output .= "<tr>\n<td class='l-padding-lm' colspan='2'>Single-family Residential (monthly amount calculated)</td>\n<td class='commrow'>$" . round($rowtotal, 2) . "</td></tr>\n";
          $totalBill += $Wastewater_Service_Fee;
          $output .= "   <tr><td colspan='2' class='l-padding-lm'>Sewer Monthly Service Fee</td>\n<td class='commrow'>$" . round($Wastewater_Service_Fee, 2) . "</td></tr>\n";
          $output .= "   <tr><td colspan='3'><strong>*</strong> Residential sewer charges are based on the account's water usage (HCF) from the past winter and are not calculated based on current water usage.</td></tr>\n";
          break;
        case 2:
          $sewerservicechargefrombill = "$" . $Wastewater_Multi_Family_Residential . " * " . $sewerservicechargefrombill . $sewerservicewinterhcf . " HCF";
          $rowtotal = $Wastewater_Multi_Family_Residential * $sewerservicewinterhcf;
          $totalBill += $rowtotal;
          $output .= "<tr>\n<td class='l-padding-lm' colspan='2'>Multi-family Residential (monthly amount calculated)</td>\n<td class='commrow'>$" . round($rowtotal, 2) . "</td></tr>\n";
          $totalBill += $Wastewater_Service_Fee;
          $output .= "   <tr><td colspan='2' class='l-padding-lm'>Sewer Monthly Service Fee</td>\n<td class='commrow'>$" . round($Wastewater_Service_Fee, 2) . "</td></tr>\n";
          $output .= "   <tr><td colspan='3'><strong>*</strong> Residential sewer charges are based on the account's water usage (HCF) from the past winter and are not calculated based on current water usage.</td></tr>\n";
          break;
        case 3:
          $output .= "   <tr><td colspan='3'><strong>*</strong> Non-Residential Wastewater customers are charged based on the flow and strength of wastewater, which is dependent on business operations. All factors (flow and strength for non-residential) and base meter fees are expected to decrease for non-residential customers and the class as a whole is expected to result in a 12% decrease in costs from the prior rates in effect. Individual bills will vary due to the unique characteristics  of each customer.</td></tr>\n";
          break;
        default:
          break;
      }

      // Display Recycled Water Fees
      if ($recycledwatermetersize and $recycledwaterusage) {
        $output .= "	<tr><td><strong>Recycled Water Commodity Charge</strong></td>\n";
        $output .= "             <td><strong>Usage</strong></td>\n  <td class ='commrow'>&nbsp;</td> \n</tr>\n";
        $rowtotal = $Recycled_Water_Fee * $recycledwaterusage;
        $totalBill += $rowtotal;
        $output .= "<tr>\n<td class='l-padding-lm'>Recycled Water</td>\n<td> " . $recycledwaterusage . " HCF</td>\n<td class='commrow'>$" . round($rowtotal, 2) . "</td></tr>\n";
        $totalBill += $Recycled_Water_Meter[$recycledwatermetersize];
        $output .= "   <tr><td colspan='2'><strong>Recycled Water Monthly Service Fee</strong></td>\n<td class='commrow'>$" . round($Recycled_Water_Meter[$recycledwatermetersize], 2) . "</td></tr>\n";
      }

      // Display Fireline Fees
      if ($firelinesize) {
        $totalBill += $Fireline[$firelinesize];
        $output .= "   <tr><td colspan='2'><strong>Fireline Monthly Service Fee</strong></td>\n<td class='commrow'>$" . round($Fireline[$firelinesize], 2) . "</td></tr>\n";
      }
      // display total
      $output .= "   <tr><td colspan='2'><strong>Bill Total</strong></td>\n<td class='commrow'>$" . round($totalBill, 2) . "</td></tr>\n";
      $output .= "	</tbody>\n</table>\n";
      $output .= "  <ol type='a'><li>Calculations are rounded up to one cent.</li><li>View the <a href='/public-utilities/customer-service/water-and-sewer-rates/increases'>Water and Wastewater Rates</a>.</ol>\n";
      $output .= "<h2>Calculate Again</h2>";
    }
    return new JsonResponse($output);
  }


}
