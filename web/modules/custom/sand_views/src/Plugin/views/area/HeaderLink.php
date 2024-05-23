<?php

namespace Drupal\sand_views\Plugin\views\area;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\node\NodeInterface;
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
        $options['link_taxonomy_field']['default'] = 'field_department';
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
            '#description' => $this->t('Start the URL with a slash. If you are using this for draggable views and sorting the current items by drag and drop on another page, this should be the url to that page (you have to look in the view)'),
            '#required' => TRUE,
            '#default_value' => $this->options['link_url'],
            '#size' => 60,
            '#maxlength' => 128,
        ];
        $form['link_taxonomy_field'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Link Taxonomy Field'),
            '#description' => $this->t('This is the field name of the taxonomy term that the view uses.'),
            '#default_value' => $this->options['link_taxonomy_field'],
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

        // Make sure we are on a page with a node.
        $node = \Drupal::routeMatch()->getParameter('node');
        if (!$node instanceof NodeInterface) {
            return '';
        }

        // Make sure we have the current URI, otherwise this won't work. Hopefully, should not hit this.
        if (empty($_SERVER["REQUEST_URI"])) {
            return '';
        } else {
            // Set the query destination to this page so that after you click save on the sort it returns.
            $options = ['query' => ['destination' => $_SERVER["REQUEST_URI"]]];
        }
        
        // Make sure the field exists on the node.
        if (!$node->hasField($this->options['link_taxonomy_field'])) {
            return '';
        } else {
            $field_name = $this->options['link_taxonomy_field'];
        }
        
        // Get all the taxonomy terms in $field_name.
        $tids = $node->{$field_name}->getValue();
        if (!empty($tids)) {
            foreach ($tids as $key => $tid) {
                $options['query']["term[$key]"] = $tid['target_id'];
            }
        }
        
        // Add classes.
        if (!empty($this->options['link_classes'])) {
            $options['attributes'] = ['class' => $this->options['link_classes']];
        }

        
        // Only render the link if the user is logged in.
        if (!$empty && \Drupal::currentUser()->isAuthenticated()) {
            $item = [
                '#type' => 'link',
                '#title' =>  $this->t($this->options['link_text']),
                '#url' => Url::fromUserInput($this->options['link_url'] . '?destination=' . $_SERVER["REQUEST_URI"], $options),
            ];
            return $item;
        }
    }
}
