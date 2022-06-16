<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratKeputusanModel extends Model
{
    protected $table            = 'SK';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['no_sk','tgl_sk','file_sk'];

    public function createSk(array $data): array
    {
        try {
            $this->db->transBegin();
            
            $no_sk       = $data['no_sk'];
            $title       = $data['title'];
            $file        = $data['file_sk'];
            $typeFile    = explode('/',$file->getClientMimeType());
            $newFileName = "sk_".$data['tgl_sk']."_".$no_sk.'.'.end($typeFile);
            $file_sk     = $newFileName;

            $this->db->table("SK")->insert([
                "no_sk"   => $no_sk,
                "title"   => $title,
                "tgl_sk"  => $data['tgl_sk'],
                "file_sk" => $file_sk,
            ]);

            foreach ($data['sk_detail'] as $d) {
                $this->db->table("SK_detail")->insert([
                    "no_sk"        => $no_sk,
                    "user_id"      => $d["user_id"],
                    "id_kedudukan" => $d["id_kedudukan"],
                    "masa_kerja"   => $d["masa_kerja"],
                    "income"       => $d["income"],
                    "id_bagian"    => $d["id_bagian"],
                    "id_subagian"  => $d["id_subagian"],
                ]);

                $this->db->table("user_detail")->where("user_id",$d["user_id"])->update([
                    "id_kedudukan" => $d["id_kedudukan"],
                    "masa_kerja"   => $d["masa_kerja"],
                    "income"       => $d["income"],
                ]);

                $this->db->table("user_detail_bag")->where("user_id",$d["user_id"])->update([
                    "id_bagian" => $d["id_bagian"],
                ]);

                $this->db->table("user_detail_subag")->where("user_id",$d["user_id"])->update([
                    "id_subagian" => $d["id_subagian"],
                ]);
            }

            $transStatus = $this->db->transStatus();

            if (!$transStatus) {
                $this->db->transRollback();
            } 
            else {
                if ($file->move('file_sk/',$newFileName)) {
                    $this->db->transCommit();
                } 
                else {
                    return [
                        "error"   => true,
                        "code"    => 500,
                        "message" => "file surat keputusan gagal disimpan",
                    ];
                }
            }

            return [
                "error"   => ($transStatus) ? false : true,
                "code"    => ($transStatus) ? 201   : 500,
                "message" => ($transStatus) ? 'surat keputusan berhasil ditambah' : "surat keputusan gagal ditambah",
            ];

        } 
        catch (\Throwable $th) {
            return [
                "error"   => true,
                "code"    => 500,
                "message" => $th->getMessage(),
                "debug"   => $th->getTraceAsString()
            ];
        }
    }
}
