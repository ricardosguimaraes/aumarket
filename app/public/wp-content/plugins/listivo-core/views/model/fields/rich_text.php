<?php

use Tangibledesign\Framework\Models\Field\Fieldable;
use Tangibledesign\Framework\Models\Field\RichTextField;

/* @var RichTextField $lstField */
/* @var Fieldable $lstModel */
?>

<h3><?php echo esc_html($lstField->getName()); ?></h3>

<?php wp_editor($lstField->getValue($lstModel), $lstField->getKey()); ?>
