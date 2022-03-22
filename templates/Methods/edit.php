<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Method $method
 * @var string[]|\Cake\Collection\CollectionInterface $contacts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $method->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $method->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Methods'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="methods form content">
            <?= $this->Form->create($method) ?>
            <fieldset>
                <legend><?= __('Edit Method') ?></legend>
                <?php
                    echo $this->Form->control('method');
                    echo $this->Form->control('contacts._ids', ['options' => $contacts]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
