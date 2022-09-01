<?php

$this->title="Error";

/** @var \Exception $exception */
?>
<h2><?= $exception->getCode() ?> <?= $exception->getMessage() ?></h2>
