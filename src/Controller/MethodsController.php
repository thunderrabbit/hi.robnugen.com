<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Methods Controller
 *
 * @property \App\Model\Table\MethodsTable $Methods
 * @method \App\Model\Entity\Method[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MethodsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $methods = $this->paginate($this->Methods);

        $this->set(compact('methods'));
    }

    /**
     * View method
     *
     * @param string|null $id Method id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $method = $this->Methods->get($id, [
            'contain' => ['Contacts'],
        ]);

        $this->set(compact('method'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $method = $this->Methods->newEmptyEntity();
        if ($this->request->is('post')) {
            $method = $this->Methods->patchEntity($method, $this->request->getData());
            if ($this->Methods->save($method)) {
                $this->Flash->success(__('The method has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The method could not be saved. Please, try again.'));
        }
        $contacts = $this->Methods->Contacts->find('list', ['limit' => 200])->all();
        $this->set(compact('method', 'contacts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Method id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $method = $this->Methods->get($id, [
            'contain' => ['Contacts'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $method = $this->Methods->patchEntity($method, $this->request->getData());
            if ($this->Methods->save($method)) {
                $this->Flash->success(__('The method has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The method could not be saved. Please, try again.'));
        }
        $contacts = $this->Methods->Contacts->find('list', ['limit' => 200])->all();
        $this->set(compact('method', 'contacts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Method id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $method = $this->Methods->get($id);
        if ($this->Methods->delete($method)) {
            $this->Flash->success(__('The method has been deleted.'));
        } else {
            $this->Flash->error(__('The method could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
