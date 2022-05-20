<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    public $loginValidate = [
		'username' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'username harus diisi',
            ],
		],
        'password' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'password harus diisi',
            ],
		],
    ];

    /**
     * Create
     * =============================
     */

    public $createBagianValidate = [
        'name' => [
            'rules'  => 'required|max_length[255]|is_unique[bagian.name]',
            'errors' => [
                'required'   => 'nama bagian harus diisi',
                'max_length' => 'maximal 255 character',
                'is_unique'  => 'nama bagian sudah terdaftar',
            ]
        ]
    ];

    public $createSubagianValidate = [
        'bagian' => [
            'rules'  => 'required|is_not_unique[bagian.name]',
            'errors' => [
                'required'      => 'nama bagian harus diisi',
                'is_not_unique' => 'nama bagian tidak terdaftar',
            ]
        ],
        'name' => [
            'rules'  => 'required|max_length[255]|is_unique[subagian.name]',
            'errors' => [
                'required'   => 'nama subagian harus diisi',
                'max_length' => 'maximal 255 character',
                'is_unique'  => 'nama subagian sudah terdaftar',
            ]
        ]
    ];

    public $createUserValidate = [
		'username' => [
            'rules'  => 'required|min_length[8]|max_length[20]|is_unique[users.username]',
            'errors' => [
                'required'    => 'username harus diisi',
                'min_length'  => 'minimal 8 character',
                'max_length'  => 'maximal 20 character',
                'is_unique'   => 'username sudah terdaftar',
            ],
		],
		'id_previlege' => [
            'rules'  => 'required|in_list[{allowedPrevilege}]',
            'errors' => [
                'required' => 'id_previlege harus diisi',
                'in_list'  => 'id_previlege tidak terdaftar',
            ],
		],
		'nik' => [
            'rules'  => 'required|max_length[20]|is_unique[user_detail.nik]|is_natural',
            'errors' => [
                'required'    => 'nik harus diisi',
                'max_length'  => 'maximal 20 character',
                'is_unique'   => 'nik sudah terdaftar',
                'is_natural'  => 'hanya boleh angka',
            ],
		],
		'nama_lengkap' => [
            'rules'  => 'required|max_length[255]',
            'errors' => [
                'required'    => 'nama lengkap harus diisi',
                'max_length'  => 'maximal 255 character',
            ],
		],
		'email' => [
            'rules'  => 'required|max_length[255]|is_unique[user_detail.email]|valid_email',
            'errors' => [
                'required'    => 'email harus diisi',
                'is_unique'   => 'email sudah terdaftar',
                'valid_email' => 'email is not in format',
                'max_length'  => 'maximal 255 character',
            ],
		],
		'agama' => [
            'rules'  => 'required|in_list[islam,protestan,katolik,budha,hindu,khonghucu]',
            'errors' => [
                'required'    => 'agama harus disi',
                'in_list'     => "nilai harus 'islam/protestan/katolik/budha/hindu/khonghucu'",
            ],
		],
        'pendidikan' => [
            'rules'  => 'required|max_length[255]',
            'errors' => [
                'required'    => 'pendidikan harus diisi',
                'max_length'  => 'maximal 255 character',
            ],
		],
        'golongan' => [
            'rules'  => 'required|in_list[asn,non-asn]',
            'errors' => [
                'required'    => 'golongan harus disi',
                'in_list'     => "nilai harus 'asn/non-asn'",
            ],
		],
        'masa_kerja' => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'   => 'masa kerja harus disi',
                'is_natural' => 'harus angka non-decimal',
            ],
		],
		'tgl_lahir' => [
            'rules'  => 'required|regex_match[/^(0[1-9]|[12][0-9]|3[01])[\-\ ](0[1-9]|1[012])[\-\ ](19|20)\d\d$/]',
            'errors' => [
                'required'    => 'tgl lahir harus diisi',
                'regex_match' => 'format must be dd-mm-yyyy',
            ],
		],
		'alamat' => [
            'rules'  => 'required|max_length[255]',
            'errors' => [
                'required'    => 'alamat harus diisi',
                'max_length'  => 'maximal 255 character',
            ],
		],
		'kelamin' => [
            'rules'  => 'required|in_list[laki-laki,perempuan]',
            'errors' => [
                'required'    => 'kelamin harus disi',
                'in_list'     => "nilai harus 'laki-laki' atau 'perempuan'",
            ],
		],
		'notelp' => [
            'rules'  => 'required|max_length[20]|is_unique[user_detail.notelp]|is_natural',
            'errors' => [
                'required'    => 'nomor telepon harus diisi',
                'max_length'  => 'maximal 20 character',
                'is_unique'   => 'no.telp sudah dipakai',
                'is_natural'  => 'hanya boleh angka',
            ],
		]
    ];

    public $createUserBagValidate = [
		'bagian' => [
            'rules'  => 'required|is_not_unique[bagian.name]',
            'errors' => [
                'required'      => 'bagian harus diisi',
                'is_not_unique' => 'bagian tidak terdaftar',
            ],
		]
    ];

    public $createUserSubagValidate = [
        'subagian' => [
            'rules'  => 'required|in_list[{allowedSubagian}]',
            'errors' => [
                'required' => 'subagian harus diisi',
                'in_list'  => 'subagian tidak terdaftar',
            ],
		],
    ];

    /**
     * Update
     * =============================
     */

    public $updateUserValidate = [
		'id' => [
            'rules'  => 'is_not_unique[users.id]',
            'errors' => [
                'is_not_unique' => 'user id ({value}) tidak terdaftar',
            ],
		],
		'username' => [
            'rules'  => 'required|min_length[8]|max_length[20]|is_unique[users.username,users.id,{id}]',
            'errors' => [
                'required'    => 'username harus diisi',
                'min_length'  => 'minimal 8 character',
                'max_length'  => 'maximal 20 character',
                'is_unique'   => 'username sudah terdaftar',
            ],
		],
		'id_previlege' => [
            'rules'  => 'required|is_not_unique[user_type.id]',
            'errors' => [
                'required'      => 'id_previlege harus diisi',
                'is_not_unique' => 'id_previlege tidak terdaftar',
            ],
		],
		'nik' => [
            'rules'  => 'required|max_length[20]|is_unique[user_detail.nik,user_detail.user_id,{id}]|is_natural',
            'errors' => [
                'required'    => 'nik harus diisi',
                'max_length'  => 'maximal 20 character',
                'is_unique'   => 'nik sudah terdaftar',
                'is_natural'  => 'hanya boleh angka',
            ],
		],
		'nama_lengkap' => [
            'rules'  => 'required|max_length[255]',
            'errors' => [
                'required'    => 'nama lengkap harus diisi',
                'max_length'  => 'maximal 255 character',
            ],
		],
		'email' => [
            'rules'  => 'required|max_length[255]|is_unique[user_detail.email,user_detail.user_id,{id}]|valid_email',
            'errors' => [
                'required'    => 'email harus diisi',
                'is_unique'   => 'email sudah terdaftar',
                'valid_email' => 'email is not in format',
                'max_length'  => 'maximal 255 character',
            ],
		],
		'agama' => [
            'rules'  => 'required|in_list[islam,protestan,katolik,budha,hindu,khonghucu]',
            'errors' => [
                'required'    => 'agama harus disi',
                'in_list'     => "nilai harus 'islam/protestan/katolik/budha/hindu/khonghucu'",
            ],
		],
        'pendidikan' => [
            'rules'  => 'required|max_length[255]',
            'errors' => [
                'required'    => 'pendidikan harus diisi',
                'max_length'  => 'maximal 255 character',
            ],
		],
        'golongan' => [
            'rules'  => 'required|in_list[asn,non-asn]',
            'errors' => [
                'required'    => 'golongan harus disi',
                'in_list'     => "nilai harus 'asn/non-asn'",
            ],
		],
		'tgl_lahir' => [
            'rules'  => 'required|regex_match[/^(0[1-9]|[12][0-9]|3[01])[\-\ ](0[1-9]|1[012])[\-\ ](19|20)\d\d$/]',
            'errors' => [
                'required'    => 'tgl lahir harus diisi',
                'regex_match' => 'format must be dd-mm-yyyy',
            ],
		],
		'alamat' => [
            'rules'  => 'required|max_length[255]',
            'errors' => [
                'required'    => 'alamat harus diisi',
                'max_length'  => 'maximal 255 character',
            ],
		],
		'kelamin' => [
            'rules'  => 'required|in_list[laki-laki,perempuan]',
            'errors' => [
                'required'    => 'kelamin harus disi',
                'in_list'     => "nilai harus 'laki-laki' atau 'perempuan'",
            ],
		],
		'notelp' => [
            'rules'  => 'required|max_length[20]|is_unique[user_detail.notelp,user_detail.user_id,{id}]|is_natural',
            'errors' => [
                'required'    => 'nomor telepon harus diisi',
                'max_length'  => 'maximal 20 character',
                'is_unique'   => 'no.telp sudah dipakai',
                'is_natural'  => 'hanya boleh angka',
            ],
		]
    ];

    public $newPasswordValidate = [
		'new_password' => [
            'rules'  => 'min_length[8]|max_length[20]',
            'errors' => [
                'min_length'  => 'password minimal 8 character',
                'max_length'  => 'password maximal 20 character',
            ],
		],
    ];

    public $updateUserBagValidate = [
		'bagian' => [
            'rules'  => 'required|is_not_unique[bagian.name]',
            'errors' => [
                'required'      => 'bagian harus diisi',
                'is_not_unique' => 'bagian tidak terdaftar',
            ],
		]
    ];

    public $updateUserSubagValidate = [
        'subagian' => [
            'rules'  => 'required|in_list[{allowedSubagian}]',
            'errors' => [
                'required' => 'subagian harus diisi',
                'in_list'  => 'subagian tidak terdaftar di bagian anda',
            ],
		],
    ];

    public $updateProfileAdminValidate = [
		'username' => [
            'rules'  => 'required|min_length[8]|max_length[20]|is_unique[users.username,users.id,{id}]',
            'errors' => [
                'required'    => 'username harus diisi',
                'min_length'  => 'username minimal 8 character',
                'max_length'  => 'username maximal 20 character',
                'is_unique'   => 'username sudah terdaftar',
            ],
		],
    ];

    public $updateProfileValidate = [
		'username' => [
            'rules'  => 'required|min_length[8]|max_length[20]|is_unique[users.username,users.id,{id}]',
            'errors' => [
                'required'    => 'username harus diisi',
                'min_length'  => 'username minimal 8 character',
                'max_length'  => 'username maximal 20 character',
                'is_unique'   => 'username sudah terdaftar',
            ],
		],
		'nik' => [
            'rules'  => 'required|max_length[20]|is_unique[user_detail.nik,user_detail.user_id,{id}]|is_natural',
            'errors' => [
                'required'    => 'nik harus diisi',
                'max_length'  => 'nik maximal 20 character',
                'is_unique'   => 'nik sudah terdaftar',
                'is_natural'  => 'nik hanya boleh angka',
            ],
		],
		'nama_lengkap' => [
            'rules'  => 'required|max_length[255]',
            'errors' => [
                'required'    => 'nama lengkap harus diisi',
                'max_length'  => 'nama lengkap maximal 255 character',
            ],
		],
		'email' => [
            'rules'  => 'required|max_length[255]|is_unique[user_detail.email,user_detail.user_id,{id}]|valid_email',
            'errors' => [
                'required'    => 'email harus diisi',
                'is_unique'   => 'email sudah terdaftar',
                'valid_email' => 'email is not in format',
                'max_length'  => 'email maximal 255 character',
            ],
		],
		'agama' => [
            'rules'  => 'required|in_list[islam,protestan,katolik,budha,hindu,khonghucu]',
            'errors' => [
                'required'    => 'agama harus disi',
                'in_list'     => "agama harus 'islam/protestan/katolik/budha/hindu/khonghucu'",
            ],
		],
        'pendidikan' => [
            'rules'  => 'required|max_length[20]',
            'errors' => [
                'required'    => 'pendidikan harus diisi',
                'max_length'  => 'pendidikan maximal 20 character',
            ],
		],
		'tgl_lahir' => [
            'rules'  => 'required|regex_match[/^(0[1-9]|[12][0-9]|3[01])[\-\ ](0[1-9]|1[012])[\-\ ](19|20)\d\d$/]',
            'errors' => [
                'required'    => 'tgl lahir harus diisi',
                'regex_match' => 'format tgl lahir harus dd-mm-yyyy',
            ],
		],
		'alamat' => [
            'rules'  => 'required|max_length[255]',
            'errors' => [
                'required'    => 'alamat harus diisi',
                'max_length'  => 'alamat maximal 255 character',
            ],
		],
		'kelamin' => [
            'rules'  => 'required|in_list[laki-laki,perempuan]',
            'errors' => [
                'required'    => 'kelamin harus disi',
                'in_list'     => "kelamin harus 'laki-laki' atau 'perempuan'",
            ],
		],
		'notelp' => [
            'rules'  => 'required|max_length[20]|is_unique[user_detail.notelp,user_detail.user_id,{id}]|is_natural',
            'errors' => [
                'required'    => 'no.telp harus diisi',
                'max_length'  => 'no.telp maximal 20 character',
                'is_unique'   => 'no.telp sudah dipakai',
                'is_natural'  => 'no.telp hanya boleh angka',
            ],
		]
    ];

    /**
     * Delete
     * =============================
     */

    public $deleteBagianValidate = [
		'id' => [
            'rules'  => 'is_not_unique[bagian.id]',
            'errors' => [
                'is_not_unique' => 'id bagian ({value}) tidak terdaftar',
            ],
		],
    ];

    public $deleteSubagianValidate = [
		'id' => [
            'rules'  => 'is_not_unique[subagian.id]',
            'errors' => [
                'is_not_unique' => 'id subagian ({value}) tidak terdaftar',
            ],
		],
    ];

    public $deleteUserValidate = [
		'id' => [
            'rules'  => 'is_not_unique[users.id,users.id_previlege]',
            'errors' => [
                'is_not_unique' => 'user id ({value}) tidak terdaftar',
            ],
		],
    ];
}
