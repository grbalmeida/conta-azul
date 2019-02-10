<?php $this->loadView('header', [
    'title' => 'Usuários - Adicionar',
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<?php $this->loadView('menu', ['company_name' => $viewData['company_name']]); ?>
<div class="container">
    <?php $this->loadView('top', ['user_email' => $viewData['user_email']]); ?>
    <div class="area">
        <h1>Usuários - Adicionar</h1>
        <form method="POST">
            <label for="name">Nome</label>
            <input type="text" name="name">
            <label for="email">E-mail</label>
            <input type="email" name="email">
            <label for="password">Senha</label>
            <input type="password" name="password">
            <label for="group">Grupo de permissões</label>
            <select name="group">
                <?php foreach ($group_list as $group): ?>
                    <option value="<?php echo $group['id']; ?>">
                        <?php echo $group['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br>
            <input type="submit" value="Adicionar" name="submit">
            <?php if (count($errors) > 0): ?>
                <?php foreach ($errors as $key => $value): ?>
                    <div class="error"><?php echo $errors[$key]; ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
        </form>
    </div>
</div>
<?php $this->loadView('footer'); ?>
