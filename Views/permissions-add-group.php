<?php $this->loadView('header', [
    'title' => 'Permissões - Adicionar grupo de permissões',
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<?php $this->loadView('menu', ['company_name' => $viewData['company_name']]); ?>
<div class="container">
    <?php $this->loadView('top', ['user_email' => $viewData['user_email']]); ?>
    <div class="area">
        <h1>Permissões - Adicionar grupo de permissões</h1>
        <form method="POST">
            <label for="name">Nome do grupo</label>
            <input type="text" name="name"><br><br>
            <label>Permissões</label><br><br>
            <?php foreach ($permissions_list as $permission): ?>
                <input
                    type="checkbox"
                    name="permissions[]"
                    id="p_<?php echo $permission['id']; ?>"
                    value="<?php echo $permission['id']; ?>">
                <label for="p_<?php echo $permission['id']; ?>"><?php echo $permission['name']; ?></label>
                <br>
            <?php endforeach; ?>
            <br>
            <input type="submit" value="Adicionar">
        </form>
    </div>
</div>
<?php $this->loadView('footer'); ?>
