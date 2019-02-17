<?php $this->loadView('header', [
    'title' => 'Inventário - Editar',
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<?php $this->loadView('menu', ['company_name' => $viewData['company_name']]); ?>
<div class="container">
    <?php $this->loadView('top', ['user_email' => $viewData['user_email']]); ?>
    <div class="area">
        <h1>Inventário - Editar</h1>
        <form method="POST">
            <label for="name">Nome</label>
            <input
                type="text"
                name="name"
                id="name"
                value="<?php echo $inventory_info['name']; ?>"><br><br>
            <label for="price">Preço</label>
            <input
                type="text"
                name="price"
                id="price"
                maxlength="15"
                data-price
                value="<?php echo number_format($inventory_info['price'], 2); ?>"><br><br>
            <label for="quantity">Quantidade</label>
            <input
                type="number"
                name="quantity"
                id="quantity"
                min="0"
                data-number
                value="<?php echo $inventory_info['quantity']; ?>"><br><br>
            <label for="minimum_quantity">Quantidade mínima</label>
            <input
                type="number"
                name="minimum_quantity"
                id="minimum_quantity"
                min="0"
                data-number
                value="<?php echo $inventory_info['minimum_quantity']; ?>"><br><br>
            <input type="submit" value="Editar" name="submit">
            <?php if (count($errors) > 0): ?>
                <?php foreach ($errors as $key => $value): ?>
                    <div class="error"><?php echo $errors[$key]; ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
        </form>
    </div>
</div>
<script src="<?php echo BASE_URL.'/node_modules/jquery-mask-plugin/dist/jquery.mask.min.js'; ?>"></script>
<script src="<?php echo BASE_URL.'/assets/js/inventory-add.js'; ?>"></script>
<?php $this->loadView('footer'); ?>
