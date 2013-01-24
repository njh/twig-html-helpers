Twig HTML Helpers Extension
==========================

This Twig extension adds the following Rails style HTML helpers:

* ```check_box_tag```
* ```content_tag```
* ```hidden_field_tag```
* ```html_tag```
* ```image_tag```
* ```input_tag```
* ```label_tag```
* ```labelled_text_field_tag```
* ```link_tag```
* ```password_field_tag```
* ```radio_button_tag```
* ```reset_tag```
* ```submit_tag```
* ```text_area_tag```
* ```text_field_tag```


To use them, first add them to your ```composer.json```:

    "require": {
        "php": ">=5.2.4",
        "njh/njh/twig-html-helpers": "*"
    },

Then load it into your environment:

    $twig = new Twig_Environment();
    $twig->addExtension(new Twig_Extension_HTMLHelpers());


You can then use them in your Twig templates:

    {{ link_tag('http://www.example.com/') }}
    
