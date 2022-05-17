<?php

namespace App\Http\Controllers\Backend\Destination;

use App\Http\Controllers\Controller;

use App\Models\Destination;
use App\Models\AdminEtax;
use App\Models\DestinationTiket;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminEtaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->lang = "ID";
        $this->orderBy = "asc";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = DB::table('admin_etax')
            ->select(
                "admin_etax.*",
                "destination_translation.title",
                "destination_translation.slug",
                "destination_category_translation.name as category",
                "destination_category_translation.slug as code_category"
            )
            ->join('destination', 'destination.id', '=', 'admin_etax.destination_id')
            ->join('destination_category', 'destination_category.id', '=', 'destination.destination_category_id')
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->join('destination_translation', 'destination.id', '=', 'destination_translation.destination_id')
            ->where('destination_translation.language_id', $this->lang)
            ->where('destination_category_translation.language_id', $this->lang)
            ->where('admin_etax.status', "REQUEST")
            ->orderBy('admin_etax.created_at', "DESC")
            ->orderBy('destination_translation.title', $this->orderBy)
            ->orderBy('admin_etax.email', $this->orderBy)
            ->get();

        return view('backend/pages/admin-etax/pengajuan-admin', compact('admin'));
    }

    public function kelolaAdmin()
    {
        $admin = DB::table('admin_etax')
            ->select(
                "admin_etax.*",
                "destination_translation.title",
                "destination_translation.slug",
                "destination_category_translation.name as category",
                "destination_category_translation.slug as code_category"
            )
            ->join('destination', 'destination.id', '=', 'admin_etax.destination_id')
            ->join('destination_category', 'destination_category.id', '=', 'destination.destination_category_id')
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->join('destination_translation', 'destination.id', '=', 'destination_translation.destination_id')
            ->where('destination_translation.language_id', $this->lang)
            ->where('destination_category_translation.language_id', $this->lang)
            ->where('admin_etax.status', "!=", "REQUEST")
            // ->orderBy('admin_etax.created_at', "DESC")
            ->orderBy('destination_translation.title', $this->orderBy)
            ->orderBy('admin_etax.email', $this->orderBy)
            ->get();

        return view('backend/pages/admin-etax/kelola-admin', compact('admin'));
    }

    public function kelolaStatusAdmin($id, $status)
    {
        $AdminEtax = AdminEtax::findorfail($id);

        // accept untuk aktif, dan nonaktif untuk nonaktif
        $AdminEtax->status = $status;
        $AdminEtax->save();

        return redirect('admin/kelola-admin-etax');
    }

    public function deleteAdmin($id)
    {
        $adminEtax = AdminEtax::findorfail($id);

        if ($adminEtax->status != "ACCEPT") {

            $jml_admin = AdminEtax::where('email', $adminEtax->email)->count();

            if($jml_admin == 1) {
                echo 'Pengelola admin tinggal 1 Orang. Tambahkan terlebih dahulu admin lainnya ! <br><br>';

                if(isset($_SERVER['HTTP_REFERER'])) {
                    echo "<a href=".$_SERVER['HTTP_REFERER'].">Go back</a>";
                }
                die;
            } else {
                $adminEtax->delete();
            }

         } else {
            echo 'Data admin masih aktif, tidak boleh dihapus <br><br>';

            if(isset($_SERVER['HTTP_REFERER'])) {
                echo "<a href=".$_SERVER['HTTP_REFERER'].">Go back</a>";
            }
            die;
        }

        return redirect('admin/kelola-admin-etax');
    }

    public function trackingUser()
    {
        $admin = DB::table('admin_etax')
            ->select(
                "admin_etax.*",
                "destination_translation.title",
                "destination_translation.slug",
                "destination_category_translation.name as category",
                "destination_category_translation.slug as code_category"
            )
            ->join('destination', 'destination.id', '=', 'admin_etax.destination_id')
            ->join('destination_category', 'destination_category.id', '=', 'destination.destination_category_id')
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->join('destination_translation', 'destination.id', '=', 'destination_translation.destination_id')
            ->where('destination_translation.language_id', $this->lang)
            ->where('destination_category_translation.language_id', $this->lang)
            ->where('admin_etax.status', "!=", "REQUEST")
            ->orderBy('admin_etax.time_login', "DESC")
            ->get();

        return view('backend/pages/admin-etax/tracking-user', compact('admin'));
    }

    public function statusAktif($id, $status)
    {
        $AdminEtax = AdminEtax::findorfail($id);

        // accept untuk aktif, dan nonaktif untuk nonaktif
        $AdminEtax->status = $status;
        $AdminEtax->save();

        return redirect('admin/tracking-admin-etax');
    }

    public function statusLogin($id, $status)
    {
        $AdminEtax = AdminEtax::findorfail($id);

        if ($status == "LOGOUT") {
            $AdminEtax->is_login = false;
            $AdminEtax->save();
        }

        return redirect('admin/tracking-admin-etax');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdminEtax  $AdminEtax
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminEtax $adminEtax)
    {
        if ($adminEtax->status == "ACCEPT") { } else {
            $adminEtax->delete();
        }
        return redirect('admin/admin-etax');
    }

    public function status($id, $status)
    {
        $AdminEtax = AdminEtax::findorfail($id);

        if ($status == "ACCEPT") {
            $destination = Destination::findOrFail($AdminEtax->destination_id);
            // email admin belum ada
            if ($destination->email_admin == null) {
                $destination->email_admin = $AdminEtax->email;
                $destination->save();

                $AdminEtax->status = $status;
                $AdminEtax->save();
            } else if ($destination->email_admin == $AdminEtax->email) {
                $destination->email_admin = $AdminEtax->email;
                $destination->save();

                $AdminEtax->status = $status;
                $AdminEtax->save();
            }
        } else {
            $AdminEtax->status = $status;
            $AdminEtax->save();
        }

        return redirect('admin/admin-etax');
    }

    public function settingKuota()
    {
        $list_hari = array("Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu");
        $tiket = DestinationTiket::take(1)->first();
        $hari_libur = explode(",", $tiket->hari_libur);

        return view('backend/pages/admin-etax/setting-kuota', compact("tiket", "hari_libur", "list_hari"));
    }

    public function updateKuota(Request $request)
    {
        $hari_libur = implode(",", $request->hari_libur);

        DestinationTiket::query()->update(['status_kuota' => $request->status_kuota, 'limit_kuota' => $request->limit_kuota, 'hari_libur' => $hari_libur]);

        return redirect("admin/setting-kuota");
    }
}
