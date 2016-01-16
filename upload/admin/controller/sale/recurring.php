<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerSaleRecurring extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('sale/recurring');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/recurring');

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_order_recurring_id'])) {
			$filter_order_recurring_id = $this->request->get['filter_order_recurring_id'];
		} else {
			$filter_order_recurring_id = null;
		}

		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = null;
		}

		if (isset($this->request->get['filter_reference'])) {
			$filter_reference = $this->request->get['filter_reference'];
		} else {
			$filter_reference = null;
		}

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = 0;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'order_recurring_id';
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_order_recurring_id'])) {
			$url .= '&filter_order_recurring_id=' . $this->request->get['filter_order_recurring_id'];
		}

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_reference'])) {
			$url .= '&filter_reference=' . $this->request->get['filter_reference'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->ssl('common/dashboard', 'token=' . $this->session->data['token'], true),
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->ssl('sale/recurring', 'token=' . $this->session->data['token'] . $url, true),
		);

		$filter_data = array(
			'filter_order_recurring_id' => $filter_order_recurring_id,
			'filter_order_id'           => $filter_order_id,
			'filter_reference'  => $filter_reference,
			'filter_customer'           => $filter_customer,
			'filter_status'             => $filter_status,
			'filter_date_added'         => $filter_date_added,
			'order'                     => $order,
			'sort'                      => $sort,
			'start'                     => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                     => $this->config->get('config_limit_admin'),
		);

		$recurrings_total = $this->model_sale_recurring->getTotalRecurrings($filter_data);

		$results = $this->model_sale_recurring->getRecurrings($filter_data);

		$data['recurrings'] = array();

		foreach ($results as $result) {
			$date_added = date($this->language->get('date_format_short'), strtotime($result['date_added']));

			$data['recurrings'][] = array(
				'order_recurring_id' => $result['order_recurring_id'],
				'order_id'           => $result['order_id'],
				'order_link'         => $this->url->ssl('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], true),
				'reference'          => $result['reference'],
				'customer'           => $result['customer'],
				'status'             => $result['status'],
				'date_added'         => $date_added,
				'view'               => $this->url->ssl('sale/recurring/info', 'token=' . $this->session->data['token'] . '&order_recurring_id=' . $result['order_recurring_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['entry_order_id'] = $this->language->get('entry_order_id');
		$data['entry_order_recurring'] = $this->language->get('entry_order_recurring');
		$data['entry_reference'] = $this->language->get('entry_reference');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		$data['entry_action'] = $this->language->get('entry_action');

		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_view'] = $this->language->get('button_view');

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_order_recurring_id'])) {
			$url .= '&filter_order_recurring_id=' . $this->request->get['filter_order_recurring_id'];
		}

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_reference'])) {
			$url .= '&filter_reference=' . urlencode(html_entity_decode($this->request->get['filter_reference'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_order_recurring'] = $this->url->ssl('sale/recurring', 'token=' . $this->session->data['token'] . '&sort=or.order_recurring_id' . $url, true);
		$data['sort_order'] = $this->url->ssl('sale/recurring', 'token=' . $this->session->data['token'] . '&sort=or.order_id' . $url, true);
		$data['sort_reference'] = $this->url->ssl('sale/recurring', 'token=' . $this->session->data['token'] . '&sort=or.reference' . $url, true);
		$data['sort_customer'] = $this->url->ssl('sale/recurring', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, true);
		$data['sort_status'] = $this->url->ssl('sale/recurring', 'token=' . $this->session->data['token'] . '&sort=or.status' . $url, true);
		$data['sort_date_added'] = $this->url->ssl('sale/recurring', 'token=' . $this->session->data['token'] . '&sort=or.date_added' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_order_recurring_id'])) {
			$url .= '&filter_order_recurring_id=' . $this->request->get['filter_order_recurring_id'];
		}

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_reference'])) {
			$url .= '&filter_reference=' . urlencode(html_entity_decode($this->request->get['filter_reference'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $recurrings_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->ssl('sale/recurring', 'token=' . $this->session->data['token'] . '&page={page}' . $url, true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($recurrings_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($recurrings_total - $this->config->get('config_limit_admin'))) ? $recurrings_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $recurrings_total, ceil($recurrings_total / $this->config->get('config_limit_admin')));

		$data['filter_order_recurring_id'] = $filter_order_recurring_id;
		$data['filter_order_id'] = $filter_order_id;
		$data['filter_reference'] = $filter_reference;
		$data['filter_customer'] = $filter_customer;
		$data['filter_status'] = $filter_status;
		$data['filter_date_added'] = $filter_date_added;

		$data['statuses'] = array(
			'0' => '',
			'1' => $this->language->get('text_status_inactive'),
			'2' => $this->language->get('text_status_active'),
			'3' => $this->language->get('text_status_suspended'),
			'4' => $this->language->get('text_status_cancelled'),
			'5' => $this->language->get('text_status_expired'),
			'6' => $this->language->get('text_status_pending'),
		);

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/recurring_list', $data));
	}

	public function info() {
		$this->load->model('sale/recurring');
		$this->load->model('sale/order');
		$this->load->model('catalog/product');

		$this->load->language('sale/recurring');

		$order_recurring = $this->model_sale_recurring->getRecurring($this->request->get['order_recurring_id']);

		if ($order_recurring) {
			$order_info = $this->model_sale_order->getOrder($order_recurring_info['order_id']);

			$this->document->setTitle($this->language->get('heading_title'));

			$url = '';

			if (isset($this->request->get['filter_order_recurring_id'])) {
				$url .= '&filter_order_recurring_id=' . $this->request->get['filter_order_recurring_id'];
			}

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}

			if (isset($this->request->get['filter_reference'])) {
				$url .= '&filter_reference=' . $this->request->get['filter_reference'];
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->ssl('common/dashboard', 'token=' . $this->session->data['token'], true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->ssl('sale/recurring', 'token=' . $this->session->data['token'] . $url, true)
			);

			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
			} else {
				$data['error_warning'] = '';
			}

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}

			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_transactions'] = $this->language->get('text_transactions');
			$data['text_cancel_confirm'] = $this->language->get('text_cancel_confirm');

			$data['entry_order_id'] = $this->language->get('entry_order_id');
			$data['entry_order_recurring'] = $this->language->get('entry_order_recurring');
			$data['entry_reference'] = $this->language->get('entry_reference');
			$data['entry_customer'] = $this->language->get('entry_customer');
			$data['entry_status'] = $this->language->get('entry_status');
			$data['entry_type'] = $this->language->get('entry_type');
			$data['entry_email'] = $this->language->get('entry_email');
			$data['entry_description'] = $this->language->get('entry_description');
			$data['entry_product'] = $this->language->get('entry_product');
			$data['entry_quantity'] = $this->language->get('entry_quantity');
			$data['entry_amount'] = $this->language->get('entry_amount');
			$data['entry_cancel_payment'] = $this->language->get('entry_cancel_payment');
			$data['entry_recurring'] = $this->language->get('entry_recurring');
			$data['entry_payment_method'] = $this->language->get('entry_payment_method');
			$data['entry_date_added'] = $this->language->get('entry_date_added');

			$data['button_cancel'] = $this->language->get('button_cancel');

			$data['order_recurring_id'] = $order_recurring_info['order_recurring_id'];
			$data['product'] = $order_recurring_info['product_name'];
			$data['quantity'] = $order_recurring_info['product_quantity'];
			$data['status'] = $order_recurring_info['status'];
			$data['reference'] = $order_recurring_info['reference'];
			$data['recurring_description'] = $order_recurring_info['recurring_description'];
			$data['recurring_name'] = $order_recurring_info['recurring_name'];

			$data['order_id'] = $order_info['order_id'];
			$data['order'] = $this->url->ssl('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $order_info['order_id'], true);

			$data['customer'] = $order_info['customer'];
			$data['email'] = $order_info['email'];
			$data['payment_method'] = $order_info['payment_method'];
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));

			$data['options'] = array();

			if ($order_info['customer_id']) {
				$data['customer'] = $this->url->ssl('customer/customer/edit', 'token=' . $this->session->data['token'] . '&customer_id=' . $order_info['customer_id'], true);
			} else {
				$data['customer'] = '';
			}

			if ($order_recurring_info['recurring_id'] != '0') {
				$data['recurring'] = $this->url->ssl('catalog/recurring/edit', 'token=' . $this->session->data['token'] . '&recurring_id=' . $order_recurring_info['recurring_id'], true);
			} else {
				$data['recurring'] = '';
			}

			$data['transactions'] = array();
			
			$transactions = $this->model_sale_recurring->getRecurringTransactions($order_recurring_info['order_recurring_id']);

			foreach ($transactions as $transaction) {
				$data['transactions'][] = array(
					'date_added' => $transaction['date_added'],
					'type'       => $transaction['type'],
					'amount'     => $this->currency->format($transaction['amount'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}

			$data['return'] = $this->url->ssl('sale/recurring', 'token=' . $this->session->data['token'] . $url, true);

			$data['token'] = $this->request->get['token'];

			$data['buttons'] = $this->load->controller('payment/' . $order_info['payment_code'] . '/recurringButtons');

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('sale/recurring_info', $data));
		} else {
			return new Action('error/not_found');
		}
	}
}