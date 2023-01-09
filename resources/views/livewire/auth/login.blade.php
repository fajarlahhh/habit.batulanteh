<div>
    <div class="login-content">
        <form wire:submit.prevent="submit" class="margin-bottom-0">
            <div class="form-group m-b-15">
                <input type="text" class="form-control form-control-lg" placeholder="UID" wire:model.defer="uid"
                    required />
            </div>
            <div class="form-group m-b-15">
                <input type="password" class="form-control form-control-lg" placeholder="Kata Sandi"
                    wire:model.defer="kataSandi" required />
            </div>
            <div class="checkbox checkbox-css m-b-30">
                <input type="checkbox" id="remember_me_checkbox" wire:model.defer="remember" />
                <label for="remember_me_checkbox">
                    Remember Me
                </label>
            </div>
            <div class="login-buttons">
                <button type="submit" class="btn btn-aqua btn-block btn-lg">Sign me in</button>
            </div>
            <div class="m-t-20 m-b-40 p-b-40 text-inverse">
                <x-info />
                <x-alert />
            </div>
            <hr />
            <p class="text-center text-grey-darker mb-0">
                &copy; Color Admin All Right Reserved 2020
            </p>
        </form>
    </div>
</div>
