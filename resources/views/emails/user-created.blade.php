<!DOCTYPE html>
<html>
<head>
    <title>Bienvenue sur notre plateforme</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table style="width: 100%; max-width: 600px; margin: 20px auto; background-color: #ffffff; border: 1px solid #dddddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <thead>
            <tr>
                <th style="background-color: #FF7A00; color: #ffffff; padding: 20px; border-top-left-radius: 8px; border-top-right-radius: 8px; text-align: center; font-size: 24px;">
                    Bienvenue sur notre plateforme !
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 20px; color: #333333; font-size: 16px;">
                    <h1 style="text-align: center; font-size: 28px;  margin-bottom: 10px;">
                        Bonjour {{ $user->prenom }} {{ $user->nom }} !
                    </h1>
                    <p style="text-align: center; font-size: 16px; margin-bottom: 20px;">
                        Votre compte a été créé avec succès sur notre plateforme.
                    </p>
                    <p style="margin-bottom: 10px;">Voici vos informations de connexion :</p>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 10px;">
                            <strong>Email :</strong> {{ $user->email }}
                        </li>
                        <li style="margin-bottom: 10px;">
                            <strong>Mot de passe temporaire :</strong> {{ $defaultPassword }}
                        </li>
                    </ul>
                    <p style="text-align: center; margin: 30px 0;">
                        <a href="{{ $loginUrl }}" style="display: inline-block; text-decoration: none; background-color: #FF7A00; color: #ffffff; padding: 12px 20px; border-radius: 5px; font-size: 16px;">
                            Se connecter
                        </a>
                    </p>
                    <p style="margin-bottom: 20px;">
                        Lors de votre première connexion, vous serez invité à changer votre mot de passe pour des raisons de sécurité.
                    </p>
                    <p style="color: #555555; font-size: 14px; text-align: center;">
                        Merci,<br>
                        <strong>L'équipe DITI, OFMS, SONATEL, ORANGE</strong>
                    </p>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td style="background-color: #f4f4f4; color: #888888; font-size: 12px; text-align: center; padding: 10px; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                    © {{ date('Y') }} OFMS, SONATEL. Tous droits réservés.
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
