@include('emails.template.mail_header')
<tr>
    <td style="background:#7b68ee45;font-size:14px;font-weight:bold;padding:11px;text-align:right;direction:rtl">
        <table width="100%" cellpadding="5" cellspacing="0">
            <tr>
                <td style="width:33%; vertical-align:top;">
                    <strong>اسم المثمن العقاري:</strong><br>
                    {{ $body_data['valuator']->name ?? '-' }}
                </td>
                <td style="width:33%; vertical-align:top;">
                    <strong>رقم التواصل:</strong><br>
                    {{ $body_data['valuator']->mobile_number ?? '-' }}
                </td>
                <td style="width:33%; vertical-align:top;">
                    <strong>البريد الإلكتروني:</strong><br>
                    {{ $body_data['valuator']->email ?? '-' }}
                </td>
            </tr>
        </table>
    </td>
</tr>

<tr><td style="height:15px;"></td></tr>

{{--<tr>
    <td>
        <strong>ملاحظات التقييم:</strong><br>
        {{ $body_data['land']->valuation_notes ?? '-' }}
    </td>
</tr>--}}

<tr><td style="height:10px;"></td></tr>

<tr>
    <td>
        <strong>السعر الموافق عليه من قبل المثمن</strong><br>
        {{ isset($body_data['land']->price) ? number_format($body_data['land']->price, 0, '.', ',') : '-' }}
    </td>
</tr>

<tr><td style="height:10px;"></td></tr>

<tr>
    <td align="center" style="padding:10px">
        <p>
            <a href="{{ url('admin/login') }}" style="background-color: #3490dc; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block;">
                تسجيل الدخول إلى حسابك
            </a>
        </p>
        <p>شكراً لاستخدامك منصتنا.</p>
    </td>
</tr>

@include('emails.template.mail_footer')
