<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Method $method
 * @var \Cake\Collection\CollectionInterface|string[] $contacts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Methods'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="methods form content">
            <?= $this->Form->create($method) ?>
            <fieldset>
                <legend><?= __('Add Method') ?></legend>
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
