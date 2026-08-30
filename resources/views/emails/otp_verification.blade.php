<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ App::getLocale() == 'ar' ? 'رمز التحقق' : 'Verification Code' }}</title>
</head>
<body style="font-family: 'Tahoma', sans-serif; background-color: #f9f9f9; padding: 30px;">
<div style="max-width: 600px; margin: auto; background-color: #ffffff; border: 1px solid #ddd; padding: 20px; border-radius: 8px;">

    @if(App::getLocale() == 'ar')
        {{-- Arabic Section --}}
        <div dir="rtl" style="text-align: right;">
            <h2 style="color: #2c3e50; text-align: center;">رمز التحقق من البريد الإلكتروني</h2>
            <p>مرحباً {{ $user->company_name }}،</p>
            <p>شكراً لتسجيلك في <strong>One Thousand</strong>. نحتاج لتأكيد بريدك الإلكتروني.</p>

            <p style="font-size: 16px; margin: 20px 0;">
                <strong>رمز التحقق الخاص بك هو:</strong>
            </p>

            <div style="font-size: 28px; text-align: center; font-weight: bold; color: #e74c3c; letter-spacing: 8px; margin: 10px 0;">
                {{ $otp_code }}
            </div>

            <p style="color: #555;">
                رمز التحقق صالح لمدة <strong>10 دقائق</strong> فقط.
                إذا لم تقم بطلب هذا الكود، يمكنك تجاهل هذه الرسالة.
            </p>
        </div>
    @else
        {{-- English Section --}}
        <div dir="ltr" style="text-align: left;">
            <h2 style="color: #2c3e50; text-align: center;">Email Verification Code</h2>
            <p>Hello {{ $user->company_name }},</p>
            <p>Thank you for registering with <strong>Sahami</strong>. We need to verify your email address.</p>

            <p style="font-size: 16px; margin: 20px 0;">
                <strong>Your verification code is:</strong>
            </p>

            <div style="font-size: 28px; text-align: center; font-weight: bold; color: #e74c3c; letter-spacing: 8px; margin: 10px 0;">
                {{ $otp_code }}
            </div>

            <p style="color: #555;">
                This code is valid for <strong>10 minutes</strong> only.
                If you did not request this code, you can ignore this email.
            </p>
        </div>
    @endif

    <p style="margin-top: 40px; text-align: center;">
        {{ App::getLocale() == 'ar' ? 'تحياتنا' : 'Best regards' }}<br>
        <strong>{{ App::getLocale() == 'ar' ? 'فريق One Thousand' : 'Sahami Team' }}</strong>
    </p>
</div>
</body>
</html>
