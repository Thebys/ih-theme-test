<?php
/**
 * HTML e-mail template used for the form submission confirmations.
 *
 * This template is called from lib/gravity-forms/autoreply-template.php
 */

/** @var $notificationLocation string Location that was selected in the form */
/** @var $notificationSubject string Subject configured inside GF e-mail notification */
/** @var $notificationContent string E-mail content configured inside GF e-mail notification */

$location = ImpactHubLocation::getD10();
if($notificationLocation === 'k10')
	$location = ImpactHubLocation::getK10();
$photo = $location->emailBanner;

function email_theme_icon($name) {
    return get_template_directory_uri() . sprintf('/assets/img/icons/email-%s.png', $name);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<!--[if !mso]><!-->
	<meta http-equiv="x-ua-compatible" content="IE=edge">
	<!--<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>﻿<?= $notificationSubject ?></title>
</head>
<body style="padding: 0;font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;font-size: 14px;line-height: 1.42857143;color: #444444;background-color: #f3f3f3;margin: 0 !important;">
<center class="wrapper" style="width: 100%;table-layout: fixed;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;background-color: #f3f3f3;">
	<div id="header" class="clearfix" style="background-color: rgb(129,129,129);color: white;width: 100%;">
		<table width="100%" style="display: block;border-collapse: collapse;vertical-align: top;font-size: 0;background-color: rgb(129,129,129);color: white;width: 100%;">
			<tbody style="display: block;">
			<tr style="text-align: center;display: block;">
				<td style="padding: 0;display: block;text-align: center;">
                <span style="display:none !important; mso-hide:all; max-height:0; max-width:0; opacity:0; overflow:hidden;">
                  <?= $notificationContent ?>
                </span>
				</td>
			</tr>
			<tr style="text-align: center;display: block;">
				<td class="text-center" style="padding: 0;display: block;text-align: center;">
					<!--[if (gte mso 9)|(IE)]>
					<table width="100%" style="border-collapse:collapse;">
						<tr>
							<td width="50%" valign="top">
					<![endif]-->
					<table class="column" style="display: inline-block;border-collapse: collapse;vertical-align: top;font-size: 0;width: 49.6%;background-color: rgb(129,129,129);color: white;min-width: 300px;">
						<tbody style="display: block;">
						<tr style="text-align: center;display: block;">
							<td class="px-15 logo" style="padding: 0 15px;display: block;">
								<table class="mt-10" style="display: block;border-collapse: collapse;vertical-align: top;font-size: 0;background-color: rgb(129,129,129);color: white;width: 100%;">
									<tr style="text-align: center;display: block;">
										<td style="padding: 0;display: block;width: 100%;line-height: 10px;font-size: 0;">.</td>
									</tr>
								</table>
								<a href="<?= get_home_url(); ?>" style="color: #fff;text-decoration: underline;font-size: 12px;"><img src="<?= get_template_directory_uri() . '/assets/img/email-logo.png' ?>" height="60" alt="Logo Impact Hub" style="margin: 0 auto 0 0;padding: 0;max-width: 100%;display: block;-ms-interpolation-mode: bicubic;height: 60px;"></a>
								<table class="mt-10" style="display: block;border-collapse: collapse;vertical-align: top;font-size: 0;background-color: rgb(129,129,129);color: white;width: 100%;">
									<tr style="text-align: center;display: block;">
										<td style="padding: 0;display: block;width: 100%;line-height: 10px;font-size: 0;">.</td>
									</tr>
								</table>
							</td>
						</tr>
						</tbody>
					</table>
					<!--[if (gte mso 9)|(IE)]>
					</td>
					<td width="50%" valign="top">
					<![endif]-->
					<table class="column" style="display: inline-block;border-collapse: collapse;vertical-align: top;font-size: 0;width: 49.6%;background-color: rgb(129,129,129);color: white;min-width: 300px;">
						<tbody style="display: block;">
						<tr style="text-align: center;display: block;">
							<td class="text-right px-15" style="padding: 0 15px;display: block;text-align: right;">
								<table class="mt-20" style="display: block;border-collapse: collapse;vertical-align: top;font-size: 0;background-color: rgb(129,129,129);color: white;width: 100%;">
									<tr style="text-align: center;display: block;">
										<td style="padding: 0;display: block;width: 100%;line-height: 20px;font-size: 0;">.</td>
									</tr>
								</table>
								<table class="mt-5" style="display: block;border-collapse: collapse;vertical-align: top;font-size: 0;background-color: rgb(129,129,129);color: white;width: 100%;">
									<tr style="text-align: center;display: block;">
										<td style="padding: 0;display: block;width: 100%;line-height: 5px;font-size: 0;">.</td>
									</tr>
								</table>
								<p class="intro-text text-right" style="font-size: 12px;margin: 0;padding: 0;text-align: right;color: #fff;">
                          <span style="font-size: 14px;">
                            <a href="https://www.facebook.com/impacthubpraha/" style="color: #fff;text-decoration: underline;font-size: 12px;"><img src="<?= email_theme_icon('facebook') ?>" width="30" height="30" style="margin: 0 auto;padding: 0;max-width: 100%;display: inline-block;-ms-interpolation-mode: bicubic;margin-right: 10px;height: 30px;" alt=""></a>
                            <a href="https://instagram.com/impacthubprague" style="color: #fff;text-decoration: underline;font-size: 12px;"><img src="<?= email_theme_icon('instagram') ?>" width="30" height="30" style="margin: 0 auto;padding: 0;max-width: 100%;display: inline-block;-ms-interpolation-mode: bicubic;margin-right: 10px;height: 30px;" alt=""></a>
                            <a href="https://slideslive.com/impact-hub-praha" style="color: #fff;text-decoration: underline;font-size: 12px;"><img src="<?= email_theme_icon('slideslive') ?>" width="30" height="30" style="margin: 0 auto;padding: 0;max-width: 100%;display: inline-block;-ms-interpolation-mode: bicubic;margin-right: 10px;height: 30px;" alt=""></a>
                            <a href="https://cz.linkedin.com/company/hub-praha" style="color: #fff;text-decoration: underline;font-size: 12px;"><img src="<?= email_theme_icon('linkedin') ?>" width="30" height="30" style="margin: 0 auto;padding: 0;max-width: 100%;display: inline-block;-ms-interpolation-mode: bicubic;margin-right: 10px;height: 30px;" alt=""></a>
                            <a href="https://www.hubpraha.cz" style="color: #fff;text-decoration: underline;font-size: 12px;"><img src="<?= email_theme_icon('website') ?>" width="30" height="30" style="margin: 0 auto;padding: 0;max-width: 100%;display: inline-block;-ms-interpolation-mode: bicubic;margin-right: 10px;height: 30px;" alt=""></a>
                          </span>
								</p>
							</td>
						</tr>
						</tbody>
					</table>
					<!--[if (gte mso 9)|(IE)]>
					</td>
					</tr>
					</table>
					<![endif]-->
				</td>
			</tr>
			</tbody>
		</table>
	</div>
	<div class="webkit" style="max-width: 651px;">
		<table class="outer" cellpadding="0" cellspacing="0" align="center" style="display: block;border-collapse: collapse;vertical-align: top;font-size: 0;margin: 0 auto;width: 100%;max-width: 651px;">
			<tbody style="display: block;">
			<tr style="text-align: center;display: block;">
				<td id="content" style="padding: 0;display: block;">
					<table class="mt-20" style="border: none;display: block;border-collapse: collapse;vertical-align: top;font-size: 0;width: 100%;">
						<tr style="text-align: center;display: block;">
							<td style="padding: 0;display: block;width: 100%;line-height: 20px;font-size: 0;">.</td>
						</tr>
					</table>
					<table class="story" width="100%" style="display: block;border-collapse: collapse;vertical-align: top;font-size: 0;width: 100%;">
						<tbody style="display: block;">
						<tr class="one-column" style="text-align: center;display: block;">
							<td class="section" style="padding: 0;display: block;background-color: #fff;border: 1px solid #dddddd;box-shadow: 0 1px 1px rgba(0,0,0,0.05);">
								<img src="<?= $photo ?>" alt="Impact Hub" style="margin: 0 auto;padding: 0;max-width: 100%;display: block;-ms-interpolation-mode: bicubic;">
								<table style="display: block;border-collapse: collapse;vertical-align: top;font-size: 0;background-color: #fff;">
									<tbody style="display: block;">
									<tr style="text-align: center;display: block;">
										<td class="text-center section_content" style="padding: 20px;display: block;font-size: 14px;text-align: center;">
											<h2 class="text-center" style="margin: 0;padding: 0;font-size: 24px;text-align: center;"><?= $notificationSubject ?></h2>
											<table class="mt-20" style="display: block;border-collapse: collapse;vertical-align: top;font-size: 0;background-color: #fff;">
												<tr style="text-align: center;display: block;">
													<td style="padding: 0;display: block;width: 100%;line-height: 20px;font-size: 0;">.</td>
												</tr>
											</table>
											<?= $notificationContent ?>
										</td>
									</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr style="text-align: center;display: block;">
							<td style="padding: 0;display: block;">
								<table class="mt-20" style="display: block;border-collapse: collapse;vertical-align: top;font-size: 0;">
									<tr style="text-align: center;display: block;">
										<td style="padding: 0;display: block;width: 100%;line-height: 20px;font-size: 0;">.</td>
									</tr>
								</table>
							</td>
						</tr>
						</tbody>
					</table>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
	<div id="footer">
		<table style="display: block;border-collapse: collapse;vertical-align: top;font-size: 0;">
			<tbody style="display: block;">
			<tr style="text-align: center;display: block;">
				<td style="padding: 0;display: block;text-align: center;font-size: 12px;color: rgb(116,116,116);">
					<p class="text-muted" style="margin: 0;padding: 0;font-size: 12px;color: rgb(116,116,116);text-align: center;">
						<strong style="text-align: center;font-size: 12px;color: rgb(116,116,116);">Impact Hub Praha</strong>
						<br>
						<a href="mailto:<?= $location->email ?>" class="text-muted" style="color: #444444;text-decoration: underline;font-size: 12px;text-align: center;"><?= $location->email ?></a>
						<br>
                        <a href="tel:<?= $location->phone ?>" class="text-muted" style="color: #444444;text-decoration: underline;font-size: 12px;text-align: center;"><?= $location->phone ?></a>
                        <br>
						<a href="https://www.hubpraha.cz/" style="color: #444444;text-decoration: underline;font-size: 12px;text-align: center;">www.hubpraha.cz</a>
					</p>
					<table class="mt-20" style="display: block;border-collapse: collapse;vertical-align: top;font-size: 12px;text-align: center;color: rgb(116,116,116);">
						<tr style="text-align: center;display: block;font-size: 12px;color: rgb(116,116,116);">
							<td style="padding: 0;display: block;width: 100%;line-height: 20px;font-size: 12px;text-align: center;color: rgb(116,116,116);">.</td>
						</tr>
					</table>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
</center>
</body>
</html>