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
                    Título
                </div>
                <div class="dashboard_info_body">
                    Corpo
                </div>
            </div>
        </div>
        <div class="grid_1">
            <div class="dashboard_info">
                <div class="dashboard_info_title">
                    Título
                </div>
                <div class="dashboard_info_body">
                    Corpo
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->loadView('footer'); ?>
