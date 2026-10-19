<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - Estética</title>
</head>
<body style="background-color: #fdf5f5; font-family: sans-serif; margin: 0; padding: 0;">

    <div class="container-registro" style="max-width: 450px; margin: 60px auto; padding: 30px; background-color: white; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">

        <div style="text-align: center; margin-bottom: 25px;">
            <h2 style="color: #4a3b3c; margin: 0 0 10px 0;">Crear Cuenta</h2>
            <p style="color: #7d6b6c; margin: 0; font-size: 14px;">Registrate para empezar a agendar tus turnos.</p>
        </div>

        <form action="" method="POST">

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="nombre" style="display: block; font-size: 14px; color: #4a3b3c; font-weight: bold; margin-bottom: 5px;">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" required
                       style="width: 100%; padding: 10px; border: 1px solid #ebd4d4; border-radius: 4px; box-sizing: border-box; font-size: 14px;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="apellido" style="display: block; font-size: 14px; color: #4a3b3c; font-weight: bold; margin-bottom: 5px;">Apellido</label>
                <input type="text" id="apellido" name="apellido" placeholder="Tu apellido" required
                       style="width: 100%; padding: 10px; border: 1px solid #ebd4d4; border-radius: 4px; box-sizing: border-box; font-size: 14px;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="email" style="display: block; font-size: 14px; color: #4a3b3c; font-weight: bold; margin-bottom: 5px;">Correo Electrónico</label>
                <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required
                       style="width: 100%; padding: 10px; border: 1px solid #ebd4d4; border-radius: 4px; box-sizing: border-box; font-size: 14px;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
            <label for="password" style="display: block; font-size: 14px; color: #4a3b3c; font-weight: bold; margin-bottom: 5px;">Contraseña</label>
            <input type="password"
                id="password"
                name="password"
                placeholder="Mínimo 8 caracteres, letras, números y símbolo"
                required
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}"
                title="La contraseña debe tener al menos 8 caracteres, incluir una mayúscula, una minúscula, un número y un carácter especial (ej: @, #, $, %, *, etc.)."
                style="width: 100%; padding: 10px; border: 1px solid #ebd4d4; border-radius: 4px; box-sizing: border-box; font-size: 14px;">
            </div>

            <div class="form-group" style="margin-bottom: 25px;">
            <label for="confirm_password" style="display: block; font-size: 14px; color: #4a3b3c; font-weight: bold; margin-bottom: 5px;">Repetir Contraseña</label>
            <input type="password"
                id="confirm_password"
                name="confirm_password"
                placeholder="Repetir contraseña"
                required
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}"
                title="La contraseña debe tener al menos 8 caracteres, incluir una mayúscula, una minúscula, un número y un carácter especial (ej: @, #, $, %, *, etc.)."
                style="width: 100%; padding: 10px; border: 1px solid #ebd4d4; border-radius: 4px; box-sizing: border-box; font-size: 14px;">
            </div>

            <div class="form-group" style="margin-bottom: 25px;">
                <label for="telefono" style="display: block; font-size: 14px; color: #4a3b3c; font-weight: bold; margin-bottom: 5px;">Teléfono de Contacto</label>
                <input type="tel" id="telefono" name="telefono" placeholder="Ej: 3416123456" required
                       style="width: 100%; padding: 10px; border: 1px solid #ebd4d4; border-radius: 4px; box-sizing: border-box; font-size: 14px;">
            </div>

            <div style="text-align: center; width: 100%; margin-bottom: 10px;">
                <button type="submit" style="width: 60%; padding: 12px; background-color: #e5989b; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; display: inline-block;">
                    Registrarse
                </button>
            </div>

        </form>

        <div style="margin-top: 20px; text-align: center; border-top: 1px solid #f5ebeb; padding-top: 15px;">
            <p style="color: #7d6b6c; font-size: 14px; margin: 0;">
                ¿Ya tenés una cuenta? <a href="login.php" style="color: #e5989b; text-decoration: none; font-weight: bold;">Iniciá sesión acá</a>
            </p>
        </div>

    </div>

</body>
</html>