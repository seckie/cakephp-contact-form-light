<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="panel panel-default">
<div class="panel-body">
Please confirm your inputs
</div>
</div>

<div class="form-group">
<span class="label">Subject</span>
<?= h($subjects[$this->request->data['subject']]); ?>
</div>

<div class="form-group">
<span class="label">Your name</span>
<?= h($this->request->data['username']); ?>
</div>

<div class="form-group">
<span class="label">E-mail</span>
<?= h($this->request->data['email']); ?>
</div>

<div class="form-group">
<span class="label">Tel</span>
<?= h($this->request->data['tel']); ?>
</div>

<div class="form-group">
<span class="label">Comment</span>
<?= h($this->request->data['comment']); ?>
</div>


<div class="form-group">
<?= $this->Form->create(null, [
    'url' => preg_replace('/confirm\/?$/', '', $this->request->here)
]) ?>
<?= $this->Form->hidden('subject_keeped', ['value' => $this->request->data['subject']]); ?>
<?= $this->Form->hidden('username_keeped', ['value' => $this->request->data['username']]); ?>
<?= $this->Form->hidden('tel_keeped', ['value' => $this->request->data['tel']]); ?>
<?= $this->Form->hidden('email_keeped', ['value' => $this->request->data['email']]); ?>
<?= $this->Form->hidden('email2_keeped', ['value' => $this->request->data['email2']]); ?>
<?= $this->Form->hidden('comment_keeped', ['value' => $this->request->data['comment']]); ?>
<?= $this->Form->button('Back', [ 'class' => 'btn btn-default' ]) ?>
<?= $this->Form->end() ?>

<?= $this->Form->create($contacts, [
    'url' => preg_replace('/confirm\/?$/', 'send', $this->request->here)
]) ?>
<?= $this->Form->hidden('subject', ['value' => $this->request->data['subject']]); ?>
<?= $this->Form->hidden('username', ['value' => $this->request->data['username']]) ?>
<?= $this->Form->hidden('tel', ['value' => $this->request->data['tel']]) ?>
<?= $this->Form->hidden('email', ['value' => $this->request->data['email']]) ?>
<?= $this->Form->hidden('email2', ['value' => $this->request->data['email2']]) ?>
<?= $this->Form->hidden('comment', ['value' => $this->request->data['comment']]) ?>
<?= $this->Form->button('Send', ['class' => 'btn btn-succeed']) ?>
<?= $this->Form->end() ?>
</div>

