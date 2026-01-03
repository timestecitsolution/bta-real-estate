@extends('dashboard.layouts.master')
@section('title', "Edit Application Subject")

@push("after-styles")
<link href="{{ asset("assets/dashboard/js/iconpicker/fontawesome-iconpicker.min.css") }}" rel="stylesheet">
@endpush

@section('content')
<div class="padding">
    <div class="box">
        <div class="box-header dker">
            <h3><i class="material-icons">&#xe3c9;</i> Edit Application Subject</h3>
            <small>
                <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                <a>Edit Application Subject</a>
            </small>
        </div>
        <div class="box-tool">
            <ul class="nav">
                <li class="nav-item inline">
                    <a class="nav-link" href="{{ route('price') }}">
                        <i class="material-icons md-18">×</i>
                    </a>
                </li>
            </ul>
        </div>

        <div class="box-body p-a-2">
            {{ Form::model($clientApplicationSubject, ['route' => ['client-application-subject.update', $clientApplicationSubject->id], 'method' => 'POST', 'files' => true, 'id'=>'clientApplicationSubjectForm']) }}

            {{-- Application Subject --}}
            <div class="form-group row">
                <label class="col-sm-2 form-control-label">Application Subject</label>
                <div class="col-sm-10">
                    {!! Form::text('subject', old('subject', $clientApplicationSubject->subject), ['id'=>'subject','class'=>'form-control']) !!}
                </div>
            </div>


            <div class="form-group row">
                <label class="col-sm-2 col-form-label">
                    Application Body
                </label>

                <div class="col-sm-10">
                    {!! Form::textarea(
                        'application_body',
                        old('application_body', $clientApplicationSubject->body),
                        [
                            'id' => 'application_body',
                            'class' => 'form-control',
                            'rows' => 6,
                            'placeholder' => 'Type your message within 250 words...'
                        ]
                    ) !!}

                    <div class="text-muted mt-1" id="wordCount">
                        0 / 250 words
                    </div>
                </div>
            </div>



            <div class="form-group row m-t-md">
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-lg btn-primary m-t">
                        <i class="material-icons">&#xe3c9;</i> Update
                    </button>
                    <a href="{{ route('price') }}" class="btn btn-lg btn-default m-t">
                        <i class="material-icons">&#xe5cd;</i> Cancel
                    </a>
                </div>
            </div>

            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection

@push("after-scripts")
<script src="{{ asset("assets/dashboard/js/iconpicker/fontawesome-iconpicker.js") }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#application_body'))
        .catch(error => {
            console.error(error);
        });
</script>
@endpush
