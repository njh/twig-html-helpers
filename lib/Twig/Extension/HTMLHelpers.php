<?php

/*
 * HTML helpers for Twig.
 *
 * (c) 2013 Nicholas Humfrey
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Twig_Extension_HTMLHelpers extends Twig_Extension
{
    public function getName()
    {
        return 'html_helpers';
    }

    public function getFunctions()
    {
        $options = array(
            'needs_context' => true,
            'needs_environment' => true,
            'is_safe' => array('html')
        );

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
            new Twig_SimpleFunction('select_tag', array($this, 'selectTag'), $options),
            new Twig_SimpleFunction('submit_tag', array($this, 'submitTag'), $options),
            new Twig_SimpleFunction('text_area_tag', array($this, 'textAreaTag'), $options),
            new Twig_SimpleFunction('text_field_tag', array($this, 'textFieldTag'), $options),
        );
    }

    protected function tagOptions(Twig_Environment $env, $options)
    {
        $html = "";
        foreach ($options as $key => $value) {
            if ($key and (!is_null($value) and $value !== '')) {
                $html .= " ".
                    twig_escape_filter($env, $key)."=\"".
                    twig_escape_filter($env, $value)."\"";
            }
        }
        return $html;
    }

    public function htmlTag(Twig_Environment $env, $context, $name, $options=array())
    {
        return "<$name".$this->tagOptions($env, $options)." />";
    }

    public function contentTag(Twig_Environment $env, $context, $name, $content='', $options=array())
    {
        return "<$name".$this->tagOptions($env, $options).">".
               twig_escape_filter($env, $content).
               "</$name>";
    }

    public function linkTag(Twig_Environment $env, $context, $title, $url=null, $options=array())
    {
        if (is_null($url)) {
            $url = $title;
        }
        $options = array_merge(array('href' => $url), $options);
        return $this->contentTag($env, $context, 'a', $title, $options);
    }

    public function imageTag(Twig_Environment $env, $context, $src, $options=array())
    {
        $options = array_merge(array('src' => $src), $options);
        return $this->htmlTag($env, $context, 'img', $options);
    }

    public function inputTag(Twig_Environment $env, $context, $type, $name, $value=null, $options=array())
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
        return $this->htmlTag($env, $context, 'input', $options);
    }

    public function textFieldTag(Twig_Environment $env, $context, $name, $default = null, $options = array())
    {
        $value = $this->getContextVariable($context, $name, $default);
        return $this->inputTag($env, $context, 'text', $name, $value, $options);
    }

    public function textAreaTag(Twig_Environment $env, $context, $name, $default = null, $options = array())
    {
	      $content = $this->getContextVariable($context, $name, $default);
        $options = array_merge(
            array(
                'name' => $name,
                'id' => $name,
                'cols' => 60,
                'rows' => 5
            ),
            $options
        );
        return $this->contentTag($env, $context, 'textarea', $content, $options);
    }

    public function hiddenFieldTag(Twig_Environment $env, $context, $name, $default = null, $options = array())
    {
	      $value = $this->getContextVariable($context, $name, $default);
        return $this->inputTag($env, $context, 'hidden', $name, $value, $options);
    }

    public function passwordFieldTag(Twig_Environment $env, $context, $name = 'password', $default = null, $options = array())
    {
	      $value = $this->getContextVariable($context, $name, $default);
        return $this->inputTag($env, $context, 'password', $name, $value, $options);
    }

    public function radioButtonTag(Twig_Environment $env, $context, $name, $value, $default = false, $options = array())
    {
        if ((null !== $this->getContextVariable($context, $name, null)) or (!isset($context[$name]) and $default))
        {
            $options = array_merge(array('checked' => 'checked'), $options);
        }
        $options = array_merge(array('id' => $name.'_'.$value), $options);
        return $this->inputTag($env, $context, 'radio', $name, $value, $options);
    }

    public function checkBoxTag(Twig_Environment $env, $context, $name, $value = '1', $default = false, $options = array())
    {
        if ((null !== $this->getContextVariable($context, $name, null)) or (!isset($context['submit']) and $default))
        {
            $options = array_merge(array('checked' => 'checked'), $options);
        }
        return $this->inputTag($env, $context, 'checkbox', $name, $value, $options);
    }

    public function labelTag(Twig_Environment $env, $context, $name, $text = null, $options = array())
    {
        if (is_null($text)) {
            $text = ucwords(str_replace('_', ' ', $name)).': ';
        }
        $options = array_merge(
            array('for' => $name, 'id' => "label_for_$name"),
            $options
        );
        return $this->contentTag($env, $context, 'label', $text, $options);
    }

    public function labeledTextFieldTag(Twig_Environment $env, $context, $name, $default = null, $options = array())
    {
        return $this->labelTag($env, $context, $name).$this->textFieldTag($env, $context, $name, $default, $options);
    }

    public function selectTag(Twig_Environment $env, $context, $name, $options, $default = null, $html_options = array())
    {
        $opts = '';
        foreach ($options as $key => $label) {
            $arr = array('value' => $key);
            if ((isset($context[$name]) and ($context[$name] === $key or (is_array($context[$name]) and in_array($key, $context[$name], true)) )) or (!isset($context[$name]) and $default === $key))
            {
                $arr = array_merge(array('selected' => 'selected'),$arr);
            }
            $opts .= $this->contentTag($env, $context, 'option', $label, $arr);
        }
        $html_options = array_merge(
            array('name' => empty($html_options['multiple']) ? $name : "{$name}[]", 'id' => $name),
            $html_options
        );
        return "<select".$this->tagOptions($env, $html_options).">$opts</select>";
    }

    public function submitTag(Twig_Environment $env, $context, $value = 'Submit', $options = array())
    {
        if (isset($options['name'])) {
            $name = $options['name'];
        } else {
            $name = '';
        }
        return $this->inputTag($env, $context, 'submit', $name, $value, $options);
    }

    public function resetTag(Twig_Environment $env, $context, $value = 'Reset', $options = array())
    {
        if (isset($options['name'])) {
            $name = $options['name'];
        } else {
            $name = '';
        }
        return $this->inputTag($env, $context, 'reset', $name, $value, $options);
    }

		protected function getContextVariable($context, $name, $defaultValue)
		{
			if (FALSE === strpos($name, '[')) return isset($context[$name]) ? $context[$name] : $defaultValue;

			// Parse html (array[key]) into the variable array.key
			$replaces = array(
				'][' => '.', // middle
				']' => '', // end
				'[' => '.' // beginning
			);
			$key = str_replace(array_keys($replaces), array_values($replaces), $name);

			return $this->getNested($context, $key, $defaultValue);
		}

		/**
	  * Retrieves a nested element from an array or $default if it doesn't exist
		* Ported from: axelarge/array-tools/src/Axelarge/ArrayTools/Arr.php:118
	  *
	  * <code>
	  * $friends = [
	  *      'Alice' => ['age' => 33, 'hobbies' => ['biking', 'skiing']],
	  *      'Bob' => ['age' => 29],
	  * ];
	  *
	  * Arr::getNested($friends, 'Alice.hobbies.1'); //=> 'skiing'
	  * Arr::getNested($friends, ['Alice', 'hobbies', 1]); //=> 'skiing'
	  * Arr::getNested($friends, 'Bob.hobbies.0', 'none'); //=> 'none'
	  * </code>
	  *
	  * @param array $array
	  * @param string|array $keys The key path as either an array or a dot-separated string
	  * @param mixed $default
	  * @return mixed
	  */
	 protected function getNested($array, $keys, $default = null)
	 {
	     if (is_string($keys)) {
	         $keys = explode('.', $keys);
	     } else if ($keys === null) {
	         return $array;
	     }

	     foreach ($keys as $key) {
	         if (is_array($array) && array_key_exists($key, $array)) {
	             $array = $array[$key];
	         } else {
	             return $default;
	         }
	     }

	     return $array;
	 }
}
