<?php
return [
        'custom' => [
            'email' => [
                'required' => 'حقل الإيمل مطلوب',
                'email' => 'يجب أن يكون البريد الإلكتروني صحيحًا.',
                'unique' => 'الايميل موجود مسبقاً يرجى استخدام ايميل جديد',
            ],
            'password' => [
                'required' => 'حقل الباسوورد مطلوب',
            ],
            'conf_password' => [
                'required' => 'حقل تأكيد كلمة المرور مطلوب',
            ],
            'full_name' => [
                'required' => 'حقل الأسم الكامل مطلوب',
            ],
            'province_cd' => [
                'required' => 'حقل المحافظة مطلوب',
            ],
            'city_cd' => [
                'required' => 'حقل المدينة مطلوب',
            ],
            'district_cd' => [
                'required' => 'حقل الحي مطلوب',
            ],
            'mobile' => [
                'required' => 'حقل رقم الجوال مطلوب',
                'number' => 'الرجاء ادخال رقم جوال صحيح',
                'max' => 'الرجاء ادخال رقم جوال صحيح',
                'min' => 'الرجاء ادخال رقم جوال صحيح',
            ],
            'role_name' => [
                'unique' => 'أسم الدور مستخدم من قبل',
            ],
            'mobile_number' => [
                'unique' => 'رقم الجوال مستخدم من قبل',
                'required' => 'رقم الجوال مطلوب',
            ],
            'user_email' => [
                'unique' => 'الايميل موجود مسبقاً يرجى استخدام ايميل جديد',
                'required' => 'حقل الإيمل مطلوب',
            ],
            'logo' => [
                'mimes' => 'الانواع المسموحة لحقل الشعار هي jpeg,jpg,png,pdf ',
            ],
            'company_profile' => [
                'mimes' => 'الانواع المسموحة لحقل الشعار هي jpeg,jpg,png,pdf ',
            ],
            'commercial_registration' => [
                'mimes' => 'الانواع المسموحة لحقل الشعار هي jpeg,jpg,png,pdf ',
            ],
            'liecence' => [
                'mimes' => 'الانواع المسموحة لحقل الشعار هي jpeg,jpg,png,pdf ',
            ],
            'tax_record' => [
                'mimes' => 'الانواع المسموحة لحقل الشعار هي jpeg,jpg,png,pdf ',
            ],
            'previous_projects' => [
                'mimes' => 'الانواع المسموحة لحقل الشعار هي jpeg,jpg,png,pdf ',
            ],
            'permissions' => [
                'required' => 'حقل الصلاحيات مطلوب ',
            ],
            'floors.*.image' => [
                'max' => 'لا يجب أن يكون حقل floor.2.image أكبر من 1072 كيلوبايت.',
            ],

        ],
];

