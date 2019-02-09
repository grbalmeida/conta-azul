<?php $this->loadView('header', [
    'title' => $viewData['company_name'],
    'styles' => [BASE_URL.'/assets/css/template.css']
]); ?>
<?php $this->loadView('menu', ['company_name' => $viewData['company_name']]); ?>
<div class="container">
    <?php $this->loadView('top', ['user_email' => $viewData['user_email']]); ?>
</div>
<?php $this->loadView('footer'); ?>
