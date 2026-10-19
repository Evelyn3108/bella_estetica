<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Estética</title>
</head>
<body style="background-color: #fdf5f5; font-family: sans-serif; margin: 0; padding: 0;">

    <div class="container-recuperar" style="max-width: 400px; margin: 100px auto; padding: 30px; background-color: white; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        
        <div style="text-align: center; margin-bottom: 25px;">
            <h2 style="color: #4a3b3c; margin: 0 0 10px 0;">Recuperar Contraseña</h2>
            <p style="color: #7d6b6c; margin: 0; font-size: 14px; line-height: 1.5;">
                Ingresá tu correo electrónico. Te enviaremos un código de verificación para restablecer tu contraseña.
            </p>
        </div>
        
        <form action="" method="POST">
            
            <div class="form-group" style="margin-bottom: 25px;">
                <label for="email" style="display: block; font-size: 14px; color: #4a3b3c; font-weight: bold; margin-bottom: 5px;">Correo Electrónico</label>
                <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ebd4d4; border-radius: 4px; box-sizing: border-box; font-size: 14px;">
            </div>
            
            <div style="text-align: center; width: 100%;">
                <button type="submit" style="width: 65%; padding: 12px; background-color: #e5989b; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 15px; font-weight: bold; display: inline-block;">
                    Enviar Código
                </button>
            </div>
            
        </form>
        
        <div style="margin-top: 25px; text-align: center; border-top: 1px solid #f5ebeb; padding-top: 15px;">
            <a href="login.php" style="color: #b57c7e; font-size: 14px; text-decoration: none; font-weight: bold;">
                ← Volver al inicio de sesión
            </a>
        </div>
        
    </div>

</body>
</html>