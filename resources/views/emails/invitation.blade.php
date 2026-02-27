<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Invitation EasyColoc</title>
</head>
<body style="margin:0; padding:0; background-color:#f3f4f6; font-family:Arial, sans-serif;">

    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:16px; padding:40px; box-shadow:0 10px 25px rgba(0,0,0,0.05);">
                    <tr>
                        <td align="center" style="padding-bottom:30px;">
                            <h2 style="margin:0; color:#4f46e5; font-size:22px;">
                                🏠 EasyColoc
                            </h2>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-bottom:15px;">
                            <h1 style="margin:0; font-size:20px; color:#111827;">
                                Invitation à rejoindre une colocation
                            </h1>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-bottom:25px; color:#6b7280; font-size:15px; line-height:1.6;">
                            Vous avez été invité à rejoindre la colocation :
                            <br>
                            <strong style="color:#4f46e5; font-size:16px;">
                                {{ $invitation->colocation->name }}
                            </strong>
                            <br><br>
                            Cette invitation expire le 
                            <strong>
                                {{ $invitation->expires_at->format('d/m/Y H:i') }}
                            </strong>.
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-bottom:30px;">
                            <a href="{{ route('invitations.show', $invitation->token) }}"
                               style="background-color:#4f46e5;
                                      color:#ffffff;
                                      text-decoration:none;
                                      padding:14px 28px;
                                      border-radius:12px;
                                      display:inline-block;
                                      font-weight:bold;
                                      font-size:15px;">
                                Voir l'invitation
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="font-size:12px; color:#9ca3af;">
                            Si vous n’êtes pas concerné par cette invitation,
                            vous pouvez ignorer cet email.
                            <br><br>
                            © {{ date('Y') }} EasyColoc
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>