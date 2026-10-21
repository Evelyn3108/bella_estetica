<?= $head ?>

    <div class="container-verificar" style="max-width: 400px; margin: 100px auto; padding: 30px; background-color: white; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">

        <div style="text-align: center; margin-bottom: 25px;">
            <h2 style="color: #4a3b3c; margin: 0 0 10px 0;">Verificar Código</h2>
            <p style="color: #7d6b6c; margin: 0; font-size: 14px; line-height: 1.5;">
                Ingresá el código numérico de 6 dígitos que enviamos a tu casilla de correo.
            </p>
        </div>

        <!-- Al presionar el botón, el controlador validará y redirigirá a la siguiente vista -->
        <form action="" method="POST">

            <!-- Campo para el Código de Verificación -->
            <div class="form-group" style="margin-bottom: 30px;">
                <label for="codigo" style="display: block; font-size: 14px; color: #4a3b3c; font-weight: bold; margin-bottom: 10px; text-align: center;">Código de Seguridad</label>
                <input type="text" id="codigo" name="codigo" placeholder="000000" required autocomplete="off" maxlength="6"
                       style="width: 100%; padding: 12px; border: 1px solid #ebd4d4; border-radius: 4px; box-sizing: border-box; font-size: 22px; text-align: center; letter-spacing: 8px; font-weight: bold; color: #4a3b3c;">
            </div>

            <!-- Botón Centrado -->
            <div style="text-align: center; width: 100%;">
                <button type="submit" style="width: 65%; padding: 12px; background-color: #e5989b; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 15px; font-weight: bold; display: inline-block;">
                    Validar Código
                </button>
            </div>

        </form>

        <div style="margin-top: 25px; text-align: center; border-top: 1px solid #f5ebeb; padding-top: 15px;">
            <a href="login.php" style="color: #b57c7e; font-size: 14px; text-decoration: none; font-weight: bold;">
                ← Cancelar
            </a>
        </div>

    </div>

<?= $footer ?>
