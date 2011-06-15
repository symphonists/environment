<?php

  Class Extension_Environment extends Extension {
    public function about() {
      return array(
        'name' => 'Environment',
        'version' => '1.0',
        'release-date' => '2011-06-15',
        'author' => array(
          'name' => 'Max Whee;er',
          'website' => 'http://icelab.com.au/',
          'email' => 'max@icelab.com.au'
        ),
        'description' => 'Adds a preference to expose the current environment as a parameter.'
      );
    }

    public function install() {
      // Set environment to development by default
      Symphony::Configuration()->set('environment', 'development', 'environment');
      Administration::instance()->saveConfig();
    }

    public function uninstall() {
      Symphony::Configuration()->remove('environment');
    }


    public function getSubscribedDelegates(){
      return array(
        array(
          'page' => '/system/preferences/',
          'delegate' => 'AddCustomPreferenceFieldsets',
          'callback' => 'appendPreferences'
        ),
        array(
          'page' => '/system/preferences/',
          'delegate' => 'Save',
          'callback' => 'savePreferences'
        ),
        array(
          'page' => '/frontend/',
          'delegate' => 'FrontendParamsResolve',
          'callback' => 'addParam'
        )
      );
    }


    /**
     * Append Environment preferences
     *
     * @param array $context
     *  delegate context
     */
    public function appendPreferences($context) {

      // Create preference group
      $group = new XMLElement('fieldset');
      $group->setAttribute('class', 'settings');
      $group->appendChild(new XMLElement('legend', __('Environment')));      
      
      // Append settings
      $label = Widget::Label();
      $current = Symphony::Configuration()->get('environment', 'environment');
      $select = Widget::Select('settings[environment][environment]',
        array(
          array('development', ('development' == $current) ? true : false, "Development"),
          array('staging', ('staging' == $current) ? true : false, "Staging"),
          array('production', ('production' == $current) ? true : false, "Production")
        )
      );
      $label->setValue($select->generate());
      $group->appendChild($label);
      
      // Append help
      $group->appendChild(new XMLElement('p', __('Will be output to the parameter pool as <code>$environment</code>.'), array('class' => 'help')));
      
      // Append new preference group      
      $context['wrapper']->appendChild($group);
    } 
    
    /**
     * Save preferences
     *
     * @param array $context
     *  delegate context
     */
    public function __SavePreferences($context) {
      // Set environment to development by default
      if(!is_array($context['settings'])) {
        $context['settings'] = array('environment' => array('environment' => 'development'));
      }
    }
    
    /**
     * Add environment to parameter pool
     *
     * @param array $context
     *  delegate context
     */
    public function addParam($context) {
      $environment = Symphony::Configuration()->get('environment', 'environment');
      $context['params']['environment'] = (isset($environment) ? $environment : 'development'); 
    }
  }