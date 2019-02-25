<?php $this->loadView('header', [
    'title' => $viewData['company_name'],
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<?php $this->loadView('menu', ['company_name' => $viewData['company_name']]); ?>
<div class="container">
    <?php $this->loadView('top', ['user_email' => $viewData['user_email']]); ?>
    <div class="dashboard">
        <div class="grid_1">
            <div class="dashboard_grid_area">
                <div class="dashboard_grid_area_count"><?php echo $products_sold; ?></div>
                <div class="dashboard_grid_area_legend">Produtos vendidos</div>
            </div>
        </div>
        <div class="grid_1">
            <div class="dashboard_grid_area">
                <div class="dashboard_grid_area_count">
                    R$ <?php echo number_format($revenue, 2, ',', '.'); ?>
                </div>
                <div class="dashboard_grid_area_legend">Receitas</div>
            </div>
        </div>
        <div class="grid_1">
            <div class="dashboard_grid_area">
                <div class="dashboard_grid_area_count">
                    R$ <?php echo number_format($expenses, 2, ',', '.'); ?>
                </div>
                <div class="dashboard_grid_area_legend">Despesas</div>
            </div>
        </div>
    </div>
    <div class="dashboard">
        <div class="grid_2">
            <div class="dashboard_info">
                <div class="dashboard_info_title">
                    Receitas e despesas dos últimos 30 dias
                </div>
                <div class="dashboard_info_body" height="300">
                    <canvas id="first_report"></canvas>
                </div>
            </div>
        </div>
        <div class="grid_1">
            <div class="dashboard_info">
                <div class="dashboard_info_title">
                    Status de Pagamento
                </div>
                <div class="dashboard_info_body" height="300">
                    <canvas id="second_report" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const daysList = <?php echo json_encode($days_list) ?>;
    const revenue = <?php echo json_encode($revenue_list) ?>;
    const expenses = [4, 7, 8, 9]
    const paymentOptionsValues = <?php echo json_encode($status_list) ?>;
</script>
<script src="<?php echo BASE_URL.'/node_modules/chart.js/dist/Chart.min.js'; ?>"></script>
<script src="<?php echo BASE_URL.'/assets/js/dashboard.js'; ?>"></script>
<?php $this->loadView('footer'); ?>
