<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class ContactsMethods extends AbstractMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     * @return void
     */
    public function up()
    {
        $this->table('contacts_methods', ['id' => false, 'primary_key' => ['contact_id', 'method_id']])
            ->addColumn('contact_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('method_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'contact_id',
                ]
            )
            ->addIndex(
                [
                    'method_id',
                ]
            )
            ->create();

        $this->table('contacts_methods')
            ->addForeignKey(
                'contact_id',
                'contacts',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'RESTRICT',
                ]
            )
            ->addForeignKey(
                'method_id',
                'methods',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'RESTRICT',
                ]
            )
            ->update();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
     * @return void
     */
    public function down()
    {
        $this->table('contacts_methods')
            ->dropForeignKey(
                'contact_id'
            )
            ->dropForeignKey(
                'method_id'
            )->save();

        $this->table('contacts_methods')->drop()->save();
    }
}
