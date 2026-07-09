@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Profil Saya</h2>

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <div class="card shadow border-secondary">
                <div class="card-header bg-dark text-white text-center fw-bold py-3">
                    FOTO PROFILE
                </div>
                <div class="card-body p-4 text-center">
                    
                    <div class="mb-4 d-flex justify-content-center align-items-center bg-secondary text-white rounded-circle mx-auto shadow-sm" style="width: 100px; height: 100px;">
                        <span style="font-size: 3rem;">👤</span>
                    </div>

                    <div class="text-start fs-6 px-2">
                        <div class="row mb-3 pb-2 border-bottom">
                            <div class="col-4 fw-bold text-muted">Nama</div>
                            <div class="col-8 fw-semibold">: {{ auth()->user()->name }}</div>
                        </div>
                        <div class="row mb-3 pb-2 border-bottom">
                            <div class="col-4 fw-bold text-muted">Email</div>
                            <div class="col-8 fw-semibold">: {{ auth()->user()->email }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 fw-bold text-muted">Role</div>
                            <div class="col-8">: 
                                <span class="badge {{ auth()->user()->role === 'admin' ? 'bg-danger' : 'bg-primary' }} text-capitalize fs-7">
                                    {{ auth()->user()->role }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </div>
    </div>
</div>
@endsection