<?php

namespace Drupal\float_on_page_scroll\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Render\FormattableMarkup;

/**
 * Provides a floating video block.
 *
 * @Block(
 *   id = "float_on_page_scrool_example",
 *   admin_label = @Translation("Floating Video"),
 *   category = @Translation("Float on Page Scroll")
 * )
 */
class FloatBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'src' => 'https://www.youtube.com/embed/B3vs2zgHwgA',
      'width' => '560',
      'height' => '315',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['src'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Source URL'),
      '#default_value' => $this->configuration['src'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['src'] = $form_state->getValue('src');
    $this->configuration['width'] = $form_state->getValue('width');
    $this->configuration['height'] = $form_state->getValue('height');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Attach CSS file.
    $build['#attached']['library'][] = 'float_on_page_scroll/float_on_page_scroll';

    // Get configuration values.
    $src = $this->configuration['src'];

    // Build block content.
    $iframe = '<section class="videowrapper ytvideo">
    <a href="javascript:void(0);" class="close-button"></a>
    <div class="gradient-overlay"></div>
    <i class="fa fa-arrows-alt" aria-hidden="true"></i>
    <iframe class="featured-video" width="560" height="315" src="' . $src . '?enablejsapi=1&amp;rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</section>';

    // Wrap the iframe content in a FormattableMarkup object.
    $build['#markup'] = new FormattableMarkup($iframe, []);

    return $build;
  }

   /**
   * Generate a unique ID for the block.
   *
   * @return string
   *   A unique identifier.
   */
  private function getUniqueId() {
    // Use the block plugin ID and a timestamp to generate a unique ID.
    return $this->getPluginId() . '-' . time();
  }

}
