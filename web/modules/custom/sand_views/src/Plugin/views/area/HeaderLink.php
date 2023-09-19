<?php

namespace Drupal\sand_views\Plugin\views\area;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\views\Plugin\views\area\AreaPluginBase;
use Drupal\views\Annotation\ViewsArea;

/**
 * Views area header link handler.
 * 
 * NOTE: This was taken from the example at this address:
 *   https://drupalize.me/tutorial/define-custom-views-area-handler-plugin
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("header_link")
 */
class HeaderLink extends AreaPluginBase
{

    /**
     * {@inheritdoc}
     */
    protected function defineOptions()
    {
        $options = parent::defineOptions();
        $options['link_text']['default'] = 'Click here to order the items below';
        $options['link_url']['default'] = '';
        $options['link_classes']['default'] = '';
        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function buildOptionsForm(&$form, FormStateInterface $form_state)
    {
        parent::buildOptionsForm($form, $form_state);
        $form['link_text'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Link text'),
            '#required' => TRUE,
            '#size' => 60,
            '#default_value' => $this->options['link_text'],
            '#maxlength' => 128,
        ];
        $form['link_classes'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Classes that will go on the link'),
            '#size' => 60,
            '#default_value' => $this->options['link_classes'],
            '#maxlength' => 128,
        ];
        $form['link_url'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Link URL'),
            '#description' => $this->t('Start the URL with a slash, this should be the url to the sort page in the view'),
            '#required' => TRUE,
            '#default_value' => $this->options['link_url'],
            '#size' => 60,
            '#maxlength' => 128,
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function validate() {
        $errors = parent::validate();

        if (strpos($this->options['link_url'], '/') !== 0) {
            $errors[] = $this->t('%current_display: The link in the %area area must start with a slash.', [
                '%current_display' => $this->displayHandler->display['display_title'],
                '%area' => $this->areaType,
            ]);
            return $errors;
        }
    }    
    
    
    /**
     * {@inheritdoc}
     */
    public function render($empty = FALSE) {
        
        // Make sure we have the current URI, otherwise this won't work.
//        if ($empty($_SERVER["REQUEST_URI"])) {
//            return;
//        }
        
        if (!empty($this->options['link_classes'])) {
            $options = [
                'attributes' => ['class' => $this->options['link_classes']],
            ];
        } else {
            $options = [];
        }
        
        
        if (!$empty && \Drupal::currentUser()->isAuthenticated()) {
            $text = $this->t($this->options['link_text']);
            $url = Url::fromUserInput($this->options['link_url'] . '?destination=' . $_SERVER["REQUEST_URI"], $options);
            $item = [
                '#type' => 'link',
                '#title' => $text,
                '#url' => $url,
            ];
            return $item;
        }
    }
}
