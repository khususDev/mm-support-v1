    <div id="data" class="tab-content-custom active m-4" style="position: relative; min-height: calc(100vh - 100px);">
        <!-- Konten form -->
        <div class="card-body p-2">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Jenis Dokumen</label>
                        <select class="form-control" name="masterdocs" id="masterdocs" onchange="changeDocs(this)">
                            <option value="" hidden>-- Pilih --</option>
                            @foreach ($mdocs as $mdocsx)
                                <option value="{{ $mdocsx->kode }}"
                                    {{ old('masterdocs') == $mdocsx->kode ? 'selected' : '' }}>
                                    {{ $mdocsx->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Departmen</label>
                        <select class="form-control" name="department" id="department" onchange="changeDept(this)">
                            <option value="" hidden>Department</option>
                            @foreach ($department as $dept)
                                <option value="{{ $dept->code }}"
                                    {{ old('department') == $dept->code ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-left: 3px">
                <div class="form-group">
                    <label class="form-label">No Dokumen</label>
                    <input type="text" class="form-control" id="valuedocs" aria-describedby="defaultFormControlHelp"
                        name="valuedocs" value="{{ old('valuedocs') }}" style="width: 100px; font-size: 14px"
                        readonly />
                    @error('name')
                        <small>{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" style="margin: 13px;"></label>
                    <input type="number" class="form-control" id="valuedocs2" aria-describedby="defaultFormControlHelp"
                        name="valuedocs2" value="{{ old('valuedocs2') }}" style="font-size: 14px; margin-left:10px;"
                        disabled />
                    @error('name')
                        <small>{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Nama Dokumen</label>
                <input type="text" class="form-control text-uppercase @error('namadocs') is-invalid @enderror"
                    id="namadocs" name="namadocs" value="{{ old('namadocs') }}"
                    oninput="this.value = this.value.toUpperCase()">
                @error('namadocs')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Deksripsi Dokumen</label>
                <textarea class="form-control" rows="5" name="deskripsi" onblur="formatProperCase(this)" id="deskripsi">{{ old('deskripsi') }}</textarea>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label">Tanggal Berlaku</label>
                        <input type="date" class="form-control" id="tanggal_berlaku" name="tanggal_berlaku"
                            value="{{ old('tanggal_berlaku') }}" />
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label">Pengecekan (/Tahun)</label>
                        <select class="form-control" id="jangka_waktu" name="jangka_waktu">
                            <option value="" disabled selected>Select
                            </option>
                            <option value="1" @selected(old('jangka_waktu') == '1')>1
                                Tahun
                            </option>
                            <option value="2" @selected(old('jangka_waktu') == '2')>2
                                Tahun
                            </option>
                            <option value="3" @selected(old('jangka_waktu') == '3')>3
                                Tahun
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label">Tanggal Pengecekan</label>
                        <input type="date" class="form-control" id="tanggal_review" name="tanggal_review"
                            value="{{ old('tanggal_review') }}" readonly />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Dokumen Label</label>
                        <select class="form-control" id="security" name="security" required>
                            <option value="" disabled selected>Pilih</option>
                            <option value="Confidential" @selected(old('security') == 'Confidential')>
                                Confidential
                            </option>
                            <option value="Internal" @selected(old('security') == 'Internal')>
                                Internal
                            </option>
                            <option value="Restricted" @selected(old('security') == 'Restricted')>
                                Restricted
                            </option>
                            <option value="Public" @selected(old('security') == 'Public')>
                                Public
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Otorisasi</label>
                        <select class="form-control" name="role" id="role">
                            <option value="Tanpa-Approval" selected="selected">
                                Tanpa Otorisasi</option>
                            @foreach ($userapprove as $userapp)
                                <option value="{{ $userapp->id }}">
                                    {{ $userapp->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer dengan posisi tetap di bawah -->
        <div class="card-footer text-end d-flex justify-content-center"
            style="position: sticky; bottom: 0; background: white; padding: 15px 0; border-top: 1px solid #eee; z-index: 10;">
            <button type="button" class="btn btn-primary next-tab" style="width: 150px; height:50px"
                data-target="files">Lanjut</button>
        </div>
        <div class="custom-input" hidden>
            <p>No Dokumen :</p>
            <div class="cst-field">
                <input type="text" id="text1" class="text1" name="text1" placeholder="_ _" required
                    readonly>
                <p>-</p>
                <input type="text" id="text2" class="text2" name="text2" placeholder="_ _" required
                    readonly>
                <p>_</p>
                <input type="text" id="text3" class="text3" name="text3" placeholder="_ _">
            </div>
        </div>
    </div>

    <script>
        document.getElementById('deskripsi').addEventListener('input', function(e) {
            const cursorPos = this.selectionStart;
            const originalValue = this.value;

            this.value = formatToProperCase(originalValue);

            // Kembalikan cursor ke posisi semula
            this.setSelectionRange(cursorPos, cursorPos);
        });

        function formatToProperCase(str) {
            return str.replace(/\w\S*/g, function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        }
    </script>
