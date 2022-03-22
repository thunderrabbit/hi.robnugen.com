Contacts and Methods for a simple CRM

Don't touch it until this README looks reasonable.


### Overview

Does not track the content of communication

The content is saved within the communication medium, meaning the specific social network or email etc.

Only remembers the upcoming timing of communication

Does not even recall the history of communications

* no private data!  data could be doxxed and must have no ill effect on anyone
* NO LAST NAMES
* NO CONTACT INFO beyond "FB" "LINE" "Whatsapp"
* * and I do mean just the name of the social network
* * not the username or anything
* if I cannot find them from above, then they aren't close enough to be contacted
* private info stays safely in my physical space or with 3rd party social network

Plans are here for now https://workflowy.com/s/hirobnugencom-crm-so/Y66vVLqCV7GOTH2j

Barefoot Rob
22 March 2022


### Creating the Database

Now that we have CakePHP installed, let's set up the database for
this simplistic app code named 'hi'. If you haven't already done so, create
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

### Allow (Require) user login

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

* Visit https://hi.robnugen.com/users
* Add a new user
* In PHPMyAdmin (or w/e) confirm the password has been hashed

#### Adding Login

Now it's time to configure the Authentication Plugin.
The Plugin will handle the authentication process using 3 different classes:

* ``Application`` will use the Authentication Middleware and provide an
  AuthenticationService, holding all the configuration we want to define how are
  we going to check the credentials, and where to find them.
* ``AuthenticationService`` will be a utility class to allow you configure the
  authentication process.
* ``AuthenticationMiddleware`` will be executed as part of the middleware queue.
  This happens before your Controllers are processed by the framework, and will pick the
  credentials and process them to check if the user is authenticated.

This logic is divided into specific classes and
the authentication process happens before your controller layer. First it checks if the user
is authenticated (based on the configuration you provided) and injects the user and
corresponding authentication results into the request for further reference.

In **src/Application.php**, add the following imports::

    // In src/Application.php add the following imports
    use Authentication\AuthenticationService;
    use Authentication\AuthenticationServiceInterface;
    use Authentication\AuthenticationServiceProviderInterface;
    use Authentication\Middleware\AuthenticationMiddleware;
    use Cake\Routing\Router;
    use Psr\Http\Message\ServerRequestInterface;

Then implement the authentication interface on your ``Application`` class::

    // in src/Application.php
    class Application extends BaseApplication
        implements AuthenticationServiceProviderInterface
    {

Then add the following::

    // src/Application.php
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            // ... other middleware added before
            ->add(new RoutingMiddleware($this))
            // add Authentication after RoutingMiddleware
            ->add(new AuthenticationMiddleware($this))

        return $middlewareQueue;
    }

    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $authenticationService = new AuthenticationService([
            'unauthenticatedRedirect' => Router::url('/users/login'),
            'queryParam' => 'redirect',
        ]);

        // Load identifiers, ensure we check email and password fields
        $authenticationService->loadIdentifier('Authentication.Password', [
            'fields' => [
                'username' => 'email',
                'password' => 'password',
            ]
        ]);

        // Load the authenticators, you want session first
        $authenticationService->loadAuthenticator('Authentication.Session');
        // Configure form data check to pick email and password
        $authenticationService->loadAuthenticator('Authentication.Form', [
            'fields' => [
                'username' => 'email',
                'password' => 'password',
            ],
            'loginUrl' => Router::url('/users/login'),
        ]);

        return $authenticationService;
    }

In your ``AppController`` class add the following code::

    // src/Controller/AppController.php
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        // Add this line to check authentication result and lock your site
        $this->loadComponent('Authentication.Authentication');

Now, on every request, the ``AuthenticationMiddleware`` will inspect
the request session to look for an authenticated user. If we are loading the ``/users/login``
page, it will also inspect the posted form data (if any) to extract the credentials.
By default the credentials will be extracted from the ``username`` and ``password``
fields in the request data.
The authentication result will be injected in a request attribute named
``authentication``. You can inspect the result at any time using
``$this->request->getAttribute('authentication')`` from your controller actions.
All your pages will be restricted as the ``AuthenticationComponent`` is checking the
result on every request. When it fails to find any authenticated user, it will redirect the
user to the ``/users/login`` page.
Note at this point, the site won't work as we don't have a login page yet.
If you visit your site, you'll get an "infinite redirect loop" so let's fix that.

In your ``UsersController``, add the following code::

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login']);
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            // redirect to /articles after login success
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Users',
                'action' => 'index',
            ]);

            return $this->redirect($redirect);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }

Add the template logic for your login action::

    <!-- in /templates/Users/login.php -->
    <div class="users form">
        <?= $this->Flash->render() ?>
        <h3>Login</h3>
        <?= $this->Form->create() ?>
        <fieldset>
            <legend><?= __('Please enter your username and password') ?></legend>
            <?= $this->Form->control('email', ['required' => true]) ?>
            <?= $this->Form->control('password', ['required' => true]) ?>
        </fieldset>
        <?= $this->Form->submit(__('Login')); ?>
        <?= $this->Form->end() ?>

        <?= $this->Html->link("Add User", ['action' => 'add']) ?>
    </div>

Now login page will allow us to correctly login into the application.
Test it by requesting any page of your site. After being redirected
to the ``/users/login`` page, enter the email and password you
picked previously when creating your user. You should be redirected
successfully after login.

We need to add a couple more details to configure our application.
We want all ``view`` and ``index`` pages accessible without logging in so we'll add this specific
configuration in AppController::

    // in src/Controller/AppController.php
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // for all controllers in our application, make index and view
        // actions public, skipping the authentication check
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }

.. note::

    If you don't have a user with a hashed password yet, comment the
    ``$this->loadComponent('Authentication.Authentication')`` line in your
    AppController and all other lines where Authentication is used. Then go to
    ``/users/add`` to create a new user picking email and password. Afterward,
    make sure to uncomment the lines we just temporarily commented!

Try it out by visiting ``/articles/add`` before logging in! Since this action is not
allowed, you will be redirected to the login page. After logging in
successfully, CakePHP will automatically redirect you back to ``/articles/add``.

#### Logout

Add the logout action to the ``UsersController`` class::

    // in src/Controller/UsersController.php
    public function logout()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

Now you can visit ``/users/logout`` to log out. You should then be sent to the login
page.

#### Enabling Registrations

If you try to visit **/users/add** without being logged in, you will be
redirected to the login page. We should fix that as we want to allow people to
sign up for our application. In the ``UsersController`` fix the following line::

    // Add to the beforeFilter method of UsersController
    $this->Authentication->addUnauthenticatedActions(['login', 'add']);

The above tells ``AuthenticationComponent`` that the ``add()`` action of the
``UsersController`` does *not* require authentication or authorization. You may
want to take the time to clean up the **Users/add.php** and remove the
misleading links, or continue on to the next section. We won't be building out
user editing, viewing or listing in this tutorial, but that is an exercise you
can complete on your own.

Now that users can log in, we'll want to limit users to only edit articles that
they created by :doc:`applying authorization policies <./authorization>`.

### Create remaining tables

Now that

* users must be logged in to see anything AND
* I have disabled new registrations

I am comfortable with adding other data to the system.

We have just two more tables and a linking table.

* TABLE `contacts` will be who we want to stay in touch with.
* TABLE `methods` will be a list of ways we can stay in touch with contacts.
* TABLE `contacts_methods` will be a linking table for them.

From the tutorial I'm using

* TABLE `articles` corresponds to TABLE `contacts`
* TABLE `tags` corresponds to TABLE `methods`
* TABLE `articles_tags` corresponds to TABLE `contacts_methods`

Here are the tables

    CREATE TABLE contacts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        name VARCHAR(255) NOT NULL,
        sufficient_contact VARCHAR(255) NOT NULL,
        last_contact DATE,
        days_interval INT NOT NULL,
        created DATETIME,
        modified DATETIME,
        FOREIGN KEY user_key (user_id) REFERENCES users(id)
    ) CHARSET=utf8mb4;
    
    CREATE TABLE methods (
        id INT AUTO_INCREMENT PRIMARY KEY,
        method VARCHAR(191),
        created DATETIME,
        modified DATETIME,
        UNIQUE KEY (method)
    ) CHARSET=utf8mb4;
    
    CREATE TABLE contacts_methods (
        contact_id INT NOT NULL,
        method_id INT NOT NULL,
        PRIMARY KEY (contact_id, method_id),
        FOREIGN KEY method_key(method_id) REFERENCES methods(id),
        FOREIGN KEY contact_key(contact_id) REFERENCES contacts(id)
    );

Above is already done if you did this at the top:

    bin/cake migrations migrate

Now bake the code for main new tables:

    cd /path/to/our/app

    bin/cake bake all contacts
    bin/cake bake all methods

So far it looks like we don't have to bake `contacts_methods`
because CakePHP's `JOIN` magic sorts them out.


### Adding Methods to Contacts

According to this app, we contact Contacts via Methods.
e.g. I contact my brother via email.

* my brother is the contact
* email is the method

Now that we have the scaffold code created, create a few sample
methods at `example.com/methods/add`

Now that we have a methods table, we can create an association between
Contacts and Methods. We can do so by adding the following to the
`initialize` method on the ContactsTable at `/src/Model/Table/ContactsTable.php`

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Methods'); // Add this line
    }

This association will work with this simple definition because we
followed CakePHP conventions when creating our tables. For more
information, read https://book.cakephp.org/4/en/orm/associations.html

### Updating Contacts to Enable Methods


Now that our application has methods, we need to enable users to add
methods to their contacts. First, update the `add` action to look like:

    <?php
    // in src/Controller/ContactsController.php
    namespace App\Controller;

    use App\Controller\AppController;

    class ContactsController extends AppController
    {
        public function add()
        {
            $contact = $this->Contacts->newEmptyEntity();
            if ($this->request->is('post')) {
                $contact = $this->Contacts->patchEntity($contact, $this->request->getData());

                // Hardcoding the user_id is temporary, and will be removed later
                // when we build authentication out.
                $contact->user_id = 1;

                if ($this->Contacts->save($contact)) {
                    $this->Flash->success(__('Your contact has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('Unable to add your contact.'));
            }
            // Get a list of methods.
            $methods = $this->Contacts->Methods->find('list')->all();

            // Set methods to the view context
            $this->set('methods', $methods);

            $this->set('contact', $contact);
        }

        // Other actions
    }

The added lines load a list of methods as an associative array of `id
=> title`.  This format will let us create a new method input in our
template.  Add the following to the PHP block of controls in
**templates/Contacts/add.php**:

    echo $this->Form->control('methods._ids', ['options' => $methods]);

This will render a multiple select element that uses the `$methods`
variable to generate the select box options. You should now create a
couple new contacts that have methods, as in the following section
we'll be adding the ability to find contacts by methods.

You should also update the `edit` method to allow adding or editing
methods. The edit method should now look like:

    public function edit($slug)
    {
        $contact = $this->Contacts
            ->findBySlug($slug)
            ->contain('Methods') // load associated methods
            ->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Contacts->patchEntity($contact, $this->request->getData());
            if ($this->Contacts->save($contact)) {
                $this->Flash->success(__('Your contact has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your contact.'));
        }

        // Get a list of methods.
        $methods = $this->Contacts->Methods->find('list')->all();

        // Set methods to the view context
        $this->set('methods', $methods);

        $this->set('contact', $contact);
    }

Remember to add the new methods multiple select control we added to
the **add.php** template to the **templates/Contacts/edit.php**
template as well.
