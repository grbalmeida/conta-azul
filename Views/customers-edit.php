<?php $this->loadView('header', [
    'title' => 'Clientes - Editar',
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<?php $this->loadView('menu', ['company_name' => $viewData['company_name']]); ?>
<div class="container">
    <?php $this->loadView('top', ['user_email' => $viewData['user_email']]); ?>
    <div class="area">
        <h1>Clientes - Editar</h1>
        <form method="POST">
            <label for="name">Nome</label>
            <input type="text" name="name" id="name" value="<?php echo $customer_info['name']; ?>"><br><br>
            <label for="email">E-mail</label>
            <input type="text" name="email" id="email" value="<?php echo $customer_info['email']; ?>"><br><br>
            <label for="phone">Telefone</label>
            <input type="text" name="phone" id="phone" value="<?php echo $customer_info['phone']; ?>"><br><br>
            <label for="starts">Estrelas</label>
            <select name="stars" id="stars">
                <option value="1" <?php echo $customer_info['stars'] == 1 ? 'selected' : ''; ?>>1 estrela</option>
                <option value="2" <?php echo $customer_info['stars'] == 2 ? 'selected' : ''; ?>>2 estrelas</option>
                <option value="3" <?php echo $customer_info['stars'] == 3 ? 'selected' : ''; ?>>3 estrelas</option>
                <option value="4" <?php echo $customer_info['stars'] == 4 ? 'selected' : ''; ?>>4 estrelas</option>
                <option value="5" <?php echo $customer_info['stars'] == 5 ? 'selected' : ''; ?>>5 estrelas</option>
            </select>
            <label for="note">Observação</label>
            <textarea name="note" id="note"><?php echo $customer_info['note']; ?></textarea><br><br>
            <label for="address">Rua</label>
            <input type="text" name="address" id="address" value="<?php echo $customer_info['address']; ?>"><br><br>
            <label for="number">Número</label>
            <input type="text" name="number" id="number" value="<?php echo $customer_info['number']; ?>"><br><br>
            <label for="zipcode">Cep</label>
            <input type="text" name="zipcode" id="zipcode" value="<?php echo $customer_info['zipcode']; ?>"><br><br>
            <label for="city">Cidade</label>
            <input type="text" name="city" id="city" value="<?php echo $customer_info['city']; ?>"><br><br>
            <label for="state">Estado</label>
            <input type="text" name="state" id="state" value="<?php echo $customer_info['state']; ?>"><br><br>
            <label for="country">País</label>
            <input type="text" name="country" id="country" value="<?php echo $customer_info['country']; ?>"><br><br>
            <label for="neighborhood">Bairro</label>
            <input type="text" name="neighborhood" id="neighborhood" value="<?php echo $customer_info['neighborhood']; ?>"><br><br>
            <label for="complement">Complemento</label>
            <input type="text" name="complement" id="complement" value="<?php echo $customer_info['complement']; ?>"><br><br>
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
<script src="<?php echo BASE_URL.'/assets/js/customers-add.js'; ?>"></script>
<?php $this->loadView('footer'); ?>
