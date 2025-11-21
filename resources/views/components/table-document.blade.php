<table class="table table-striped" id="documentTable">
    <thead>
        <button>New Upload</button>
        <tr>
            <th>No</th>
            <th>Categories</th>
            <th>No Document</th>
            <th>Nama Document</th>
            <th>Berlaku</th>
            <th>Status</th>
            <th>Verified</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($documents as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->jenisDocument->name }}</td>
                <td>{{ $item->nodocument }}</td>
                <td>{{ $item->namadocument }}</td>
                <td>{{ $item->tanggal_berlaku }}</td>
                <td>{{ $item->status->name }}</td>
                <td>{{ $item->verified }}</td>
                <td>
                    <form action="{{ route('mmqa.destroy', $item->id) }}" method="POST" id="delt{{ $item->id }}">
                        <a href="#" data-id="{{ Crypt::encryptString($item->nodocument) }}"
                            class="btn btn-warning view-document"><i class="fas fa-eye"></i></a>
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-danger" onclick="confirmDelete(<?= $item->id ?>)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script src="{{ asset('dist/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('dist/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('custom/document/index.js') }}"></script>
