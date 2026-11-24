<?php

namespace app\librerias;

require_once __DIR__ . '/PHPMailer/Exception.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private static function configurarSMTP(): PHPMailer
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = $_ENV['SMTP_HOST'] ?? 'smtp-relay.brevo.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['SMTP_USER'] ?? '';
        $mail->Password   = $_ENV['SMTP_PASS'] ?? '';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = (int)($_ENV['SMTP_PORT'] ?? 587);
        $mail->CharSet    = 'UTF-8';
        $mail->Timeout    = 5;

        // Evita que Brevo reescriba los enlaces con sendibt2.com (rompe URLs en localhost)
        $mail->addCustomHeader('X-Mailin-Track-Clicks', '0');

        $remitente = $_ENV['SMTP_FROM'] ?? '';
        $mail->setFrom($remitente, 'Bella Estética');

        return $mail;
    }

    public static function enviarConfirmacionTurno($destinatarioEmail, $nombreCliente, $datosTurno)
    {
        try {
            $mail = self::configurarSMTP();
            $mail->addAddress($destinatarioEmail, $nombreCliente);

            $mail->isHTML(true);
          $mail->Subject = 'Confirmación de Turno - Bella Estética';

            $fechaFormateada = date('d/m/Y', strtotime($datosTurno['fecha']));
            $horaFormateada  = substr($datosTurno['hora'], 0, 5) . ' hs';
            $urlCancelar     = $datosTurno['url_perfil'];

            $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #f0ebeb; border-radius: 10px; overflow: hidden;'>
                    <div style='background-color: #a05a42; padding: 20px; text-align: center; color: #ffffff;'>
                        <h2 style='margin: 0;'>Bella Estética</h2>
                        <p style='margin: 5px 0 0; font-size: 14px;'>Tu turno ha sido confirmado</p>
                    </div>
                    <div style='padding: 25px; color: #4a3b3c; background-color: #ffffff;'>
                        <p>Hola <strong>" . htmlspecialchars($nombreCliente) . "</strong>,</p>
                        <p>Te confirmamos que reservaste un turno en nuestro centro:</p>
                        
                        <div style='background-color: #fdf5f5; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #a05a42;'>
                            <p style='margin: 5px 0;'><strong>Tratamiento:</strong> " . htmlspecialchars($datosTurno['servicio']) . "</p>
                            <p style='margin: 5px 0;'><strong>Fecha:</strong> {$fechaFormateada}</p>
                            <p style='margin: 5px 0;'><strong>Horario:</strong> {$horaFormateada}</p>
                            <p style='margin: 5px 0;'><strong>Especialista:</strong> " . htmlspecialchars($datosTurno['especialista']) . "</p>
                            <p style='margin: 5px 0;'><strong>Consultorio:</strong> " . htmlspecialchars($datosTurno['consultorio']) . "</p>
                        </div>

                        <p style='font-size: 14px; color: #4a3b3c;'>
                           Si por algún motivo no podés asistir y deseás cancelar tu turno, podés hacerlo ingresando a tu perfil desde el siguiente boton:
                        </p>

                        <div style='text-align: center; margin: 25px 0;'>
                            <a href='{$urlCancelar}' style='background-color: #a05a42; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-weight: bold; display: inline-block;'>
                                Cancelar Turno
                            </a>
                        </div>
                    </div>
                    <div style='background-color: #fbf7f7; padding: 15px; text-align: center; font-size: 12px; color: #7d6b6c;'>
                        © " . date('Y') . " Bella Estética. Belleza, cuidado y bienestar integral.
                    </div>
                </div>
            ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function enviarCodigoRecuperacion($destinatarioEmail, $nombreCliente, $codigo)
    {
        try {
            $mail = self::configurarSMTP();
            $mail->addAddress($destinatarioEmail, $nombreCliente);

            $mail->isHTML(true);
            $mail->Subject = 'Código de Recuperación - Bella Estética';

            $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 550px; margin: 0 auto; border: 1px solid #f0ebeb; border-radius: 10px; overflow: hidden;'>
                    <div style='background-color: #a05a42; padding: 20px; text-align: center; color: #ffffff;'>
                        <h2 style='margin: 0;'>Bella Estética</h2>
                        <p style='margin: 5px 0 0; font-size: 14px;'>Restablecimiento de contraseña</p>
                    </div>
                    <div style='padding: 25px; color: #4a3b3c; background-color: #ffffff; text-align: center;'>
                        <p style='text-align: left;'>Hola <strong>" . htmlspecialchars($nombreCliente) . "</strong>,</p>
                        <p style='text-align: left;'>Recibimos una solicitud para restablecer tu contraseña. Ingresá el siguiente código de verificación en la página:</p>
                        
                        <div style='background-color: #fdf5f5; border: 2px dashed #a05a42; border-radius: 8px; padding: 15px; margin: 20px auto; max-width: 220px;'>
                            <span style='font-size: 28px; font-weight: bold; letter-spacing: 6px; color: #a05a42;'>{$codigo}</span>
                        </div>

                        <p style='font-size: 13px; color: #7d6b6c; text-align: left;'>
                            Si no solicitaste este cambio, podés ignorar este mensaje. Tu contraseña actual seguirá funcionando.
                        </p>
                    </div>
                    <div style='background-color: #fbf7f7; padding: 12px; text-align: center; font-size: 12px; color: #7d6b6c;'>
                        © " . date('Y') . " Bella Estética.
                    </div>
                </div>
            ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function enviarAvisoBajaEspecialista($destinatarioEmail, $nombreCliente, $datosTurno)
    {
        try {
            $mail = self::configurarSMTP();
            $mail->addAddress($destinatarioEmail, $nombreCliente);

            $mail->isHTML(true);
            $mail->Subject = 'Aviso importante sobre tu turno - Bella Estética';

            $fechaFormateada = date('d/m/Y', strtotime($datosTurno['fecha']));
            $horaFormateada  = substr($datosTurno['hora'], 0, 5) . ' hs';
            $urlCatalogo     = $datosTurno['url_catalogo'];

            $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #f0ebeb; border-radius: 10px; overflow: hidden;'>
                    <div style='background-color: #a05a42; padding: 20px; text-align: center; color: #ffffff;'>
                        <h2 style='margin: 0;'>Bella Estética</h2>
                        <p style='margin: 5px 0 0; font-size: 14px;'>Actualización sobre tu cita programada</p>
                    </div>
                    <div style='padding: 25px; color: #4a3b3c; background-color: #ffffff;'>
                        <p>Hola <strong>" . htmlspecialchars($nombreCliente) . "</strong>,</p>
                        <p>Te informamos que la especialista <strong>" . htmlspecialchars($datosTurno['especialista']) . "</strong> no se encontrará disponible próximamente, por lo que tu turno ha sido <strong>cancelado automáticamente</strong>:</p>
                        
                        <div style='background-color: #fdf5f5; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #dc3545;'>
                            <p style='margin: 5px 0;'><strong>Tratamiento:</strong> " . htmlspecialchars($datosTurno['servicio']) . "</p>
                            <p style='margin: 5px 0;'><strong>Fecha:</strong> {$fechaFormateada}</p>
                            <p style='margin: 5px 0;'><strong>Horario:</strong> {$horaFormateada}</p>
                        </div>

                        <p style='font-size: 14px; color: #4a3b3c;'>
                            No es necesario que asistas en esa fecha. Si deseás <strong>reagendar tu turno con otro profesional</strong> de nuestro equipo, podés hacerlo ingresando directamente a nuestro catálogo:
                        </p>

                        <div style='text-align: center; margin: 25px 0;'>
                            <a href='{$urlCatalogo}' style='background-color: #a05a42; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-weight: bold; display: inline-block;'>
                                Reagendar
                            </a>
                        </div>

                        <p style='font-size: 13px; color: #7d6b6c;'>
                         Pedimos disculpas por las molestias ocasionadas.
                        </p>
                    </div>
                    <div style='background-color: #fbf7f7; padding: 15px; text-align: center; font-size: 12px; color: #7d6b6c;'>
                        © " . date('Y') . " Bella Estética. Belleza, cuidado y bienestar integral.
                    </div>
                </div>
            ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}