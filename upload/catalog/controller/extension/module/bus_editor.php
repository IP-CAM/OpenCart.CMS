<?php
// *	@copyright	OPENCART.PRO 2011 - 2020.
// *	@forum		http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerExtensionModuleBusEditor extends Controller {
	public function index() {
		$this->user = new Cart\User($this->registry);

		if ($this->config->get('bus_editor_blog_category_href_status') && isset($this->request->get['blog_category']) && $this->user->isLogged()) {
			$bus_editor_href_admin = $this->config->get('bus_editor_href_admin');
			$this->response->redirect(($bus_editor_href_admin ? $bus_editor_href_admin : 'admin/') . 'index.php?route=blog/category/edit' . '&token=' . $this->session->data['token'] . '&blog_category_id=' . (int)$this->request->get['blog_category']);
		} elseif ($this->config->get('bus_editor_blog_article_href_status') && isset($this->request->get['article']) && $this->user->isLogged()) {
			$bus_editor_href_admin = $this->config->get('bus_editor_href_admin');
			$this->response->redirect(($bus_editor_href_admin ? $bus_editor_href_admin : 'admin/') . 'index.php?route=blog/article/edit' . '&token=' . $this->session->data['token'] . '&article_id=' . (int)$this->request->get['article']);
		} elseif ($this->config->get('bus_editor_category_href_status') && isset($this->request->get['category']) && $this->user->isLogged()) {
			$bus_editor_href_admin = $this->config->get('bus_editor_href_admin');
			$this->response->redirect(($bus_editor_href_admin ? $bus_editor_href_admin : 'admin/') . 'index.php?route=catalog/category/edit' . '&token=' . $this->session->data['token'] . '&category_id=' . (int)$this->request->get['category']);
		} elseif ($this->config->get('bus_editor_information_href_status') && isset($this->request->get['information']) && $this->user->isLogged()) {
			$bus_editor_href_admin = $this->config->get('bus_editor_href_admin');
			$this->response->redirect(($bus_editor_href_admin ? $bus_editor_href_admin : 'admin/') . 'index.php?route=catalog/information/edit' . '&token=' . $this->session->data['token'] . '&information_id=' . (int)$this->request->get['information']);
		} elseif ($this->config->get('bus_editor_manufacturer_href_status') && isset($this->request->get['manufacturer']) && $this->user->isLogged()) {
			$bus_editor_href_admin = $this->config->get('bus_editor_href_admin');
			$this->response->redirect(($bus_editor_href_admin ? $bus_editor_href_admin : 'admin/') . 'index.php?route=catalog/manufacturer/edit' . '&token=' . $this->session->data['token'] . '&manufacturer_id=' . (int)$this->request->get['manufacturer']);
		} elseif ($this->config->get('bus_editor_product_href_status') && isset($this->request->get['product']) && $this->user->isLogged()) {
			$bus_editor_href_admin = $this->config->get('bus_editor_href_admin');
			$this->response->redirect(($bus_editor_href_admin ? $bus_editor_href_admin : 'admin/') . 'index.php?route=catalog/product/edit' . '&token=' . $this->session->data['token'] . '&product_id=' . (int)$this->request->get['product']);
		} else {
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 403 Forbidden');
			$this->response->setOutput($this->language->get('error_bus_editor_href'));
		}
	}
}