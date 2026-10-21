<?= $head ?>

    <div class="container-nueva-pass" style="max-width: 400px; margin: 90px auto; padding: 30px; background-color: white; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">

        <div style="text-align: center; margin-bottom: 25px;">
            <h2 style="color: #4a3b3c; margin: 0 0 10px 0;">Nueva Contraseña</h2>
            <p style="color: #7d6b6c; margin: 0; font-size: 14px; line-height: 1.5;">
                Código verificado con éxito. Por favor, escribí tu nueva contraseña de acceso.
            </p>
        </div>

        <form action="" method="POST">

            <!-- Campo Nueva Contraseña con Validación -->
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="password" style="display: block; font-size: 14px; color: #4a3b3c; font-weight: bold; margin-bottom: 5px;">Nueva Contraseña</label>
                <input type="password"
                       id="password"
                       name="password"
                       placeholder="Mínimo 8 caracteres, letras, números y símbolo"
                       required
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}"
                       title="La contraseña debe tener al menos 8 caracteres, incluir una mayúscula, una minúscula, un número y un carácter especial (ej: @, #, $, %, *, etc.)."
                       style="width: 100%; padding: 10px; border: 1px solid #ebd4d4; border-radius: 4px; box-sizing: border-box; font-size: 14px;">
            </div>

            <!-- Campo Repetir Nueva Contraseña con Validación -->
            <div class="form-group" style="margin-bottom: 25px;">
                <label for="confirm_password" style="display: block; font-size: 14px; color: #4a3b3c; font-weight: bold; margin-bottom: 5px;">Repetir Nueva Contraseña</label>
                <input type="password"
                       id="confirm_password"
                       name="confirm_password"
                       placeholder="Repetí tu nueva contraseña"
                       required
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}"
                       title="La contraseña debe tener al menos 8 caracteres, incluir una mayúscula, una minúscula, un número y un carácter especial (ej: @, #, $, %, *, etc.)."
                       style="width: 100%; padding: 10px; border: 1px solid #ebd4d4; border-radius: 4px; box-sizing: border-box; font-size: 14px;">
            </div>

            <!-- Botón Centrado y Estilizado -->
            <div style="text-align: center; width: 100%;">
                <button type="submit" style="width: 75%; padding: 12px; background-color: #e5989b; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 15px; font-weight: bold; display: inline-block;">
                    Guardar Nueva Contraseña
                </button>
            </div>

        </form>

    </div>

<?= $footer ?>
