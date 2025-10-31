<?php

namespace App\Livewire;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class SignatureTable extends PowerGridComponent
{
    public string $tableName = 'signature-table-y1s5kj-table';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return DB::table('signatures')
            ->selectRaw('signatures.*, ROW_NUMBER() OVER (ORDER BY id) as rowNumber');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('rowNumber')
            ->add('id')
            ->add('nama_penandatangan')
            ->add('tanggal_formatted', function ($data) {
                return Carbon::parse($data->tanggal)->format('d/m/Y');
            })
            ->add('nomor_dokumen')
            ->add('keterangan')
            ->add('status', function ($data) {
                if ($data->status == 'valid') {
                    return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Valid
                            </span>';
                } else {
                    return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Invalid
                            </span>';
                }
            })
            ->add('aksi', function ($row) {
                return view('livewire.signature.buttons', ['row' => $row]);
            });
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'rowNumber')
                ->sortable(),

            Column::make('Nama penandatangan', 'nama_penandatangan')
                ->sortable()
                ->searchable(),

            Column::make('Tanggal', 'tanggal_formatted', 'tanggal')
                ->sortable()
                ->searchable(),

            Column::make('Nomor dokumen', 'nomor_dokumen')
                ->sortable()
                ->searchable(),

            Column::make('Keterangan', 'keterangan')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::make('aksi', 'aksi'),
        ];
    }

    public function filters(): array
    {
        return [];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
