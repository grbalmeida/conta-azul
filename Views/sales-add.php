<?php $this->loadView('header', [
    'title' => 'Venda - Adicionar',
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<?php $this->loadView('menu', ['company_name' => $viewData['company_name']]); ?>
<div class="container">
    <?php $this->loadView('top', ['user_email' => $viewData['user_email']]); ?>
    <div class="area">
        <h1>Venda - Adicionar</h1>
        <form method="POST">
            <label for="customer_name">Nome do cliente</label><br><br>
            <input type="hidden" name="customer_id">
            <input
                type="text"
                name="customer_name"
                id="customer_name"
                data-type="searchCustomers"
                data-search-customer-sale
                placeholder="Informe o nome do usuário...">
                <button data-add-customer>+</button><br><br>
            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="0">Aguardando Pagamento</option>
                <option value="1">Pago</option>
                <option value="2">Cancelado</option>
            </select><br>
            <label for="total_price">Preço total</label><br>
            <input type="text" name="total_price" data-price style="width: 50%;"><br><br>
            <input type="submit" value="Adicionar" name="submit">
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
<script src="<?php echo BASE_URL.'/assets/js/sales-add.js'; ?>"></script>
<?php $this->loadView('footer'); ?>
