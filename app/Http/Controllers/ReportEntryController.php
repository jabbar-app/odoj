<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Report;
use App\Models\ReportEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ReportEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Report $report)
    {
        $entries = ReportEntry::where('report_id', $report->id)->get();

        return view('entries.index', compact('entries', 'report'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search()
    {
        $reports = Report::all();
        return view('entries.search', compact('reports'));
    }

    public function find(Request $request)
    {
        $report = Report::findOrFail($request->report_id);
        return redirect()->route('entries.create', $report);
    }

    public function create(Report $report)
    {
        return view('entries.create', compact('report'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Report $report)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'recite_amount' => 'nullable|string|max:255',
            'juz' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        // Simpan data report entry
        $entry = ReportEntry::create([
            'report_id' => $report->id,
            'name' => $request->name,
            'recite_amount' => $request->recite_amount,
            'juz' => $request->juz,
            'status' => $request->status,
        ]);

        try {
            // Ambil data members dari group
            $members = $report->group->member ?? [];

            // Ambil semua report entries untuk report ini
            $entries = $report->entries;

            // Buat pesan dinamis
            $message = "بِسْـــــــــــــمِ اللَّهِ الرَّحْمَنِ الرَّحِيـــــــــــــمِ\n\n";
            $message .= "          ┏━🎑🏞🌆━━━━━━━━━┓\n";
            $message .= "                       — daily report —\n";
            $message .= "        ✨GENCARKAN RAMADAN✨\n";
            $message .= "          ┗━━━━━━━━━🎑🏞🌆━┛\n\n";
            $message .= "> 🗓Day, date: " . Carbon::parse($report->report_date)->translatedFormat('l, d F Y') . "\n";
            $message .= "> ⏳Periode: " . Carbon::parse($report->report_date)->translatedFormat('d') . " Ramadan 1446 H\n\n";
            $message .= "🤴🏻PJ ODOJ: " . $report->pj_odoj . "\n";
            $message .= "🥷PJ Bersaksi: " . $report->pj_bersaksi . "\n";
            $message .= "♻PJ Next Day: " . $report->pj_nextday . "\n\n";
            $message .= "Link Pengisian Laporan :\n";
            $message .= "https://odoj.generasicakrawala.com/laporan/\n\n";
            $message .= "🔥SANTRI CAKRAWALA🔥:\n";

            // Loop melalui members dan tambahkan ke pesan
            foreach ($members as $index => $member) {
                // Cari entry untuk member ini
                $entry = $entries->firstWhere('name', $member['name']);

                // Jika entry ditemukan, ambil Juz dan status
                if ($entry) {
                    // Konversi Juz ke emoji angka
                    $juz = match ($entry->juz) {
                        'Juz 1' => '0️⃣1️⃣',
                        'Juz 2' => '0️⃣2️⃣',
                        'Juz 3' => '0️⃣3️⃣',
                        'Juz 4' => '0️⃣4️⃣',
                        'Juz 5' => '0️⃣5️⃣',
                        'Juz 6' => '0️⃣6️⃣',
                        'Juz 7' => '0️⃣7️⃣',
                        'Juz 8' => '0️⃣8️⃣',
                        'Juz 9' => '0️⃣9️⃣',
                        'Juz 10' => '1️⃣0️⃣',
                        'Juz 11' => '1️⃣1️⃣',
                        'Juz 12' => '1️⃣2️⃣',
                        'Juz 13' => '1️⃣3️⃣',
                        'Juz 14' => '1️⃣4️⃣',
                        'Juz 15' => '1️⃣5️⃣',
                        'Juz 16' => '1️⃣6️⃣',
                        'Juz 17' => '1️⃣7️⃣',
                        'Juz 18' => '1️⃣8️⃣',
                        'Juz 19' => '1️⃣9️⃣',
                        'Juz 20' => '2️⃣0️⃣',
                        'Juz 21' => '2️⃣1️⃣',
                        'Juz 22' => '2️⃣2️⃣',
                        'Juz 23' => '2️⃣3️⃣',
                        'Juz 24' => '2️⃣4️⃣',
                        'Juz 25' => '2️⃣5️⃣',
                        'Juz 26' => '2️⃣6️⃣',
                        'Juz 27' => '2️⃣7️⃣',
                        'Juz 28' => '2️⃣8️⃣',
                        'Juz 29' => '2️⃣9️⃣',
                        'Juz 30' => '3️⃣0️⃣',
                        default => '❌', // Default jika Juz tidak valid
                    };

                    // Ambil emoji pertama dari status (contoh: 🐏 dari "🐏 = 18:01 - 23:00 WIB")
                    $statusEmoji = mb_substr($entry->status, 0, 1); // Ambil karakter pertama
                } else {
                    // Jika entry tidak ditemukan, gunakan string kosong
                    $juz = "";
                    $statusEmoji = "";
                }

                // Tambahkan ke pesan
                $message .= ($index + 1) . ". " . $member['name'] . " = " . $juz . $statusEmoji . "\n";
            }

            $message .= "\n-> TOTAL PENYETOR= " . $entries->count() . "/" . count($members) . "\n\n";
            $message .= "Ket:\n";
            $message .= "> 🤴🏻PJ ODOJ: Membuat daily report & ingatkan santri ODOJ agar segera laporan.\n";
            $message .= "> 🥷🏻PJ Bersaksi: Mendesain ayat kesukaan dan share ke grup maks. pukul 09.00 WIB.\n";
            $message .= "> 🕚Kholas maks. pukul 23.00 WIB❗\n";
            $message .= "> Kode² kholas:\n";
            $message .= "> 🐫= 00:01 - 10:00 WIB\n";
            $message .= "> 🐄= 10:01 - 18:00 WIB\n";
            $message .= "> 🐏= 18:01 - 23:00 WIB\n";
            $message .= "> 🟡 = Tidak lapor 1×\n";
            $message .= "> 🔴 = Tidak lapor 2× berturut²\n";
            $message .= "> 🔙 = Pos karantina (3× berturut²)\n";
            $message .= "> 👑 = Khatam Alquran\n\n";
            $message .= "          •┈┈┈┈• ❀ ▫🪷▫ ❀ •┈┈┈┈•\n";

            app(WhatsappController::class)->sendNotification($message, $report->group->whatsapp_id);
        } catch (\Exception $e) {
            Log::error('WhatsApp notification failed: ' . $e->getMessage());
        }

        return redirect()->route('entries.index', $report)->with('success', 'Report created successfully! Now you can add entries for this report.');
    }

    public function check()
    {
        $group = Group::find(request('group_id'));
        $groups = Group::all();
        return view('entries.check', compact('group', 'groups'));
    }

    public function show()
    {
        // Ambil data entries berdasarkan nama
        $entries = ReportEntry::where('name', request('name'))->get();

        // Gabungkan recite_amount untuk tanggal yang sama berdasarkan report->report_date
        $groupedEntries = $entries->groupBy(function ($entry) {
            return \Carbon\Carbon::parse($entry->report->report_date)->format('Y-m-d'); // Group by report_date
        })->map(function ($group) {
            return [
                'date' => \Carbon\Carbon::parse($group->first()->report->report_date)->format('Y-m-d'), // Ambil tanggal dari report_date
                'total_recite_amount' => $group->sum('recite_amount') // Jumlahkan recite_amount
            ];
        })->values(); // Reset keys


        return view('entries.show', compact('entries', 'groupedEntries'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReportEntry $reportEntry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReportEntry $reportEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReportEntry $reportEntry)
    {
        //
    }
}
