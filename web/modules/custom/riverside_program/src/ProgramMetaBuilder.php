<?php

namespace Drupal\riverside_program;

use Drupal\node\NodeInterface;

/**
 * Builds the schedule/price/level "meta" string for a Program node.
 *
 * Only build this module if you want the SAME logic reachable from both
 * theme preprocess and a non-theme context (e.g. a JSON:API resource or
 * REST normalizer). If preprocess alone is enough for your submission,
 * skip this module entirely — the brief explicitly rewards restraint.
 */
class ProgramMetaBuilder {

  public function buildLine(NodeInterface $node): string {
    $date_range = $this->formatDateRange($node);
    $price = $this->formatPrice($node);
    $level = $node->get('field_level')->value ?? '';

    return implode(' · ', array_filter([$date_range, $price, $level]));
  }

  protected function formatDateRange(NodeInterface $node): string {
    if ($node->get('field_date_range')->isEmpty()) {
      return '';
    }
    $item = $node->get('field_date_range')->first();
    $start = new \DateTime($item->value);
    $end = !empty($item->end_value) ? new \DateTime($item->end_value) : NULL;

    if (!$end || $start->format('Y-m-d') === $end->format('Y-m-d')) {
      return $start->format('D, M j');
    }
    return $start->format('M j') . ' – ' . $end->format('M j');
  }

  protected function formatPrice(NodeInterface $node): string {
    $standard = $node->get('field_price_standard')->value;
    if ($standard === NULL || $standard === '') {
      return 'Free';
    }
    $standard_fmt = '$' . number_format((float) $standard, 0);
    $member = $node->get('field_price_member')->value ?? NULL;
    if ($member === NULL || $member === '') {
      return $standard_fmt;
    }
    return $standard_fmt . ' (' . '$' . number_format((float) $member, 0) . ' members)';
  }

}