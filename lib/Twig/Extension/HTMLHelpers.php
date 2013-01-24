<?php

class Twig_Extension_HTMLHelpers extends Twig_Extension
{
    public function getName() {
        return 'html_helpers';
    }
 
    public function getFunctions() {
        $options = array('needs_environment' => true, 'is_safe' => array('html'));
        return array(
            new Twig_SimpleFunction('check_box_tag', array($this, 'checkBoxTag'), $options),
            new Twig_SimpleFunction('content_tag', array($this, 'contentTag'), $options),
            new Twig_SimpleFunction('hidden_field_tag', array($this, 'hiddenFieldTag'), $options),
            new Twig_SimpleFunction('html_tag', array($this, 'htmlTag'), $options),
            new Twig_SimpleFunction('image_tag', array($this, 'imageTag'), $options),
            new Twig_SimpleFunction('input_tag', array($this, 'inputTag'), $options),
            new Twig_SimpleFunction('label_tag', array($this, 'labelTag'), $options),
            new Twig_SimpleFunction('labelled_text_field_tag', array($this, 'labeledTextFieldTag'), $options),
            new Twig_SimpleFunction('link_tag', array($this, 'linkTag'), $options),
            new Twig_SimpleFunction('password_field_tag', array($this, 'passwordFieldTag'), $options),
            new Twig_SimpleFunction('radio_button_tag', array($this, 'radioButtonTag'), $options),
            new Twig_SimpleFunction('reset_tag', array($this, 'resetTag'), $options),
            new Twig_SimpleFunction('submit_tag', array($this, 'submitTag'), $options),
            new Twig_SimpleFunction('text_area_tag', array($this, 'textAreaTag'), $options),
            new Twig_SimpleFunction('text_field_tag', array($this, 'textFieldTag'), $options),
        );
    }

    protected function tagOptions(Twig_Environment $env, $options) {
        $html = "";
        foreach ($options as $key => $value) {
            if ($key and $value) {
                $html .= " ".
                    twig_escape_filter($env, $key)."=\"".
                    twig_escape_filter($env, $value)."\"";
            }
        }
        return $html;
    }
   
    public function htmlTag(Twig_Environment $env, $name, $options=array()) {
        return "<$name".$this->tagOptions($env, $options)." />";
    }
   
    public function contentTag(Twig_Environment $env, $name, $content, $options=array()) {
        return "<$name".$this->tagOptions($env, $options).">".
               twig_escape_filter($env, $content).
               "</$name>";
    }
    
    public function linkTag(Twig_Environment $env, $title, $url=null, $options=array()) {
        if (is_null($url)) {
            $url = $title;
        }
        $options = array_merge(array('href' => $url), $options);
        return $this->contentTag($env, 'a', $title, $options);
    }

    public function imageTag(Twig_Environment $env, $src, $options=array())
    {
        $options = array_merge(array('src' => $src), $options);
        return $this->htmlTag($env, 'img', $options);
    }

    public function inputTag(Twig_Environment $env, $type, $name, $value=null, $options=array())
    {
        $options = array_merge(
            array(
                'type' => $type,
                'name' => $name,
                'id' => $name,
                'value' => $value
            ),
            $options
        );
        return $this->htmlTag($env, 'input', $options);
    }

    public function textFieldTag(Twig_Environment $env, $name, $default = null, $options = array())
    {
        $value = isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
        return $this->inputTag($env, 'text', $name, $value, $options);
    }

    public function textAreaTag(Twig_Environment $env, $name, $default = null, $options = array())
    {
        $content = isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
        $options = array_merge(
            array(
                'name' => $name,
                'id' => $name,
                'cols' => 60,
                'rows' => 5
            ),
            $options
        );
        return $this->contentTag($env, 'textarea', $content, $options);
    }


    public function hiddenFieldTag(Twig_Environment $env, $name, $default = null, $options = array())
    {
        $value = isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
        return $this->inputTag($env, 'hidden', $name, $value, $options);
    }

    public function passwordFieldTag(Twig_Environment $env, $name = 'password', $default = null, $options = array())
    {
        $value = isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
        return $this->inputTag($env, 'password', $name, $value, $options);
    }

    public function radioButtonTag(Twig_Environment $env, $name, $value, $default = false, $options = array())
    {
        if ((isset($_REQUEST[$name]) and $_REQUEST[$name] == $value) or
            (!isset($_REQUEST[$name]) and $default))
        {
            $options = array_merge(array('checked' => 'checked'), $options);
        }
        $options = array_merge(array('id' => $name.'_'.$value), $options);
        return $this->inputTag($env, 'radio', $name, $value, $options);
    }

    public function checkBoxTag(Twig_Environment $env, $name, $value = '1', $default = false, $options = array())
    {
        if ((isset($_REQUEST[$name]) and $_REQUEST[$name] == $value) or
            (!isset($_REQUEST['submit']) and $default))
        {
            $options = array_merge(array('checked' => 'checked'),$options);
        }
        return $this->inputTag($env, 'checkbox', $name, $value, $options);
    }

    public function labelTag(Twig_Environment $env, $name, $text = null, $options = array())
    {
        if ($text == null) {
            $text = ucwords(str_replace('_', ' ', $name)).': ';
        }
        $options = array_merge(
            array('for' => $name, 'id' => "label_for_$name"),
            $options
        );
        return $this->contentTag($env, 'label', $text, $options);
    }

    public function labeledTextFieldTag(Twig_Environment $env, $name, $default = null, $options = array())
    {
        return $this->labelTag($env, $name).$this->textFieldTag($env, $name, $default, $options);
    }

    public function selectTag(Twig_Environment $env, $name, $options, $default = null, $html_options = array())
    {
        $opts = '';
        foreach ($options as $key => $value) {
            $arr = array('value' => $value);
            if ((isset($_REQUEST[$name]) and $_REQUEST[$name] == $value) or
                (!isset($_REQUEST[$name]) and $default == $value))
            {
                $arr = array_merge(array('selected' => 'selected'),$arr);
            }
            $opts .= content_tag('option', $key, $arr);
        }
        $html_options = array_merge(
            array('name' => $name, 'id' => $name),
            $html_options
        );
        return "<select".$this->tagOptions($env,$html_options).">$opts</select>";
    }

    public function submitTag(Twig_Environment $env, $name = '', $value = 'Submit', $options = array())
    {
        return $this->inputTag($env, 'submit', $name, $value, $options);
    }

    public function resetTag(Twig_Environment $env, $name = '', $value = 'Reset', $options = array())
    {
        return $this->inputTag($env, 'reset', $name, $value, $options);
    }

}
