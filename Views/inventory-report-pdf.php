<?php $this->loadView('header', [
    'title' => 'Relatório de Estoque',
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<style>
    fieldset { width: 50%; }
</style>
<div class="container">
    <div class="area">
        <h1>Relatório de Estoque</h1>
        <table>
            <tr>
                <th>Nome</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Quantidade mímima</th>
                <th>Diferença</th>
            </tr>
            <?php foreach ($inventory_list as $inventory): ?>
                <tr>
                    <td><?php echo $inventory['name']; ?></td>
                    <td>R$ <?php echo number_format($inventory['price'], 2, ',', '.'); ?></td>
                    <td><?php echo $inventory['quantity']; ?></td>
                    <td>
                        <?php if ($inventory['quantity'] >= $inventory['minimum_quantity']): ?>
                            <?php echo $inventory['minimum_quantity']; ?>
                        <?php else: ?>
                            <span style="color: red;"><?php echo $inventory['minimum_quantity']; ?></span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $inventory['minimum_quantity'] - $inventory['quantity']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php $this->loadView('footer'); ?>
