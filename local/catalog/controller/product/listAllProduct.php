<?php
class ControllerproductlistAllProduct extends Controller {

	private function getCategories ($parent_id = -1)
	{

		$categories = $this->model_catalog_category->getAllCategoriesTree(-1);

        return $categories;

	}

	private function getProducts ($category_id)
	{
		$data = array(
				'filter_category_id' => $category_id,
				'sort'               => 'id',
				'order'              => 'DESC'
			);


		$products = $this->model_catalog_product->getProducts($data);

		if (count ($products) > 0)
		{
			foreach ($products as $key => $product) {


				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float)$product['special']) {
					$special = $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$product['special'] ? $product['special'] : $product['price']);
				} else {
					$tax = false;
				}

				$attributi = $this->model_catalog_product->getProductAttributes($product['product_id']);
				$description = html_entity_decode($product['description'], ENT_QUOTES, 'UTF-8');

				$productData= array(
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'attributi'   => $attributi,
					'description' => $description
				);

				$products[$key] = array_merge ($products[$key], $productData);




			}
		}

		return ($products);
	}


	public function index() {
		$this->language->load('product/category');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$this->data['categorieProdotti'] = array();

		$arrayCategorie = $this->getCategories ();

		if (count ($arrayCategorie) > 0)
		{
			foreach ($arrayCategorie as $key => $categoria) {
				$arrayCategorie[$key]['prodotti'] = ($this->getProducts ($categoria['category_id']));
			}
		}

		$this->data['categorieProdotti'] = $arrayCategorie;
		$this->data['text_tax'] = $this->language->get('text_tax');
		$this->data['text_price'] = $this->language->get('text_price');
		$this->data['button_cart'] = $this->language->get('button_cart');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/listAllProduct.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/listAllProduct.tpl';
		} else {
			$this->template = 'default/template/product/listAllProduct.tpl';
		}

		$this->render();





  	}
}
?>