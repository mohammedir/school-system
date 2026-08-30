
@include('emails.template.mail_header')
<tr>
    <td style="background:#7b68ee45;font-size:14px;font-weight:bold;padding:11px;text-align:right;direction:rtl">
        <table width="100%" cellpadding="5" cellspacing="0">
            <tr>
                <td style="width:33%; vertical-align:top;">
                    <strong>اسم صاحب الأرض:</strong><br>
                    {{ $body_data['land']->investor->full_name ?? '-' }}
                </td>
                <td style="width:33%; vertical-align:top;">
                    <strong>رقم التواصل:</strong><br>
                    {{ $body_data['land']->investor->mobile ?? '-' }}
                </td>
                <td style="width:33%; vertical-align:top;">
                    <strong>البريد الإلكتروني:</strong><br>
                    {{ $body_data['land']->investor->email ?? '-' }}
                </td>
            </tr>
        </table>
    </td>
</tr>

<tr><td style="height:15px;"></td></tr>

<tr><td style="height:10px;"></td></tr>

<tr>
    <td>
        <strong> لقد تم اضافة ارض جديدة وتحتاج الى تقييم من قبلكم يرجى الذهاب الي المنصة والاطلاع على الاراضي وتقييم الارض السعر المطلوب موضح</strong><br>
        {{ $body_data['land']->price ?? '-' }}
    </td>
</tr>

<tr><td style="height:10px;"></td></tr>

<tr>
    <td align="center" style="padding:10px">
        <p>شكراً لاستخدامك منصتنا.</p>
    </td>
</tr>

@include('emails.template.mail_footer')
