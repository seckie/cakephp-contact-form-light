<?php
namespace ContactFormLight\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use ContactFormLight\Model\Table\ContactsTable;

/**
 * ContactFormLight\Model\Table\ContactsTable Test Case
 */
class ContactsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \ContactFormLight\Model\Table\ContactsTable
     */
    public $Contacts;
    public $messages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.contact_form_light.contacts'
    ];
    public $autoFixtures = false;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        // set $Contacts
        $config = TableRegistry::exists('Contacts') ? [] : ['className' => 'ContactFormLight\Model\Table\ContactsTable'];
        $this->Contacts = TableRegistry::get('Contacts', $config);

        // set $messages
        $defaultMessages = Configure::read('ContactFormLight.default.validation.messages');
        $myMessages = Configure::read('ContactFormLight.validation.messages');
        $this->messages = is_array($myMessages) ? array_merge($defaultMessages, $myMessages) : $defaultMessages;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Contacts);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function xtestInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $validator = new Validator();
        $validator = $this->Contacts->validationDefault($validator);

        $this->loadFixtures('Contacts');
        $entries = $this->Contacts->find()
            ->hydrate(false) // 結果セットをオブジェクトに変換しない
            ->toArray();

        $this->assertTrue(is_array($entries));
        $entry = $entries[0];

        $errors = $validator->errors($entry);
        $this->assertEquals([], $errors);

        // email format error
        $entryTest = $entry;
        $entryTest['email'] = 'foo';
        $entryTest['email2'] = 'foo';
        $errors = $validator->errors($entryTest);
        $emailMessage = $this->messages['invalidEmailFormat'];
        $this->assertArrayHasKey('email', $errors);
        $this->assertArrayHasKey('email2', $errors);
        $this->assertEquals($errors['email']['email_format'], $emailMessage);
        $this->assertEquals($errors['email2']['email_format'], $emailMessage);

        // tel format error
        $entryTest = $entry;
        $entryTest['tel'] = 'abcd01234';
        $errors = $validator->errors($entryTest);
        $telMessage = $this->messages['invalidTelFormat'];
        $this->assertArrayHasKey('tel', $errors);
        $this->assertEquals($errors['tel']['custom'], $telMessage);

        // required field error
        $entryTest = [];
        $errors = $validator->errors($entryTest);
        $this->assertArrayHasKey('subject', $errors);
        $this->assertEquals($errors['subject']['_required'], $this->messages['isRequired']);
        $this->assertArrayHasKey('username', $errors);
        $this->assertEquals($errors['username']['_required'], $this->messages['isRequired']);
        $this->assertArrayHasKey('tel', $errors);
        $this->assertEquals($errors['tel']['_required'], $this->messages['isRequired']);
        $this->assertArrayHasKey('email', $errors);
        $this->assertEquals($errors['email']['_required'], $this->messages['isRequired']);
        $this->assertArrayHasKey('comment', $errors);
        $this->assertEquals($errors['comment']['_required'], $this->messages['isRequired']);

        // empty field error
        $entryTest = [
            'subject' => '',
            'username' => '',
            'tel' => '',
            'email' => '',
            'email2' => '',
            'comment' => ''
        ];
        $errors = $validator->errors($entryTest);
        $this->assertArrayHasKey('subject', $errors);
        $this->assertEquals($errors['subject']['_empty'], $this->messages['notEmpty']);
        $this->assertArrayHasKey('username', $errors);
        $this->assertEquals($errors['username']['_empty'], $this->messages['notEmpty']);
        $this->assertArrayHasKey('email', $errors);
        $this->assertEquals($errors['email']['_empty'], $this->messages['notEmpty']);
        $this->assertArrayHasKey('email2', $errors);
        $this->assertEquals($errors['email2']['_empty'], $this->messages['notEmpty']);
        $this->assertArrayHasKey('comment', $errors);
        $this->assertEquals($errors['comment']['_empty'], $this->messages['notEmpty']);

        // email <-> email2 unmatch error
        $entryTest = ['email' => 'foo@example.com', 'email2' => 'bar@example.com'];
        $errors = $validator->errors($entryTest);
        $this->assertArrayHasKey('email2', $errors);
        $this->assertEquals($errors['email2']['equal-to-email'], $this->messages['notSameEmail']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $rules = new RulesChecker();
        $rules = $this->Contacts->buildRules($rules);
        $expected = new RulesChecker();
        $this->assertEquals($expected, $rules);
    }
}
