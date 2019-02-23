<?php $this->loadView('header', [
    'title' => 'Relatórios',
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<?php $this->loadView('menu', ['company_name' => $viewData['company_name']]); ?>
<div class="container">
    <?php $this->loadView('top', ['user_email' => $viewData['user_email']]); ?>
    <div class="area">
        <h1>Relatórios</h1>
        <div class="report_item">
            <a href="<?php echo BASE_URL.'/reports/sales'; ?>">Vendas</a>
        </div>
    </div>
</div>
<?php $this->loadView('footer'); ?>
