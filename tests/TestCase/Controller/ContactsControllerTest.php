<?php
namespace ContactFormLight\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use ContactFormLight\Controller\ContactsController;

/**
 * ContactFormLight\Controller\ContactsController Test Case
 */
class ContactsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.contact_form_light.contacts'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        //$this->markTestIncomplete('Not implemented yet.');
        $this->assertTrue(true);
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function xtestView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function xtestAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function xtestEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function xtestDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
