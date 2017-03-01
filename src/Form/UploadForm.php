<?php

namespace Drupal\horse_uploader\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\File\FileSystem;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;

/**
 * Class UploadForm.
 *
 * @package Drupal\horse_uploader\Form
 */
class UploadForm extends FormBase {

  /**
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * Drupal\Core\File\FileSystem definition.
   *
   * @var \Drupal\Core\File\FileSystem
   */
  protected $fileSystem;

  public function __construct(
    FileSystem $file_system,
    AccountInterface $current_user
  ) {
    $this->fileSystem = $file_system;
    $this->currentUser = $current_user;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('file_system'),
      $container->get('current_user')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'upload_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['file_zip'] = [
      '#type' => 'file',
      '#title' => $this->t('Upload zip file'),
      '#description' => $this->t('Upload a zip file.'),
    ];


    $form['file_image'] = [
      '#type' => 'plupload',
      '#title' => $this->t('Upload image files'),
      '#description' => $this->t('Upload image files.'),
      '#autoupload' => TRUE,
      //'#autosubmit' => TRUE,
      //'#submit_element' => '#id-of-your-submit-element',
      '#upload_validators' => array(
        'file_validate_extensions' => array('jpg jpeg gif png'),
        //'my_custom_file_validator' => array('some validation criteria'),
      ),
      '#plupload_settings' => array(
        'runtimes' => 'html5',
        'chunk_size' => '1mb',
      ),
      '#event_callbacks' => array(
        //'FilesAdded' => 'Drupal.mrhorse_uploader.filesAddedCallback',
        //'UploadComplete' => 'Drupal.mrhorse_uploader.uploadCompleteCallback',
      ),
    ];

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => t('Submit'),
    ];

    return $form;
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    $zip = $form_state->getValue('file_zip');
    $images = $form_state->getValue('file_image');

    if($images) {
      foreach ($images as $image) {

        $tempfile = $this->fileSystem->realpath($image['tmppath']);
        $filename = $image['name'];
/*
        $file = file_save_data($data, 'public://' . $this->currentUser->id() . '/' . $, FILE_EXISTS_RENAME);


        $node = Node::create([
          'type' => 'photo',
          'langcode' => 'en',
          'created' => REQUEST_TIME,
          'changed' => REQUEST_TIME,
          'uid' => $this->currentUser()->id(),
          'title' => '',
          'field_tags' =>[2],
          'body' => [
            'summary' => '',
            'value' => 'My node!',
            'format' => 'full_html',
          ],
          'field_images' => [
            [
              'target_id' => $file->id(),
              'alt' => "My 'alt'",
              'title' => "My 'title'",
            ],
          ],
        ]);
        $node->save();
        //\Drupal::service('path.alias_storage')->save('/node/' . $node->id(), '/my-path', 'en');

*/

        // Create node object with attached file.
/*
        $node = Node::create([
          'type'        => 'article',
          'title'       => 'Druplicon test',
          'field_image' => [
            'target_id' => $file->id(),
            'alt' => 'Hello world',
            'title' => 'Goodbye world'
          ],
        ]);
*/
      }
    }

    foreach ($form_state->getValues() as $key => $value) {
        //drupal_set_message($key . ': ' . $value);

    }
    if (!empty($form_state->getValues())) {

      //File::create('')

      //File::create()->
      //$file = file_save_data($data, 'public://druplicon.png', FILE_EXISTS_REPLACE);

      // Create node object with attached file.
      /*
      $node = Node::create([
        'type'        => 'article',
        'title'       => 'Druplicon test',
        'field_image' => [
          'target_id' => $file->id(),
          'alt' => 'Hello world',
          'title' => 'Goodbye world'
        ],
      ]);
      */
    }

  }

}
