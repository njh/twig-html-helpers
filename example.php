<?php

require './vendor/autoload.php';

$twig = new Twig_Environment();
$twig->addExtension(new Twig_Extension_HTMLHelpers());

$string = <<<EOF
<p>
  {{ html_tag('br') }}
</p>

<p>
  {{ content_tag('p', '<Hello World>') }}
</p>

<p>
  {{ link_tag('http://www.aelius.com/') }}
</p>

<p>
  {{ image_tag('/PoweredByMacOSX.gif', {width:200, height:100}) }}
</p>

<form>
  <p>
    {{ input_tag('text', 'name1', 'value1') }}
  </p>

  <p>
    {{ text_area_tag('name3', 'value2') }}
  </p>

  <p>
    {{ hidden_field_tag('name3', 'value3') }}
  </p>

  <p>
    {{ password_field_tag() }}
  </p>

  <p>
    {{ label_tag('name4_value4', 'Radio 4') }} {{ radio_button_tag('name4', 'value4') }}
  </p>

  <p>
    {{ label_tag('name_5') }} {{ check_box_tag('name_5', 'value5') }}
  </p>

  <p>
    {{ labelled_text_field_tag('name_6', 'value6') }}
  </p>

  <p>
    {{ reset_tag() }} {{ submit_tag() }}
  </p>
</form>

EOF;

// Load the template from string
$twig->setLoader(new Twig_Loader_String());
$template = $twig->loadTemplate($string);

// Render the template
echo $template->render(array());

