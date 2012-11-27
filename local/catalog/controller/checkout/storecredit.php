<?php
class ControllerCheckoutStoreCredit extends Controller {
	private $error = array();

	public function index() {
		$name = basename(__FILE__, '.php');

		$name = str_replace('vq2-catalog_controller_checkout_', '', basename(__FILE__, '.php'));

		$this->language->load('checkout/' . $name);
		
		$this->document->setTitle($this->language->get('heading_title'));

		if (!isset($this->session->data['vouchers'])) {
			$this->session->data['vouchers'] = array();
		}

    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->session->data['vouchers'][rand()] = array(
				'description'      => sprintf($this->language->get('text_for'), $this->currency->format($this->currency->convert($this->request->post['amount'], $this->currency->getCode(), $this->config->get('config_currency')))),
				'to_name'          => 'store-credit',
				'to_email'         => 'purchased',
				'from_name'        => $this->customer->getId(),
				'from_email'       => '',
				'message'          => '',
				'amount'           => $this->currency->convert($this->request->post['amount'], $this->currency->getCode(), $this->config->get('config_currency')),
				'voucher_theme_id' => 0
			);

	  		$this->redirect($this->url->link('checkout/cart'));
    	}

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
        	'separator' => false
      	);

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_' . $name),
			'href'      => $this->url->link('checkout/' . $name, '', 'SSL'),
        	'separator' => $this->language->get('text_separator')
      	);

    	$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_description'] = $this->language->get('text_description');
		$this->data['text_agree'] = $this->language->get('text_agree');

		$this->data['entry_amount'] = sprintf($this->language->get('entry_amount'), $this->currency->format(1, false, 1), $this->currency->format(1000, false, 1));

		$this->data['button_continue'] = $this->language->get('button_continue');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['amount'])) {
			$this->data['error_amount'] = $this->error['amount'];
		} else {
			$this->data['error_amount'] = '';
		}

		$this->data['error_logged'] = $this->language->get('error_logged');

		$this->data['action'] = $this->url->link('checkout/' . $name, '', 'SSL');

		if (isset($this->request->post['amount'])) {
			$this->data['amount'] = $this->request->post['amount'];
		} else {
			$this->data['amount'] = '25.00';
		}

		if (isset($this->request->post['agree'])) {
			$this->data['agree'] = $this->request->post['agree'];
		} else {
			$this->data['agree'] = false;
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/' . $name . '.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/' . $name . '.tpl';
		} else {
			$this->template = 'default/template/checkout/' . $name . '.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render());
  	}
/*
  	public function success() {
  		$name = basename(__FILE__, '.php');

		$this->language->load('checkout/' . $name);

		$this->document->setTitle($this->language->get('heading_title'));

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
        	'separator' => false
      	);

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('checkout/' . $name),
        	'separator' => $this->language->get('text_separator')
      	);

    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['button_continue'] = $this->language->get('button_continue');

    	$this->data['continue'] = $this->url->link('checkout/cart');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);

 		$this->response->setOutput($this->render());
	}
*/
	private function validate() {

		if (($this->request->post['amount'] < 1) || ($this->request->post['amount'] > 1000)) {
      		$this->error['amount'] = sprintf($this->language->get('error_amount'), $this->currency->format(1, false, 1), $this->currency->format(1000, false, 1) . ' ' . $this->currency->getCode());
    	}

		if (!isset($this->request->post['agree'])) {
      		$this->error['warning'] = $this->language->get('error_agree');
		}

    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
	}
}
?>