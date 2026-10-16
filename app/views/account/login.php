<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Estética</title>
</head>
<body style="background-color: #fdf5f5; font-family: sans-serif; margin: 0; padding: 0;">

    <div class="container-login" style="max-width: 400px; margin: 100px auto; padding: 30px; background-color: white; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: #4a3b3c; margin: 0 0 10px 0;">¡Hola de nuevo!</h2>
            <p style="color: #7d6b6c; margin: 0; font-size: 14px;">Ingresá tus datos para gestionar tus turnos.</p>
        </div>
        
        <form action="" method="POST">
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="email" style="display: block; font-size: 14px; color: #4a3b3c; font-weight: bold; margin-bottom: 5px;">Correo Electrónico</label>
                <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ebd4d4; border-radius: 4px; box-sizing: border-box; font-size: 14px;">
            </div>
            
            <div class="form-group" style="margin-bottom: 25px;">
                <label for="password" style="display: block; font-size: 14px; color: #4a3b3c; font-weight: bold; margin-bottom: 5px;">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ebd4d4; border-radius: 4px; box-sizing: border-box; font-size: 14px;">
            </div>
            
            <div style="text-align: center; margin-bottom: 10px;">
                <button type="submit" style="width: 60%; padding: 12px; background-color: #e5989b; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold;">
                    Iniciar Sesión
                </button>
            </div>
            
        </form>
        
        <div style="text-align: center;">
            <a href="recuperar_contrasenia.php" style="color: #b57c7e; font-size: 13px; text-decoration: none; font-weight: 500; display: inline-block; margin-top: 10px;">
                ¿Olvidaste tu contraseña?
            </a>
            
            <div style="margin-top: 20px; border-top: 1px solid #f5ebeb; padding-top: 15px;">
                <p style="color: #7d6b6c; font-size: 14px; margin: 0;">
                    ¿No tenés cuenta? <a href="registro.php" style="color: #e5989b; text-decoration: none; font-weight: bold;">Registrate acá</a>
                </p>
            </div>
        </div>
        
    </div>

</body>
</html>