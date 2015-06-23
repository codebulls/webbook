<?php

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class SecurityPlugin extends Plugin
{

	/**
	 * Returns an existing or new access control list
	 *
	 * @returns AclList
	 */
	public function getAcl()
	{

		//throw new \Exception("something");
		#print_r($this->persistent->acl);exit;
		if (!isset($this->persistent->acl)) {

			$acl = new AclList();

			$acl->setDefaultAction(Acl::DENY);

			//Register roles
			$roles = array(
				'customers'  => new Role('Customers'),
				'admins' => new Role('Admins'),
				'guests' => new Role('Guests')
			);
			foreach ($roles as $role) {
				$acl->addRole($role);
			}

			//Admin Zugriffe
			$adminResources = array(
				'adminuser'    => array('index', 'new', 'edit', 'save', 'create', 'delete'),
				'adminaccount'     => array('index', 'edit', 'save', 'create', 'delete', 'show'),
				'adminwebbook' => array('index', 'new', 'edit', 'save', 'create', 'delete'),
				'admincenter' => array('index')
			);
			foreach ($adminResources as $resource => $actions) {
				$acl->addResource(new Resource($resource), $actions);
			}

			//Kunden Zugriffe
			$customerResources = array(
				'user'    => array('index', 'update', 'edit'),
				'account'     => array('index', 'edit', 'update'),
				'webbook' => array('index', 'new', 'edit', 'save', 'create', 'delete'),
				'project' => array('index', 'new', 'create', 'edit', 'update'),
				'center' => array('index')
			);
			foreach ($customerResources as $resource => $actions) {
				$acl->addResource(new Resource($resource), $actions);
			}

			//Öffentliche Zugriffe
			$publicResources = array(
				'index'      => array('index'),
				'about'      => array('index'),
				'user'		 => array('new', 'checkdata', 'createuser', 'create', 'confirm'),
				'account'	 => array('create'),
				'errors'     => array('show401', 'show404', 'show500'),
				'login'    => array('index', 'start', 'end'),
				'contact'    => array('index', 'send')
			);
			foreach ($publicResources as $resource => $actions) {
				$acl->addResource(new Resource($resource), $actions);
			}
			

			//Grant access to public areas to both users and guests
			foreach ($roles as $role) {
				foreach ($publicResources as $resource => $actions) {
					foreach ($actions as $action){
						$acl->allow($role->getName(), $resource, $action);
					}
				}
			}

			//Grant acess to private area to role Users
			foreach ($adminResources as $resource => $actions) {
				foreach ($actions as $action){
					$acl->allow('Admins', $resource, $action);
				}
			}

			//Grant acess to private area to role Users
			foreach ($customerResources as $resource => $actions) {
				foreach ($actions as $action){
					$acl->allow('Customers', $resource, $action);
				}
			}

			//The acl is stored in session, APC would be useful here too
			$this->persistent->acl = $acl;
		}

		return $this->persistent->acl;
	}

	/**
	 * This action is executed before execute any action in the application
	 *
	 * @param Event $event
	 * @param Dispatcher $dispatcher
	 */
	public function beforeDispatch(Event $event, Dispatcher $dispatcher)
	{

		$c_auth = $this->session->get('c_auth');
		$a_auth = $this->session->get('a_auth');
		if ($c_auth){
			$role = 'Customers';
		} elseif($a_auth) {
			$role = 'Admins';
		}
		else
		{
			$role = 'Guests';
		}

		$controller = $dispatcher->getControllerName();
		$action = $dispatcher->getActionName();

		$acl = $this->getAcl();

		$allowed = $acl->isAllowed($role, $controller, $action);
		if ($allowed != Acl::ALLOW) {
			$dispatcher->forward(array(
				'controller' => 'errors',
				'action'     => 'show401'
			));
            $this->session->destroy();
			return false;
		}
	}
}
