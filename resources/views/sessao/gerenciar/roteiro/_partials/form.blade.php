@csrf

<input type="hidden" class="form-control" id="inputEmail4" name="nrSeqSessao[nrSequence]"
    value="{{ $sessao[0]['nrSequence'] ?? old('nrSeqSessao.nrSequence') }}">

<div class="form-row mb-4">

    <div class="form-group col-md-6">
        <label for="exampleFormControlFile1">INCLUIR PDF</label>
        <input type="file" class="form-control-file mb-5" id="exampleFormControlFile1" name="dto[docRoteiro]">

        @foreach ($roteiro as $roteiro)
            @if (isset($roteiro['docRoteiro']))
                <iframe src="{{ url('uploads/' . $roteiro['docRoteiro'] ?? old('')) }}" type="application/pdf"
                    width="100%" height="800px"></iframe>
            @endif
        @endforeach

    </div>
</div>
