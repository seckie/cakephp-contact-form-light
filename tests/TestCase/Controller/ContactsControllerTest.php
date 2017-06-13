<?php
namespace ContactFormLight\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use ContactFormLight\Controller\ContactsController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

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
     * private vars
     */
    private $subjects;


    public function setUp()
    {
        $defaultSubjects = Configure::read('ContactFormLight.default.subjects');
        $subjects = Configure::read('ContactFormLight.subjects');
        $this->subjects = is_array($subjects) ? $subjects : $defaultSubjects;

        // For Csrf component
        $this->enableCsrfToken();
        // For Security component
        $this->enableSecurityToken();

        parent::setUp();
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        // Initial access
        $this->get('/contact-form-light/contacts/');
        $this->assertResponseOk();
        foreach ($this->subjects as $subject) {
            $this->assertResponseContains($subject);
        }

        // POST access
        $this->post('/contact-form-light/contacts/', [
            'subject' => '1',
            'username' => 'someone',
            'email' => 'foo@example.com',
            'email2' => 'foo2@example.com',
            'comment' => 'Sutekina something',
        ]);
        $this->assertResponseContains(' value="1" selected');
        $this->assertResponseContains(' value="someone"');
        $this->assertResponseContains(' value="foo@example.com"');
        $this->assertResponseContains(' value="foo2@example.com"');
        $this->assertResponseContains('>Sutekina something</textarea>');

        // POST access from 'confirm' action
        $this->post('/contact-form-light/contacts/', [
            'subject' => '1',
            'username' => 'someone',
            'email' => 'foo@example.com',
            'email2' => 'foo2@example.com',
            'comment' => 'Sutekina something',
            // '_keeped' values should take a priority
            'subject_keeped' => '2',
            'username_keeped' => 'someoneB',
            'email_keeped' => 'fooB@example.com',
            'email2_keeped' => 'foo2B@example.com',
            'comment_keeped' => 'Sutekina something B',
        ]);
        $this->assertResponseContains(' value="2" selected');
        $this->assertResponseContains(' value="someoneB"');
        $this->assertResponseContains(' value="fooB@example.com"');
        $this->assertResponseContains(' value="foo2B@example.com"');
        $this->assertResponseContains('>Sutekina something B</textarea>');
    }

    /**
     * Test confirm method
     *
     * @return void
     */
    public function testConfirm()
    {
        // Invalid method
        $this->get('/contact-form-light/contacts/confirm');
        $this->assertRedirect(['controller' => 'Contacts', 'action' => 'index']);

        // POST access
        $data = [
            'subject' => '1',
            'username' => 'someone',
            'email' => 'foo@example.com',
            'email2' => 'foo@example.com',
            'tel' => '03-0000-0000',
            'comment' => 'Sutekina something',
        ];
        $this->post('/contact-form-light/contacts/confirm', $data);
        $this->assertResponseSuccess();
        $this->assertResponseContains(' value="' . $data['subject'] . '"');
        $this->assertResponseContains(' value="' . $data['username'] . '"');
        $this->assertResponseContains(' value="' . $data['email'] . '"');
        $this->assertResponseContains(' value="' . $data['tel'] . '"');
        $this->assertResponseContains(' value="' . $data['comment'] . '"');
    }

    /**
     * Test send method
     *
     * @return void
     */
    public function testSend()
    {
        // Invalid method
        $this->get('/contact-form-light/contacts/send', []);
        $this->assertRedirect(['controller' => 'Contacts', 'action' => 'index']);

        // Error response
        $this->post('/contact-form-light/contacts/send', []);
        $this->assertRedirect(['controller' => 'Contacts', 'action' => 'error']);

        // After 'save'
        $data = [
            'subject' => '1',
            'username' => 'someone',
            'email' => 'foo@example.com',
            'email2' => 'foo@example.com',
            'tel' => '03-0000-0000',
            'comment' => 'Sutekina something',
        ];
        $this->post('/contact-form-light/contacts/send', $data);
        $table = TableRegistry::get('Contacts');
        $query = $table->find()->where(['email' => $data['email']]);
        $this->assertEquals(1, $query->count());

        // Redirect
        $this->assertRedirect(['controller' => 'Contacts', 'action' => 'thanks']);

        /**
         * TODO:
         * How to test email feature?
         */
    }

    /**
     * Test thanks method
     *
     * @return void
     */
    public function testThanks()
    {
        $this->get('/contact-form-light/contacts/thanks');
        $this->assertResponseOk();
    }
}
