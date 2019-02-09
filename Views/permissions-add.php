<?php $this->loadView('header', [
    'title' => 'Permissões - Adicionar',
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<?php $this->loadView('menu', ['company_name' => $viewData['company_name']]); ?>
<div class="container">
    <?php $this->loadView('top', ['user_email' => $viewData['user_email']]); ?>
    <div class="area">
        <h1>Permissões - Adicionar</h1>
        <form method="POST">
            <label for="name">Nome</label>
            <input type="text" name="name"><br><br>
            <input type="submit" value="Adicionar">
        </form>
    </div>
</div>
<?php $this->loadView('footer'); ?>
