@extends('layout.app')
@section('title', 'Khut::Visotor')

@section('content')

    <div class="page-header">
        <h3 class="page-title"> Site Visitors </h3>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>SL</th>
                                    <th>ID</th>
                                    <th>IP Address</th>
                                    <th>Visit Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($visitors as $index => $visitorData)
                                    <tr>
                                        <td>{{ ($visitors->currentPage() - 1) * $visitors->perPage() + $loop->iteration }}</td>
                                        <td>{{ $visitorData->id }}</td>
                                        <td>{{ $visitorData->ip_address }}</td>
                                        <td>{{ \Carbon\Carbon::parse($visitorData->visit_time)->format('d M, Y h:i A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                       
                            {{-- Pagination Links --}}
                            <div  class="mt-3 align-items-center">
                                {{ $visitors->links() }}
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection      