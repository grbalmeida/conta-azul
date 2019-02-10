<?php $this->loadView('header', [
    'title' => 'Usuários',
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<?php $this->loadView('menu', ['company_name' => $viewData['company_name']]); ?>
<div class="container">
    <?php $this->loadView('top', ['user_email' => $viewData['user_email']]); ?>
    <div class="area">
        <h1>Usuários</h1>
        <a class="button" href="<?php echo BASE_URL.'/users/add'; ?>">Adicionar usuário</a>
        <table width="100%">
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Grupo</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($users_list as $user): ?>
            <tr>
                <td><?php echo $user['user_name']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['group_name']; ?></td>
                <td>
                <form
                    method="POST"
                    action="<?php echo BASE_URL.'/users/delete/'.$user['id']; ?>">
                    <input
                        type="submit"
                        value="Excluir"
                        onclick="return confirm('Tem certeza que deseja excluir?')"
                    />
                    <a class="button"
                        href="<?php echo BASE_URL.'/users/edit/'.$user['id']; ?>">
                        Editar
                    </a>
                </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php $this->loadView('footer'); ?>
