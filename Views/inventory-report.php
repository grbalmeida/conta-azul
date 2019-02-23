<?php $this->loadView('header', [
    'title' => 'Relatório de Estoque',
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<?php $this->loadView('menu', ['company_name' => $viewData['company_name']]); ?>
<div class="container">
    <?php $this->loadView('top', ['user_email' => $viewData['user_email']]); ?>
    <div class="area">
        <h1>Relatório de Estoque</h1>
        <form method="GET" action="<?php echo BASE_URL.'/reports/inventory_pdf'; ?>">
            <input type="submit" value="Gerar Relatório">
        </form>
    </div>
</div>
<?php $this->loadView('footer'); ?>
