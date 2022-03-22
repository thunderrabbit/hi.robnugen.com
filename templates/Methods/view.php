<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Method $method
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Method'), ['action' => 'edit', $method->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Method'), ['action' => 'delete', $method->id], ['confirm' => __('Are you sure you want to delete # {0}?', $method->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Methods'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Method'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="methods view content">
            <h3><?= h($method->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Method') ?></th>
                    <td><?= h($method->method) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($method->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($method->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($method->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Contacts') ?></h4>
                <?php if (!empty($method->contacts)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Sufficient Contact') ?></th>
                            <th><?= __('Last Contact') ?></th>
                            <th><?= __('Days Interval') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($method->contacts as $contacts) : ?>
                        <tr>
                            <td><?= h($contacts->id) ?></td>
                            <td><?= h($contacts->user_id) ?></td>
                            <td><?= h($contacts->name) ?></td>
                            <td><?= h($contacts->sufficient_contact) ?></td>
                            <td><?= h($contacts->last_contact) ?></td>
                            <td><?= h($contacts->days_interval) ?></td>
                            <td><?= h($contacts->created) ?></td>
                            <td><?= h($contacts->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Contacts', 'action' => 'view', $contacts->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Contacts', 'action' => 'edit', $contacts->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Contacts', 'action' => 'delete', $contacts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contacts->id)]) ?>
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
