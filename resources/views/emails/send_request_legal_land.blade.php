@include('emails.template.mail_header')
<tr>
    <td>
        <table width="100%" cellpadding="5" cellspacing="0">
            <tr>
                <td style="width:33%; vertical-align:top;">
                    <strong>اسم الشريك القانوني:</strong><br>
                    {{ $body_data['Legal_partner']->name ?? '-' }}
                </td>
                <td style="width:33%; vertical-align:top;">
                    <strong>رقم التواصل:</strong><br>
                    {{ $body_data['Legal_partner']->mobile_number ?? '-' }}
                </td>
                <td style="width:33%; vertical-align:top;">
                    <strong>البريد الإلكتروني:</strong><br>
                    {{ $body_data['Legal_partner']->email ?? '-' }}
                </td>
            </tr>
        </table>
    </td>
</tr>

<tr><td style="height:15px;"></td></tr>
@if($body_data['legal_action_type'] == 'approved')
    <tr>
        <td>
            <strong>ملاحظات اعتماد ملكية الأرض :</strong><br>
            {{ $body_data['land']->legal_notes ?? '-' }}
        </td>
    </tr>
@else
    <tr>
        <td>
            <strong>ملاحظات رفض اعتماد ملكية الأرض :</strong><br>
            {{ $body_data['land']->legal_decline_reasons ?? '-' }}
        </td>
    </tr>
@endif



<tr><td style="height:20px;"></td></tr>

@include('emails.template.mail_footer')
