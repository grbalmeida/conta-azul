<?php $this->loadView('header', [
    'title' => 'Clientes',
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<?php $this->loadView('menu', ['company_name' => $viewData['company_name']]); ?>
<div class="container">
    <?php $this->loadView('top', ['user_email' => $viewData['user_email']]); ?>
    <div class="area">
        <h1>Clientes</h1>
        <?php if ($has_permission_customers_edit): ?>
            <a class="button" href="<?php echo BASE_URL.'/customer/add'; ?>">Adicionar cliente</a>
        <?php endif; ?>
        <table width="100%">
            <tr>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Cidade</th>
                <th>Estrelas</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($customers_list as $customer): ?>
            <tr>
                <td><?php echo $customer['name']; ?></td>
                <td><?php echo $customer['phone']; ?></td>
                <td><?php echo $customer['city']; ?></td>
                <td><?php echo $customer['stars']; ?></td>
                <td>
                <?php if ($has_permission_customers_edit): ?>
                    <form
                        method="POST"
                        action="<?php echo BASE_URL.'/customers/delete/'.$customer['id']; ?>">
                        <input
                            type="submit"
                            value="Excluir"
                            onclick="return confirm('Tem certeza que deseja excluir?')"
                        />
                        <a class="button"
                            href="<?php echo BASE_URL.'/customers/edit/'.$customer['id']; ?>">
                            Editar
                        </a>
                    </form>
                <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php $this->loadView('footer'); ?>