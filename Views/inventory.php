<?php $this->loadView('header', [
    'title' => 'Estoque',
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<?php $this->loadView('menu', ['company_name' => $viewData['company_name']]); ?>
<div class="container">
    <?php $this->loadView('top', ['user_email' => $viewData['user_email']]); ?>
    <div class="area">
        <h1>Estoque</h1>
        <?php if ($has_permission_inventory_add): ?>
            <a class="button" href="<?php echo BASE_URL.'/inventory/add'; ?>">Adicionar produto</a>
        <?php endif; ?>
        <input
            type="text"
            data-search
            data-type="searchInventory"
            placeholder="Buscar produto pelo nome..." />
        <table width="100%">
            <tr>
                <th>Nome</th>
                <th width="20%">Preço</th>
                <th width="15%">Quantidade</th>
                <th width="15%">Quantidade mínima</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($inventory_list as $inventory): ?>
                <tr>
                    <td><?php echo $inventory['name']; ?></td>
                    <td>R$ <?php echo number_format($inventory['price'], 2); ?></td>
                    <td><?php echo $inventory['quantity']; ?></td>
                    <td><?php echo $inventory['minimum_quantity']; ?></td>
                    <td>
                    <form
                        method="POST"
                        action="<?php echo BASE_URL.'/inventory/delete/'.$inventory['id']; ?>">
                        <input
                            type="submit"
                            value="Excluir"
                            onclick="return confirm('Tem certeza que deseja excluir?')"
                        />
                        <a class="button"
                            href="<?php echo BASE_URL.'/inventory/edit/'.$inventory['id']; ?>">
                            Editar
                        </a>
                    </form>
                    </td>
                </tr
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php $this->loadView('footer'); ?>
