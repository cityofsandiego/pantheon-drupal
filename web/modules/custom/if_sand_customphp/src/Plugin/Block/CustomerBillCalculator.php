<?php

namespace Drupal\if_sand_customphp\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides the customer bill calculator block.
 *
 * @Block(
 *   id = "customer_bill_calculator",
 *   admin_label = @Translation("Customer Bill Calculator"),
 *   category = @Translation("Custom SAND PHP blocks"),
 * )
 */
class CustomerBillCalculator extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'customer_bill_calculator',
    ];
  }
}