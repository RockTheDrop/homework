<?php

/**
 * @file
 * Contains \Drupal\homework\Form\PersonSearchForm
 */
namespace Drupal\homework\Form;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class PersonSearchForm extends FormBase {
  public function getFormId() {
    return 'person_search_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['last_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Candidate Last Name'),
    );
/*
    $form['first_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Candidate First Name'),
    );
*/
    $form['address'] = array(
      '#type' => 'textfield',
      '#title' => t('Candidate Street Address'),
      '#description' => t('Please do not include city state or zip'),
    );

    $form['gender'] = array(
      '#type' => 'select',
      '#title' => t('Gender'),
      '#options' => array(
        'any' => t('Any'),
        'F' => t('Female'),
        'M' => t('Male'),
      ),
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => 'SEARCH',
      '#button_type' => 'primary',
    );

    $form['#method'] = 'post';
//    $form['#action'] = '/persons-with-search';

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('first_name') == 'khalim') {
      $form_state->setErrorByName('first_name', $this->t('Khalim is not allowed'));
    }

  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $last_name = $form_state->getValue('last_name');
    $address = $form_state->getValue('address');
    $gender = $form_state->getValue('gender');

    $last_name = empty($last_name) ? "all" : $last_name;
    $address = empty($address) ? "all" : $address;
    $gender = empty($gender) ? "any" : $gender;

    $q_string = "?last_name={$last_name}&address={$address}&gender={$gender}";

    $response = new RedirectResponse('/person-search' . $q_string);

    $request = \Drupal::request();
    // Save the session so things like messages get saved.
    $request->getSession()->save();
    $response->prepare($request);
    // Make sure to trigger kernel events.
    \Drupal::service('kernel')->terminate($request, $response);
    $response->send();
  
/*    if ($form_state->getValue('first_name')
    foreach ($form_state->getValues() as $key => $value) {
      drupal_set_message($key . ': ' . $value);
    }
*/

  }
}
