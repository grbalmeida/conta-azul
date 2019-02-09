<?php $this->loadView('header', [
    'title' => 'Permissões',
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<?php $this->loadView('menu', ['company_name' => $viewData['company_name']]); ?>
<div class="container">
    <?php $this->loadView('top', ['user_email' => $viewData['user_email']]); ?>
    <div class="area">
        <h1>Permissões</h1>
        <div class="tab-area">
            <div class="tab-item active-tab">Grupos de permissões</div>
            <div class="tab-item">Permissões</div>
        </div>
        <div class="tab-content">
            <div class="tab-body">
                <a class="button" href="<?php echo BASE_URL.'/permissions/add_group'; ?>">Adicionar grupo de permissão</a>
                    <table width="100%">
                        <tr>
                            <th>Nome do grupo de permissões</th>
                            <th>Ações</th>
                        </tr>
                       <?php foreach ($permissions_group_list as $group_permission): ?>
                            <tr>
                                <td><?php echo $group_permission['name']; ?></td>
                                <td>
                                    <form
                                        method="POST"
                                        action="<?php echo BASE_URL.'/permissions/delete_group/'.$group_permission['id']; ?>">
                                        <input
                                            type="submit"
                                            value="Excluir"
                                            onclick="return confirm('Tem certeza que deseja excluir?')"
                                        />
                                        <a class="button"
                                            href="<?php echo BASE_URL.'/permissions/edit_group/'.$group_permission['id']; ?>">
                                            Editar
                                        </a>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
            </div>
            <div class="tab-body">
                <a class="button" href="<?php echo BASE_URL.'/permissions/add'; ?>">Adicionar permissão</a>
                <table width="100%">
                    <tr>
                        <th>Nome da permissão</th>
                        <th>Ações</th>
                    </tr>
                    <?php foreach ($permissions_list as $permission): ?>
                        <tr>
                            <td><?php echo $permission['name']; ?></td>
                            <td>
                                <form
                                    method="POST"
                                    action="<?php echo BASE_URL.'/permissions/delete/'.$permission['id']; ?>">
                                    <input
                                        type="submit"
                                        value="Excluir"
                                        onclick="return confirm('Tem certeza que deseja excluir?')"
                                    />
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $this->loadView('footer'); ?>
