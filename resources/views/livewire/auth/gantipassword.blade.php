<div>
  <div class="modal fade" id="modal-password" wire:ignore.self>
    <div class="modal-dialog">
      <form wire:submit.prevent="submit">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Ganti Kata Sandi</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="control-label">Kata Sandi Lama</label>
              <input class="form-control password" type="password" wire:model.defer="kataSandiLama" />
              @error('kataSandiLama')
                <small><span class="text-danger">{{ $message }}</span></small>
              @enderror
            </div>
            <div class="form-group">
              <label class="control-label">Kata Sandi Baru</label>
              <input class="form-control password" type="password" wire:model.defer="kataSandiBaru" />
              @error('kataSandiBaru')
                <small><span class="text-danger">{{ $message }}</span></small>
              @enderror
            </div>
            <x-notif.info />
          </div>
          <div class="modal-footer">
            <input type="submit" value="Simpan" class="btn text-white btn-success">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
