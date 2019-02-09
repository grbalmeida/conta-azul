<?php $this->loadView('header', [
    'title' => 'Permissões',
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<?php $this->loadView('menu', ['company_name' => $viewData['company_name']]); ?>
<div class="container">
    <?php $this->loadView('top', ['user_email' => $viewData['user_email']]); ?>
    <div class="area">
        <h1>Permissões</h1>
        <div class="tab-area">
            <div class="tab-item active-tab">Grupos de permissões</div>
            <div class="tab-item">Permissões</div>
        </div>
        <div class="tab-content">
            <div class="tab-body">GRUPOS DE PERMISSÕES</div>
            <div class="tab-body">PERMISSÕES</div>
        </div>
    </div>
</div>
<?php $this->loadView('footer'); ?>
