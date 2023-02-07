@extends('layouts.app')
@section('links')
    <style>
        #parent1 {
            width:100%;
            height: 600px;
            display:inline-block;
            position:relative;
        }
        
        #editor1 {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }
    </style>

@endsection

@section('content')
    <div class="page-header">
        <div class="row justify-content-between align-items-baseline">
            <div class="col-auto">
                <h2 class="page-title text-capitalize">
                    {{ __('edit layout file') }}
                </h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-uppercase">{{ __('edit layout file') }}<span style="font-size: 12px; color: red;">&nbsp; Please, be careful!!!</span></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('update_layout') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="meta_tags" class="form-label text-capitalize required">{{ __('file contents') }}</label>
                            <div id="parent1">
                                <div id="editor1">

                                </div>
                            </div>
                            <textarea id="meta_tags" rows="10" placeholder="Meta" class="form-control @error('meta_tags') is-invalid @enderror" name="meta_tags" required>{{ old('meta_tags') ?? $fileContent }}</textarea>

                            @error('meta_tags')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary text-capitalize">
                                {{ __('update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://pagecdn.io/lib/ace/1.4.12/ace.js" crossorigin="anonymous" integrity="sha256-Q9hnBpgBFstzZOr+OKFOWZWfcF5nFXO8Qz48Nmndo6U=" ></script>

    <script>
        var editor1 = ace.edit("editor1");
        editor1.setTheme("ace/theme/dracula");
        editor1.session.setMode("ace/mode/html");
        editor1.session.setUseSoftTabs(true);
        var textarea1 = $('textarea[name="meta_tags"]').hide();
        editor1.getSession().setValue(textarea1.val());
        editor1.getSession().on('change', function(){
            textarea1.val(editor1.getSession().getValue());
        });
    </script>
@endsection
