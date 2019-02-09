<?php $this->loadView('header', [
    'title' => $title,
    'styles' => [BASE_URL.'/assets/css/login.css']
]); ?>
    <div class="login-area">
        <form method="POST">
            <input type="email" name="email" placeholder="E-mail" />
            <input type="password" name="password" placeholder="Senha" />
            <input type="submit" value="Entrar" />

            <?php if (isset($error) && !empty($error)): ?>
                <div class="error">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
<?php $this->loadView('footer', []); ?>
