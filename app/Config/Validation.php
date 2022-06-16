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

    public $userValidateBag = [
		'id_bagian' => [
            'rules'  => 'required|is_not_unique[bagian.id]',
            'errors' => [
                'required'      => 'id_bagian harus diisi',
                'is_not_unique' => 'id_bagian tidak terdaftar',
            ],
		]
    ];

    public $userValidateSubag = [
        'id_subagian' => [
            'rules'  => 'required|in_list[{allowedSubagian}]',
            'errors' => [
                'required' => 'id_subagian harus diisi',
                'in_list'  => 'id_subagian ({value}) tidak terdaftar pada bagian ini',
            ],
		],
    ];

    public $userValidateTglLahir = [
		'tgl_lahir' => [
            'rules'  => 'regex_match[/^(0[1-9]|[12][0-9]|3[01])[\-\ ](0[1-9]|1[012])[\-\ ](19|20)\d\d$/]',
            'errors' => [
                'regex_match' => 'tgl lahir harus berformat dd-mm-yyyy',
            ],
		],
    ];

    public $userValidateKelamin = [
		'kelamin' => [
            'rules'  => 'in_list[laki-laki,perempuan]',
            'errors' => [
                'in_list'     => "kelamin harus bernilai 'laki-laki' atau 'perempuan'",
            ],
		],
    ];

    public $userValidateAgama = [
		'agama' => [
            'rules'  => 'in_list[islam,protestan,katolik,budha,hindu,khonghucu]',
            'errors' => [
                'in_list'     => "agama harus bernilai 'islam/protestan/katolik/budha/hindu/khonghucu'",
            ],
		],
    ];

    public $userValidateStatus = [
        'status' => [
            'rules'  => 'in_list[active,nonactive]',
            'errors' => [
                'in_list'     => "status harus bernilai 'active' atau 'nonactive'",
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
        ],
		'description' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'deskripsi harus diisi',
            ],
		],
    ];

    public $createSubagianValidate = [
        'id_bagian' => [
            'rules'  => 'required|is_not_unique[bagian.id]',
            'errors' => [
                'required'      => 'id_bagian bagian harus diisi',
                'is_not_unique' => 'id_bagian tidak terdaftar',
            ]
        ],
        'name' => [
            'rules'  => 'required|max_length[255]|is_unique[subagian.name]',
            'errors' => [
                'required'   => 'nama subagian harus diisi',
                'max_length' => 'maximal 255 character',
                'is_unique'  => 'nama subagian sudah terdaftar',
            ]
        ],
		'description' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'deskripsi harus diisi',
            ],
		],
    ];

    public $createKedudukanValidate = [
        'name' => [
            'rules'  => 'required|max_length[255]|is_unique[kedudukan.name]',
            'errors' => [
                'required'   => 'nama kedudukan harus diisi',
                'max_length' => 'maximal 255 character',
                'is_unique'  => 'nama kedudukan sudah terdaftar',
            ]
        ],
    ];

    public $createUserValidate = [
		'username' => [
            'rules'  => 'required|min_length[8]|max_length[20]|is_unique[users.username]',
            'errors' => [
                'required'    => 'username harus diisi',
                'min_length'  => 'username minimal 8 character',
                'max_length'  => 'username maximal 20 character',
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
    ];

    public $createUserValidateDetail = [
		'nik' => [
            'rules'  => 'required|max_length[20]|is_unique[user_detail.nik]|is_natural',
            'errors' => [
                'required'    => 'nik harus diisi',
                'max_length'  => 'nik maximal 20 character',
                'is_unique'   => 'nik sudah terdaftar',
                'is_natural'  => 'nik hanya boleh angka nondecimal',
            ],
		],
		'npwp' => [
            'rules'  => 'required|max_length[40]|is_unique[user_detail.npwp]',
            'errors' => [
                'required'    => 'npwp harus diisi',
                'max_length'  => 'npwp maximal 20 character',
                'is_unique'   => 'npwp sudah terdaftar',
            ],
		],
		'email' => [
            'rules'  => 'required|max_length[255]|is_unique[user_detail.email]|valid_email',
            'errors' => [
                'required'    => 'email harus diisi',
                'is_unique'   => 'email sudah terdaftar',
                'valid_email' => 'email is not in format',
                'max_length'  => 'email maximal 255 character',
            ],
		],
		'notelp' => [
            'rules'  => 'required|max_length[20]|is_unique[user_detail.notelp]|is_natural',
            'errors' => [
                'required'    => 'no.telp harus diisi',
                'max_length'  => 'no.telp maximal 20 character',
                'is_unique'   => 'no.telp sudah dipakai',
                'is_natural'  => 'no.telp hanya boleh angka nondecimal',
            ],
		],
        'id_kedudukan' => [
            'rules'  => 'required|is_not_unique[kedudukan.id]',
            'errors' => [
                'required'      => 'kedudukan harus disi',
                'is_not_unique' => 'id kedudukan ({value}) tidak terdaftar',
            ],
		],
        'masa_kerja' => [
            'rules'  => 'required|max_length[11]|is_natural',
            'errors' => [
                'required'   => 'masa kerja harus disi',
                'max_length' => 'masa kerja maximal 11 character',
                'is_natural' => 'masa kerja harus bernilai angka nondecimal',
            ],
		],
        'income' => [
            'rules'  => 'required|max_length[11]|is_natural',
            'errors' => [
                'required'   => 'income harus disi',
                'max_length' => 'income maximal 11 character',
                'is_natural' => 'income harus bernilai angka nondecimal',
            ],
		],
		'nama_lengkap' => [
            'rules'  => 'max_length[255]',
            'errors' => [
                'max_length'  => 'nama maximal 255 character',
            ],
		],
		'alamat' => [
            'rules'  => 'max_length[255]',
            'errors' => [
                'max_length'  => 'alamat maximal 255 character',
            ],
		],
        'pendidikan' => [
            'rules'  => 'max_length[255]',
            'errors' => [
                'max_length'  => 'pendidikan maximal 255 character',
            ],
		],
    ];

    public $createSkValidate = [
        'no_sk' => [
            'rules'  => 'required|max_length[255]|is_unique[SK.no_sk]',
            'errors' => [
                'required'   => 'nomor sk harus diisi',
                'max_length' => 'nomor sk maximal 255 character',
                'is_unique'  => 'nomor sk sudah terdaftar',
            ]
        ],
        'title' => [
            'rules'  => 'required|max_length[255]',
            'errors' => [
                'required'   => 'nomor sk harus diisi',
                'max_length' => 'nomor sk maximal 255 character',
            ]
        ],
		'tgl_sk' => [
            'rules'  => 'required|regex_match[/^(0[1-9]|[12][0-9]|3[01])[\-\ ](0[1-9]|1[012])[\-\ ](19|20)\d\d$/]',
            'errors' => [
                'required'    => 'tgl sk harus diisi',
                'regex_match' => 'tgl sk harus berformat dd-mm-yyyy',
            ],
		],
        'file_sk' => [
            'rules'  => 'uploaded[file_sk]|ext_in[file_sk,pdf]|max_size[file_sk,1000]',
            'errors' => [
                'uploaded' => 'file sk harus diupload',
                'ext_in'   => 'file sk harus berupa pdf',
                'max_size' => 'file sk tidak boleh lebih dari 1mb',
            ],
        ],
		'sk_detail' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'detil sk harus diisi',
            ],
		],
    ];

    public $createSkValidateDetail = [
		'user_id' => [
            'rules'  => 'required|is_not_unique[users.id]',
            'errors' => [
                'required'      => 'id user harus diisi',
                'is_not_unique' => 'user dengan id ({value}) tidak terdaftar',
            ],
		],
        'id_kedudukan' => [
            'rules'  => 'required|is_not_unique[kedudukan.id]',
            'errors' => [
                'required'      => 'kedudukan harus disi',
                'is_not_unique' => 'id kedudukan ({value}) tidak terdaftar',
            ],
		],
        'masa_kerja' => [
            'rules'  => 'required|max_length[11]|is_natural',
            'errors' => [
                'required'   => 'masa kerja harus disi',
                'max_length' => 'masa kerja maximal 11 character',
                'is_natural' => 'masa kerja harus bernilai angka nondecimal',
            ],
		],
        'income' => [
            'rules'  => 'required|max_length[11]|is_natural',
            'errors' => [
                'required'   => 'income harus disi',
                'max_length' => 'income maximal 11 character',
                'is_natural' => 'income harus bernilai angka nondecimal',
            ],
		],
    ];

    /**
     * Update
     * =============================
     */
    public $updateBagValidate = [
		'id' => [
            'rules'  => 'required|is_not_unique[bagian.id]',
            'errors' => [
                'required'      => 'nama bagian harus diisi',
                'is_not_unique' => 'id bagian ({value}) tidak terdaftar',
            ],
		],
        'name' => [
            'rules'  => 'required|max_length[255]|is_unique[bagian.name,bagian.id,{id}]',
            'errors' => [
                'required'   => 'nama bagian harus diisi',
                'max_length' => 'maximal 255 character',
                'is_unique'  => 'nama bagian sudah terdaftar',
            ]
        ],
		'description' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'deskripsi harus diisi',
            ],
		],
    ];

    public $updateSubagValidate = [
		'id' => [
            'rules'  => 'required|is_not_unique[subagian.id]',
            'errors' => [
                'required'      => 'id subagian harus diisi',
                'is_not_unique' => 'id subagian ({value}) tidak terdaftar',
            ],
		],
        'name' => [
            'rules'  => 'required|max_length[255]|is_unique[subagian.name,subagian.id,{id}]',
            'errors' => [
                'required'   => 'nama subagian harus diisi',
                'max_length' => 'maximal 255 character',
                'is_unique'  => 'nama subagian sudah terdaftar',
            ]
        ],
        'id_bagian' => [
            'rules'  => 'required|is_not_unique[bagian.id]',
            'errors' => [
                'required'      => 'id_bagian harus diisi',
                'is_not_unique' => 'id_bagian tidak terdaftar',
            ]
        ],
		'description' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'deskripsi harus diisi',
            ],
		],
    ];

    public $updateKedudukanValidate = [
		'id' => [
            'rules'  => 'required|is_not_unique[kedudukan.id]',
            'errors' => [
                'required'      => 'id kedudukan harus diisi',
                'is_not_unique' => 'id kedudukan ({value}) tidak terdaftar',
            ],
		],
        'name' => [
            'rules'  => 'required|max_length[255]|is_unique[kedudukan.name,kedudukan.id,{id}]',
            'errors' => [
                'required'   => 'nama kedudukan harus diisi',
                'max_length' => 'maximal 255 character',
                'is_unique'  => 'nama kedudukan sudah terdaftar',
            ]
        ],
    ];

    public $updateUserValidate = [
		'id' => [
            'rules'  => 'required|is_not_unique[users.id]',
            'errors' => [
                'required'      => 'id user harus diisi',
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

    public $updateUserValidateDetail = [
		'nik' => [
            'rules'  => 'required|max_length[20]|is_unique[user_detail.nik,user_detail.user_id,{id}]|is_natural',
            'errors' => [
                'required'    => 'nik harus diisi',
                'max_length'  => 'maximal 20 character',
                'is_unique'   => 'nik sudah terdaftar',
                'is_natural'  => 'hanya boleh angka',
            ],
		],
		'npwp' => [
            'rules'  => 'required|max_length[40]|is_unique[user_detail.npwp,user_detail.user_id,{id}]',
            'errors' => [
                'required'    => 'npwp harus diisi',
                'max_length'  => 'npwp maximal 20 character',
                'is_unique'   => 'npwp sudah terdaftar',
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
		'notelp' => [
            'rules'  => 'required|max_length[20]|is_unique[user_detail.notelp,user_detail.user_id,{id}]|is_natural',
            'errors' => [
                'required'    => 'nomor telepon harus diisi',
                'max_length'  => 'maximal 20 character',
                'is_unique'   => 'no.telp sudah dipakai',
                'is_natural'  => 'hanya boleh angka',
            ],
		],
        'id_kedudukan' => [
            'rules'  => 'required|is_not_unique[kedudukan.id]',
            'errors' => [
                'required'      => 'kedudukan harus disi',
                'is_not_unique' => 'id kedudukan ({value}) tidak terdaftar',
            ],
		],
        'masa_kerja' => [
            'rules'  => 'required|max_length[11]|is_natural',
            'errors' => [
                'required'   => 'masa kerja harus disi',
                'max_length' => 'masa kerja maximal 11 character',
                'is_natural' => 'masa kerja harus bernilai angka nondecimal',
            ],
		],
        'income' => [
            'rules'  => 'required|max_length[11]|is_natural',
            'errors' => [
                'required'   => 'income harus disi',
                'max_length' => 'income maximal 11 character',
                'is_natural' => 'income harus bernilai angka nondecimal',
            ],
		],
		'nama_lengkap' => [
            'rules'  => 'max_length[255]',
            'errors' => [
                'max_length'  => 'maximal 255 character',
            ],
		],
		'alamat' => [
            'rules'  => 'max_length[255]',
            'errors' => [
                'max_length'  => 'maximal 255 character',
            ],
		],
        'pendidikan' => [
            'rules'  => 'max_length[255]',
            'errors' => [
                'max_length'  => 'maximal 255 character',
            ],
		]
    ];

    public $updateProfileAsnValidate = [
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

    public $updateProfileNonAsnValidate = [
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
                'max_length'  => 'maximal 20 character',
                'is_unique'   => 'nik sudah terdaftar',
                'is_natural'  => 'hanya boleh angka',
            ],
		],
		'npwp' => [
            'rules'  => 'required|max_length[40]|is_unique[user_detail.npwp,user_detail.user_id,{id}]',
            'errors' => [
                'required'    => 'npwp harus diisi',
                'max_length'  => 'npwp maximal 20 character',
                'is_unique'   => 'npwp sudah terdaftar',
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
		'notelp' => [
            'rules'  => 'required|max_length[20]|is_unique[user_detail.notelp,user_detail.user_id,{id}]|is_natural',
            'errors' => [
                'required'    => 'nomor telepon harus diisi',
                'max_length'  => 'maximal 20 character',
                'is_unique'   => 'no.telp sudah dipakai',
                'is_natural'  => 'hanya boleh angka',
            ],
		],
		'nama_lengkap' => [
            'rules'  => 'max_length[255]',
            'errors' => [
                'max_length'  => 'maximal 255 character',
            ],
		],
		'alamat' => [
            'rules'  => 'max_length[255]',
            'errors' => [
                'max_length'  => 'maximal 255 character',
            ],
		],
        'pendidikan' => [
            'rules'  => 'max_length[255]',
            'errors' => [
                'max_length'  => 'maximal 255 character',
            ],
		]
    ];

	public $updateInformationValidate = [
		'id' => [
            'rules'  => 'required|is_not_unique[information.id]',
            'errors' => [
                'required'      => 'id harus diisi',
                'is_not_unique' => 'id ({value}) tidak ditemukan',
            ],
		],
		'visi' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'visi harus diisi',
            ],
		],
		'misi' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'misi harus diisi',
            ],
		],
		'pengumuman' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'pengumuman harus diisi',
            ],
		]
	];

	public $newLogoValidate = [
        'new_logo' => [
            'rules'  => 'max_size[new_logo,2000]|mime_in[new_logo,image/png,image/jpg,image/jpeg,image/webp]',
            'errors' => [
                'max_size' => 'ukuran maximal 2mb',
                // 'is_image' => 'your file is not image',
                'mime_in'  => 'format yang tersedia adalah (png/jpg/jpeg/webp)',
            ],
        ],
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

    public $deleteKedudukanValidate = [
		'id' => [
            'rules'  => 'is_not_unique[kedudukan.id]',
            'errors' => [
                'is_not_unique' => 'id kedudukan ({value}) tidak terdaftar',
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
