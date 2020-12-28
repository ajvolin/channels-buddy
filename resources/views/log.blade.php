@extends('layouts.main')
<style>
    .log-display {
        background-color: #f5f5f5;
        border: 1px solid #ccc;
    }
</style>
@section('fluid-content')
<div class="row mb-3">
    <div class="col-12">
        <h1>Application Log</h1>
        <pre class="log-display overflow-auto text-wrap p-2 d-flex flex-column-reverse h-75 rounded">{{ $log }}</pre>
    </div>
</div>
@endsection