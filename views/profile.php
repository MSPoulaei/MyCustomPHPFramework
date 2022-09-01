<?php

/** @var \app\models\User $user */
$this->title="Profile";
?>
<h2>Profile</h2>

<p>Name: <?=$user->getFullName()?></p>
<p>Email: <?=$user->email?></p>
<p>Phone: <?=$user->phone?></p>
<p>Status: <?=\app\models\Status::from($user->status)->name?></p>



