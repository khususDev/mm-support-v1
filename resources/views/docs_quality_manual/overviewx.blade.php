<div id="overview" class="tab-content-custom active m-4">
    <div class="card-body p-2">
        @if ($data)
            <!-- Fields yang diisi dengan data yang sudah ada -->
            <div class="row p-0">
                <div class="col-6 d-flex justify-content-between p-0">
                    <div class="form-group col-8">
                        <label class="form-label" style="color: dodgerblue">No Dokumen</label>
                        <input type="text" class="form-control force-disabled" id="no_dokumen"
                            aria-describedby="defaultFormControlHelp" name="no_dokumen"
                            style="font-size: large; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif;"
                            disabled value="{{ old('no_dokumen', $data->no_document ?? '') }}" />
                    </div>
                    <div class="form-group col-4">
                        <label class="form-label" style="color: dodgerblue">Revisi</label>
                        <input type="text" class="form-control" name="no_revisi" id="no_revisi"
                            aria-describedby="defaultFormControlHelp"
                            style="font-size: large; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif;"
                            disabled value="{{ old('no_revisi', $data->revisi ?? '') }}" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" style="color: dodgerblue">Tanggal Berlaku</label>
                @php
                    $tanggalFormat = \Carbon\Carbon::parse($data->tanggal)->translatedFormat('l, d F Y');
                @endphp
                <input type="text" class="form-control" name="tanggal_view" id="tanggal_display"
                    aria-describedby="defaultFormControlHelp"
                    style="font-size: large; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif;"
                    value="{{ old('tanggal_view', $tanggalFormat ?? '') }}" disabled />

                <input type="hidden" name="tanggal" id="tanggal" value="{{ old('tanggal', $data->tanggal ?? '') }}">
            </div>

            <div class="form-group">
                <label for="" class="form-label" style="color: dodgerblue">Nama Dokumen</label>
                <input type="text" class="form-control" name="nama_dokumen" aria-describedby="defaultFormControlHelp"
                    style="font-size: large; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif;"
                    disabled value="{{ old('nama_dokumen', $data->nama_document ?? '') }}">
            </div>

            <div class="form-group">
                <label for="" class="form-label" style="color: dodgerblue">Nama Perusahaan</label>
                <input type="text" class="form-control" name="perusahaan" aria-describedby="defaultFormControlHelp"
                    style="font-size: large; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif;"
                    disabled value="{{ old('perusahaan', $data->perusahaan ?? '') }}">
            </div>

            <div class="form-group">
                <label for="" class="form-label" style="color: dodgerblue">Alamat</label>
                <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control"
                    style="font-size: large; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif; height: 100px;"
                    disabled>{{ old('alamat', $data->alamat ?? '') }}</textarea>
            </div>
            <div class="form-group d-flex justify-content-center">
                <button class="btn btn-primary btn-lg d-none" id="ovSimpan" type="submit">Update Data</button>
            </div>
            </form>
        @else
            <form action="{{ route('docs_qualitymanual.store') }}" method="POST">
                @csrf
                <div class="row p-0">
                    <div class="col-6 d-flex justify-content-between p-0">
                        <div class="form-group col-8">
                            <label class="form-label" style="color: dodgerblue">No Dokumen</label>
                            <input type="text" class="form-control force-disabled" id="no_dokumen"
                                aria-describedby="defaultFormControlHelp" name="no_dokumen" style="font-size: large"
                                disabled value="{{ old('no_dokumen') }}" />
                        </div>
                        <div class="form-group col-4">
                            <label class="form-label" style="color: dodgerblue">Revisi</label>
                            <input type="text" class="form-control" name="no_revisi" id="no_revisi"
                                aria-describedby="defaultFormControlHelp" style="font-size: large" disabled
                                value="{{ old('no_revisi') }}" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" style="color: dodgerblue">Tanggal Berlaku</label>
                    <!-- Ini yang ditampilkan ke user -->
                    <input type="text" class="form-control" id="tanggal_display" style="font-size: large" />

                    <!-- Ini yang dikirim ke controller -->
                    <input type="hidden" name="tanggal" id="tanggal" value="{{ old('tanggal') }}">
                </div>

                <div class="form-group">
                    <label for="" class="form-label" style="color: dodgerblue">Nama Dokumen</label>
                    <input type="text" class="form-control" name="nama_dokumen"
                        aria-describedby="defaultFormControlHelp" style="font-size: large" disabled
                        value="{{ old('nama_dokumen') }}">
                </div>

                <div class="form-group">
                    <label for="" class="form-label" style="color: dodgerblue">Nama Perusahaan</label>
                    <input type="text" class="form-control" name="perusahaan"
                        aria-describedby="defaultFormControlHelp" style="font-size: large; font-weight: bold;"
                        disabled value="{{ old('perusahaan') }}">
                </div>

                <div class="form-group">
                    <label for="" class="form-label" style="color: dodgerblue">Alamat</label>
                    <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control"
                        style="height: 100px; font-size: large;" disabled>{{ old('alamat') }}</textarea>
                </div>
        @endif

    </div>
</div>
