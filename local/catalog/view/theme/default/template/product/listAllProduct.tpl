<?php if (count ($categorieProdotti) > 0): ?>

	<?php foreach ($categorieProdotti as $categoria): ?>

		<?php if (count ($categoria['prodotti']) > 0): ?>

			<div>
				<?php echo $categoria['name'] ?>
			</div>

			<?php foreach ($categoria['prodotti'] as $product): ?>

				<?php //print_r($product)?>

				<div class="name">
					<?php echo $product['name']; ?>
				</div>

				<div class="location">
					Località: <?php echo $product['location']; ?>
				</div>

				<div class="location">
					Disponibilità: <?php echo $product['quantity']; ?>
				</div>

				<?php if (count ($product['attributi'])): ?>

      				<?php foreach ($product['attributi'] as $attributoType): ?>

      					<?php foreach ($attributoType['attribute'] as $attributo): ?>

      						<div class="attributo">
      							<?php echo $attributo['name']?>: <?php echo $attributo['text']?>
      						</div>

      					<?php endforeach ?>


      				<?php endforeach ?>

      			<?php endif ?>

      			<div class="description">
      				<?php echo $product['description']; ?>
      			</div>
      			<?php if ($product['price']): ?>
      				<div class="price">
      					<?php echo $text_price; ?>
        				<?php if (!$product['special']):?>
        					<?php echo $product['price']; ?>
        				<?php else: ?>
        					<span class="price-old">
        						<?php echo $product['price']; ?>
        					</span>
        					<span class="price-new">
        						<?php echo $product['special']; ?>
        					</span>
        				<?php endif ?>

        				<?php if ($product['tax']):?>
        					<br />
        					<span class="price-tax">
        						<?php echo $text_tax; ?>
        						<?php echo $product['tax']; ?>
        					</span>
        				<?php endif ?>
      				</div>

      			<?php endif ?>


      		<div class="cart">
        		<input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" />
      		</div>

			<?php endforeach ?>

		<?php endif ?>

	<?php endforeach ?>

<?php endif ?>