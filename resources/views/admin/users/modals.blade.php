

<!-- Modal Suspend -->
<div class="modal fade" id="suspendModal" tabindex="-1" aria-labelledby="suspendModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.users.suspend') }}">
      @csrf
      <input type="hidden" name="user_id" id="suspendUserId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Suspend Akun</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <label for="suspend_reason" class="form-label">Alasan Suspend</label>
          <textarea name="suspend_reason" class="form-control" required></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning">Suspend</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Unsuspend (tanpa alasan) -->
<div class="modal fade" id="unsuspendModal" tabindex="-1" aria-labelledby="unsuspendModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.users.unsuspend') }}">
      @csrf
      <input type="hidden" name="user_id" id="unsuspendUserId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Aktifkan Kembali Akun</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p>Yakin ingin mengaktifkan kembali akun ini?</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Aktifkan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.users.delete') }}">
      @csrf
      <input type="hidden" name="user_id" id="deleteUserId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Akun</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <label for="deleted_reason" class="form-label">Alasan Penghapusan</label>
          <textarea name="deleted_reason" class="form-control" required></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Hapus Akun</button>
        </div>
      </div>
    </form>
  </div>
</div>


<script>
    function showSuspendModal(id) {
        document.getElementById('suspendUserId').value = id;
        new bootstrap.Modal(document.getElementById('suspendModal')).show();
    }

    function showUnsuspendModal(id) {
        document.getElementById('unsuspendUserId').value = id;
        new bootstrap.Modal(document.getElementById('unsuspendModal')).show();
    }

    function showDeleteModal(id) {
        document.getElementById('deleteUserId').value = id;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
</script>


<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="" id="approveForm">
      @csrf
      <input type="hidden" name="user_id" id="approveUserId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Setujui Permintaan Upgrade</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yakin ingin menyetujui permintaan upgrade akun ini menjadi Akun Customer?</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Setujui</button>
        </div>
      </div>
    </form>
  </div>
</div>



<script>
function showApproveModal(userId) {
    document.getElementById('approveUserId').value = userId;
    document.getElementById('approveForm').action = '/admin/users/' + userId + '/approve';
    new bootstrap.Modal(document.getElementById('approveModal')).show();
}
</script>
