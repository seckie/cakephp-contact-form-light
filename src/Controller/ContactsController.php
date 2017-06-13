<?php
namespace ContactFormLight\Controller;

use ContactFormLight\Controller\AppController;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\Core\Exception\Exception;

/**
 * Contacts Controller
 *
 * @property \ContactFormLight\Model\Table\ContactsTable $Contacts
 */
class ContactsController extends AppController
{
    /**
     * Data array for 'subject' field
     */
    private $subjects;

    /**
     * Initialize method
     */
    public function initialize () {
        parent::initialize();

        $defaultSubjects = Configure::read('ContactFormLight.default.subjects');
        $subjects = Configure::read('ContactFormLight.subjects');
        $this->subjects = is_array($subjects) ? $subjects : $defaultSubjects;
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $values = [];
        if (isset($this->request->data)) {
            if (isset($this->request->data['subject'])) {
                $values['subject'] = $this->request->data['subject'];
            }
            foreach ($this->request->data as $key => $val) {
                if (preg_match('/_keeped$/', $key)) {
                    $newkey = substr($key, 0, strpos($key, '_keeped'));
                    $values[$newkey] = $val;
                }
            }
        }
        $this->set(compact('values'));
        $this->set([ 'subjects' => $this->subjects ]);
    }

    /**
     * Confirm method
     *
     * @return \Cake\Network\Response|null
     */
    public function confirm()
    {
        if (!$this->request->is('post')) {
            // Only accespts 'POST' method
            return $this->redirect(['action' => 'index']);
        }

        $contacts = $this->Contacts->newEntity($this->request->data);
        $this->set(compact('contacts'));
        $this->set([ 'subjects' => $this->subjects ]);

        if ($contacts->errors()) {
            $values = [];
            if (isset($this->request->data) && isset($this->request->data['subject'])) {
                $values['subject'] = $this->request->data['subject'];
            }
            $this->errorHandler($contacts->errors());
            $this->set('values', $values);
            return $this->render('index');
        }
    }

    /**
     * Send method
     *
     * @return \Cake\Network\Response|null
     */
    public function send ()
    {
        if (!$this->request->is('post')) { // Only accespts 'POST' method
            return $this->redirect(['action' => 'index']);
        }

        $contacts = $this->Contacts->newEntity($this->request->data);
        if ($contacts->errors()) { // Deal with this as system error
            return $this->redirect(['action' => 'error']);
        }

        if ($this->Contacts->save($contacts)) { // save to database
            // Data to send
            $vars = $this->request->data;
            $vars['subject'] = $this->subjects[$vars['subject']];

            $emailProfile = Configure::read('debug') ? 'debug_contact' : 'contact';
            $emailProfileConfig = Configure::read($emailProfile);
            if (isset($emailProfileConfig)) {
                // Send entry to us
                $email = new Email($emailProfile);
                $email->setTemplate('ContactFormLight.contact')
                    ->setViewVars($vars)
                    ->send();

                // Auto reply to user
                $autoReplyEmail = new Email($emailProfile);
                $autoReplyEmail->setTemplate('ContactFormLight.autoreply')
                    ->setTo($vars['email'])
                    ->setViewVars($vars)
                    ->send();

            } else if ($emailProfile === 'debug_contact') {
                // No email feature
                $this->Flash->error(__('No email profile was found in app.php'));
            }

            // Result
            $this->Flash->success(__('The contact has been saved.'));
            $this->redirect(['action' => 'thanks']);
        } else {
            $this->Flash->error('Couldn\'t save your inquiry to the DB.');
            $this->redirect(['action' => 'error']);
        }
    }

    /**
     * Thanks method
     *
     * @return \Cake\Network\Response|null
     */
    public function thanks ()
    {
    }

    /**
     * Utility function
     */
    protected function errorHandler ($errors)
    {
        $messages = [];
        foreach ($errors as $key => $err) {
            if (is_array($err)) {
                foreach ($err as $key2 => $message) {
                    $this->Flash->error($message);
                    $messages[$key][] = $message;
                }
            } else {
                $this->Flash->error($err);
                $messages[$key] = [ $err ];
            }
        }
        $this->set(['errors' => $messages]);
    }
}
