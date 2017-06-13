<?php

namespace ContactFormLight\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\Event;

class AppController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Csrf');
        $this->loadComponent('Security');
    }
    public function beforeFilter(Event $event)
    {
        $this->Security->config('blackHoleCallback', 'blackhole');
    }

    /**
     * @type {String} ‘auth’ は、フォームバリデーションエラー、もしくはコントローラ/アクションの不適合エラーを示します。
     *     ‘secure’ は、SSL メソッド制限の失敗を示します。
     */
    public function blackhole ($type)
    {
        $this->Flash->error('System error has occurred.');
        return $this->render('error');
    }

    /**
     * error method
     *
     * @return \Cake\Network\Response|null
     */
    public function error ()
    {
    }
}
