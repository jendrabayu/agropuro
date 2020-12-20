<?php

return [
    /*
    |---------------------------------------------------------------------------------------
    | Baris Bahasa untuk Validasi
    |---------------------------------------------------------------------------------------
    |
    | Baris bahasa berikut ini berisi standar pesan kesalahan yang digunakan oleh
    | kelas validasi. Beberapa aturan mempunyai banyak versi seperti aturan 'size'.
    | Jangan ragu untuk mengoptimalkan setiap pesan yang ada di sini.
    |
    */

    'accepted'             => ':Attribute harus diterima.',
    'active_url'           => ':Attribute bukan URL yang valid.',
    'after'                => ':Attribute harus berisi tanggal setelah :date.',
    'after_or_equal'       => ':Attribute harus berisi tanggal setelah atau sama dengan :date.',
    'alpha'                => ':Attribute hanya boleh berisi huruf.',
    'alpha_dash'           => ':Attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num'            => ':Attribute hanya boleh berisi huruf dan angka.',
    'array'                => ':Attribute harus berisi sebuah array.',
    'before'               => ':Attribute harus berisi tanggal sebelum :date.',
    'before_or_equal'      => ':Attribute harus berisi tanggal sebelum atau sama dengan :date.',
    'between'              => [
        'numeric' => ':Attribute harus bernilai antara :min sampai :max.',
        'file'    => ':Attribute harus berukuran antara :min sampai :max kilobita.',
        'string'  => ':Attribute harus berisi antara :min sampai :max karakter.',
        'array'   => ':Attribute harus memiliki :min sampai :max anggota.',
    ],
    'boolean'              => ':Attribute harus bernilai true atau false',
    'confirmed'            => 'Konfirmasi :attribute tidak cocok.',
    'date'                 => ':Attribute bukan tanggal yang valid.',
    'date_equals'          => ':Attribute harus berisi tanggal yang sama dengan :date.',
    'date_format'          => ':Attribute tidak cocok dengan format :format.',
    'different'            => ':Attribute dan :other harus berbeda.',
    'digits'               => ':Attribute harus terdiri dari :digits angka.',
    'digits_between'       => ':Attribute harus terdiri dari :min sampai :max angka.',
    'dimensions'           => ':Attribute tidak memiliki dimensi gambar yang valid.',
    'distinct'             => ':Attribute memiliki nilai yang duplikat.',
    'email'                => ':Attribute harus berupa alamat surel yang valid.',
    'ends_with'            => ':Attribute harus diakhiri salah satu dari berikut: :values',
    'exists'               => ':Attribute yang dipilih tidak valid.',
    'file'                 => ':Attribute harus berupa sebuah berkas.',
    'filled'               => ':Attribute harus memiliki nilai.',
    'gt'                   => [
        'numeric' => ':Attribute harus bernilai lebih besar dari :value.',
        'file'    => ':Attribute harus berukuran lebih besar dari :value kilobita.',
        'string'  => ':Attribute harus berisi lebih besar dari :value karakter.',
        'array'   => ':Attribute harus memiliki lebih dari :value anggota.',
    ],
    'gte'                  => [
        'numeric' => ':Attribute harus bernilai lebih besar dari atau sama dengan :value.',
        'file'    => ':Attribute harus berukuran lebih besar dari atau sama dengan :value kilobita.',
        'string'  => ':Attribute harus berisi lebih besar dari atau sama dengan :value karakter.',
        'array'   => ':Attribute harus terdiri dari :value anggota atau lebih.',
    ],
    'image'                => ':Attribute harus berupa gambar.',
    'in'                   => ':Attribute yang dipilih tidak valid.',
    'in_array'             => ':Attribute tidak ada di dalam :other.',
    'integer'              => ':Attribute harus berupa bilangan bulat.',
    'ip'                   => ':Attribute harus berupa alamat IP yang valid.',
    'ipv4'                 => ':Attribute harus berupa alamat IPv4 yang valid.',
    'ipv6'                 => ':Attribute harus berupa alamat IPv6 yang valid.',
    'json'                 => ':Attribute harus berupa JSON string yang valid.',
    'lt'                   => [
        'numeric' => ':Attribute harus bernilai kurang dari :value.',
        'file'    => ':Attribute harus berukuran kurang dari :value kilobita.',
        'string'  => ':Attribute harus berisi kurang dari :value karakter.',
        'array'   => ':Attribute harus memiliki kurang dari :value anggota.',
    ],
    'lte'                  => [
        'numeric' => ':Attribute harus bernilai kurang dari atau sama dengan :value.',
        'file'    => ':Attribute harus berukuran kurang dari atau sama dengan :value kilobita.',
        'string'  => ':Attribute harus berisi kurang dari atau sama dengan :value karakter.',
        'array'   => ':Attribute harus tidak lebih dari :value anggota.',
    ],
    'max'                  => [
        'numeric' => ':Attribute maksimal bernilai :max.',
        'file'    => ':Attribute maksimal berukuran :max kilobita.',
        'string'  => ':Attribute maksimal berisi :max karakter.',
        'array'   => ':Attribute maksimal terdiri dari :max anggota.',
    ],
    'mimes'                => ':Attribute harus berupa berkas berjenis: :values.',
    'mimetypes'            => ':Attribute harus berupa berkas berjenis: :values.',
    'min'                  => [
        'numeric' => ':Attribute minimal bernilai :min.',
        'file'    => ':Attribute minimal berukuran :min kilobita.',
        'string'  => ':Attribute minimal berisi :min karakter.',
        'array'   => ':Attribute minimal terdiri dari :min anggota.',
    ],
    'multiple_of'          => 'The :attribute must be a multiple of :value',
    'not_in'               => ':Attribute yang dipilih tidak valid.',
    'not_regex'            => 'Format :attribute tidak valid.',
    'numeric'              => ':Attribute harus berupa angka.',
    'password'             => 'Kata sandi salah.',
    'present'              => ':Attribute wajib ada.',
    'regex'                => 'Format :attribute tidak valid.',
    'required'             => ':Attribute wajib diisi.',
    'required_if'          => ':Attribute wajib diisi bila :other adalah :value.',
    'required_unless'      => ':Attribute wajib diisi kecuali :other memiliki nilai :values.',
    'required_with'        => ':Attribute wajib diisi bila terdapat :values.',
    'required_with_all'    => ':Attribute wajib diisi bila terdapat :values.',
    'required_without'     => ':Attribute wajib diisi bila tidak terdapat :values.',
    'required_without_all' => ':Attribute wajib diisi bila sama sekali tidak terdapat :values.',
    'same'                 => ':Attribute dan :other harus sama.',
    'size'                 => [
        'numeric' => ':Attribute harus berukuran :size.',
        'file'    => ':Attribute harus berukuran :size kilobyte.',
        'string'  => ':Attribute harus berukuran :size karakter.',
        'array'   => ':Attribute harus mengandung :size anggota.',
    ],
    'starts_with'          => ':Attribute harus diawali salah satu dari berikut: :values',
    'string'               => ':Attribute harus berupa string.',
    'timezone'             => ':Attribute harus berisi zona waktu yang valid.',
    'unique'               => ':Attribute sudah ada sebelumnya.',
    'uploaded'             => ':Attribute gagal diunggah.',
    'url'                  => 'Format :attribute tidak valid.',
    'uuid'                 => ':Attribute harus merupakan UUID yang valid.',

    /*
    |---------------------------------------------------------------------------------------
    | Baris Bahasa untuk Validasi Kustom
    |---------------------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan pesan validasi untuk atribut sesuai keinginan dengan
    | menggunakan konvensi "attribute.rule" dalam penamaan barisnya. Hal ini mempercepat
    | dalam menentukan baris bahasa kustom yang spesifik untuk aturan atribut yang diberikan.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |---------------------------------------------------------------------------------------
    | Kustom Validasi Atribut
    |---------------------------------------------------------------------------------------
    |
    | Baris bahasa berikut digunakan untuk menukar 'placeholder' atribut dengan sesuatu
    | yang lebih mudah dimengerti oleh pembaca seperti "Alamat Surel" daripada "surel" saja.
    | Hal ini membantu kita dalam membuat pesan menjadi lebih ekspresif.
    |
    */

    'attributes' => [],
];

// return [

//     /*
//     |--------------------------------------------------------------------------
//     | Validation Language Lines
//     |--------------------------------------------------------------------------
//     |
//     | The following language lines contain the default error messages used by
//     | the validator class. Some of these rules have multiple versions such
//     | as the size rules. Feel free to tweak each of these messages here.
//     |
//     */

//     'accepted' => 'The :attribute must be accepted.',
//     'active_url' => 'The :attribute is not a valid URL.',
//     'after' => 'The :attribute must be a date after :date.',
//     'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
//     'alpha' => 'The :attribute may only contain letters.',
//     'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
//     'alpha_num' => 'The :attribute may only contain letters and numbers.',
//     'array' => 'The :attribute must be an array.',
//     'before' => 'The :attribute must be a date before :date.',
//     'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
//     'between' => [
//         'numeric' => 'The :attribute must be between :min and :max.',
//         'file' => 'The :attribute must be between :min and :max kilobytes.',
//         'string' => 'The :attribute must be between :min and :max characters.',
//         'array' => 'The :attribute must have between :min and :max items.',
//     ],
//     'boolean' => 'The :attribute field must be true or false.',
//     'confirmed' => 'The :attribute confirmation does not match.',
//     'date' => 'The :attribute is not a valid date.',
//     'date_equals' => 'The :attribute must be a date equal to :date.',
//     'date_format' => 'The :attribute does not match the format :format.',
//     'different' => 'The :attribute and :other must be different.',
//     'digits' => 'The :attribute must be :digits digits.',
//     'digits_between' => 'The :attribute must be between :min and :max digits.',
//     'dimensions' => 'The :attribute has invalid image dimensions.',
//     'distinct' => 'The :attribute field has a duplicate value.',
//     'email' => 'The :attribute must be a valid email address.',
//     'ends_with' => 'The :attribute must end with one of the following: :values.',
//     'exists' => 'The selected :attribute is invalid.',
//     'file' => 'The :attribute must be a file.',
//     'filled' => 'The :attribute field must have a value.',
//     'gt' => [
//         'numeric' => 'The :attribute must be greater than :value.',
//         'file' => 'The :attribute must be greater than :value kilobytes.',
//         'string' => 'The :attribute must be greater than :value characters.',
//         'array' => 'The :attribute must have more than :value items.',
//     ],
//     'gte' => [
//         'numeric' => 'The :attribute must be greater than or equal :value.',
//         'file' => 'The :attribute must be greater than or equal :value kilobytes.',
//         'string' => 'The :attribute must be greater than or equal :value characters.',
//         'array' => 'The :attribute must have :value items or more.',
//     ],
//     'image' => 'The :attribute must be an image.',
//     'in' => 'The selected :attribute is invalid.',
//     'in_array' => 'The :attribute field does not exist in :other.',
//     'integer' => 'The :attribute must be an integer.',
//     'ip' => 'The :attribute must be a valid IP address.',
//     'ipv4' => 'The :attribute must be a valid IPv4 address.',
//     'ipv6' => 'The :attribute must be a valid IPv6 address.',
//     'json' => 'The :attribute must be a valid JSON string.',
//     'lt' => [
//         'numeric' => 'The :attribute must be less than :value.',
//         'file' => 'The :attribute must be less than :value kilobytes.',
//         'string' => 'The :attribute must be less than :value characters.',
//         'array' => 'The :attribute must have less than :value items.',
//     ],
//     'lte' => [
//         'numeric' => 'The :attribute must be less than or equal :value.',
//         'file' => 'The :attribute must be less than or equal :value kilobytes.',
//         'string' => 'The :attribute must be less than or equal :value characters.',
//         'array' => 'The :attribute must not have more than :value items.',
//     ],
//     'max' => [
//         'numeric' => 'The :attribute may not be greater than :max.',
//         'file' => 'The :attribute may not be greater than :max kilobytes.',
//         'string' => 'The :attribute may not be greater than :max characters.',
//         'array' => 'The :attribute may not have more than :max items.',
//     ],
//     'mimes' => 'The :attribute must be a file of type: :values.',
//     'mimetypes' => 'The :attribute must be a file of type: :values.',
//     'min' => [
//         'numeric' => 'The :attribute must be at least :min.',
//         'file' => 'The :attribute must be at least :min kilobytes.',
//         'string' => 'The :attribute must be at least :min characters.',
//         'array' => 'The :attribute must have at least :min items.',
//     ],
//     'not_in' => 'The selected :attribute is invalid.',
//     'not_regex' => 'The :attribute format is invalid.',
//     'numeric' => 'The :attribute must be a number.',
//     'password' => 'The password is incorrect.',
//     'present' => 'The :attribute field must be present.',
//     'regex' => 'The :attribute format is invalid.',
//     'required' => 'The :attribute field is required.',
//     'required_if' => 'The :attribute field is required when :other is :value.',
//     'required_unless' => 'The :attribute field is required unless :other is in :values.',
//     'required_with' => 'The :attribute field is required when :values is present.',
//     'required_with_all' => 'The :attribute field is required when :values are present.',
//     'required_without' => 'The :attribute field is required when :values is not present.',
//     'required_without_all' => 'The :attribute field is required when none of :values are present.',
//     'same' => 'The :attribute and :other must match.',
//     'size' => [
//         'numeric' => 'The :attribute must be :size.',
//         'file' => 'The :attribute must be :size kilobytes.',
//         'string' => 'The :attribute must be :size characters.',
//         'array' => 'The :attribute must contain :size items.',
//     ],
//     'starts_with' => 'The :attribute must start with one of the following: :values.',
//     'string' => 'The :attribute must be a string.',
//     'timezone' => 'The :attribute must be a valid zone.',
//     'unique' => 'The :attribute has already been taken.',
//     'uploaded' => 'The :attribute failed to upload.',
//     'url' => 'The :attribute format is invalid.',
//     'uuid' => 'The :attribute must be a valid UUID.',

//     /*
//     |--------------------------------------------------------------------------
//     | Custom Validation Language Lines
//     |--------------------------------------------------------------------------
//     |
//     | Here you may specify custom validation messages for attributes using the
//     | convention "attribute.rule" to name the lines. This makes it quick to
//     | specify a specific custom language line for a given attribute rule.
//     |
//     */

//     'custom' => [
//         'attribute-name' => [
//             'rule-name' => 'custom-message',
//         ],
//     ],

//     /*
//     |--------------------------------------------------------------------------
//     | Custom Validation Attributes
//     |--------------------------------------------------------------------------
//     |
//     | The following language lines are used to swap our attribute placeholder
//     | with something more reader friendly such as "E-Mail Address" instead
//     | of "email". This simply helps us make our message more expressive.
//     |
//     */

//     'attributes' => [],

// ];
