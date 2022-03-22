<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Contact Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $sufficient_contact
 * @property \Cake\I18n\FrozenDate|null $last_contact
 * @property int $days_interval
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Method[] $methods
 */
class Contact extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'name' => true,
        'sufficient_contact' => true,
        'last_contact' => true,
        'days_interval' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'methods' => true,
    ];
}
