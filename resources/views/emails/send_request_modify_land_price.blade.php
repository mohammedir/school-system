@include('emails.template.mail_header')

            @if($body_data['type'] == 'editPriceFormLandowner')
                <tr>
                    <td style="background:#7b68ee45;font-size:14px;font-weight:bold;padding:11px;text-align:right;direction:rtl">
                        <table width="100%" cellpadding="5" cellspacing="0">
                            <tr>
                                <td style="width:33%; vertical-align:top;">
                                    <strong>اسم صاحب الارض:</strong><br>
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


                <tr><td style="height:15px;"></td></tr>

                <tr><td style="height:10px;"></td></tr>

                <tr>
                    <td>
                        <strong>سعر التثمين:</strong><br>
                        {{ format_price_email($body_data['land']->valuation_price) }}

                    </td>
                </tr>

                <tr><td style="height:10px;"></td></tr>

                <tr>
                    <td>
                        <strong>السعر الجديد:</strong><br>
                        {{ format_price_email($body_data['land']->price) }}

                    </td>
                </tr>


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
            @else
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

                <tr>
                    <td>
                        <strong>ملاحظات التقييم:</strong><br>
                        {{ $body_data['land']->valuation_notes ?? '-' }}
                    </td>
                </tr>

                <tr><td style="height:10px;"></td></tr>

                <tr>
                    <td>
                        <strong>السعر القديم:</strong><br>
                        {{ $body_data['land']->price ?? '-' }}
                    </td>
                </tr>

                <tr><td style="height:10px;"></td></tr>

                <tr>
                    <td>
                        <strong>السعر من المثمن:</strong><br>
                        {{ $body_data['land']->valuation_price ?? '-' }}
                    </td>
                </tr>

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

            @endif


@include('emails.template.mail_footer')
