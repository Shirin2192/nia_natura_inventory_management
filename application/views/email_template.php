<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $subject ?? 'Nia Natura Inventory Notification' ?></title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table width="100%" bgcolor="#f4f4f4" cellpadding="0" cellspacing="0" style="padding: 30px 0;">
        <tr>
            <td>
                <table width="600" align="center" cellpadding="0" cellspacing="0" style="background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <thead style="background-color: #4CAF50; color: white;">
                        <tr>
                            <th style="padding: 20px; font-size: 26px;">
                                Nia Natura Inventory System
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 30px; font-size: 16px; color: #333;">
                                <?= $dynamic_body_content ?>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot style="background-color: #f1f1f1; text-align: center;">
                        <tr>
                            <td style="padding: 20px; font-size: 12px; color: #777;">
                                &copy; <?= date('Y') ?> Nia Natura. All rights reserved.
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
