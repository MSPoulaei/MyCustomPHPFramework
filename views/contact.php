<?php
$this->title="Contact";
?>
<h1>Contacts</h1>

<!--<form action="" method="post">-->
<!--    <div class="mb-3">-->
<!--        <label for="exampleInputEmail1" class="form-label">Email address</label>-->
<!--        <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">-->
<!--        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>-->
<!--    </div>-->
<!--    <div class="mb-3">-->
<!--        <label for="exampleInputPassword1" class="form-label">Password</label>-->
<!--        <input name="password" type="password" class="form-control" id="exampleInputPassword1">-->
<!--    </div>-->
<!--    <div class="mb-3 form-check">-->
<!--        <input name="check" type="checkbox" class="form-check-input" id="exampleCheck1">-->
<!--        <label class="form-check-label" for="exampleCheck1">Check me out</label>-->
<!--    </div>-->
<!--    <button type="submit" class="btn btn-primary">Submit</button>-->
<!--</form>-->


<?php $form=\app\core\form\Form::Begin("","post"); ?>
<?php /** @var \app\core\Model $model */
 echo new \app\core\form\InputField("subject",$model) ?>
<?php echo new \app\core\form\InputField("email",$model) ?>
<?php echo new \app\core\form\TextareaField("body",$model) ?>
<?php $form->submitBtn("Send"); ?>
<?php $form->End(); ?>
