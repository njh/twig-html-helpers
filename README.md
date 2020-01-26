Twig HTML Helpers Extension
===========================

[![Build Status](https://travis-ci.org/njh/twig-html-helpers.svg?branch=master)](https://travis-ci.org/njh/twig-html-helpers)

This [PHP Twig] extension adds the following Rails style HTML helpers:

* ```check_box_tag($name, $value = '1', $default = false, $options = array())```
* ```content_tag($name, $content='', $options=array())```
* ```hidden_field_tag($name, $default = null, $options = array())```
* ```html_tag($name, $options=array())```
* ```image_tag($src, $options=array())```
* ```input_tag($type, $name, $value=null, $options=array())```
* ```label_tag($name, $text = null, $options = array())```
* ```labelled_text_field_tag($name, $default = null, $options = array())```
* ```link_tag($title, $url=null, $options=array())```
* ```password_field_tag($name = 'password', $default = null, $options = array())```
* ```radio_button_tag($name, $value, $default = false, $options = array())```
* ```reset_tag($value = 'Reset', $options = array())```
* ```select_tag($name, $options, $default = null, $html_options = array())```
* ```submit_tag($value = 'Submit', $options = array())```
* ```text_area_tag($name, $default = null, $options = array())```
* ```text_field_tag($name, $default = null, $options = array())```


To use them, first add the extension to your ```composer.json```:

    "require": {
        "njh/twig-html-helpers": "dev-master"
    },

Then load it into your environment:

    $twig = new Twig_Environment();
    $twig->addExtension(new Twig_Extension_HTMLHelpers());


You can then use them in your Twig templates:

    {{ link_tag('http://www.example.com/') }}



[PHP Twig]: http://twig.sensiolabs.org
