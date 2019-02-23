<?php $this->loadView('header', [
    'title' => 'Relatório de Vendas',
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<style>
    fieldset { width: 50%; }
</style>
<div class="container">
    <div class="area">
        <h1>Relatório de Vendas</h1>
        <fieldset>

        </fieldset>
        <table>
            <tr>
                <th>Nome do Cliente</th>
                <th>Data</th>
                <th>Status</th>
                <th>Valor</th>
            </tr>
            <?php foreach ($sales_list as $sale): ?>
                <tr>
                    <td><?php echo $sale['name']; ?></td>
                    <td><?php echo date('d/m/Y H:i:s', strtotime($sale['sale_date'])); ?></td>
                    <td><?php echo $sale['sale_status']; ?></td>
                    <td><?php echo number_format($sale['total_price'], 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php $this->loadView('footer'); ?>
