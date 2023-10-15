@extends('admin.layout')
@section('content')
    <section class=" wrapper">
        @if (count($errors)>0)
			<div class="alert alert-danger">
				@foreach ($errors->all() as $err)
					{{ $err }}<br/>
				@endforeach
			</div>
		@endif
		@if (session('thatbai'))
			<div class="alert alert-danger">
				{{ session('thatbai') }}
			</div>
		@endif
		@if (session('thanhcong'))
			<div class="alert alert-success">
				{{ session('thanhcong') }}
			</div>
		@endif
    </section>
@endsection