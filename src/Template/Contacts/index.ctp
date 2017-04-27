<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?= $this->Form->create(null, [
    'url' => preg_replace('/contacts\/?(index)?\/?$/', 'contacts/confirm', $this->request->here)
]) ?>

<div class="form-group">
<label class="label" for="subject">Subject</label>
<?php if (isset($errors['subject'])) {
    foreach ($errors['subject'] as $err) { echo '<span class="error">' . $err . '</span>'; }
} ?>
<?php
$params = [
    'label' => false,
    'id' => 'subject',
    'class' => 'form-control',
    'empty' => true,
    'val' => isset($values['subject']) ? $values['subject'] : ''
];
if (isset($errors['subject'])) {
    $params['class'] .= ' has-error';
}
echo $this->Form->select('subject', $subjects, $params);
?>
</div>

<div class="form-group">
<label class="label" for="username">Your name</label>
<?php if (isset($errors['username'])) {
    foreach ($errors['username'] as $err) { echo '<span class="error">' . $err . '</span>'; }
}?>
<?php
$params = [
    'label' => false,
    'id' => 'username',
    'type' => 'text',
    'placeholder' => 'Pat Metheny',
    'class' => 'form-control',
];
if (isset($values['username'])) {
    $params['value'] = $values['username'];
}
if (isset($errors['username'])) {
    $params['class'] .= ' has-error';
}
echo $this->Form->control('username', $params);
?>
</div>

<div class="form-group">
<label class="label" for="tel">Tel</label>
<?php if (isset($errors['tel'])) {
    foreach ($errors['tel'] as $err) { echo '<span class="error">' . $err . '</span>'; }
}?>
<?php
$params = [
    'label' => false,
    'id' => 'tel',
    'placeholder' => '03-0000-0000',
    'maxLength' => 16,
    'class' => 'form-control',
];
if (isset($values['tel'])) {
    $params['value'] = $values['tel'];
}
if (isset($errors['tel'])) {
    $params['class'] .= ' has-error';
}
echo $this->Form->control('tel', $params);
?>
</div>

<div class="form-group">
<label class="label" for="email">E-mail</label>
<?php if (isset($errors['email'])) {
    foreach ($errors['email'] as $err) { echo '<span class="error">' . $err . '</span>'; }
}?>
<?php
$params = [
    'label' => false,
    'id' => 'email',
    'placeholder' => 'pat@example.com',
//    'type' => 'email',
    'type' => 'text',
    'maxLength' => 256,
    'class' => 'form-control',
];
if (isset($values['email'])) {
    $params['value'] = $values['email'];
}
if (isset($errors['email'])) {
    $params['class'] .= ' has-error';
}
echo $this->Form->control('email', $params);
?>
</div>


<div class="form-group">
<label class="label" for="email2">Re-type e-mail</label>
<?php if (isset($errors['email2'])) {
    foreach ($errors['email2'] as $err) { echo '<span class="error">' . $err . '</span>'; }
}?>
<?php
$params = [
    'label' => false,
    'id' => 'email2',
    'placeholder' => 'pat@example.com',
//    'type' => 'email',
    'type' => 'text',
    'maxLength' => 256,
    'class' => 'form-control',
];
if (isset($values['email2'])) {
    $params['value'] = $values['email2'];
}
if (isset($errors['email2'])) {
    $params['class'] .= ' has-error';
}
echo $this->Form->control('email2', $params);
?>
</div>

<div class="form-group">
<label class="label" for="comment">Comment</label>
<?php if (isset($errors['comment'])) {
    foreach ($errors['comment'] as $err) { echo '<span class="error">' . $err . '</span>'; }
}?>
<?php
$params = [
    'label' => false,
    'id' => 'comment',
    'placeholder' => 'Comment',
    'type' => 'textarea',
    'rows' => 6,
    'cols' => 30,
    'class' => 'form-control',
];
if (isset($values['comment'])) {
    $params['value'] = $values['comment'];
}
if (isset($errors['body'])) {
    $params['class'] .= ' has-error';
}
echo $this->Form->control('comment', $params);
?>
</div>

<div class="form-group">
<?= $this->Form->button('Confirm', [ 'class' => 'button' ]) ?>
</div>
<?= $this->Form->end() ?>
