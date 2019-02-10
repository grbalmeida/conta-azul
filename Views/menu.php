<div class="left-menu">
    <div class="company-name">
        <?php echo $viewData['company_name']; ?>
    </div>
    <div class="menu-area">
        <ul>
            <li>
                <a href="<?php echo BASE_URL; ?>">
                    <i class="material-icons">home</i>
                    Home
                </a>
            </li>
            <li>
                <a href="<?php echo BASE_URL.'/permissions'; ?>">
                    <i class="material-icons">vpn_key</i>
                    Permissões
                </a>
            </li>
            <li>
                <a href="<?php echo BASE_URL.'/users'; ?>">
                    <i class="material-icons">people_outline</i>
                    Usuários
                </a>
            </li>
        </ul>
    </div>
</div>
