<?php

use PHPUnit\Framework\TestCase;

class BonzaQuoteTest extends WP_UnitTestCase
{

    public function test_post_type_registered()
    {
        $this->assertTrue(post_type_exists('bonza_quote'), 'Custom post type "bonza_quote" should be registered.');
    }
}
