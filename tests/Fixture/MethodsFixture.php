<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MethodsFixture
 */
class MethodsFixture extends TestFixture
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
                'method' => 'Lorem ipsum dolor sit amet',
                'created' => '2022-03-22 04:49:56',
                'modified' => '2022-03-22 04:49:56',
            ],
        ];
        parent::init();
    }
}
