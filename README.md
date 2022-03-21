Vaporware for a simple CRM

Don't touch it until this README looks reasonable.

Plans are here for now https://workflowy.com/s/hirobnugencom-crm-so/Y66vVLqCV7GOTH2j

Barefoot Rob
18 March 2022


CMS Tutorial - Creating the Database
####################################

Now that we have CakePHP installed, let's set up the database for
this Vaporware app code named 'hi'. If you haven't already done so, create
an empty database for this.
If you are using MySQL/MariaDB, you can execute the following SQL to create the
necessary tables:

    USE cake_cms;

    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        created DATETIME,
        modified DATETIME
    );

Plan now to use migrate on it after creating the table with PHPMyAdmin

Done via

    bin/cake bake migration_snapshot users

Okay now instead of all the above, we can just do this:

    bin/cake migrations migrate


Now start baking the code for tables:

    cd /path/to/our/app

    # You can overwrite any existing files.
    bin/cake bake model users
    bin/cake bake controller users
    bin/cake bake template users

In order to hash passwords, we need to install Authentication Plugin

    composer require "cakephp/authentication:^2.0"


Add this to the top of `src/Model/Entity/User.php`

    use Authentication\PasswordHasher\DefaultPasswordHasher; // Required for passwords to work

Then add this to the end of `src/Model/Entity/User.php`

    protected function _setPassword(string $password) : ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    }
