<div class="h-full w-full flex-1">
    <div class="bg-muted flex flex-col items-center justify-center">
        <div class="flex w-full max-w-md flex-col">
            <div class="flex flex-col">
                <div
                    class="rounded-xl border bg-white dark:bg-slate-700 dark:border-zinc-800 dark:text-white text-stone-800 shadow-xs">
                    <div class="px-10 py-8">
                        <div class="text-center mb-5">
                            <h4 class="font-bold text-xl">
                                Verifikasi Dokumen
                            </h4>
                            <p class="text-sm text-muted">
                                Hasil verifikasi data dokumen dari {{ env('app_name') }}
                            </p>
                        </div>
                        <table class="text-sm w-full">
                            <tr>
                                <td class="py-2">Nomor Dokumen</td>
                                <td class="py-2 text-end">
                                    {{ $signature->nomor_dokumen }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2">Tanggal Dokumen</td>
                                <td class="py-2 text-end">
                                    {{ \Carbon\Carbon::parse($signature->tanggal)->translatedFormat('d F Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2">Nama Penandatangan</td>
                                <td class="py-2 text-end">
                                    {{ $signature->nama_penandatangan }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2">Keterangan</td>
                                <td class="py-2 text-end">
                                    {{ $signature->keterangan }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2">Status</td>
                                <td class="py-2 text-end">
                                    @if ($signature->status == 'valid')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Valid
                                        </span>
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Invalid
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
