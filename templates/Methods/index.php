<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Method[]|\Cake\Collection\CollectionInterface $methods
 */
?>
<div class="methods index content">
    <?= $this->Html->link(__('New Method'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Methods') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('method') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($methods as $method): ?>
                <tr>
                    <td><?= $this->Number->format($method->id) ?></td>
                    <td><?= h($method->method) ?></td>
                    <td><?= h($method->created) ?></td>
                    <td><?= h($method->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $method->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $method->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $method->id], ['confirm' => __('Are you sure you want to delete # {0}?', $method->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
