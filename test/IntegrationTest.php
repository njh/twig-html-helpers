<?php

class IntegrationTest extends Twig_Test_IntegrationTestCase
{
    public function getExtensions()
    {
        return array(
            new Twig_Extension_HTMLHelpers()
        );
    }

    public function getFixturesDir()
    {
        return dirname(__FILE__).'/Fixtures/';
    }
}
