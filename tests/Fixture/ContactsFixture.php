<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ContactsFixture
 */
class ContactsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'sufficient_contact' => 'Lorem ipsum dolor sit amet',
                'last_contact' => '2022-03-22',
                'days_interval' => 1,
                'created' => '2022-03-22 04:48:18',
                'modified' => '2022-03-22 04:48:18',
            ],
        ];
        parent::init();
    }
}
