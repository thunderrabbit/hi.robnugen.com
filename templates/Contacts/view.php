<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contact $contact
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Contact'), ['action' => 'edit', $contact->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Contact'), ['action' => 'delete', $contact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contact->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Contacts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Contact'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="contacts view content">
            <h3><?= h($contact->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $contact->has('user') ? $this->Html->link($contact->user->name, ['controller' => 'Users', 'action' => 'view', $contact->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($contact->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sufficient Contact') ?></th>
                    <td><?= h($contact->sufficient_contact) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($contact->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Days Interval') ?></th>
                    <td><?= $this->Number->format($contact->days_interval) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Contact') ?></th>
                    <td><?= h($contact->last_contact) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($contact->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($contact->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Methods') ?></h4>
                <?php if (!empty($contact->methods)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Method') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($contact->methods as $methods) : ?>
                        <tr>
                            <td><?= h($methods->id) ?></td>
                            <td><?= h($methods->method) ?></td>
                            <td><?= h($methods->created) ?></td>
                            <td><?= h($methods->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Methods', 'action' => 'view', $methods->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Methods', 'action' => 'edit', $methods->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Methods', 'action' => 'delete', $methods->id], ['confirm' => __('Are you sure you want to delete # {0}?', $methods->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
