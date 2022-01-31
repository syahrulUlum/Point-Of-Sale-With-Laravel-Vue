@extends('layouts/main')

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-header text-center bg-primary text-white">
                <h4 class="font-weight-bold">Notifikasi</h4>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    @if (count($data_notif) > 0)
                        @foreach ($data_notif as $notif)
                            <tr>
                                <td>
                                    <span class="font-weight-bold">
                                        {{ $notif->nama }}
                                    </span> tersisa
                                    <span class="text-danger">{{ $notif->stok }}
                                    </span>
                                </td>
                                <td align="right">{{ convert_date($notif->updated_at) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td align="center">Tidak Ada Notifikasi</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
@endsection
