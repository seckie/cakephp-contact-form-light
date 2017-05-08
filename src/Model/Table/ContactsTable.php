<?php
namespace ContactFormLight\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

/**
 * Contacts Model
 *
 * @method \ContactFormLight\Model\Entity\Contact get($primaryKey, $options = [])
 * @method \ContactFormLight\Model\Entity\Contact newEntity($data = null, array $options = [])
 * @method \ContactFormLight\Model\Entity\Contact[] newEntities(array $data, array $options = [])
 * @method \ContactFormLight\Model\Entity\Contact|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ContactFormLight\Model\Entity\Contact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ContactFormLight\Model\Entity\Contact[] patchEntities($entities, array $data, array $options = [])
 * @method \ContactFormLight\Model\Entity\Contact findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ContactsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('contacts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $defaultMessages = Configure::read('ContactFormLight.default.validation.messages');
        $myMessages = Configure::read('ContactFormLight.validation.messages');
        $messages = is_array($myMessages) ? array_merge($defaultMessages, $myMessages) : $defaultMessages;

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('subject')
            ->requirePresence('subject', 'create', $messages['isRequired'])
            ->notEmpty('subject', $messages['notEmpty']);

        $validator
            ->add('username', 'length', [
                'rule' => ['maxLength', 255],
                'message' => $messages['tooLong']
            ])
            ->requirePresence('username', 'create', $messages['isRequired'])
            ->notEmpty('username', $messages['notEmpty']);

        $validator
            ->add('tel', 'custom', [
                'rule' => function ($value, $context) {
                    $pattern = '/^(0\d{1,4}[\s-]?\d{1,4}[\s-]?\d{1,4}|\+\d{1,3}[\s-]?\d{1,4}[\s-]?\d{1,4}[\s-]?\d{1,4})$/';
                    return (bool)preg_match($pattern, $value);
                },
                'message' => $messages['invalidTelFormat']
            ])
            ->requirePresence('tel', 'create', $messages['isRequired'])
            ->allowEmpty('tel');

        $validator
            ->notEmpty('email', $messages['notEmpty'])
            ->requirePresence('email', 'create', $messages['isRequired'])
            ->add('email', 'email_format', [
                'rule' => 'email',
                'message' => $messages['invalidEmailFormat']
            ]);

        $validator
            ->notEmpty('email2', $messages['notEmpty'])
            ->add('email2', 'email_format', [
                'rule' => 'email',
                'message' => $messages['invalidEmailFormat']
            ])
            ->add('email2', 'equal-to-email', [
                'rule' => ['compareWith', 'email'],
                'message' => $messages['notSameEmail']
            ]);

        $validator
            ->requirePresence('comment', 'create', $messages['isRequired'])
            ->notEmpty('comment', $messages['notEmpty']);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        //$rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
