<?php $this->loadView('header', [
    'title' => 'Relatório de Vendas',
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<?php $this->loadView('menu', ['company_name' => $viewData['company_name']]); ?>
<div class="container">
    <?php $this->loadView('top', ['user_email' => $viewData['user_email']]); ?>
    <div class="area">
        <h1>Relatório de Vendas</h1>
        <form method="GET" action="<?php echo BASE_URL.'/reports/sales_pdf'; ?>">
            <div class="report_grid_4">
                <label for='customer_name'>Nome do cliente</label><br>
                <input type="text" name="customer_name" id="customer_name">
            </div>
            <div class="report_grid_4">
                <label>Período</label><br>
                <input type="date" min="1900-01-01" name="first_period" value="<?php echo date('Y-m-d'); ?>"><br>
                <input type="date" min="1900-01-01" name="final_period" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="report_grid_4">
                <label>Status</label>
                <select name="status">
                    <option value="">Todos os status</option>
                    <?php foreach ($status as $key => $value): ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="report_grid_4">
                <label>Status</label>
                <select name="order_by">
                    <option value="date_desc">Mais recente</option>
                    <option value="date_asc">Mais antigo</option>
                    <option value="status">Status</option>
                </select>
            </div>
            <div style="clear:both;"></div>
            <div style="text-align:center;">
                <input type="submit" value="Gerar Relatório">
            </div>
        </form>
    </div>
</div>
<?php $this->loadView('footer'); ?>
