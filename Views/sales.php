<?php $this->loadView('header', [
    'title' => 'Vendas',
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<?php $this->loadView('menu', ['company_name' => $viewData['company_name']]); ?>
<div class="container">
    <?php $this->loadView('top', ['user_email' => $viewData['user_email']]); ?>
    <div class="area">
        <h1>Vendas</h1>
        <a class="button" href="<?php echo BASE_URL.'/sales/add'; ?>">Adicionar venda</a>
        <table width="100%">
            <tr>
                <th>Nome do cliente</th>
                <th>Data</th>
                <th>Status</th>
                <th>Total</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($sales_list as $sale): ?>
                <tr>
                    <td><?php echo $sale['name']; ?></td>
                    <td><?php echo date('d/m/Y H:i:s', strtotime($sale['sale_date'])); ?></td>
                    <td><?php echo $sale['sale_status']; ?></td>
                    <td>R$ <?php echo number_format($sale['total_price'], 2, ',', '.'); ?></td>
                </tr
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php $this->loadView('footer'); ?>
